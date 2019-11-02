<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Episodes;
use App\Resources\Read;
use App\Search;
use App\Shows;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->get('term');
        if ($term) {
            $keywords = Read::tags($term);
            if (!empty($keywords)) {
                $posts = Shows::withAnyTags($keywords)->pluck('id');
            }
            $results = Search::where('search', 'LIKE', "%{$term}%")
                ->orWhere(function ($query) use ($posts) {
                    $query->whereIn('id', $posts)
                        ->where('type', '=', 'post');
                })
                ->orderBy('weight', 'desc')->paginate(25);
        }

        return view('search', [
            'results' => $results,
            'term' => $term,
        ]);
    }

    public function update()
    {
        $categories = Categories::all();
        foreach ($categories as $category) {

            $shows = Shows::where('categories_id', $category->id)->get();
            foreach ($shows as $show) {

                $url = route('show.view', [$category, $show]);
                Search::add($show->id, 'show', $show->name, $url, $show->thumbnail, 4);
                $keywords = Read::tags($show->name);
                if (!empty($keywords)) {
                    foreach ($keywords as $keyword) {
                        if ($keyword != '') {
                            Search::add($show->id, 'show', $keyword, $url, $show->thumbnail, 4);
                        }

                    }
                }

                $episodes = Episodes::whereShow($show->id)->get();
                foreach ($episodes as $episode) {
                    $url = route('episode.view', [$category, $show, $episode]);
                    Search::add($episode->id, 'episode', $episode->title, $url, $show->thumbnail, 2);

                    $keywords = Read::tags($episode->title);
                    if (!empty($keywords)) {
                        foreach ($keywords as $keyword) {
                            if ($keyword != '') {
                                Search::add($episode->id, 'episode', $keyword, $url, $show->thumbnail, 2);
                                Search::add($show->id, 'show', $keyword, $url, $show->thumbnail, 4);
                            }

                        }
                    }
                }
            }
        }
    }
}
