<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Episodes;
use App\Shows;
use MetaTag;

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
        MetaTag::setTags([
            'title' => $category->name,
            'description' => $category->description,
        ]);

        return view('shows', [
            'category' => $category,
            'shows' => $category->shows()->paginate(10, ['*'], 'page-show'),
        ]);
    }

    public function viewShow(Categories $category, Shows $show)
    {

        MetaTag::setTags([
            'title' => $show->name,
            'description' => $show->description,
        ]);

        return view('episodes', [
            'category' => $category,
            'shows' => $category->shows()->paginate(10, ['*'], 'page-show'),
            'show' => $show,
            'episodes' => Episodes::whereShow($show->id)->paginate(25),
        ]);
    }

    public function viewEpisode(Categories $category, Shows $show, Episode $episode)
    {
        MetaTag::setTags([
            'title' => $episode->title,
            'description' => $show->description,
        ]);

        return view('episodes', [
            'category' => $category,
            'shows' => Shows::where('categories_id', $category->id)->paginate(10),
            'show' => $show,
            'episodes' => Episodes::whereShow($show->id)->paginate(25),
        ]);
    }

}
