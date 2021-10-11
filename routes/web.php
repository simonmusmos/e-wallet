<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/unauthorized', function(){
    return view('unauthorized');
})->name('unauthorized');

Route::group(['prefix' => 'wallet', 'middleware' => ['auth:web']], function(){
    Route::get('/add', 'WalletController@create')->name('wallet.add');
    Route::post('/create', 'WalletController@store')->name('wallet.create');
    Route::get('/', 'WalletController@index')->name('wallet.get');
    Route::get('/open-request', 'WalletController@openRequest')->name('wallet.open-request');
    Route::post('/process-request', 'WalletController@processRequest')->name('wallet.process-request');
    
    Route::group(['prefix' => '{wallet}'], function(){
        Route::get('/', 'WalletController@view')->name('wallet.view');
        Route::get('/request', 'WalletController@requestMoney')->name('wallet.request');
        Route::post('/generate-request', 'WalletController@generateRequestMoneyToken')->name('wallet.generate-request');
        Route::post('/remove-wallet', 'WalletController@destroy')->name('wallet.remove-wallet');
        Route::post('/rename', 'WalletController@renameWallet')->name('wallet.rename');
        Route::get('/send', 'WalletController@sendMoney')->name('wallet.send');
        Route::post('/process', 'WalletController@processSendMoney')->name('wallet.process-send');
    });
});

Route::group(['prefix' => 'transaction', 'middleware' => ['auth:web']], function(){
    Route::group(['prefix' => '{wallet}'], function(){
        Route::get('/add', 'WalletController@createTransaction')->name('transaction.add');
        Route::get('/', 'TransactionController@index')->name('transaction.get');
        Route::post('/create', 'WalletController@storeTransaction')->name('transaction.create');
    });
    
    Route::group(['prefix' => '{transaction}'], function(){
        Route::post('/{mark-as-fraudulent', 'TransactionController@markAsFraudulent')->name('transaction.mark-as-fraudulent');
        Route::post('/remove-transaction', 'TransactionController@destroy')->name('transaction.remove-transaction');
        Route::get('/check-access', 'TransactionController@checkAccess');
    });
    
});

Route::group(['prefix' => 'references'], function(){
    Route::get('/generate-url/', 'ReferenceController@getURL')->name('reference.get-url');
});