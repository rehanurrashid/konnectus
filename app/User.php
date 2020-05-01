<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\PasswordResetNotification;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use App\UserProfile;
use App\ServiceRating;
use App\PlaceRating;
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
        'name', 'email', 'password','verification_code','phone_verified_at'
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

    protected $appends = [
        'myReviewsCount',
        // 'rateCount'
    ];

    public function profile(){
        return $this->hasOne(UserProfile::class); 
    }

    // public function comment(){
    //     return $this->hasOne(Comment::class,'user_id','id');
    // }

    public function total_places(){
        return $this->hasMany(Place::class,'user_id','id')->with(['category','photos'])->withCount('rating');
    }

    public function disapproved_places(){
        return $this->hasMany(Place::class,'user_id','id')->where('status', 0);
    }

    public function approved_places(){
        return $this->hasMany(Place::class,'user_id','id')->where('status', 1);
    }

    public function total_services(){
        return $this->hasMany(Service::class,'user_id','id')->with(['category','photos']);
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

    public function service_reviews()
    {
        return $this->hasMany(ServiceRating::class, 'service_id','id');
    }

    public function place_reviews()
    {
        return $this->hasMany(PlaceRating::class, 'place_id','id');
    }

    public function getMyReviewsCountAttribute(){
        return $this->service_reviews()->count() + $this->place_reviews()->count();
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_users', 'user_id', 'category_id');
    }
}
