<?php

namespace App\Console\Commands;

use App\Categories;
use Illuminate\Console\Command;

class RereshCountShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:total';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresca el total de shows por categorias';

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
        $categories = Categories::get();
        foreach($categories as $item) {
            $total = $item->shows()->count();
            $item->shows_count = intval($total);
            $item->save();
        }
    }
}
