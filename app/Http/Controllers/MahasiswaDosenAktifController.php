<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Mahasiswa;
use App\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;

class MahasiswaDosenAktifController extends Controller
{
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

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
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data dosen at ' . $program_studi->nama_program_studi . ' with an active status',
            'data' => $dosen_aktif
        ], 200);
    }
}
