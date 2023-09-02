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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');

//GET MASTER DATA
Route::get('/category', 'App\Http\Controllers\CategoryController@index');
Route::get('/product', 'App\Http\Controllers\ProductController@index');
Route::get('/province/all', 'App\Http\Controllers\AddressController@getAllProvinces');
Route::get('/address/{id}', 'App\Http\Controllers\AddressController@getAddress');

Route::group([

    'middleware' => 'api',
    'prefix' => 'vendor'

], function ($router) {

    Route::controller(\App\Http\Controllers\ProductController::class)->group(function () {
        Route::get('/product/{id}','getByVendor')->middleware('vendor.verify');
        Route::post('/product/create','store')->middleware('vendor.verify');

        // Route::get('/customer/view/{id}','customerDetail')->middleware('vendor.verify');
    });

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'bridge'

], function ($router) {

    Route::controller(\App\Http\Controllers\ProductController::class)->group(function () {
        Route::get('/product/random','getRandom')->middleware('bridge.verify');
    });

    Route::controller(\App\Http\Controllers\VendorController::class)->group(function () {
        Route::get('/vendor/random','getRandom')->middleware('bridge.verify');
    });

});