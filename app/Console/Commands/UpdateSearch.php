<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza todos los terminos de búsqueda';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('App\Http\Controllers\SearchController')->update();
    }
}
