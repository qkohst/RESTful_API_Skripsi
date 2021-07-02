<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\HasilSeminarProposal;
use App\HasilSidangSkripsi;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use App\SidangSkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use App\ProgramStudi;
use App\Fakultas;

class MahasiswaHasilSidangSkripsiController extends Controller
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

        $sidang_skripsi = SidangSkripsi::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($sidang_skripsi)) {
            $response = [
                'status'  => 'error',
                'message' => 'Sidang Skripsi Not Found, please upload data',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 404);
        }

        $hasil_sidang_skripsi = HasilSidangSkripsi::where('sidang_skripsi_id_sidang', $sidang_skripsi->id)
            ->get('id');
        if ($hasil_sidang_skripsi->count() == 0) {
            $response = [
                'status'  => 'error',
                'message' => 'Hasil Sidang Skripsi Not Found',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 404);
        }

        foreach ($hasil_sidang_skripsi as $hasil_sidang) {
            $data_hasil_sidang = HasilSidangSkripsi::findOrFail($hasil_sidang->id);
            $data_dosen = Dosen::findOrFail($data_hasil_sidang->dosen_id_dosen);

            $hasil_sidang->dosen = [
                'id' => $data_dosen->id,
                'nama_dosen' => $data_dosen->nama_dosen . ', ' . $data_dosen->gelar_dosen,
                'nidn_dosen' => $data_dosen->nidn_dosen,
                'status_dosen' => $data_hasil_sidang->jenis_dosen_hasil_sidang_skripsi,
            ];
            $hasil_sidang->status_verifikasi_hasil_sidang_skripsi = $data_hasil_sidang->status_verifikasi_hasil_sidang_skripsi;
            $hasil_sidang->catatan_hasil_sidang_skripsi = $data_hasil_sidang->catatan_hasil_sidang_skripsi;
        }
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Hasil Sidang Skripsi',
            'data' => $hasil_sidang_skripsi,
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

        $hasil_sidang_skripsi = HasilSidangSkripsi::findOrFail($id);
        $dosen = Dosen::findOrFail($hasil_sidang_skripsi->dosen_id_dosen);

        $data = [
            'id' => $hasil_sidang_skripsi->id,
            'dosen' => [
                'id' => $dosen->id,
                'nama_dosen' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
                'nidn_dosen' => $dosen->nidn_dosen,
                'status_dosen' => $hasil_sidang_skripsi->jenis_dosen_hasil_sidang_skripsi
            ],
            'status_verifikasi_hasil_sidang_skripsi' => $hasil_sidang_skripsi->status_verifikasi_hasil_sidang_skripsi,
            'catatan_hasil_sidang_skripsi' => $hasil_sidang_skripsi->catatan_hasil_sidang_skripsi
        ];

        $response = [
            'status'  => 'success',
            'message' => 'Details Data Sidang Skripsi',
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
        $sidang_skripsi = SidangSkripsi::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);
        $fakultas = Fakultas::findorfail($program_studi->fakultas_id_fakultas);

        $nilai_pembimbing1 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Pembimbing 1']
        ])->first();

        $nilai_pembimbing2 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Pembimbing 2']
        ])->first();

        $nilai_penguji1 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Penguji 1']
        ])->first();

        $nilai_penguji2 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Penguji 2']
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
        } elseif ($nilai_pembimbing1->status_verifikasi_hasil_sidang_skripsi == 'Revisi' || $nilai_pembimbing2->status_verifikasi_hasil_sidang_skripsi == 'Revisi' || $nilai_penguji1->status_verifikasi_hasil_sidang_skripsi == 'Revisi' || $nilai_penguji2->status_verifikasi_hasil_sidang_skripsi == 'Revisi') {
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

        //hitung nilai akhir sidang 
        $rata2_nilaia_pembimbing1 = ($nilai_pembimbing1->nilai_a1_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_a2_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_a3_hasil_sidang_skripsi) / 3;
        $rata2_nilaia_pembimbing2 = ($nilai_pembimbing2->nilai_a1_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_a2_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_a3_hasil_sidang_skripsi) / 3;

        $rata2_nilaib_pembimbing1 = ((15 * $nilai_pembimbing1->nilai_b1_hasil_sidang_skripsi) + (15 * $nilai_pembimbing1->nilai_b2_hasil_sidang_skripsi) + (15 * $nilai_pembimbing1->nilai_b3_hasil_sidang_skripsi) + (15 * $nilai_pembimbing1->nilai_b4_hasil_sidang_skripsi) + (20 * $nilai_pembimbing1->nilai_b5_hasil_sidang_skripsi) + (10 * $nilai_pembimbing1->nilai_b6_hasil_sidang_skripsi) + (10 * $nilai_pembimbing1->nilai_b7_hasil_sidang_skripsi)) / 100;
        $rata2_nilaib_pembimbing2 = ((15 * $nilai_pembimbing2->nilai_b1_hasil_sidang_skripsi) + (15 * $nilai_pembimbing2->nilai_b2_hasil_sidang_skripsi) + (15 * $nilai_pembimbing2->nilai_b3_hasil_sidang_skripsi) + (15 * $nilai_pembimbing2->nilai_b4_hasil_sidang_skripsi) + (20 * $nilai_pembimbing2->nilai_b5_hasil_sidang_skripsi) + (10 * $nilai_pembimbing2->nilai_b6_hasil_sidang_skripsi) + (10 * $nilai_pembimbing2->nilai_b7_hasil_sidang_skripsi)) / 100;

        $rata2_nilaic_pembimbing1 = ((20 * $nilai_pembimbing1->nilai_c1_hasil_sidang_skripsi) + (50 * $nilai_pembimbing1->nilai_c2_hasil_sidang_skripsi) + (30 * $nilai_pembimbing1->nilai_c3_hasil_sidang_skripsi)) / 100;
        $rata2_nilaic_pembimbing2 = ((20 * $nilai_pembimbing2->nilai_c1_hasil_sidang_skripsi) + (50 * $nilai_pembimbing2->nilai_c2_hasil_sidang_skripsi) + (30 * $nilai_pembimbing2->nilai_c3_hasil_sidang_skripsi)) / 100;

        $rata2_nilaib_penguji1 = ((15 * $nilai_penguji1->nilai_b1_hasil_sidang_skripsi) + (15 * $nilai_penguji1->nilai_b2_hasil_sidang_skripsi) + (15 * $nilai_penguji1->nilai_b3_hasil_sidang_skripsi) + (15 * $nilai_penguji1->nilai_b4_hasil_sidang_skripsi) + (20 * $nilai_penguji1->nilai_b5_hasil_sidang_skripsi) + (10 * $nilai_penguji1->nilai_b6_hasil_sidang_skripsi) + (10 * $nilai_penguji1->nilai_b7_hasil_sidang_skripsi)) / 100;
        $rata2_nilaib_penguji2 = ((15 * $nilai_penguji2->nilai_b1_hasil_sidang_skripsi) + (15 * $nilai_penguji2->nilai_b2_hasil_sidang_skripsi) + (15 * $nilai_penguji2->nilai_b3_hasil_sidang_skripsi) + (15 * $nilai_penguji2->nilai_b4_hasil_sidang_skripsi) + (20 * $nilai_penguji2->nilai_b5_hasil_sidang_skripsi) + (10 * $nilai_penguji2->nilai_b6_hasil_sidang_skripsi) + (10 * $nilai_penguji2->nilai_b7_hasil_sidang_skripsi)) / 100;

        $rata2_nilaic_penguji1 = ((20 * $nilai_penguji1->nilai_c1_hasil_sidang_skripsi) + (50 * $nilai_penguji1->nilai_c2_hasil_sidang_skripsi) + (30 * $nilai_penguji1->nilai_c3_hasil_sidang_skripsi)) / 100;
        $rata2_nilaic_penguji2 = ((20 * $nilai_penguji2->nilai_c1_hasil_sidang_skripsi) + (50 * $nilai_penguji2->nilai_c2_hasil_sidang_skripsi) + (30 * $nilai_penguji2->nilai_c3_hasil_sidang_skripsi)) / 100;

        $rata2_nilaia = ($rata2_nilaia_pembimbing1 + $rata2_nilaia_pembimbing2) / 2;
        $rata2_nilaib = ($rata2_nilaib_pembimbing1 + $rata2_nilaib_pembimbing2 + $rata2_nilaib_penguji1 + $rata2_nilaib_penguji2) / 4;
        $rata2_nilaic = ($rata2_nilaic_pembimbing1 + $rata2_nilaic_pembimbing2 + $rata2_nilaic_penguji1 + $rata2_nilaic_penguji2) / 4;

        $nilai_akhir_sidang = ((20 * $rata2_nilaia) + (30 * $rata2_nilaib) + (50 * $rata2_nilaic)) / 100;
        //akhir hitung nilai sidang 

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

        $nilai_akhir = (60 / 100 * $nilai_akhir_sidang) + (40 / 100 * $nilai_akhir_seminar);

        $data = [
            'id' => $sidang_skripsi->id,
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
            'waktu_sidang_skripsi' => $sidang_skripsi->waktu_sidang_skripsi,
            'tempat_sidang_skripsi' => $sidang_skripsi->tempat_sidang_skripsi,
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
            'rekap_nilai_sidang' => [
                'rata2_nilai_a_hasil_sidang_skripsi' => round($rata2_nilaia, 0),
                'rata2_nilai_b_hasil_sidang_skripsi' => round($rata2_nilaib, 0),
                'rata2_nilai_c_hasil_sidang_skripsi' => round($rata2_nilaic, 0),
                'jumlah_rata2_nilai_hasil_sidang_skripsi' => round($rata2_nilaia + $rata2_nilaib + $rata2_nilaic, 0),
                'nilai_akhir_hasil_sidang_skripsi' => round($nilai_akhir_sidang, 0),
            ],
            'rekap_nilai_seminar' => [
                'rata2_nilai_a_hasil_seminar_proposal' => round($rata2_nilaia_seminar, 0),
                'rata2_nilai_b_hasil_seminar_proposal' => round($rata2_nilaib_seminar, 0),
                'rata2_nilai_c_hasil_seminar_proposal' => round($rata2_nilaic_seminar, 0),
                'jumlah_rata2_nilai_hasil_seminar_proposal' => round($rata2_nilaia_seminar + $rata2_nilaib_seminar + $rata2_nilaic_seminar, 0),
                'nilai_akhir_hasil_seminar_proposal' => round($nilai_akhir_seminar, 0),
            ],
            'nilai_akhir' => round($nilai_akhir, 0),
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Nilai Sidang Skripsi',
            'data' => $data,
        ], 200);
    }
}
