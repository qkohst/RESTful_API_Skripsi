<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPenguji;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PersetujuanDosenPengujiController extends Controller
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
        $dosen_penguji = DosenPenguji::where('dosen_id_dosen', $dosen->id)
            ->orderBy('persetujuan_dosen_penguji', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get('id');

        foreach ($dosen_penguji as $penguji) {
            $data_dosen_penguji = DosenPenguji::findorfail($penguji->id);
            $data_judul_skripsi = JudulSkripsi::findorfail($data_dosen_penguji->judul_skripsi_id_judul_skripsi);
            $data_mahasiswa = Mahasiswa::findorfail($data_judul_skripsi->mahasiswa_id_mahasiswa);
            $data_seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $data_judul_skripsi->id)->first();


            $penguji->mahasiswa = [
                'id' => $data_mahasiswa->id,
                'npm_mahasiswa' => $data_mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $data_mahasiswa->nama_mahasiswa
            ];
            $penguji->judul_skripsi = [
                'id' => $data_judul_skripsi->id,
                'nama_judul_skripsi' => $data_judul_skripsi->nama_judul_skripsi
            ];
            $penguji->seminar_proposal = [
                'id' => $data_seminar_proposal->id,
                'tempat_seminar_proposal' => $data_seminar_proposal->tempat_seminar_proposal,
                'waktu_seminar_proposal' => $data_seminar_proposal->waktu_seminar_proposal
            ];
            $penguji->jabatan_dosen_penguji = 'Penguji ' . $data_dosen_penguji->jabatan_dosen_penguji;
            $penguji->status_persetujuan_dosen_penguji = $data_dosen_penguji->persetujuan_dosen_penguji;
            $penguji->tanggal_pengajuan_dosen_penguji = $data_dosen_penguji->created_at->format('Y-m-d H:i:s');
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Persetujuan Dosen Penguji',
            'data' => $dosen_penguji,
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
            $dosen_penguji = DosenPenguji::findorfail($id);
            $cek_dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            if ($cek_dosen->id != $dosen_penguji->dosen_id_dosen) {
                $response = [
                    'status'  => 'error',
                    'message' => 'You do not have access to data with id ' . $dosen_penguji->id,
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

                return response()->json($response, 400);
            }
            $judul_skripsi = JudulSkripsi::findorfail($dosen_penguji->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
            $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();

            $data = [
                'id' => $dosen_penguji->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'seminar_proposal' => [
                    'id' => $seminar_proposal->id,
                    'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal,
                    'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal
                ],
                'jabatan_dosen_penguji' => 'Penguji ' . $dosen_penguji->jabatan_dosen_penguji,
                'status_persetujuan_dosen_penguji' => $dosen_penguji->persetujuan_dosen_penguji
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Persetujuan Dosen Penguji',
                'data' => $data
            ];
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
            'status_persetujuan_dosen_penguji' => 'required|in:Antrian,Disetujui,Ditolak',
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

        $dosen_penguji = DosenPenguji::findorfail($id);
        $cek_dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        if ($cek_dosen->id != $dosen_penguji->dosen_id_dosen) {
            $response = [
                'status'  => 'error',
                'message' => 'You do not have access to data with id ' . $dosen_penguji->id,
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }
        if ($dosen_penguji->persetujuan_dosen_penguji != 'Disetujui') {
            $dosen_penguji->persetujuan_dosen_penguji = $request->input('status_persetujuan_dosen_penguji');
            $dosen_penguji->update();

            $judul_skripsi = JudulSkripsi::findorfail($dosen_penguji->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
            $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();

            $data = [
                'id' => $dosen_penguji->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'seminar_proposal' => [
                    'id' => $seminar_proposal->id,
                    'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal,
                    'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal
                ],
                'jabatan_dosen_penguji' => $dosen_penguji->jabatan_dosen_penguji,
                'status_persetujuan_dosen_penguji' => $dosen_penguji->persetujuan_dosen_penguji
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
