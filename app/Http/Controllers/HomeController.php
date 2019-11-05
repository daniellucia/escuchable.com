<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Episodes;
use App\Shows;
use Illuminate\Support\Facades\Cache;
use MetaTag;
use Illuminate\Http\Request;

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

    public function viewCategory(Categories $category, Request $request)
    {
        MetaTag::setTags([
            'title' => $category->name,
            'description' => $category->description,
        ]);

        $shows = Cache::remember(sprintf('episodes.%d.%d', $category->id, $request->get('page')), 60, function () use ($category) {
            return $category->shows()->orderBy('last_episode', 'desc')->paginate(16);
        });

        return view('shows', [
            'category' => $category,
            'shows' => $shows,
        ]);
    }

    public function viewShow(Shows $show)
    {

        MetaTag::setTags([
            'title' => $show->name,
            'description' => $show->description,
        ]);

        $category = Cache::remember(sprintf('category.%d', $show->category), 60, function () use ($show) {
            return Categories::find($show->category);
        });

        return view('episodes', [
            'category' => $category,
            'show' => $show,
            'episodes' => Episodes::whereShow($show->id)->paginate(25),
        ]);
    }

    public function viewEpisode(Shows $show, Episodes $episode, Request $request)
    {
        MetaTag::setTags([
            'title' => $episode->title,
            'description' => $episode->description,
        ]);

        $category = Cache::remember(sprintf('category.%d', $show->category), 60, function () use ($show) {
            return Categories::find($show->category);
        });

        return view('episode', [
            'category' => $category,
            'episode' => $episode,
            'show' => $show,
        ]);
    }

}
