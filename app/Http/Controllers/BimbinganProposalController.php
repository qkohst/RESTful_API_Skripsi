<?php

namespace App\Http\Controllers;

use App\BimbinganProposal;
use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganProposalController extends Controller
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
            $bimbingan->topik_bimbingan_proposal = $data_bimbingan_proposal->topik_bimbingan_proposal;
            $bimbingan->status_persetujuan_bimbingan_proposal = $data_bimbingan_proposal->status_persetujuan_bimbingan_proposal;
            $bimbingan->tanggal_pengajuan_bimbingan_proposal = $data_bimbingan_proposal->created_at;
        }
        return response()->json([
            'message' => 'List of Data',
            'bimbingan_proposal' => $bimbingan_proposal,
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
            $bimbingan_proposal = BimbinganProposal::findorfail($id);
            $dosen_pembimbing = DosenPembimbing::findorfail($bimbingan_proposal->dosen_pembimbing_id_dosen_pembimbing);
            $cek_dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            if ($cek_dosen->id != $dosen_pembimbing->dosen_id_dosen) {
                $response = [
                    'message' => 'You do not have access to data with id ' . $bimbingan_proposal->id,
                ];

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
            ];

            $response = [
                'message' => 'Data details',
                'bimbingan_proposal' => $data
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
            'status_persetujuan_bimbingan_proposal' => 'required|in:Antrian,Disetujui,Revisi',
            'catatan_bimbingan_proposal' => 'required',
        ]);

        $bimbingan_proposal = BimbinganProposal::findorfail($id);
        $dosen_pembimbing = DosenPembimbing::findorfail($bimbingan_proposal->dosen_pembimbing_id_dosen_pembimbing);
        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        if ($dosen_pembimbing->dosen_id_dosen != $dosen->id) {
            return response()->json([
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
