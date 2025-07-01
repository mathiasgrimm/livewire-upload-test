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
        if (config('filesystems.laravel_cloud_disk_config')) {
            $_SERVER['LARAVEL_CLOUD_DISK_CONFIG'] = config('filesystems.laravel_cloud_disk_config');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
