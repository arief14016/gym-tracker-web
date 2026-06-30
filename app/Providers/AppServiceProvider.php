<?php

namespace App\Providers;

use App\Models\WorkoutSetLog;
use App\Observers\WorkoutSetLogObserver;
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
        WorkoutSetLog::observe(WorkoutSetLogObserver::class);
    }
}
