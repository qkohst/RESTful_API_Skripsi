<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\HasilSeminarProposal;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenVerifikasiSeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $id_dosen_penguji = DosenPenguji::where('dosen_id_dosen', $dosen->id)->get('judul_skripsi_id_judul_skripsi');
        $id_dosen_pembimbing = DosenPembimbing::where('dosen_id_dosen', $dosen->id)->get('judul_skripsi_id_judul_skripsi');
        $id_judul_skripsi = JudulSkripsi::whereIn('id', $id_dosen_pembimbing)->orWhereIn('id', $id_dosen_penguji)->get('id');

        $seminar_proposal = SeminarProposal::whereIn('judul_skripsi_id_judul_skripsi', $id_judul_skripsi)
            ->orderBy('waktu_seminar_proposal', 'desc')
            ->get('id');
        foreach ($seminar_proposal as $seminar) {
            $data_seminar_proposal = SeminarProposal::findorfail($seminar->id);
            $data_judul_skripsi = JudulSkripsi::findorfail($data_seminar_proposal->judul_skripsi_id_judul_skripsi);
            $data_mahasiswa = Mahasiswa::findorfail($data_judul_skripsi->mahasiswa_id_mahasiswa);

            $seminar->mahasiswa = [
                'id' => $data_mahasiswa->id,
                'npm_mahasiswa' => $data_mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $data_mahasiswa->nama_mahasiswa
            ];
            $seminar->judul_skripsi = [
                'id' => $data_judul_skripsi->id,
                'nama_judul_skripsi' => $data_judul_skripsi->nama_judul_skripsi
            ];

            $cek_pembimbing = DosenPembimbing::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $data_judul_skripsi->id]
            ])->first();
            $cek_penguji = DosenPenguji::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $data_judul_skripsi->id]
            ])->first();

            if (!is_null($cek_pembimbing)) {
                $seminar->jabatan_dosen_seminar_proposal = 'Dosen Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $seminar->jabatan_dosen_seminar_proposal = 'Dosen Penguji ' . $cek_penguji->jabatan_dosen_penguji;
            }

            $seminar->waktu_seminar_proposal = $data_seminar_proposal->waktu_seminar_proposal;
            $seminar->tempat_seminar_proposal = $data_seminar_proposal->tempat_seminar_proposal;
            if ($data_seminar_proposal->waktu_seminar_proposal > Carbon::now() && $data_seminar_proposal->status_seminar_proposal == 'Proses') {
                $seminar->status_seminar_proposal = 'Belum Mulai';
            } elseif ($data_seminar_proposal->waktu_seminar_proposal <= Carbon::now() && $data_seminar_proposal->status_seminar_proposal == 'Proses') {
                $seminar->status_seminar_proposal = 'Sedang Berlangsung';
            } elseif ($data_seminar_proposal->status_seminar_proposal == 'Selesai') {
                $seminar->status_seminar_proposal = 'Selesai';
            }

            $cek_verifikasi = HasilSeminarProposal::where([
                ['dosen_id_dosen', $dosen->id],
                ['seminar_proposal_id_seminar', $data_seminar_proposal->id]
            ])->first();
            if (is_null($cek_verifikasi)) {
                $seminar->status_verifikasi_seminar_proposal = 'Belum Verifikasi';
            } else {
                $seminar->status_verifikasi_seminar_proposal = $cek_verifikasi->status_verifikasi_hasil_seminar_proposal;
            }
        }


        return response()->json([
            'message' => 'List of Data',
            'seminar_proposal' => $seminar_proposal,
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
