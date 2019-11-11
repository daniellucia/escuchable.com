<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Shows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

            Cache::flush();

            if ($request->ajax()) {
                return response()->json(['success' => 'Perfecto! Se ha actualizado con éxito.']);
            }
            return redirect(route('show.view', [$show]))->with('message', 'Perfecto! Se ha actualizado con éxito.');
        }

        return view('admin.show', [
            'show' => $show,
            'categories' => Categories::orderBy('name')->get(),
        ]);
    }

}
