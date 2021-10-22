<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\HasilSidangSkripsi;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SidangSkripsi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class DosenVerifikasiSidangSkripsiController extends Controller
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

        $sidang_skripsi = SidangSkripsi::whereIn('judul_skripsi_id_judul_skripsi', $id_judul_skripsi)
            ->where('status_sidang_skripsi', '!=', 'Pengajuan')
            ->orderBy('status_sidang_skripsi', 'asc')
            ->orderBy('waktu_sidang_skripsi', 'asc')
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
                'url' => 'fileSidang/' . $data_sidang_skripsi->file_sidang_skripsi
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
                $sidang->jabatan_dosen_sidang_skripsi = 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $sidang->jabatan_dosen_sidang_skripsi = 'Penguji ' . $cek_penguji->jabatan_dosen_penguji;
            }

            $sidang->waktu_sidang_skripsi = $data_sidang_skripsi->waktu_sidang_skripsi;
            $sidang->tempat_sidang_skripsi = $data_sidang_skripsi->tempat_sidang_skripsi;
            if ($data_sidang_skripsi->waktu_sidang_skripsi > Carbon::now() && $data_sidang_skripsi->status_sidang_skripsi == 'Proses') {
                $sidang->status_sidang_skripsi = 'Belum Mulai';
            } elseif ($data_sidang_skripsi->waktu_sidang_skripsi <= Carbon::now() && $data_sidang_skripsi->status_sidang_skripsi == 'Proses') {
                $sidang->status_sidang_skripsi = 'Sedang Berlangsung';
            } elseif ($data_sidang_skripsi->status_sidang_skripsi == 'Selesai') {
                $sidang->status_sidang_skripsi = 'Selesai';
            }

            $cek_verifikasi = HasilSidangSkripsi::where([
                ['dosen_id_dosen', $dosen->id],
                ['sidang_skripsi_id_sidang', $data_sidang_skripsi->id]
            ])->first();
            if (is_null($cek_verifikasi)) {
                $sidang->status_verifikasi_sidang_skripsi = 'Belum Verifikasi';
            } else {
                $sidang->status_verifikasi_sidang_skripsi = $cek_verifikasi->status_verifikasi_hasil_sidang_skripsi;
            }
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
                    'message' => 'You do not have access to data with id ' . $sidang_skripsi->id,
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

                return response()->json($response, 400);
            }

            $cek_verifikasi = HasilSidangSkripsi::where([
                ['dosen_id_dosen', $dosen->id],
                ['sidang_skripsi_id_sidang', $sidang_skripsi->id]
            ])->first();
            if (is_null($cek_verifikasi)) {
                $status_verifikasi_hasil_sidang_skripsi = 'Belum Verifikasi';
                $catatan_hasil_sidang_skripsi = '-';
            } else {
                $status_verifikasi_hasil_sidang_skripsi = $cek_verifikasi->status_verifikasi_hasil_sidang_skripsi;
                $catatan_hasil_sidang_skripsi = $cek_verifikasi->catatan_hasil_sidang_skripsi;
            }
            $jabatan_dosen_sidang_skripsi = null;
            if (!is_null($cek_pembimbing)) {
                $jabatan_dosen_sidang_skripsi = 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $jabatan_dosen_sidang_skripsi = 'Penguji ' . $cek_penguji->jabatan_dosen_penguji;
            }
            $jabatan_dosen_sidang_skripsi;

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
                'file_sidang_skripsi' => [
                    'nama_file' => $sidang_skripsi->file_sidang_skripsi,
                    'url' => 'fileSidang/' . $sidang_skripsi->file_sidang_skripsi
                ],
                'jabatan_dosen_sidang_skripsi' => $jabatan_dosen_sidang_skripsi,
                'status_verifikasi_hasil_sidang_skripsi' => $status_verifikasi_hasil_sidang_skripsi,
                'catatan_hasil_sidang_skripsi' => $catatan_hasil_sidang_skripsi
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
            'status_verifikasi_hasil_sidang_skripsi' => 'required|in:Revisi,Lulus Sidang',
            'catatan_hasil_sidang_skripsi' => 'required',
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

        $sidang_skripsi = SidangSkripsi::findorfail($id);
        if ($sidang_skripsi->waktu_sidang_skripsi > Carbon::now() && $sidang_skripsi->status_sidang_skripsi == 'Proses') {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json([
                'status'  => 'error',
                'message' => 'Verification cannot be carried out yet, because the Sidang Skripsi has not yet started'
            ], 400);
        } elseif ($sidang_skripsi->waktu_sidang_skripsi <= Carbon::now() && $sidang_skripsi->status_sidang_skripsi == 'Proses') {
            $judul_skripsi = JudulSkripsi::findorfail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
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
                    'message' => 'You do not have access to data with id ' . $sidang_skripsi->id,
                ];
                return response()->json($response, 400);
            } elseif (!is_null($cek_pembimbing)) {
                $cek_verifikasi = HasilSidangSkripsi::where([
                    ['dosen_id_dosen', $dosen->id],
                    ['sidang_skripsi_id_sidang', $sidang_skripsi->id]
                ])->first();
                if (is_null($cek_verifikasi)) {
                    $verifikasi = new HasilSidangSkripsi([
                        'sidang_skripsi_id_sidang' => $sidang_skripsi->id,
                        'dosen_id_dosen' => $dosen->id,
                        'jenis_dosen_hasil_sidang_skripsi' => 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing,
                        'status_verifikasi_hasil_sidang_skripsi' => $request->status_verifikasi_hasil_sidang_skripsi,
                        'catatan_hasil_sidang_skripsi' => $request->catatan_hasil_sidang_skripsi
                    ]);
                    $verifikasi->save();

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
                        'jabatan_dosen_sidang_skripsi' => $verifikasi->jenis_dosen_hasil_sidang_skripsi,
                        'status_verifikasi_hasil_sidang_skripsi' => $verifikasi->status_verifikasi_hasil_sidang_skripsi,
                        'catatan_hasil_sidang_skripsi' => $verifikasi->catatan_hasil_sidang_skripsi,
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
                } elseif ($cek_verifikasi->status_verifikasi_hasil_sidang_skripsi == 'Revisi') {
                    $cek_verifikasi->status_verifikasi_hasil_sidang_skripsi = $request->status_verifikasi_hasil_sidang_skripsi;
                    $cek_verifikasi->catatan_hasil_sidang_skripsi = $request->catatan_hasil_sidang_skripsi;
                    $cek_verifikasi->update();
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
                        'jabatan_dosen_sidang_skripsi' => $cek_verifikasi->jenis_dosen_hasil_sidang_skripsi,
                        'status_verifikasi_hasil_sidang_skripsi' => $cek_verifikasi->status_verifikasi_hasil_sidang_skripsi,
                        'catatan_hasil_sidang_skripsi' => $cek_verifikasi->catatan_hasil_sidang_skripsi,
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
                } elseif ($cek_verifikasi->status_verifikasi_hasil_sidang_skripsi == 'Lulus Sidang') {
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
                $cek_verifikasi = HasilSidangSkripsi::where([
                    ['dosen_id_dosen', $dosen->id],
                    ['sidang_skripsi_id_sidang', $sidang_skripsi->id]
                ])->first();
                if (is_null($cek_verifikasi)) {
                    $verifikasi = new HasilSidangSkripsi([
                        'sidang_skripsi_id_sidang' => $sidang_skripsi->id,
                        'dosen_id_dosen' => $dosen->id,
                        'jenis_dosen_hasil_sidang_skripsi' => 'Penguji ' . $cek_penguji->jabatan_dosen_penguji,
                        'status_verifikasi_hasil_sidang_skripsi' => $request->status_verifikasi_hasil_sidang_skripsi,
                        'catatan_hasil_sidang_skripsi' => $request->catatan_hasil_sidang_skripsi
                    ]);
                    $verifikasi->save();

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
                        'jabatan_dosen_sidang_skripsi' => $verifikasi->jenis_dosen_hasil_sidang_skripsi,
                        'status_verifikasi_hasil_sidang_skripsi' => $verifikasi->status_verifikasi_hasil_sidang_skripsi,
                        'catatan_hasil_sidang_skripsi' => $verifikasi->catatan_hasil_sidang_skripsi,
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
                } elseif ($cek_verifikasi->status_verifikasi_hasil_sidang_skripsi == 'Revisi') {
                    $cek_verifikasi->status_verifikasi_hasil_sidang_skripsi = $request->status_verifikasi_hasil_sidang_skripsi;
                    $cek_verifikasi->catatan_hasil_sidang_skripsi = $request->catatan_hasil_sidang_skripsi;
                    $cek_verifikasi->update();
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
                        'jabatan_dosen_sidang_skripsi' => $cek_verifikasi->jenis_dosen_hasil_sidang_skripsi,
                        'status_verifikasi_hasil_sidang_skripsi' => $cek_verifikasi->status_verifikasi_hasil_sidang_skripsi,
                        'catatan_hasil_sidang_skripsi' => $cek_verifikasi->catatan_hasil_sidang_skripsi,
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
                } elseif ($cek_verifikasi->status_verifikasi_hasil_sidang_skripsi == 'Lulus Sidang') {
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
        } elseif ($sidang_skripsi->status_sidang_skripsi == 'Selesai') {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json([
                'status'  => 'error',
                'message' => 'Sidang Skripsi Has Completed'
            ], 400);
        }
    }

    public function input_nilai(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $sidang_skripsi = SidangSkripsi::findorfail($id);
        if ($sidang_skripsi->waktu_sidang_skripsi > Carbon::now() && $sidang_skripsi->status_sidang_skripsi == 'Proses') {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'Input nilai cannot be carried out yet, because the seminar proposal has not yet started'
            ], 400);
        } elseif ($sidang_skripsi->waktu_sidang_skripsi <= Carbon::now() && $sidang_skripsi->status_sidang_skripsi == 'Proses') {
            $judul_skripsi = JudulSkripsi::findorfail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
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

            $jabatan_dosen_sidang_skripsi = null;
            if (!is_null($cek_pembimbing)) {
                $jabatan_dosen_sidang_skripsi = 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $jabatan_dosen_sidang_skripsi = 'Penguji ' . $cek_penguji->jabatan_dosen_penguji;
            }
            $jabatan_dosen_sidang_skripsi;

            if (is_null($cek_pembimbing) && is_null($cek_penguji)) {
                $response = [
                    'status'  => 'error',
                    'message' => 'You do not have access to data with id ' . $sidang_skripsi->id,
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();
                return response()->json($response, 400);
            }

            $cek_verifikasi = HasilSidangSkripsi::where([
                ['dosen_id_dosen', $dosen->id],
                ['sidang_skripsi_id_sidang', $sidang_skripsi->id]
            ])->first();
            if (is_null($cek_verifikasi)) {
                $response = [
                    'status'  => 'error',
                    'message' => 'Sidang Skripsi with id ' . $sidang_skripsi->id . ' not verified, please verify first.',
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

                return response()->json($response, 400);
            } elseif (!is_null($cek_pembimbing)) {
               
                $validator = Validator::make($request->all(), [
                    'nilai_a1_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_a2_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_a3_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b1_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b2_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b3_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b4_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b5_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b6_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b7_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_c1_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_c2_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_c3_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
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

                $cek_verifikasi->nilai_a1_hasil_sidang_skripsi = $request->nilai_a1_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_a2_hasil_sidang_skripsi = $request->nilai_a2_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_a3_hasil_sidang_skripsi = $request->nilai_a3_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b1_hasil_sidang_skripsi = $request->nilai_b1_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b2_hasil_sidang_skripsi = $request->nilai_b2_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b3_hasil_sidang_skripsi = $request->nilai_b3_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b4_hasil_sidang_skripsi = $request->nilai_b4_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b5_hasil_sidang_skripsi = $request->nilai_b5_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b6_hasil_sidang_skripsi = $request->nilai_b6_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b7_hasil_sidang_skripsi = $request->nilai_b7_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_c1_hasil_sidang_skripsi = $request->nilai_c1_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_c2_hasil_sidang_skripsi = $request->nilai_c2_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_c3_hasil_sidang_skripsi = $request->nilai_c3_hasil_sidang_skripsi;
                $cek_verifikasi->update();

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
                    'jabatan_dosen_sidang_skripsi' => $jabatan_dosen_sidang_skripsi,
                    'nilai_a1_hasil_sidang_skripsi' => $cek_verifikasi->nilai_a1_hasil_sidang_skripsi,
                    'nilai_a2_hasil_sidang_skripsi' => $cek_verifikasi->nilai_a2_hasil_sidang_skripsi,
                    'nilai_a3_hasil_sidang_skripsi' => $cek_verifikasi->nilai_a3_hasil_sidang_skripsi,
                    'nilai_b1_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b1_hasil_sidang_skripsi,
                    'nilai_b2_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b2_hasil_sidang_skripsi,
                    'nilai_b3_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b3_hasil_sidang_skripsi,
                    'nilai_b4_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b4_hasil_sidang_skripsi,
                    'nilai_b5_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b5_hasil_sidang_skripsi,
                    'nilai_b6_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b6_hasil_sidang_skripsi,
                    'nilai_b7_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b7_hasil_sidang_skripsi,
                    'nilai_c1_hasil_sidang_skripsi' => $cek_verifikasi->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $cek_verifikasi->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $cek_verifikasi->nilai_c3_hasil_sidang_skripsi
                ];

                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Input nilai is successful',
                    'nilai_hasil_sidang_skripsi' => $data,
                ], 200);
            } elseif (!is_null($cek_penguji)) {
                $validator = Validator::make($request->all(), [
                    'nilai_b1_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b2_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b3_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b4_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b5_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b6_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_b7_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_c1_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_c2_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
                    'nilai_c3_hasil_sidang_skripsi' => 'required|numeric|between:0,100',
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
                $cek_verifikasi->nilai_b1_hasil_sidang_skripsi = $request->nilai_b1_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b2_hasil_sidang_skripsi = $request->nilai_b2_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b3_hasil_sidang_skripsi = $request->nilai_b3_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b4_hasil_sidang_skripsi = $request->nilai_b4_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b5_hasil_sidang_skripsi = $request->nilai_b5_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b6_hasil_sidang_skripsi = $request->nilai_b6_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_b7_hasil_sidang_skripsi = $request->nilai_b7_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_c1_hasil_sidang_skripsi = $request->nilai_c1_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_c2_hasil_sidang_skripsi = $request->nilai_c2_hasil_sidang_skripsi;
                $cek_verifikasi->nilai_c3_hasil_sidang_skripsi = $request->nilai_c3_hasil_sidang_skripsi;
                $cek_verifikasi->update();

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
                    'jabatan_dosen_sidang_skripsi' => $jabatan_dosen_sidang_skripsi,
                    'nilai_a1_hasil_sidang_skripsi' => $cek_verifikasi->nilai_a1_hasil_sidang_skripsi,
                    'nilai_a2_hasil_sidang_skripsi' => $cek_verifikasi->nilai_a2_hasil_sidang_skripsi,
                    'nilai_a3_hasil_sidang_skripsi' => $cek_verifikasi->nilai_a3_hasil_sidang_skripsi,
                    'nilai_b1_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b1_hasil_sidang_skripsi,
                    'nilai_b2_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b2_hasil_sidang_skripsi,
                    'nilai_b3_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b3_hasil_sidang_skripsi,
                    'nilai_b4_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b4_hasil_sidang_skripsi,
                    'nilai_b5_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b5_hasil_sidang_skripsi,
                    'nilai_b6_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b6_hasil_sidang_skripsi,
                    'nilai_b7_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b7_hasil_sidang_skripsi,
                    'nilai_c1_hasil_sidang_skripsi' => $cek_verifikasi->nilai_c1_hasil_sidang_skripsi,
                    'nilai_c2_hasil_sidang_skripsi' => $cek_verifikasi->nilai_c2_hasil_sidang_skripsi,
                    'nilai_c3_hasil_sidang_skripsi' => $cek_verifikasi->nilai_c3_hasil_sidang_skripsi
                ];

                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Input nilai is successful',
                    'nilai_hasil_sidang_skripsi' => $data,
                ], 200);
            }
        } elseif ($sidang_skripsi->status_sidang_skripsi == 'Selesai') {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json([
                'status'  => 'error',
                'message' => 'Sidang Skripsi Has Completed'
            ], 400);
        }
    }

    public function lihat_nilai(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $sidang_skripsi = SidangSkripsi::findorfail($id);
        $judul_skripsi = JudulSkripsi::findorfail($sidang_skripsi->judul_skripsi_id_judul_skripsi);
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
                'message' => 'You do not have access to data with id ' . $sidang_skripsi->id,
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }

        $cek_verifikasi = HasilSidangSkripsi::where([
            ['dosen_id_dosen', $dosen->id],
            ['sidang_skripsi_id_sidang', $sidang_skripsi->id]
        ])->first();

        if (is_null($cek_verifikasi)) {
            $response = [
                'status'  => 'error',
                'message' => 'Sidang skripsi with id ' . $sidang_skripsi->id . ' not verified, please verify first.',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 400);
        } else {
            $jabatan_dosen_sidang_skripsi = null;
            if (!is_null($cek_pembimbing)) {
                $jabatan_dosen_sidang_skripsi = 'Pembimbing ' . $cek_pembimbing->jabatan_dosen_pembimbing;
            } elseif (!is_null($cek_penguji)) {
                $jabatan_dosen_sidang_skripsi = 'Penguji ' . $cek_penguji->jabatan_dosen_penguji;
            }
            $jabatan_dosen_sidang_skripsi;
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
                'jabatan_dosen_sidang_skripsi' => $jabatan_dosen_sidang_skripsi,
                'nilai_a1_hasil_sidang_skripsi' => $cek_verifikasi->nilai_a1_hasil_sidang_skripsi,
                'nilai_a2_hasil_sidang_skripsi' => $cek_verifikasi->nilai_a2_hasil_sidang_skripsi,
                'nilai_a3_hasil_sidang_skripsi' => $cek_verifikasi->nilai_a3_hasil_sidang_skripsi,
                'nilai_b1_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b1_hasil_sidang_skripsi,
                'nilai_b2_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b2_hasil_sidang_skripsi,
                'nilai_b3_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b3_hasil_sidang_skripsi,
                'nilai_b4_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b4_hasil_sidang_skripsi,
                'nilai_b5_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b5_hasil_sidang_skripsi,
                'nilai_b6_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b6_hasil_sidang_skripsi,
                'nilai_b7_hasil_sidang_skripsi' => $cek_verifikasi->nilai_b7_hasil_sidang_skripsi,
                'nilai_c1_hasil_sidang_skripsi' => $cek_verifikasi->nilai_c1_hasil_sidang_skripsi,
                'nilai_c2_hasil_sidang_skripsi' => $cek_verifikasi->nilai_c2_hasil_sidang_skripsi,
                'nilai_c3_hasil_sidang_skripsi' => $cek_verifikasi->nilai_c3_hasil_sidang_skripsi
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
