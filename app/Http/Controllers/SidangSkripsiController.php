<?php

namespace App\Http\Controllers;

use App\AdminProdi;
use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\HasilSidangSkripsi;
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

    public function hasil_sidang($id)
    {
        $sidang_skripsi = SidangSkripsi::findorfail($id);
        $hasil_sidang = HasilSidangSkripsi::where('sidang_skripsi_id_sidang', $sidang_skripsi->id)->get('id');
        if ($hasil_sidang->count() == 4) {
            foreach ($hasil_sidang as $hasil) {
                $data_hasil_sidang = HasilSidangSkripsi::findorfail($hasil->id);
                $data_dosen = Dosen::findorfail($data_hasil_sidang->dosen_id_dosen);
                $hasil->nama_dosen = [
                    'id' => $data_dosen->id,
                    'nama_dosen' => $data_dosen->nama_dosen . ', ' . $data_dosen->gelar_dosen,
                    'nidn_dosen' => $data_dosen->nidn_dosen
                ];
                $hasil->status_dosen_sidang_skripsi = $data_hasil_sidang->jenis_dosen_hasil_sidang_skripsi;
                $hasil->status_verifikasi_dosen_sidang_skripsi = $data_hasil_sidang->status_verifikasi_hasil_sidang_skripsi;
            }

            return response()->json([
                'message' => 'List of Data',
                'hasil_sidang_skripsi' => $hasil_sidang,
            ], 200);
        }
        $response = [
            'message' => 'Incomplete data, please wait until the verification process is complete',
        ];

        return response()->json($response, 404);
    }

    public function verifikasi_sidang($id)
    {
        $sidang_skripsi = SidangSkripsi::findorfail($id);
        $judul_skripsi = JudulSkripsi::findorfail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
        $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
        $hasil_sidang = HasilSidangSkripsi::where('sidang_skripsi_id_sidang', $sidang_skripsi->id)->get();
        if ($hasil_sidang->count() != 4) {
            $response = [
                'message' => 'Incomplete data, please wait until the verification process is complete',
            ];
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
                'message' => 'Verification of the sidang skripsi with id ' . $sidang_skripsi->id . ' was successful',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'message' => 'Incomplete data, please wait until the verification process is complete',
        ];
        return response()->json($response, 400);
    }

    public function daftar_nilai($id)
    {
        $sidang_skripsi = SidangSkripsi::findorfail($id);
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
                    'deskripsi_nilai_a_hasil_sidang_skripsi' => 'Nilai Pembimbingan Proposal',
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
                    'deskripsi_nilai_a_hasil_sidang_skripsi' => 'Nilai Pembimbingan Proposal',
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
