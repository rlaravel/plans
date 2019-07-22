<?php

namespace RafaelMorenoJS\Plans\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PlansServiceProvider
 * @package RafaelMorenoJS\Plans\Providers
 */
class PlansServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/plans.php' => config_path('plans.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }
}
