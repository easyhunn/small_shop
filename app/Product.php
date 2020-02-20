<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = [];

    public function catagory() {
    	return $this->belongsTo(Catagory::class);
    }
    
    public function users() {
    	return $this->belongsToMany(User::class);
    }

}
