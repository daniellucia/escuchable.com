<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shows;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->get('term');
        $shows = [];

        if ($term) {
            $shows = Shows::where('name', 'like', '%' . $term . '%')
            ->orWhere('description', 'like', '%' . $term . '%')->paginate(16);
        }

        return view('search', [
            'shows' => $shows,
            'term' => $term,
        ]);
    }

}
