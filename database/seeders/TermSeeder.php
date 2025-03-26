<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    public function run()
    {
        Term::create([
            'term_id' => 1,
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'term_group' => 0,
        ]);
    }
}
