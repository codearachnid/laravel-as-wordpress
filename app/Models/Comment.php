<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'comment_ID';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'comment_post_ID',
        'comment_author',
        'comment_author_email',
        'comment_author_url',
        'comment_author_IP',
        'comment_date',
        'comment_content',
        'comment_approved',
        'comment_agent',
        'comment_type',
        'comment_parent',
        'user_id',
    ];

    public function getTable()
    {
        return config('wordpress.table_prefix', 'wp_') . $this->table;
    }

    /**
     * Relationship to Post.
     */
    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'comment_post_ID', 'ID');
    }

    /**
     * Relationship to User (optional, nullable).
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'ID');
    }

    /**
     * Relationship to parent comment (self-referential).
     */
    public function parent() : BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_parent', 'comment_ID');
    }

    /**
     * Relationship to child comments.
     */
    public function children() : HasMany
    {
        return $this->hasMany(Comment::class, 'comment_parent', 'comment_ID');
    }
}