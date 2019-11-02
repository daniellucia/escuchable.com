<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Episodes;
use App\Resources\Channel;
use App\Resources\Read;
use App\Shows;
use Carbon\Carbon;

class UpdateController extends Controller
{
    public function index()
    {
        /**
         * Obtenemos el siguiente show
         * para obtener el feed de episodios
         */

        $shows = Shows::whereDate('updated_at', '<', Carbon::now()->subHours(3)->toDateTimeString())->orWhereNull('updated_at')->limit(30)->get();
        if (!$shows) {
            return 'Nada que actualizar';
        }

        $salida = [];

        foreach ($shows as $show) {
            /**
             * Actualziamos la fecha
             * de actualziación
             */

            $show->touch();

            /**
             * Leemos feed
             */
            $xml = null;
            try {
                $xml = Read::xml($show->feed);
            } catch (Exception $e) {
                continue;
            }

            /**
             * Actualizamos el título
             * del show
             */
            if (is_object($xml)) {
                $show->updateByChannel($xml->channel);
                if (!$show->getMeta('Visitas')) {
                    $show->addMeta('Visitas', 0);
                }

                /**
                 * Obtenemos elepisodio más nuevo
                 */
                $lastEpisode = Episodes::orderBy('published', 'desc')->first();
                $show->last_episode = $lastEpisode->published;
                $show->save();

            }

            /**
             * Guardamos los episodios
             * correspondientes
             */
            if (is_object($xml)) {
                Episodes::saveFromChannel($show, $xml->channel);
            }

            $salida[] = $show->name;
        }

        return $salida;
    }

    public function opml()
    {
        /**
         * Obtenemos el archivo opml local
         * para actualizarlo.
         * Este método puede ser usado para
         * que los usuarios puedan subir
         * sus propios opml
         */
        $showsImported = Shows::saveFromOPML(
            \File::get(storage_path('opml/Podcasts.opml'))
        );

        return $showsImported;
    }

    /**
     * Método para encontrar duplicados
     *
     * @return array
     */
    public function findDuplicates()
    {
        $shows = Shows::all();
        $showsUnique = $shows->unique('name');
        $results = $shows->diff($showsUnique);
        foreach ($results as $show) {
            Episodes::whereShow($show->id)->delete();
            $show->delete();
            echo $show->id . "\n";
        }
        return false;
    }

    public function fromTxt()
    {
        $feeds = file(storage_path('opml/feeds.txt'));
        foreach ($feeds as $feed) {
            $feed = trim($feed);
            dump($feed);

            $show = Shows::where('feed', $feed)->first();

            if (!$show) {
                $xml = null;
                try {
                    $xml = Read::xml($feed);
                } catch (Exception $e) {
                    continue;
                }

                if (is_object($xml)) {
                    $channel = new Channel($xml->channel);
                    $data = $channel->toArray();
                    //dump($data);
                    $data['categories_id'] = intval($data['categories_id']);
                    dump('Insertado');

                    $data['feed'] = $feed;
                    $show = Shows::create($data);
                }

            }
        }
    }
    public function tags()
    {
        $categories = Categories::all();
        foreach ($categories as $category) {

            $shows = Shows::where('categories_id', $category->id)->orderBy('updated_at', 'desc')->get();
            foreach ($shows as $show) {
                $keywords = Read::tags($show->name);
                if (!empty($keywords)) {
                    foreach ($keywords as $keyword) {
                        if ($keyword != '') {
                            $show->attachTag(strval($keyword));
                        }

                    }
                }

                $episodes = Episodes::whereShow($show->id)->get();
                foreach ($episodes as $episode) {
                    $keywords = Read::tags($episode->title);
                    if (!empty($keywords)) {
                        foreach ($keywords as $keyword) {
                            if ($keyword != '') {
                                $show->attachTag(strval($keyword));
                            }

                        }
                    }
                }
            }
        }
    }
}
