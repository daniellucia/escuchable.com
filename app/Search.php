<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = ['search', 'url', 'weight', 'type', 'id_type', 'image'];

    public static function add($id_type, $type, $text, $url, $image, $weight)
    {
        if (!$text) {
            return false;
        }

        if (!$id_type) {
            return false;
        }

        $search = Search::where(['id_type' => $id_type, 'type' => $type, 'search' => $text])->first();
        if (!$search) {
            $data = [
                'search' => $text,
                'url' => $url,
                'type' => $type,
                'id_type' => $id_type,
                'image' => $image,
                'weight' => $weight,
            ];
            //dump($data);
            $search = Search::create($data);
        }

        return $search;
    }

    public static function remove($id_type, $type)
    {
        return Search::where(['id_type' => $id_type, 'type' => $type])->delete();
    }
}
