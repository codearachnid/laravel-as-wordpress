<?php

namespace Database\Seeders;

use App\Models\UserMeta;
use Illuminate\Database\Seeder;

class UserMetaSeeder extends Seeder
{
    public function run()
    {
        $prefix = config('wordpress.table_prefix', 'wp_');

        UserMeta::create([
            'user_id' => 1,
            'meta_key' => "{$prefix}capabilities",
            'meta_value' => serialize(['administrator' => true]),
        ]);

        UserMeta::create([
            'user_id' => 1,
            'meta_key' => "{$prefix}user_level",
            'meta_value' => '10',
        ]);

        UserMeta::create([
            'user_id' => 1,
            'meta_key' => 'first_name',
            'meta_value' => 'Admin',
        ]);

        UserMeta::create([
            'user_id' => 1,
            'meta_key' => 'last_name',
            'meta_value' => 'User',
        ]);
    }
}
