<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('home_page');
});

Route::get('/game_page', function () {
    return view('game_page');
});

Route::get('/api/home.xml', 'HomePageController@homeXml');
Route::get('/api/games/{name}/header.xml', 'GameController@game_header');
Route::get('/api/games/{name}/info.xml', 'GameController@game_header');
Route::get('/api/games/{name}/leaderboard.xml', 'GameController@game_leaderboard');
Route::get('/api/games/{name}/comments.xml/{offset?}', 'GameController@game_comments');
Route::get('/api/games/{name}/related_games.xml', 'GameController@game_related');

Route::post('/api/games/add_comment', 'GameController@add_comment')->middleware('auth');

Route::get('/games_list', function () {
    return view('games_list');
});

Route::get('/api/categories.xml', 'GamesListController@getCategories');
Route::get('/api/games.xml/{searchKeywords?}', 'GamesListController@games');
Route::post('/api/games_list.xml', 'GamesListController@games_list');

Route::post('/profile/categorisation', 'ProfilesController@categorisation');
Route::post('/profile/changepassword', 'ProfilesController@changepassword');
Route::resource('profile', 'ProfilesController', ['only' => ['show', 'update']]);
Route::get('/profile/{$username}', ['as' => 'profile', 'uses' => 'ProfilesController@show']);

Route::get('/admin/make', 'UserController@addtoadmin');
Route::resource('admin', 'UserController', ['only' => ['edit', 'update']]);
Route::get('/admin/{admin?}', ['as' => 'admin', 'uses' => 'UserController@edit'])->middleware('auth', 'admin');

Route::get('/minesweeper', function () {
    return view('minesweeper');
});
Route::post('/api/minesweeper', 'GameController@minesweeper')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
