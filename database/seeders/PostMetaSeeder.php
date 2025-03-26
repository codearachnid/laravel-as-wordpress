<?php

namespace Database\Seeders;

use App\Models\PostMeta;
use Illuminate\Database\Seeder;

class PostMetaSeeder extends Seeder
{
    public function run()
    {

        PostMeta::create([
            'post_id' => 1,
            'meta_key' => '_edit_last',
            'meta_value' => '1', // Admin user
        ]);

        PostMeta::create([
            'post_id' => 1,
            'meta_key' => '_edit_lock',
            'meta_value' => now()->timestamp . ':1',
        ]);

        PostMeta::create([
            'post_id' => 2,
            'meta_key' => '_edit_last',
            'meta_value' => '1',
        ]);

        PostMeta::create([
            'post_id' => 2,
            'meta_key' => '_edit_lock',
            'meta_value' => now()->timestamp . ':1',
        ]);
    }
}