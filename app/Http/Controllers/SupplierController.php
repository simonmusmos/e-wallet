<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(){
        $suppliers = Supplier::get();
        return view("supplier.index", [
            "suppliers"=>$suppliers
        ]);
    }

    public function add(){
        // dd(213);
        $countries = Country::get();
        return view("supplier.add", [
            "countries"=>$countries
        ]);
    }

    public function create(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'supplier_code'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'city'=>'required',
            'country'=>'required',
            'state'=>'required',
        ]);

        Supplier::create(
            [
                "name" => $request->name,
                "supplier_code" => $request->supplier_code,
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

    public function edit($supplier_id){
        $supplier = Supplier::find($supplier_id);
        $countries = Country::get();
        return view("supplier.edit", [
            "supplier"=>$supplier,
            "countries"=>$countries
        ]);
    }

    public function update($supplier_id, Request $request){
        $this->validate($request,[
            'name'=>'required',
            'supplier_code'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'city'=>'required',
            'country'=>'required',
            'state'=>'required',
        ]);

        $supplier = Supplier::where('id', $supplier_id)->update([
            "name" => $request->name,
            "supplier_code" => $request->supplier_code,
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
