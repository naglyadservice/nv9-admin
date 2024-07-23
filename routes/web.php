<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//\URL::forceScheme('https');

Route::get('/', function () {
    return redirect('/login');
});

//Route::get('/check', 'App\Http\Controllers\CheckController@check')->name('check');
Route::get('/user/{userHash}', 'App\Http\Controllers\CheckController@user_page')->name('user_page');
Route::get('/check/{hash}', 'App\Http\Controllers\CheckController@check_hash')->name('check_hash');
Route::get('/partner/{hash}', 'App\Http\Controllers\CheckController@check_partner')->name('check_partner_hash');
Route::get('/check/{hash}/reserve_payment', 'App\Http\Controllers\CheckController@ajax_reserve_payment')->name('ajax_reserve_payment');
Route::get('/check/{hash}/check_allow_payment', 'App\Http\Controllers\CheckController@ajax_check_allow_payment')->name('ajax_check_allow_payment');
Route::post('/check/{hash}/payment', 'App\Http\Controllers\CheckController@go_payment')->name('go_payment');
Route::any('/payment/liqpay/callback', 'App\Http\Controllers\CheckController@liqpay_callback')->name('payment.liqpay.callback');
Route::any('/payment/monopay/callback', 'App\Http\Controllers\CheckController@monopay_callback')->name('payment.monopay.callback');
Route::any('/payment/monoqr/callback', function(){
    $data = file_get_contents("php://input");
    file_put_contents("monoqr.txt", $data);
});

Route::get('/privacy-policy/{id}', 'App\Http\Controllers\CheckController@privacyPolicy')->name('privacy-policy');
Route::get('/about-us/{id}', 'App\Http\Controllers\CheckController@aboutUs')->name('about-us');
Route::get('/oferta/{id}', 'App\Http\Controllers\CheckController@oferta')->name('oferta');

Route::get('temp-receipt/{hash}/{id}', 'App\Http\Controllers\CheckController@tempReceipt')->name('temp-receipt');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /* Devices */
    Route::prefix('devices')->group(function (){

        Route::get('/', 'App\Http\Controllers\DevicesController@index')->name('devices');
        Route::post('/{device}/delete', 'App\Http\Controllers\DevicesController@delete')->name('devices.delete');
        Route::get('/add', 'App\Http\Controllers\DevicesController@add')->name('devices.add');
        Route::post('/add', 'App\Http\Controllers\DevicesController@add_save')->name('devices.add_save');
        Route::get('/{device}/edit', 'App\Http\Controllers\DevicesController@edit')->name('devices.edit');
        Route::post('/{device}/edit', 'App\Http\Controllers\DevicesController@edit_save')->name('devices.edit_save');
        Route::post('/{device}/edit_fiscalization', 'App\Http\Controllers\DevicesController@edit_fiscalization')->name('devices.edit_fiscalization');
        Route::post('/{device}/edit_payment', 'App\Http\Controllers\DevicesController@edit_payment')->name('devices.edit_payment');

    });

    /* Partners */
    Route::prefix('partners')->group(function (){

        Route::get('/', 'App\Http\Controllers\PartnersController@index')->name('partners');
        Route::post('/{partner}/delete', 'App\Http\Controllers\PartnersController@delete')->name('partners.delete');
        Route::get('/add', 'App\Http\Controllers\PartnersController@add')->name('partners.add');
        Route::post('/add', 'App\Http\Controllers\PartnersController@add_save')->name('partners.add_save');
        Route::get('/{partner}/edit', 'App\Http\Controllers\PartnersController@edit')->name('partners.edit');
        Route::post('/{partner}/edit', 'App\Http\Controllers\PartnersController@edit_save')->name('partners.edit_save');
        Route::post('/{user}/edit_fiscalization', 'App\Http\Controllers\PartnersController@edit_fiscalization')->name('partners.edit_fiscalization');
        Route::post('/{user}/edit_payment', 'App\Http\Controllers\PartnersController@edit_payment')->name('partners.edit_payment');

    });

    /* Fiscalization */
    Route::prefix('fiscalization')->group(function (){
        Route::get('/', 'App\Http\Controllers\FiscalizationController@index')->name('fiscalization');
        Route::post('/{key}/delete', 'App\Http\Controllers\FiscalizationController@delete')->name('fiscalization.delete');
        Route::get('/add', 'App\Http\Controllers\FiscalizationController@add')->name('fiscalization.add');
        Route::post('/add', 'App\Http\Controllers\FiscalizationController@save')->name('fiscalization.add');
        Route::get('/{key}/edit', 'App\Http\Controllers\FiscalizationController@edit')->name('fiscalization.edit');
        Route::post('/{key}/edit', 'App\Http\Controllers\FiscalizationController@edit_save')->name('fiscalization.edit_save');


    });

    Route::prefix('reports')->group(function (){
        Route::get('/', 'App\Http\Controllers\ReportsController@index')->name('reports');
    });

    Route::prefix('payment-gateways')->group(function (){
        Route::get('/', 'App\Http\Controllers\PaymentGatewayController@index')->name('payment-gateway.index');
        Route::post('/', 'App\Http\Controllers\PaymentGatewayController@add')->name('payment-gateway.add');
        Route::post('/{system}/delete', 'App\Http\Controllers\PaymentGatewayController@delete')->name('payment-gateway.delete');
    });

    Route::get('logout', 'App\Http\Controllers\Controller@logout')->name('account.logout');

});
