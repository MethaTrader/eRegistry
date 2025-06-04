<?php

namespace App\Providers;

use App\Services\DashboardService;
use App\Services\DoctorService;
use App\Services\MonitoringService;
use App\Services\PatientService;
use App\Services\StatisticsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Регистрируем сервисы как синглтоны для оптимизации производительности
        $this->app->singleton(StatisticsService::class);
        $this->app->singleton(DashboardService::class);
        $this->app->singleton(PatientService::class);
        $this->app->singleton(MonitoringService::class);
        $this->app->singleton(DoctorService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
