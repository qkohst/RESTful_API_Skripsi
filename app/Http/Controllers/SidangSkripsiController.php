<?php

namespace App\Http\Controllers;

use App\AdminProdi;
use Illuminate\Support\Carbon;
use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\HasilSeminarProposal;
use App\HasilSidangSkripsi;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\ProgramStudi;
use App\SeminarProposal;
use App\SidangSkripsi;
use App\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class SidangSkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

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
            $sidang->file_sidang_skripsi = [
                'nama_file' => $data_sidang_skripsi->file_sidang_skripsi,
                'url' => 'fileSidang/' . $data_sidang_skripsi->file_sidang_skripsi,
            ];

            if (is_null($data_sidang_skripsi->waktu_sidang_skripsi)) {
                $sidang->status_sidang_skripsi = 'Pengajuan';
            } elseif ($data_sidang_skripsi->waktu_sidang_skripsi > Carbon::now() && $data_sidang_skripsi->status_sidang_skripsi == 'Proses') {
                $sidang->status_sidang_skripsi = 'Belum Mulai';
            } elseif ($data_sidang_skripsi->waktu_sidang_skripsi <= Carbon::now() && $data_sidang_skripsi->status_sidang_skripsi == 'Proses') {
                $sidang->status_sidang_skripsi = 'Sedang Berlangsung';
            } elseif ($data_sidang_skripsi->status_sidang_skripsi == 'Selesai') {
                $sidang->status_sidang_skripsi = 'Selesai';
            }

            if (is_null($data_sidang_skripsi->waktu_sidang_skripsi)) {
                $sidang->waktu_sidang_skripsi = 'Belum Ditentukan';
            } else {
                $sidang->waktu_sidang_skripsi = $data_sidang_skripsi->waktu_sidang_skripsi;
            }
            $sidang->tanggal_pengajuan_sidang_skripsi = $data_sidang_skripsi->created_at->format('Y-m-d H:i:s');
        }
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Sidang Skripsi',
            'data' => $sidang_skripsi,
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
        } catch (\Throwable $th) {
            $response = [
                'status'  => 'error',
                'message' => 'Data not found',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

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
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'waktu_sidang_skripsi' => 'required|after:today',
            'tempat_sidang_skripsi' => 'required|min:3'
        ]);
        if ($validator->fails()) {
            $response = [
                'status'  => 'error',
                'message' => $validator->messages()->all()[0]
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 422);
        }

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
                'status'  => 'success',
                'message' => 'The time has been determined successfully',
                'data' => $data
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json($response, 200);
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'The time is set, you cannot change data.',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 400);
        }
    }

    public function hasil_sidang(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $sidang_skripsi = SidangSkripsi::findorfail($id);
        $hasil_sidang = HasilSidangSkripsi::where('sidang_skripsi_id_sidang', $sidang_skripsi->id)->get('id');
        if ($hasil_sidang->count() == 4) {
            foreach ($hasil_sidang as $hasil) {
                $data_hasil_sidang = HasilSidangSkripsi::findorfail($hasil->id);
                $data_dosen = Dosen::findorfail($data_hasil_sidang->dosen_id_dosen);
                $hasil->nama_dosen_sidang_skripsi = $data_dosen->nama_dosen . ', ' . $data_dosen->gelar_dosen;
                $hasil->status_dosen_sidang_skripsi = $data_hasil_sidang->jenis_dosen_hasil_sidang_skripsi;
                $hasil->status_verifikasi_dosen_sidang_skripsi = $data_hasil_sidang->status_verifikasi_hasil_sidang_skripsi;
            }
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Details Data Hasil Sidang',
                'data' => $hasil_sidang,
            ], 200);
        }
        $response = [
            'status'  => 'error',
            'message' => 'Incomplete data, please wait until the verification process is complete',
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();

        return response()->json($response, 404);
    }

    public function verifikasi_sidang(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $sidang_skripsi = SidangSkripsi::findorfail($id);
        if ($sidang_skripsi->status_sidang_skripsi == 'Selesai') {
            $response = [
                'status'  => 'error',
                'message' => 'Sidang Skripsi has been verified',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }

        $judul_skripsi = JudulSkripsi::findorfail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
        $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
        $hasil_sidang = HasilSidangSkripsi::where('sidang_skripsi_id_sidang', $sidang_skripsi->id)->get();
        if ($hasil_sidang->count() != 4) {
            $response = [
                'status'  => 'error',
                'message' => 'Incomplete data, please wait until the process verification pembimbing & penguji',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }
        $cek_hasil_pembimbing1 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Pembimbing 1']
        ])->first();
        $cek_hasil_pembimbing2 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Pembimbing 2']
        ])->first();
        $cek_hasil_penguji1 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Penguji 1']
        ])->first();
        $cek_hasil_penguji2 = HasilSidangSkripsi::where([
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id],
            ['jenis_dosen_hasil_sidang_skripsi', 'Penguji 2']
        ])->first();

        if ($cek_hasil_pembimbing1->status_verifikasi_hasil_sidang_skripsi == 'Lulus Sidang' && $cek_hasil_pembimbing2->status_verifikasi_hasil_sidang_skripsi == 'Lulus Sidang' && $cek_hasil_penguji1->status_verifikasi_hasil_sidang_skripsi == 'Lulus Sidang' && $cek_hasil_penguji2->status_verifikasi_hasil_sidang_skripsi == 'Lulus Sidang') {
            $sidang_skripsi->status_sidang_skripsi = 'Selesai';
            $sidang_skripsi->update();
            $mahasiswa->status_mahasiswa = 'Lulus';
            $mahasiswa->update();
            $response = [
                'status'  => 'success',
                'message' => 'Verification of the sidang skripsi with id ' . $sidang_skripsi->id . ' was successful',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();
            return response()->json($response, 200);
        }
        $response = [
            'status'  => 'error',
            'message' => 'Incomplete data, please wait until the verification process is complete',
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();
        return response()->json($response, 400);
    }

    public function daftar_nilai(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $sidang_skripsi = SidangSkripsi::findorfail($id);
        $judul_skripsi = JudulSkripsi::findorfail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
        $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
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
                'message' => 'the verification process by the dosen pembimbing and penguji has not been completed',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
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
            'nilai_pembimbing1' => [
                'dosen' => [
                    'nama_dosen' => $dosen_pembimbing1->nama_dosen . ', ' . $dosen_pembimbing1->gelar_dosen,
                    'nidn_dosen' => $dosen_pembimbing1->nidn_dosen
                ],
                'nilai_a' => [
                    'deskripsi_nilai_a_hasil_sidang_skripsi' => 'Nilai Pembimbingan Proposal',
                    'nilai_a1_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_a1_hasil_sidang_skripsi,
                    'nilai_a2_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_a2_hasil_sidang_skripsi,
                    'nilai_a3_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_a3_hasil_sidang_skripsi,
                    'jumlah_nilai_a_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_a1_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_a2_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_a3_hasil_sidang_skripsi,
                    'rata2_nilai_a_hasil_sidang_skripsi' => round($rata2_nilaia_pembimbing1, 0),
                ],
                'nilai_b' => [
                    'deskripsi_nilai_b_hasil_sidang_skripsi' => 'Nilai Naskah Skripsi',
                    'nilai_b1_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_b1_hasil_sidang_skripsi,
                    'nilai_b2_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_b2_hasil_sidang_skripsi,
                    'nilai_b3_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_b3_hasil_sidang_skripsi,
                    'nilai_b4_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_b4_hasil_sidang_skripsi,
                    'nilai_b5_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_b5_hasil_sidang_skripsi,
                    'nilai_b6_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_b6_hasil_sidang_skripsi,
                    'nilai_b7_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_b7_hasil_sidang_skripsi,
                    'jumlah_nilai_b_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_b1_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_b2_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_b3_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_b4_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_b5_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_b6_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_b7_hasil_sidang_skripsi,
                    'rata2_nilai_b_hasil_sidang_skripsi' => round($rata2_nilaib_pembimbing1, 0),
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_sidang_skripsi' => 'Nilai Pelaksanaan Sidang Skripsi',
                    'nilai_c1_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_c3_hasil_sidang_skripsi,
                    'jumlah_nilai_c_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_c1_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_c2_hasil_sidang_skripsi + $nilai_pembimbing1->nilai_c3_hasil_sidang_skripsi,
                    'rata2_nilai_c_hasil_sidang_skripsi' => round($rata2_nilaic_pembimbing2, 0),
                ]
            ],
            'nilai_pembimbing2' => [
                'dosen' => [
                    'nama_dosen' => $dosen_pembimbing2->nama_dosen . ', ' . $dosen_pembimbing2->gelar_dosen,
                    'nidn_dosen' => $dosen_pembimbing2->nidn_dosen
                ],
                'nilai_a' => [
                    'deskripsi_nilai_a_hasil_sidang_skripsi' => 'Nilai Pembimbingan Proposal',
                    'nilai_a1_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_a1_hasil_sidang_skripsi,
                    'nilai_a2_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_a2_hasil_sidang_skripsi,
                    'nilai_a3_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_a3_hasil_sidang_skripsi,
                    'jumlah_nilai_a_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_a1_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_a2_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_a3_hasil_sidang_skripsi,
                    'rata2_nilai_a_hasil_sidang_skripsi' => round($rata2_nilaia_pembimbing2, 0),
                ],
                'nilai_b' => [
                    'deskripsi_nilai_b_hasil_sidang_skripsi' => 'Nilai Naskah Skripsi',
                    'nilai_b1_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_b1_hasil_sidang_skripsi,
                    'nilai_b2_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_b2_hasil_sidang_skripsi,
                    'nilai_b3_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_b3_hasil_sidang_skripsi,
                    'nilai_b4_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_b4_hasil_sidang_skripsi,
                    'nilai_b5_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_b5_hasil_sidang_skripsi,
                    'nilai_b6_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_b6_hasil_sidang_skripsi,
                    'nilai_b7_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_b7_hasil_sidang_skripsi,
                    'jumlah_nilai_b_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_b1_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_b2_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_b3_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_b4_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_b5_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_b6_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_b7_hasil_sidang_skripsi,
                    'rata2_nilai_b_hasil_sidang_skripsi' => round($rata2_nilaib_pembimbing2, 0),
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_sidang_skripsi' => 'Nilai Pelaksanaan Sidang Skripsi',
                    'nilai_c1_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_c3_hasil_sidang_skripsi,
                    'jumlah_nilai_c_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_c1_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_c2_hasil_sidang_skripsi + $nilai_pembimbing2->nilai_c3_hasil_sidang_skripsi,
                    'rata2_nilai_c_hasil_sidang_skripsi' => round($rata2_nilaic_pembimbing2, 0),
                ]
            ],
            'nilai_penguji1' => [
                'dosen' => [
                    'nama_dosen' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                    'nidn_dosen' => $dosen_penguji1->nidn_dosen
                ],
                'nilai_b' => [
                    'deskripsi_nilai_b_hasil_sidang_skripsi' => 'Nilai Naskah Skripsi',
                    'nilai_b1_hasil_sidang_skripsi' => $nilai_penguji1->nilai_b1_hasil_sidang_skripsi,
                    'nilai_b2_hasil_sidang_skripsi' => $nilai_penguji1->nilai_b2_hasil_sidang_skripsi,
                    'nilai_b3_hasil_sidang_skripsi' => $nilai_penguji1->nilai_b3_hasil_sidang_skripsi,
                    'nilai_b4_hasil_sidang_skripsi' => $nilai_penguji1->nilai_b4_hasil_sidang_skripsi,
                    'nilai_b5_hasil_sidang_skripsi' => $nilai_penguji1->nilai_b5_hasil_sidang_skripsi,
                    'nilai_b6_hasil_sidang_skripsi' => $nilai_penguji1->nilai_b6_hasil_sidang_skripsi,
                    'nilai_b7_hasil_sidang_skripsi' => $nilai_penguji1->nilai_b7_hasil_sidang_skripsi,
                    'jumlah_nilai_b_hasil_sidang_skripsi' => $nilai_penguji1->nilai_b1_hasil_sidang_skripsi + $nilai_penguji1->nilai_b2_hasil_sidang_skripsi + $nilai_penguji1->nilai_b3_hasil_sidang_skripsi + $nilai_penguji1->nilai_b4_hasil_sidang_skripsi + $nilai_penguji1->nilai_b5_hasil_sidang_skripsi + $nilai_penguji1->nilai_b6_hasil_sidang_skripsi + $nilai_penguji1->nilai_b7_hasil_sidang_skripsi,
                    'rata2_nilai_b_hasil_sidang_skripsi' => round($rata2_nilaib_penguji1, 0),
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_sidang_skripsi' => 'Nilai Pelaksanaan Sidang Skripsi',
                    'nilai_c1_hasil_sidang_skripsi' => $nilai_penguji1->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $nilai_penguji1->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $nilai_penguji1->nilai_c3_hasil_sidang_skripsi,
                    'jumlah_nilai_c_hasil_sidang_skripsi' => $nilai_penguji1->nilai_c1_hasil_sidang_skripsi + $nilai_penguji1->nilai_c2_hasil_sidang_skripsi + $nilai_penguji1->nilai_c3_hasil_sidang_skripsi,
                    'rata2_nilai_c_hasil_sidang_skripsi' => round($rata2_nilaic_penguji1, 0),
                ]
            ],
            'nilai_penguji2' => [
                'dosen' => [
                    'nama_dosen' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen,
                    'nidn_dosen' => $dosen_penguji2->nidn_dosen
                ],
                'nilai_b' => [
                    'deskripsi_nilai_b_hasil_sidang_skripsi' => 'Nilai Naskah Skripsi',
                    'nilai_b1_hasil_sidang_skripsi' => $nilai_penguji2->nilai_b1_hasil_sidang_skripsi,
                    'nilai_b2_hasil_sidang_skripsi' => $nilai_penguji2->nilai_b2_hasil_sidang_skripsi,
                    'nilai_b3_hasil_sidang_skripsi' => $nilai_penguji2->nilai_b3_hasil_sidang_skripsi,
                    'nilai_b4_hasil_sidang_skripsi' => $nilai_penguji2->nilai_b4_hasil_sidang_skripsi,
                    'nilai_b5_hasil_sidang_skripsi' => $nilai_penguji2->nilai_b5_hasil_sidang_skripsi,
                    'nilai_b6_hasil_sidang_skripsi' => $nilai_penguji2->nilai_b6_hasil_sidang_skripsi,
                    'nilai_b7_hasil_sidang_skripsi' => $nilai_penguji2->nilai_b7_hasil_sidang_skripsi,
                    'jumlah_nilai_b_hasil_sidang_skripsi' => $nilai_penguji2->nilai_b1_hasil_sidang_skripsi + $nilai_penguji2->nilai_b2_hasil_sidang_skripsi + $nilai_penguji2->nilai_b3_hasil_sidang_skripsi + $nilai_penguji2->nilai_b4_hasil_sidang_skripsi + $nilai_penguji2->nilai_b5_hasil_sidang_skripsi + $nilai_penguji2->nilai_b6_hasil_sidang_skripsi + $nilai_penguji2->nilai_b7_hasil_sidang_skripsi,
                    'rata2_nilai_b_hasil_sidang_skripsi' => round($rata2_nilaib_penguji2, 0),
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_sidang_skripsi' => 'Nilai Pelaksanaan Sidang Skripsi',
                    'nilai_c1_hasil_sidang_skripsi' => $nilai_penguji2->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $nilai_penguji2->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $nilai_penguji2->nilai_c3_hasil_sidang_skripsi,
                    'jumlah_nilai_c_hasil_sidang_skripsi' => $nilai_penguji2->nilai_c1_hasil_sidang_skripsi + $nilai_penguji2->nilai_c2_hasil_sidang_skripsi + $nilai_penguji2->nilai_c3_hasil_sidang_skripsi,
                    'rata2_nilai_c_hasil_sidang_skripsi' => round($rata2_nilaic_penguji2, 0),
                ]
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
