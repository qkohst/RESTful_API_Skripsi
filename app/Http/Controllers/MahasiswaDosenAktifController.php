<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Mahasiswa;
use App\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaDosenAktifController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $mahasiswa->program_studi_id_program_studi)->first();

        $dosen_aktif = Dosen::where([
            ['program_studi_id_program_studi', $program_studi->id],
            ['status_dosen', 'Aktif']
        ])->orderBy('nama_dosen', 'asc')->get('id');

        foreach ($dosen_aktif as $dosen) {
            $data_dosen = Dosen::findorfail($dosen->id);
            $dosen->nidn_dosen = $data_dosen->nidn_dosen;
            $dosen->nama_dosen = $data_dosen->nama_dosen . ', ' . $data_dosen->gelar_dosen;
        }

        return response()->json([
            'message' => 'Data dosen at ' . $program_studi->nama_program_studi . ' with an active status',
            'dosen_aktif' => $dosen_aktif
        ], 200);
    }
}
