<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::get();
        return view("customer.index", [
            "customers"=>$customers
        ]);
    }

    public function add(){
        // dd(213);
        $countries = Country::get();
        return view("customer.add", [
            "countries"=>$countries
        ]);
    }

    public function create(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'city'=>'required',
            'country'=>'required',
            'state'=>'required',
        ]);

        Customer::create(
            [
                "name" => $request->name,
                "phone" => $request->phone,
                "address" => $request->address,
                "email" => $request->email,
                "country_id" => $request->country,
                "city_id" => $request->city,
                "state_id" => $request->state,
            ]
        );

        return $request;
    }

    public function edit($customer_id){
        $customer = Customer::find($customer_id);
        $countries = Country::get();
        return view("customer.edit", [
            "customer"=>$customer,
            "countries"=>$countries
        ]);
    }

    public function update($customer_id, Request $request){
        $this->validate($request,[
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'city'=>'required',
            'country'=>'required',
            'state'=>'required',
        ]);

        $customer = Customer::where('id', $customer_id)->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "address" => $request->address,
            "email" => $request->email,
            "country_id" => $request->country,
            "city_id" => $request->city,
            "state_id" => $request->state,
        ]);

        return $request;
    }
}
