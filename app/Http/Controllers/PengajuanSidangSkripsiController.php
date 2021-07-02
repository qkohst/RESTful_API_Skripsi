<?php

namespace App\Http\Controllers;

use App\BimbinganSkripsi;
use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SidangSkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PengajuanSidangSkripsiController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'file_sidang_skripsi' => 'required|mimes:pdf|max:5000',
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
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($judul_skripsi)) {
            $response = [
                'status'  => 'error',
                'message' => 'You are not allowed at this stage, please complete the process pengajuan judul',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }
        $dosen_pembimbing = DosenPembimbing::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->get('id');
        $bimbingan_skripsi = BimbinganSkripsi::whereIn('dosen_pembimbing_id_dosen_pembimbing', $dosen_pembimbing)
            ->orderBy('created_at', 'desc')
            ->first();
        if (is_null($bimbingan_skripsi) || $bimbingan_skripsi->status_persetujuan_bimbingan_skripsi == 'Antrian') {
            $response = [
                'status'  => 'error',
                'message' => 'You are not allowed at this stage, please complete the process bimbingan skripsi',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }
        $data_sidang_skripsi = SidangSkripsi::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();

        $data_file_sidang_skripsi = $request->file('file_sidang_skripsi');
        $sidang_skripsi_fileName = 'sidang-' . $mahasiswa->npm_mahasiswa . '.' . $data_file_sidang_skripsi->getClientOriginalExtension();

        if (is_null($data_sidang_skripsi)) {
            $sidang_skripsi = new SidangSkripsi([
                'judul_skripsi_id_judul_skripsi' => $judul_skripsi->id,
                'file_sidang_skripsi' => $sidang_skripsi_fileName,
                'persetujuan_pembimbing1_sidang_skripsi' => 'Antrian',
                'persetujuan_pembimbing2_sidang_skripsi' => 'Antrian',
                'status_sidang_skripsi' => 'Pengajuan',
            ]);
            $sidang_skripsi->save();
            $data_file_sidang_skripsi->move('api/v1/fileSidang/', $sidang_skripsi_fileName);

            $data = [
                'id' => $sidang_skripsi->id,
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'file_sidang_skripsi' => [
                    'nama_file' => $sidang_skripsi->file_sidang_skripsi,
                    'url' => 'fileSidang/' . $sidang_skripsi->file_sidang_skripsi,
                ],
                'status_sidang_skripsi' => $sidang_skripsi->status_sidang_skripsi,
                'created_at' => $sidang_skripsi->created_at->diffForHumans(),
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'success',
                'message' => 'File uploaded successfully',
                'data' => $data
            ];
            return response()->json($response, 201);
        } else {
            if ($data_sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi == 'Ditolak' || $data_sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi == 'Ditolak') {
                $data_sidang_skripsi->file_sidang_skripsi = $sidang_skripsi_fileName;
                $data_sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi = 'Antrian';
                $data_sidang_skripsi->catatan_pembimbing1_sidang_skripsi = '';
                $data_sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi = 'Antrian';
                $data_sidang_skripsi->catatan_pembimbing2_sidang_skripsi = '';
                $data_sidang_skripsi->update();
                $data_file_sidang_skripsi->move('api/v1/fileSidang/', $sidang_skripsi_fileName);

                $data = [
                    'id' => $data_sidang_skripsi->id,
                    'judul_skripsi' => [
                        'id' => $judul_skripsi->id,
                        'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                    ],
                    'file_sidang_skripsi' => [
                        'nama_file' => $data_sidang_skripsi->file_sidang_skripsi,
                        'url' => 'fileSidang/' . $data_sidang_skripsi->file_sidang_skripsi,
                    ],
                    'status_sidang_skripsi' => $data_sidang_skripsi->status_sidang_skripsi,
                    'created_at' => $data_sidang_skripsi->created_at->diffForHumans(),
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
            } elseif ($data_sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi == 'Antrian' || $data_sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi == 'Antrian') {
                $response = [
                    'status'  => 'error',
                    'message' => 'Please wait for the approval of the dosen pembimbing',
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
                'message' => 'It is detected that the sidang skripsi has been approved by the dosen pembimbing, you cannot change data',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 409);
        }
    }

    public function cek_persetujuan_dosbing(Request $request)
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
        $data = [
            'id' => $sidang_skripsi->id,
            'judul_skripsi' => [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ],
            'persetujuan_pembimbing1_sidang_skripsi' => $sidang_skripsi->persetujuan_pembimbing1_sidang_skripsi,
            'catatan_pembimbing1_sidang_skripsi' => $sidang_skripsi->catatan_pembimbing1_sidang_skripsi,
            'persetujuan_pembimbing2_sidang_skripsi' => $sidang_skripsi->persetujuan_pembimbing2_sidang_skripsi,
            'catatan_pembimbing2_sidang_skripsi' => $sidang_skripsi->catatan_pembimbing2_sidang_skripsi,
            'tanggal_pengajuan_sidang_skripsi' => $sidang_skripsi->created_at->format('Y-m-d H:i:s'),
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

    public function cek_waktu(Request $request)
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
        } elseif (is_null($sidang_skripsi->waktu_sidang_skripsi)) {
            $response = [
                'status'  => 'error',
                'message' => 'Data not yet determined',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 404);
        } else {
            $penguji1 = DosenPenguji::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_penguji', '1']
            ])->first();
            $dosen_penguji1 = Dosen::findOrFail($penguji1->dosen_id_dosen);

            $penguji2 = DosenPenguji::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_penguji', '2']
            ])->first();
            $dosen_penguji2 = Dosen::findOrFail($penguji2->dosen_id_dosen);

            $data = [
                'id' => $sidang_skripsi->id,
                'dosen_penguji1_sidang_skripsi' => [
                    'id' => $penguji1->id,
                    'nama_dosen' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                    'nidn_dosen' => $dosen_penguji1->nidn_dosen
                ],
                'dosen_penguji2_sidang_skripsi' => [
                    'id' => $penguji2->id,
                    'nama_dosen' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen,
                    'nidn_dosen' => $dosen_penguji2->nidn_dosen
                ],
                'waktu_sidang_skripsi' => $sidang_skripsi->waktu_sidang_skripsi,
                'tempat_sidang_skripsi' => $sidang_skripsi->tempat_sidang_skripsi
            ];
            $response = [
                'status'  => 'success',
                'message' => 'Information Waktu Sidang',
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
