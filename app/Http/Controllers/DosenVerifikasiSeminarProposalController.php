<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\HasilSeminarProposal;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenVerifikasiSeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $id_dosen_penguji = DosenPenguji::where('dosen_id_dosen', $dosen->id)->get('judul_skripsi_id_judul_skripsi');
        $id_dosen_pembimbing = DosenPembimbing::where('dosen_id_dosen', $dosen->id)->get('judul_skripsi_id_judul_skripsi');
        $id_judul_skripsi = JudulSkripsi::whereIn('id', $id_dosen_pembimbing)->orWhereIn('id', $id_dosen_penguji)->get('id');

        $seminar_proposal = SeminarProposal::whereIn('judul_skripsi_id_judul_skripsi', $id_judul_skripsi)
            ->orderBy('waktu_seminar_proposal', 'desc')
            ->get('id');
        foreach ($seminar_proposal as $seminar) {
            $data_seminar_proposal = SeminarProposal::findorfail($seminar->id);
            $data_judul_skripsi = JudulSkripsi::findorfail($data_seminar_proposal->judul_skripsi_id_judul_skripsi);
            $data_mahasiswa = Mahasiswa::findorfail($data_judul_skripsi->mahasiswa_id_mahasiswa);

            $seminar->mahasiswa = [
                'id' => $data_mahasiswa->id,
                'npm_mahasiswa' => $data_mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $data_mahasiswa->nama_mahasiswa
            ];
            $seminar->judul_skripsi = [
                'id' => $data_judul_skripsi->id,
                'nama_judul_skripsi' => $data_judul_skripsi->nama_judul_skripsi
            ];

            $cek_pembimbing = DosenPembimbing::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $data_judul_skripsi->id]
            ])->first();
            $cek_penguji = DosenPenguji::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $data_judul_skripsi->id]
            ])->first();

            if (!is_null($cek_pembimbing)) {
                $seminar->jabatan_dosen_seminar_proposal = 'Dosen Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $seminar->jabatan_dosen_seminar_proposal = 'Dosen Penguji ' . $cek_penguji->jabatan_dosen_penguji;
            }

            $seminar->waktu_seminar_proposal = $data_seminar_proposal->waktu_seminar_proposal;
            $seminar->tempat_seminar_proposal = $data_seminar_proposal->tempat_seminar_proposal;
            if ($data_seminar_proposal->waktu_seminar_proposal > Carbon::now() && $data_seminar_proposal->status_seminar_proposal == 'Proses') {
                $seminar->status_seminar_proposal = 'Belum Mulai';
            } elseif ($data_seminar_proposal->waktu_seminar_proposal <= Carbon::now() && $data_seminar_proposal->status_seminar_proposal == 'Proses') {
                $seminar->status_seminar_proposal = 'Sedang Berlangsung';
            } elseif ($data_seminar_proposal->status_seminar_proposal == 'Selesai') {
                $seminar->status_seminar_proposal = 'Selesai';
            }

            $cek_verifikasi = HasilSeminarProposal::where([
                ['dosen_id_dosen', $dosen->id],
                ['seminar_proposal_id_seminar', $data_seminar_proposal->id]
            ])->first();
            if (is_null($cek_verifikasi)) {
                $seminar->status_verifikasi_seminar_proposal = 'Belum Verifikasi';
            } else {
                $seminar->status_verifikasi_seminar_proposal = $cek_verifikasi->status_verifikasi_hasil_seminar_proposal;
            }
        }


        return response()->json([
            'message' => 'List of Data',
            'seminar_proposal' => $seminar_proposal,
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
            $seminar_proposal = SeminarProposal::findorfail($id);
            $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            $cek_pembimbing = DosenPembimbing::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
            ])->first();
            $cek_penguji = DosenPenguji::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
            ])->first();

            if (is_null($cek_pembimbing) && is_null($cek_penguji)) {
                $response = [
                    'message' => 'You do not have access to data with id ' . $seminar_proposal->id,
                ];

                return response()->json($response, 400);
            }

            $cek_verifikasi = HasilSeminarProposal::where([
                ['dosen_id_dosen', $dosen->id],
                ['seminar_proposal_id_seminar', $seminar_proposal->id]
            ])->first();
            if (is_null($cek_verifikasi)) {
                $status_verifikasi_hasil_seminar_proposal = 'Belum Verifikasi';
                $catatan_hasil_seminar_proposal = '-';
            } else {
                $status_verifikasi_hasil_seminar_proposal = $cek_verifikasi->status_verifikasi_hasil_seminar_proposal;
                $catatan_hasil_seminar_proposal = $cek_verifikasi->catatan_hasil_seminar_proposal;
            }

            $data = [
                'id' => $seminar_proposal->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'file_seminar_proposal' => [
                    'nama_file' => $seminar_proposal->file_seminar_proposal,
                    'url' => 'fileSeminar/' . $seminar_proposal->file_seminar_proposal
                ],
                'status_verifikasi_hasil_seminar_proposal' => $status_verifikasi_hasil_seminar_proposal,
                'catatan_hasil_seminar_proposal' => $catatan_hasil_seminar_proposal
            ];

            $response = [
                'message' => 'Data details',
                'seminar_proposal' => $data
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
            'status_verifikasi_hasil_seminar_proposal' => 'required|in:Revisi,Lulus Seminar',
            'catatan_hasil_seminar_proposal' => 'required',
        ]);

        $seminar_proposal = SeminarProposal::findorfail($id);

        if ($seminar_proposal->waktu_seminar_proposal > Carbon::now() && $seminar_proposal->status_seminar_proposal == 'Proses') {
            return response()->json([
                'message' => 'Verification cannot be carried out yet, because the seminar proposal has not yet started'
            ], 400);
        } elseif ($seminar_proposal->waktu_seminar_proposal <= Carbon::now() && $seminar_proposal->status_seminar_proposal == 'Proses') {
            $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            $cek_pembimbing = DosenPembimbing::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
            ])->first();
            $cek_penguji = DosenPenguji::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
            ])->first();

            if (is_null($cek_pembimbing) && is_null($cek_penguji)) {
                $response = [
                    'message' => 'You do not have access to data with id ' . $seminar_proposal->id,
                ];
                return response()->json($response, 400);
            } elseif (!is_null($cek_pembimbing)) {
                $cek_verifikasi = HasilSeminarProposal::where([
                    ['dosen_id_dosen', $dosen->id],
                    ['seminar_proposal_id_seminar', $seminar_proposal->id]
                ])->first();
                if (is_null($cek_verifikasi)) {
                    $verifikasi = new HasilSeminarProposal([
                        'seminar_proposal_id_seminar' => $seminar_proposal->id,
                        'dosen_id_dosen' => $dosen->id,
                        'jenis_dosen_hasil_seminar_proposal' => 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing,
                        'status_verifikasi_hasil_seminar_proposal' => $request->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $request->catatan_hasil_seminar_proposal
                    ]);
                    $verifikasi->save();

                    $data = [
                        'id' => $seminar_proposal->id,
                        'mahasiswa' => [
                            'id' => $mahasiswa->id,
                            'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                            'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                        ],
                        'judul_skripsi' => [
                            'id' => $judul_skripsi->id,
                            'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                        ],
                        'jenis_dosen_hasil_seminar_proposal' => $verifikasi->jenis_dosen_hasil_seminar_proposal,
                        'status_verifikasi_hasil_seminar_proposal' => $verifikasi->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $verifikasi->catatan_hasil_seminar_proposal,
                        'updated_at' => $verifikasi->created_at->diffForHumans()
                    ];
                    return response()->json([
                        'message' => 'verification is successful',
                        'verifikasi_hasil_seminar_proposal' => $data,
                    ], 200);
                } elseif ($cek_verifikasi->status_verifikasi_hasil_seminar_proposal == 'Revisi') {
                    $cek_verifikasi->status_verifikasi_hasil_seminar_proposal = $request->status_verifikasi_hasil_seminar_proposal;
                    $cek_verifikasi->catatan_hasil_seminar_proposal = $request->catatan_hasil_seminar_proposal;
                    $cek_verifikasi->update();
                    $data = [
                        'id' => $seminar_proposal->id,
                        'mahasiswa' => [
                            'id' => $mahasiswa->id,
                            'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                            'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                        ],
                        'judul_skripsi' => [
                            'id' => $judul_skripsi->id,
                            'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                        ],
                        'jenis_dosen_hasil_seminar_proposal' => $cek_verifikasi->jenis_dosen_hasil_seminar_proposal,
                        'status_verifikasi_hasil_seminar_proposal' => $cek_verifikasi->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $cek_verifikasi->catatan_hasil_seminar_proposal,
                        'updated_at' => $cek_verifikasi->created_at->diffForHumans()
                    ];
                    return response()->json([
                        'message' => 'update verification is successful',
                        'verifikasi_hasil_seminar_proposal' => $data,
                    ], 200);
                } elseif ($cek_verifikasi->status_verifikasi_hasil_seminar_proposal == 'Lulus Seminar') {
                    return response()->json([
                        'message' => 'the data has been verified, you can not change the verification status. Please continue with the process input nilai'
                    ], 400);
                }
            } elseif (!is_null($cek_penguji)) {
                $cek_verifikasi = HasilSeminarProposal::where([
                    ['dosen_id_dosen', $dosen->id],
                    ['seminar_proposal_id_seminar', $seminar_proposal->id]
                ])->first();
                if (is_null($cek_verifikasi)) {
                    $verifikasi = new HasilSeminarProposal([
                        'seminar_proposal_id_seminar' => $seminar_proposal->id,
                        'dosen_id_dosen' => $dosen->id,
                        'jenis_dosen_hasil_seminar_proposal' => 'Penguji ' . $cek_penguji->jabatan_dosen_penguji,
                        'status_verifikasi_hasil_seminar_proposal' => $request->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $request->catatan_hasil_seminar_proposal
                    ]);
                    $verifikasi->save();

                    $data = [
                        'id' => $seminar_proposal->id,
                        'mahasiswa' => [
                            'id' => $mahasiswa->id,
                            'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                            'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                        ],
                        'judul_skripsi' => [
                            'id' => $judul_skripsi->id,
                            'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                        ],
                        'jenis_dosen_hasil_seminar_proposal' => $verifikasi->jenis_dosen_hasil_seminar_proposal,
                        'status_verifikasi_hasil_seminar_proposal' => $verifikasi->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $verifikasi->catatan_hasil_seminar_proposal,
                        'updated_at' => $verifikasi->created_at->diffForHumans()
                    ];
                    return response()->json([
                        'message' => 'verification is successful',
                        'verifikasi_hasil_seminar_proposal' => $data,
                    ], 200);
                } elseif ($cek_verifikasi->status_verifikasi_hasil_seminar_proposal == 'Revisi') {
                    $cek_verifikasi->status_verifikasi_hasil_seminar_proposal = $request->status_verifikasi_hasil_seminar_proposal;
                    $cek_verifikasi->catatan_hasil_seminar_proposal = $request->catatan_hasil_seminar_proposal;
                    $cek_verifikasi->update();
                    $data = [
                        'id' => $seminar_proposal->id,
                        'mahasiswa' => [
                            'id' => $mahasiswa->id,
                            'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                            'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                        ],
                        'judul_skripsi' => [
                            'id' => $judul_skripsi->id,
                            'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                        ],
                        'jenis_dosen_hasil_seminar_proposal' => $cek_verifikasi->jenis_dosen_hasil_seminar_proposal,
                        'status_verifikasi_hasil_seminar_proposal' => $cek_verifikasi->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $cek_verifikasi->catatan_hasil_seminar_proposal,
                        'updated_at' => $cek_verifikasi->created_at->diffForHumans()
                    ];
                    return response()->json([
                        'message' => 'update verification is successful',
                        'verifikasi_hasil_seminar_proposal' => $data,
                    ], 200);
                } elseif ($cek_verifikasi->status_verifikasi_hasil_seminar_proposal == 'Lulus Seminar') {
                    return response()->json([
                        'message' => 'the data has been verified, you can not change the verification status. Please continue with the process input nilai'
                    ], 400);
                }
            }
        }
    }

    public function input_nilai(Request $request, $id)
    {
        $seminar_proposal = SeminarProposal::findorfail($id);
        if ($seminar_proposal->waktu_seminar_proposal > Carbon::now() && $seminar_proposal->status_seminar_proposal == 'Proses') {
            return response()->json([
                'message' => 'Input nilai cannot be carried out yet, because the seminar proposal has not yet started'
            ], 400);
        } elseif ($seminar_proposal->waktu_seminar_proposal <= Carbon::now() && $seminar_proposal->status_seminar_proposal == 'Proses') {
            $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
            $cek_pembimbing = DosenPembimbing::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
            ])->first();
            $cek_penguji = DosenPenguji::where([
                ['dosen_id_dosen', $dosen->id],
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
            ])->first();

            if (is_null($cek_pembimbing) && is_null($cek_penguji)) {
                $response = [
                    'message' => 'You do not have access to data with id ' . $seminar_proposal->id,
                ];
                return response()->json($response, 400);
            }

            $cek_verifikasi = HasilSeminarProposal::where([
                ['dosen_id_dosen', $dosen->id],
                ['seminar_proposal_id_seminar', $seminar_proposal->id]
            ])->first();
            if ($cek_verifikasi->status_verifikasi_hasil_seminar_proposal == 'Revisi') {
                $response = [
                    'message' => 'You do not have access to data with id ' . $seminar_proposal->id . ', because the verification status is Revisi. Please re-verify before input nilai'
                ];
                return response()->json($response, 400);
            } elseif (!is_null($cek_pembimbing)) {
                if ($cek_verifikasi->nilai_a1_hasil_seminar_proposal != null) {
                    $response = [
                        'message' => 'It is detected that you have made an assessment, on the data with an id ' . $seminar_proposal->id
                    ];
                    return response()->json($response, 400);
                }

                $this->validate($request, [
                    'nilai_a1_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_a2_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_a3_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b1_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b2_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b3_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b4_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b5_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b6_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b7_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_c1_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_c2_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_c3_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                ]);
                $cek_verifikasi->nilai_a1_hasil_seminar_proposal = $request->nilai_a1_hasil_seminar_proposal;
                $cek_verifikasi->nilai_a2_hasil_seminar_proposal = $request->nilai_a2_hasil_seminar_proposal;
                $cek_verifikasi->nilai_a3_hasil_seminar_proposal = $request->nilai_a3_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b1_hasil_seminar_proposal = $request->nilai_b1_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b2_hasil_seminar_proposal = $request->nilai_b2_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b3_hasil_seminar_proposal = $request->nilai_b3_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b4_hasil_seminar_proposal = $request->nilai_b4_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b5_hasil_seminar_proposal = $request->nilai_b5_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b6_hasil_seminar_proposal = $request->nilai_b6_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b7_hasil_seminar_proposal = $request->nilai_b7_hasil_seminar_proposal;
                $cek_verifikasi->nilai_c1_hasil_seminar_proposal = $request->nilai_c1_hasil_seminar_proposal;
                $cek_verifikasi->nilai_c2_hasil_seminar_proposal = $request->nilai_c2_hasil_seminar_proposal;
                $cek_verifikasi->nilai_c3_hasil_seminar_proposal = $request->nilai_c3_hasil_seminar_proposal;
                $cek_verifikasi->update();

                $data = [
                    'id' => $seminar_proposal->id,
                    'mahasiswa' => [
                        'id' => $mahasiswa->id,
                        'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                        'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                    ],
                    'judul_skripsi' => [
                        'id' => $judul_skripsi->id,
                        'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                    ],
                    'nilai_a1_hasil_seminar_proposal' => $cek_verifikasi->nilai_a1_hasil_seminar_proposal,
                    'nilai_a2_hasil_seminar_proposal' => $cek_verifikasi->nilai_a2_hasil_seminar_proposal,
                    'nilai_a3_hasil_seminar_proposal' => $cek_verifikasi->nilai_a3_hasil_seminar_proposal,
                    'nilai_b1_hasil_seminar_proposal' => $cek_verifikasi->nilai_b1_hasil_seminar_proposal,
                    'nilai_b2_hasil_seminar_proposal' => $cek_verifikasi->nilai_b2_hasil_seminar_proposal,
                    'nilai_b3_hasil_seminar_proposal' => $cek_verifikasi->nilai_b3_hasil_seminar_proposal,
                    'nilai_b4_hasil_seminar_proposal' => $cek_verifikasi->nilai_b4_hasil_seminar_proposal,
                    'nilai_b5_hasil_seminar_proposal' => $cek_verifikasi->nilai_b5_hasil_seminar_proposal,
                    'nilai_b6_hasil_seminar_proposal' => $cek_verifikasi->nilai_b6_hasil_seminar_proposal,
                    'nilai_b7_hasil_seminar_proposal' => $cek_verifikasi->nilai_b7_hasil_seminar_proposal,
                    'nilai_c1_hasil_seminar_proposal' => $cek_verifikasi->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $cek_verifikasi->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $cek_verifikasi->nilai_c3_hasil_seminar_proposal
                ];

                return response()->json([
                    'message' => 'Input nilai is successful',
                    'nilai_hasil_seminar_proposal' => $data,
                ], 200);
            } elseif (!is_null($cek_penguji)) {
                if ($cek_verifikasi->nilai_b1_hasil_seminar_proposal != null) {
                    $response = [
                        'message' => 'It is detected that you have made an assessment, on the data with an id ' . $seminar_proposal->id
                    ];
                    return response()->json($response, 400);
                }

                $this->validate($request, [
                    'nilai_b1_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b2_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b3_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b4_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b5_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b6_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_b7_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_c1_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_c2_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                    'nilai_c3_hasil_seminar_proposal' => 'required|numeric|between:0,100',
                ]);
                $cek_verifikasi->nilai_b1_hasil_seminar_proposal = $request->nilai_b1_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b2_hasil_seminar_proposal = $request->nilai_b2_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b3_hasil_seminar_proposal = $request->nilai_b3_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b4_hasil_seminar_proposal = $request->nilai_b4_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b5_hasil_seminar_proposal = $request->nilai_b5_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b6_hasil_seminar_proposal = $request->nilai_b6_hasil_seminar_proposal;
                $cek_verifikasi->nilai_b7_hasil_seminar_proposal = $request->nilai_b7_hasil_seminar_proposal;
                $cek_verifikasi->nilai_c1_hasil_seminar_proposal = $request->nilai_c1_hasil_seminar_proposal;
                $cek_verifikasi->nilai_c2_hasil_seminar_proposal = $request->nilai_c2_hasil_seminar_proposal;
                $cek_verifikasi->nilai_c3_hasil_seminar_proposal = $request->nilai_c3_hasil_seminar_proposal;
                $cek_verifikasi->update();

                $data = [
                    'id' => $seminar_proposal->id,
                    'mahasiswa' => [
                        'id' => $mahasiswa->id,
                        'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                        'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                    ],
                    'judul_skripsi' => [
                        'id' => $judul_skripsi->id,
                        'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                    ],
                    'nilai_a1_hasil_seminar_proposal' => $cek_verifikasi->nilai_a1_hasil_seminar_proposal,
                    'nilai_a2_hasil_seminar_proposal' => $cek_verifikasi->nilai_a2_hasil_seminar_proposal,
                    'nilai_a3_hasil_seminar_proposal' => $cek_verifikasi->nilai_a3_hasil_seminar_proposal,
                    'nilai_b1_hasil_seminar_proposal' => $cek_verifikasi->nilai_b1_hasil_seminar_proposal,
                    'nilai_b2_hasil_seminar_proposal' => $cek_verifikasi->nilai_b2_hasil_seminar_proposal,
                    'nilai_b3_hasil_seminar_proposal' => $cek_verifikasi->nilai_b3_hasil_seminar_proposal,
                    'nilai_b4_hasil_seminar_proposal' => $cek_verifikasi->nilai_b4_hasil_seminar_proposal,
                    'nilai_b5_hasil_seminar_proposal' => $cek_verifikasi->nilai_b5_hasil_seminar_proposal,
                    'nilai_b6_hasil_seminar_proposal' => $cek_verifikasi->nilai_b6_hasil_seminar_proposal,
                    'nilai_b7_hasil_seminar_proposal' => $cek_verifikasi->nilai_b7_hasil_seminar_proposal,
                    'nilai_c1_hasil_seminar_proposal' => $cek_verifikasi->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $cek_verifikasi->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $cek_verifikasi->nilai_c3_hasil_seminar_proposal
                ];

                return response()->json([
                    'message' => 'Input nilai is successful',
                    'nilai_hasil_seminar_proposal' => $data,
                ], 200);
            }
        }
    }

    public function lihat_nilai($id)
    {
        $seminar_proposal = SeminarProposal::findorfail($id);
        $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
        $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $cek_pembimbing = DosenPembimbing::where([
            ['dosen_id_dosen', $dosen->id],
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
        ])->first();
        $cek_penguji = DosenPenguji::where([
            ['dosen_id_dosen', $dosen->id],
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
        ])->first();

        if (is_null($cek_pembimbing) && is_null($cek_penguji)) {
            $response = [
                'message' => 'You do not have access to data with id ' . $seminar_proposal->id,
            ];

            return response()->json($response, 400);
        }

        $cek_verifikasi = HasilSeminarProposal::where([
            ['dosen_id_dosen', $dosen->id],
            ['seminar_proposal_id_seminar', $seminar_proposal->id]
        ])->first();

        if (is_null($cek_verifikasi)) {
            $response = [
                'message' => 'Nilai seminar proposal with id ' . $seminar_proposal->id . ' not found, please verify first.',
            ];

            return response()->json($response, 404);
        } else {
            $data = [
                'id' => $seminar_proposal->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'nilai_a1_hasil_seminar_proposal' => $cek_verifikasi->nilai_a1_hasil_seminar_proposal,
                'nilai_a2_hasil_seminar_proposal' => $cek_verifikasi->nilai_a2_hasil_seminar_proposal,
                'nilai_a3_hasil_seminar_proposal' => $cek_verifikasi->nilai_a3_hasil_seminar_proposal,
                'nilai_b1_hasil_seminar_proposal' => $cek_verifikasi->nilai_b1_hasil_seminar_proposal,
                'nilai_b2_hasil_seminar_proposal' => $cek_verifikasi->nilai_b2_hasil_seminar_proposal,
                'nilai_b3_hasil_seminar_proposal' => $cek_verifikasi->nilai_b3_hasil_seminar_proposal,
                'nilai_b4_hasil_seminar_proposal' => $cek_verifikasi->nilai_b4_hasil_seminar_proposal,
                'nilai_b5_hasil_seminar_proposal' => $cek_verifikasi->nilai_b5_hasil_seminar_proposal,
                'nilai_b6_hasil_seminar_proposal' => $cek_verifikasi->nilai_b6_hasil_seminar_proposal,
                'nilai_b7_hasil_seminar_proposal' => $cek_verifikasi->nilai_b7_hasil_seminar_proposal,
                'nilai_c1_hasil_seminar_proposal' => $cek_verifikasi->nilai_c1_hasil_seminar_proposal,
                'nilai_c2_hasil_seminar_proposal' => $cek_verifikasi->nilai_c2_hasil_seminar_proposal,
                'nilai_c3_hasil_seminar_proposal' => $cek_verifikasi->nilai_c3_hasil_seminar_proposal
            ];

            $response = [
                'message' => 'Data information',
                'nilai_hasil_seminar_proposal' => $data
            ];
            return response()->json($response, 200);
        }
    }
}
