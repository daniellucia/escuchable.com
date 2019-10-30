<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
use App\Categories;

Route::get('update', 'UpdateController@index');
Route::get('update/opml', 'UpdateController@opml');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/{category}', 'HomeController@viewCategory')->name('category.view');
Route::get('/{category}/{show}', 'HomeController@viewShow')->name('show.view');
Route::get('/{category}/{show}/{episode}', 'HomeController@viewEpisode')->name('episode.view');
