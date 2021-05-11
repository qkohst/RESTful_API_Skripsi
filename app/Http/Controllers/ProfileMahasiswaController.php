<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use App\ProgramStudi;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

class ProfileMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $mahasiswa->program_studi_id_program_studi)->first();

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
            'provinsi_mahasiswa' => $mahasiswa->provinsi_mahasiswa,
            'kabupaten_mahasiswa' => $mahasiswa->kabupaten_mahasiswa,
            'kecamatan_mahasiswa' => $mahasiswa->kecamatan_mahasiswa,
            'desa_mahasiswa' => $mahasiswa->desa_mahasiswa,
            'email_mahasiswa' => $mahasiswa->email_mahasiswa,
            'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
            'status_mahasiswa' => $mahasiswa->status_mahasiswa,
            'foto_mahasiswa' => [
                'nama_file' => $mahasiswa->foto_mahasiswa,
                'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
            ],
            'updated_at' => $mahasiswa->updated_at->diffForHumans(),
        ];

        return response()->json([
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
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $mahasiswa->program_studi_id_program_studi)->first();
        $id = $mahasiswa->id;

        $this->validate($request, [
            'status_perkawinan_mahasiswa' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'jenis_kelamin_mahasiswa' => 'required|in:L,P',
            'nama_ibu_mahasiswa' => 'required|min:3',
            'alamat_mahasiswa' => 'nullable|max:100',
            'provinsi_mahasiswa' => 'required|min:3',
            'kabupaten_mahasiswa' => 'required|min:3',
            'kecamatan_mahasiswa' => 'required|min:3',
            'desa_mahasiswa' => 'required|min:3',
            'no_hp_mahasiswa' => 'required|numeric|digits_between:11,13|unique:mahasiswa' . ($id ? ",id,$id" : ''),
            'email_mahasiswa' => 'required|email|unique:mahasiswa' . ($id ? ",id,$id" : ''),
            'foto_mahasiswa' => 'nullable|mimes:jpg,jpeg,png|max:2000',
        ]);

        $mahasiswa->status_perkawinan_mahasiswa = $request->input('status_perkawinan_mahasiswa');
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
            $file_foto->move('fileFotoProfile/', $fotoName);
            $mahasiswa->foto_mahasiswa = $fotoName;
        }
        $mahasiswa->save();

        $data = [
            'id' => $mahasiswa->id,
            'program_studi' => [
                'id' => $program_studi->id,
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi,
            ],
            'status_perkawinan_mahasiswa' => $mahasiswa->status_perkawinan_mahasiswa,
            'jenis_kelamin_mahasiswa' => $mahasiswa->jenis_kelamin_mahasiswa,
            'nama_ibu_mahasiswa' => $mahasiswa->nama_ibu_mahasiswa,
            'alamat_mahasiswa' => $mahasiswa->alamat_mahasiswa,
            'provinsi_mahasiswa' => $mahasiswa->provinsi_mahasiswa,
            'kabupaten_mahasiswa' => $mahasiswa->kabupaten_mahasiswa,
            'kecamatan_mahasiswa' => $mahasiswa->kecamatan_mahasiswa,
            'desa_mahasiswa' => $mahasiswa->desa_mahasiswa,
            'no_hp_mahasiswa' => $mahasiswa->no_hp_mahasiswa,
            'email_mahasiswa' => $mahasiswa->email_mahasiswa,
            'foto_mahasiswa' => [
                'nama_file' => $mahasiswa->foto_mahasiswa,
                'url' => 'fileFotoProfile/' . $mahasiswa->foto_mahasiswa
            ],
            'updated_at' => $mahasiswa->updated_at->diffForHumans(),
        ];
        return response()->json([
            'message' => 'Profile updated successfully',
            'mahasiswa' => $data
        ], 200);
    }
}
