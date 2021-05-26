<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPenguji;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersetujuanDosenPengujiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $dosen_penguji = DosenPenguji::where('dosen_id_dosen', $dosen->id)
            ->orderBy('persetujuan_dosen_penguji', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get('id');

        foreach ($dosen_penguji as $penguji) {
            $data_dosen_penguji = DosenPenguji::findorfail($penguji->id);
            $data_judul_skripsi = JudulSkripsi::findorfail($data_dosen_penguji->judul_skripsi_id_judul_skripsi);
            $data_mahasiswa = Mahasiswa::findorfail($data_judul_skripsi->mahasiswa_id_mahasiswa);

            $penguji->mahasiswa = [
                'id' => $data_mahasiswa->id,
                'npm_mahasiswa' => $data_mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $data_mahasiswa->nama_mahasiswa
            ];
            $penguji->judul_skripsi = [
                'id' => $data_judul_skripsi->id,
                'nama_judul_skripsi' => $data_judul_skripsi->nama_judul_skripsi
            ];
            $penguji->jabatan_dosen_penguji = $data_dosen_penguji->jabatan_dosen_penguji;
            $penguji->status_persetujuan_dosen_penguji = $data_dosen_penguji->persetujuan_dosen_penguji;
            $penguji->created_at = $data_dosen_penguji->created_at;
        }

        return response()->json([
            'message' => 'List of Data',
            'persetujuan_dosen_penguji' => $dosen_penguji,
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
            $dosen_penguji = DosenPenguji::findorfail($id);
            $cek_dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            if ($cek_dosen->id != $dosen_penguji->dosen_id_dosen) {
                $response = [
                    'message' => 'You do not have access to data with id ' . $dosen_penguji->id,
                ];

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
                'jabatan_dosen_penguji' => $dosen_penguji->jabatan_dosen_penguji,
                'status_persetujuan_dosen_penguji' => $dosen_penguji->persetujuan_dosen_penguji
            ];

            $response = [
                'message' => 'Data details',
                'persetujuan_dosen_penguji' => $data
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
            'status_persetujuan_dosen_penguji' => 'required|in:Antrian,Disetujui,Ditolak',
        ]);

        $dosen_penguji = DosenPenguji::findorfail($id);
        $cek_dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        if ($cek_dosen->id != $dosen_penguji->dosen_id_dosen) {
            $response = [
                'message' => 'You do not have access to data with id ' . $dosen_penguji->id,
            ];

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

            return response()->json([
                'message' => 'verification is successful',
                'persetujuan_dosen_penguji' => $data,
            ], 200);
        }
        return response()->json([
            'message' => 'the data has been verified, you can not change the verification status'
        ], 400);
    }
}
