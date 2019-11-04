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
            'shows' => $category->shows()->orderBy('last_episode', 'desc')->paginate(16),
        ]);
    }

    public function viewShow(Shows $show)
    {

        MetaTag::setTags([
            'title' => $show->name,
            'description' => $show->description,
        ]);

        $category = Categories::find($show->category);

        return view('episodes', [
            'category' => $category,
            //'shows' => $category->shows()->orderBy('last_episode', 'desc')->paginate(16),
            'show' => $show,
            'episodes' => Episodes::whereShow($show->id)->paginate(25),
        ]);
    }

    public function viewEpisode(Shows $show, Episode $episode)
    {
        MetaTag::setTags([
            'title' => $episode->title,
            'description' => $show->description,
        ]);

        $episodes = Episodes::whereShow($show->id)->paginate(25);
        $category = Categories::find($show->category);

        /*$events = [];
        foreach ($episodes as $episode) {
            $events[] = \Calendar::event(
                $episode->title,
                true,
                $episode->published,
                $episode->published,
                $episode->slug
            );
        }
        $calendar = \Calendar::addEvents($events);*/

        return view('episodes', [
            'category' => $category,
            //'shows' => $category->shows()->paginate(16),
            //'show' => $show,
            'episodes' => $episodes,
            //'calendar' => $calendar,
        ]);
    }

}
