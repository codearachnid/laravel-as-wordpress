<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run()
    {
        $options = [
            ['option_name' => 'blogname', 'option_value' => 'WordPress Reborn', 'autoload' => 'yes'],
            ['option_name' => 'blogdescription', 'option_value' => 'Just another WordPress site', 'autoload' => 'yes'],
            ['option_name' => 'siteurl', 'option_value' => config('wordpress.constants.wp_siteurl'), 'autoload' => 'yes'],
            ['option_name' => 'home', 'option_value' => config('wordpress.constants.wp_home'), 'autoload' => 'yes'],
            ['option_name' => 'users_can_register', 'option_value' => '0', 'autoload' => 'yes'],
            ['option_name' => 'admin_email', 'option_value' => 'admin@example.com', 'autoload' => 'yes'],
            ['option_name' => 'default_comment_status', 'option_value' => 'open', 'autoload' => 'yes'],
            ['option_name' => 'default_ping_status', 'option_value' => 'open', 'autoload' => 'yes'],
            ['option_name' => 'default_category', 'option_value' => '1', 'autoload' => 'yes'],
            ['option_name' => 'posts_per_page', 'option_value' => '10', 'autoload' => 'yes'],
            ['option_name' => 'date_format', 'option_value' => 'F j, Y', 'autoload' => 'yes'],
            ['option_name' => 'time_format', 'option_value' => 'g:i a', 'autoload' => 'yes'],
            ['option_name' => 'start_of_week', 'option_value' => '1', 'autoload' => 'yes'],
            ['option_name' => 'timezone_string', 'option_value' => 'UTC', 'autoload' => 'yes'],
            ['option_name' => 'permalink_structure', 'option_value' => '', 'autoload' => 'yes'],
            ['option_name' => 'current_theme', 'option_value' => 'twentytwentythree', 'autoload' => 'yes'],
            ['option_name' => 'active_plugins', 'option_value' => serialize([]), 'autoload' => 'yes'],
        ];

        foreach ($options as $option) {
            Option::create($option);
        }
    }
}
