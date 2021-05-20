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

        Route::post('auth/logout', 'AuthController@logout');
        Route::post('auth/gantipassword', 'AuthController@gantipassword');

        //Route Admin
        Route::group(['prefix' => 'admin'], function () {
            Route::group(['middleware' => 'checkRole:Admin'], function () {
                Route::get('profile', [
                    'uses' => 'ProfileAdminController@index'
                ]);
                Route::post('profile', [
                    'uses' => 'ProfileAdminController@update_profile'
                ]);

                Route::get('fakultas/aktif', [
                    'uses' => 'FakultasController@filter_status_aktif'
                ]);
                Route::resource('fakultas', 'FakultasController', [
                    'except' => ['create', 'edit']
                ]);
                Route::get('programstudi/aktif/{fakultas_id_fakultas}', [
                    'uses' => 'ProgramStudiController@filter_by_fakultas'
                ]);

                Route::resource('programstudi', 'ProgramStudiController', [
                    'except' => ['create', 'edit']
                ]);

                Route::resource('jabatanstruktural', 'JabatanStrukturalController', [
                    'except' => ['create', 'edit']
                ]);

                Route::resource('jabatanfungsional', 'JabatanFungsionalController', [
                    'except' => ['create', 'edit']
                ]);

                Route::resource('adminprodi', 'AdminProdiController', [
                    'except' => ['create', 'edit']
                ]);
                Route::patch('adminprodi/{id}/resetpassword', [
                    'uses' => 'AdminProdiController@resetpassword'
                ]);
            });
        });

        //Route Admin Prodi
        Route::group(['prefix' => 'adminprodi'], function () {
            Route::group(['middleware' => 'checkRole:Admin Prodi'], function () {
                Route::get('profile', [
                    'uses' => 'ProfileAdminProdiController@index'
                ]);
                Route::post('profile', [
                    'uses' => 'ProfileAdminProdiController@update_profile'
                ]);

                Route::resource('mahasiswa', 'MahasiswaController', [
                    'except' => ['create', 'edit']
                ]);
                Route::patch('mahasiswa/{id}/resetpassword', [
                    'uses' => 'MahasiswaController@resetpassword'
                ]);

                Route::get('dosen/aktif', [
                    'uses' => 'DosenController@filter_by_status'
                ]);
                Route::resource('dosen', 'DosenController', [
                    'except' => ['create', 'edit']
                ]);
                Route::patch('dosen/{id}/resetpassword', [
                    'uses' => 'DosenController@resetpassword'
                ]);

                Route::resource('persetujuankrs', 'PersetujuanKRSController', [
                    'except' => ['create', 'edit', 'destroy', 'store']
                ]);
            });
        });

        //Route Mahasiswa
        Route::group(['prefix' => 'mahasiswa'], function () {
            Route::group(['middleware' => 'checkRole:Mahasiswa'], function () {
                Route::get('profile', [
                    'uses' => 'ProfileMahasiswaController@index'
                ]);
                Route::post('profile', [
                    'uses' => 'ProfileMahasiswaController@update_profile'
                ]);

                Route::get('dosen', [
                    'uses' => 'MahasiswaDosenAktifController@index'
                ]);

                Route::post('persyaratan/uploadkrs', [
                    'uses' => 'PersyaratanSkripsiController@uploadkrs'
                ]);
                Route::get('persyaratan/uploadkrs', [
                    'uses' => 'PersyaratanSkripsiController@lihat_status_krs'
                ]);
                Route::post('persyaratan/juduldosbing1', [
                    'uses' => 'PersyaratanSkripsiController@juduldosbing1'
                ]);
                Route::get('persyaratan/juduldosbing1', [
                    'uses' => 'PersyaratanSkripsiController@lihat_status_juduldosbing1'
                ]);
            });
        });

        //Route Dosen
        Route::group(['prefix' => 'dosen'], function () {
            Route::group(['middleware' => 'checkRole:Dosen'], function () {
                Route::get('profile', [
                    'uses' => 'ProfileDosenController@index'
                ]);
                Route::post('profile', [
                    'uses' => 'ProfileDosenController@update_profile'
                ]);
            });
        });
    });
});
