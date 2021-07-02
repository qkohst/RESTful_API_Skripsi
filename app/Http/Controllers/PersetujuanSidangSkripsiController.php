<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SidangSkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PersetujuanSidangSkripsiController extends Controller
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
        $sidang_skripsi = SidangSkripsi::whereIn('judul_skripsi_id_judul_skripsi', $data_judul_skripsi)
            ->orderBy('persetujuan_pembimbing1_sidang_skripsi', 'asc')
            ->orderBy('persetujuan_pembimbing2_sidang_skripsi', 'asc')
            ->get('id');

        foreach ($sidang_skripsi as $sidang) {
            $data_sidang_skripsi = SidangSkripsi::findorfail($sidang->id);
            $judul_skripsi = JudulSkripsi::findorfail($data_sidang_skripsi->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
            $dosen_pembimbing = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['dosen_id_dosen', $dosen->id]
            ])->first();

            $sidang->mahasiswa = [
                'id' => $mahasiswa->id,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
            ];
            $sidang->judul_skripsi = [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ];
            $sidang->file_persetujuan_sidang = [
                'nama_file' => $data_sidang_skripsi->file_sidang_skripsi,
                'url' => 'fileSidang/' . $data_sidang_skripsi->file_sidang_skripsi
            ];

            if ($dosen_pembimbing->jabatan_dosen_pembimbing == '1') {
                $sidang->status_persetujuan_sidang = $data_sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi;
                $sidang->catatan_persetujuan_sidang = $data_sidang_skripsi->catatan_pembimbing1_sidang_skripsi;
                $sidang->tanggal_pengajuan_persetujuan_sidang = $data_sidang_skripsi->created_at->format('Y-m-d H:i:s');
            } else {
                $sidang->status_persetujuan_sidang = $data_sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi;
                $sidang->catatan_persetujuan_sidang = $data_sidang_skripsi->catatan_pembimbing2_sidang_skripsi;
                $sidang->tanggal_pengajuan_persetujuan_sidang = $data_sidang_skripsi->created_at->format('Y-m-d H:i:s');
            }
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Persetujuan Sidang Skripsi',
            'data' => $sidang_skripsi,
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
            $sidang_skripsi = SidangSkripsi::findorfail($id);
            $judul_skripsi = JudulSkripsi::findorfail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            $dosen_pembimbing = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['dosen_id_dosen', $dosen->id]
            ])->first();

            if ($dosen_pembimbing->jabatan_dosen_pembimbing == '1') {
                $data = [
                    'id' => $sidang_skripsi->id,
                    'mahasiswa' => [
                        'id' => $mahasiswa->id,
                        'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                        'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                    ],
                    'judul_skripsi' => [
                        'id' => $judul_skripsi->id,
                        'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                    ],
                    'file_persetujuan_sidang' => [
                        'nama_file' => $sidang_skripsi->file_sidang_skripsi,
                        'url' => 'fileSidang/' . $sidang_skripsi->file_sidang_skripsi
                    ],
                    'status_persetujuan_sidang' => $sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi,
                    'catatan_persetujuan_sidang' => $sidang_skripsi->catatan_pembimbing1_sidang_skripsi,
                    'tanggal_pengajuan_persetujuan_sidang' => $sidang_skripsi->created_at->format('Y-m-d H:i:s'),
                ];
                $response = [
                    'status'  => 'success',
                    'message' => 'Details Data Persetujuan Sidang',
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
                'id' => $sidang_skripsi->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'file_persetujuan_sidang' => [
                    'nama_file' => $sidang_skripsi->file_sidang_skripsi,
                    'url' => 'fileSidang/' . $sidang_skripsi->file_sidang_skripsi
                ],
                'status_persetujuan_sidang' => $sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi,
                'catatan_persetujuan_sidang' => $sidang_skripsi->catatan_pembimbing2_sidang_skripsi,
                'tanggal_pengajuan_persetujuan_sidang' => $sidang_skripsi->created_at->format('Y-m-d H:i:s'),
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
            'status_persetujuan_sidang' => 'required|in:Antrian,Disetujui,Ditolak',
            'catatan_persetujuan_sidang' => 'required',
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
        $sidang_skripsi = SidangSkripsi::findorfail($id);
        $judul_skripsi = JudulSkripsi::findorfail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
        $cek_jabatan_pembimbing = DosenPembimbing::where([
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
            ['dosen_id_dosen', $dosen->id]
        ])->first();

        if ($cek_jabatan_pembimbing->jabatan_dosen_pembimbing == '1') {
            if ($sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi != 'Disetujui') {
                $sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi = $request->input('status_persetujuan_sidang');
                $sidang_skripsi->catatan_pembimbing1_sidang_skripsi = $request->input('catatan_persetujuan_sidang');
                $sidang_skripsi->update();

                $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

                $data = [
                    'id' => $sidang_skripsi->id,
                    'mahasiswa' => [
                        'id' => $mahasiswa->id,
                        'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                        'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                    ],
                    'judul_skripsi' => [
                        'id' => $judul_skripsi->id,
                        'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                    ],
                    'status_persetujuan_sidang' => $sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi,
                    'catatan_persetujuan_sidang' => $sidang_skripsi->catatan_pembimbing1_sidang_skripsi,
                    'updated_at' => $sidang_skripsi->updated_at
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
        if ($sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi != 'Disetujui') {
            $sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi = $request->input('status_persetujuan_sidang');
            $sidang_skripsi->catatan_pembimbing2_sidang_skripsi = $request->input('catatan_persetujuan_sidang');
            $sidang_skripsi->update();

            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $data = [
                'id' => $sidang_skripsi->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'status_persetujuan_sidang' => $sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi,
                'catatan_persetujuan_sidang' => $sidang_skripsi->catatan_pembimbing2_sidang_skripsi,
                'updated_at' => $sidang_skripsi->updated_at
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
