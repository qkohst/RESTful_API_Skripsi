<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use App\ProgramStudi;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class ProfileMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $mahasiswa->program_studi_id_program_studi)->first();
        // Get Alamat 
        if (!is_null($mahasiswa->desa_mahasiswa)) {
            $provinsi = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi/' . $mahasiswa->provinsi_mahasiswa)->json();
            $kabupaten = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota/' . $mahasiswa->kabupaten_mahasiswa)->json();
            $kecamatan = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/' . $mahasiswa->kecamatan_mahasiswa)->json();
            $desa = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/' . $mahasiswa->desa_mahasiswa)->json();

            $data = [
                'id' => $mahasiswa->id,
                'program_studi' => [
                    'id' => $program_studi->id,
                    'kode_program_studi' => $program_studi->kode_program_studi,
                    'nama_program_studi' => $program_studi->nama_program_studi,
                ],
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'semester_mahasiswa' => $mahasiswa->semester_mahasiswa,
                'jenis_kelamin_mahasiswa' => $mahasiswa->jenis_kelamin_mahasiswa,
                'tempat_lahir_mahasiswa' => $mahasiswa->tempat_lahir_mahasiswa,
                'tanggal_lahir_mahasiswa' => $mahasiswa->tanggal_lahir_mahasiswa,
                'status_perkawinan_mahasiswa' => $mahasiswa->status_perkawinan_mahasiswa,
                'agama_mahasiswa' => $mahasiswa->agama_mahasiswa,
                'nama_ibu_mahasiswa' => $mahasiswa->nama_ibu_mahasiswa,
                'alamat_mahasiswa' => $mahasiswa->alamat_mahasiswa,
                'provinsi_mahasiswa' => [
                    'id' => $provinsi['id'],
                    'nama' => $provinsi['nama'],
                ],
                'kabupaten_mahasiswa' => [
                    'id' => $kabupaten['id'],
                    'nama' => $kabupaten['nama'],
                ],
                'kecamatan_mahasiswa' => [
                    'id' => $kecamatan['id'],
                    'nama' => $kecamatan['nama'],
                ],
                'desa_mahasiswa' => [
                    'id' => $desa['id'],
                    'nama' => $desa['nama'],
                ],
                'email_mahasiswa' => $mahasiswa->email_mahasiswa,
                'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
                'status_mahasiswa' => $mahasiswa->status_mahasiswa,
                'foto_mahasiswa' => [
                    'nama_file' => $mahasiswa->foto_mahasiswa,
                    'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
                ],
                'tanggal_pembaruan_mahasiswa' => $mahasiswa->updated_at->format('Y-m-d H:i:s')
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Profile Mahasiswa',
                'data' => $data
            ], 200);
        }

        $data = [
            'id' => $mahasiswa->id,
            'program_studi' => [
                'id' => $program_studi->id,
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi,
            ],
            'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
            'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
            'semester_mahasiswa' => $mahasiswa->semester_mahasiswa,
            'jenis_kelamin_mahasiswa' => $mahasiswa->jenis_kelamin_mahasiswa,
            'tempat_lahir_mahasiswa' => $mahasiswa->tempat_lahir_mahasiswa,
            'tanggal_lahir_mahasiswa' => $mahasiswa->tanggal_lahir_mahasiswa,
            'status_perkawinan_mahasiswa' => $mahasiswa->status_perkawinan_mahasiswa,
            'agama_mahasiswa' => $mahasiswa->agama_mahasiswa,
            'nama_ibu_mahasiswa' => $mahasiswa->nama_ibu_mahasiswa,
            'alamat_mahasiswa' => $mahasiswa->alamat_mahasiswa,
            'provinsi_mahasiswa' => [
                'id' => null,
                'nama' => null,
            ],
            'kabupaten_mahasiswa' => [
                'id' => null,
                'nama' => null,
            ],
            'kecamatan_mahasiswa' => [
                'id' => null,
                'nama' => null,
            ],
            'desa_mahasiswa' => [
                'id' => null,
                'nama' => null,
            ],
            'email_mahasiswa' => $mahasiswa->email_mahasiswa,
            'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
            'status_mahasiswa' => $mahasiswa->status_mahasiswa,
            'foto_mahasiswa' => [
                'nama_file' => $mahasiswa->foto_mahasiswa,
                'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
            ],
            'tanggal_pembaruan_mahasiswa' => $mahasiswa->updated_at->format('Y-m-d H:i:s')
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Profile Mahasiswa',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $mahasiswa->program_studi_id_program_studi)->first();
        $id = $mahasiswa->id;

        $validator = Validator::make($request->all(), [
            'status_perkawinan_mahasiswa' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'agama_mahasiswa' => 'required|in:Islam, Protestan, Katolik, Hindu, Budha, Khonghucu, Kepercayaan',
            'jenis_kelamin_mahasiswa' => 'required|in:L,P',
            'nama_ibu_mahasiswa' => 'required|min:3',
            'alamat_mahasiswa' => 'nullable|max:100',
            'provinsi_mahasiswa' => 'required|numeric',
            'kabupaten_mahasiswa' => 'required|numeric',
            'kecamatan_mahasiswa' => 'required|numeric',
            'desa_mahasiswa' => 'required|numeric',
            'no_hp_mahasiswa' => 'required|numeric|digits_between:11,13|unique:mahasiswa' . ($id ? ",id,$id" : ''),
            'email_mahasiswa' => 'required|email|unique:mahasiswa' . ($id ? ",id,$id" : ''),
            'foto_mahasiswa' => 'nullable|image|max:2000',
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

        $mahasiswa->status_perkawinan_mahasiswa = $request->input('status_perkawinan_mahasiswa');
        $mahasiswa->agama_mahasiswa = $request->input('agama_mahasiswa');
        $mahasiswa->jenis_kelamin_mahasiswa = $request->input('jenis_kelamin_mahasiswa');
        $mahasiswa->nama_ibu_mahasiswa = $request->input('nama_ibu_mahasiswa');
        $mahasiswa->alamat_mahasiswa = $request->input('alamat_mahasiswa');
        $mahasiswa->provinsi_mahasiswa = $request->input('provinsi_mahasiswa');
        $mahasiswa->kabupaten_mahasiswa = $request->input('kabupaten_mahasiswa');
        $mahasiswa->kecamatan_mahasiswa = $request->input('kecamatan_mahasiswa');
        $mahasiswa->desa_mahasiswa = $request->input('desa_mahasiswa');
        $mahasiswa->no_hp_mahasiswa = $request->input('no_hp_mahasiswa');
        $mahasiswa->email_mahasiswa = $request->input('email_mahasiswa');

        if ($request->hasFile('foto_mahasiswa')) {
            $file_foto = $request->file('foto_mahasiswa');
            $fotoName = 'img-' . $mahasiswa->npm_mahasiswa . '.' . $file_foto->getClientOriginalExtension();
            $file_foto->move('api/v1/fileFotoProfile/', $fotoName);
            $mahasiswa->foto_mahasiswa = $fotoName;
        }
        $mahasiswa->save();

        // Get Alamat 
        $provinsi = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi/' . $request->input('provinsi_mahasiswa'))->json();
        $kabupaten = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota/' . $request->input('kabupaten_mahasiswa'))->json();
        $kecamatan = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/' . $request->input('kecamatan_mahasiswa'))->json();
        $desa = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/' . $request->input('desa_mahasiswa'))->json();

        $data = [
            'id' => $mahasiswa->id,
            'program_studi' => [
                'id' => $program_studi->id,
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi,
            ],
            'status_perkawinan_mahasiswa' => $mahasiswa->status_perkawinan_mahasiswa,
            'agama_mahasiswa' => $mahasiswa->agama_mahasiswa,
            'jenis_kelamin_mahasiswa' => $mahasiswa->jenis_kelamin_mahasiswa,
            'nama_ibu_mahasiswa' => $mahasiswa->nama_ibu_mahasiswa,
            'alamat_mahasiswa' => $mahasiswa->alamat_mahasiswa,
            'provinsi_mahasiswa' => [
                'id' => $provinsi['id'],
                'nama' => $provinsi['nama'],
            ],
            'kabupaten_mahasiswa' => [
                'id' => $kabupaten['id'],
                'nama' => $kabupaten['nama'],
            ],
            'kecamatan_mahasiswa' => [
                'id' => $kecamatan['id'],
                'nama' => $kecamatan['nama'],
            ],
            'desa_mahasiswa' => [
                'id' => $desa['id'],
                'nama' => $desa['nama'],
            ],
            'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
            'email_mahasiswa' => $mahasiswa->email_mahasiswa,
            'foto_mahasiswa' => [
                'nama_file' => $mahasiswa->foto_mahasiswa,
                'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
            ],
            'updated_at' => $mahasiswa->updated_at->diffForHumans(),
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
