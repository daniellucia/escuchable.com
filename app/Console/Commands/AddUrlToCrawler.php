<?php

namespace App\Console\Commands;

use App\Crawler;
use App\Resources\Utils;
use Illuminate\Console\Command;

class AddUrlToCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:add {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Añade una nueva url a la tabla';

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
        $url = Crawler::normalizeUrl($this->argument('url'));
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->error('La URL no es válida!');

            return;
        }

        $crawler = Crawler::whereUrl($url)->first();
        if (!$crawler) {

            Crawler::add($url);
            $this->info(sprintf('La url (%s) se ha añadido correctamente.', $url));

            return;
        } else {
            $this->error('La URL ya existe en la lista');

            return;
        }

    }
}
