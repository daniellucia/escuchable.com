<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Shows;
use App\Episodes;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function viewCategory(Categories $category) {

        return view('home', [
            'category' => $category,
            'shows' => Shows::whereCategory($category->id)->get()
        ]);
    }

    public function viewShow(Categories $category, Shows $show) {
        return view('home', [
            'category' => $category,
            'shows' => Shows::whereCategory($category->id)->get(),
            'show' => $show,
            'episodes' => Episodes::whereShow($show->id)->paginate(25),
        ]);
    }

    public function viewEpisode(Categories $category, Shows $show) {
        return view('home', [
            'category' => $category,
            'shows' => Shows::whereCategory($category->id)->get(),
            'show' => $show,
            'episodes' => Episodes::whereShow($show->id)->paginate(25),
        ]);
    }
}
