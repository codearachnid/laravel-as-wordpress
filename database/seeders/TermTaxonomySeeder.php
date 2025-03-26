<?php

namespace Database\Seeders;

use App\Models\TermTaxonomy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermTaxonomySeeder extends Seeder
{
    public function run()
    {
        TermTaxonomy::create([
            'term_taxonomy_id' => 1,
            'term_id' => 1,
            'taxonomy' => 'category',
            'description' => '',
            'parent' => 0,
            'count' => 1,
        ]);

        DB::table(config('wordpress.migrate.table.term_relationships', 'wp_term_relationships') )->insert([
            'object_id' => 1, // Post ID
            'term_taxonomy_id' => 1,
            'term_order' => 0,
        ]);
    }
}
