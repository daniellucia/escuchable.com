<?php

namespace App\Http\Controllers;

use App\Episodes;
use App\Shows;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UpdateController extends Controller
{
    public function index()
    {
        /**
         * Obtenemos el siguiente show
         * para obtener el feed de episodios
         */
        $show = Shows::whereDate('updated_at', '<', Carbon::today()->toDateString())->orWhereNull('updated_at')->first();
        if (!$show) {
            return [];
        }

        /**
         * Leemos feed
         */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $show->feed);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        $data = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($data);

        /**
         * Actualizamos el título
         * del show
         */
        $show->name = $xml->channel->title;
        $show->web = $xml->channel->link;
        $show->language = substr($xml->channel->language, 0, 2);
        $show->description = $xml->channel->description;
        $show->save();

        /**
         * Marcamos el show como
         * revisado
         */
        foreach ($xml->channel->item as $item) {
            $episode = Episodes::where([
                'title' => $item->title,
                'show' => $show->id,
            ])->first();

            $epidoseShow = [
                'title' => $item->title,
                'slug' => Str::slug($item->title),
                'show' > $show->id,
                'description' => $item->description,
                'link' => $item->link,
                'published' => Carbon::createFromTimeString($item->pubDate)->toDateTimeString(),
                'mp3' => $item->enclosure->attributes()['url'],
                'length' => $item->enclosure->attributes()['length'],
            ];

            if (!$episode) {
                Episodes::create($epidoseShow);
            }
        }

        return ['ok' => $show->name];
    }
}
