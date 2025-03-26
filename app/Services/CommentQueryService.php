<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;

class CommentQueryService
{
    protected $query;
    protected $defaults = [
        'post_id' => 0, // Filter by post
        'status' => '1', // Approved comments by default
        'type' => '', // Empty for regular comments
        'number' => 10,
        'paged' => 1,
    ];

    public function __construct()
    {
        $this->query = Comment::query();
    }

    /**
     * Fetch comments with WordPress-style arguments.
     */
    public function get(array $args = [])
    {
        $params = array_merge($this->defaults, $args);

        $this->applyPostId($params['post_id'])
             ->applyStatus($params['status'])
             ->applyType($params['type'])
             ->applyPagination($params['number'], $params['paged']);

        return $this->query->paginate($params['number']);
    }

    public function getTree(array $args = [])
    {
        $params = array_merge($this->defaults, $args);

        $this->applyPostId($params['post_id'])
            ->applyStatus($params['status'])
            ->applyType($params['type']);

        // Get top-level comments
        $topLevel = $this->query->where('comment_parent', 0)
                                ->paginate($params['number']);

        // Eager load children
        $topLevel->load('children');

        return $topLevel;
    }

    /**
     * Filter by post ID.
     */
    protected function applyPostId(int $postId): self
    {
        if ($postId > 0) {
            $this->query->where('comment_post_ID', $postId);
        }
        return $this;
    }

    /**
     * Filter by comment status (approved, pending, spam).
     */
    protected function applyStatus(string|array $status): self
    {
        if (is_array($status)) {
            $this->query->whereIn('comment_approved', $status);
        } elseif ($status !== '') {
            $this->query->where('comment_approved', $status);
        }
        return $this;
    }

    /**
     * Filter by comment type (comment, pingback, trackback).
     */
    protected function applyType(string|array $type): self
    {
        if (is_array($type)) {
            $this->query->whereIn('comment_type', $type);
        } elseif ($type !== '') {
            $this->query->where('comment_type', $type);
        }
        return $this;
    }

    /**
     * Apply pagination.
     */
    protected function applyPagination(int $perPage, int $page): self
    {
        $this->query->forPage($page, $perPage);
        return $this;
    }

    /**
     * Get the raw query builder.
     */
    public function query(): Builder
    {
        return $this->query;
    }
}