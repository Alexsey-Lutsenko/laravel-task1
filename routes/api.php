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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'Culture', 'prefix'=>'cultures'], function() {
    Route::get('/','IndexController');
    Route::post('/', 'StoreController');
    Route::patch('/{culture}', 'UpdateController');
    Route::delete('/{culture}', 'DestroyController');
});

Route::group(['namespace'=>'User', 'prefix'=>'users'], function() {
    Route::get('/','IndexController');
//    Route::post('/', 'StoreController');
//    Route::patch('/{user}', 'UpdateController');
    Route::delete('/{user}', 'DestroyController');
});
