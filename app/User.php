<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\PasswordResetNotification;
use Laravel\Passport\HasApiTokens;
use App\UserProfile;
use App\Place;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(){
        return $this->hasOne(UserProfile::class); 
    }

    // public function comment(){
    //     return $this->hasOne(Comment::class,'user_id','id');
    // }

    public function total_places(){
        return $this->hasMany(Place::class,'user_id','id')->with('category');
    }

    public function disapproved_places(){
        return $this->hasMany(Place::class,'user_id','id')->where('status', 0);
    }

    public function approved_places(){
        return $this->hasMany(Place::class,'user_id','id')->where('status', 1);
    }

    public function total_services(){
        return $this->hasMany(Service::class,'user_id','id')->with('category');
    }

    public function disapproved_services(){
        return $this->hasMany(Service::class,'user_id','id')->where('status', 0);
    }

    public function approved_services(){
        return $this->hasMany(Service::class,'user_id','id')->where('status', 1);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

}
