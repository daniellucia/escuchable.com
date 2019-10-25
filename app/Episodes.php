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
                'title' => Str::limit($item->title, 250),
                'show' => $show->id,
            ])->first();

            $episodeShow = [
                'title' => Str::limit($item->title, 250),
                'slug' => Str::slug(Str::limit($item->title, 250)),
                'show' => $show->id,
                'description' => $item->description,
                'link' => $item->link,
                'published' => Carbon::createFromTimeString($item->pubDate)->toDateTimeString(),
                'length' => 0,
            ];

            if ($item->enclosure->attributes()) {
                $episodeShow['mp3'] = $item->enclosure->attributes()['url'];
                $episodeShow['length'] = $item->enclosure->attributes()['length'];
            }

            if (!$episode) {
                self::create($episodeShow);
            }
        }
    }
}
