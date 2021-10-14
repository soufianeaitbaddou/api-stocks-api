<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('product', 'Products\ProductController', ['except' => ['create', 'edit']]);
Route::resource('stock', 'Stocks\StockController', ['except' => ['create', 'edit']]);
Route::resource('order', 'Orders\OrderController', ['except' => ['create', 'edit']]);
Route::post('orderWithClient', 'Orders\OrderController@storeWithClient');
Route::get('stats', 'StatsController@index');
Route::resource('client', 'Clients\ClientController', ['except' => ['create', 'edit']]);
