<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TorMorten\Eventy\Facades\Events as Eventy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Cambiamos el path public
         */
        $this->app->bind('path.public', function () {
            return base_path('public_html');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Eventy::addFilter('meta.title', function ($title) {
            return $title . ' • escuchable.com';
        }, 20, 1);

    }
}
