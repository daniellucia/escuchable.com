<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Episodes;
use App\Shows;

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

    public function viewCategory(Categories $category)
    {

        return view('home', [
            'category' => $category,
            'shows' => $category->shows()->paginate(10, ['*'], 'page-show'),
        ]);
    }

    public function viewShow(Categories $category, Shows $show)
    {

        return view('home', [
            'category' => $category,
            'shows' => $category->shows()->paginate(10, ['*'], 'page-show'),
            'show' => $show,
            'episodes' => Episodes::whereShow($show->id)->paginate(25, ['*'], 'page-episode'),
        ]);
    }

    public function viewEpisode(Categories $category, Shows $show)
    {
        return view('home', [
            'category' => $category,
            'shows' => Shows::whereCategory($category->id)->get(),
            'show' => $show,
            'episodes' => Episodes::whereShow($show->id)->paginate(25),
        ]);
    }
}
