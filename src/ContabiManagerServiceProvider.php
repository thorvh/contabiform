<?php

namespace Badore\ContabiManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class ContabiManagerServiceProvider extends ServiceProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ContabiManagerCommand::class,
                //ControllersCommand::class,
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Route::mixin(new ContabiManagerRouteMethods);
		
		
		
    }
}
