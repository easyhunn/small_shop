<?php

namespace App;

use App\Product;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $guarded = [];
    function user () {
    	return $this->belongsTo(User::class);
    }
    function product () {
    	return $this->belongsTo(Product::class);
    }

}
