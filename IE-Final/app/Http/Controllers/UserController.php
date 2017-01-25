<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $games = Game::with('categories')->get();
        $admin = User::find(Auth::id());
        $categories = Category::all();
        return View::make('admin')->with('games', $games)->with('admin', $admin)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $game = Game::find($request->gameId);
        if($game){
            $categories = $integerIDs = array_map('intval', $request->categories);
            $game->title = $request->title;
            $game->abstract = $request->abstract;
            $game->info = $request->info;
            $game->large_image = $request->large_image;
            $game->small_image = $request->small_image;
            $game->categories()->sync($categories);
            $game->save();
        }elseif ($request->gameId == 'newGame'){
            $categories = $integerIDs = array_map('intval', $request->categories);
            $game = new Game();
            $game->title = $request->title;
            $game->abstract = $request->abstract;
            $game->info = $request->info;
            $game->large_image = $request->large_image;
            $game->small_image = $request->small_image;
            $game->save();
            $game->categories()->sync($categories);
            $game->save();
        }
        return redirect('admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addtoadmin(){
        if(Auth::check()){
            $user = User::find(Auth::id());
            $user->admin = true;
            $user->save();
            return redirect('admin');
        }
        return redirect('admin');
    }
}
