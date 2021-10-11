<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\RequestToken;
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
    public function destroy(Wallet $wallet, Request $request) {
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

    private function generateRequestToken()
    {
        $time = Carbon\Carbon::now();
        $hash = md5($time = Carbon\Carbon::now());

        while(count(RequestToken::where('token', $hash)->get()) > 0){
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

    public function sendMoney(Request $request, Wallet $wallet)
    {
        $this->checkAccess($request, $wallet);
        return view("wallet.send", [
            "wallet"=>$wallet
        ]);
    }

    public function processSendMoney(Request $request, Wallet $wallet)
    {
        $this->checkAccess($request, $wallet);
        $this->validate($request,[
            'amount' => ['required','numeric','min:0.01','max:'.number_format((float)$wallet->transactions->where("is_deleted",0)->where("is_incoming",1)->sum("amount"), 2, '.', '')]
        ]);

        $receiver = Wallet::where('wallet_address', $request->address)->first();

        if($receiver) {
            Transaction::create(
                [
                    "amount" => $request->amount,
                    "is_incoming" => 1,
                    "wallet_id" => $receiver->id,
                    "other_wallet" => $wallet->id
                ]
            );

            Transaction::create(
                [
                    "amount" => $request->amount,
                    "is_incoming" => 0,
                    "wallet_id" => $wallet->id,
                    "other_wallet" => $receiver->id
                ]
            );
            
            return ["result" => true];
        }else{
            return ["result" => false, "message" => $request];
        }
    }

    public function openRequest(Request $request){
        $token = RequestToken::where('token', $request->token)->first();
        return view("wallet.select-wallet", [
            "wallets"=>$request->user()->wallets->where('is_deleted', 0),
            "token"=>$token
        ]);
    }

    public function processRequest(Request $request){
        $token = RequestToken::where('token', $request->token)->where('is_usable', 1)->first();
        $sendingWallet = Wallet::where('id', $request->id)->first();

        if(!$token) {
            return ["result" => false, "message" => "Token is invalid or already used."];
        }
        
        if(!$sendingWallet) {
            return ["result" => false, "message" => "Selected wallet is invalid."];
        }

        if((number_format((float)$sendingWallet->transactions->where("is_deleted",0)->where("is_incoming",1)->sum("amount"), 2, '.', '') - number_format((float)$sendingWallet->transactions->where("is_deleted",0)->where("is_incoming",0)->sum("amount"), 2, '.', '')) < $token->amount){
            return ["result" => false, "message" => "Insufficient Balance."];
        }
        
        Transaction::create(
            [
                "amount" => $token->amount,
                "is_incoming" => 1,
                "wallet_id" => $token->wallet_id,
                "other_wallet" => $sendingWallet->id
            ]
        );

        Transaction::create(
            [
                "amount" => $token->amount,
                "is_incoming" => 0,
                "wallet_id" => $sendingWallet->id,
                "other_wallet" => $token->wallet_id
            ]
        );

        $token->update(["is_usable" => 0]);

        return ["result" => true, "url" => route("wallet.view", $sendingWallet->id)];
    }


    public function requestMoney(Request $request, Wallet $wallet)
    {
        $this->checkAccess($request, $wallet);
        return view("wallet.request", [
            "wallet"=>$wallet
        ]);
    }

    public function generateRequestMoneyToken(Request $request, Wallet $wallet)
    {
        $this->checkAccess($request, $wallet);
        $this->validate($request,[
            'amount' => ['required','numeric','min:0.01']
        ]);
        $token = $this->generateRequestToken();
        
        RequestToken::create(
            [
                "amount" => $request->amount,
                "token" => $token,
                "is_usable" => 1,
                "wallet_id" => $wallet->id
            ]
        );
            
        return ["result" => true, "link" => route('wallet.open-request') . '?token=' . $token, "url" => route("wallet.view", $wallet->id)];
    }

    public function checkAccess(Request $request, Wallet $wallet){
        if($request->user()->id != $wallet->user_id) {
            return redirect()->route('unauthorized');
        }
    }
}
