<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Categories extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'slug', 'visible'];

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

    /**
     * Comprobamos si existe la categoria
     * la creamos y la retornamos.
     *
     * @param Channel $channel
     * @return void
     */
    public static function check($channel)
    {
        $category = false;

        if (strval($channel->categories_id) != '') {
            $categoryName = GoogleTranslate::trans(strval($channel->categories_id), 'es', 'en');

            if (strlen($categoryName) > 3) {
                $category = Categories::firstOrCreate(['name' => Str::limit($categoryName, 30)]);
                $category->save();
            } else {
                $category = Categories::firstOrCreate(['name' => Str::limit(strval($channel->category), 30)]);
                $category->save();
            }
        }

        return $category;
    }

    public function shows()
    {
        return $this->hasMany('App\Shows');
    }
}
