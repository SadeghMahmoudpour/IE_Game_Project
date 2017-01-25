<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ProfilesController extends Controller
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
    public function show($username)
    {
        $user = User::find($username);
        $usercategories = $user->categories()->get();
        $categories = Category::all();
        return View::make('profile')->with('user', $user)->with('usercategories', $usercategories)->with('categories', $categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = User::find($id);
        $input = Input::only('name', 'email', 'avatar');
        $user->name = $input["name"];
        $user->email = $input["email"];
        $user->avatar = $input["avatar"];
        $user->save();
        return Redirect::route('profile.show', $user->id);
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

    public function categorisation(Request $request){
        $categories = $integerIDs = array_map('intval', $request->categories);
        $user = User::find(Auth::id());
        $user->categories()->sync($categories);
        return Redirect::route('profile.show', $user->id);
    }

    public function changepassword(Request $request){
        $user = User::find(Auth::id());
        if (!Hash::check($request->old_password, $user->password)){
            return Redirect::route('profile.show', $user->id);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return Redirect::route('profile.show', $user->id);
    }
}
