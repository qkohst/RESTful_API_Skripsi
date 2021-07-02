<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PersetujuanSeminarProposalController extends Controller
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
        $data_pembimbing = DosenPembimbing::where('dosen_id_dosen', $dosen->id)->get('judul_skripsi_id_judul_skripsi');
        $data_judul_skripsi = JudulSkripsi::whereIn('id', $data_pembimbing)->get('id');
        $seminar_proposal = SeminarProposal::whereIn('judul_skripsi_id_judul_skripsi', $data_judul_skripsi)
            ->orderBy('persetujuan_pembimbing1_seminar_proposal', 'asc')
            ->orderBy('persetujuan_pembimbing2_seminar_proposal', 'asc')
            ->get('id');

        foreach ($seminar_proposal as $seminar) {
            $data_seminar_proposal = SeminarProposal::findorfail($seminar->id);
            $judul_skripsi = JudulSkripsi::findorfail($data_seminar_proposal->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
            $dosen_pembimbing = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['dosen_id_dosen', $dosen->id]
            ])->first();

            $seminar->mahasiswa = [
                'id' => $mahasiswa->id,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
            ];
            $seminar->judul_skripsi = [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ];
            $seminar->file_persetujuan_seminar = [
                'nama_file' => $data_seminar_proposal->file_seminar_proposal,
                'url' => 'fileSeminar/' . $data_seminar_proposal->file_seminar_proposal
            ];

            if ($dosen_pembimbing->jabatan_dosen_pembimbing == '1') {
                $seminar->status_persetujuan_seminar = $data_seminar_proposal->persetujuan_pembimbing1_seminar_proposal;
                $seminar->catatan_persetujuan_seminar = $data_seminar_proposal->catatan_pembimbing1_seminar_proposal;
                $seminar->tanggal_pengajuan_persetujuan_seminar = $data_seminar_proposal->created_at->format('Y-m-d H:i:s');
            } else {
                $seminar->status_persetujuan_seminar = $data_seminar_proposal->persetujuan_pembimbing2_seminar_proposal;
                $seminar->catatan_persetujuan_seminar = $data_seminar_proposal->catatan_pembimbing2_seminar_proposal;
                $seminar->tanggal_pengajuan_persetujuan_seminar = $data_seminar_proposal->created_at->format('Y-m-d H:i:s');
            }
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Persetujuan Seminar Proposal',
            'data' => $seminar_proposal,
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
            $seminar_proposal = SeminarProposal::findorfail($id);
            $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            $dosen_pembimbing = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['dosen_id_dosen', $dosen->id]
            ])->first();

            if ($dosen_pembimbing->jabatan_dosen_pembimbing == '1') {
                $data = [
                    'id' => $seminar_proposal->id,
                    'mahasiswa' => [
                        'id' => $mahasiswa->id,
                        'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                        'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                    ],
                    'judul_skripsi' => [
                        'id' => $judul_skripsi->id,
                        'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                    ],
                    'file_persetujuan_seminar' => [
                        'nama_file' => $seminar_proposal->file_seminar_proposal,
                        'url' => 'fileSeminar/' . $seminar_proposal->file_seminar_proposal
                    ],
                    'status_persetujuan_seminar' => $seminar_proposal->persetujuan_pembimbing1_seminar_proposal,
                    'catatan_persetujuan_seminar' => $seminar_proposal->catatan_pembimbing1_seminar_proposal,
                    'tanggal_pengajuan_persetujuan_seminar' => $seminar_proposal->created_at->format('Y-m-d H:i:s'),
                ];
                $response = [
                    'status'  => 'success',
                    'message' => 'Details Data Persetujuan Seminar',
                    'data' => $data
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                return response()->json($response, 200);
            }

            $data = [
                'id' => $seminar_proposal->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'file_persetujuan_seminar' => [
                    'nama_file' => $seminar_proposal->file_seminar_proposal,
                    'url' => 'fileSeminar/' . $seminar_proposal->file_seminar_proposal
                ],
                'status_persetujuan_seminar' => $seminar_proposal->persetujuan_pembimbing2_seminar_proposal,
                'catatan_persetujuan_seminar' => $seminar_proposal->catatan_pembimbing2_seminar_proposal,
                'tanggal_pengajuan_persetujuan_seminar' => $seminar_proposal->created_at->format('Y-m-d H:i:s'),
            ];
            $response = [
                'status'  => 'success',
                'message' => 'Details Data Persetujuan Seminar',
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
            'status_persetujuan_seminar' => 'required|in:Antrian,Disetujui,Ditolak',
            'catatan_persetujuan_seminar' => 'required',
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

        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $seminar_proposal = SeminarProposal::findorfail($id);
        $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
        $cek_jabatan_pembimbing = DosenPembimbing::where([
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
            ['dosen_id_dosen', $dosen->id]
        ])->first();

        if ($cek_jabatan_pembimbing->jabatan_dosen_pembimbing == '1') {
            if ($seminar_proposal->persetujuan_pembimbing1_seminar_proposal != 'Disetujui') {
                $seminar_proposal->persetujuan_pembimbing1_seminar_proposal = $request->input('status_persetujuan_seminar');
                $seminar_proposal->catatan_pembimbing1_seminar_proposal = $request->input('catatan_persetujuan_seminar');
                $seminar_proposal->update();

                $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

                $data = [
                    'id' => $seminar_proposal->id,
                    'mahasiswa' => [
                        'id' => $mahasiswa->id,
                        'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                        'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                    ],
                    'judul_skripsi' => [
                        'id' => $judul_skripsi->id,
                        'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                    ],
                    'status_persetujuan_seminar' => $seminar_proposal->persetujuan_pembimbing1_seminar_proposal,
                    'catatan_persetujuan_seminar' => $seminar_proposal->catatan_pembimbing1_seminar_proposal,
                    'updated_at' => $seminar_proposal->updated_at
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
        if ($seminar_proposal->persetujuan_pembimbing2_seminar_proposal != 'Disetujui') {
            $seminar_proposal->persetujuan_pembimbing2_seminar_proposal = $request->input('status_persetujuan_seminar');
            $seminar_proposal->catatan_pembimbing2_seminar_proposal = $request->input('catatan_persetujuan_seminar');
            $seminar_proposal->update();

            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $data = [
                'id' => $seminar_proposal->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'status_persetujuan_seminar' => $seminar_proposal->persetujuan_pembimbing2_seminar_proposal,
                'catatan_persetujuan_seminar' => $seminar_proposal->catatan_pembimbing2_seminar_proposal,
                'updated_at' => $seminar_proposal->updated_at
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'verification is successful',
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
