<?php

namespace App;

use App\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Shows extends Model
{
    use HasSlug;
    use HasTags;

    protected $fillable = ['name', 'slug', 'feed', 'image', 'descrition', 'category', 'author', 'revised'];

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
        });
    }

    public function updateByChannel($channel)
    {

        /**
         * Comprobamos la categoría
         */
        $category = Categories::check($channel);

        /**
         * Comprobamos si el show
         * tiene imagen y de ser así,
         * la copiamos con el nombre
         * correcto
         */
        $image = self::checkImage($channel);

        /**
         * Actualizamos el show
         */

        $this->name = $channel->title;
        $this->web = $channel->link;
        $this->language = $channel->language;
        $this->description = $channel->description;
        $this->image = $image;

        if ($category) {
            $this->category = $category->id;

            $this->attachTag($category->name);
        }

        $this->save();
    }

    public static function saveFromOPML($xml)
    {
        if (!is_object($xml)) {
            return;
        }

        $parser = new \vipnytt\OPMLParser($xml);
        $array = $parser->getResult();

        if (!empty($array)) {
            foreach ($array['body'] as $element) {
                if (isset($element['xmlUrl'])) {
                    $show = self::firstOrCreate(['feed' => $element['xmlUrl']]);
                    $show->name = $element['text'];
                    $show->save();
                }

            }
        }
    }

    public static function checkImage($channel)
    {
        $image = '';
        if ($channel->image->url) {
            $urlRemote = strtok($channel->image->url, '?');
            $extension = pathinfo($urlRemote, PATHINFO_EXTENSION);
            $image = sprintf('/images/show/%s.%s', substr(Str::slug($channel->title), 0, 30), $extension);
            if (!file_exists($image)) {
                try {
                    Image::make($urlRemote)->save(public_path($image));

                    /**
                     * Redimensionamos la imagen
                     */
                    $img = Image::make(public_path($image));
                    $img->resize(400, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } catch (\Exception $e) {

                }
            }
        }

        return $image;
    }
}
