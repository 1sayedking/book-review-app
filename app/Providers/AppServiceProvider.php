<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;// add to use bootstrap pagination

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrapFive();// add to use bootstrap pagination
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Set default string length for migrations
         Schema::defaultStringLength(191);
        
    }
}
