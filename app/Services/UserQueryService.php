<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserQueryService
{
    protected $query;
    protected $defaults = [
        'role' => '',
        'number' => 10,
        'paged' => 1,
    ];

    public function __construct()
    {
        $this->query = User::query();
    }

    public function get(array $args = [])
    {
        $params = array_merge($this->defaults, $args);

        $this->applyRole($params['role'])
             ->applyPagination($params['number'], $params['paged']);

        return $this->query->paginate($params['number']);
    }

    /**
     * Filter by role (stored in wp_usermeta as 'wp_capabilities').
     */
    protected function applyRole(string|array $role): self
    {
        if (!$role) {
            return $this;
        }

        $prefix = config('wordpress.table_prefix', 'wp_');

        if (is_string($role)) {
            // Single role
            $this->query->whereHas('meta', function (Builder $q) use ($prefix, $role) {
                $q->where('meta_key', "{$prefix}capabilities")
                  ->where('meta_value', 'like', "%\"$role\"%");
            });
        } elseif (is_array($role)) {
            // Multiple roles with optional relation
            $relation = $role['relation'] ?? 'OR';
            $roles = isset($role['roles']) ? $role['roles'] : $role;

            $this->query->where(function ($query) use ($prefix, $roles, $relation) {
                foreach ((array) $roles as $r) {
                    $method = $relation === 'AND' ? 'whereHas' : 'orWhereHas';
                    $query->$method('meta', function (Builder $q) use ($prefix, $r) {
                        $q->where('meta_key', "{$prefix}capabilities")
                          ->where('meta_value', 'like', "%\"$r\"%");
                    });
                }
            });
        }

        return $this;
    }

    protected function applyPagination(int $perPage, int $page): self
    {
        $this->query->forPage($page, $perPage);
        return $this;
    }

    public function query(): Builder
    {
        return $this->query;
    }
}