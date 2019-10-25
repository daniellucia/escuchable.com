<?php

namespace App;

use App\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Shows extends Model
{
    protected $fillable = ['name', 'slug', 'feed', 'image', 'descrition', 'category', 'author', 'revised'];

    public function updateByChannel($channel)
    {

        /**
         * Comprobamos la categoría
         */
        $category = false;
        if ($channel->category) {
            $category = Categories::firstOrCreate(['slug' => Str::slug($channel->category)]);
            $category->name = $channel->category;
            $category->save();
        }

        /**
         * Comprobamos si el show
         * tiene imagen y de ser así,
         * la copiamos con el nombre
         * correcto
         */
        $image = false;
        if ($channel->image->url) {
            $extension = pathinfo($channel->image->url, PATHINFO_EXTENSION);
            $image = sprintf('/images/show/%s.%s', substr(Str::slug($channel->title), 0, 30), $extension);
            if (!file_exists($image)) {
                Image::make($channel->image->url)->save(public_path($image));

                /**
                 * Redimensionamos la imagen
                 */
                $img = Image::make(public_path($image));
                $img->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

        }

        /**
         * Actualizamos el show
         */

        $this->name = trim($channel->title);
        $this->slug = Str::slug($channel->title);
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
                    $show->name = $element['text'];
                    $show->slug = Str::slug($element['text']);
                    $show->save();
                }

            }
        }
    }
}
