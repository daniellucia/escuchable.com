<?php

namespace App\Console\Commands;

use App\Shows;
use Illuminate\Console\Command;
use ImageOptimizer;


class OptimizeImagesShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimiza las imágenes de los shows';

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
        $elements = Shows::whereImageOptimized(0)->get();
        $bar = $this->output->createProgressBar(count($elements));
        $bar->start();
        foreach ($elements as $element) {
            ImageOptimizer::optimize(public_path($element->image));
            $element->image_optimized = 1;
            $element->save();
            $bar->advance();
        }

        $bar->finish();

    }
}
