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

Route::group([

    'middleware' => 'api',
    'prefix' => 'vendor'

], function ($router) {

    Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
        // Route::post('/customer/list','customerList')->middleware('vendor.verify');
        // Route::get('/customer/view/{id}','customerDetail')->middleware('vendor.verify');
    });

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'bridge'

], function ($router) {

    Route::controller(\App\Http\Controllers\CustomerController::class)->group(function () {

    });

});