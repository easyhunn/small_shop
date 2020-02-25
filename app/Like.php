<?php

namespace App;

use App\Comment;
use App\User;
use Illuminate\Database\Eloquent\Concerns\belongsTo;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    protected $guarded = [];

    function comment() {
    	return $this->belongsTo(Comment::class); 
    }

    function user() {
    	return $this->belongsTo(User::class);
    }
}
