<?php

namespace App\Http\Controllers;

use App\Resources\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShowController extends Controller
{
    /**
     * Muestra elformulario para
     * enviar una feed nuevo
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('shows.create');
    }

    public function store(Request $request)
    {
        if (Feed::insert($request->feed)) {
            return redirect()->back()->with('message', 'Perfecto! Se ha añadido con éxito.');
        } else {
            return redirect()->back()->withErrors(['Ha ocurrido un error con la url de este feed.']);
        }
    }
}
