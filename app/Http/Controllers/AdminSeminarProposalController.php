<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\HasilSeminarProposal;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\ProgramStudi;
use App\SeminarProposal;
use Illuminate\Http\Request;
use App\ApiClient;
use App\TrafficRequest;

class AdminSeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $seminar_proposal = SeminarProposal::get('id');

        foreach ($seminar_proposal as $seminar) {
            $data_seminar_proposal = SeminarProposal::findorfail($seminar->id);
            $data_judul_skripsi = JudulSkripsi::findorfail($data_seminar_proposal->judul_skripsi_id_judul_skripsi);
            $data_mahasiswa = Mahasiswa::findorfail($data_judul_skripsi->mahasiswa_id_mahasiswa);
            $data_program_studi = ProgramStudi::findorfail($data_mahasiswa->program_studi_id_program_studi);

            $seminar->program_studi = [
                'id' => $data_program_studi->id,
                'kode_program_studi' => $data_program_studi->kode_program_studi,
                'nama_program_studi' => $data_program_studi->nama_program_studi
            ];
            $seminar->mahasiswa = [
                'id' => $data_mahasiswa->id,
                'npm_mahasiswa' => $data_mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $data_mahasiswa->nama_mahasiswa
            ];
            $seminar->status_seminar_proposal = $data_seminar_proposal->status_seminar_proposal;
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Seminar Proposal',
            'data' => $seminar_proposal,
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

        $seminar_proposal = SeminarProposal::findorfail($id);
        $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
        $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
        $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);

        $nilai_pembimbing1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 1']
        ])->first();

        $nilai_pembimbing2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 2']
        ])->first();

        $nilai_penguji1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 1']
        ])->first();

        $nilai_penguji2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 2']
        ])->first();

        if (is_null($nilai_pembimbing1) || is_null($nilai_pembimbing2) || is_null($nilai_penguji1) || is_null($nilai_penguji2)) {
            $response = [
                'status'  => 'error',
                'message' => 'the verification process by the dosen pembimbing and penguji has not been completed',
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        } elseif ($nilai_pembimbing1->status_verifikasi_hasil_seminar_proposal == 'Revisi' || $nilai_pembimbing2->status_verifikasi_hasil_seminar_proposal == 'Revisi' || $nilai_penguji1->status_verifikasi_hasil_seminar_proposal == 'Revisi' || $nilai_penguji2->status_verifikasi_hasil_seminar_proposal == 'Revisi') {
            $response = [
                'status'  => 'error',
                'message' => 'Incomplete data, please wait for the process input nilai to complete',
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }

        $dosen_pembimbing1 = Dosen::findOrFail($nilai_pembimbing1->dosen_id_dosen);
        $dosen_pembimbing2 = Dosen::findOrFail($nilai_pembimbing2->dosen_id_dosen);
        $dosen_penguji1 = Dosen::findOrFail($nilai_penguji1->dosen_id_dosen);
        $dosen_penguji2 = Dosen::findOrFail($nilai_penguji2->dosen_id_dosen);

        //hitung nilai akhir
        $rata2_nilaia_pembimbing1 = ($nilai_pembimbing1->nilai_a1_hasil_seminar_proposal + $nilai_pembimbing1->nilai_a2_hasil_seminar_proposal + $nilai_pembimbing1->nilai_a3_hasil_seminar_proposal) / 3;
        $rata2_nilaia_pembimbing2 = ($nilai_pembimbing2->nilai_a1_hasil_seminar_proposal + $nilai_pembimbing2->nilai_a2_hasil_seminar_proposal + $nilai_pembimbing2->nilai_a3_hasil_seminar_proposal) / 3;

        $rata2_nilaib_pembimbing1 = ((15 * $nilai_pembimbing1->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_pembimbing1->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_pembimbing1->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_pembimbing1->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_pembimbing1->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_pembimbing1->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_pembimbing1->nilai_b7_hasil_seminar_proposal)) / 100;
        $rata2_nilaib_pembimbing2 = ((15 * $nilai_pembimbing2->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_pembimbing2->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_pembimbing2->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_pembimbing2->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_pembimbing2->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_pembimbing2->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_pembimbing2->nilai_b7_hasil_seminar_proposal)) / 100;

        $rata2_nilaic_pembimbing1 = ((20 * $nilai_pembimbing1->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_pembimbing1->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_pembimbing1->nilai_c3_hasil_seminar_proposal)) / 100;
        $rata2_nilaic_pembimbing2 = ((20 * $nilai_pembimbing2->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_pembimbing2->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_pembimbing2->nilai_c3_hasil_seminar_proposal)) / 100;

        $rata2_nilaib_penguji1 = ((15 * $nilai_penguji1->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_penguji1->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_penguji1->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_penguji1->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_penguji1->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_penguji1->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_penguji1->nilai_b7_hasil_seminar_proposal)) / 100;
        $rata2_nilaib_penguji2 = ((15 * $nilai_penguji2->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_penguji2->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_penguji2->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_penguji2->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_penguji2->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_penguji2->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_penguji2->nilai_b7_hasil_seminar_proposal)) / 100;

        $rata2_nilaic_penguji1 = ((20 * $nilai_penguji1->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_penguji1->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_penguji1->nilai_c3_hasil_seminar_proposal)) / 100;
        $rata2_nilaic_penguji2 = ((20 * $nilai_penguji2->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_penguji2->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_penguji2->nilai_c3_hasil_seminar_proposal)) / 100;

        $rata2_nilaia = ($rata2_nilaia_pembimbing1 + $rata2_nilaia_pembimbing2) / 2;
        $rata2_nilaib = ($rata2_nilaib_pembimbing1 + $rata2_nilaib_pembimbing2 + $rata2_nilaib_penguji1 + $rata2_nilaib_penguji2) / 4;
        $rata2_nilaic = ($rata2_nilaic_pembimbing1 + $rata2_nilaic_pembimbing2 + $rata2_nilaic_penguji1 + $rata2_nilaic_penguji2) / 4;

        $nilai_akhir = ((20 * $rata2_nilaia) + (30 * $rata2_nilaib) + (50 * $rata2_nilaic)) / 100;
        //akhir hitung nilai

        $data = [
            'id' => $seminar_proposal->id,
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
            'tanggal_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal,
            'status_seminar_proposal' => 'Lulus Seminar',
            'nilai_akhir_seminar_proposal' => round($nilai_akhir, 0)
        ];

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();
        return response()->json([
            'status'  => 'success',
            'message' => 'Details Data Seminar Proposal',
            'data' => $data,
        ], 200);
    }
}
