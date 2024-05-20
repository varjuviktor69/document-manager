<?php

namespace App\Providers;

use App\Interfaces\CategoryService;
use App\Services\CategoryServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(CategoryService::class, CategoryServiceImpl::class);
    }
}
