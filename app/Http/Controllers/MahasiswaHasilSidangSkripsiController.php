<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\HasilSidangSkripsi;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SidangSkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaHasilSidangSkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        if (is_null($judul_skripsi)) {
            $response = [
                'message' => 'Judul Skripsi Not Found, please upload data',
            ];
            return response()->json($response, 404);
        }

        $sidang_skripsi = SidangSkripsi::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($sidang_skripsi)) {
            $response = [
                'message' => 'Sidang Skripsi Not Found, please upload data',
            ];
            return response()->json($response, 404);
        }

        $hasil_sidang_skripsi = HasilSidangSkripsi::where('sidang_skripsi_id_sidang', $sidang_skripsi->id)
            ->get('id');

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
        }

        return response()->json([
            'message' => 'List of Data',
            'verifikasi_hasil_sidang_skripsi' => $hasil_sidang_skripsi,
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
            'message' => 'Data details',
            'verifikasi_hasil_sidang_skripsi' => $data
        ];
        return response()->json($response, 200);
    }

    public function daftar_nilai()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        $sidang_skripsi = SidangSkripsi::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();

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
                'message' => 'the verification process by the dosen pembimbing and penguji has not been completed',
            ];
            return response()->json($response, 404);
        } elseif ($nilai_pembimbing1->status_verifikasi_hasil_sidang_skripsi == 'Revisi' || $nilai_pembimbing2->status_verifikasi_hasil_sidang_skripsi == 'Revisi' || $nilai_penguji1->status_verifikasi_hasil_sidang_skripsi == 'Revisi' || $nilai_penguji2->status_verifikasi_hasil_sidang_skripsi == 'Revisi') {
            $response = [
                'message' => 'Incomplete data, please wait for the input process to complete',
            ];
            return response()->json($response, 404);
        }
        $dosen_pembimbing1 = Dosen::findOrFail($nilai_pembimbing1->dosen_id_dosen);
        $dosen_pembimbing2 = Dosen::findOrFail($nilai_pembimbing2->dosen_id_dosen);
        $dosen_penguji1 = Dosen::findOrFail($nilai_penguji1->dosen_id_dosen);
        $dosen_penguji2 = Dosen::findOrFail($nilai_penguji2->dosen_id_dosen);

        $data = [
            'id' => $sidang_skripsi->id,
            'nilai_pembimbing1' => [
                'dosen' => [
                    'nama_dosen' => $dosen_pembimbing1->nama_dosen . ', ' . $dosen_pembimbing1->gelar_dosen,
                    'nidn_dosen' => $dosen_pembimbing1->nidn_dosen
                ],
                'nilai_a' => [
                    'deskripsi_nilai_a_hasil_sidang_skripsi' => 'Nilai Pembimbingan Skripsi',
                    'nilai_a1_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_a1_hasil_sidang_skripsi,
                    'nilai_a2_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_a2_hasil_sidang_skripsi,
                    'nilai_a3_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_a3_hasil_sidang_skripsi,
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
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_sidang_skripsi' => 'Nilai Pelaksanaan Sidang Skripsi',
                    'nilai_c1_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $nilai_pembimbing1->nilai_c3_hasil_sidang_skripsi,
                ]
            ],
            'nilai_pembimbing2' => [
                'dosen' => [
                    'nama_dosen' => $dosen_pembimbing2->nama_dosen . ', ' . $dosen_pembimbing2->gelar_dosen,
                    'nidn_dosen' => $dosen_pembimbing2->nidn_dosen
                ],
                'nilai_a' => [
                    'deskripsi_nilai_a_hasil_sidang_skripsi' => 'Nilai Pembimbingan Skripsi',
                    'nilai_a1_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_a1_hasil_sidang_skripsi,
                    'nilai_a2_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_a2_hasil_sidang_skripsi,
                    'nilai_a3_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_a3_hasil_sidang_skripsi,
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
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_sidang_skripsi' => 'Nilai Pelaksanaan Sidang Skripsi',
                    'nilai_c1_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $nilai_pembimbing2->nilai_c3_hasil_sidang_skripsi,
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
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_sidang_skripsi' => 'Nilai Pelaksanaan Sidang Skripsi',
                    'nilai_c1_hasil_sidang_skripsi' => $nilai_penguji1->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $nilai_penguji1->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $nilai_penguji1->nilai_c3_hasil_sidang_skripsi,
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
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_sidang_skripsi' => 'Nilai Pelaksanaan Sidang Skripsi',
                    'nilai_c1_hasil_sidang_skripsi' => $nilai_penguji2->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $nilai_penguji2->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $nilai_penguji2->nilai_c3_hasil_sidang_skripsi,
                ]
            ]
        ];

        return response()->json([
            'message' => 'List of Data',
            'rekap_nilai_hasil_sidang_skripsi' => $data,
        ], 200);
    }
}
