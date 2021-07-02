<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PersetujuanJudulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $dosen_pembimbing = DosenPembimbing::where('dosen_id_dosen', $dosen->id)
            ->orderBy('persetujuan_dosen_pembimbing', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get('id');

        foreach ($dosen_pembimbing as $pembimbing) {
            $data_dosen_pembimbing = DosenPembimbing::findorfail($pembimbing->id);
            $judul_skripsi = JudulSkripsi::findorfail($data_dosen_pembimbing->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $pembimbing->mahasiswa = [
                'id' => $mahasiswa->id,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
            ];
            $pembimbing->judul_skripsi = [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ];
            $pembimbing->jabatan_dosen_pembimbing = 'Pembimbing ' . $data_dosen_pembimbing->jabatan_dosen_pembimbing;
            $pembimbing->persetujuan_dosen_pembimbing = $data_dosen_pembimbing->persetujuan_dosen_pembimbing;
            $pembimbing->catatan_dosen_pembimbing = $data_dosen_pembimbing->catatan_dosen_pembimbing;
            $pembimbing->tanggal_pengajuan_dosen_pembimbing = $data_dosen_pembimbing->created_at->format('Y-m-d H:i:s');
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Persetujuan Judul',
            'data' => $dosen_pembimbing,
        ], 200);
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
            $dosen_pembimbing = DosenPembimbing::findorfail($id);
            $cek_dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            if ($cek_dosen->id != $dosen_pembimbing->dosen_id_dosen) {
                $response = [
                    'status'  => 'error',
                    'message' => 'You do not have access to data with id ' . $dosen_pembimbing->id,
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

                return response()->json($response, 400);
            }
            $judul_skripsi = JudulSkripsi::findorfail($dosen_pembimbing->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $data = [
                'id' => $dosen_pembimbing->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi,
                ],
                'jabatan_dosen_pembimbing' => 'Pembimbing ' . $dosen_pembimbing->jabatan_dosen_pembimbing,
                'persetujuan_dosen_pembimbing' => $dosen_pembimbing->persetujuan_dosen_pembimbing,
                'catatan_dosen_pembimbing' => $dosen_pembimbing->catatan_dosen_pembimbing,
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Persetujuan Judul',
                'data' => $data
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'status'  => 'error',
                'message' => 'Data not found',
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

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
            'persetujuan_dosen_pembimbing' => 'required|in:Disetujui,Ditolak',
            'catatan_dosen_pembimbing' => 'required|min:1',
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

        $dosen_pembimbing = DosenPembimbing::findorfail($id);
        $cek_dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        if ($cek_dosen->id != $dosen_pembimbing->dosen_id_dosen) {
            $response = [
                'status'  => 'error',
                'message' => 'You do not have access to data with id ' . $dosen_pembimbing->id,
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 400);
        }
        if ($dosen_pembimbing->persetujuan_dosen_pembimbing != 'Disetujui') {
            $dosen_pembimbing->persetujuan_dosen_pembimbing = $request->input('persetujuan_dosen_pembimbing');
            $dosen_pembimbing->catatan_dosen_pembimbing = $request->input('catatan_dosen_pembimbing');
            $dosen_pembimbing->update();

            $judul_skripsi = JudulSkripsi::findorfail($dosen_pembimbing->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $data = [
                'id' => $dosen_pembimbing->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi,
                ],
                'jabatan_dosen_pembimbing' => $dosen_pembimbing->jabatan_dosen_pembimbing,
                'persetujuan_dosen_pembimbing' => $dosen_pembimbing->persetujuan_dosen_pembimbing,
                'catatan_dosen_pembimbing' => $dosen_pembimbing->catatan_dosen_pembimbing,
                'updated_at' => $dosen_pembimbing->updated_at->diffForHumans(),
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Verification is successful',
                'data' => $data,
            ], 200);
        }
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'error',
            'message' => 'the data has been verified, you can not change the verification status'
        ], 400);
    }
}
