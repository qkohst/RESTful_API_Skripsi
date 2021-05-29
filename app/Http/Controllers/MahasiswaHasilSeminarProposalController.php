<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\HasilSeminarProposal;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaHasilSeminarProposalController extends Controller
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
        $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($seminar_proposal)) {
            $response = [
                'message' => 'Seminar Proposal Not Found, please upload data',
            ];
            return response()->json($response, 404);
        }

        $hasil_seminar_proposal = HasilSeminarProposal::where('seminar_proposal_id_seminar', $seminar_proposal->id)
            ->get('id');
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
        }

        return response()->json([
            'message' => 'List of Data',
            'verifikasi_hasil_seminar_proposal' => $hasil_seminar_proposal,
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
            'message' => 'Data details',
            'verifikasi_hasil_seminar_proposal' => $data
        ];
        return response()->json($response, 200);
    }

    public function daftar_nilai()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();

        $nilai_pembimbing1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 1']
        ])->first();
        $dosen_pembimbing1 = Dosen::findOrFail($nilai_pembimbing1->dosen_id_dosen);

        $nilai_pembimbing2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 2']
        ])->first();
        $dosen_pembimbing2 = Dosen::findOrFail($nilai_pembimbing2->dosen_id_dosen);

        $nilai_penguji1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 1']
        ])->first();
        $dosen_penguji1 = Dosen::findOrFail($nilai_penguji1->dosen_id_dosen);

        $nilai_penguji2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 2']
        ])->first();
        $dosen_penguji2 = Dosen::findOrFail($nilai_penguji2->dosen_id_dosen);

        if (is_null($nilai_pembimbing1) || is_null($nilai_pembimbing2) || is_null($nilai_penguji1) || is_null($nilai_penguji2)) {
            $response = [
                'message' => 'the verification process by the dosen pembimbing and penguji has not been completed',
            ];
            return response()->json($response, 404);
        } elseif ($nilai_pembimbing1->status_verifikasi_hasil_seminar_proposal == 'Revisi' || $nilai_pembimbing2->status_verifikasi_hasil_seminar_proposal == 'Revisi' || $nilai_penguji1->status_verifikasi_hasil_seminar_proposal == 'Revisi' || $nilai_penguji2->status_verifikasi_hasil_seminar_proposal == 'Revisi') {
            $response = [
                'message' => 'Incomplete data, please wait for the input process to complete',
            ];
            return response()->json($response, 404);
        }

        $data = [
            'id' => $seminar_proposal->id,
            'nilai_pembimbing1' => [
                'dosen' => [
                    'nama_dosen' => $dosen_pembimbing1->nama_dosen . ', ' . $dosen_pembimbing1->gelar_dosen,
                    'nidn_dosen' => $dosen_pembimbing1->nidn_dosen
                ],
                'nilai_a' => [
                    'deskripsi_nilai_a_hasil_seminar_proposal' => 'Nilai Pembimbingan Proposal',
                    'nilai_a1_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_a1_hasil_seminar_proposal,
                    'nilai_a2_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_a2_hasil_seminar_proposal,
                    'nilai_a3_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_a3_hasil_seminar_proposal,
                ],
                'nilai_b' => [
                    'deskripsi_nilai_b_hasil_seminar_proposal' => 'Nilai Naskah Proposal Skripsi',
                    'nilai_b1_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_b1_hasil_seminar_proposal,
                    'nilai_b2_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_b2_hasil_seminar_proposal,
                    'nilai_b3_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_b3_hasil_seminar_proposal,
                    'nilai_b4_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_b4_hasil_seminar_proposal,
                    'nilai_b5_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_b5_hasil_seminar_proposal,
                    'nilai_b6_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_b6_hasil_seminar_proposal,
                    'nilai_b7_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_b7_hasil_seminar_proposal,
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_seminar_proposal' => 'Nilai Pelaksanaan Seminar Proposal',
                    'nilai_c1_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_c3_hasil_seminar_proposal,
                ]
            ],
            'nilai_pembimbing2' => [
                'dosen' => [
                    'nama_dosen' => $dosen_pembimbing2->nama_dosen . ', ' . $dosen_pembimbing2->gelar_dosen,
                    'nidn_dosen' => $dosen_pembimbing2->nidn_dosen
                ],
                'nilai_a' => [
                    'deskripsi_nilai_a_hasil_seminar_proposal' => 'Nilai Pembimbingan Proposal',
                    'nilai_a1_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_a1_hasil_seminar_proposal,
                    'nilai_a2_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_a2_hasil_seminar_proposal,
                    'nilai_a3_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_a3_hasil_seminar_proposal,
                ],
                'nilai_b' => [
                    'deskripsi_nilai_b_hasil_seminar_proposal' => 'Nilai Naskah Proposal Skripsi',
                    'nilai_b1_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_b1_hasil_seminar_proposal,
                    'nilai_b2_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_b2_hasil_seminar_proposal,
                    'nilai_b3_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_b3_hasil_seminar_proposal,
                    'nilai_b4_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_b4_hasil_seminar_proposal,
                    'nilai_b5_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_b5_hasil_seminar_proposal,
                    'nilai_b6_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_b6_hasil_seminar_proposal,
                    'nilai_b7_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_b7_hasil_seminar_proposal,
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_seminar_proposal' => 'Nilai Pelaksanaan Seminar Proposal',
                    'nilai_c1_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_c3_hasil_seminar_proposal,
                ]
            ],
            'nilai_penguji1' => [
                'dosen' => [
                    'nama_dosen' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                    'nidn_dosen' => $dosen_penguji1->nidn_dosen
                ],
                'nilai_b' => [
                    'deskripsi_nilai_b_hasil_seminar_proposal' => 'Nilai Naskah Proposal Skripsi',
                    'nilai_b1_hasil_seminar_proposal' => $nilai_penguji1->nilai_b1_hasil_seminar_proposal,
                    'nilai_b2_hasil_seminar_proposal' => $nilai_penguji1->nilai_b2_hasil_seminar_proposal,
                    'nilai_b3_hasil_seminar_proposal' => $nilai_penguji1->nilai_b3_hasil_seminar_proposal,
                    'nilai_b4_hasil_seminar_proposal' => $nilai_penguji1->nilai_b4_hasil_seminar_proposal,
                    'nilai_b5_hasil_seminar_proposal' => $nilai_penguji1->nilai_b5_hasil_seminar_proposal,
                    'nilai_b6_hasil_seminar_proposal' => $nilai_penguji1->nilai_b6_hasil_seminar_proposal,
                    'nilai_b7_hasil_seminar_proposal' => $nilai_penguji1->nilai_b7_hasil_seminar_proposal,
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_seminar_proposal' => 'Nilai Pelaksanaan Seminar Proposal',
                    'nilai_c1_hasil_seminar_proposal' => $nilai_penguji1->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $nilai_penguji1->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $nilai_penguji1->nilai_c3_hasil_seminar_proposal,
                ]
            ],
            'nilai_penguji2' => [
                'dosen' => [
                    'nama_dosen' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen,
                    'nidn_dosen' => $dosen_penguji2->nidn_dosen
                ],
                'nilai_b' => [
                    'deskripsi_nilai_b_hasil_seminar_proposal' => 'Nilai Naskah Proposal Skripsi',
                    'nilai_b1_hasil_seminar_proposal' => $nilai_penguji2->nilai_b1_hasil_seminar_proposal,
                    'nilai_b2_hasil_seminar_proposal' => $nilai_penguji2->nilai_b2_hasil_seminar_proposal,
                    'nilai_b3_hasil_seminar_proposal' => $nilai_penguji2->nilai_b3_hasil_seminar_proposal,
                    'nilai_b4_hasil_seminar_proposal' => $nilai_penguji2->nilai_b4_hasil_seminar_proposal,
                    'nilai_b5_hasil_seminar_proposal' => $nilai_penguji2->nilai_b5_hasil_seminar_proposal,
                    'nilai_b6_hasil_seminar_proposal' => $nilai_penguji2->nilai_b6_hasil_seminar_proposal,
                    'nilai_b7_hasil_seminar_proposal' => $nilai_penguji2->nilai_b7_hasil_seminar_proposal,
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_seminar_proposal' => 'Nilai Pelaksanaan Seminar Proposal',
                    'nilai_c1_hasil_seminar_proposal' => $nilai_penguji2->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $nilai_penguji2->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $nilai_penguji2->nilai_c3_hasil_seminar_proposal,
                ]
            ]
        ];

        return response()->json([
            'message' => 'List of Data',
            'rekap_nilai_hasil_seminar_proposal' => $data,
        ], 200);
    }
}
