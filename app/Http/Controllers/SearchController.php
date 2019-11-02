<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->get('term');
        $results = [];

        if ($term) {

        }

        return view('search', [
            'results' => $results,
            'term' => $term,
        ]);
    }

}
