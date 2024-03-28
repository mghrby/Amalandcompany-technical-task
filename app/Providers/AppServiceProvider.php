<?php

namespace App\Providers;

use App\Repositories\AirtableBusinessRepository;
use App\Repositories\IBusinessRepositoryInterface;
use App\Services\BusinessService;
use App\Services\IBusinessServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            IBusinessServiceInterface::class,
            BusinessService::class
        );

        $this->app->bind(
            IBusinessRepositoryInterface::class,
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
