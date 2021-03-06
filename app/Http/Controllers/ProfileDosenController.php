<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\JabatanFungsional;
use App\JabatanStruktural;
use App\ProgramStudi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class ProfileDosenController extends Controller
{
    public function index(Request $request, User $user)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $dosen->program_studi_id_program_studi)->first();

        $jabatan_fungsional = [
            'id' => null,
            'nama_jabatan_fungsional' => null
        ];
        if (!is_null($dosen->jabatan_fungsional_id_jabatan_fungsional)) {
            $jabatan_fungsional = JabatanFungsional::where('id', $dosen->jabatan_fungsional_id_jabatan_fungsional)->get([
                'id',
                'nama_jabatan_fungsional'
            ])->first();
        }
        $jabatan_fungsional;

        $jabatan_struktural = [
            'id' => null,
            'nama_jabatan_struktural' => null
        ];
        if (!is_null($dosen->jabatan_struktural_id_jabatan_struktural)) {
            $jabatan_struktural = JabatanStruktural::where('id', $dosen->jabatan_struktural_id_jabatan_struktural)->get([
                'id',
                'nama_jabatan_struktural'
            ])->first();
        }
        $jabatan_struktural;

        if (!is_null($dosen->desa_dosen)) {
            $provinsi = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi/' . $dosen->provinsi_dosen)->json();
            $kabupaten = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota/' . $dosen->kabupaten_dosen)->json();
            $kecamatan = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/' . $dosen->kecamatan_dosen)->json();
            $desa = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/' . $dosen->desa_dosen)->json();
            $data = [
                'id' => $dosen->id,
                'program_studi' => [
                    'id' => $program_studi->id,
                    'kode_program_studi' => $program_studi->kode_program_studi,
                    'nama_program_studi' => $program_studi->nama_program_studi
                ],
                'nama_dosen' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
                'nidn_dosen' => $dosen->nidn_dosen,
                'nip_dosen' => $dosen->nip_dosen,
                'jenis_kelamin_dosen' => $dosen->jenis_kelamin_dosen,
                'tempat_lahir_dosen' => $dosen->tempat_lahir_dosen,
                'tanggal_lahir_dosen' => $dosen->tanggal_lahir_dosen,
                'pendidikan_terakhir_dosen' => $dosen->pendidikan_terakhir_dosen,
                'nik_dosen' => $dosen->nik_dosen,
                'status_perkawinan_dosen' => $dosen->status_perkawinan_dosen,
                'agama_dosen' => $dosen->agama_dosen,
                'nama_ibu_dosen' => $dosen->nama_ibu_dosen,
                'alamat_dosen' => $dosen->alamat_dosen,
                'provinsi_dosen' => [
                    'id' => $provinsi['id'],
                    'nama' => $provinsi['nama'],
                ],
                'kabupaten_dosen' => [
                    'id' => $kabupaten['id'],
                    'nama' => $kabupaten['nama'],
                ],
                'kecamatan_dosen' => [
                    'id' => $kecamatan['id'],
                    'nama' => $kecamatan['nama'],
                ],
                'desa_dosen' => [
                    'id' => $desa['id'],
                    'nama' => $desa['nama'],
                ],
                'email_dosen' => $dosen->email_dosen,
                'no_hp_dosen' => $dosen->no_hp_dosen,
                'jabatan_fungsional' => $jabatan_fungsional,
                'jabatan_struktural' => $jabatan_struktural,
                'foto_dosen' => [
                    'nama_file' => $dosen->foto_dosen,
                    'url' => 'fileFotoProfile/' . $dosen->foto_dosen

                ],
                'status_dosen' => $dosen->status_dosen,
                'tanggal_pembaruan_dosen' => $dosen->updated_at->format('Y-m-d H:i:s')
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Profile Dosen',
                'data' => $data
            ], 200);
        }
        $data = [
            'id' => $dosen->id,
            'program_studi' => [
                'id' => $program_studi->id,
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi
            ],
            'nama_dosen' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
            'nidn_dosen' => $dosen->nidn_dosen,
            'nip_dosen' => $dosen->nip_dosen,
            'jenis_kelamin_dosen' => $dosen->jenis_kelamin_dosen,
            'tempat_lahir_dosen' => $dosen->tempat_lahir_dosen,
            'tanggal_lahir_dosen' => $dosen->tanggal_lahir_dosen,
            'pendidikan_terakhir_dosen' => $dosen->pendidikan_terakhir_dosen,
            'nik_dosen' => $dosen->nik_dosen,
            'status_perkawinan_dosen' => $dosen->status_perkawinan_dosen,
            'agama_dosen' => $dosen->agama_dosen,
            'nama_ibu_dosen' => $dosen->nama_ibu_dosen,
            'alamat_dosen' => $dosen->alamat_dosen,
            'provinsi_dosen' => [
                'id' => null,
                'nama' => null,
            ],
            'kabupaten_dosen' => [
                'id' => null,
                'nama' => null,
            ],
            'kecamatan_dosen' => [
                'id' => null,
                'nama' => null,
            ],
            'desa_dosen' => [
                'id' => null,
                'nama' => null,
            ],
            'email_dosen' => $dosen->email_dosen,
            'no_hp_dosen' => $dosen->no_hp_dosen,
            'jabatan_fungsional' => $jabatan_fungsional,
            'jabatan_struktural' => $jabatan_struktural,
            'foto_dosen' => [
                'nama_file' => $dosen->foto_dosen,
                'url' => 'fileFotoProfile/' . $dosen->foto_dosen

            ],
            'status_dosen' => $dosen->status_dosen,
            'tanggal_pembaruan_dosen' => $dosen->updated_at->format('Y-m-d H:i:s')
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Profile Dosen',
            'data' => $data
        ], 200);
    }

    public function update_profile(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $dosen->program_studi_id_program_studi)->first();
        $id = $dosen->id;

        $validator = Validator::make($request->all(), [
            'status_perkawinan_dosen' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'jenis_kelamin_dosen' => 'required|in:L,P',
            'nama_ibu_dosen' => 'required|min:3',
            'alamat_dosen' => 'nullable|max:100',
            'provinsi_dosen' => 'required|numeric',
            'kabupaten_dosen' => 'required|numeric',
            'kecamatan_dosen' => 'required|numeric',
            'desa_dosen' => 'required|numeric',
            'no_hp_dosen' => 'required|numeric|digits_between:11,13|unique:dosen' . ($id ? ",id,$id" : ''),
            'email_dosen' => 'required|email|unique:dosen' . ($id ? ",id,$id" : ''),
            'foto_dosen' => 'nullable|image|max:2000',
        ]);
        if ($validator->fails()) {
            $response = [
                'status'  => 'error',
                'message' => $validator->messages()->all()[0]
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 422);
        }

        $dosen->status_perkawinan_dosen = $request->input('status_perkawinan_dosen');
        $dosen->jenis_kelamin_dosen = $request->input('jenis_kelamin_dosen');
        $dosen->nama_ibu_dosen = $request->input('nama_ibu_dosen');
        $dosen->alamat_dosen = $request->input('alamat_dosen');
        $dosen->provinsi_dosen = $request->input('provinsi_dosen');
        $dosen->kabupaten_dosen = $request->input('kabupaten_dosen');
        $dosen->kecamatan_dosen = $request->input('kecamatan_dosen');
        $dosen->desa_dosen = $request->input('desa_dosen');
        $dosen->no_hp_dosen = $request->input('no_hp_dosen');
        $dosen->email_dosen = $request->input('email_dosen');
        // $dosen->foto_dosen = $request->input('foto_dosen');

        if ($request->hasFile('foto_dosen')) {
            $file_foto = $request->file('foto_dosen');
            $fotoName = 'img-' . $dosen->nidn_dosen . '.' . $file_foto->getClientOriginalExtension();
            $file_foto->move('api/v1/fileFotoProfile/', $fotoName);
            $dosen->foto_dosen = $fotoName;
        }
        $dosen->save();

        // Get Alamat 
        $provinsi = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi/' . $request->input('provinsi_dosen'))->json();
        $kabupaten = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota/' . $request->input('kabupaten_dosen'))->json();
        $kecamatan = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/' . $request->input('kecamatan_dosen'))->json();
        $desa = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/' . $request->input('desa_dosen'))->json();

        $data = [
            'id' => $dosen->id,
            'program_studi' => [
                'id' => $program_studi->id,
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi,
            ],
            'status_perkawinan_dosen' => $dosen->status_perkawinan_dosen,
            'jenis_kelamin_dosen' => $dosen->jenis_kelamin_dosen,
            'nama_ibu_dosen' => $dosen->nama_ibu_dosen,
            'alamat_dosen' => $dosen->alamat_dosen,
            'provinsi_dosen' => [
                'id' => $provinsi['id'],
                'nama' => $provinsi['nama'],
            ],
            'kabupaten_dosen' => [
                'id' => $kabupaten['id'],
                'nama' => $kabupaten['nama'],
            ],
            'kecamatan_dosen' => [
                'id' => $kecamatan['id'],
                'nama' => $kecamatan['nama'],
            ],
            'desa_dosen' => [
                'id' => $desa['id'],
                'nama' => $desa['nama'],
            ],
            'no_hp_dosen' => $dosen->no_hp_dosen,
            'email_dosen' => $dosen->email_dosen,
            'foto_dosen' => [
                'nama_file' => $dosen->foto_dosen,
                'url' => 'fileFotoProfile/' . $dosen->foto_dosen
            ],
            'updated_at' => $dosen->updated_at->diffForHumans(),
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Profile updated successfully',
            'data' => $data
        ], 200);
    }
}
