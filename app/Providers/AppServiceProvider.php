<?php

namespace App\Providers;

use App\Repositories\AirtableBusinessRepository;
use App\Repositories\BusinessRepositoryInterface;
use App\Services\BusinessService;
use App\Services\BusinessServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            BusinessServiceInterface::class,
            BusinessService::class
        );

        $this->app->bind(
            BusinessRepositoryInterface::class,
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
