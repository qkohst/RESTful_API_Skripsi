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

class PersyaratanSkripsiController extends Controller
{
    public function uploadkrs(Request $request)
    {
        $this->validate($request, [
            'file_krs' => 'required|mimes:jpg,jpeg,png|max:2000',
        ]);

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
            $data_file_krs->move('fileKRS/', $krs_fileName);

            $data = [
                'id' => $file_krs->id,
                'file' => [
                    'nama_file' => $file_krs->nama_file_krs,
                    'url' => 'fileKRS/' . $file_krs->nama_file_krs,
                ],
                'created_at' => $file_krs->created_at->diffForHumans(),
            ];

            $response = [
                'message' => 'File uploaded successfully',
                'file_krs' => $data
            ];
            return response()->json($response, 201);
        } else {
            if ($data_krs_mahasiswa->status_persetujuan_admin_prodi_file_krs == 'Ditolak') {
                $data_krs_mahasiswa->nama_file_krs = $krs_fileName;
                $data_krs_mahasiswa->status_persetujuan_admin_prodi_file_krs = 'Antrian';
                $data_krs_mahasiswa->catatan_file_krs = '';
                $data_krs_mahasiswa->update();

                $data = [
                    'id' => $data_krs_mahasiswa->id,
                    'file' => [
                        'nama_file' => $data_krs_mahasiswa->nama_file_krs,
                        'url' => 'fileKRS/' . $data_krs_mahasiswa->nama_file_krs,
                    ],
                    'updated_at' => $data_krs_mahasiswa->updated_at->diffForHumans(),
                ];

                $response = [
                    'message' => 'File updated successfully',
                    'file_krs' => $data
                ];
                return response()->json($response, 200);
            } elseif ($data_krs_mahasiswa->status_persetujuan_admin_prodi_file_krs == 'Antrian') {
                $response = [
                    'message' => 'detects that you have uploaded a file KRS, please wait for the approval of the admin prodi',
                ];
                return response()->json($response, 409);
            }
            $response = [
                'message' => 'It is detected that the file krs has been approved by the admin prodi, you cannot change the krs file krs',
            ];
            return response()->json($response, 409);
        }
    }

    public function lihat_status_krs()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $file_krs = FileKrs::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($file_krs)) {
            $response = [
                'message' => 'File KRS Not Found, please upload the file',
            ];
            return response()->json($response, 404);
        }

        $data = [
            'id' => $file_krs->id,
            'file' => [
                'nama_file' => $file_krs->nama_file_krs,
                'url' => 'fileKRS/' . $file_krs->nama_file_krs,
            ],
            'status_persetujuan_admin_prodi_file_krs' => $file_krs->status_persetujuan_admin_prodi_file_krs,
            'catatan_file_krs' => $file_krs->catatan_file_krs,
            'created_at' => $file_krs->created_at->diffForHumans(),
        ];
        return response()->json($data, 200);
    }

    public function juduldosbing1(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $file_krs = FileKrs::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        if (is_null($file_krs)) {
            $response = [
                'message' => 'You are not allowed at this stage, please complete the KRS upload process first',
            ];
            return response()->json($response, 400);
        } elseif ($file_krs->status_persetujuan_admin_prodi_file_krs == 'Disetujui') {
            $cek_judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', '=', $mahasiswa->id)->first();
            $this->validate($request, [
                'nama_judul_skripsi' => 'required|min:15|unique:judul_skripsi' . ($cek_judul_skripsi->id ? ",id,$cek_judul_skripsi->id" : ''),
                'dosen_id_dosen' => 'required|exists:dosen,id',
            ]);
            if (is_null($cek_judul_skripsi)) {
                $cekdosen = Dosen::where('id', $request->dosen_id_dosen)->first();
                if ($cekdosen->status_dosen == 'Non Aktif') {
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => [
                            'dosen_id_dosen' => [
                                'The selected dosen id dosen status is non aktif, please choose another'
                            ]
                        ]
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
                    'persetujuan_dosen_pembimbing' => 'Antrian',
                ]);
                $pembimbing1->save();

                $data = [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi,
                    'dosen_pembimbing' => [
                        'dosen_id_dosen' => $pembimbing1->dosen_id_dosen,
                        'nama_dosen_pembimbing' => $cekdosen->nama_dosen,
                        'jabatan_dosen_pembibing' => $pembimbing1->jabatan_dosen_pembimbing,
                        'persetujuan_dosen_pembimbing' => $pembimbing1->persetujuan_dosen_pembimbing,
                    ],
                    'created_at' => $pembimbing1->created_at
                ];

                return response()->json([
                    'message' => 'Data has been submitted',
                    'judul_skripsi' => $data
                ], 201);
            } else {
                $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', '=', $mahasiswa->id)->first();
                $dosbing1 = DosenPembimbing::where([
                    ['judul_skripsi_id_judul_skripsi', '=', $cek_judul_skripsi->id],
                    ['jabatan_dosen_pembimbing', '=', '1']
                ])->first();

                if ($dosbing1->persetujuan_dosen_pembimbing == 'Ditolak') {
                    $cekdosen = Dosen::where('id', $request->dosen_id_dosen)->first();
                    if ($cekdosen->status_dosen == 'Non Aktif') {
                        return response()->json([
                            'message' => 'The given data was invalid.',
                            'errors' => [
                                'dosen_id_dosen' => [
                                    'The selected dosen id dosen status is non aktif, please choose another'
                                ]
                            ]
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

                    return response()->json([
                        'message' => 'Data has been updated',
                        'judul_skripsi' => $data
                    ], 200);
                } elseif ($dosbing1->persetujuan_dosen_pembimbing == 'Antrian') {
                    $response = [
                        'message' => 'Please wait for the approval of the dosen pembimbing 1',
                    ];
                    return response()->json($response, 409);
                }
                $response = [
                    'message' => 'The submission has been approved by dosen pembimbing 1, you cannot change data. Please continue with the process of selecting pembimbing 2',
                ];
                return response()->json($response, 409);
            }
        }
        $response = [
            'message' => 'You are not allowed at this stage, please complete the KRS upload process first',
        ];
        return response()->json($response, 400);
    }

    public function lihat_status_juduldosbing1()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($judul_skripsi)) {
            $response = [
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
            'nama_dosen_pembimbing' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
            'nidn_dosen_pembimbing' => $dosen->nidn_dosen,
            'persetujuan_dosen_pembimbing' => $pembimbing1->persetujuan_dosen_pembimbing,
            'catatan_dosen_pembimbing' => $pembimbing1->catatan_dosen_pembimbing,
            'crated_at' => $pembimbing1->created_at
        ];

        return response()->json([
            'message' => 'Submission status',
            'status_pengajuan_pembimbing1' => $data
        ], 200);
    }
}
