<?php

namespace App;

use Appstract\Meta\Metable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Episodes extends Model
{
    use HasSlug;
    use Metable;

    protected $fillable = ['title', 'slug', 'mp3', 'description', 'published', 'show', 'link', 'mp3', 'length'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function boot()
    {
        parent::boot();

        self::saving(function ($episode) {
            $episode->title = Str::limit($episode->title, 350);

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

    public static function saveEpisode($item, $show)
    {
        if (!isset($item->title)) {
            return;
        }

        $episode = self::where([
            'title' => Str::limit($item->title, 250),
            'show' => $show->id,
        ])->first();

        $episodeShow = [
            'title' => $item->title, 250,
            'show' => $show->id,
            'description' => $item->description,
            'link' => $item->link,
            'published' => Carbon::createFromTimeString($item->pubDate)->toDateTimeString(),
            'length' => 0,
        ];

        if ($item->enclosure) {
            $attributes = $item->enclosure->attributes();
            if (isset($attributes['url'])) {
                $episodeShow['mp3'] = strval($attributes['url']);
            }

            if (isset($attributes['length'])) {
                $episodeShow['length'] = intval($attributes['length']);
            }
        }

        if (!$episode) {
            $newEpisode = self::create($episodeShow);
            $newEpisode->addMeta('Escuchas', 0);
        }
    }
}
