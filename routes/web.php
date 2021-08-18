<?php
use Illuminate\Support\Facades\Auth;
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
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

//
Route::post('Addnewissue/{id}', 'AssetsController@addnewissue')->name('addnewissue')->middleware('auth');
Route::post('postshopkeeper/{id}', 'AssetsController@postshopkeepers')->name('postshopkeeper')->middleware('auth');
Route::get('usedissueslistgroup/{id}','AssetsController@allissueslistgroup')->name('allissuesgroup')->middleware('auth');
Route::get('usedissueslist/{id}/{date}','AssetsController@allissueslist')->name('allissues')->middleware('auth');
Route::get('shopkeeper/{id}','AssetsController@shopkeepers')->name('shopkeeper')->middleware('auth');
Route::get('shopsadmin','AssetsController@shopsadmin')->name('shopsadmin')->middleware('auth');
Route::get('shops/{id}','AssetsController@shops')->name('shops')->middleware('auth');
Route::get('adddnewshop','AssetsController@newshopadd')->name('addshop')->middleware('auth');
Route::post('postnewshop/{id}', 'AssetsController@postnewshop')->name('addnewshop')->middleware('auth');
Route::get('dashboard','AssetsController@dashboard')->name('dashboard')->middleware('auth');
Route::get('adddairyissue/{id}','AssetsController@dairlyissueadd')->name('adddairyissue')->middleware('auth');
Route::get('addshopkeeper/{id}','AssetsController@addshopkeepers')->name('addshopkeeper')->middleware('auth');
Route::get('boughtissuess/{id}/{date}','AssetsController@biughtissueslist')->name('boughtissues')->middleware('auth');
Route::get('boughtissuessgroup/{id}','AssetsController@biughtissueslistgroup')->name('boughtissuesgroup')->middleware('auth');
Route::get('addboughtissue/{id}','AssetsController@boughts')->name('adddairyboughtissue')->middleware('auth');
Route::post('Addnewboughtissue/{id}', 'AssetsController@addnewbought')->name('addnewboughtissue')->middleware('auth');
Route::get('salesissuessgroup/{id}','AssetsController@salesissueslistgroup')->name('salesissuesgroup')->middleware('auth');
Route::get('salesissuess/{id}/{date}','AssetsController@salesissueslist')->name('salesissues')->middleware('auth');
Route::post('Addnewsale/{id}', 'AssetsController@addnewsale')->name('addnewsales')->middleware('auth');
Route::get('adddnewsaleissue/{id}','AssetsController@newsaleadd')->name('addsales')->middleware('auth');
Route::get('ammountaddedonshop/{id}/{date}','AssetsController@ammountadded')->name('ammountadded')->middleware('auth');
Route::get('ammountaddedonshopgroup/{id}','AssetsController@ammountaddedgroup')->name('ammountaddedgroup')->middleware('auth');
Route::get('adddamount/{id}','AssetsController@newamount')->name('addamount')->middleware('auth');
Route::post('addnewamount/{id}', 'AssetsController@addnewamount')->name('addnewamounts')->middleware('auth');
Route::get('transactionsgroup/{id}','AssetsController@alltransactionsgroup')->name('transactionsgroup')->middleware('auth');
Route::get('transactions/{id}/{date}','AssetsController@alltransactions')->name('transactions')->middleware('auth');
Route::get('vouchers/{id}/{date}','AssetsController@vouchers')->name('voucher')->middleware('auth');
Route::get('vouchersgroup/{id}','AssetsController@vouchersgroup')->name('vouchergroup')->middleware('auth');
Route::get('myshopsumarygroup/{id}','AssetsController@summarygroup')->name('summarygroup')->middleware('auth');
Route::get('myshopsumary/{id}/{date}','AssetsController@summary')->name('summary')->middleware('auth');
Route::get('update_transaction/{id}','AssetsController@updatetransaction')->name('updatetransaction')->middleware('auth');
Route::get('update_voucher/{id}','AssetsController@updatevoucher')->name('updatevoucher')->middleware('auth');
Route::post('updateamounts/{id}', 'AssetsController@updatemyamount')->name('updateammount')->middleware('auth');
Route::post('updatevouchers{id}', 'AssetsController@updatevoucherass')->name('updatevoucheradd')->middleware('auth');


