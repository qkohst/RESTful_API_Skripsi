<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\DosenPembimbing;
use App\FileKrs;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\ProgramStudi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PersyaratanSkripsiController extends Controller
{
    public function uploadkrs(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'file_krs' => 'required|image|max:2000',
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

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $data_krs_mahasiswa = FileKrs::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        $data_file_krs = $request->file('file_krs');
        $krs_fileName = 'krs-' . $mahasiswa->npm_mahasiswa . '.' . $data_file_krs->getClientOriginalExtension();

        if (is_null($data_krs_mahasiswa)) {
            $file_krs = new FileKrs([
                'mahasiswa_id_mahasiswa' => $mahasiswa->id,
                'nama_file_krs' => $krs_fileName,
                'status_persetujuan_admin_prodi_file_krs' => 'Antrian',
            ]);
            $file_krs->save();
            $data_file_krs->move('api/v1/fileKRS/', $krs_fileName);

            $data = [
                'id' => $file_krs->id,
                'file' => [
                    'nama_file' => $file_krs->nama_file_krs,
                    'url' => 'fileKRS/' . $file_krs->nama_file_krs,
                ],
                'created_at' => $file_krs->created_at->diffForHumans(),
            ];

            $response = [
                'status'  => 'success',
                'message' => 'File uploaded successfully',
                'data' => $data
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json($response, 200);
        } else {
            if ($data_krs_mahasiswa->status_persetujuan_admin_prodi_file_krs == 'Ditolak') {
                $data_krs_mahasiswa->nama_file_krs = $krs_fileName;
                $data_krs_mahasiswa->status_persetujuan_admin_prodi_file_krs = 'Antrian';
                $data_krs_mahasiswa->catatan_file_krs = '';
                $data_krs_mahasiswa->update();

                $data = [
                    'id' => $data_krs_mahasiswa->id,
                    'file_krs' => [
                        'nama_file' => $data_krs_mahasiswa->nama_file_krs,
                        'url' => 'fileKRS/' . $data_krs_mahasiswa->nama_file_krs,
                    ],
                    'updated_at' => $data_krs_mahasiswa->updated_at->diffForHumans(),
                ];

                $response = [
                    'status'  => 'success',
                    'message' => 'File updated successfully',
                    'data' => $data
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                return response()->json($response, 200);
            } elseif ($data_krs_mahasiswa->status_persetujuan_admin_prodi_file_krs == 'Antrian') {
                $response = [
                    'status'  => 'error',
                    'message' => 'detects that you have uploaded a file KRS, please wait for the approval of the admin prodi',
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();
                return response()->json($response, 409);
            }
            $response = [
                'status'  => 'error',
                'message' => 'It is detected that the file krs has been approved by the admin prodi, you cannot change the krs file krs',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 409);
        }
    }

    public function lihat_status_krs(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $file_krs = FileKrs::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($file_krs)) {
            $response = [
                'status'  => 'error',
                'message' => 'File KRS Not Found, please upload the file',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 404);
        }

        $data = [
            'id' => $file_krs->id,
            'file_krs' => [
                'nama_file' => $file_krs->nama_file_krs,
                'url' => 'fileKRS/' . $file_krs->nama_file_krs,
            ],
            'status_persetujuan_admin_prodi_file_krs' => $file_krs->status_persetujuan_admin_prodi_file_krs,
            'catatan_file_krs' => $file_krs->catatan_file_krs,
            'tanggal_pengajuan_file_krs' => $file_krs->created_at->format('Y-m-d H:i:s')
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        $response = [
            'status'  => 'success',
            'message' => 'KRS File Verification Status',
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    public function juduldosbing1(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $file_krs = FileKrs::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        if (is_null($file_krs)) {
            $response = [
                'status'  => 'error',
                'message' => 'You are not allowed at this stage, please complete the KRS upload process first',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 400);
        } elseif ($file_krs->status_persetujuan_admin_prodi_file_krs == 'Disetujui') {
            $cek_judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', '=', $mahasiswa->id)->first();
            if (is_null($cek_judul_skripsi)) {
                $validator = Validator::make($request->all(), [
                    'nama_judul_skripsi' => 'required|min:10|unique:judul_skripsi',
                    'dosen_id_dosen' => 'required|exists:dosen,id',
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

                $cekdosen = Dosen::where('id', $request->dosen_id_dosen)->first();
                if ($cekdosen->status_dosen == 'Non Aktif') {
                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '0',
                    ]);
                    $traffic->save();

                    return response()->json([
                        'status'  => 'error',
                        'message' => 'The selected dosen id dosen status is non aktif, please choose another',
                    ], 422);
                }

                $judul_skripsi = new JudulSkripsi([
                    'mahasiswa_id_mahasiswa' => $mahasiswa->id,
                    'nama_judul_skripsi' => $request->nama_judul_skripsi,
                ]);
                $judul_skripsi->save();

                $pembimbing1 = new DosenPembimbing([
                    'judul_skripsi_id_judul_skripsi' => $judul_skripsi->id,
                    'dosen_id_dosen' => $request->dosen_id_dosen,
                    'jabatan_dosen_pembimbing' => '1',
                    'persetujuan_dosen_pembimbing' => 'Antrian'
                ]);
                $pembimbing1->save();

                $data = [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi,
                    'dosen_pembimbing' => [
                        'id' => $pembimbing1->dosen_id_dosen,
                        'nama_dosen_pembimbing' => $cekdosen->nama_dosen . ', ' . $cekdosen->gelar_dosen,
                        'jabatan_dosen_pembibing' => $pembimbing1->jabatan_dosen_pembimbing,
                        'persetujuan_dosen_pembimbing' => $pembimbing1->persetujuan_dosen_pembimbing,
                    ],
                    'created_at' => $pembimbing1->created_at
                ];

                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '1',
                ]);
                $traffic->save();

                $response = [
                    'status'  => 'success',
                    'message' => 'Data has been submitted',
                    'data' => $data
                ];
                return response()->json($response, 200);
            } else {
                $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', '=', $mahasiswa->id)->first();
                $dosbing1 = DosenPembimbing::where([
                    ['judul_skripsi_id_judul_skripsi', '=', $cek_judul_skripsi->id],
                    ['jabatan_dosen_pembimbing', '=', '1']
                ])->first();

                $validator = Validator::make($request->all(), [
                    'nama_judul_skripsi' => 'required|min:10|unique:judul_skripsi' . ($judul_skripsi->id ? ",id,$judul_skripsi->id" : ''),
                    'dosen_id_dosen' => 'required|exists:dosen,id',
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

                if ($dosbing1->persetujuan_dosen_pembimbing == 'Ditolak') {
                    $cekdosen = Dosen::where('id', $request->dosen_id_dosen)->first();
                    if ($cekdosen->status_dosen == 'Non Aktif') {
                        $traffic = new TrafficRequest([
                            'api_client_id' => $api_client->id,
                            'status' => '0',
                        ]);
                        $traffic->save();
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'The selected dosen id dosen status is non aktif, please choose another',
                        ], 422);
                    }

                    $judul_skripsi->nama_judul_skripsi = $request->nama_judul_skripsi;
                    $judul_skripsi->update();

                    $dosbing1->dosen_id_dosen = $request->dosen_id_dosen;
                    $dosbing1->persetujuan_dosen_pembimbing = 'Antrian';
                    $dosbing1->catatan_dosen_pembimbing = '';
                    $dosbing1->update();

                    $data = [
                        'id' => $judul_skripsi->id,
                        'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi,
                        'dosen_pembimbing' => [
                            'dosen_id_dosen' => $dosbing1->dosen_id_dosen,
                            'nama_dosen_pembimbing' => $cekdosen->nama_dosen,
                            'jabatan_dosen_pembibing' => $dosbing1->jabatan_dosen_pembimbing,
                            'persetujuan_dosen_pembimbing' => $dosbing1->persetujuan_dosen_pembimbing,
                        ],
                        'created_at' => $dosbing1->updated_at
                    ];
                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '1',
                    ]);
                    $traffic->save();

                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Data has been updated',
                        'data' => $data
                    ], 200);
                } elseif ($dosbing1->persetujuan_dosen_pembimbing == 'Antrian') {
                    $response = [
                        'status'  => 'error',
                        'message' => 'Please wait for the approval of the dosen pembimbing 1',
                    ];
                    $traffic = new TrafficRequest([
                        'api_client_id' => $api_client->id,
                        'status' => '0',
                    ]);
                    $traffic->save();
                    return response()->json($response, 409);
                }
                $response = [
                    'status'  => 'error',
                    'message' => 'The submission has been approved by dosen pembimbing 1, you cannot change data. Please continue with the process of selecting pembimbing 2',
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();
                return response()->json($response, 409);
            }
        }
        $response = [
            'status'  => 'error',
            'message' => 'You are not allowed at this stage, please complete the KRS upload process first',
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();
        return response()->json($response, 400);
    }


    public function lihat_status_juduldosbing1(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($judul_skripsi)) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'error',
                'message' => 'Judul Skripsi Not Found, please upload data',
            ];
            return response()->json($response, 404);
        }

        $pembimbing1 = DosenPembimbing::where([
            ['judul_skripsi_id_judul_skripsi', '=', $judul_skripsi->id],
            ['jabatan_dosen_pembimbing', '=', '1']
        ])->first();
        $dosen = Dosen::findOrFail($pembimbing1->dosen_id_dosen);

        $data = [
            'id' => $pembimbing1->id,
            'judul_skripsi' => [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ],
            'nama_dosen_pembimbing1' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
            'nidn_dosen_pembimbing1' => $dosen->nidn_dosen,
            'persetujuan_dosen_pembimbing1' => $pembimbing1->persetujuan_dosen_pembimbing,
            'catatan_dosen_pembimbing1' => $pembimbing1->catatan_dosen_pembimbing,
            'tanggal_pengajuan_dosen_pembimbing1' => $pembimbing1->created_at->format('Y-m-d H:i:s')
        ];

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Submission status',
            'data' => $data
        ], 200);
    }

    public function juduldosbing2(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        $pembimbing1 = DosenPembimbing::where([
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
            ['jabatan_dosen_pembimbing', '1']
        ])->first();

        if (is_null($judul_skripsi)) {
            $response = [
                'status'  => 'error',
                'message' => 'You are not allowed at this stage',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        } elseif ($pembimbing1->persetujuan_dosen_pembimbing != 'Disetujui') {
            $response = [
                'status'  => 'error',
                'message' => 'You are not allowed at this stage, Make sure the judul skripsi has been approved by pembimbing 1',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 400);
        }

        $cek_pembimbing2 = DosenPembimbing::where([
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
            ['jabatan_dosen_pembimbing', '2']
        ])->first();

        if (is_null($cek_pembimbing2)) {
            $validator = Validator::make($request->all(), [
                'dosen_id_dosen' => 'required|exists:dosen,id',
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

            $cekdosen = Dosen::where('id', $request->dosen_id_dosen)->first();
            if ($cekdosen->status_dosen == 'Non Aktif' || $cekdosen->id == $pembimbing1->dosen_id_dosen) {
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

                return response()->json([
                    'status'  => 'error',
                    'message' => 'The selected dosen id dosen is invalid, please choose another',
                ], 422);
            }
            $pembimbing2 = new DosenPembimbing([
                'judul_skripsi_id_judul_skripsi' => $judul_skripsi->id,
                'dosen_id_dosen' => $request->dosen_id_dosen,
                'jabatan_dosen_pembimbing' => '2',
                'persetujuan_dosen_pembimbing' => 'Antrian'
            ]);
            $pembimbing2->save();

            $data = [
                'id' => $pembimbing2->id,
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'dosen' => [
                    'id' => $cekdosen->id,
                    'nama_dosen' => $cekdosen->nama_dosen . ', ' . $cekdosen->gelar_dosen
                ],
                'jabatan_dosen_pembimbing' => $pembimbing2->jabatan_dosen_pembimbing,
                'persetujuan_dosen_pembimbing' => $pembimbing2->persetujuan_dosen_pembimbing,
                'created_at' => $pembimbing2->created_at
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data has been submitted',
                'data' => $data
            ], 200);
        } elseif ($cek_pembimbing2->persetujuan_dosen_pembimbing == 'Ditolak') {
            $validator = Validator::make($request->all(), [
                'dosen_id_dosen' => 'required|exists:dosen,id',
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
            $cekdosen = Dosen::where('id', $request->dosen_id_dosen)->first();
            if ($cekdosen->status_dosen == 'Non Aktif' || $cekdosen->id == $pembimbing1->dosen_id_dosen) {
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();
                return response()->json([
                    'status'  => 'error',
                    'message' => 'The selected dosen id dosen is invalid, please choose another',
                ], 422);
            }

            $cek_pembimbing2->dosen_id_dosen = $request->dosen_id_dosen;
            $cek_pembimbing2->persetujuan_dosen_pembimbing = 'Antrian';
            $cek_pembimbing2->catatan_dosen_pembimbing = '';
            $cek_pembimbing2->update();

            $data = [
                'id' => $cek_pembimbing2->id,
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'dosen' => [
                    'id' => $cekdosen->id,
                    'nama_dosen' => $cekdosen->nama_dosen . ', ' . $cekdosen->gelar_dosen
                ],
                'jabatan_dosen_pembimbing' => $cek_pembimbing2->jabatan_dosen_pembimbing,
                'persetujuan_dosen_pembimbing' => $cek_pembimbing2->persetujuan_dosen_pembimbing,
                'created_at' => $cek_pembimbing2->created_at
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data has been updated',
                'data' => $data
            ], 200);
        } elseif ($cek_pembimbing2->persetujuan_dosen_pembimbing == 'Antrian') {
            $response = [
                'status'  => 'error',
                'message' => 'Please wait for the approval of the dosen pembimbing 2',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 409);
        }
        $response = [
            'status'  => 'error',
            'message' => 'The submission has been approved by dosen pembimbing 2, you cannot change data.',
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();
        return response()->json($response, 409);
    }

    public function lihat_status_juduldosbing2(Request $request)
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

        $pembimbing2 = DosenPembimbing::where([
            ['judul_skripsi_id_judul_skripsi', '=', $judul_skripsi->id],
            ['jabatan_dosen_pembimbing', '=', '2']
        ])->first();
        $dosen = Dosen::findOrFail($pembimbing2->dosen_id_dosen);

        $data = [
            'id' => $pembimbing2->id,
            'judul_skripsi' => [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ],
            'nama_dosen_pembimbing2' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
            'nidn_dosen_pembimbing2' => $dosen->nidn_dosen,
            'persetujuan_dosen_pembimbing2' => $pembimbing2->persetujuan_dosen_pembimbing,
            'catatan_dosen_pembimbing2' => $pembimbing2->catatan_dosen_pembimbing,
            'tanggal_pengajuan_dosen_pembimbing2' => $pembimbing2->created_at->format('Y-m-d H:i:s')
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Submission status',
            'data' => $data
        ], 200);
    }
}
