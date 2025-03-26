<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';
    protected $primaryKey = 'option_id';
    public $timestamps = false; // No Laravel timestamps
    public $incrementing = true;

    protected $fillable = [
        'option_name',
        'option_value',
        'autoload',
    ];

    public function getTable()
    {
        return config('wordpress.table_prefix', 'wp_') . $this->table;
    }

    /**
     * Get the unserialized option value.
     */
    public function getOptionValueAttribute($value)
    {
        return maybe_unserialize($value); // Handle WordPress serialized data
    }

    /**
     * Set the option value, serializing if necessary.
     */
    public function setOptionValueAttribute($value)
    {
        $this->attributes['option_value'] = is_scalar($value) ? $value : serialize($value);
    }
}
