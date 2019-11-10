<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Shows;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function category(Categories $category, Request $request)
    {
        return $category;
    }
    public function show(Shows $show, Request $request)
    {
        if ($request->isMethod('post')) {
            $show->categories_id = $request->input('category');
            $show->save();

            return redirect(route('show.view', [$show]))->with('message', 'Perfecto! Se ha actualizado con éxito.');
        }

        return view('admin.show',[
            'show' => $show,
            'categories' => Categories::orderBy('name')->get()
        ]);
    }

}
