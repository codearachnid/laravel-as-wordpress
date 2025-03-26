<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UserMetaSeeder::class,
            PostSeeder::class,
            PostMetaSeeder::class,
            TermSeeder::class,
            TermTaxonomySeeder::class,
            CommentSeeder::class,
            OptionSeeder::class,
        ]);
    }
}
