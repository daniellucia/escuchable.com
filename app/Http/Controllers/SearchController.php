<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Episodes;
use App\Search;
use App\Shows;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->get('term');
        if ($term) {
            $results = Search::where('search', 'LIKE', "%{$term}%")->orderBy('weight', 'desc')->paginate(25);
        }

        return view('search', [
            'results' => $results,
            'term' => $term
        ]);
    }

    public function update()
    {

        $categories = Categories::all();
        foreach ($categories as $category) {

            $shows = Shows::where('categories_id', $category->id)->get();
            foreach ($shows as $show) {

                $url = route('show.view', [$category, $show]);
                $search = Search::where('url', $url)->first();
                if (!$search) {
                    $search = Search::create([
                        'search' => $show->name,
                        'url' => $url,
                        'type' => 'show',
                        'id_type' => $show->id,
                        'image' => $show->thumbnail,
                        'weight' => 4,
                    ]);
                }

                $episodes = Episodes::whereShow($show->id)->get();
                foreach ($episodes as $episode) {
                    $url = route('episode.view', [$category, $show, $episode]);
                    $search = Search::where('url', $url)->first();
                    if (!$search) {
                        $search = Search::create([
                            'search' => substr($episode->title, 0, 400),
                            'url' => $url,
                            'type' => 'episode',
                            'id_type' => $episode->id,
                            'image' => $show->thumbnail,
                            'weight' => 2,
                        ]);
                    }
                }
            }
        }
    }
}
