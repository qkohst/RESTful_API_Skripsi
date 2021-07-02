<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ApiClient;
use App\TrafficRequest;

class DosenPembimbingMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        try {
            $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
            $judul_skripi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
            if (is_null($judul_skripi)) {
                $response = [
                    'status'  => 'error',
                    'message' => 'You are not allowed at this stage',
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();
                return response()->json($response, 400);
            }
            $dosen_pembimbing = DosenPembimbing::where('judul_skripsi_id_judul_skripsi', $judul_skripi->id)
                ->orderBy('jabatan_dosen_pembimbing', 'asc')
                ->get('id');
            foreach ($dosen_pembimbing as $pembimbing) {
                $data_dosen_pembimbing = DosenPembimbing::findorfail($pembimbing->id);
                $dosen = Dosen::where('id', $data_dosen_pembimbing->dosen_id_dosen)->first();
                $pembimbing->dosen = [
                    'id' => $dosen->id,
                    'nama_dosen' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
                    'nidn_dosen' => $dosen->nidn_dosen
                ];
                $pembimbing->jabatan_dosen_pembimbing = 'Pembimbing ' . $data_dosen_pembimbing->jabatan_dosen_pembimbing;
            }
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'List of Data Dosen Pembimbing',
                'data' => $dosen_pembimbing,
            ], 200);
        } catch (\Throwable $th) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json([
                'status'  => 'error',
                'message' => 'Data Not Found'
            ], 404);
        }
    }
}
