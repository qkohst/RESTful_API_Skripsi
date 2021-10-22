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
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class DosenVerifikasiSeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $dosen = Dosen::where('user_id_user', Auth::user()->id)->first();
        $id_dosen_penguji = DosenPenguji::where('dosen_id_dosen', $dosen->id)->get('judul_skripsi_id_judul_skripsi');
        $id_dosen_pembimbing = DosenPembimbing::where('dosen_id_dosen', $dosen->id)->get('judul_skripsi_id_judul_skripsi');
        $id_judul_skripsi = JudulSkripsi::whereIn('id', $id_dosen_pembimbing)->orWhereIn('id', $id_dosen_penguji)->get('id');

        $seminar_proposal = SeminarProposal::whereIn('judul_skripsi_id_judul_skripsi', $id_judul_skripsi)
            ->where('status_seminar_proposal', '!=', 'Pengajuan')
            ->orderBy('status_seminar_proposal', 'asc')
            ->orderBy('waktu_seminar_proposal', 'asc')
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
            $seminar->file_seminar_proposal = [
                'nama_file' => $data_seminar_proposal->file_seminar_proposal,
                'url' => 'fileSeminar/' . $data_seminar_proposal->file_seminar_proposal
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
                $seminar->jabatan_dosen_seminar_proposal = 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $seminar->jabatan_dosen_seminar_proposal = 'Penguji ' . $cek_penguji->jabatan_dosen_penguji;
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
                    'status'  => 'error',
                    'message' => 'You do not have access to data with id ' . $seminar_proposal->id,
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

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

            $jabatan_dosen_seminar_proposal = null;
            if (!is_null($cek_pembimbing)) {
                $jabatan_dosen_seminar_proposal = 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $jabatan_dosen_seminar_proposal = 'Penguji ' . $cek_penguji->jabatan_dosen_penguji;
            }
            $jabatan_dosen_seminar_proposal;

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
                'jabatan_dosen_seminar_proposal' => $jabatan_dosen_seminar_proposal,
                'status_verifikasi_hasil_seminar_proposal' => $status_verifikasi_hasil_seminar_proposal,
                'catatan_hasil_seminar_proposal' => $catatan_hasil_seminar_proposal
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Seminar Proposal',
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
            'status_verifikasi_hasil_seminar_proposal' => 'required|in:Revisi,Lulus Seminar',
            'catatan_hasil_seminar_proposal' => 'required',
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

        $seminar_proposal = SeminarProposal::findorfail($id);

        if ($seminar_proposal->waktu_seminar_proposal > Carbon::now() && $seminar_proposal->status_seminar_proposal == 'Proses') {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json([
                'status'  => 'error',
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
                    'status'  => 'error',
                    'message' => 'You do not have access to data with id ' . $seminar_proposal->id,
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();
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
                        'jabatan_dosen_seminar_proposal' => $verifikasi->jenis_dosen_hasil_seminar_proposal,
                        'status_verifikasi_hasil_seminar_proposal' => $verifikasi->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $verifikasi->catatan_hasil_seminar_proposal,
                        'updated_at' => $verifikasi->created_at->diffForHumans()
                    ];
                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '1',
                    ]);
                    $traffic->save();

                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Verification is successful',
                        'data' => $data,
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
                        'jabatan_dosen_seminar_proposal' => $cek_verifikasi->jenis_dosen_hasil_seminar_proposal,
                        'status_verifikasi_hasil_seminar_proposal' => $cek_verifikasi->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $cek_verifikasi->catatan_hasil_seminar_proposal,
                        'updated_at' => $cek_verifikasi->created_at->diffForHumans()
                    ];
                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '1',
                    ]);
                    $traffic->save();

                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Update verification is successful',
                        'data' => $data,
                    ], 200);
                } elseif ($cek_verifikasi->status_verifikasi_hasil_seminar_proposal == 'Lulus Seminar') {
                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '0',
                    ]);
                    $traffic->save();
                    return response()->json([
                        'status'  => 'error',
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
                        'jabatan_dosen_seminar_proposal' => $verifikasi->jenis_dosen_hasil_seminar_proposal,
                        'status_verifikasi_hasil_seminar_proposal' => $verifikasi->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $verifikasi->catatan_hasil_seminar_proposal,
                        'updated_at' => $verifikasi->created_at->diffForHumans()
                    ];
                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '1',
                    ]);
                    $traffic->save();

                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Verification is successful',
                        'data' => $data,
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
                        'jabatan_dosen_seminar_proposal' => $cek_verifikasi->jenis_dosen_hasil_seminar_proposal,
                        'status_verifikasi_hasil_seminar_proposal' => $cek_verifikasi->status_verifikasi_hasil_seminar_proposal,
                        'catatan_hasil_seminar_proposal' => $cek_verifikasi->catatan_hasil_seminar_proposal,
                        'updated_at' => $cek_verifikasi->created_at->diffForHumans()
                    ];
                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '1',
                    ]);
                    $traffic->save();

                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Update verification is successful',
                        'data' => $data,
                    ], 200);
                } elseif ($cek_verifikasi->status_verifikasi_hasil_seminar_proposal == 'Lulus Seminar') {
                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '0',
                    ]);
                    $traffic->save();
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'the data has been verified, you can not change the verification status. Please continue with the process input nilai'
                    ], 400);
                }
            }
        } elseif ($seminar_proposal->status_seminar_proposal == 'Selesai') {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json([
                'status'  => 'error',
                'message' => 'Seminar Proposal Has Completed'
            ], 400);
        }
    }

    public function input_nilai(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $seminar_proposal = SeminarProposal::findorfail($id);
        if ($seminar_proposal->waktu_seminar_proposal > Carbon::now() && $seminar_proposal->status_seminar_proposal == 'Proses') {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
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

            $jabatan_dosen_seminar_proposal = null;
            if (!is_null($cek_pembimbing)) {
                $jabatan_dosen_seminar_proposal = 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $jabatan_dosen_seminar_proposal = 'Penguji ' . $cek_penguji->jabatan_dosen_penguji;
            }
            $jabatan_dosen_seminar_proposal;

            if (is_null($cek_pembimbing) && is_null($cek_penguji)) {
                $response = [
                    'status'  => 'error',
                    'message' => 'You do not have access to data with id ' . $seminar_proposal->id,
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

                return response()->json($response, 400);
            }

            $cek_verifikasi = HasilSeminarProposal::where([
                ['dosen_id_dosen', $dosen->id],
                ['seminar_proposal_id_seminar', $seminar_proposal->id]
            ])->first();

            if (is_null($cek_verifikasi)) {
                $response = [
                    'status'  => 'error',
                    'message' => 'Seminar proposal with id ' . $seminar_proposal->id . ' not verified, please verify first.',
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

                return response()->json($response, 400);
            } elseif (!is_null($cek_pembimbing)) {
                
                $validator = Validator::make($request->all(), [
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
                    'jabatan_dosen_seminar_proposal' => $jabatan_dosen_seminar_proposal,
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
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Input nilai is successful',
                    'data' => $data,
                ], 200);
            } elseif (!is_null($cek_penguji)) {  
                $validator = Validator::make($request->all(), [
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
                    'jabatan_dosen_seminar_proposal' => $jabatan_dosen_seminar_proposal,
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
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Input nilai is successful',
                    'data' => $data,
                ], 200);
            }
        } elseif ($seminar_proposal->status_seminar_proposal == 'Selesai') {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json([
                'status'  => 'error',
                'message' => 'Seminar Proposal Has Completed'
            ], 400);
        }
    }

    public function lihat_nilai(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

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
                'status'  => 'error',
                'message' => 'You do not have access to data with id ' . $seminar_proposal->id,
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }

        $cek_verifikasi = HasilSeminarProposal::where([
            ['dosen_id_dosen', $dosen->id],
            ['seminar_proposal_id_seminar', $seminar_proposal->id]
        ])->first();

        if (is_null($cek_verifikasi)) {
            $response = [
                'status'  => 'error',
                'message' => 'Seminar proposal with id ' . $seminar_proposal->id . ' not verified, please verify first.',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        } else {
            $jabatan_dosen_seminar_proposal = null;
            if (!is_null($cek_pembimbing)) {
                $jabatan_dosen_seminar_proposal = 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $jabatan_dosen_seminar_proposal = 'Penguji ' . $cek_penguji->jabatan_dosen_penguji;
            }
            $jabatan_dosen_seminar_proposal;

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
                'jabatan_dosen_seminar_proposal' => $jabatan_dosen_seminar_proposal,
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
                'status'  => 'success',
                'message' => 'Data information',
                'data' => $data
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json($response, 200);
        }
    }
}
