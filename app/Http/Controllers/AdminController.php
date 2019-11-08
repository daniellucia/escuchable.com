<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Shows;

class AdminController extends Controller
{
    public function category(Categories $category)
    {
        return $category;
    }
    public function show(Shows $show)
    {
        return $show;
    }

}
