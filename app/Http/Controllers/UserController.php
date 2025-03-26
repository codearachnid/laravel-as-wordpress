<?php

namespace App\Http\Controllers;

use App\Services\UserQueryService;

class UserController extends Controller
{
    public function index(UserQueryService $query)
    {
        // Example: Get users with 'administrator' OR 'editor' roles
        $users = $query->get([
            'role' => [
                'roles' => ['administrator', 'editor'],
                'relation' => 'OR',
            ],
            'number' => 5,
            'paged' => 1,
        ]);

        return view('users.index', ['users' => $users]);
    }
}