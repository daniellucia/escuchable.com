<?php

namespace App;

use App\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Shows extends Model
{
    protected $fillable = ['name', 'slug', 'feed', 'image', 'descrition', 'category', 'author', 'revised'];

    public static function boot()
    {
        parent::boot();

        /**
         * Al actualizar o crear, actualizamos
         * el slug con el nombre del modelo
         */
        self::saving(function($show) {
            $show->slug = Str::slug($show->name);
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

        $this->name = Str::limit(trim($channel->title), 250);
        $this->web = $channel->link;
        $this->language = substr($channel->language, 0, 2);
        $this->description = $channel->description;

        if ($category) {
            $this->category = $category->id;
        }

        if ($image) {
            $this->image = $image;
        }

        $this->save();
    }

    public static function saveFromOPML($xml)
    {
        $parser = new \vipnytt\OPMLParser($xml);

        $array = $parser->getResult();

        if (!empty($array)) {
            foreach ($array['body'] as $element) {
                if (isset($element['xmlUrl'])) {
                    $show = self::firstOrCreate(['feed' => $element['xmlUrl']]);
                    $show->name = Str::limit($element['text'], 250);
                    $show->save();
                }

            }
        }
    }

    public static function checkImage($channel)
    {
        $image = false;
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
                } catch (Exception $e) {

                }
            }
        }

        return $image;
    }
}
