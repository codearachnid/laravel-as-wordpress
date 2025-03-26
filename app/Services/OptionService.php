<?php

namespace App\Services;

use App\Models\Option;
use Illuminate\Support\Facades\Cache;

class OptionService
{
    /**
     * Get an option value, with caching.
     */
    public function get(string $optionName, $default = null)
    {
        $cacheKey = "wp_option_{$optionName}";
        $value = Cache::remember($cacheKey, 3600, function () use ($optionName) {
            $option = Option::where('option_name', $optionName)->first();
            return $option ? $option->option_value : null;
        });

        return $value !== null ? $value : $default;
    }

    /**
     * Update an existing option or create it if it doesn’t exist.
     */
    public function update(string $optionName, $value, string $autoload = 'yes'): bool
    {
        $option = Option::where('option_name', $optionName)->first();

        if ($option) {
            $option->option_value = $value;
            $option->autoload = $autoload;
            $result = $option->save();
        } else {
            $result = $this->add($optionName, $value, $autoload);
        }

        if ($result) {
            Cache::forget("wp_option_{$optionName}");
        }

        return $result;
    }

    /**
     * Add a new option.
     */
    public function add(string $optionName, $value, string $autoload = 'yes'): bool
    {
        if (Option::where('option_name', $optionName)->exists()) {
            return false;
        }

        $option = new Option();
        $option->option_name = $optionName;
        $option->option_value = $value;
        $option->autoload = $autoload;

        $result = $option->save();

        if ($result) {
            Cache::forget("wp_option_{$optionName}");
        }

        return $result;
    }

    /**
     * Delete an option.
     */
    public function delete(string $optionName): bool
    {
        $option = Option::where('option_name', $optionName)->first();

        if ($option) {
            $result = $option->delete();
            if ($result) {
                Cache::forget("wp_option_{$optionName}");
            }
            return $result;
        }

        return false;
    }

    /**
     * Get all autoloaded options (like WordPress’s wp_load_alloptions).
     */
    public function getAutoloaded(): array
    {
        return Cache::remember('wp_autoloaded_options', 3600, function () {
            return Option::where('autoload', 'yes')
                ->pluck('option_value', 'option_name')
                ->map(fn($value) => maybe_unserialize($value))
                ->all();
        });
    }

    public function getTransient(string $transientName)
    {
        $value = $this->get("_transient_{$transientName}");
        $timeout = $this->get("_transient_timeout_{$transientName}");

        if ($timeout && $timeout < time()) {
            $this->delete("_transient_{$transientName}");
            $this->delete("_transient_timeout_{$transientName}");
            return null;
        }

        return $value;
    }

    public function setTransient(string $transientName, $value, int $expiration): bool
    {
        $this->update("_transient_{$transientName}", $value, 'no');
        $this->update("_transient_timeout_{$transientName}", time() + $expiration, 'no');
        return true;
    }

    public function deleteTransient(string $transientName): bool
    {
        $this->delete("_transient_{$transientName}");
        $this->delete("_transient_timeout_{$transientName}");
        return true;
    }
}