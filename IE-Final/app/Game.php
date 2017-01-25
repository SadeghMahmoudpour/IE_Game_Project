<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'title', 'abstract', 'info', 'large-image', 'small-image',
    ];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function records()
    {
        return $this->hasMany('App\Record');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_game', 'game_id', 'category_id');
    }

    public function getGameArray()
    {
        $gameArr = $this->toArray();
        $gameArr['rate'] = 0;
        $rate = $this->comments()->avg('rate');
        if($rate) {
            $gameArr['rate'] = $this->comments()->avg('rate');
        }
        $gameArr['number_of_comments'] = $this->comments()->count();
        $gameArr['categories']=[];
        $categories = $this->categories()->pluck('name')->toArray();
        if(!empty($categories)) {
            $gameArr['categories']['category'] = $this->categories()->pluck('name')->toArray();
        }
        return $gameArr;
    }

    public function getTutorialArray()
    {
        $tutorialArr = [];
        $tutorialArr['title'] = $this->title;
        $tutorialArr['date'] = $this->updated_at;
        $tutorialArr['game'] = $this->getGameArray();
        return $tutorialArr;
    }
}
