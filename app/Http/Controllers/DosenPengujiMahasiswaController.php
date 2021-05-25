<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPenguji;
use App\JudulSkripsi;
use App\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DosenPengujiMahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        if (is_null($judul_skripi)) {
            $response = [
                'message' => 'You are not allowed at this stage',
            ];
            return response()->json($response, 400);
        }
        $dosen_penguji = DosenPenguji::where('judul_skripsi_id_judul_skripsi', $judul_skripi->id)
            ->orderBy('jabatan_dosen_penguji', 'asc')
            ->get([
                'id',
                'dosen_id_dosen',
                'jabatan_dosen_penguji'
            ]);
        foreach ($dosen_penguji as $penguji) {
            $dosen = Dosen::where('id', $penguji->dosen_id_dosen)->first();
            $penguji->dosen = [
                'id' => $dosen->id,
                'nama_dosen' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
                'nidn_dosen' => $dosen->nidn_dosen
            ];
        }

        return response()->json([
            'message' => 'List of Data',
            'dosen_penguji' => $dosen_penguji,
        ], 200);
    }
}
