<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'ID' => 1,
            'user_login' => 'admin',
            'user_pass' => md5('admin'),
            'user_nicename' => 'admin',
            'user_email' => 'admin@example.com',
            'user_url' => '',
            'user_registered' => now()->toDateTimeString(),
            'user_activation_key' => '',
            'user_status' => 0,
            'display_name' => 'admin',
            // 'password' => null, // Leave Laravel password empty initially
        ]);
    }
}
