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
        $this->add_views();
	$this->add_publishes();
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function add_publishes()
    {
    $this->publishes([
        __DIR__.'/database/migrations/' => database_path('migrations')
	   ]);
    }

    public function add_routes()
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }
    public function add_views()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'payout');
    }


    public function register()
    {
        //
    $this->mergeConfigFrom(__DIR__ . '/Config/payout.sidebar.php','package.sidebar');
        $this->mergeConfigFrom(__DIR__ . '/Config/payout.permissions.php','web.permissions');
    }
}
