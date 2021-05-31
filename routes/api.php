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

                Route::resource('seminarproposal', 'AdminSeminarProposalController', [
                    'only' => ['index', 'show']
                ]);

                Route::resource('sidangskripsi', 'AdminSidangSkripsiController', [
                    'only' => ['index', 'show']
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

                Route::resource('seminarproposal', 'SeminarProposalController', [
                    'except' => ['create', 'edit', 'destroy', 'store']
                ]);
                Route::get('seminarproposal/{id}/penguji', [
                    'uses' => 'SeminarProposalController@cek_persetujuan_penguji'
                ]);
                Route::get('seminarproposal/{id}/hasil', [
                    'uses' => 'SeminarProposalController@hasil_seminar'
                ]);
                Route::patch('seminarproposal/{id}/verifikasi', [
                    'uses' => 'SeminarProposalController@verifikasi_seminar'
                ]);
                Route::get('seminarproposal/{id}/daftarnilai', [
                    'uses' => 'SeminarProposalController@daftar_nilai'
                ]);

                Route::resource('sidangskripsi', 'SidangSkripsiController', [
                    'except' => ['create', 'edit', 'destroy', 'store']
                ]);
                Route::get('sidangskripsi/{id}/hasil', [
                    'uses' => 'SidangSkripsiController@hasil_sidang'
                ]);
                Route::patch('sidangskripsi/{id}/verifikasi', [
                    'uses' => 'SidangSkripsiController@verifikasi_sidang'
                ]);
                Route::get('sidangskripsi/{id}/daftarnilai', [
                    'uses' => 'SidangSkripsiController@daftar_nilai'
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
                Route::get('dosenpembimbing', [
                    'uses' => 'DosenPembimbingMahasiswaController@index'
                ]);
                Route::get('dosenpenguji', [
                    'uses' => 'DosenPengujiMahasiswaController@index'
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
                Route::post('persyaratan/juduldosbing2', [
                    'uses' => 'PersyaratanSkripsiController@juduldosbing2'
                ]);
                Route::get('persyaratan/juduldosbing2', [
                    'uses' => 'PersyaratanSkripsiController@lihat_status_juduldosbing2'
                ]);

                Route::resource('bimbinganproposal', 'PengajuanBimbinganProposalController', [
                    'only' => ['index', 'show', 'store']
                ]);

                Route::resource('seminarproposal', 'PengajuanSeminarProposalController', [
                    'only' => ['store']
                ]);
                Route::get('seminarproposal/persetujuandosbing', [
                    'uses' => 'PengajuanSeminarProposalController@cek_persetujuan_dosbing'
                ]);
                Route::get('seminarproposal/penguji', [
                    'uses' => 'PengajuanSeminarProposalController@cek_penguji_dan_waktu'
                ]);
                Route::get('hasilseminarproposal/daftarnilai', [
                    'uses' => 'MahasiswaHasilSeminarProposalController@daftar_nilai'
                ]);
                Route::resource('hasilseminarproposal', 'MahasiswaHasilSeminarProposalController', [
                    'only' => ['index', 'show']
                ]);

                Route::resource('bimbinganskripsi', 'PengajuanBimbinganSkripsiController', [
                    'only' => ['index', 'show', 'store']
                ]);

                Route::resource('sidangskripsi', 'PengajuanSidangSkripsiController', [
                    'only' => ['store']
                ]);
                Route::get('sidangskripsi/persetujuandosbing', [
                    'uses' => 'PengajuanSidangSkripsiController@cek_persetujuan_dosbing'
                ]);
                Route::get('sidangskripsi/waktu', [
                    'uses' => 'PengajuanSidangSkripsiController@cek_waktu'
                ]);
                Route::get('hasilsidangskripsi/daftarnilai', [
                    'uses' => 'MahasiswaHasilSidangSkripsiController@daftar_nilai'
                ]);
                Route::resource('hasilsidangskripsi', 'MahasiswaHasilSidangSkripsiController', [
                    'only' => ['index', 'show']
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

                Route::resource('persetujuanjudul', 'PersetujuanJudulController', [
                    'except' => ['create', 'edit', 'destroy', 'store']
                ]);

                Route::resource('bimbinganproposal', 'BimbinganProposalController', [
                    'only' => ['index', 'show', 'update']
                ]);

                Route::resource('persetujuanseminar', 'PersetujuanSeminarProposalController', [
                    'only' => ['index', 'show', 'update']
                ]);

                Route::resource('persetujuandosenpenguji', 'PersetujuanDosenPengujiController', [
                    'only' => ['index', 'show', 'update']
                ]);

                Route::resource('seminarproposal', 'DosenVerifikasiSeminarProposalController', [
                    'only' => ['index', 'show', 'update']
                ]);
                Route::patch('seminarproposal/{id}/nilai', [
                    'uses' => 'DosenVerifikasiSeminarProposalController@input_nilai'
                ]);
                Route::get('seminarproposal/{id}/nilai', [
                    'uses' => 'DosenVerifikasiSeminarProposalController@lihat_nilai'
                ]);

                Route::resource('bimbinganskripsi', 'BimbinganSkripsiController', [
                    'only' => ['index', 'show', 'update']
                ]);

                Route::resource('persetujuansidang', 'PersetujuanSidangSkripsiController', [
                    'only' => ['index', 'show', 'update']
                ]);

                Route::resource('sidangskripsi', 'DosenVerifikasiSidangSkripsiController', [
                    'only' => ['index', 'show', 'update']
                ]);
                Route::patch('sidangskripsi/{id}/nilai', [
                    'uses' => 'DosenVerifikasiSidangSkripsiController@input_nilai'
                ]);
                Route::get('sidangskripsi/{id}/nilai', [
                    'uses' => 'DosenVerifikasiSidangSkripsiController@lihat_nilai'
                ]);
            });
        });
    });
});
