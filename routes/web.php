<?php

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

Route::resource('fees', 'FeeCollectionController');
Route::resource('classfee', 'FeesController');
Route::get('studentbyclass', 'FeeCollectionController@ajaxGetStudentByClass');
Route::get('feebyclass', 'FeeCollectionController@ajaxGetFeeByClass');
Route::get('feepayhistory', 'FeeCollectionController@ajaxCheckStuFeePaymentHistory');


Route::get('receipt_print', 'FeeCollectionController@ajaxTakePaymentPrintReceipt');