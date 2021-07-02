<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\HasilSeminarProposal;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use App\ProgramStudi;
use App\Fakultas;

class MahasiswaHasilSeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        if (is_null($judul_skripsi)) {
            $response = [
                'status'  => 'error',
                'message' => 'Judul Skripsi Not Found, please upload data',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 404);
        }
        $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($seminar_proposal)) {
            $response = [
                'status'  => 'error',
                'message' => 'Seminar Proposal Not Found, please upload data',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 404);
        }

        $hasil_seminar_proposal = HasilSeminarProposal::where('seminar_proposal_id_seminar', $seminar_proposal->id)
            ->get('id');
        if ($hasil_seminar_proposal->count() == 0) {
            $response = [
                'status'  => 'error',
                'message' => 'Hasil Seminar Proposal Not Found',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 404);
        }
        foreach ($hasil_seminar_proposal as $hasil_seminar) {
            $data_hasil_seminar = HasilSeminarProposal::findOrFail($hasil_seminar->id);
            $data_dosen = Dosen::findOrFail($data_hasil_seminar->dosen_id_dosen);

            $hasil_seminar->dosen = [
                'id' => $data_dosen->id,
                'nama_dosen' => $data_dosen->nama_dosen . ', ' . $data_dosen->gelar_dosen,
                'nidn_dosen' => $data_dosen->nidn_dosen,
                'status_dosen' => $data_hasil_seminar->jenis_dosen_hasil_seminar_proposal,
            ];
            $hasil_seminar->status_verifikasi_hasil_seminar_proposal = $data_hasil_seminar->status_verifikasi_hasil_seminar_proposal;
            $hasil_seminar->catatan_hasil_seminar_proposal = $data_hasil_seminar->catatan_hasil_seminar_proposal;
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Hasil Seminar Proposal',
            'data' => $hasil_seminar_proposal,
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

        $hasil_seminar_proposal = HasilSeminarProposal::findOrFail($id);
        $dosen = Dosen::findOrFail($hasil_seminar_proposal->dosen_id_dosen);

        $data = [
            'id' => $hasil_seminar_proposal->id,
            'dosen' => [
                'id' => $dosen->id,
                'nama_dosen' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
                'nidn_dosen' => $dosen->nidn_dosen,
                'status_dosen' => $hasil_seminar_proposal->jenis_dosen_hasil_seminar_proposal
            ],
            'status_verifikasi_hasil_seminar_proposal' => $hasil_seminar_proposal->status_verifikasi_hasil_seminar_proposal,
            'catatan_hasil_seminar_proposal' => $hasil_seminar_proposal->catatan_hasil_seminar_proposal
        ];

        $response = [
            'status'  => 'success',
            'message' => 'Details Hasil Seminar Proposal',
            'data' => $data
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json($response, 200);
    }

    public function daftar_nilai(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);
        $fakultas = Fakultas::findorfail($program_studi->fakultas_id_fakultas);

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
                'message' => 'The verification process by the dosen pembimbing and penguji has not been completed',
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
                'message' => 'Incomplete data, please wait for the input process to complete',
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
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
            ],
            'program_studi' => [
                'id' => $program_studi->id,
                'fakultas_program_studi' => $fakultas->nama_fakultas,
                'nama_program_studi' => $program_studi->nama_program_studi,
            ],
            'judul_skripsi' => [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi,
            ],
            'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal,
            'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal,
            'dosen_pembimbing_1' => [
                'id' => $dosen_pembimbing1->id,
                'nama_dosen' => $dosen_pembimbing1->nama_dosen . ', ' . $dosen_pembimbing1->gelar_dosen,
                'nidn_dosen' => $dosen_pembimbing1->nidn_dosen
            ],
            'dosen_pembimbing_2' => [
                'id' => $dosen_pembimbing2->id,
                'nama_dosen' => $dosen_pembimbing2->nama_dosen . ', ' . $dosen_pembimbing2->gelar_dosen,
                'nidn_dosen' => $dosen_pembimbing2->nidn_dosen
            ],
            'dosen_penguji_1' => [
                'id' => $dosen_penguji1->id,
                'nama_dosen' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                'nidn_dosen' => $dosen_penguji1->nidn_dosen
            ],
            'dosen_penguji_2' => [
                'id' => $dosen_penguji2->id,
                'nama_dosen' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen,
                'nidn_dosen' => $dosen_penguji2->nidn_dosen
            ],
            'rekap_nilai_seminar_proposal' => [
                'rata2_nilai_a_hasil_seminar_proposal' => round($rata2_nilaia, 0),
                'rata2_nilai_b_hasil_seminar_proposal' => round($rata2_nilaib, 0),
                'rata2_nilai_c_hasil_seminar_proposal' => round($rata2_nilaic, 0),
                'jumlah_rata2_nilai_hasil_seminar_proposal' => round($rata2_nilaia + $rata2_nilaib + $rata2_nilaic, 0),
                'nilai_akhir_hasil_seminar_proposal' => round($nilai_akhir, 0),
            ]
        ];

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();
        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Rekap Nilai Seminar Proposal',
            'data' => $data,
        ], 200);
    }
}
