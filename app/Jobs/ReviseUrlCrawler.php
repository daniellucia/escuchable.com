<?php

namespace App\Jobs;

use App\Crawler;
use App\Resources\Feed;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ReviseUrlCrawler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $element;
    public $tries = 2;
    public $timeout = 10;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $element)
    {
        //Log::debug($element);
        $this->element = Crawler::whereUrl($element)->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $element = $this->element;

        if ($element) {
            $element->date_revised = now();
            $element->save();

            //Log::debug(sprintf('Se ha guardado: (%s)', $element->url));

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
                //Log::debug(sprintf('Se ha encontrado: (%s)', $url));

                Artisan::call('crawler:add', [
                    'url' => $url,
                ]);
            });

            if ($crawler->filterXpath('//link[@type="application/rss+xml"]')->count() > 0) {
                $feed = $crawler->filterXpath('//link[@type="application/rss+xml"]')->attr('href');
                //Log::debug($feed);
                Feed::insert($feed);
            }

            if ($crawler->filterXpath('//a[@id="show_episodes_feed"]')->count() > 0) {
                $feed = $crawler->filterXpath('//a[@id="show_episodes_feed"]')->attr('href');
                //Log::debug($feed);
                Feed::insert($feed);
            }
        } else {
            //Log::error(sprintf('Error al recuperar (%s)', $url));
        }

    }
}
