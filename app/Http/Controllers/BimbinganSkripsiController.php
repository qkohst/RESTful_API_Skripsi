<?php

namespace App\Http\Controllers;

use App\BimbinganSkripsi;
use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganSkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $id_dosen_pembimbing = DosenPembimbing::where('dosen_id_dosen', $dosen->id)->get('id');

        $bimbingan_skripsi = BimbinganSkripsi::whereIn('dosen_pembimbing_id_dosen_pembimbing', $id_dosen_pembimbing)
            ->orderBy('status_persetujuan_bimbingan_skripsi', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get('id');
        foreach ($bimbingan_skripsi as $bimbingan) {
            $data_bimbingan_skripsi = BimbinganSkripsi::findorfail($bimbingan->id);
            $dosen_pembimbing = DosenPembimbing::findorfail($data_bimbingan_skripsi->dosen_pembimbing_id_dosen_pembimbing);
            $judul_skripsi = JudulSkripsi::findorfail($dosen_pembimbing->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $bimbingan->mahasiswa = [
                'id' => $mahasiswa->id,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
            ];
            $bimbingan->topik_bimbingan_skripsi = $data_bimbingan_skripsi->topik_bimbingan_skripsi;
            $bimbingan->tanggal_pengajuan_bimbingan_skripsi = $data_bimbingan_skripsi->created_at;
            $bimbingan->status_persetujuan_bimbingan_skripsi = $data_bimbingan_skripsi->status_persetujuan_bimbingan_skripsi;
        }

        return response()->json([
            'message' => 'List of Data',
            'bimbingan_skripsi' => $bimbingan_skripsi
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
            $bimbingan_skripsi = BimbinganSkripsi::findorfail($id);
            $dosen_pembimbing = DosenPembimbing::findorfail($bimbingan_skripsi->dosen_pembimbing_id_dosen_pembimbing);
            $cek_dosen = Dosen::where('user_id_user', Auth::user()->id)->first();

            if ($cek_dosen->id != $dosen_pembimbing->dosen_id_dosen) {
                $response = [
                    'message' => 'You do not have access to data with id ' . $bimbingan_skripsi->id,
                ];

                return response()->json($response, 400);
            }
            $judul_skripsi = JudulSkripsi::findorfail($dosen_pembimbing->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $data = [
                'id' => $bimbingan_skripsi->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'topik_bimbingan_skripsi' => $bimbingan_skripsi->topik_bimbingan_skripsi,
                'file_bimbingan_skripsi' => [
                    'nama_file' => $bimbingan_skripsi->nama_file_bimbingan_skripsi,
                    'url' => 'fileSkripsi/' . $bimbingan_skripsi->nama_file_bimbingan_skripsi,
                ],
                'status_persetujuan_bimbingan_skripsi' => $bimbingan_skripsi->status_persetujuan_bimbingan_skripsi,
                'catatan_bimbingan_skripsi' => $bimbingan_skripsi->catatan_bimbingan_skripsi,
                'tanggal_pengajuan_bimbingan_skripsi' => $bimbingan_skripsi->created_at
            ];

            $response = [
                'message' => 'Data details',
                'bimbingan_skripsi' => $data
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
            'status_persetujuan_bimbingan_skripsi' => 'required|in:Antrian,Disetujui,Revisi',
            'catatan_bimbingan_skripsi' => 'required',
        ]);

        $bimbingan_skripsi = BimbinganSkripsi::findorfail($id);
        $dosen_pembimbing = DosenPembimbing::findorfail($bimbingan_skripsi->dosen_pembimbing_id_dosen_pembimbing);
        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        if ($dosen_pembimbing->dosen_id_dosen != $dosen->id) {
            return response()->json([
                'message' => 'You do not have access to data with id ' . $bimbingan_skripsi->id
            ], 400);
        }
        if ($bimbingan_skripsi->status_persetujuan_bimbingan_skripsi != 'Disetujui') {
            $bimbingan_skripsi->status_persetujuan_bimbingan_skripsi = $request->input('status_persetujuan_bimbingan_skripsi');
            $bimbingan_skripsi->catatan_bimbingan_skripsi = $request->input('catatan_bimbingan_skripsi');
            $bimbingan_skripsi->update();

            $judul_skripsi = JudulSkripsi::findorfail($dosen_pembimbing->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
            
            $data = [
                'id' => $bimbingan_skripsi->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'topik_bimbingan_skripsi' => $bimbingan_skripsi->topik_bimbingan_skripsi,
                'status_bimbingan_skripsi' => $bimbingan_skripsi->status_persetujuan_bimbingan_skripsi,
                'catatan_bimbingan_skripsi' => $bimbingan_skripsi->catatan_bimbingan_skripsi,
                'updated_at' => $bimbingan_skripsi->updated_at->diffForHumans(),
            ];

            return response()->json([
                'message' => 'verification is successful',
                'bimbingan_proposal' => $data,
            ], 200);
        }
        return response()->json([
            'message' => 'the data has been verified, you can not change the verification status'
        ], 400);
    }
}
