<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Episodes extends Model
{
    protected $fillable = ['title', 'slug', 'mp3', 'description', 'published', 'show', 'link', 'mp3', 'length'];

    public static function boot() {
        parent::boot();

        /**
         * Al actualizar o crear, actualizamos
         * el slug con el nombre del modelo
         */
        self::saving(function($episode) {
            $episode->slug = Str::slug($episode->title);
        });
    }

    public static function saveFromChannel($show, $channel)
    {
        if (empty($channel)) {
            return;
        }

        foreach ($channel->item as $item) {
            self::saveEpisode($item, $show);
        }
    }

    public static function saveEpisode($item, $show) {
        $episode = self::where([
            'title' => Str::limit($item->title, 250),
            'show' => $show->id,
        ])->first();

        $episodeShow = [
            'title' => Str::limit($item->title, 250),
            'show' => $show->id,
            'description' => $item->description,
            'link' => $item->link,
            'published' => Carbon::createFromTimeString($item->pubDate)->toDateTimeString(),
            'length' => 0,
        ];

        if ($item->enclosure->attributes() !== null) {
            $episodeShow['mp3'] = $item->enclosure->attributes()['url'];
            $episodeShow['length'] = intval($item->enclosure->attributes()['length']);
        }

        if (!$episode) {
            self::create($episodeShow);
        }
    }
}
