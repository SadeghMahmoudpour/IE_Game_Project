<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;

class GamesListController extends Controller
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

    public function getCategories()
    {
        $categories = Category::all();
        $result['categories']['category'] = $categories->pluck('name')->toArray();
        $xml = ArrayToXml::convert($this->makeResponseArray($result), 'response');
        return response($xml, '200')->header('Content-Type', 'text/xml');
    }

    public function games(Request $request)
    {
        $searchKeywords = $request->searchKeywords;
        $games = Game::where('title', 'LIKE', '%' . $searchKeywords . '%')->get();

        $result['games']['game'] = [];
        foreach ($games as $game) {
            array_push($result['games']['game'], $game->getGameArray());
        }
        if (!$searchKeywords || !$games->first()) $result = [];
        $xml = ArrayToXml::convert($this->makeResponseArray($result), 'response');
        return response($xml, '200')->header('Content-Type', 'text/xml');
    }

    public function games_list(Request $request)
    {
        $filters = json_decode($request->filters);
        $games['game'] = [];
        $added_games = [];
        $catfilter = !empty($filters->categories);
        $ratefilter = !empty($filters->rates);
        if ($catfilter) {
            $categories = Category::where(function ($query) use ($filters) {
                foreach ($filters->categories as $category) {
                $query->orWhere('name', $category);
            }
            })->get();
            foreach ($categories as $category) {
                $category_games = $category->games()->get();
                foreach ($category_games as $game) {
                    if (!in_array($game->id, $added_games, true)) {
                        array_push($added_games, $game->id);
                    }
                }
            }
            if ($ratefilter) {
                $and_games = [];
                $all_games = Game::all();
                foreach ($all_games as $game) {
                    if (in_array($game->id, $added_games, true)) {
                        $checked = false;
                        $game_rate = $game->comments()->avg('rate');
                        foreach ($filters->rates as $rate) {
                            $rate = (double)$rate;
                            if ($game_rate >= $rate && $game_rate < $rate + 1) {
                                $checked = true;
                            }
                        }
                        if ($checked) {
                            array_push($and_games, $game->id);
                        }
                    }
                }
                $added_games = $and_games;
            }
        }
        elseif ($ratefilter) {
            $all_games = Game::all();
            foreach ($all_games as $game) {
                if (!in_array($game->id, $added_games, true)) {
                    $checked = false;
                    $game_rate = $game->comments()->avg('rate');
                    foreach ($filters->rates as $rate) {
                        $rate = (double)$rate;
                        if ($game_rate >= $rate && $game_rate < $rate + 1) {
                            $checked = true;
                        }
                    }
                    if ($checked) {
                        array_push($added_games, $game->id);
                    }
                }
            }
        }

        if (empty($added_games)) $games = [];
        else {
            foreach ($added_games as $game_id) {
                array_push($games['game'], Game::where('id', $game_id)->first()->getGameArray());
            }
        }
        $result['games_list']['games'] = $games;
        $xml = ArrayToXml::convert($this->makeResponseArray($result), 'response');
        return response($xml, '200')->header('Content-Type', 'text/xml');

//        $games = Game::where(function ($query) use ($filters) {
//            foreach ($filters->categories as $category) {
//                $query->orWhere('title', 'LIKE', '%' . $category . '%');
//            }
//        })->first();
    }
}
