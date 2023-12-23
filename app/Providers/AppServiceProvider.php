<?php

namespace App\Providers;

use App\Services\Contracts\TagService;
use App\Services\Contracts\TodoService;
use App\Services\TagServiceImpl;
use App\Services\TodoServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TagService::class, TagServiceImpl::class);
        $this->app->bind(TodoService::class, TodoServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
