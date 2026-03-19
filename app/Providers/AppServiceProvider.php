<?php

namespace App\Providers;

use App\Services\AcademyService;
use App\Services\AcademyWriteService;
use App\Services\AuthService;
use App\Services\MediaService;
use App\Support\LegacyDb;
use App\Support\PageRenderer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LegacyDb::class);
        $this->app->singleton(PageRenderer::class);
        $this->app->singleton(AuthService::class);
        $this->app->singleton(AcademyService::class);
        $this->app->singleton(AcademyWriteService::class);
        $this->app->singleton(MediaService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        date_default_timezone_set((string) config('app.timezone', 'Europe/Moscow'));
    }
}
