<?php

namespace App\Providers;

use App\Util\Helpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        App::bind('helpers', function () {
            return new Helpers();
        });
    }
}
