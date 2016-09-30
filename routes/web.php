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

Route::get('/{raffle}', [
    'as'   => 'raffle.home',
    'uses' => 'RaffleController@home',
]);

Route::get('/{raffle}/purchases', [
    'as'   => 'raffle.purchases',
    'uses' => 'PurchaseController@index',
]);

Route::get('/{raffle}/coupons', [
    'as'   => 'coupons.browse',
    'uses' => 'CouponsController@browse',
]);

Route::get('/{raffle}/status/{numbers}', [
    'as'   => 'coupons.status',
    'uses' => 'CouponsController@status',
]);

Route::post('/{raffle}/confirm', [
    'as'   => 'coupons.confirm',
    'uses' => 'CouponsController@confirm',
]);

Route::get('/{raffle}/checkout', [
    'as'   => 'coupons.checkout',
    'uses' => 'CouponsController@checkout',
]);

Route::get('/coupons/add/{number}', [
    'as'   => 'coupons.add',
    'uses' => 'CouponsController@add',
]);

Route::get('/coupons/reset', [
    'as'   => 'coupons.reset',
    'uses' => 'CouponsController@reset',
]);

Route::get('/{raffle}/purchase/{hash}', [
    'as'   => 'coupons.purchase',
    'uses' => 'PurchaseController@status',
]);
