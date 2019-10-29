<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

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
     * @param [type] $channel
     * @return void
     */
    public static function check($channel)
    {
        $category = false;
        if ($channel->category) {
            $category = Categories::firstOrCreate(['name' => Str::limit($channel->category, 30)]);
            $category->save();
        }

        return $category;
    }
}
