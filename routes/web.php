<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search.results');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin/category/edit/{category}', 'AdminController@category')->name('categories.edit');
    Route::get('/admin/shows/edit/{show}', 'AdminController@show')->name('show.edit');
    Route::post('/admin/shows/edit/{show}', 'AdminController@show')->name('show.save');

    Route::get('/admin/shows/create', 'ShowController@create')->name('show.create');
    Route::post('/admin/shows/create', 'ShowController@store')->name('show.store');
});

Route::group(['middleware' => ['role:super-user', 'role:user']], function () {
    //Route::get('/admin/shows/edit/{show}', 'AdminController@show')->name('show.edit');
});

Route::get('/{category}', 'HomeController@viewCategory')->name('category.view');
Route::get('/show/{show}', 'HomeController@viewShow')->name('show.view');
Route::get('/{show}/{episode}', 'HomeController@viewEpisode')->name('episode.view');


