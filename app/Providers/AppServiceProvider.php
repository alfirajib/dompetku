<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Paksa HTTPS di production supaya link/asset/form tidak mixed-content
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
