<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/docs', function () {
    return view('docs/index');
});

Route::get('/login', 'Docs\AuthController@form_login')->name('login');
Route::post('/postlogin', 'Docs\AuthController@post_login');
Route::get('/register', 'Docs\AuthController@form_register');
Route::post('/postregister', 'Docs\AuthController@post_register');

Route::group(['middleware' => 'auth:developer'], function () {
    Route::post('/logout', 'Docs\AuthController@logout')->name('logout');
    Route::get('/dashboard', 'Docs\DashboardController@index');

    // Route Admin 
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['middleware' => 'checkRoleUserDev:Admin'], function () {
            Route::resource('developer', 'Docs\DeveloperController', [
                'except' => 'destroy'
            ]);
        });
    });

    // Route Developer 
    Route::group(['prefix' => 'developer'], function () {
        Route::group(['middleware' => 'checkRoleUserDev:Developer'], function () {
            Route::resource('myapp', 'Docs\DeveloperApiClientController', [
                'except' => ['edit', 'destroy']
            ]);
        });
    });
});
