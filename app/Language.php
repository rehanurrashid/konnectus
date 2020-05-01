<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Place;

class Language extends Model
{
	use SoftDeletes;
	
    public function places(){
    	return $this->belongsToMany(Place::class,'place_languages','language_id','id');
    }
}
