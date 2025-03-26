<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::create([
            'ID' => 1,
            'post_author' => 1,
            'post_date' => now()->toDateTimeString(),
            'post_content' => "Welcome to WordPress. This is your first post. Edit or delete it, then start writing!",
            'post_title' => "Hello world!",
            'post_excerpt' => '',
            'post_status' => 'publish',
            'comment_status' => 'open',
            'ping_status' => 'open',
            'post_name' => 'hello-world',
            'post_modified' => now()->toDateTimeString(),
            'post_type' => 'post',
            'comment_count' => 1,
        ]);

        Post::create([
            'ID' => 2,
            'post_author' => 1,
            'post_date' => now()->toDateTimeString(),
            'post_content' => "This is an example page. It’s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:\n\nHi there! I’m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like piña coladas. (And gettin’ caught in the rain.)\n\n…or something like this:\n\nThe XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.\n\nAs a new WordPress user, you should go to your dashboard to delete this page and create new pages for your content. Have fun!",
            'post_title' => "Sample Page",
            'post_excerpt' => '',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_name' => 'sample-page',
            'post_modified' => now()->toDateTimeString(),
            'post_type' => 'page',
            'comment_count' => 0,
        ]);
    }
}