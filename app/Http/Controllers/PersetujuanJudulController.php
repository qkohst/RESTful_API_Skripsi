<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersetujuanJudulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $dosen_pembimbing = DosenPembimbing::where('dosen_id_dosen', $dosen->id)
            ->orderBy('persetujuan_dosen_pembimbing', 'asc')
            ->orderBy('updated_at', 'asc')
            ->get([
                'id',
                'judul_skripsi_id_judul_skripsi',
                'jabatan_dosen_pembimbing',
                'persetujuan_dosen_pembimbing',
                'created_at'
            ]);

        foreach ($dosen_pembimbing as $pembimbing) {
            $judul_skripsi = JudulSkripsi::findorfail($pembimbing->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $pembimbing->judul_skripsi = [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ];

            $pembimbing->mahasiswa = [
                'id' => $mahasiswa->id,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
            ];
        }

        return response()->json([
            'message' => 'List of Data',
            'persetujuan_judul' => $dosen_pembimbing,
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
            $dosen_pembimbing = DosenPembimbing::findorfail($id);
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
                'created_at' => $dosen_pembimbing->created_at
            ];

            $response = [
                'message' => 'Data details',
                'persetujuan_judul' => $data
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
            'persetujuan_dosen_pembimbing' => 'required|in:Antrian,Disetujui,Ditolak',
            'catatan_dosen_pembimbing' => 'required|min:1',
        ]);

        $dosen_pembimbing = DosenPembimbing::findorfail($id);
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

            return response()->json([
                'message' => 'verification is successful',
                'persetujuan_judul' => $data,
            ], 200);
        }
        return response()->json([
            'message' => 'the data has been verified, you can not change the verification status'
        ], 400);
    }
}
