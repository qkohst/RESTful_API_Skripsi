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

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();
        $dosen = Dosen::where('program_studi_id_program_studi', $program_studi->id)->get([
            'id',
            'nama_dosen',
            'nidn_dosen',
            'nip_dosen',
            'jenis_kelamin_dosen',
            'tanggal_lahir_dosen',
            'status_dosen',
        ]);
        $response = [
            'message' => 'List Dosen of Program Studi ' . $program_studi->nama_program_studi,
            'dosen' => $dosen,
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
            'nama_dosen' => 'required|min:3',
            'nik_dosen' => 'required|unique:dosen|numeric|digits:16',
            'nidn_dosen' => 'required|unique:dosen|numeric|digits:10',
            'nip_dosen' => 'nullable|unique:dosen|numeric|digits:18',
            'tempat_lahir_dosen' => 'required|min:3',
            'tanggal_lahir_dosen' => 'required|date',
            'jenis_kelamin_dosen' => 'required|in:L,P',
            'status_perkawinan_dosen' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'agama_dosen' => 'required|in:Islam, Protestan, Katolik, Hindu, Budha, Khonghucu, Kepercayaan',
            'nama_ibu_dosen' => 'required|min:3',
            'gelar_dosen' => 'required|min:2',
            'pendidikan_terakhir_dosen' => 'required|in:S1,S2,S3',
            'alamat_dosen' => 'nullable|max:100',
            'provinsi_dosen' => 'required|min:3',
            'kabupaten_dosen' => 'required|min:3',
            'kecamatan_dosen' => 'required|min:3',
            'desa_dosen' => 'required|min:3',
            'email_dosen' => 'required|unique:dosen|email',
            'no_hp_dosen' => 'required|unique:dosen|numeric|digits_between:11,13',
            'jabatan_fungsional_id_jabatan_fungsional' => 'nullable|exists:jabatan_fungsional,id',
            'jabatan_struktural_id_jabatan_struktural' => 'nullable|exists:jabatan_struktural,id',
            'foto_dosen' => 'nullable|mimes:jpg,jpeg,png|max:2000',
        ]);

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
            'api_token' => bcrypt($request->username . 'Dosen'),
        ]);

        if ($user->save()) {
            try {
                if ($request->hasFile('foto_dosen')) {
                    $file_foto = $request->file('foto_dosen');
                    $fotoName = 'img-' . date('mdYHis') . '.' . $file_foto->getClientOriginalExtension();
                    $file_foto->move('fileFotoProfile/', $fotoName);

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
                        'status_perkawinan_dosen' => $request->input('status_perkawinan_dosen'),
                        'agama_dosen' => $request->input('agama_dosen'),
                        'nama_ibu_dosen' => $request->input('nama_ibu_dosen'),
                        'gelar_dosen' => $request->input('gelar_dosen'),
                        'pendidikan_terakhir_dosen' => $request->input('pendidikan_terakhir_dosen'),
                        'alamat_dosen' => $request->input('alamat_dosen'),
                        'provinsi_dosen' => $request->input('provinsi_dosen'),
                        'kabupaten_dosen' => $request->input('kabupaten_dosen'),
                        'kecamatan_dosen' => $request->input('kecamatan_dosen'),
                        'desa_dosen' => $request->input('desa_dosen'),
                        'email_dosen' => $request->input('email_dosen'),
                        'no_hp_dosen' => $request->input('no_hp_dosen'),
                        'jabatan_fungsional_id_jabatan_fungsional' => $request->input('jabatan_fungsional_id_jabatan_fungsional'),
                        'jabatan_struktural_id_jabatan_struktural' => $request->input('jabatan_struktural_id_jabatan_struktural'),
                        'foto_dosen' => $fotoName,
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
                        'status_perkawinan_dosen' => $dosen->status_perkawinan_dosen,
                        'agama_dosen' => $dosen->agama_dosen,
                        'nama_ibu_dosen' => $dosen->nama_ibu_dosen,
                        'gelar_dosen' => $dosen->gelar_dosen,
                        'pendidikan_terakhir_dosen' => $dosen->pendidikan_terakhir_dosen,
                        'alamat_dosen' => $dosen->alamat_dosen,
                        'provinsi_dosen' => $dosen->provinsi_dosen,
                        'kabupaten_dosen' => $dosen->kabupaten_dosen,
                        'kecamatan_dosen' => $dosen->kecamatan_dosen,
                        'desa_dosen' => $dosen->desa_dosen,
                        'email_dosen' => $dosen->email_dosen,
                        'nomor_hp_dosen' => $dosen->nomor_hp_dosen,
                        'jabatan_fungsional' => $data_jabatan_fungsional,
                        'jabatan_struktural' => $data_jabatan_struktural,
                        'foto_dosen' => [
                            'nama_file' => $dosen->foto_dosen,
                            'url' => 'fileFotoProfile/' . $dosen->foto_dosen

                        ],
                        'status_dosen' => $dosen->status_dosen,
                        'created_at' => $dosen->created_at->diffForHumans(),
                    ];

                    $response = [
                        'message' => 'Data added successfully',
                        'dosen' => $data
                    ];
                    return response()->json($response, 201);
                }
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
                    'status_perkawinan_dosen' => $request->input('status_perkawinan_dosen'),
                    'agama_dosen' => $request->input('agama_dosen'),
                    'nama_ibu_dosen' => $request->input('nama_ibu_dosen'),
                    'gelar_dosen' => $request->input('gelar_dosen'),
                    'pendidikan_terakhir_dosen' => $request->input('pendidikan_terakhir_dosen'),
                    'alamat_dosen' => $request->input('alamat_dosen'),
                    'provinsi_dosen' => $request->input('provinsi_dosen'),
                    'kabupaten_dosen' => $request->input('kabupaten_dosen'),
                    'kecamatan_dosen' => $request->input('kecamatan_dosen'),
                    'desa_dosen' => $request->input('desa_dosen'),
                    'email_dosen' => $request->input('email_dosen'),
                    'no_hp_dosen' => $request->input('no_hp_dosen'),
                    'jabatan_fungsional_id_jabatan_fungsional' => $request->input('jabatan_fungsional_id_jabatan_fungsional'),
                    'jabatan_struktural_id_jabatan_struktural' => $request->input('jabatan_struktural_id_jabatan_struktural'),
                    'foto_dosen' => $request->input('foto_dosen'),
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
                    'status_perkawinan_dosen' => $dosen->status_perkawinan_dosen,
                    'agama_dosen' => $dosen->agama_dosen,
                    'nama_ibu_dosen' => $dosen->nama_ibu_dosen,
                    'gelar_dosen' => $dosen->gelar_dosen,
                    'pendidikan_terakhir_dosen' => $dosen->pendidikan_terakhir_dosen,
                    'alamat_dosen' => $dosen->alamat_dosen,
                    'provinsi_dosen' => $dosen->provinsi_dosen,
                    'kabupaten_dosen' => $dosen->kabupaten_dosen,
                    'kecamatan_dosen' => $dosen->kecamatan_dosen,
                    'desa_dosen' => $dosen->desa_dosen,
                    'email_dosen' => $dosen->email_dosen,
                    'nomor_hp_dosen' => $dosen->nomor_hp_dosen,
                    'jabatan_fungsional' => $data_jabatan_fungsional,
                    'jabatan_struktural' => $data_jabatan_struktural,
                    'foto_dosen' => [
                        'nama_file' => $dosen->foto_dosen,
                        'url' => 'fileFotoProfile/' . $dosen->foto_dosen

                    ],
                    'status_dosen' => $dosen->status_dosen,
                    'created_at' => $dosen->created_at->diffForHumans(),
                ];

                $response = [
                    'message' => 'Data added successfully',
                    'dosen' => $data
                ];
                return response()->json($response, 201);
            } catch (\Throwable $th) {
                $user_delete = User::findOrFail($user->id);
                $user_delete->delete();
                $response = [
                    'message' => 'an error occurred while saving the data mahasiswa, make sure that you have entered the correct data format!'
                ];
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
    public function show($id)
    {
        try {
            $dosen = Dosen::findorfail($id);
            $data_user = User::findorfail($dosen->user_id_user);
            $program_studi = ProgramStudi::findorfail($dosen->program_studi_id_program_studi);

            $data_jabatan_fungsional = [
                'id' => 'null',
                'nama_jabatan_fungsional' => 'null'
            ];
            if (!is_null($dosen->jabatan_fungsional_id_jabatan_fungsional)) {
                $data_jabatan_fungsional = JabatanFungsional::where('id', $dosen->jabatan_fungsional_id_jabatan_fungsional)->get([
                    'id',
                    'nama_jabatan_fungsional'
                ])->first();
            }
            $data_jabatan_fungsional;

            $data_jabatan_struktural = [
                'id' => 'null',
                'nama_jabatan_struktural' => 'null'
            ];
            if (!is_null($dosen->jabatan_struktural_id_jabatan_struktural)) {
                $data_jabatan_struktural = JabatanStruktural::where('id', $dosen->jabatan_struktural_id_jabatan_struktural)->get([
                    'id',
                    'nama_jabatan_struktural'
                ])->first();
            }
            $data_jabatan_struktural;

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
                'provinsi_dosen' => $dosen->provinsi_dosen,
                'kabupaten_dosen' => $dosen->kabupaten_dosen,
                'kecamatan_dosen' => $dosen->kecamatan_dosen,
                'desa_dosen' => $dosen->desa_dosen,
                'email_dosen' => $dosen->email_dosen,
                'nomor_hp_dosen' => $dosen->nomor_hp_dosen,
                'jabatan_fungsional' => $data_jabatan_fungsional,
                'jabatan_struktural' => $data_jabatan_struktural,
                'foto_dosen' => [
                    'nama_file' => $dosen->foto_dosen,
                    'url' => 'fileFotoProfile/' . $dosen->foto_dosen

                ],
                'status_dosen' => $dosen->status_dosen,
                'updated_at' => $dosen->updated_at->diffForHumans(),
            ];

            $response = [
                'message' => 'Data details',
                'detail_dosen' => $data
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
            'nama_dosen' => 'required|min:3',
            'tempat_lahir_dosen' => 'required|min:3',
            'tanggal_lahir_dosen' => 'required|date',
            'nip_dosen' => 'nullable|numeric|digits:18|unique:dosen' . ($id ? ",id,$id" : ''),
            'nik_dosen' => 'required|numeric|digits:16|unique:dosen' . ($id ? ",id,$id" : ''),
            'jabatan_fungsional_id_jabatan_fungsional' => 'nullable|exists:jabatan_fungsional,id',
            'jabatan_struktural_id_jabatan_struktural' => 'nullable|exists:jabatan_struktural,id',
            'gelar_dosen' => 'required|min:2',
            'pendidikan_terakhir_dosen' => 'required|in:S1,S2,S3',
            'status_dosen' => 'required|in:Aktif,Non Aktif',
        ]);

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
                'message' => 'Data Edited Successfully',
                'dosen' => $data
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
            $dosen = Dosen::findOrFail($id);
            $user = User::findOrFail($dosen->user_id_user);
            $dosen->delete();
            $user->delete();
            return response()->json([
                'message' => 'Data user & dosen with id ' . $dosen->id . ' deleted successfully'
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
            'nidn_dosen' => 'required|numeric|digits:10'
        ]);
        $dosen = Dosen::findOrFail($id);
        $user = User::findorfail($dosen->user_id_user);
        $program_studi = ProgramStudi::findorfail($dosen->program_studi_id_program_studi);

        if ($user->username == $request->input('nidn_dosen')) {
            $user->password = bcrypt($request->input('nidn_dosen'));
            $user->api_token = bcrypt($request->input('nidn_dosen') . 'Dosen');
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

            return response()->json([
                'message' => 'password reset successful',
                'dosen' => $data
            ], 205);
        }

        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => [
                'nidn_dosen' => 'The nidn dosen you entered is invalid'
            ],
        ], 400);
    }

    public function filter_by_status()
    {
        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();

        $dosen = Dosen::where([
            ['program_studi_id_program_studi', $program_studi->id],
            ['status_dosen', 'Aktif']
        ])->orderBy('nama_dosen', 'asc')->get([
            'id',
            'nidn_dosen',
            'nama_dosen'
        ]);

        return response()->json([
            'message' => 'Data dosen at ' . $program_studi->nama_program_studi . ' with an active status',
            'dosen' => $dosen
        ], 200);
    }
}
