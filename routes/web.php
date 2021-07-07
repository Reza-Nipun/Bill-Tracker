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

Route::get('/', 'Auth\LoginController@index');

Auth::routes(['register' => false]);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('plant', 'PlantController')->middleware('is_admin');
    Route::resource('user', 'UserController')->middleware('is_admin');
    Route::resource('currency', 'CurrencyController')->middleware('is_admin');

    Route::resource('bill', 'BillController');
    Route::post('/search_bill', 'BillController@searchBill')->name('search_bill');
    Route::post('/return_to_ap', 'BillController@returnToAP')->name('return_to_ap');
    Route::post('/receipt_by_tr', 'BillController@receiptByTR')->name('receipt_by_tr');
    Route::post('/payment_proposal', 'BillController@paymentProposal')->name('payment_proposal');
    Route::post('/payment_approval', 'BillController@paymentApproval')->name('payment_approval');
    Route::post('/cheque_print', 'BillController@chequePrint')->name('cheque_print');
    Route::post('/cheque_handover', 'BillController@chequeHandover')->name('cheque_handover');

});
