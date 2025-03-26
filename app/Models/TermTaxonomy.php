<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TermTaxonomy extends Model
{
    protected $table = 'term_taxonomy';
    protected $primaryKey = 'term_taxonomy_id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'term_id',
        'taxonomy',
        'description',
        'parent',
        'count',
    ];

    public function getTable()
    {
        return config('wordpress.migrate.table.term_taxonomy', 'wp_term_taxonomy');
    }

    /**
     * Relationship to Term.
     */
    public function term() : BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id', 'term_id');
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(self::class, 'parent', 'term_taxonomy_id');
    }

    /**
     * Relationship to Posts via TermRelationships.
     */
    public function posts() : BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            config('wordpress.migrate.table.term_relationships', 'wp_term_relationships'),
            'term_taxonomy_id',
            'object_id',
            'term_taxonomy_id',
            'ID'
        );
    }
}