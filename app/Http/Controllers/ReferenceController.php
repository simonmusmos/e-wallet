<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;

class ReferenceController extends Controller
{
    public function state($country_id){
        $country_info = Country::where('id', $country_id)->first();
        return $country_info->states;
    }

    public function city($state_id){
        $state_info = State::where('id', $state_id)->first();
        return $state_info->cities;
    }

    public function getURL(Request $request){
        return route($request->type, $request->id);
    }
}
