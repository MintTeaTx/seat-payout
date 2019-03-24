<?php

namespace Fordav3\Seat\Payout;

use Illuminate\Support\ServiceProvider;

class PayoutServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->add_routes();
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function add_routes()
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }

    public function register()
    {
        //
    $this->mergeConfigFrom(__DIR__ . '/Config/payout.sidebar.php','payout.sidebar');
    }
}
