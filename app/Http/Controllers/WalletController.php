<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("wallet.index", [
            "wallets"=>$request->user()->wallets->where('is_deleted', 0)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("wallet.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'unique:wallets,name,NULL,id,user_id,' . $request->user()->id]
        ]);

        Wallet::create(
            [
                "name" => $request->name,
                "wallet_address" => $this->generateWalletAddress(),
                "user_id" => $request->user()->id
            ]
        );

        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet) {
        $this->checkAccess($request, $wallet);
        return $wallet->update(['is_deleted' => '1']);
    }

    public function view(Wallet $wallet, Request $request) {
        $this->checkAccess($request, $wallet);
        return view("wallet.view", [
            "wallet" => $wallet,
            "transactions" => $wallet->transactions->where("is_deleted", 0)
        ]);
    }

    private function generateWalletAddress()
    {
        $time = Carbon\Carbon::now();
        $hash = md5($time = Carbon\Carbon::now());

        while(count(Wallet::where('name', $hash)->get()) > 0){
            $time = Carbon\Carbon::now();
            $hash = md5($time = Carbon\Carbon::now());
        }

        return $hash;
    }

    public function renameWallet(Wallet $wallet, Request $request) {
        $this->checkAccess($request, $wallet);
        $this->validate($request,[
            'name' => ['required', 'unique:wallets,name,'.$wallet->id.',id,user_id,' . $request->user()->id]
        ]);

        return $wallet->update(['name' => $request->name]);
    }

    public function storeTransaction(Request $request, Wallet $wallet)
    {
        $this->checkAccess($request, $wallet);
        $this->validate($request,[
            'amount' => ['required','numeric','min:0.01'],
            'type' => ['required']
        ]);

        Transaction::create(
            [
                "amount" => $request->amount,
                "is_incoming" => $request->type,
                "wallet_id" => $wallet->id
            ]
        );

        return $request;
    }

    public function createTransaction(Request $request, Wallet $wallet)
    {
        $this->checkAccess($request, $wallet);
        return view("transaction.add", [
            "wallet"=>$wallet
        ]);
    }

    public function checkAccess(Request $request, Wallet $wallet){
        if($request->user()->id != $wallet->user_id) {
            return redirect()->route('unauthorized');
        }
    }
}
