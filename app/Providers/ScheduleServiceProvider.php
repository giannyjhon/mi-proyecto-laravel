<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\ScheduleServiceInterface;
use App\Services\ScheduleService;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ScheduleServiceInterface::class, ScheduleService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
