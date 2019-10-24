<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episodes extends Model
{
    protected $fields = ['title', 'slug', 'mp3', 'description', 'published', 'show', 'link', 'mp3', 'length', 'id'];
    protected $fillable = ['title', 'slug', 'mp3', 'description', 'published', 'show', 'link', 'mp3', 'length'];
}
