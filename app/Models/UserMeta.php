<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMeta extends Model
{
    protected $table = 'usermeta';
    protected $primaryKey = 'umeta_id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'meta_key',
        'meta_value',
    ];

    public function getTable()
    {
        return config('wordpress.table_prefix', 'wp_') . $this->table;
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'ID');
    }
}