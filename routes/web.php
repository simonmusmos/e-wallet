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
Route::group(['prefix' => 'customer'], function(){
    Route::get('/add', 'CustomerController@add')->name('customer.add');
    Route::post('/create', 'CustomerController@create')->name('customer.create');
    Route::get('/', 'CustomerController@index')->name('customer.get');
    Route::get('/edit/{customer_id}', 'CustomerController@edit')->name('customer.edit');
    Route::post('/update/{customer_id}', 'CustomerController@update')->name('customer.update');
});

Route::group(['prefix' => 'supplier'], function(){
    Route::get('/add', 'SupplierController@add')->name('supplier.add');
    Route::post('/create', 'SupplierController@create')->name('supplier.create');
    Route::get('/', 'SupplierController@index')->name('supplier.get');
    Route::get('/edit/{supplier_id}', 'SupplierController@edit')->name('supplier.edit');
    Route::post('/update/{supplier_id}', 'SupplierController@update')->name('supplier.update');
});

Route::group(['prefix' => 'wallet'], function(){
    Route::get('/add', 'WalletController@create')->name('wallet.add');
    Route::post('/create', 'WalletController@store')->name('wallet.create');
    Route::get('/', 'WalletController@index')->name('wallet.get');
    Route::get('/{wallet}', 'WalletController@view')->name('wallet.view');
    Route::post('/{wallet}/remove-wallet', 'WalletController@destroy')->name('wallet.remove-wallet');
    Route::post('/{wallet}/rename', 'WalletController@renameWallet')->name('wallet.rename');
    Route::get('/{wallet}/send', 'WalletController@sendMoney')->name('wallet.send');
    Route::post('/{wallet}/process', 'WalletController@processSendMoney')->name('wallet.process-send');
    // Route::get('/edit/{supplier_id}', 'SupplierController@edit')->name('supplier.edit');
    // Route::post('/update/{supplier_id}', 'SupplierController@update')->name('supplier.update');
});

Route::group(['prefix' => 'transaction'], function(){
    Route::get('/{wallet}/add', 'WalletController@createTransaction')->name('transaction.add');
    Route::get('/{wallet}', 'TransactionController@index')->name('transaction.get');
    Route::post('/{wallet}/create', 'WalletController@storeTransaction')->name('transaction.create');
    Route::post('/{transaction}/mark-as-fraudulent', 'TransactionController@markAsFraudulent')->name('transaction.mark-as-fraudulent');
    Route::post('/{transaction}/remove-transaction', 'TransactionController@destroy')->name('transaction.remove-transaction');
    Route::get('/{transaction}/check-access', 'TransactionController@checkAccess');
});

Route::group(['prefix' => 'user'], function(){
    Route::get('/', 'UserController@index')->name('user.get');
});

Route::group(['prefix' => 'references'], function(){
    Route::get('/state/{country_id}', 'ReferenceController@state')->name('get.states');
    Route::get('/city/{state_id}', 'ReferenceController@city')->name('get.cities');
    Route::get('/generate-url/', 'ReferenceController@getURL')->name('reference.get-url');
});