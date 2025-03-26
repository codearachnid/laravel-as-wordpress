<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::create([
            'comment_ID' => 1,
            'comment_post_ID' => 1,
            'comment_author' => 'Mr WordPress',
            'comment_author_email' => 'wordpress@example.com',
            'comment_author_url' => 'https://wordpress.org/',
            'comment_author_IP' => '127.0.0.1',
            'comment_date' => now()->toDateTimeString(),
            'comment_content' => 'Hi, this is a comment. To get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard. The avatar that displays next to comments comes from <a href="https://gravatar.com">Gravatar</a>.',
            'comment_approved' => '1',
            'comment_agent' => '',
            'comment_type' => 'comment',
            'comment_parent' => 0,
            'user_id' => 0,
        ]);
    }
}
