<?php

namespace App;

use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    //
    protected $guarded = [];
    function user () {
    	return $this->hasOne(User::class);
    }
    function product () {
    	return $this->hasOne(Product::class);
    }
}
