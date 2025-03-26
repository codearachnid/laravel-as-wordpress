<?php
namespace App\Http\Controllers;

use App\Services\PostQueryService;

class PostController extends Controller
{
    public function index(PostQueryService $query)
    {
        $posts = $query->get([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 5,
            'paged' => 1,
            'meta_query' => [
                [
                    'key' => '_thumbnail_id',
                    'value' => '123',
                    'compare' => '=',
                ],
            ],
        ]);

        return view('posts.index', ['posts' => $posts]);
    }
}