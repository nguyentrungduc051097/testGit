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

Route::prefix('product')->group(function () {
    Route::get('listProduct','Api\V1\ProductCtrl@index');
    Route::post('store','Api\V1\ProductCtrl@stroe');
    Route::put('update/{$id}','Api\V1\Product@update');
    Route::post('detail/{$id}','Api\V1\ProductCtrl@detail');
    Route::delete('delete/{$id}','Api\V1\ProductCtrl@delete');
});
