<?php

namespace App\Http\Controllers;

use App\BimbinganProposal;
use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class BimbinganProposalController extends Controller
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
        $id_dosen_pembimbing = DosenPembimbing::where('dosen_id_dosen', $dosen->id)->get('id');
        $bimbingan_proposal = BimbinganProposal::whereIn('dosen_pembimbing_id_dosen_pembimbing', $id_dosen_pembimbing)
            ->orderBy('status_persetujuan_bimbingan_proposal', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get('id');
        foreach ($bimbingan_proposal as $bimbingan) {
            $data_bimbingan_proposal = BimbinganProposal::findorfail($bimbingan->id);
            $dosen_pembimbing = DosenPembimbing::findorfail($data_bimbingan_proposal->dosen_pembimbing_id_dosen_pembimbing);
            $judul_skripsi = JudulSkripsi::findorfail($dosen_pembimbing->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
            $bimbingan->mahasiswa = [
                'id' => $mahasiswa->id,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
            ];
            $bimbingan->judul_skripsi = [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ];
            $bimbingan->file_bimbingan_proposal = [
                'nama_file' => $data_bimbingan_proposal->nama_file_bimbingan_proposal,
                'url' => 'fileProposal/' . $data_bimbingan_proposal->nama_file_bimbingan_proposal,
            ];
            $bimbingan->topik_bimbingan_proposal = $data_bimbingan_proposal->topik_bimbingan_proposal;
            $bimbingan->status_persetujuan_bimbingan_proposal = $data_bimbingan_proposal->status_persetujuan_bimbingan_proposal;
            $bimbingan->catatan_bimbingan_proposal = $data_bimbingan_proposal->catatan_bimbingan_proposal;
            $bimbingan->tanggal_pengajuan_bimbingan_proposal = $data_bimbingan_proposal->created_at->format('Y-m-d H:i:s');
            $bimbingan->tanggal_persetujuan_bimbingan_proposal = $data_bimbingan_proposal->updated_at->format('Y-m-d H:i:s');
        }
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Bimbingan Proposal',
            'data' => $bimbingan_proposal,
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
            $bimbingan_proposal = BimbinganProposal::findorfail($id);
            $dosen_pembimbing = DosenPembimbing::findorfail($bimbingan_proposal->dosen_pembimbing_id_dosen_pembimbing);
            $cek_dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            if ($cek_dosen->id != $dosen_pembimbing->dosen_id_dosen) {
                $response = [
                    'status'  => 'error',
                    'message' => 'You do not have access to data with id ' . $bimbingan_proposal->id,
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
                'id' => $bimbingan_proposal->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'topik_bimbingan_proposal' => $bimbingan_proposal->topik_bimbingan_proposal,
                'file_bimbingan_proposal' => [
                    'nama_file' => $bimbingan_proposal->nama_file_bimbingan_proposal,
                    'url' => 'fileProposal/' . $bimbingan_proposal->nama_file_bimbingan_proposal,
                ],
                'status_persetujuan_bimbingan_proposal' => $bimbingan_proposal->status_persetujuan_bimbingan_proposal,
                'catatan_bimbingan_proposal' => $bimbingan_proposal->catatan_bimbingan_proposal,
                'tanggal_persetujuan_bimbingan_proposal' => $bimbingan_proposal->updated_at->format('Y-m-d H:i:s'),

            ];

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Bimbingan Proposal',
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
            'status_persetujuan_bimbingan_proposal' => 'required|in:Antrian,Disetujui,Revisi',
            'catatan_bimbingan_proposal' => 'required',
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
        
        $bimbingan_proposal = BimbinganProposal::findorfail($id);
        $dosen_pembimbing = DosenPembimbing::findorfail($bimbingan_proposal->dosen_pembimbing_id_dosen_pembimbing);
        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        if ($dosen_pembimbing->dosen_id_dosen != $dosen->id) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json([
                'status'  => 'error',
                'message' => 'You do not have access to data with id ' . $bimbingan_proposal->id
            ], 400);
        }

        if ($bimbingan_proposal->status_persetujuan_bimbingan_proposal != 'Disetujui') {
            $bimbingan_proposal->status_persetujuan_bimbingan_proposal = $request->input('status_persetujuan_bimbingan_proposal');
            $bimbingan_proposal->catatan_bimbingan_proposal = $request->input('catatan_bimbingan_proposal');
            $bimbingan_proposal->update();

            $judul_skripsi = JudulSkripsi::findorfail($dosen_pembimbing->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $data = [
                'id' => $bimbingan_proposal->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'topik_bimbingan_proposal' => $bimbingan_proposal->topik_bimbingan_proposal,
                'status_bimbingan_proposal' => $bimbingan_proposal->status_persetujuan_bimbingan_proposal,
                'catatan_bimbingan_proposal' => $bimbingan_proposal->catatan_bimbingan_proposal,
                'updated_at' => $bimbingan_proposal->updated_at->diffForHumans(),
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
