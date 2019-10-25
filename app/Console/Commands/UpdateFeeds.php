<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:feeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los episodios del próximo feed';

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
        app('App\Http\Controllers\UpdateController')->index();
    }
}
