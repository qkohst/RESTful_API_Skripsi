<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\AdminProdi;
use App\ProgramStudi;

class ProfileAdminProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();

        $data = [
            'id' => $admin_prodi->id,
            'program_studi' => [
                'id' => $program_studi->id,
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi,
            ],
            'nama_admin_prodi' => $admin_prodi->nama_admin_prodi,
            'nik_admin_prodi' => $admin_prodi->nik_admin_prodi,
            'nidn_admin_prodi' => $admin_prodi->nidn_admin_prodi,
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
            'updated_at' => $admin_prodi->updated_at->diffForHumans(),
        ];
        return response()->json([
            'message' => 'Profile Admin Prodi',
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
        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();
        $id = $admin_prodi->id;
        $this->validate($request, [
            'tempat_lahir_admin_prodi' => 'required|min:3',
            'tanggal_lahir_admin_prodi' => 'required|date',
            'jenis_kelamin_admin_prodi' => 'required|in:L,P',
            'email_admin_prodi' => 'required|email|unique:admin_prodi' . ($id ? ",id,$id" : ''),
            'no_hp_admin_prodi' => 'required|numeric|digits_between:11,13|unique:admin_prodi' . ($id ? ",id,$id" : ''),
            'foto_admin_prodi' => 'nullable|mimes:jpg,jpeg,png|max:2000'
        ]);

        $admin_prodi->tempat_lahir_admin_prodi = $request->input('tempat_lahir_admin_prodi');
        $admin_prodi->tanggal_lahir_admin_prodi = $request->input('tanggal_lahir_admin_prodi');
        $admin_prodi->jenis_kelamin_admin_prodi = $request->input('jenis_kelamin_admin_prodi');
        $admin_prodi->email_admin_prodi = $request->input('email_admin_prodi');
        $admin_prodi->no_hp_admin_prodi = $request->input('no_hp_admin_prodi');

        if ($request->hasFile('foto_admin_prodi')) {
            $file_foto = $request->file('foto_admin_prodi');
            $fotoName = 'img-' . date('mdYHis') . '.' . $file_foto->getClientOriginalExtension();
            $file_foto->move('fileFotoProfile/', $fotoName);
            $admin_prodi->foto_admin_prodi = $fotoName;
        }
        $admin_prodi->save();

        $data = [
            'id' => $admin_prodi->id,
            'program_studi' => [
                'id' => $program_studi->id,
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi,
            ],
            'nik_admin_prodi' => $admin_prodi->nik_admin_prodi,
            'nidn_admin_prodi' => $admin_prodi->nidn_admin_prodi,
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
            'updated_at' => $admin_prodi->updated_at->diffForHumans(),
        ];
        return response()->json([
            'message' => 'Profile updated successfully',
            'admin_prodi' => $data
        ], 200);
    }
}
