<?php

namespace App\Console\Commands;

use App\Crawler;
use App\Resources\Feed;
use App\Resources\Utils;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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
        $elements = Crawler::whereNull('date_revised')->limit(6)->get();
        $bar = $this->output->createProgressBar(count($elements));

        $bar->start();
        foreach ($elements as $element) {
            if (!$element) {
                $this->error('No hay ninguna url que revisar');

                return;
            }

            //$this->info($element->url);

            $client = new Client();
            $crawler = $client->request('GET', $element->url);
            $crawler->filter('a')->each(function ($node) use ($element) {
                $url = $node->attr('href');

                if (strlen($url) < 2) {
                    return;
                }

                if (Crawler::getDomain($url) != $element->domain) {
                    return;
                }

                Artisan::call('crawler:add', [
                    'url' => $url,
                ]);
            });

            if ($crawler->filterXpath('//link[@type="application/rss+xml"]')->count() > 0) {
                $feed = $crawler->filterXpath('//link[@type="application/rss+xml"]')->attr('href');
                //$this->info(sprintf('Se ha encontrado %s', $feed));
                Feed::insert($feed);
            }

            if ($crawler->filterXpath('//a[@id="show_episodes_feed"]')->count() > 0) {
                $feed = $crawler->filterXpath('//a[@id="show_episodes_feed"]')->attr('href');
                //$this->info(sprintf('Se ha encontrado %s', $feed));
                Feed::insert($feed);
            }

            $element->date_revised = now();
            $element->save();

            $bar->advance();
        }

        $bar->finish();
    }
}
