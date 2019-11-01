<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = ['search', 'url', 'weight', 'type', 'id_type', 'image'];

}
