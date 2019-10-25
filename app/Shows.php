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
}
