<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use App\Categories;
use App\Shows;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Inicio', route('home'));
});

Breadcrumbs::for('shows', function ($trail, $category) {
    $trail->parent('home');
    $trail->push($category->name, route('category.view', $category));
});

Breadcrumbs::for('episodes', function ($trail, $show) {
    $trail->parent('shows', Categories::find($show->categories_id));
    $trail->push($show->name, route('show.view', $show));
});

Breadcrumbs::for('episode', function ($trail, $show, $episode) {
    $trail->parent('episodes', $show);
    $trail->push($episode->title, route('show.view', [$show, $episode]));
});
