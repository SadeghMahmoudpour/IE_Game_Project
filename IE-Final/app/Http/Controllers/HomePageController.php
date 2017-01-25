<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Game;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\ArrayToXml\ArrayToXml;

class HomePageController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function makeResponseArray($result)
    {
        $response = [];
        $response['ok'] = 'true';
        $response['result'] = $result;
        return $response;
    }

    private function bestCategoriesGames($categories){
        $added_games = [];
        foreach ($categories as $category) {
            $games = $category->games()->get();
            $game_id = 0;
            $game_avg = 0.00;
            if ($games->first() && !in_array($games->first()->id, $added_games, true)) {
                $game_id = $games->first()->id;
                $game_avg = $games->first()->comments()->avg('rate');
            }
            foreach ($games as $game) {
                if (!in_array($game->id, $added_games, true) && ($game->comments()->avg('rate') > $game_avg)) {
                    $game_id = $game->id;
                    $game_avg = $game->comments()->avg('rate');
                }
            }
            if ($game_id > 0) {
                array_push($added_games, $game_id);
            }
        }
        return Game::whereIn('id', $added_games)->get();
    }

    public function homeXml()
    {
        $sliderGames = Game::all()->take(5);
        $categories = Category::all();
        if (Auth::check()) {
            $added_games = [];
            $categories = Auth::user()->categories()->get();
            foreach ($categories as $category) {
                $games = $category->games()->get();
                foreach ($games as $game) {
                    if (!in_array($game->id, $added_games, true)) {
                        array_push($added_games, $game->id);
                    }
                }
            }
            if(!empty($added_games)) {
                $sliderGames = Game::whereIn('id', $added_games)->get();
            }else {
                $sliderGames = $this->bestCategoriesGames(Category::all());
            }
        } else {
            $sliderGames = $this->bestCategoriesGames($categories);
        }

        $comments = Comment::orderBy('updated_at', 'desc')->take(5)->get();

        $result = [];
        $result['homepage']['slider']['game'] = [];
        if(!$sliderGames->first())$sliderGames=Game::all()->take(5);
        foreach ($sliderGames as $game) {
            array_push($result['homepage']['slider']['game'], $game->getGameArray());
        }

        $newGames = Game::orderBy('created_at', 'desc')->take(5)->get();
        $result['homepage']['new_games']['game'] = [];
        foreach ($newGames as $game) {
            array_push($result['homepage']['new_games']['game'], $game->getGameArray());
        }

        $result['homepage']['comments']['comment'] = [];
        foreach ($comments as $comment) {
            array_push($result['homepage']['comments']['comment'], $comment->getCommentArray());
        }

        $result['homepage']['tutorials']['tutorial'] = [];
        foreach ($newGames as $game) {
            array_push($result['homepage']['tutorials']['tutorial'], $game->getTutorialArray());
        }

        $xml = ArrayToXml::convert($this->makeResponseArray($result), 'response');
        return response($xml, '200')->header('Content-Type', 'text/xml');
    }
}
