<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Shows;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function category(Categories $category) {
        return $category;
    }
    public function show(Shows $show) {
        return $show;
    }
}
