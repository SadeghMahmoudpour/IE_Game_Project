<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'avatar', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'admin',
    ];

    public function comments()
    {
        return $this->hasMany('App\Comment', 'foreign_key');
    }

    public function records()
    {
        return $this->hasMany('App\Record', 'foreign_key');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_user', 'user_id', 'category_id');
    }

    public function getUserArray()
    {
        return $this->toArray();
    }

    public function isAdmin()
    {
        return $this->admin;
    }
}
