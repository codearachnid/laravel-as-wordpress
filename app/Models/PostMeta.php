<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMeta extends Model
{
    protected $table = 'postmeta';
    protected $primaryKey = 'meta_id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'post_id',
        'meta_key',
        'meta_value',
    ];

    public function getTable()
    {
        return config('wordpress.migrate.table.postmeta', 'wp_postmeta');
    }

    public function getMetaValueAttribute($value)
    {
        return maybe_unserialize($value);
    }

    /**
     * Relationship to the Post model.
     */
    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'ID');
    }
}