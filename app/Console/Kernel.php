<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\UpdateFeeds',
        'App\Console\Commands\FindDuplicates',
        'App\Console\Commands\AddUrlToCrawler',
        'App\Console\Commands\RereshCountShows',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        /**
         * Actualización de feeds
         */
        $schedule->command('update:feeds')->everyMinute();

        /**
         * Verificación de shows duplicados
         */
        $schedule->command('update:duplicates')->daily();

        /**
         * Regenerar sitemap
         */
        $schedule->command('update:sitemap')->daily();

        /**
         * Actualización del listado del crawler
         */
        $schedule->command('crawler:revise')->everyMinute();

        /**
         * Actualización de los totales en las categorias
         */
        $schedule->command('update:total')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
