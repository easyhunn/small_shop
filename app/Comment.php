<?php

namespace App;

use App\Like;
use App\Rating;
use App\Reply;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $guarded = [];
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function replies() {
    	return $this->hasMany(Reply::class);
    }
    public function getVote() {

    	return  optional(Rating::where('user_id',$this->user_id)
    					->where('product_id',$this->product_id)
    					->get()->first())->value;
    }

    public function likes() {
    	return $this->hasMany(Like::class);
    }

    public function liked() {
    	if(optional($this->likes()->where('user_id',Auth::user()->id)->first())->like == 1) {
    		return true;
    	} else {
    		return false;
    	}
    }

}
