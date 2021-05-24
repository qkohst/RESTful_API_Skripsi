<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersetujuanSeminarProposalController extends Controller
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
        $seminar_proposal = SeminarProposal::whereIn('judul_skripsi_id_judul_skripsi', $data_judul_skripsi)->get('id');

        foreach ($seminar_proposal as $seminar) {
            $data_seminar_propoal = SeminarProposal::findorfail($seminar->id);
            $judul_skripsi = JudulSkripsi::findorfail($data_seminar_propoal->judul_skripsi_id_judul_skripsi);
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
            if ($dosen_pembimbing->jabatan_dosen_pembimbing == '1') {
                $seminar->status_persetujuan_seminar = $data_seminar_propoal->persetujuan_pembimbing1_seminar_proposal;
                $seminar->created_at = $data_seminar_propoal->created_at;
            }
            $seminar->status_persetujuan_seminar = $data_seminar_propoal->persetujuan_pembimbing2_seminar_proposal;
            $seminar->created_at = $data_seminar_propoal->created_at;
        }

        return response()->json([
            'message' => 'List of Data',
            'persetujuan_seminar' => $seminar_proposal,
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
        //
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
        //
    }
}
