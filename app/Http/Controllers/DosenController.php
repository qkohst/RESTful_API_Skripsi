<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\AdminProdi;
use App\ProgramStudi;
use App\User;
use App\Dosen;
use App\JabatanFungsional;
use App\JabatanStruktural;
use Illuminate\Support\Str;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class DosenController extends Controller
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
        $dosen = Dosen::where('program_studi_id_program_studi', $program_studi->id)
            ->orderby('nama_dosen', 'asc')->get('id');
        foreach ($dosen as $data_dosen) {
            $identitas_dosen = Dosen::findorfail($data_dosen->id);
            $data_dosen->nama_dosen = $identitas_dosen->nama_dosen . ', ' . $identitas_dosen->gelar_dosen;
            $data_dosen->nidn_dosen = $identitas_dosen->nidn_dosen;
            $data_dosen->nip_dosen = $identitas_dosen->nip_dosen;
            $data_dosen->jenis_kelamin_dosen = $identitas_dosen->jenis_kelamin_dosen;
            $data_dosen->tanggal_lahir_dosen = $identitas_dosen->tanggal_lahir_dosen;
            $data_dosen->status_dosen = $identitas_dosen->status_dosen;
        }
        $response = [
            'status'  => 'success',
            'message' => 'List Dosen of Program Studi ' . $program_studi->nama_program_studi,
            'data' => $dosen,
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
            'nama_dosen' => 'required|min:3',
            'nik_dosen' => 'required|unique:dosen|numeric|digits:16',
            'nidn_dosen' => 'required|unique:dosen|numeric|digits:10',
            'nip_dosen' => 'nullable|unique:dosen|numeric|digits:18',
            'tempat_lahir_dosen' => 'required|min:3',
            'tanggal_lahir_dosen' => 'required|date|before:today',
            'jenis_kelamin_dosen' => 'required|in:L,P',
            'agama_dosen' => 'required|in:Islam, Protestan, Katolik, Hindu, Budha, Khonghucu, Kepercayaan',
            'gelar_dosen' => 'required|min:2',
            'pendidikan_terakhir_dosen' => 'required|in:S1,S2,S3',
            'jabatan_fungsional_id_jabatan_fungsional' => 'nullable|exists:jabatan_fungsional,id',
            'jabatan_struktural_id_jabatan_struktural' => 'nullable|exists:jabatan_struktural,id',
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


        $data_jabatan_fungsional = [
            'id' => 'null',
            'nama_jabatan_fungsional' => 'null'
        ];
        if (!is_null($request->get('jabatan_fungsional_id_jabatan_fungsional'))) {
            $data_jabatan_fungsional = JabatanFungsional::where('id', $request->input('jabatan_fungsional_id_jabatan_fungsional'))->get([
                'id',
                'nama_jabatan_fungsional'
            ])->first();
        }
        $data_jabatan_fungsional;

        $data_jabatan_struktural = [
            'id' => 'null',
            'nama_jabatan_struktural' => 'null'
        ];
        if (!is_null($request->get('jabatan_struktural_id_jabatan_struktural'))) {
            $data_jabatan_struktural = JabatanStruktural::where('id', $request->input('jabatan_struktural_id_jabatan_struktural'))->get([
                'id',
                'nama_jabatan_struktural'
            ])->first();
        }
        $data_jabatan_struktural;

        $user = new User([
            'nama' => $request->input('nama_dosen'),
            'username' => $request->input('nidn_dosen'),
            'password' => bcrypt($request->input('nidn_dosen')),
            'role' => 'Dosen',
            'api_token' => Str::random(100),
        ]);

        if ($user->save()) {
            try {
                $dosen = new Dosen([
                    'user_id_user' => $user->id,
                    'program_studi_id_program_studi' => $program_studi->id,
                    'nama_dosen' => $request->input('nama_dosen'),
                    'nik_dosen' => $request->input('nik_dosen'),
                    'nidn_dosen' => $request->input('nidn_dosen'),
                    'nip_dosen' => $request->input('nip_dosen'),
                    'tempat_lahir_dosen' => $request->input('tempat_lahir_dosen'),
                    'tanggal_lahir_dosen' => $request->input('tanggal_lahir_dosen'),
                    'jenis_kelamin_dosen' => $request->input('jenis_kelamin_dosen'),
                    'agama_dosen' => $request->input('agama_dosen'),
                    'gelar_dosen' => $request->input('gelar_dosen'),
                    'pendidikan_terakhir_dosen' => $request->input('pendidikan_terakhir_dosen'),
                    'jabatan_fungsional_id_jabatan_fungsional' => $request->input('jabatan_fungsional_id_jabatan_fungsional'),
                    'jabatan_struktural_id_jabatan_struktural' => $request->input('jabatan_struktural_id_jabatan_struktural'),
                    'status_dosen' => 'Aktif',
                ]);
                $dosen->save();

                $data = [
                    'id' => $dosen->id,
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
                    'nama_dosen' => $dosen->nama_dosen,
                    'nik_dosen' => $dosen->nik_dosen,
                    'nidn_dosen' => $dosen->nidn_dosen,
                    'nip_dosen' => $dosen->nip_dosen,
                    'tempat_lahir_dosen' => $dosen->tempat_lahir_dosen,
                    'tanggal_lahir_dosen' => $dosen->tanggal_lahir_dosen,
                    'jenis_kelamin_dosen' => $dosen->jenis_kelamin_dosen,
                    'agama_dosen' => $dosen->agama_dosen,
                    'gelar_dosen' => $dosen->gelar_dosen,
                    'pendidikan_terakhir_dosen' => $dosen->pendidikan_terakhir_dosen,
                    'jabatan_fungsional' => $data_jabatan_fungsional,
                    'jabatan_struktural' => $data_jabatan_struktural,
                    'status_dosen' => $dosen->status_dosen,
                    'created_at' => $dosen->created_at->diffForHumans(),
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
            } catch (\Throwable $th) {
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

                return response()->json($response, 404);
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
            $dosen = Dosen::findorfail($id);
            $data_user = User::findorfail($dosen->user_id_user);
            $program_studi = ProgramStudi::findorfail($dosen->program_studi_id_program_studi);

            $data_jabatan_fungsional = [
                'id' => null,
                'nama_jabatan_fungsional' => null
            ];
            if (!is_null($dosen->jabatan_fungsional_id_jabatan_fungsional)) {
                $data_jabatan_fungsional = JabatanFungsional::where('id', $dosen->jabatan_fungsional_id_jabatan_fungsional)->get([
                    'id',
                    'nama_jabatan_fungsional'
                ])->first();
            }
            $data_jabatan_fungsional;

            $data_jabatan_struktural = [
                'id' => null,
                'nama_jabatan_struktural' => null
            ];
            if (!is_null($dosen->jabatan_struktural_id_jabatan_struktural)) {
                $data_jabatan_struktural = JabatanStruktural::where('id', $dosen->jabatan_struktural_id_jabatan_struktural)->get([
                    'id',
                    'nama_jabatan_struktural'
                ])->first();
            }
            $data_jabatan_struktural;
            if (!is_null($dosen->desa_dosen)) {
                $provinsi = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi/' . $dosen->provinsi_dosen)->json();
                $kabupaten = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota/' . $dosen->kabupaten_dosen)->json();
                $kecamatan = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/' . $dosen->kecamatan_dosen)->json();
                $desa = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/' . $dosen->desa_dosen)->json();

                $data = [
                    'id' => $dosen->id,
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
                    'nama_dosen' => $dosen->nama_dosen,
                    'nik_dosen' => $dosen->nik_dosen,
                    'nidn_dosen' => $dosen->nidn_dosen,
                    'nip_dosen' => $dosen->nip_dosen,
                    'tempat_lahir_dosen' => $dosen->tempat_lahir_dosen,
                    'tanggal_lahir_dosen' => $dosen->tanggal_lahir_dosen,
                    'jenis_kelamin_dosen' => $dosen->jenis_kelamin_dosen,
                    'status_perkawinan_dosen' => $dosen->status_perkawinan_dosen,
                    'agama_dosen' => $dosen->agama_dosen,
                    'nama_ibu_dosen' => $dosen->nama_ibu_dosen,
                    'gelar_dosen' => $dosen->gelar_dosen,
                    'pendidikan_terakhir_dosen' => $dosen->pendidikan_terakhir_dosen,
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
                    'jabatan_fungsional' => $data_jabatan_fungsional,
                    'jabatan_struktural' => $data_jabatan_struktural,
                    'foto_dosen' => [
                        'nama_file' => $dosen->foto_dosen,
                        'url' => 'fileFotoProfile/' . $dosen->foto_dosen

                    ],
                    'status_dosen' => $dosen->status_dosen,
                    'tanggal_pembaruan_dosen' => $dosen->updated_at->format('Y-m-d H:i:s')
                ];

                $response = [
                    'status'  => 'success',
                    'message' => 'Details Data Dosen',
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
                'id' => $dosen->id,
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
                'nama_dosen' => $dosen->nama_dosen,
                'nik_dosen' => $dosen->nik_dosen,
                'nidn_dosen' => $dosen->nidn_dosen,
                'nip_dosen' => $dosen->nip_dosen,
                'tempat_lahir_dosen' => $dosen->tempat_lahir_dosen,
                'tanggal_lahir_dosen' => $dosen->tanggal_lahir_dosen,
                'jenis_kelamin_dosen' => $dosen->jenis_kelamin_dosen,
                'status_perkawinan_dosen' => $dosen->status_perkawinan_dosen,
                'agama_dosen' => $dosen->agama_dosen,
                'nama_ibu_dosen' => $dosen->nama_ibu_dosen,
                'gelar_dosen' => $dosen->gelar_dosen,
                'pendidikan_terakhir_dosen' => $dosen->pendidikan_terakhir_dosen,
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
                'jabatan_fungsional' => $data_jabatan_fungsional,
                'jabatan_struktural' => $data_jabatan_struktural,
                'foto_dosen' => [
                    'nama_file' => $dosen->foto_dosen,
                    'url' => 'fileFotoProfile/' . $dosen->foto_dosen

                ],
                'status_dosen' => $dosen->status_dosen,
                'tanggal_pembaruan_dosen' => $dosen->updated_at->format('Y-m-d H:i:s')
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Dosen',
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
            'nama_dosen' => 'required|min:3',
            'tempat_lahir_dosen' => 'required|min:3',
            'tanggal_lahir_dosen' => 'required|date|before:today',
            'nip_dosen' => 'nullable|numeric|digits:18|unique:dosen' . ($id ? ",id,$id" : ''),
            'nik_dosen' => 'required|numeric|digits:16|unique:dosen' . ($id ? ",id,$id" : ''),
            'jabatan_fungsional_id_jabatan_fungsional' => 'nullable|exists:jabatan_fungsional,id',
            'jabatan_struktural_id_jabatan_struktural' => 'nullable|exists:jabatan_struktural,id',
            'gelar_dosen' => 'required|min:2',
            'pendidikan_terakhir_dosen' => 'required|in:S1,S2,S3',
            'status_dosen' => 'required|in:Aktif,Non Aktif',
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

        $dosen = Dosen::findorfail($id);
        $dosen->nama_dosen = $request->input('nama_dosen');
        $dosen->tempat_lahir_dosen = $request->input('tempat_lahir_dosen');
        $dosen->tanggal_lahir_dosen = $request->input('tanggal_lahir_dosen');
        $dosen->nip_dosen = $request->input('nip_dosen');
        $dosen->nik_dosen = $request->input('nik_dosen');
        $dosen->jabatan_fungsional_id_jabatan_fungsional = $request->input('jabatan_fungsional_id_jabatan_fungsional');
        $dosen->jabatan_struktural_id_jabatan_struktural = $request->input('jabatan_struktural_id_jabatan_struktural');
        $dosen->gelar_dosen = $request->input('gelar_dosen');
        $dosen->pendidikan_terakhir_dosen = $request->input('pendidikan_terakhir_dosen');
        $dosen->status_dosen = $request->input('status_dosen');

        $user = User::findorfail($dosen->user_id_user);
        $user->nama = $request->input('nama_dosen');

        $program_studi = ProgramStudi::findorfail($dosen->program_studi_id_program_studi);

        $data_jabatan_fungsional = [
            'id' => null,
            'nama_jabatan_fungsional' => null
        ];
        if (!is_null($request->get('jabatan_fungsional_id_jabatan_fungsional'))) {
            $data_jabatan_fungsional = JabatanFungsional::where('id', $request->input('jabatan_fungsional_id_jabatan_fungsional'))->get([
                'id',
                'nama_jabatan_fungsional'
            ])->first();
        }
        $data_jabatan_fungsional;

        $data_jabatan_struktural = [
            'id' => null,
            'nama_jabatan_struktural' => null
        ];
        if (!is_null($request->get('jabatan_struktural_id_jabatan_struktural'))) {
            $data_jabatan_struktural = JabatanStruktural::where('id', $request->input('jabatan_struktural_id_jabatan_struktural'))->get([
                'id',
                'nama_jabatan_struktural'
            ])->first();
        }
        $data_jabatan_struktural;

        try {
            $dosen->update();
            $user->update();
            $data = [
                'id' => $dosen->id,
                'user' => [
                    'id' => $user->id,
                    'nama' => $user->nama
                ],
                'program_studi' => [
                    'id' => $program_studi->id,
                    'kode_program_studi' => $program_studi->kode_program_studi,
                    'nama_program_studi' => $program_studi->nama_program_studi
                ],
                'nama_dosen' => $dosen->nama_dosen,
                'tempat_lahir_dosen' => $dosen->tempat_lahir_dosen,
                'tanggal_lahir_dosen' => $dosen->tanggal_lahir_dosen,
                'nip_dosen' => $dosen->nip_dosen,
                'nik_dosen' => $dosen->nik_dosen,
                'jabatan_fungsional' => $data_jabatan_fungsional,
                'jabatan_fungsional' => $data_jabatan_fungsional,
                'gelar_dosen' => $dosen->gelar_dosen,
                'pendidikan_terakhir_dosen' => $dosen->pendidikan_terakhir_dosen,
                'status_dosen' => $dosen->status_dosen,
                'updated_at' => $dosen->updated_at->diffForHumans(),
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
            ], 422);
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
            $dosen = Dosen::findOrFail($id);
            $user = User::findOrFail($dosen->user_id_user);
            $dosen->delete();
            $user->delete();
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data user & dosen with id ' . $dosen->id . ' deleted successfully'
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
            'nidn_dosen' => 'required|numeric|digits:10'
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

        $dosen = Dosen::findOrFail($id);
        $user = User::findorfail($dosen->user_id_user);
        $program_studi = ProgramStudi::findorfail($dosen->program_studi_id_program_studi);

        if ($user->username == $request->input('nidn_dosen')) {
            $user->password = bcrypt($request->input('nidn_dosen'));
            $user->api_token = Str::random(100);
            $user->update();

            $data = [
                'id' => $dosen->id,
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
            'message' => 'The nidn dosen you entered is invalid',
        ], 400);
    }

    public function filter_by_status(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();

        $dosen = Dosen::where([
            ['program_studi_id_program_studi', $program_studi->id],
            ['status_dosen', 'Aktif']
        ])->orderBy('nama_dosen', 'asc')->get('id');

        foreach ($dosen as $data_dosen) {
            $identitas_dosen = Dosen::findorfail($data_dosen->id);
            $data_dosen->nidn_dosen = $identitas_dosen->nidn_dosen;
            $data_dosen->nama_dosen = $identitas_dosen->nama_dosen . ', ' . $identitas_dosen->gelar_dosen;
        }
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data dosen at ' . $program_studi->nama_program_studi . ' with an active status',
            'data' => $dosen
        ], 200);
    }
}
