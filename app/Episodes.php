<?php

namespace App;

use Appstract\Meta\Metable;
use App\Presenters\DatePublishedAgo;
use Carbon\Carbon;
use Fomvasss\LaravelMetaTags\Traits\Metatagable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Watson\Rememberable\Rememberable;

class Episodes extends Model
{
    use HasSlug;
    use Metable;
    use Metatagable;
    use DatePublishedAgo;
    use Rememberable;

    protected $fillable = ['title', 'slug', 'mp3', 'description', 'published', 'shows_id', 'link', 'mp3', 'length'];
    public $rememberFor = 120; //2 horas

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
            'shows_id' => $show->id,
        ])->first();

        $episodeShow = [
            'title' => $item->title, 250,
            'shows_id' => $show->id,
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

    public function show()
    {
        //return $this->belongsTo('App\Shows');
        return Shows::find($this->shows_id);
    }

}
