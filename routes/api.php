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

    Route::group(['namespace'=>'Deleted', 'prefix'=>'deleted'], function() {
        Route::get('/','IndexController');
    });
});

Route::group(['namespace'=>'User', 'prefix'=>'users'], function() {
    Route::get('/','IndexController');
    Route::post('/', 'StoreController');
    Route::patch('/{user}', 'UpdateController');
    Route::delete('/{user}', 'DestroyController');

    Route::group(['namespace'=>'Deleted', 'prefix'=>'deleted'], function() {
        Route::get('/','IndexController');
    });

    Route::group(['namespace'=>'CreateAdmin', 'prefix'=>'create-admin'], function() {
        Route::get('/','IndexController');
        Route::post('/','StoreController');
    });
});

Route::group(['namespace'=>'Client', 'prefix'=>'clients'], function() {
    Route::get('/','IndexController');
    Route::post('/', 'StoreController');
    Route::patch('/{client}', 'UpdateController');
    Route::delete('/{client}', 'DestroyController');

    Route::group(['namespace'=>'Deleted', 'prefix'=>'deleted'], function() {
        Route::get('/','IndexController');
    });

    Route::group(['namespace'=>'Import', 'prefix'=>'import'], function() {
        Route::post('/','ImportController');
    });

    Route::group(['namespace'=>'Export', 'prefix'=>'export'], function() {
        Route::get('/','ExportController');
    });

    Route::group(['namespace'=>'Agreement', 'prefix'=>'agreement'], function() {
        Route::post('/','AgreementController');
    });
});

Route::group(['namespace'=>'Fertilizer', 'prefix'=>'fertilizers'], function() {
    Route::get('/','IndexController');
    Route::post('/', 'StoreController');
    Route::patch('/{fertilizer}', 'UpdateController');
    Route::delete('/{fertilizer}', 'DestroyController');

    Route::group(['namespace'=>'Deleted', 'prefix'=>'deleted'], function() {
        Route::get('/','IndexController');
    });

    Route::group(['namespace'=>'Import', 'prefix'=>'import'], function() {
        Route::post('/','ImportController');
    });

    Route::group(['namespace'=>'Export', 'prefix'=>'export'], function() {
        Route::get('/','ExportController');
    });
});

Route::group(['namespace'=>'Role', 'prefix'=>'roles'], function() {
    Route::get('/','IndexController');
});

Route::group(['namespace'=>'ImportStatus', 'prefix'=>'import-status'], function() {
    Route::get('/','IndexController');
    Route::post('/','StoreController');
});
