<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SidangSkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersetujuanSidangSkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            if ($dosen_pembimbing->jabatan_dosen_pembimbing == '1') {
                $sidang->status_persetujuan_sidang_skripsi = $data_sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi;
                $sidang->tanggal_pengajuan_persetujuan_sidang_skripsi = $data_sidang_skripsi->created_at;
            } else {
                $sidang->status_persetujuan_sidang = $data_sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi;
                $sidang->tanggal_pengajuan_persetujuan_sidang_skripsi = $data_sidang_skripsi->created_at;
            }
        }
        return response()->json([
            'message' => 'List of Data',
            'persetujuan_sidang_skripsi' => $sidang_skripsi,
        ], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
                    'tanggal_pengajuan_persetujuan_sidang' => $sidang_skripsi->created_at
                ];
                $response = [
                    'message' => 'Data details',
                    'persetujuan_sidang' => $data
                ];
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
                'created_at' => $sidang_skripsi->created_at
            ];
            $response = [
                'message' => 'Data details',
                'persetujuan_sidang' => $data
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Data not found',
            ];

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
        $this->validate($request, [
            'status_persetujuan_sidang' => 'required|in:Antrian,Disetujui,Ditolak',
            'catatan_persetujuan_sidang' => 'required',
        ]);

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
                return response()->json([
                    'message' => 'verification is successful',
                    'persetujuan_sidang' => $data,
                ], 200);
            }
            return response()->json([
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
            return response()->json([
                'message' => 'verification is successful',
                'persetujuan_sidang' => $data,
            ], 200);
        }
        return response()->json([
            'message' => 'the data has been verified, you can not change the verification status'
        ], 400);
    }
}
