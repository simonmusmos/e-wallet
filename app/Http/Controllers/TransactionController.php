<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Wallet $wallet, Request $request)
    {
        if($request->type == "incoming") {
            return $wallet->transactions->where("is_deleted", 0)->where("is_incoming", 1);
        } elseif($request->type == "outgoing") {
            return $wallet->transactions->where("is_deleted", 0)->where("is_incoming", 0);
        } else {
            return $wallet->transactions->where("is_deleted", 0);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Wallet $wallet)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Wallet $wallet)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        $this->checkAccess($request, $transaction);
        return $transaction->update(['is_deleted' => '1']);
    }

    public function markAsFraudulent(Transaction $transaction, Request $request) {
        $this->checkAccess($request, $transaction);
        return $transaction->update(['is_fraudulent' => '1']);
    }

    public function checkAccess(Request $request, Transaction $transaction){
        if($request->user()->id != $transaction->wallet->user_id) {
            return redirect()->route('unauthorized');
        }
    }
}
