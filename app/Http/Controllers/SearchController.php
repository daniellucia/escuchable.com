<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Shows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->get('term');
        $shows = [];

        $categories = Cache::remember('categories', 60, function () {
            Categories::orderBy('name')->get();
        });

        if ($term) {
            $shows = Shows::where('name', 'like', '%' . $term . '%')
                ->orWhere('description', 'like', '%' . $term . '%')->paginate(16);
        }

        return view('search', [
            'shows' => $shows,
            'categories' => $categories,
            'term' => $term,
        ]);
    }

}
