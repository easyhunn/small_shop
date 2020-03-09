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
    function getStatus () {
    	switch ($this->status) {
    		case 0:
    			return 'in queue';
    			break;
    		case 1:
    			return 'in cart';
    			break;
    		case 2:
    			return 'in processing';
    			break;
    		default:
    			return 'finish';
    			break;
    	}
    }
    function process_patch () {
    	return url('process/'.Auth::user()->id);
    }
}
