<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = [];

    public function catagory() {
    	$this->belongsTo(Catagory::class);
    }

}
