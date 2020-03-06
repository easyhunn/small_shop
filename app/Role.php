<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $guarded = [];

    function users() {
    	return $this->belongsToMany(User::class);
    }
}
