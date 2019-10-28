<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Categories extends Model
{
    protected $fillable = ['name', 'slug', 'visible'];

    public static function boot() {
        parent::boot();

        /**
         * Al actualizar o crear, actualizamos
         * el slug con el nombre del modelo
         */
        self::saving(function($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    /**
     * Comprobamos si existe la categoria
     * la creamos y la retornamos.
     *
     * @param [type] $channel
     * @return void
     */
    public static function check($channel) {
        $category = false;
        if ($channel->category) {
            $category = Categories::firstOrCreate(['name' => Str::limit($channel->category, 30)]);
            $category->save();
        }

        return false;
    }
}
