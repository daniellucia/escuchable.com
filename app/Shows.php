<?php

namespace App;

use Appstract\Meta\Metable;
use App\Categories;
use App\Resources\Channel;
use App\Search;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Jcc\LaravelVote\CanBeVoted;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Shows extends Model
{
    use HasSlug;
    use HasTags;
    use Metable;
    use CanBeVoted;

    protected $vote = User::class;
    protected $fillable = ['name', 'slug', 'feed', 'image', 'description', 'categories_id',
        'author', 'revised', 'language', 'thumbnail', 'last_episode'];

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

        /**
         * Al actualizar o crear, actualizamos
         * el slug con el nombre del modelo
         */
        self::saving(function ($show) {
            $show->name = Str::limit(trim($show->name), 250);
            $show->language = substr($show->language, 0, 2);

            /**
             * Sistema de búsqueda
             */
            $category = Categories::find($show->categories_id);
            $url = route('show.view', [$category, $show]);
            $search = Search::where('url', $url)->first();
            if (!$search) {
                $search = Search::create([
                    'search' => $show->name,
                    'url' => $url,
                    'type' => 'show',
                    'id_type' => $show->id,
                    'image' => $show->thumbnail,
                    'weight' => 4,
                ]);
            }

            $keywords = Read::tags($show->name);
            if (!empty($keywords)) {
                foreach ($keywords as $keyword) {
                    if ($keyword != '') {
                        $show->attachTag(strval($keyword));
                    }

                }
            }
        });

        self::deleting(function ($show) {
            Search::where([
                'type' => 'show',
                'id_type' => $show->id,
            ])->delete();
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
        $channel->setCategory($category);

        if ($category) {
            $this->attachTag($category->name);
        }

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
        if (!file_exists(public_path($value))) {
            return '';
        } else {
            return $value;
        }

    }

    public function getThumbnailAttribute($value)
    {
        if (!file_exists(public_path($value))) {
            return '';
        } else {
            return $value;
        }

    }

}
