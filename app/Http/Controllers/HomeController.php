<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Episodes;
use App\Shows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use MetaTag;
use TorMorten\Eventy\Facades\Events as Eventy;

class HomeController extends Controller
{
    private $categories;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = Cache::remember('categories', 60, function () {
            return Categories::where('shows_count', '>', 0)->orderBy('name')->get();
        });

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'categories' => $this->categories,
        ]);
    }

    public function viewCategory(Categories $category, Request $request)
    {
        MetaTag::setTags([
            'title' => Eventy::filter('meta.title', $category->name),
            'description' => $category->description,
        ]);

        if (Auth::check() && Auth::user()->hasPermissionTo('show.edit')) {
            $shows = $category->shows()->orderBy('last_episode', 'desc')->paginate(18);
        } else {
            $shows = Cache::remember(sprintf('shows.%d.%d', $category->id, $request->get('page')), 60, function () use ($category) {
                return $category->shows()->active()->orderBy('last_episode', 'desc')->paginate(18);
            });
        }

        return view('shows', [
            'category' => $category,
            'shows' => $shows,
            'categories' => $this->categories,
        ]);
    }

    public function viewShow(Shows $show)
    {

        MetaTag::setTags([
            'title' => Eventy::filter('meta.title', $show->name),
            'description' => $show->description,
        ]);

        $category = Cache::remember(sprintf('category.%d', $show->category), 60, function () use ($show) {
            return Categories::find($show->category);
        });

        return view('episodes', [
            'category' => $category,
            'show' => $show,
            'episodes' => $show->episodes()->paginate(25),
        ]);
    }

    public function viewEpisode(Shows $show, Episodes $episode, Request $request)
    {
        MetaTag::setTags([
            'title' => Eventy::filter('meta.title', $episode->title),
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
