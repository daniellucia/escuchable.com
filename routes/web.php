<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search.results');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin/category/edit/{category}', 'AdminController@category')->name('categories.edit');
    Route::get('/admin/shows/edit/{show}', 'AdminController@show')->name('show.edit');
});

Route::group(['middleware' => ['role:super-user', 'role:user']], function () {
    //Route::get('/admin/shows/edit/{show}', 'AdminController@show')->name('show.edit');
});

Route::get('/{category}', 'HomeController@viewCategory')->name('category.view');
Route::get('/show/{show}', 'HomeController@viewShow')->name('show.view');
Route::get('/{show}/{episode}', 'HomeController@viewEpisode')->name('episode.view');


