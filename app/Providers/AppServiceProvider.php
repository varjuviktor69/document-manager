<?php

namespace App\Providers;

use App\Interfaces\CategoryService;
use App\Interfaces\FileService;
use App\Services\CategoryServiceImpl;
use App\Services\FileServiceImpl;
use Illuminate\Support\Facades\Auth;
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
        // For testing purposes: uncomment after all the migrations ran
        // Auth::loginUsingId(1);
    }
}
