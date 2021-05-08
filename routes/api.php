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

        Route::post('auth/gantipassword', 'AuthController@gantipassword');
        Route::post('auth/logout', 'AuthController@logout');

        //Route Admin
        Route::group(['prefix' => 'admin'], function () {
            Route::group(['middleware' => 'checkRole:Admin'], function () {
                Route::get('profile', 'ProfileAdminController@index');
                Route::post('profile', 'ProfileAdminController@update_profile');

                Route::get('fakultas/aktif', 'FakultasController@filter_status_aktif');
                Route::resource('fakultas', 'FakultasController', [
                    'except' => ['create', 'edit']
                ]);

                Route::get('programstudi/aktif/{fakultas_id_fakultas}', 'ProgramStudiController@filter_by_fakultas');
                Route::resource('programstudi', 'ProgramStudiController', [
                    'except' => ['create', 'edit']
                ]);
            });
        });

        //Route Admin Prodi
    });
});
