<?php

namespace App\Http\Controllers;

use App\AdminProdi;
use App\Mahasiswa;
use App\User;
use App\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();
        $mahasiswa = Mahasiswa::where('program_studi_id_program_studi', $program_studi->id)->orderby('nama_mahasiswa', 'asc')->get([
            'id',
            'nama_mahasiswa',
            'npm_mahasiswa',
            'jenis_kelamin_mahasiswa',
            'tanggal_lahir_mahasiswa',
            'semester_mahasiswa',
            'status_mahasiswa',
        ]);
        $response = [
            'status'  => 'success',
            'message' => 'List Mahasiswa of Program Studi ' . $program_studi->nama_program_studi,
            'data' => $mahasiswa,
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'nama_mahasiswa' => 'required|min:3',
            'npm_mahasiswa' => 'required|unique:mahasiswa|numeric|digits:10',
            'semester_mahasiswa' => 'required|numeric|between:7,14',
            'tempat_lahir_mahasiswa' => 'required|min:3',
            'tanggal_lahir_mahasiswa' => 'required|date|before:today',
            'jenis_kelamin_mahasiswa' => 'required|in:L,P',
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

        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();

        $user = new User([
            'nama' => $request->input('nama_mahasiswa'),
            'username' => $request->input('npm_mahasiswa'),
            'password' => bcrypt($request->input('npm_mahasiswa')),
            'role' => 'Mahasiswa',
            'api_token' => Str::random(100),
        ]);

        if ($user->save()) {
            try {
                $mahasiswa = new Mahasiswa([
                    'user_id_user' => $user->id,
                    'program_studi_id_program_studi' => $program_studi->id,
                    'nama_mahasiswa' => $request->input('nama_mahasiswa'),
                    'npm_mahasiswa' => $request->input('npm_mahasiswa'),
                    'tempat_lahir_mahasiswa' => $request->input('tempat_lahir_mahasiswa'),
                    'tanggal_lahir_mahasiswa' => $request->input('tanggal_lahir_mahasiswa'),
                    'jenis_kelamin_mahasiswa' => $request->input('jenis_kelamin_mahasiswa'),
                    'semester_mahasiswa' => $request->input('semester_mahasiswa'),
                    'status_mahasiswa' => 'Aktif',
                ]);
                $mahasiswa->save();

                $data = [
                    'id' => $mahasiswa->id,
                    'user' => [
                        'id' => $user->id,
                        'nama' => $user->nama,
                        'username' => $user->username
                    ],
                    'program_studi' => [
                        'id' => $program_studi->id,
                        'kode_program_studi' => $program_studi->kode_program_studi,
                        'nama_program_studi' => $program_studi->nama_program_studi,
                    ],
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'semester_mahasiswa' => $mahasiswa->semester_mahasiswa,
                    'tempat_lahir_mahasiswa' => $mahasiswa->tempat_lahir_mahasiswa,
                    'tanggal_lahir_mahasiswa' => $mahasiswa->tanggal_lahir_mahasiswa,
                    'jenis_kelamin_mahasiswa' => $mahasiswa->jenis_kelamin_mahasiswa,
                    'status_mahasiswa' => $mahasiswa->status_mahasiswa,
                    'created_at' => $mahasiswa->created_at->diffForHumans(),
                ];

                $response = [
                    'status'  => 'success',
                    'message' => 'Data added successfully',
                    'data' => $data
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                return response()->json($response, 201);
            } catch (\Illuminate\Database\QueryException $ex) {
                $user_delete = User::findOrFail($user->id);
                $user_delete->delete();
                $response = [
                    'status'  => 'error',
                    'message' => 'an error occurred while saving the data mahasiswa, make sure that you have entered the correct data format!'
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();
                return response()->json($response, 400);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        try {
            $mahasiswa = Mahasiswa::findorfail($id);
            $data_user = User::findorfail($mahasiswa->user_id_user);
            $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);
            // Get Alamat 
            if (!is_null($mahasiswa->desa_mahasiswa)) {
                $provinsi = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi/' . $mahasiswa->provinsi_mahasiswa)->json();
                $kabupaten = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota/' . $mahasiswa->kabupaten_mahasiswa)->json();
                $kecamatan = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/' . $mahasiswa->kecamatan_mahasiswa)->json();
                $desa = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/' . $mahasiswa->desa_mahasiswa)->json();

                $data = [
                    'id' => $mahasiswa->id,
                    'user' => [
                        'id' => $data_user->id,
                        'nama' => $data_user->nama,
                        'username' => $data_user->username
                    ],
                    'program_studi' => [
                        'id' => $program_studi->id,
                        'kode_program_studi' => $program_studi->kode_program_studi,
                        'nama_program_studi' => $program_studi->nama_program_studi
                    ],
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'semester_mahasiswa' => $mahasiswa->semester_mahasiswa,
                    'tempat_lahir_mahasiswa' => $mahasiswa->tempat_lahir_mahasiswa,
                    'tanggal_lahir_mahasiswa' => $mahasiswa->tanggal_lahir_mahasiswa,
                    'jenis_kelamin_mahasiswa' => $mahasiswa->jenis_kelamin_mahasiswa,
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
                    'foto_mahasiswa' => [
                        'nama_file' => $mahasiswa->foto_mahasiswa,
                        'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
                    ],
                    'email_mahasiswa' => $mahasiswa->email_mahasiswa,
                    'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
                    'status_mahasiswa' => $mahasiswa->status_mahasiswa,
                    'tanggal_pembaruan_mahasiswa' => $mahasiswa->updated_at->format('Y-m-d H:i:s')
                ];

                $response = [
                    'status'  => 'success',
                    'message' => 'Details Data Mahasiswa',
                    'data' => $data
                ];

                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                return response()->json($response, 200);
            }
            $data = [
                'id' => $mahasiswa->id,
                'user' => [
                    'id' => $data_user->id,
                    'nama' => $data_user->nama,
                    'username' => $data_user->username
                ],
                'program_studi' => [
                    'id' => $program_studi->id,
                    'kode_program_studi' => $program_studi->kode_program_studi,
                    'nama_program_studi' => $program_studi->nama_program_studi
                ],
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'semester_mahasiswa' => $mahasiswa->semester_mahasiswa,
                'tempat_lahir_mahasiswa' => $mahasiswa->tempat_lahir_mahasiswa,
                'tanggal_lahir_mahasiswa' => $mahasiswa->tanggal_lahir_mahasiswa,
                'jenis_kelamin_mahasiswa' => $mahasiswa->jenis_kelamin_mahasiswa,
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
                'foto_mahasiswa' => [
                    'nama_file' => $mahasiswa->foto_mahasiswa,
                    'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
                ],
                'email_mahasiswa' => $mahasiswa->email_mahasiswa,
                'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
                'status_mahasiswa' => $mahasiswa->status_mahasiswa,
                'tanggal_pembaruan_mahasiswa' => $mahasiswa->updated_at->format('Y-m-d H:i:s')
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Mahasiswa',
                'data' => $data
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'status'  => 'error',
                'message' => 'Data not found',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'nama_mahasiswa' => 'required|min:3',
            'tempat_lahir_mahasiswa' => 'required|min:3',
            'tanggal_lahir_mahasiswa' => 'required|date|before:today',
            'status_mahasiswa' => 'required|in:Aktif,Non Aktif,Drop Out,Lulus',
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

        $mahasiswa = Mahasiswa::findorfail($id);
        $mahasiswa->nama_mahasiswa = $request->input('nama_mahasiswa');
        $mahasiswa->tempat_lahir_mahasiswa = $request->input('tempat_lahir_mahasiswa');
        $mahasiswa->tanggal_lahir_mahasiswa = $request->input('tanggal_lahir_mahasiswa');
        $mahasiswa->status_mahasiswa = $request->input('status_mahasiswa');

        $user = User::findorfail($mahasiswa->user_id_user);
        $user->nama = $request->input('nama_mahasiswa');

        $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);

        try {
            $mahasiswa->update();
            $user->update();
            $data = [
                'id' => $mahasiswa->id,
                'user' => [
                    'id' => $user->id,
                    'nama' => $user->nama
                ],
                'program_studi' => [
                    'id' => $program_studi->id,
                    'kode_program_studi' => $program_studi->kode_program_studi,
                    'nama_program_studi' => $program_studi->nama_program_studi
                ],
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                'tempat_lahir_mahasiswa' => $mahasiswa->tempat_lahir_mahasiswa,
                'tanggal_lahir_mahasiswa' => $mahasiswa->tanggal_lahir_mahasiswa,
                'status_mahasiswa' => $mahasiswa->status_mahasiswa,
                'updated_at' => $mahasiswa->updated_at->diffForHumans(),
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Data Edited Successfully',
                'data' => $data
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'an error occurred while updating the data'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $user = User::findOrFail($mahasiswa->user_id_user);
            $mahasiswa->delete();
            $user->delete();
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data user & mahasiswa with id ' . $mahasiswa->id . ' deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry the data cannot be deleted, there are still data in other tables that are related to this data!'
            ], 400);
        }
    }

    public function resetpassword(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'npm_mahasiswa' => 'required|numeric|digits:10'
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

        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = User::findorfail($mahasiswa->user_id_user);
        $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);

        if ($user->username == $request->input('npm_mahasiswa')) {
            $user->password = bcrypt($request->input('npm_mahasiswa'));
            $user->api_token = Str::random(100);
            $user->update();

            $data = [
                'id' => $mahasiswa->id,
                'user' => [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'username' => $user->username,
                ],
                'program_studi' => [
                    'id' => $program_studi->id,
                    'nama_program_studi' => $program_studi->nama_program_studi
                ]
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Password Reset Successful',
                'data' => $data
            ], 205);
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'error',
            'message' => 'The npm mahasiswa you entered is invalid',
        ], 400);
    }
}
