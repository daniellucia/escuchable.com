<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportTxt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:txt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa feeds de un TXT';

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
        app('App\Http\Controllers\UpdateController')->fromTxt();
    }
}
