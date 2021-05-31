<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\HasilSeminarProposal;
use App\HasilSidangSkripsi;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\ProgramStudi;
use App\SeminarProposal;
use App\SidangSkripsi;
use Illuminate\Http\Request;

class AdminSidangSkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sidang_skripsi = SidangSkripsi::get('id');

        foreach ($sidang_skripsi as $sidang) {
            $data_sidang_skripsi = SidangSkripsi::findorfail($sidang->id);
            $data_judul_skripsi = JudulSkripsi::findorfail($data_sidang_skripsi->judul_skripsi_id_judul_skripsi);
            $data_mahasiswa = Mahasiswa::findorfail($data_judul_skripsi->mahasiswa_id_mahasiswa);
            $data_program_studi = ProgramStudi::findorfail($data_mahasiswa->program_studi_id_program_studi);

            $sidang->program_studi = [
                'id' => $data_program_studi->id,
                'kode_program_studi' => $data_program_studi->kode_program_studi,
                'nama_program_studi' => $data_program_studi->nama_program_studi
            ];
            $sidang->mahasiswa = [
                'id' => $data_mahasiswa->id,
                'npm_mahasiswa' => $data_mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $data_mahasiswa->nama_mahasiswa
            ];
            $sidang->status_sidang_skripsi = $data_sidang_skripsi->status_sidang_skripsi;
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
        $sidang_skripsi = SidangSkripsi::findorfail($id);
        $judul_skripsi = JudulSkripsi::findorfail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
        $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
        $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);

        $nilai_sidang_pembimbing1 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Pembimbing 1']
        ])->first();

        $nilai_sidang_pembimbing2 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Pembimbing 2']
        ])->first();

        $nilai_sidang_penguji1 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Penguji 1']
        ])->first();

        $nilai_sidang_penguji2 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Penguji 2']
        ])->first();

        if (is_null($nilai_sidang_pembimbing1) || is_null($nilai_sidang_pembimbing2) || is_null($nilai_sidang_penguji1) || is_null($nilai_sidang_penguji2)) {
            $response = [
                'message' => 'the verification process by the dosen pembimbing and penguji has not been completed',
            ];
            return response()->json($response, 404);
        } elseif ($nilai_sidang_pembimbing1->status_verifikasi_hasil_sidang_skripsi == 'Revisi' || $nilai_sidang_pembimbing2->status_verifikasi_hasil_sidang_skripsi == 'Revisi' || $nilai_sidang_penguji1->status_verifikasi_hasil_sidang_skripsi == 'Revisi' || $nilai_sidang_penguji2->status_verifikasi_hasil_sidang_skripsi == 'Revisi') {
            $response = [
                'message' => 'Incomplete data, please wait for the process input nilai to complete',
            ];
            return response()->json($response, 404);
        }

        $dosen_pembimbing1 = Dosen::findOrFail($nilai_sidang_pembimbing1->dosen_id_dosen);
        $dosen_pembimbing2 = Dosen::findOrFail($nilai_sidang_pembimbing2->dosen_id_dosen);
        $dosen_penguji1 = Dosen::findOrFail($nilai_sidang_penguji1->dosen_id_dosen);
        $dosen_penguji2 = Dosen::findOrFail($nilai_sidang_penguji2->dosen_id_dosen);

        //hitung nilai akhir sidang skripsi
        $rata2_nilaia_sidang_pembimbing1 = ($nilai_sidang_pembimbing1->nilai_a1_hasil_sidang_skripsi + $nilai_sidang_pembimbing1->nilai_a2_hasil_sidang_skripsi + $nilai_sidang_pembimbing1->nilai_a3_hasil_sidang_skripsi) / 3;
        $rata2_nilaia_sidang_pembimbing2 = ($nilai_sidang_pembimbing2->nilai_a1_hasil_sidang_skripsi + $nilai_sidang_pembimbing2->nilai_a2_hasil_sidang_skripsi + $nilai_sidang_pembimbing2->nilai_a3_hasil_sidang_skripsi) / 3;

        $rata2_nilaib_sidang_pembimbing1 = ((15 * $nilai_sidang_pembimbing1->nilai_b1_hasil_sidang_skripsi) + (15 * $nilai_sidang_pembimbing1->nilai_b2_hasil_sidang_skripsi) + (15 * $nilai_sidang_pembimbing1->nilai_b3_hasil_sidang_skripsi) + (15 * $nilai_sidang_pembimbing1->nilai_b4_hasil_sidang_skripsi) + (20 * $nilai_sidang_pembimbing1->nilai_b5_hasil_sidang_skripsi) + (10 * $nilai_sidang_pembimbing1->nilai_b6_hasil_sidang_skripsi) + (10 * $nilai_sidang_pembimbing1->nilai_b7_hasil_sidang_skripsi)) / 100;
        $rata2_nilaib_sidang_pembimbing2 = ((15 * $nilai_sidang_pembimbing2->nilai_b1_hasil_sidang_skripsi) + (15 * $nilai_sidang_pembimbing2->nilai_b2_hasil_sidang_skripsi) + (15 * $nilai_sidang_pembimbing2->nilai_b3_hasil_sidang_skripsi) + (15 * $nilai_sidang_pembimbing2->nilai_b4_hasil_sidang_skripsi) + (20 * $nilai_sidang_pembimbing2->nilai_b5_hasil_sidang_skripsi) + (10 * $nilai_sidang_pembimbing2->nilai_b6_hasil_sidang_skripsi) + (10 * $nilai_sidang_pembimbing2->nilai_b7_hasil_sidang_skripsi)) / 100;

        $rata2_nilaic_sidang_pembimbing1 = ((20 * $nilai_sidang_pembimbing1->nilai_c1_hasil_sidang_skripsi) + (50 * $nilai_sidang_pembimbing1->nilai_c2_hasil_sidang_skripsi) + (30 * $nilai_sidang_pembimbing1->nilai_c3_hasil_sidang_skripsi)) / 100;
        $rata2_nilaic_sidang_pembimbing2 = ((20 * $nilai_sidang_pembimbing2->nilai_c1_hasil_sidang_skripsi) + (50 * $nilai_sidang_pembimbing2->nilai_c2_hasil_sidang_skripsi) + (30 * $nilai_sidang_pembimbing2->nilai_c3_hasil_sidang_skripsi)) / 100;

        $rata2_nilaib_sidang_penguji1 = ((15 * $nilai_sidang_penguji1->nilai_b1_hasil_sidang_skripsi) + (15 * $nilai_sidang_penguji1->nilai_b2_hasil_sidang_skripsi) + (15 * $nilai_sidang_penguji1->nilai_b3_hasil_sidang_skripsi) + (15 * $nilai_sidang_penguji1->nilai_b4_hasil_sidang_skripsi) + (20 * $nilai_sidang_penguji1->nilai_b5_hasil_sidang_skripsi) + (10 * $nilai_sidang_penguji1->nilai_b6_hasil_sidang_skripsi) + (10 * $nilai_sidang_penguji1->nilai_b7_hasil_sidang_skripsi)) / 100;
        $rata2_nilaib_sidang_penguji2 = ((15 * $nilai_sidang_penguji2->nilai_b1_hasil_sidang_skripsi) + (15 * $nilai_sidang_penguji2->nilai_b2_hasil_sidang_skripsi) + (15 * $nilai_sidang_penguji2->nilai_b3_hasil_sidang_skripsi) + (15 * $nilai_sidang_penguji2->nilai_b4_hasil_sidang_skripsi) + (20 * $nilai_sidang_penguji2->nilai_b5_hasil_sidang_skripsi) + (10 * $nilai_sidang_penguji2->nilai_b6_hasil_sidang_skripsi) + (10 * $nilai_sidang_penguji2->nilai_b7_hasil_sidang_skripsi)) / 100;

        $rata2_nilaic_sidang_penguji1 = ((20 * $nilai_sidang_penguji1->nilai_c1_hasil_sidang_skripsi) + (50 * $nilai_sidang_penguji1->nilai_c2_hasil_sidang_skripsi) + (30 * $nilai_sidang_penguji1->nilai_c3_hasil_sidang_skripsi)) / 100;
        $rata2_nilaic_sidang_penguji2 = ((20 * $nilai_sidang_penguji2->nilai_c1_hasil_sidang_skripsi) + (50 * $nilai_sidang_penguji2->nilai_c2_hasil_sidang_skripsi) + (30 * $nilai_sidang_penguji2->nilai_c3_hasil_sidang_skripsi)) / 100;

        $rata2_nilaia_sidang = ($rata2_nilaia_sidang_pembimbing1 + $rata2_nilaia_sidang_pembimbing2) / 2;
        $rata2_nilaib_sidang = ($rata2_nilaib_sidang_pembimbing1 + $rata2_nilaib_sidang_pembimbing2 + $rata2_nilaib_sidang_penguji1 + $rata2_nilaib_sidang_penguji2) / 4;
        $rata2_nilaic_sidang = ($rata2_nilaic_sidang_pembimbing1 + $rata2_nilaic_sidang_pembimbing2 + $rata2_nilaic_sidang_penguji1 + $rata2_nilaic_sidang_penguji2) / 4;

        $nilai_akhir_sidang = ((20 * $rata2_nilaia_sidang) + (30 * $rata2_nilaib_sidang) + (50 * $rata2_nilaic_sidang)) / 100;
        //akhir hitung nilai sidang skripsi

        $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        $nilai_seminar_pembimbing1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 1']
        ])->first();

        $nilai_seminar_pembimbing2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 2']
        ])->first();

        $nilai_seminar_penguji1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 1']
        ])->first();

        $nilai_seminar_penguji2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 2']
        ])->first();

        //hitung nilai akhir seminar proposal
        $rata2_nilaia_seminar_pembimbing1 = ($nilai_seminar_pembimbing1->nilai_a1_hasil_seminar_proposal + $nilai_seminar_pembimbing1->nilai_a2_hasil_seminar_proposal + $nilai_seminar_pembimbing1->nilai_a3_hasil_seminar_proposal) / 3;
        $rata2_nilaia_seminar_pembimbing2 = ($nilai_seminar_pembimbing2->nilai_a1_hasil_seminar_proposal + $nilai_seminar_pembimbing2->nilai_a2_hasil_seminar_proposal + $nilai_seminar_pembimbing2->nilai_a3_hasil_seminar_proposal) / 3;

        $rata2_nilaib_seminar_pembimbing1 = ((15 * $nilai_seminar_pembimbing1->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_seminar_pembimbing1->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_seminar_pembimbing1->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_seminar_pembimbing1->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_seminar_pembimbing1->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_seminar_pembimbing1->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_seminar_pembimbing1->nilai_b7_hasil_seminar_proposal)) / 100;
        $rata2_nilaib_seminar_pembimbing2 = ((15 * $nilai_seminar_pembimbing2->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_seminar_pembimbing2->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_seminar_pembimbing2->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_seminar_pembimbing2->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_seminar_pembimbing2->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_seminar_pembimbing2->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_seminar_pembimbing2->nilai_b7_hasil_seminar_proposal)) / 100;

        $rata2_nilaic_seminar_pembimbing1 = ((20 * $nilai_seminar_pembimbing1->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_seminar_pembimbing1->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_seminar_pembimbing1->nilai_c3_hasil_seminar_proposal)) / 100;
        $rata2_nilaic_seminar_pembimbing2 = ((20 * $nilai_seminar_pembimbing2->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_seminar_pembimbing2->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_seminar_pembimbing2->nilai_c3_hasil_seminar_proposal)) / 100;

        $rata2_nilaib_seminar_penguji1 = ((15 * $nilai_seminar_penguji1->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_seminar_penguji1->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_seminar_penguji1->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_seminar_penguji1->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_seminar_penguji1->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_seminar_penguji1->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_seminar_penguji1->nilai_b7_hasil_seminar_proposal)) / 100;
        $rata2_nilaib_seminar_penguji2 = ((15 * $nilai_seminar_penguji2->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_seminar_penguji2->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_seminar_penguji2->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_seminar_penguji2->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_seminar_penguji2->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_seminar_penguji2->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_seminar_penguji2->nilai_b7_hasil_seminar_proposal)) / 100;

        $rata2_nilaic_seminar_penguji1 = ((20 * $nilai_seminar_penguji1->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_seminar_penguji1->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_seminar_penguji1->nilai_c3_hasil_seminar_proposal)) / 100;
        $rata2_nilaic_seminar_penguji2 = ((20 * $nilai_seminar_penguji2->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_seminar_penguji2->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_seminar_penguji2->nilai_c3_hasil_seminar_proposal)) / 100;

        $rata2_nilaia_seminar = ($rata2_nilaia_seminar_pembimbing1 + $rata2_nilaia_seminar_pembimbing2) / 2;
        $rata2_nilaib_seminar = ($rata2_nilaib_seminar_pembimbing1 + $rata2_nilaib_seminar_pembimbing2 + $rata2_nilaib_seminar_penguji1 + $rata2_nilaib_seminar_penguji2) / 4;
        $rata2_nilaic_seminar = ($rata2_nilaic_seminar_pembimbing1 + $rata2_nilaic_seminar_pembimbing2 + $rata2_nilaic_seminar_penguji1 + $rata2_nilaic_seminar_penguji2) / 4;

        $nilai_akhir_seminar = ((20 * $rata2_nilaia_seminar) + (30 * $rata2_nilaib_seminar) + (50 * $rata2_nilaic_seminar)) / 100;
        //akhir hitung nilai seminar proposal

        $nilai_akhir = ($nilai_akhir_sidang + $nilai_akhir_seminar) / 2;

        $data = [
            'id' => $sidang_skripsi->id,
            'mahasiswa' => [
                'id' => $mahasiswa->id,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa
            ],
            'program_studi' => [
                'id' => $program_studi->id,
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi
            ],
            'judul_skripsi' => [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ],
            'dosen_pembimbing_1' => [
                'id' => $dosen_pembimbing1->id,
                'nama_dosen_pembimbing_1' => $dosen_pembimbing1->nama_dosen . ', ' . $dosen_pembimbing1->gelar_dosen,
                'nidn_dosen_pembimbing_1' => $dosen_pembimbing1->nidn_dosen
            ],
            'dosen_pembimbing_2' => [
                'id' => $dosen_pembimbing2->id,
                'nama_dosen_pembimbing_2' => $dosen_pembimbing2->nama_dosen . ', ' . $dosen_pembimbing2->gelar_dosen,
                'nidn_dosen_pembimbing_2' => $dosen_pembimbing2->nidn_dosen
            ],
            'dosen_penguji_1' => [
                'id' => $dosen_penguji1->id,
                'nama_dosen_penguji_1' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                'nidn_dosen_penguji_1' => $dosen_penguji1->nidn_dosen
            ],
            'dosen_penguji_2' => [
                'id' => $dosen_penguji2->id,
                'nama_dosen_penguji_2' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen,
                'nidn_dosen_penguji_2' => $dosen_penguji2->nidn_dosen
            ],
            'tanggal_sidang_skripsi' => $sidang_skripsi->waktu_sidang_skripsi,
            'status_mahasiswa_sidang_skripsi' => $mahasiswa->status_mahasiswa,
            'nilai_akhir_sidang_skripsi' => round($nilai_akhir, 0)
        ];


        return response()->json([
            'message' => 'Data details',
            'detail_sidang_skripsi' => $data,
        ], 200);
    }
}
