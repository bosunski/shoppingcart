<?php

namespace Drumzminister\ShoppingCart;

use Illuminate\Support\ServiceProvider;
use Drumzminister\ShoppingCart\Services\Session;
use Drumzminister\ShoppingCart\Services\Database;
use Drumzminister\ShoppingCart\Services\ShoppingCart;

class ShoppingCartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->getStorageService() == 'session')
        {
            $this->app->singleton('shoppingcart', function($app) {
                return new Session();
            });
        } else {
            $this->app->singleton('shoppingcart', function($app) {
                return new Database();
            });
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/shoppingcart.php' =>  config_path('shoppingcart.php'),
        ], 'config');
    }

    /**
     *  Get the storage settings based on config file
     *
     * @return string
     */
    public function getStorageService()
    {
        $class = $this->app['config']->get('shoppingcart.storage','session');

        switch ($class)
        {
            case 'session':
                return 'session';
            break;
            case 'database':
                return 'database';
            break;
            default:
                return 'session';
            break;
    }
}
}
