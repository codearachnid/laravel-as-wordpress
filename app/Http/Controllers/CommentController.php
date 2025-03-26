<?php

namespace App\Http\Controllers;

use App\Services\CommentQueryService;

class CommentController extends Controller
{
    public function index(CommentQueryService $query)
    {
        // Get approved comments for a specific post
        $comments = $query->get([
            'post_id' => 1, // Replace with a real post ID from wp_posts
            'status' => '1', // Approved comments
            'number' => 5,
            'paged' => 1,
        ]);

        return view('comments.index', ['comments' => $comments]);
    }
    
    public function tree(CommentQueryService $query)
    {
        $comments = $query->getTree([
            'post_id' => 1,
            'status' => '1',
            'number' => 5,
            'paged' => 1,
        ]);

        return view('comments.tree', ['comments' => $comments]);
    }
}