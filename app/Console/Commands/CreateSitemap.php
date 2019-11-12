<?php

namespace App\Console\Commands;

use App\Categories;
use App\Episodes;
use App\Shows;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class CreateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recrea el sitemap de la web';

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

        $sitemap = App::make("sitemap");

        $categories = Categories::all();
        foreach ($categories as $category) {
            $sitemap->add(route('category.view', $category), $category->updated_at, 0.8, 'daily');
            $shows = Shows::where('categories_id', $category->id)->orderBy('updated_at', 'desc')->get();
            foreach ($shows as $show) {
                $sitemap->add(route('show.view', $show), $show->updated_at, 0.9, 'daily');

                $episodes = Episodes::whereShowsId($show->id)->get();
                foreach ($episodes as $episode) {
                    $sitemap->add(route('episode.view', [$show, $episode]), $episode->updated_at, 0.6, 'yearly');
                }
            }
        }

        $sitemap->store('xml', 'sitemap');

    }
}
