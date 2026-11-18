<?php

namespace App\Providers;

use App\Support\HostingerPublicSync;
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
        // Shared hosting: keep public_html/build (+ storage) aligned with cigno/public.
        if (! $this->app->runningInConsole() && public_path() !== base_path('public')) {
            HostingerPublicSync::syncBuildIfNeeded();
            HostingerPublicSync::ensureStorageLink();
        }
    }
}
