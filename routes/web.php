<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * WordPressify routes
 */
Route::get('/posts', [PostController::class, 'index']);
Route::get('/comments', [App\Http\Controllers\CommentController::class, 'index']);
Route::get('/comments/tree', [App\Http\Controllers\CommentController::class, 'tree']);
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/dashboard', fn() => 'Welcome, ' . Auth::user()->display_name)->middleware('auth');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
Route::get('/options', [App\Http\Controllers\OptionController::class, 'index']);
Route::get('/admin', fn() => 'Admin Area')->middleware('can:manage-users');