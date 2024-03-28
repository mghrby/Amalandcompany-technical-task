<?php

namespace App\Providers;

use App\Repositories\AirtableBusinessRepository;
use App\Repositories\IBusinessRepository;
use App\Services\BusinessService;
use App\Services\IBusinessService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            IBusinessService::class,
            BusinessService::class
        );

        $this->app->bind(
            IBusinessRepository::class,
            AirtableBusinessRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
