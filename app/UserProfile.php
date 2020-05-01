<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserProfile extends Model
{
	protected $fillable = [
        'user_id', 'address', 'city','country','country_code','phone','photo','gender','dob'
    ];

    protected $guard = [];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
