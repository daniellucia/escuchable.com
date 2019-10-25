<?php

namespace App;

use App\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
         * Actualizamos el show
         */
        $this->name = $channel->title;
        $this->slug = Str::slug($channel->title);
        $this->web = $channel->link;
        $this->language = substr($channel->language, 0, 2);
        $this->description = $channel->description;
        if ($category) {
            $this->category = $category->id;
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
