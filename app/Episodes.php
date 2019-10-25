<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Episodes extends Model
{
    protected $fillable = ['title', 'slug', 'mp3', 'description', 'published', 'show', 'link', 'mp3', 'length'];

    public static function saveFromChannel($show, $channel)
    {
        if (empty($channel)) {
            return;
        }

        foreach ($channel->item as $item) {
            $episode = self::where([
                'title' => $item->title,
                'show' => $show->id,
            ])->first();

            $episodeShow = [
                'title' => $item->title,
                'slug' => Str::slug($item->title),
                'show' => $show->id,
                'description' => $item->description,
                'link' => $item->link,
                'published' => Carbon::createFromTimeString($item->pubDate)->toDateTimeString(),
                'mp3' => $item->enclosure->attributes()['url'],
                'length' => $item->enclosure->attributes()['length'],
            ];

            if (!$episode) {
                self::create($episodeShow);
            }
        }
    }
}