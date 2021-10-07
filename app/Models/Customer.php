<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'country_id',
        'city_id',
        'state_id'
    ];

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }

    public function state(){
        return $this->belongsTo('App\Models\State');
    }

    public function city(){
        return $this->belongsTo('App\Models\City');
    }
}
