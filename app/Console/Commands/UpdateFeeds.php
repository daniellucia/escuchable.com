<?php

namespace App\Console\Commands;

use App\Episodes;
use App\Resources\Read;
use App\Shows;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        $showsToUpdate = env('FEEDS_TO_UPDATE', 10);
        $shows = Shows::where('updated_at', '<', Carbon::now()->subHours(3)->toDateTimeString())->orWhereNull('updated_at')->limit($showsToUpdate)->get();

        if (!$shows) {
            $this->error('Nada que actualizar');
            return;
        }

        $bar = $this->output->createProgressBar(count($shows));
        $bar->start();

        $salida = [];

        foreach ($shows as $show) {
            $show->touch();
            $show->categories()->touch();

            $xml = null;
            try {
                $xml = Read::xml($show->feed);
            } catch (Exception $e) {
                continue;
            }

            if (is_object($xml)) {
                $show->updateByChannel($xml->channel);

                $lastEpisode = Episodes::whereShowsId($show->id)->orderBy('published', 'desc')->first();
                if ($lastEpisode) {
                    $show->last_episode = $lastEpisode->getOriginal('published');
                    $show->save();
                }

            }

            if (is_object($xml)) {
                Episodes::saveFromChannel($show, $xml->channel);
            }

            $salida[] = [
                'show' => $show->name,
                'feed' => $show->feed,
            ];

            $bar->advance();
        }

        $this->table(['Show', 'Feed'], $salida);
        $bar->finish();

    }
}
