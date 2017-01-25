<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'text', 'rate',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function getCommentArray()
    {
        $commentArr = $this->toArray();
        $commentArr['date'] = $this->updated_at;
        $commentArr['player'] = $this->user()->first()->getUserArray();
        $commentArr['game'] = $this->game()->first()->getGameArray();
        return $commentArr;
    }
}
