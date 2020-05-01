<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlacePhoto extends Model
{
    protected $fillable = ['place_id', 'photo'];

    public function place()
    {
        return $this->belongsTo('App\Place');
    }
}
