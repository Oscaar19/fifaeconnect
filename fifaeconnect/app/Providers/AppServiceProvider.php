<?php

namespace App\Providers;

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
        $this->app->bind(
            // package controller
            \Backpack\PermissionManager\app\Http\Controllers\UserCrudController::class,
            // your controller
            \App\Http\Controllers\Admin\UserCrudController::class
        );
    }
}
