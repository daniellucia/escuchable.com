<?php

namespace App\Providers;

use App\Categories;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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
        if (Schema::hasTable('categories')) {
            View::share('categories', Categories::orderBy('name')->get());
        }

        Eventy::addFilter('meta.title', function($title) {
            return $title .' • escuchable.com';
        }, 20, 1);

    }
}
