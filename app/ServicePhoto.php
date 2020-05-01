<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePhoto extends Model
{
    protected $fillable = ['service_id', 'photo'];

    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
