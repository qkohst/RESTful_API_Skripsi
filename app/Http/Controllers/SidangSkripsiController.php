<?php

namespace App\Http\Controllers;

use App\AdminProdi;
use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\ProgramStudi;
use App\SidangSkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SidangSkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();

        $mahasiswa = Mahasiswa::where('program_studi_id_program_studi', $program_studi->id)->get('id');
        $judul_skripsi = JudulSkripsi::whereIn('mahasiswa_id_mahasiswa', $mahasiswa)->get('id');
        $sidang_skripsi = SidangSkripsi::whereIn('judul_skripsi_id_judul_skripsi', $judul_skripsi)
            ->where([
                ['persetujuan_pembimbing1_sidang_skripsi', 'Disetujui'],
                ['persetujuan_pembimbing2_sidang_skripsi', 'Disetujui']
            ])
            ->orderBy('status_sidang_skripsi', 'asc')
            ->orderBy('updated_at', 'asc')
            ->get('id');

        foreach ($sidang_skripsi as $sidang) {
            $data_sidang_skripsi = SidangSkripsi::findorfail($sidang->id);
            $data_judul_skripsi = JudulSkripsi::findorfail($data_sidang_skripsi->judul_skripsi_id_judul_skripsi);
            $data_mahasiswa = Mahasiswa::findorfail($data_judul_skripsi->mahasiswa_id_mahasiswa);

            $sidang->mahasiswa = [
                'id' => $data_mahasiswa->id,
                'npm_mahasiswa' => $data_mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $data_mahasiswa->nama_mahasiswa
            ];
            $sidang->judul_skripsi = [
                'id' => $data_judul_skripsi->id,
                'nama_judul_skripsi' => $data_judul_skripsi->nama_judul_skripsi
            ];
            $sidang->persetujuan_pembimbing_sidang_skripsi = 'Disetujui';
            if (is_null($data_sidang_skripsi->waktu_sidang_skripsi)) {
                $sidang->waktu_sidang_skripsi = 'Belum Ditentukan';
            } else {
                $sidang->waktu_sidang_skripsi = $data_sidang_skripsi->waktu_sidang_skripsi;
            }
            $sidang->created_at = $data_sidang_skripsi->created_at;
        }

        return response()->json([
            'message' => 'List of Data',
            'sidang_skripsi' => $sidang_skripsi,
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

            $pembimbing1 = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_pembimbing', '1']
            ])->first();
            $dosen_pembimbing1 = Dosen::findorfail($pembimbing1->dosen_id_dosen);
            $pembimbing2 = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_pembimbing', '2']
            ])->first();
            $dosen_pembimbing2 = Dosen::findorfail($pembimbing2->dosen_id_dosen);

            $penguji1 = DosenPenguji::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_penguji', '1']
            ])->first();
            $dosen_penguji1 = Dosen::findorfail($penguji1->dosen_id_dosen);
            $penguji2 = DosenPenguji::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_penguji', '2']
            ])->first();
            $dosen_penguji2 = Dosen::findorfail($penguji2->dosen_id_dosen);

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
                'pembimbing1_sidang_skripsi' => $dosen_pembimbing1->nama_dosen . ', ' . $dosen_pembimbing1->gelar_dosen,
                'pembimbing2_sidang_skripsi' => $dosen_pembimbing2->nama_dosen . ', ' . $dosen_pembimbing2->gelar_dosen,
                'penguji1_sidang_skripsi' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                'penguji2_sidang_skripsi' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen
            ];

            $response = [
                'message' => 'Data details',
                'sidang_skripsi' => $data
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
            'waktu_sidang_skripsi' => 'required|date_format:Y-m-d H:i:s|after:today',
            'tempat_sidang_skripsi' => 'required|min:3'
        ]);

        $sidang_skripsi = SidangSkripsi::findOrFail($id);
        $judul_skripsi = JudulSkripsi::findOrFail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
        $mahasiswa = Mahasiswa::findOrFail($judul_skripsi->mahasiswa_id_mahasiswa);

        if ($sidang_skripsi->status_sidang_skripsi == 'Pengajuan') {
            $sidang_skripsi->waktu_sidang_skripsi = $request->waktu_sidang_skripsi;
            $sidang_skripsi->tempat_sidang_skripsi = $request->tempat_sidang_skripsi;
            $sidang_skripsi->status_sidang_skripsi = 'Proses';
            $sidang_skripsi->update();

            $data = [
                'id' => $sidang_skripsi->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'waktu_sidang_skripsi' => $sidang_skripsi->waktu_sidang_skripsi,
                'tempat_sidang_skripsi' => $sidang_skripsi->tempat_sidang_skripsi,
                'updated_at' => $sidang_skripsi->updated_at
            ];

            $response = [
                'message' => 'The time has been determined successfully',
                'seminar_proposal' => $data
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'The time is set, you cannot change data.',
            ];
            return response()->json($response, 400);
        }
    }
}
