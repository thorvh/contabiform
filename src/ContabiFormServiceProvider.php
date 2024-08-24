<?php

namespace Badore\ContabiForm;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class ContabiFormServiceProvider extends ServiceProvider
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
                ContabiFormCommand::class,
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
        //
    }
}
