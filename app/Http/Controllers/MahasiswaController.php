<?php

namespace App\Http\Controllers;

use App\AdminProdi;
use App\Mahasiswa;
use App\User;
use App\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
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
        $mahasiswa = Mahasiswa::where('program_studi_id_program_studi', $program_studi->id)->orderby('npm_mahasiswa','asc')->get([
            'id',
            'nama_mahasiswa',
            'npm_mahasiswa',
            'jenis_kelamin_mahasiswa',
            'tanggal_lahir_mahasiswa',
            'semester_mahasiswa',
            'status_mahasiswa',
        ]);
        $response = [
            'message' => 'List Mahasiswa of Program Studi ' . $program_studi->nama_program_studi,
            'mahasiswa' => $mahasiswa,
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
            'nama_mahasiswa' => 'required|min:3',
            'npm_mahasiswa' => 'required|unique:mahasiswa|numeric|digits:10',
            'semester_mahasiswa' => 'required|numeric|between:1,14',
            'tempat_lahir_mahasiswa' => 'required|min:3',
            'tanggal_lahir_mahasiswa' => 'required|date',
            'jenis_kelamin_mahasiswa' => 'required|in:L,P',
            'status_perkawinan_mahasiswa' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'agama_mahasiswa' => 'required|in:Islam, Protestan, Katolik, Hindu, Budha, Khonghucu, Kepercayaan',
            'nama_ibu_mahasiswa' => 'required|min:3',
            'alamat_mahasiswa' => 'nullable|max:100',
            'provinsi_mahasiswa' => 'required|min:3',
            'kabupaten_mahasiswa' => 'required|min:3',
            'kecamatan_mahasiswa' => 'required|min:3',
            'desa_mahasiswa' => 'required|min:3',
            'email_mahasiswa' => 'required|unique:mahasiswa|email',
            'no_hp_mahasiswa' => 'required|unique:mahasiswa|numeric|digits_between:11,13',
            'foto_mahasiswa' => 'nullable|mimes:jpg,jpeg,png|max:2000',
        ]);

        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();

        $user = new User([
            'nama' => $request->input('nama_mahasiswa'),
            'username' => $request->input('npm_mahasiswa'),
            'password' => bcrypt($request->input('npm_mahasiswa')),
            'role' => 'Mahasiswa',
            'api_token' => bcrypt($request->username . 'Mahasiswa'),
        ]);

        if ($user->save()) {
            try {
                //Jika Upload Foto
                if ($request->hasFile('foto_mahasiswa')) {
                    $file_foto = $request->file('foto_mahasiswa');
                    $fotoName = 'img-' . $user->username . '.' . $file_foto->getClientOriginalExtension();
                    $file_foto->move('fileFotoProfile/', $fotoName);

                    $mahasiswa = new Mahasiswa([
                        'user_id_user' => $user->id,
                        'program_studi_id_program_studi' => $program_studi->id,
                        'nama_mahasiswa' => $request->input('nama_mahasiswa'),
                        'npm_mahasiswa' => $request->input('npm_mahasiswa'),
                        'tempat_lahir_mahasiswa' => $request->input('tempat_lahir_mahasiswa'),
                        'tanggal_lahir_mahasiswa' => $request->input('tanggal_lahir_mahasiswa'),
                        'jenis_kelamin_mahasiswa' => $request->input('jenis_kelamin_mahasiswa'),
                        'status_perkawinan_mahasiswa' => $request->input('status_perkawinan_mahasiswa'),
                        'agama_mahasiswa' => $request->input('agama_mahasiswa'),
                        'nama_ibu_mahasiswa' => $request->input('nama_ibu_mahasiswa'),
                        'semester_mahasiswa' => $request->input('semester_mahasiswa'),
                        'alamat_mahasiswa' => $request->input('alamat_mahasiswa'),
                        'provinsi_mahasiswa' => $request->input('provinsi_mahasiswa'),
                        'kabupaten_mahasiswa' => $request->input('kabupaten_mahasiswa'),
                        'kecamatan_mahasiswa' => $request->input('kecamatan_mahasiswa'),
                        'desa_mahasiswa' => $request->input('desa_mahasiswa'),
                        'foto_mahasiswa' => $fotoName,
                        'email_mahasiswa' => $request->input('email_mahasiswa'),
                        'no_hp_mahasiswa' => $request->input('no_hp_mahasiswa'),
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
                        'status_perkawinan_mahasiswa' => $mahasiswa->status_perkawinan_mahasiswa,
                        'agama_mahasiswa' => $mahasiswa->agama_mahasiswa,
                        'nama_ibu_mahasiswa' => $mahasiswa->nama_ibu_mahasiswa,
                        'alamat_mahasiswa' => $mahasiswa->alamat_mahasiswa,
                        'provinsi_mahasiswa' => $mahasiswa->provinsi_mahasiswa,
                        'kabupaten_mahasiswa' => $mahasiswa->kabupaten_mahasiswa,
                        'kecamatan_mahasiswa' => $mahasiswa->kecamatan_mahasiswa,
                        'desa_mahasiswa' => $mahasiswa->desa_mahasiswa,
                        'foto_mahasiswa' => [
                            'nama_file' => $mahasiswa->foto_mahasiswa,
                            'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
                        ],
                        'email_mahasiswa' => $mahasiswa->email_mahasiswa,
                        'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
                        'status_mahasiswa' => $mahasiswa->status_mahasiswa,
                        'created_at' => $mahasiswa->created_at->diffForHumans(),
                    ];

                    $response = [
                        'message' => 'Data added successfully',
                        'mahasiswa' => $data
                    ];
                    return response()->json($response, 201);
                }

                //Jika Tidak Upload Foto
                $mahasiswa = new Mahasiswa([
                    'user_id_user' => $user->id,
                    'program_studi_id_program_studi' => $program_studi->id,
                    'nama_mahasiswa' => $request->input('nama_mahasiswa'),
                    'npm_mahasiswa' => $request->input('npm_mahasiswa'),
                    'tempat_lahir_mahasiswa' => $request->input('tempat_lahir_mahasiswa'),
                    'tanggal_lahir_mahasiswa' => $request->input('tanggal_lahir_mahasiswa'),
                    'jenis_kelamin_mahasiswa' => $request->input('jenis_kelamin_mahasiswa'),
                    'status_perkawinan_mahasiswa' => $request->input('status_perkawinan_mahasiswa'),
                    'agama_mahasiswa' => $request->input('agama_mahasiswa'),
                    'nama_ibu_mahasiswa' => $request->input('nama_ibu_mahasiswa'),
                    'semester_mahasiswa' => $request->input('semester_mahasiswa'),
                    'alamat_mahasiswa' => $request->input('alamat_mahasiswa'),
                    'provinsi_mahasiswa' => $request->input('provinsi_mahasiswa'),
                    'kabupaten_mahasiswa' => $request->input('kabupaten_mahasiswa'),
                    'kecamatan_mahasiswa' => $request->input('kecamatan_mahasiswa'),
                    'desa_mahasiswa' => $request->input('desa_mahasiswa'),
                    'foto_mahasiswa' => $request->input('foto_mahasiswa'),
                    'email_mahasiswa' => $request->input('email_mahasiswa'),
                    'no_hp_mahasiswa' => $request->input('no_hp_mahasiswa'),
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
                    'status_perkawinan_mahasiswa' => $mahasiswa->status_perkawinan_mahasiswa,
                    'agama_mahasiswa' => $mahasiswa->agama_mahasiswa,
                    'nama_ibu_mahasiswa' => $mahasiswa->nama_ibu_mahasiswa,
                    'alamat_mahasiswa' => $mahasiswa->alamat_mahasiswa,
                    'provinsi_mahasiswa' => $mahasiswa->provinsi_mahasiswa,
                    'kabupaten_mahasiswa' => $mahasiswa->kabupaten_mahasiswa,
                    'kecamatan_mahasiswa' => $mahasiswa->kecamatan_mahasiswa,
                    'desa_mahasiswa' => $mahasiswa->desa_mahasiswa,
                    'foto_mahasiswa' => [
                        'nama_file' => $mahasiswa->foto_mahasiswa,
                        'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
                    ],
                    'email_mahasiswa' => $mahasiswa->email_mahasiswa,
                    'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
                    'status_mahasiswa' => $mahasiswa->status_mahasiswa,
                    'created_at' => $mahasiswa->created_at->diffForHumans(),
                ];

                $response = [
                    'message' => 'Data added successfully',
                    'mahasiswa' => $data
                ];
                return response()->json($response, 201);
            } catch (\Illuminate\Database\QueryException $ex) {
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
            $mahasiswa = Mahasiswa::findorfail($id);
            $data_user = User::findorfail($mahasiswa->user_id_user);
            $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);

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
                'provinsi_mahasiswa' => $mahasiswa->provinsi_mahasiswa,
                'kabupaten_mahasiswa' => $mahasiswa->kabupaten_mahasiswa,
                'kecamatan_mahasiswa' => $mahasiswa->kecamatan_mahasiswa,
                'desa_mahasiswa' => $mahasiswa->desa_mahasiswa,
                'foto_mahasiswa' => [
                    'nama_file' => $mahasiswa->foto_mahasiswa,
                    'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
                ],
                'email_mahasiswa' => $mahasiswa->email_mahasiswa,
                'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
                'status_mahasiswa' => $mahasiswa->status_mahasiswa,
                'created_at' => $mahasiswa->created_at->diffForHumans(),
                'updated_at' => $mahasiswa->updated_at->diffForHumans(),
            ];

            $response = [
                'message' => 'Data details',
                'detail_mahasiswa' => $data
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
            'nama_mahasiswa' => 'required|min:3',
            'tempat_lahir_mahasiswa' => 'required|min:3',
            'tanggal_lahir_mahasiswa' => 'required|date',
            'status_mahasiswa' => 'required|in:Aktif,Non Aktif,Drop Out,Lulus',
        ]);

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
                'message' => 'Data Edited Successfully',
                'mahasiswa' => $data
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
            $mahasiswa = Mahasiswa::findOrFail($id);
            $user = User::findOrFail($mahasiswa->user_id_user);
            $mahasiswa->delete();
            $user->delete();
            return response()->json([
                'message' => 'Data user & mahasiswa with id ' . $mahasiswa->id . ' deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'Sorry the data cannot be deleted, there are still data in other tables that are related to this data!'
            ], 400);
        }
    }

    public function resetpassword(Request $request, $id)
    {
        $this->validate($request, [
            'npm_mahasiswa' => 'required|numeric|digits:10'
        ]);
        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = User::findorfail($mahasiswa->user_id_user);
        $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);

        if ($user->username == $request->input('npm_mahasiswa')) {
            $user->password = bcrypt($request->input('npm_mahasiswa'));
            $user->api_token = bcrypt($request->input('npm_mahasiswa') . 'Mahasiswa');
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

            return response()->json([
                'message' => 'password reset successful',
                'mahasiswa' => $data
            ], 205);
        }

        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => [
                'npm_mahasiswa' => 'The npm mahasiswa you entered is invalid'
            ],
        ], 400);
    }
}
