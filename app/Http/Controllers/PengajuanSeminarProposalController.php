<?php

namespace App\Http\Controllers;

use App\BimbinganProposal;
use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PengajuanSeminarProposalController extends Controller
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
            'file_seminar_proposal' => 'required|mimes:pdf|max:5000',
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
        $bimbingan_proposal = BimbinganProposal::whereIn('dosen_pembimbing_id_dosen_pembimbing', $dosen_pembimbing)
            ->orderBy('created_at', 'desc')
            ->first();
        if (is_null($bimbingan_proposal) || $bimbingan_proposal->status_persetujuan_bimbingan_proposal == 'Antrian') {
            $response = [
                'status'  => 'error',
                'message' => 'You are not allowed at this stage, please complete the process bimbingan proposal',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 400);
        }
        $data_seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();

        $data_file_seminar_proposal = $request->file('file_seminar_proposal');
        $seminar_proposal_fileName = 'seminar-' . $mahasiswa->npm_mahasiswa . '.' . $data_file_seminar_proposal->getClientOriginalExtension();

        if (is_null($data_seminar_proposal)) {
            $seminar_proposal = new SeminarProposal([
                'judul_skripsi_id_judul_skripsi' => $judul_skripsi->id,
                'file_seminar_proposal' => $seminar_proposal_fileName,
                'persetujuan_pembimbing1_seminar_proposal' => 'Antrian',
                'persetujuan_pembimbing2_seminar_proposal' => 'Antrian',
                'status_seminar_proposal' => 'Pengajuan',
            ]);
            $seminar_proposal->save();
            $data_file_seminar_proposal->move('api/v1/fileSeminar/', $seminar_proposal_fileName);

            $data = [
                'id' => $seminar_proposal->id,
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                ],
                'file_seminar_proposal' => [
                    'nama_file' => $seminar_proposal->file_seminar_proposal,
                    'url' => 'fileSeminar/' . $seminar_proposal->file_seminar_proposal,
                ],
                'status_seminar_proposal' => $seminar_proposal->status_seminar_proposal,
                'created_at' => $seminar_proposal->created_at->diffForHumans(),
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
            if ($data_seminar_proposal->persetujuan_pembimbing1_seminar_proposal == 'Ditolak' || $data_seminar_proposal->persetujuan_pembimbing2_seminar_proposal == 'Ditolak') {
                $data_seminar_proposal->file_seminar_proposal = $seminar_proposal_fileName;
                $data_seminar_proposal->persetujuan_pembimbing1_seminar_proposal = 'Antrian';
                $data_seminar_proposal->catatan_pembimbing1_seminar_proposal = '';
                $data_seminar_proposal->persetujuan_pembimbing2_seminar_proposal = 'Antrian';
                $data_seminar_proposal->catatan_pembimbing2_seminar_proposal = '';
                $data_seminar_proposal->update();
                $data_file_seminar_proposal->move('api/v1/fileSeminar/', $seminar_proposal_fileName);

                $data = [
                    'id' => $data_seminar_proposal->id,
                    'judul_skripsi' => [
                        'id' => $judul_skripsi->id,
                        'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
                    ],
                    'file_seminar_proposal' => [
                        'nama_file' => $data_seminar_proposal->file_seminar_proposal,
                        'url' => 'fileSeminar/' . $data_seminar_proposal->file_seminar_proposal,
                    ],
                    'status_seminar_proposal' => $data_seminar_proposal->status_seminar_proposal,
                    'created_at' => $data_seminar_proposal->created_at->diffForHumans(),
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
            } elseif ($data_seminar_proposal->persetujuan_pembimbing1_seminar_proposal == 'Antrian' || $data_seminar_proposal->persetujuan_pembimbing2_seminar_proposal == 'Antrian') {
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
                'message' => 'It is detected that the seminar proposal has been approved by the dosen pembimbing, you cannot change data',
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
        $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($seminar_proposal)) {
            $response = [
                'status'  => 'error',
                'message' => 'Seminar Proposal Not Found, please upload data',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 404);
        }
        $data = [
            'id' => $seminar_proposal->id,
            'judul_skripsi' => [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi
            ],
            'persetujuan_pembimbing1_seminar_proposal' => $seminar_proposal->persetujuan_pembimbing1_seminar_proposal,
            'catatan_pembimbing1_seminar_proposal' => $seminar_proposal->catatan_pembimbing1_seminar_proposal,
            'persetujuan_pembimbing2_seminar_proposal' => $seminar_proposal->persetujuan_pembimbing2_seminar_proposal,
            'catatan_pembimbing2_seminar_proposal' => $seminar_proposal->catatan_pembimbing2_seminar_proposal,
            'tanggal_pengajuan_seminar_proposal' => $seminar_proposal->created_at->format('Y-m-d H:i:s'),
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

    public function cek_penguji_dan_waktu(Request $request)
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
        $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($seminar_proposal)) {
            $response = [
                'status'  => 'error',
                'message' => 'Seminar Proposal Not Found, please upload data',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 404);
        } elseif (is_null($seminar_proposal->waktu_seminar_proposal)) {
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

            if ($penguji1->persetujuan_dosen_penguji == 'Disetujui' && $penguji2->persetujuan_dosen_penguji == 'Disetujui') {
                $data = [
                    'id' => $seminar_proposal->id,
                    'dosen_penguji1_seminar_proposal' => [
                        'id' => $penguji1->id,
                        'nama_dosen' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                        'nidn_dosen' => $dosen_penguji1->nidn_dosen
                    ],
                    'dosen_penguji2_seminar_proposal' => [
                        'id' => $penguji2->id,
                        'nama_dosen' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen,
                        'nidn_dosen' => $dosen_penguji2->nidn_dosen
                    ],
                    'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal,
                    'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal
                ];
                $response = [
                    'status'  => 'success',
                    'message' => 'Information of Penguji & Waktu Seminar',
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
                    'message' => 'Waiting for the approval process from dosen penguji',
                ];
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();
                return response()->json($response, 400);
            }
        }
    }
}
