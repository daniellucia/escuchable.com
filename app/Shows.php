<?php

namespace App;

use Appstract\Meta\Metable;
use App\Categories;
use App\Presenters\DateLastEpisodeAgo;
use App\Resources\Channel;
use Fomvasss\LaravelMetaTags\Traits\Metatagable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Jcc\LaravelVote\CanBeVoted;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Watson\Rememberable\Rememberable;

class Shows extends Model
{
    use HasSlug;
    use Metable;
    use CanBeVoted;
    use Metatagable;
    use DateLastEpisodeAgo;
    use Rememberable;

    protected $vote = User::class;
    protected $fillable = ['name', 'slug', 'feed', 'image', 'description', 'categories_id',
        'author', 'revised', 'language', 'thumbnail', 'last_episode', 'active'];
    public $rememberFor = 120; //2 horas

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
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

        self::saving(function ($show) {
            $show->name = Str::limit(trim($show->name), 250);
            $show->language = substr($show->language, 0, 2);

        });
    }

    public function updateByChannel($channel)
    {
        /**
         * Formateamos channel
         */
        $channel = new Channel($channel);

        /**
         * Comprobamos la categoría
         */
        $category = Categories::check($channel);
        $channel->setCategory($category, $this->category);

        $this->update($channel->toArray());
    }

    public static function saveFromOPML($xml)
    {
        $showsImported = [];
        $parser = new \vipnytt\OPMLParser($xml);
        $array = $parser->getResult();

        if (!empty($array)) {
            foreach ($array['body'] as $element) {
                if (isset($element['xmlUrl'])) {
                    $show = self::firstOrCreate(['feed' => $element['xmlUrl']]);
                    $show->name = $element['text'];
                    $show->save();

                    $showsImported[] = $element['text'];
                }

            }
        }

        return $showsImported;
    }

    public function getImageAttribute($value)
    {
        if ($value == '' || !file_exists(public_path($value))) {
            return '/images/show/no-image.jpg';
        } else {
            return $value;
        }

    }

    public function getThumbnailAttribute($value)
    {
        if ($value == '' || !file_exists(public_path($value))) {
            return '/images/show/no-image.jpg';
        } else {
            return $value;
        }

    }

    public function category()
    {
        return $this->belongsTo('App\Categories');
    }

    public function episodes()
    {
        return $this->hasMany('App\Episodes');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
