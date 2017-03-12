<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('img/{filename}', function ($filename) {
    $path = storage_path('app/'.$filename.'.png');

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header('Content-Type', $type);

    return $response;
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '{raffle}'], function() {

    Route::get('', [
        'as'   => 'raffle.home',
        'uses' => 'RaffleController@home',
    ]);
    
    Route::get('/purchases', [
        'as'   => 'raffle.purchases',
        'uses' => 'PurchaseController@index',
    ]);

    Route::get('/coupons', [
        'as'   => 'coupons.browse',
        'uses' => 'CouponsController@browse',
    ]);

    Route::get('/status/{numbers}', [
        'as'   => 'coupons.status',
        'uses' => 'CouponsController@status',
    ]);

    Route::post('/confirm', [
        'as'   => 'coupons.confirm',
        'uses' => 'CouponsController@confirm',
    ]);

    Route::get('/checkout', [
        'as'   => 'coupons.checkout',
        'uses' => 'CouponsController@checkout',
    ]);

    Route::get('/purchase/{hash}', [
        'as'   => 'coupons.purchase',
        'uses' => 'PurchaseController@status',
    ]);

    Route::post('/directconfirm', [
        'as'   => 'coupons.directconfirm',
        'uses' => 'SinglepageController@directconfirm',
    ]);

    ////////////////
    // Backoffice //
    ////////////////

    Route::get('/backoffice/purchases/{password}', [
        'as'   => 'backoffice.purchases',
        'uses' => 'Backoffice\PurchaseController@index',
    ]);

});

Route::get('/coupons/add/{number}', [
    'as'   => 'coupons.add',
    'uses' => 'CouponsController@add',
]);

Route::get('/coupons/reset', [
    'as'   => 'coupons.reset',
    'uses' => 'CouponsController@reset',
]);
