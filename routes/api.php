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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => 'v1'], function () {
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/login', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function () {

        //Route Admin
        Route::group(['prefix' => 'admin'], function () {
            Route::group(['middleware' => 'checkRole:Admin'], function () {
                Route::resource('profile', 'ProfileAdminController', [
                    'only' => ['index', 'update']
                ]);
                Route::post('profile/gantipassword', 'ProfileAdminController@gantipassword');
                Route::resource('fakultas', 'FakultasController', [
                    'except' => ['create', 'edit']
                ]);
            });
        });

        //Route Admin Prodi
    });
});
