<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'category_user', 'user_id', 'game_id');
    }

    public function games()
    {
        return $this->belongsToMany('App\Game', 'category_game', 'category_id', 'game_id');
    }
}
