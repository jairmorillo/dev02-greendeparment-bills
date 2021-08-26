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

Auth::routes();
// Authentication routes...
Route::get('/','DashboardController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->middleware('AuthAdmin');
Route::get('/dashboard/profit', 'DashboardController@profit');
Route::get('/dashboard/profitmonth', 'DashboardController@profitmonth');
Route::get('/dashboard/profityear', 'DashboardController@profityear');
Route::get('/dashboard/profittoday', 'DashboardController@profittoday');
Route::get('/dashboard/customercount', 'DashboardController@customercount');  
Route::get('/dashboard/billscount', 'DashboardController@billscount');
Route::get('/dashboard/billscountyear', 'DashboardController@billscountyear');

Route::get('/dashboard/profitrecordmonththisyear', 'DashboardController@profitrecordmonththisyear'); 
Route::get('/dashboard/Profile', 'DashboardController@Profile');
Route::get('/dashboard/lastyeargan', 'DashboardController@lastyeargan');  
Route::get('/dashboard/profitrecordmonthlastyear', 'DashboardController@profitrecordmonthlastyear'); 
Route::get('/dashboard/billscountlastyear', 'DashboardController@billscountlastyear');
Route::get('/dashboard/money', 'DashboardController@month_incoming_money')->name('dashboard.money');;

// Registration routes...
//Route::get('/register', 'Auth\RegisterController@index');
//Route::post('/register', 'Auth\RegisterController@create');

Route::resource('/services','ServicesController@index')->middleware('AuthAdmin');
Route::post('/services/search','ServicesController@search');
Route::resource('/services','ServicesController');

Route::resource('/users','UsersController@index')->middleware('AuthAdmin');
Route::resource('/users','UsersController');



Route::resource('/bill','BillController@index')->middleware('AuthAdmin');
Route::resource('/bill','BillController');
//POST
Route::post('/bill/status', 'BillController@status')->name('bill.status');
Route::post('/bill/delet', 'BillController@delet')->name('bill.delete');
Route::post('/bill/deletpay', 'BillController@partial_payment_delet')->name('bill.deletepay');
Route::post('/bill/parialpay', 'BillController@partial_payment_store')->name('bill.parialpay');
//GET
Route::get('/bill/billcustomer/{id}', 'BillController@billcustomer')->name('bill.billcustomer');
Route::get('/bill/partialpaylis/{id}', 'BillController@partial_payment_list')->name('bill.partial_payment_list');
Route::get('/bill/notificactionpartialpay/{id}', 'BillController@notification_payment_pending')->name('bill.notification_payment_pending');


Route::resource('/billservises','BillServicesController@index');
Route::resource('/billservises','BillServicesController');


Route::get('pdf/invoice/{id}','PdfController@invoice'); // 1
Route::get('pdf/preview','PdfController@preview'); //2 pdf/
Route::get('pdf/previewresquest','PdfController@previewresquest');
Route::get('pdf/request/{id}','PdfController@request'); // 1
Route::get('pdf/monthprofit','PdfController@monthprofit'); // 1
Route::get('pdf/anualprofit','PdfController@anualprofit'); // 1


Route::get('/customer','CustomerController@index');
Route::post('/customer/search','CustomerController@search');
Route::resource('/customer','CustomerController');


Route::resource('/request','Purchase_requestController@index')->middleware('AuthAdmin');
Route::resource('/request','Purchase_requestController');
Route::post('/request/status', 'Purchase_requestController@status')->name('request.status');
Route::post('/request/delet', 'Purchase_requestController@delet')->name('request.delete');


Route::resource('/items','Item_requestController@index')->middleware('AuthAdmin');
Route::post('/items/search','Item_requestController@search');
Route::resource('/items','Item_requestController');


Route::resource('/requestitem','Request_itemController@index');
Route::resource('/requestitem','Request_itemController');



Route::post('/email/estimate_1', 'EmailController@estimate_part_one')->name('bill.estimateone');
Route::post('/email/estimate_2', 'EmailController@estimate_part_two')->name('bill.estimatetwo');


Route::get('/pay/{token}','PaymentController@pay')->name('pay');
Route::post('/dopay/online', 'PaymentController@handleonlinepay')->name('dopay.online');



/*
Route::get('/transaction','PaymentTransactionController@index')->name('listras');
Route::get('/transaction/create','PaymentTransactionController@create')->name('createtras');
Route::post('/transaction/create', 'PaymentTransactionController@store')->name('storetras');
*/

Route::resource('/transaction','PaymentTransactionController');
Route::get('/transaction/show/{id}','PaymentTransactionController@show')->name('pay');


Route::get('/token', function () {
    return csrf_token(); 
});