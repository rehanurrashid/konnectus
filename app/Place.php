<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\PlacePhoto;
use App\PlaceRating;
use App\User; 
use App\Category;
use App\Language;

class Place extends Model
{
	use SoftDeletes;

    protected $fillable = ['user_id', 'slug', 'category_id','name','tags','phone','address','longitude','latitude','from_time','to_time','country_code'];

	protected $guard = [];

	public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function setSlugAttribute($slug)
    {
        $slug = Str::slug( $slug );
        $slugs = $this->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'");

        if ($slugs->count() === 0) {
            $this->attributes['slug'] = $slug;
        }
        else{   
            // Get the last matching slug
            $lastSlug = $slugs->orderBy('slug', 'desc')->first()->slug;
        
            // Strip the number off of the last slug, if any
            $lastSlugNumber = intval(str_replace($slug . '-', '', $lastSlug));
        
            // Increment/append the counter and return the slug we generated
            $this->attributes['slug'] = $slug . '-' . ($lastSlugNumber + 1);
        }
    }

    public function rating()
    {
        return $this->hasMany(PlaceRating::class, 'place_id','id')->with('user');
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'place_languages', 'place_id', 'language_id');
    }

    public function photos(){
        return $this->hasMany(PlacePhoto::class);
    }
}
