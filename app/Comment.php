<?php

namespace App;

use App\Rating;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $guarded = [];
    public function user() {
    	return $this->belongsTo(User::class);
    }
    public function getVote() {

    	return  optional(Rating::where('user_id',$this->user_id)
    					->where('product_id',$this->product_id)
    					->get()->first())->value;
    }
}
