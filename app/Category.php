<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Place;

class Category extends Model
{
	use SoftDeletes;
	
    protected $guarded = [];

    public function children(){
    	return $this->belongTo(Category::class, 'parent_id', 'id');
    }

    public function parent(){
    	return $this->belongTo(Category::class, 'parent_id', 'id');
    }

    public function places(){
    	return $this->hasMany(Place::class,'category_id','id');
    }
}
