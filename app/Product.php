<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function public_path () {
    	return url('/product/'.$this->id."-".Str::slug($this->product_name));
    }

}
