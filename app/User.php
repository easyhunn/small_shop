<?php

namespace App;

use App\AuxiliaryCart;
use App\Cart;
use App\Comment;
use App\Like;
use App\Process;
use App\Rating;
use App\Reply;
use App\Role;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    function comments() {
        return $this->hasMany(Comment::class);
    }
    function rates() {
        return $this->hasMany(Rating::class);
    }
    function replies() {
        return $this->hasMany(Reply::class);
    }
    function likes() {
        return $this->hasMany(Like::class);
    }
    function carts() {
        return $this->hasMany(Cart::class);
    }
    function AuxiliaryCarts() {
        return $this->hasMany(AuxiliaryCart::class);
    }
    function Process() {
        return $this->hasMany(Process::class);
    }
    function Roles() {
        return $this->belongsToMany(Role::class);
    }
}
