<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminProdi;
use App\ProgramStudi;
use App\User;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AdminProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $admin_prodi = AdminProdi::orderBy('program_studi_id_program_studi', 'asc')
            ->get('id');

        foreach ($admin_prodi as $admin) {
            $data_admin_prodi = AdminProdi::findorfail($admin->id);
            $data_program_studi = ProgramStudi::findorfail($data_admin_prodi->program_studi_id_program_studi);
            $admin->program_studi = [
                'id' => $data_program_studi->id,
                'nama_program_studi' => $data_program_studi->nama_program_studi
            ];
            $admin->nama_admin_prodi = $data_admin_prodi->nama_admin_prodi;
            $admin->jenis_kelamin_admin_prodi = $data_admin_prodi->jenis_kelamin_admin_prodi;
            $admin->nidn_admin_prodi = $data_admin_prodi->nidn_admin_prodi;
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        $response = [
            'status'  => 'success',
            'message' => 'List of Data Admin Prodi',
            'data' => $admin_prodi
        ];
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
            'program_studi_id_program_studi' => 'required|exists:program_studi,id|unique:admin_prodi',
            'nik_admin_prodi' => 'required|unique:admin_prodi|numeric|digits:16',
            'nidn_admin_prodi' => 'required|unique:admin_prodi|numeric|digits:10',
            'nip_admin_prodi' => 'nullable|unique:admin_prodi|numeric|digits:18',
            'nama_admin_prodi' => 'required|min:3',
            'tempat_lahir_admin_prodi' => 'required|min:3',
            'tanggal_lahir_admin_prodi' => 'required|date|before:today',
            'jenis_kelamin_admin_prodi' => 'required|in:L,P',
            'foto_admin_prodi' => 'nullable|image|max:2000',
            'no_surat_tugas_admin_prodi' => 'required|unique:admin_prodi|min:5',
            'email_admin_prodi' => 'required|unique:admin_prodi|email',
            'no_hp_admin_prodi' => 'required|unique:admin_prodi|numeric|digits_between:11,13',
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

        $program_studi = ProgramStudi::findorfail($request->program_studi_id_program_studi);

        //Menyimpan Data User
        $user = new User([
            'nama' => $request->input('nama_admin_prodi'),
            'username' => $program_studi->kode_program_studi . "000001",
            'password' => bcrypt($program_studi->kode_program_studi . "000001"),
            'role' => 'Admin Prodi',
            'api_token' => Str::random(100),

        ]);

        //Ketika User Berhasil Disimpan {Menambahkan Data Admin Prodi}
        if ($user->save()) {
            //Menyimpan Data Admin Prodi
            try {
                //Jika Upload Foto
                if ($request->hasFile('foto_admin_prodi')) {
                    $file_foto = $request->file('foto_admin_prodi');
                    $fotoName = 'img-' . $user->username . '.' . $file_foto->getClientOriginalExtension();
                    $file_foto->move('api/v1/fileFotoProfile/', $fotoName);

                    $admin_prodi = new AdminProdi([
                        'user_id_user' => $user->id,
                        'program_studi_id_program_studi' => $request->input('program_studi_id_program_studi'),
                        'nik_admin_prodi' => $request->input('nik_admin_prodi'),
                        'nidn_admin_prodi' => $request->input('nidn_admin_prodi'),
                        'nip_admin_prodi' => $request->input('nip_admin_prodi'),
                        'nama_admin_prodi' => $request->input('nama_admin_prodi'),
                        'tempat_lahir_admin_prodi' => $request->input('tempat_lahir_admin_prodi'),
                        'tanggal_lahir_admin_prodi' => $request->input('tanggal_lahir_admin_prodi'),
                        'jenis_kelamin_admin_prodi' => $request->input('jenis_kelamin_admin_prodi'),
                        'foto_admin_prodi' => $fotoName,
                        'no_surat_tugas_admin_prodi' => $request->input('no_surat_tugas_admin_prodi'),
                        'email_admin_prodi' => $request->input('email_admin_prodi'),
                        'no_hp_admin_prodi' => $request->input('no_hp_admin_prodi'),
                    ]);

                    $admin_prodi->save();

                    $data = [
                        'id' => $admin_prodi->id,
                        'user' => [
                            'id' => $user->id,
                            'nama' => $user->nama,
                            'username' => $user->username,
                            'role' => $user->role
                        ],
                        'program_studi' => [
                            'id' => $program_studi->id,
                            'kode_program_studi' => $program_studi->kode_program_studi,
                            'nama_program_studi' => $program_studi->nama_program_studi
                        ],
                        'nik_admin_prodi' => $admin_prodi->nik_admin_prodi,
                        'nidn_admin_prodi' => $admin_prodi->nidn_admin_prodi,
                        'nip_admin_prodi' => $admin_prodi->nip_admin_prodi,
                        'nama_admin_prodi' => $admin_prodi->nama_admin_prodi,
                        'tempat_lahir_admin_prodi' => $admin_prodi->tempat_lahir_admin_prodi,
                        'tanggal_lahir_admin_prodi' => $admin_prodi->tanggal_lahir_admin_prodi,
                        'jenis_kelamin_admin_prodi' => $admin_prodi->jenis_kelamin_admin_prodi,
                        'foto_admin_prodi' => [
                            'nama_file' => $admin_prodi->foto_admin_prodi,
                            'url' => 'fileFotoProfile/' . $admin_prodi->foto_admin_prodi
                        ],
                        'no_surat_tugas_admin_prodi' => $admin_prodi->no_surat_tugas_admin_prodi,
                        'email_admin_prodi' => $admin_prodi->email_admin_prodi,
                        'created_at' => $admin_prodi->created_at->diffForHumans(),
                    ];

                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '1',
                    ]);
                    $traffic->save();

                    $response = [
                        'status'  => 'success',
                        'message' => 'Data added successfully',
                        'data' => $data
                    ];
                    return response()->json($response, 201);
                }

                //Jika Tidak Upload Foto
                $admin_prodi = new AdminProdi([
                    'user_id_user' => $user->id,
                    'program_studi_id_program_studi' => $request->input('program_studi_id_program_studi'),
                    'nik_admin_prodi' => $request->input('nik_admin_prodi'),
                    'nidn_admin_prodi' => $request->input('nidn_admin_prodi'),
                    'nip_admin_prodi' => $request->input('nip_admin_prodi'),
                    'nama_admin_prodi' => $request->input('nama_admin_prodi'),
                    'tempat_lahir_admin_prodi' => $request->input('tempat_lahir_admin_prodi'),
                    'tanggal_lahir_admin_prodi' => $request->input('tanggal_lahir_admin_prodi'),
                    'jenis_kelamin_admin_prodi' => $request->input('jenis_kelamin_admin_prodi'),
                    'foto_admin_prodi' => $request->input('foto_admin_prodi'),
                    'no_surat_tugas_admin_prodi' => $request->input('no_surat_tugas_admin_prodi'),
                    'email_admin_prodi' => $request->input('email_admin_prodi'),
                    'no_hp_admin_prodi' => $request->input('no_hp_admin_prodi'),
                ]);

                $admin_prodi->save();

                $data = [
                    'id' => $admin_prodi->id,
                    'user' => [
                        'id' => $user->id,
                        'nama' => $user->nama,
                        'username' => $user->username,
                        'role' => $user->role
                    ],
                    'program_studi' => [
                        'id' => $program_studi->id,
                        'kode_program_studi' => $program_studi->kode_program_studi,
                        'nama_program_studi' => $program_studi->nama_program_studi
                    ],
                    'nik_admin_prodi' => $admin_prodi->nik_admin_prodi,
                    'nidn_admin_prodi' => $admin_prodi->nidn_admin_prodi,
                    'nip_admin_prodi' => $admin_prodi->nip_admin_prodi,
                    'nama_admin_prodi' => $admin_prodi->nama_admin_prodi,
                    'tempat_lahir_admin_prodi' => $admin_prodi->tempat_lahir_admin_prodi,
                    'tanggal_lahir_admin_prodi' => $admin_prodi->tanggal_lahir_admin_prodi,
                    'jenis_kelamin_admin_prodi' => $admin_prodi->jenis_kelamin_admin_prodi,
                    'foto_admin_prodi' => [
                        'nama_file' => $admin_prodi->foto_admin_prodi,
                        'url' => 'fileFotoProfile/' . $admin_prodi->foto_admin_prodi
                    ],
                    'no_surat_tugas_admin_prodi' => $admin_prodi->no_surat_tugas_admin_prodi,
                    'email_admin_prodi' => $admin_prodi->email_admin_prodi,
                    'created_at' => $admin_prodi->created_at->diffForHumans(),
                ];

                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                $response = [
                    'status'  => 'success',
                    'message' => 'Data added successfully',
                    'data' => $data
                ];
                return response()->json($response, 201);
            } catch (\Illuminate\Database\QueryException $ex) {
                // response ketika data admin prodi gagal disimpan 
                $user_delete = User::findOrFail($user->id);
                $user_delete->delete();
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

                $response = [
                    'status'  => 'error',
                    'message' => 'an error occurred while saving the data admin prodi, make sure that you have entered the correct data format!'
                ];
                return response()->json($response, 400);
            }
        }
        // response ketika data user gagal disimpan 
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();

        $response = [
            'status'  => 'error',
            'message' => 'an error occurred while saving the data user admin prodi'
        ];
        return response()->json($response, 400);
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
            $admin_prodi = AdminProdi::findorfail($id);
            $data_user = User::findorfail($admin_prodi->user_id_user);
            $program_studi = ProgramStudi::findorfail($admin_prodi->program_studi_id_program_studi);

            $data = [
                'id' => $admin_prodi->id,
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
                'nik_admin_prodi' => $admin_prodi->nik_admin_prodi,
                'nidn_admin_prodi' => $admin_prodi->nidn_admin_prodi,
                'nip_admin_prodi' => $admin_prodi->nip_admin_prodi,
                'nama_admin_prodi' => $admin_prodi->nama_admin_prodi,
                'tempat_lahir_admin_prodi' => $admin_prodi->tempat_lahir_admin_prodi,
                'tanggal_lahir_admin_prodi' => $admin_prodi->tanggal_lahir_admin_prodi,
                'jenis_kelamin_admin_prodi' => $admin_prodi->jenis_kelamin_admin_prodi,
                'foto_admin_prodi' => [
                    'nama_file' => $admin_prodi->foto_admin_prodi,
                    'url' => 'fileFotoProfile/' . $admin_prodi->foto_admin_prodi
                ],
                'no_surat_tugas_admin_prodi' => $admin_prodi->no_surat_tugas_admin_prodi,
                'email_admin_prodi' => $admin_prodi->email_admin_prodi,
                'no_hp_admin_prodi' => $admin_prodi->no_hp_admin_prodi,
                'tanggal_pembaruan_admin_prodi' => $admin_prodi->updated_at->format('Y-m-d H:i:s')
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Admin Prodi',
                'data' => $data
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'error',
                'message' => 'Data not found',
            ];

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
            'nama_admin_prodi' => 'required|min:3',
            'nik_admin_prodi' => 'required|numeric|digits:16|unique:program_studi' . ($id ? ",id,$id" : ''),
            'nip_admin_prodi' => 'nullable|numeric|digits:18|unique:program_studi' . ($id ? ",id,$id" : ''),
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

        $admin_prodi = AdminProdi::findorfail($id);
        $admin_prodi->nama_admin_prodi = $request->input('nama_admin_prodi');
        $admin_prodi->nik_admin_prodi = $request->input('nik_admin_prodi');
        $admin_prodi->nip_admin_prodi = $request->input('nip_admin_prodi');

        $user = User::findorfail($admin_prodi->user_id_user);
        $user->nama = $request->input('nama_admin_prodi');

        $program_studi = ProgramStudi::findorfail($admin_prodi->program_studi_id_program_studi);

        try {
            $admin_prodi->update();
            $user->update();
            $data = [
                'id' => $admin_prodi->id,
                'user' => [
                    'id' => $user->id,
                    'nama' => $user->nama
                ],
                'program_studi' => [
                    'id' => $program_studi->id,
                    'kode_program_studi' => $program_studi->kode_program_studi,
                    'nama_program_studi' => $program_studi->nama_program_studi
                ],
                'nama_admin_prodi' => $admin_prodi->nama_admin_prodi,
                'nip_admin_prodi' => $admin_prodi->nip_admin_prodi,
                'nik_admin_prodi' => $admin_prodi->nik_admin_prodi,
                'updated_at' => $admin_prodi->updated_at->diffForHumans(),
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'success',
                'message' => 'Data Edited Successfully',
                'data' => $data
            ];

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
            ], 404);
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
            $admin_prodi = AdminProdi::findOrFail($id);
            $user = User::findOrFail($admin_prodi->user_id_user);
            $admin_prodi->delete();
            $user->delete();
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data user & admin prodi with id ' . $admin_prodi->id . ' deleted successfully'
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
            ], 404);
        }
    }

    public function resetpassword(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'nidn_admin_prodi' => 'required|numeric|digits:10'
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

        $admin_prodi = AdminProdi::findOrFail($id);
        $user = User::findorfail($admin_prodi->user_id_user);
        $program_studi = ProgramStudi::findorfail($admin_prodi->program_studi_id_program_studi);

        if ($admin_prodi->nidn_admin_prodi == $request->input('nidn_admin_prodi')) {
            $user->password = bcrypt($program_studi->kode_program_studi . "000001");
            $user->api_token = Str::random(100);
            $user->update();

            $data = [
                'id' => $admin_prodi->id,
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
            'message' => 'The nidn admin prodi you entered is invalid',
        ], 400);
    }
}
