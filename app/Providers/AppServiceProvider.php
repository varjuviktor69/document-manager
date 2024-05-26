<?php

namespace App\Providers;

use App\Interfaces\FileService;
use App\Services\FileServiceImpl;
use App\Interfaces\CategoryService;
use Illuminate\Support\Facades\Auth;
use App\Services\CategoryServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CategoryService::class, CategoryServiceImpl::class);
        $this->app->singleton(FileService::class, FileServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // For testing purposes
        Auth::loginUsingId(1);
    }
}
