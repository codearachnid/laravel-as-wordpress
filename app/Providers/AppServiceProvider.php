<?php

namespace App\Providers;

use App\Services\CommentQueryService;
use App\Services\OptionService;
use App\Services\PostQueryService;
use App\Services\UserQueryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PostQueryService::class, function () {
            return new PostQueryService();
        });

        $this->app->singleton(CommentQueryService::class, function () {
            return new CommentQueryService();
        });

        $this->app->singleton(OptionService::class, function () {
            return new OptionService();
        });

        $this->app->singleton(UserQueryService::class, function () {
            return new UserQueryService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
