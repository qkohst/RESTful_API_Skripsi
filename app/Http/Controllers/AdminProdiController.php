<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminProdi;
use App\ProgramStudi;
use App\User;

class AdminProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_prodi = AdminProdi::get([
            'id',
            'program_studi_id_program_studi',
            'nama_admin_prodi',
            'jenis_kelamin_admin_prodi',
            'nidn_admin_prodi'
        ]);

        foreach ($admin_prodi as $data_admin_prodi) {
            $data_program_studi = ProgramStudi::findorfail($data_admin_prodi->program_studi_id_program_studi);
            $data_admin_prodi->program_studi = [
                'id' => $data_program_studi->id,
                'nama_program_studi' => $data_program_studi->nama_program_studi
            ];
        }

        $response = [
            'message' => 'List of Data',
            'admin_prodi' => $admin_prodi
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
        $this->validate($request, [
            'program_studi_id_program_studi' => 'required|exists:program_studi,id',
            'nik_admin_prodi' => 'required|unique:admin_prodi|numeric|digits:16',
            'nidn_admin_prodi' => 'required|unique:admin_prodi|numeric|digits:10',
            'nip_admin_prodi' => 'nullable|unique:admin_prodi|numeric|digits:18',
            'nama_admin_prodi' => 'required|min:3',
            'tempat_lahir_admin_prodi' => 'required|min:3',
            'tanggal_lahir_admin_prodi' => 'required|date',
            'jenis_kelamin_admin_prodi' => 'required|in:L,P',
            'foto_admin_prodi' => 'nullable|mimes:jpg,jpeg,png|max:2000',
            'no_surat_tugas_admin_prodi' => 'required|unique:admin_prodi|min:5',
            'email_admin_prodi' => 'required|unique:admin_prodi|email',
            'no_hp_admin_prodi' => 'required|unique:admin_prodi|numeric|digits_between:11,13',
        ]);

        //Menyimpan Data User
        $user = new User([
            'nama' => $request->input('nama_admin_prodi'),
            'username' => $request->input('nidn_admin_prodi'),
            'password' => bcrypt($request->input('nidn_admin_prodi')),
            'role' => 'Admin Prodi',
            'api_token' => bcrypt($request->username . 'Admin Prodi'),

        ]);

        //Ketika User Berhasil Disimpan {Menambahkan Data Admin Prodi}
        if ($user->save()) {
            //Menyimpan Data Admin Prodi
            try {
                $program_studi = ProgramStudi::findorfail($request->input('program_studi_id_program_studi'));

                //Jika Upload Foto
                if ($request->hasFile('foto_admin_prodi')) {
                    $file_foto = $request->file('foto_admin_prodi');
                    $fotoName = 'img-' . $user->username . '.' . $file_foto->getClientOriginalExtension();
                    $file_foto->move('fileFotoProfile/', $fotoName);

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

                    $response = [
                        'message' => 'Data added successfully',
                        'admin_prodi' => $data
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

                $response = [
                    'message' => 'Data added successfully',
                    'admin_prodi' => $data
                ];
                return response()->json($response, 201);
            } catch (\Illuminate\Database\QueryException $ex) {
                // response ketika data admin prodi gagal disimpan 
                $user_delete = User::findOrFail($user->id);
                $user_delete->delete();
                $response = [
                    'message' => 'an error occurred while saving the data admin prodi, make sure that you have entered the correct data format!'
                ];
                return response()->json($response, 404);
            }
        }
        // response ketika data user gagal disimpan 
        $response = [
            'message' => 'an error occurred while saving the data user admin prodi'
        ];
        return response()->json($response, 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
                'created_at' => $admin_prodi->created_at->diffForHumans(),
                'updated_at' => $admin_prodi->updated_at->diffForHumans(),
            ];

            $response = [
                'message' => 'Data details',
                'detail_admin_prodi' => $data
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
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
        $this->validate($request, [
            'nama_admin_prodi' => 'required|min:3',
            'nik_admin_prodi' => 'required|numeric|digits:16|unique:program_studi' . ($id ? ",id,$id" : ''),
            'nip_admin_prodi' => 'nullable|numeric|digits:18|unique:program_studi' . ($id ? ",id,$id" : ''),
        ]);

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

            $response = [
                'message' => 'Data Edited Successfully',
                'admin_prodi' => $data
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
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
    public function destroy($id)
    {
        try {
            $admin_prodi = AdminProdi::findOrFail($id);
            $user = User::findOrFail($admin_prodi->user_id_user);
            $admin_prodi->delete();
            $user->delete();
            return response()->json([
                'message' => 'Data user & admin prodi with id ' . $admin_prodi->id . ' deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'Sorry the data cannot be deleted, there are still data in other tables that are related to this data!'
            ], 404);
        }
    }

    public function resetpassword(Request $request, $id)
    {
        $this->validate($request, [
            'nidn_admin_prodi' => 'required|numeric|digits:10'
        ]);
        $admin_prodi = AdminProdi::findOrFail($id);
        $user = User::findorfail($admin_prodi->user_id_user);
        $program_studi = ProgramStudi::findorfail($admin_prodi->program_studi_id_program_studi);

        if ($user->username == $request->input('nidn_admin_prodi')) {
            $user->password = bcrypt($request->input('nidn_admin_prodi'));
            $user->api_token = bcrypt($request->input('nidn_admin_prodi') . 'Admin Prodi');
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

            return response()->json([
                'message' => 'password reset successful',
                'admin_prodi' => $data
            ], 205);
        }

        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => [
                'nidn_admin_prodi' => 'The nidn admin prodi you entered is invalid'
            ],
        ], 400);
    }
}
