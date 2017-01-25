<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Game;
use App\Record;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\ArrayToXml\ArrayToXml;

class GameController extends Controller
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

    public function game_header(Request $request)
    {
        $gameName = $request->name;
        $result = [];
        $result['game'] = Game::where('title', $gameName)->first()->getGameArray();
        $xml = ArrayToXml::convert($this->makeResponseArray($result), 'response');
        return response($xml, '200')->header('Content-Type', 'text/xml');
    }

    public function game_leaderboard(Request $request)
    {
        $gameName = $request->name;
        $result = [];
        $result['leaderboard'] = [];
        $game_records = Game::where('title', $gameName)->first()->records()->orderBy('score', 'desc');
        $topten = $game_records->take(5)->get();
        if ($game_records->first()) {
            $result['leaderboard']['record'] = [];
        }
        $added_users = [];
        foreach ($topten as $record) {
            array_push($added_users, $record->user_id);
            array_push($result['leaderboard']['record'], $record->getRecordArray());
        }
        if (!in_array(Auth::id(), $added_users, true)) {
            $user_record = Record::where('user_id', Auth::id())->where('game_id', Game::where('title', $gameName)->first()->id)->first();
            if ($user_record) {
                if (count($added_users) > 4) {
                    array_pop($result['leaderboard']['record']);
                }
                $user_rank = $game_records->where('score', '>=', $user_record->score)->count();
                $user_record_array = $user_record->getRecordArray();
                $user_record_array["rate"] = $user_rank;
                array_push($result['leaderboard']['record'], $user_record_array);
            }
        }
        $xml = ArrayToXml::convert($this->makeResponseArray($result), 'response');
        return response($xml, '200')->header('Content-Type', 'text/xml');
    }

    public function game_comments(Request $request)
    {
        $gameName = $request->name;
        $comments_offset = $request->offset;
        if (!$comments_offset) {
            $comments_offset = 0;
        }
        $result = [];
        $result['comments'] = [];
        $game_comments = Game::where('title', $gameName)->first()->comments()->orderBy('updated_at', 'desc')->take(rand(1, 3))->skip($comments_offset)->get();
        if ($game_comments->first()) {
            $result['comments']['comment'] = [];
        }

        foreach ($game_comments as $comment) {
            array_push($result['comments']['comment'], $comment->getCommentArray());
        }
        $xml = ArrayToXml::convert($this->makeResponseArray($result), 'response');
        return response($xml, '200')->header('Content-Type', 'text/xml');
    }

    public function game_related(Request $request)
    {
        $gameName = $request->name;
        $this_game = Game::where('title', $gameName)->first();
        $game_categories = $this_game->categories()->get();
        $related_games = [];
        $added_games = [];
        foreach ($game_categories as $category) {
            $category_games = $category->games()->get();
            foreach ($category_games as $game) {
                if (($this_game->id != $game->id) && !in_array($game->id, $added_games, true)) {
                    array_push($related_games, $game->getGameArray());
                    array_push($added_games, $game->id);
                }
            }
        }
        $result = [];
        $result['games'] = [];
        if (!empty($added_games)) {
            $result['games']['game'] = $related_games;
        }
        $xml = ArrayToXml::convert($this->makeResponseArray($result), 'response');
        return response($xml, '200')->header('Content-Type', 'text/xml');
    }

    public function add_comment(Request $request)
    {
        $game_id = Game::where('title', $request->game_title)->first()->id;
        $comment = Comment::where('user_id', (integer)$request->user_id)->where('game_id', $game_id)->first();
        if (!$comment) {
            $comment = new Comment();
            $comment->user_id = (integer)$request->user_id;
            $comment->game_id = $game_id;
        }
        $comment->text = e($request->text);
        if ($request->rate && (integer)e($request->rate)>=0 && (integer)e($request->rate)<=5) {
            $comment->rate = (integer)e($request->rate);
        }
        $comment->save();
        return Redirect::to('/game_page?game_title=' . $request->game_title . '&tab=2');
//        $rules = array(
//            'text' => 'required',
//        );
//        $validator = Validator::make(Input::all(), $rules);
//        if(!$validator->fails()){
//            echo Input::get('text');
//        }
    }

    public function minesweeper(Request $request)
    {
        $level = (int)json_decode($request->level);
        $score = 100 * ($level - 1) + (int)json_decode($request->score);
        $game_id = Game::where('title', 'minesweeper')->first()->id;
        $record = Record::where('user_id', Auth::id())->where('game_id', $game_id)->first();
        if ($record) {
            if ($score > $record->score) {
                $record->score = $score;
                $record->level = $level;
                $record->displacement = rand(-2, 3);
                $record->save();
                return 'success';
            }

        } else {
            $record = new Record();
            $record->user_id = Auth::id();
            $record->game_id = $game_id;
            $record->displacement = rand(-2, 3);
            $record->score = $score;
            $record->level = $level;
            $record->save();
            return 'success';
        }
        return 'fail';
    }
}
