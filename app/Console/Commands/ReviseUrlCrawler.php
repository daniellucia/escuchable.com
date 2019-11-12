<?php

namespace App\Console\Commands;

use App\Crawler;
use App\Resources\Read;
use Illuminate\Console\Command;

class ReviseUrlCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:revise';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa la siguiente URL en la lista';

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
        $elements = Crawler::whereNull('date_revised')->limit(2)->get();
        $bar = $this->output->createProgressBar(count($elements));

        $bar->start();
        foreach ($elements as $element) {
            Read::links($element);

            $bar->advance();
        }

        $bar->finish();
    }
}
