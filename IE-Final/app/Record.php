<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'score', 'level', 'displacement',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function getRecordArray(){
        $recordArr = $this->toArray();
        $recordArr['player'] = $this->user()->first()->getUserArray();
        return $recordArr;
    }
}
