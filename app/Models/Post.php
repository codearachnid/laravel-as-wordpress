<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'post_title',
        'post_content',
        'post_excerpt',
        'post_status',
        'post_type',
        'post_name',
        'post_date',
        'post_author',
    ];
    
    public function getTable()
    {
        return config('wordpress.table_prefix', 'wp_') . $this->table;
    }

    /**
     * Relationship to PostMeta model.
     */
    public function meta() : HasMany
    {
        return $this->hasMany(PostMeta::class, 'post_id', 'ID');
    }

    /**
     * Relationship to TermTaxonomy via TermRelationships.
     */
    public function taxonomies() : BelongsToMany
    {
        return $this->belongsToMany(
            TermTaxonomy::class,
            config('wordpress.table.term_relationships', 'wp_term_relationships'),
            'object_id',
            'term_taxonomy_id',
            'ID',
            'term_taxonomy_id'
        );
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'comment_post_ID', 'ID');
    }

    /**
     * Scope to filter by post type.
     * TODO test this with ofType method name for laravel 12
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('post_type', $type);
    }

}