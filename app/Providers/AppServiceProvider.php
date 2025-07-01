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
         config(['filesystems.disks.mathias-register' => ['driver' => 's3']]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['filesystems.disks.mathias-boot' => ['driver' => 's3']]);
    }
}
