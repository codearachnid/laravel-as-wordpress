<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    protected $table = 'terms';
    protected $primaryKey = 'term_id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'name',
        'slug',
        'term_group',
    ];

    public function getTable()
    {
        return config('wordpress.migrate.table.terms', 'wp_terms');
    }

    /**
     * Relationship to TermTaxonomy model.
     */
    public function taxonomies() : HasMany
    {
        return $this->hasMany(TermTaxonomy::class, 'term_id', 'term_id');
    }
}