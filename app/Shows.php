<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shows extends Model
{
    protected $fields = ['name', 'slug', 'feed', 'image', 'descrition', 'category', 'author', 'revised', 'id'];
    protected $fillable = ['name', 'slug', 'feed', 'image', 'descrition', 'category', 'author', 'revised'];
}
