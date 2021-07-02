<?php

namespace App\Http\Controllers;

use App\BimbinganProposal;
use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\Fakultas;
use App\ProgramStudi;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PengajuanBimbinganProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        try {
            $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
            $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
            $id_dosen_pembimbing = DosenPembimbing::where('juduL_skripsi_id_judul_skripsi', $judul_skripsi->id)->get('id');

            $bimbingan_proposal = BimbinganProposal::whereIn('dosen_pembimbing_id_dosen_pembimbing', $id_dosen_pembimbing)
                ->orderBy('id', 'desc')
                ->get('id');
            foreach ($bimbingan_proposal as $bimbingan) {
                $data_bimbingan_proposal = BimbinganProposal::findorfail($bimbingan->id);
                $dosen_pembimbing = DosenPembimbing::findorfail($data_bimbingan_proposal->dosen_pembimbing_id_dosen_pembimbing);
                $dosen = Dosen::findorfail($dosen_pembimbing->dosen_id_dosen);

                $bimbingan->dosen_pembimbing = [
                    'id' => $dosen_pembimbing->id,
                    'nama_dosen' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
                    'nidn_dosen' => $dosen->nidn_dosen,
                    'jabatan_dosen_pembimbing' => 'Pembimbing ' . $dosen_pembimbing->jabatan_dosen_pembimbing
                ];
                $bimbingan->file_bimbingan_proposal = [
                    'nama_file' => $data_bimbingan_proposal->nama_file_bimbingan_proposal,
                    'url' => 'fileProposal/' . $data_bimbingan_proposal->nama_file_bimbingan_proposal,
                ];
                $bimbingan->topik_bimbingan_proposal = $data_bimbingan_proposal->topik_bimbingan_proposal;
                $bimbingan->status_persetujuan_bimbingan_proposal = $data_bimbingan_proposal->status_persetujuan_bimbingan_proposal;
                $bimbingan->catatan_bimbingan_proposal = $data_bimbingan_proposal->catatan_bimbingan_proposal;
                $bimbingan->tanggal_pengajuan_bimbingan_proposal = $data_bimbingan_proposal->created_at->format('Y-m-d H:i:s');
            }

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'List of Data Bimbingan Proposal',
                'data' => $bimbingan_proposal,
            ], 200);
        } catch (\Throwable $th) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'You are not allowed at this stage, please complete the process Persyaratan Skripsi',
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($judul_skripsi)) {
            $response = [
                'status'  => 'error',
                'message' => 'You are not allowed at this stage, please complete the previous process',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }

        $dosen_pembimbing = DosenPembimbing::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->get('id');
        $cek_status_bimbingan = BimbinganProposal::whereIn('dosen_pembimbing_id_dosen_pembimbing', $dosen_pembimbing)
            ->where('status_persetujuan_bimbingan_proposal', 'Antrian')->first();

        if (is_null($cek_status_bimbingan)) {
            $validator = Validator::make($request->all(), [
                'topik_bimbingan_proposal' => 'required|max:200',
                'nama_file_bimbingan_proposal' => 'required|mimes:pdf|max:5000',
                'dosen_pembimbing_id_dosen_pembimbing' => 'required|exists:dosen_pembimbing,id'
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

            $cekpembimbing = DosenPembimbing::where([
                ['id', $request->dosen_pembimbing_id_dosen_pembimbing],
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
            ])->first();

            if (is_null($cekpembimbing)) {
                $traffic = new TrafficRequest([
                    'api_client_id' => $api_client->id,
                    'status' => '0',
                ]);
                $traffic->save();

                return response()->json([
                    'status'  => 'error',
                    'message' => 'The selected dosen pembimbing id dosen pembimbing is invalid, please choose another',
                ], 422);
            }

            $data_file_proposal = $request->file('nama_file_bimbingan_proposal');
            $proposal_fileName = 'proposal-' . $mahasiswa->npm_mahasiswa . '_' . date('mdYHis') . '.' . $data_file_proposal->getClientOriginalExtension();
            $bimbingan_proposal = new BimbinganProposal([
                'dosen_pembimbing_id_dosen_pembimbing' => $request->dosen_pembimbing_id_dosen_pembimbing,
                'topik_bimbingan_proposal' => $request->topik_bimbingan_proposal,
                'nama_file_bimbingan_proposal' => $proposal_fileName,
                'status_persetujuan_bimbingan_proposal' => 'Antrian',
            ]);
            $bimbingan_proposal->save();
            $data_file_proposal->move('api/v1/fileProposal/', $proposal_fileName);

            $cekdosen = Dosen::where('id', $cekpembimbing->dosen_id_dosen)->first();

            $data = [
                'id' => $bimbingan_proposal->id,
                'topik_bimbingan_proposal' => $bimbingan_proposal->topik_bimbingan_proposal,
                'dosen_pembimbing' => [
                    'id' => $request->dosen_pembimbing_id_dosen_pembimbing,
                    'nama_dosen_pembimbing' => $cekdosen->nama_dosen . ', ' . $cekdosen->gelar_dosen,
                ],
                'file_proposal' => [
                    'nama_file' => $bimbingan_proposal->nama_file_bimbingan_proposal,
                    'url' => 'fileProposal/' . $bimbingan_proposal->nama_file_bimbingan_proposal,
                ],
                'created_at' => $bimbingan_proposal->created_at->diffForHumans(),
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

            return response()->json($response, 201);
        }
        $response = [
            'status'  => 'error',
            'message' => 'Please wait for approval from the dosen pembimbing in the previous process, before you re-upload proposal skripsi',
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();
        return response()->json($response, 409);
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
            $bimbingan_proposal = BimbinganProposal::findorfail($id);
            $dosen_pembimbing = DosenPembimbing::where('id', $bimbingan_proposal->dosen_pembimbing_id_dosen_pembimbing)->first();
            $dosen = Dosen::where('id', $dosen_pembimbing->dosen_id_dosen)->first();

            $data = [
                'id' => $bimbingan_proposal->id,
                'topik_bimbingan_proposal' => $bimbingan_proposal->topik_bimbingan_proposal,
                'dosen_pembimbing' => [
                    'id' => $dosen_pembimbing->id,
                    'nama_dosen_pembimbing' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
                    'nidn_dosen_pembimbing' => $dosen->nidn_dosen
                ],
                'file_bimbingan_proposal' => [
                    'nama_file' => $bimbingan_proposal->nama_file_bimbingan_proposal,
                    'url' => 'fileProposal/' . $bimbingan_proposal->nama_file_bimbingan_proposal,
                ],
                'status_bimbingan_proposal' => $bimbingan_proposal->status_persetujuan_bimbingan_proposal,
                'catatan_bimbingan_proposal' => $bimbingan_proposal->catatan_bimbingan_proposal,
                'tanggal_pengajuan_bimbingan_proposal' => $bimbingan_proposal->created_at->format('Y-m-d H:i:s'),
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Bimbingan Proposal',
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

    public function beritaacara(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();
        try {
            $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
            $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);
            $fakultas = Fakultas::findorfail($program_studi->fakultas_id_fakultas);
            $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

            // Bimbingan Pembimbing 1 
            $id_dosen_pembimbing_1 = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_pembimbing', 1]
            ])->first();
            $dosen_pembimbing_1 = Dosen::findorfail($id_dosen_pembimbing_1->dosen_id_dosen);

            $bimbingan_proposal_pembimbing_1 = BimbinganProposal::where('dosen_pembimbing_id_dosen_pembimbing', $id_dosen_pembimbing_1->id)
                ->orderBy('created_at', 'asc')
                ->get('id');

            foreach ($bimbingan_proposal_pembimbing_1 as $bimbingan_1) {
                $data_bimbingan_proposal_1 = BimbinganProposal::findorfail($bimbingan_1->id);

                $bimbingan_1->topik_bimbingan_proposal = $data_bimbingan_proposal_1->topik_bimbingan_proposal;
                $bimbingan_1->status_persetujuan_bimbingan_proposal = $data_bimbingan_proposal_1->status_persetujuan_bimbingan_proposal;
                $bimbingan_1->tanggal_pengajuan_bimbingan_proposal = $data_bimbingan_proposal_1->created_at->format('Y-m-d');
            }

            // Bimbingan Pembimbing 2
            $id_dosen_pembimbing_2 = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_pembimbing', 2]
            ])->first();
            $dosen_pembimbing_2 = Dosen::findorfail($id_dosen_pembimbing_2->dosen_id_dosen);

            $bimbingan_proposal_pembimbing_2 = BimbinganProposal::where('dosen_pembimbing_id_dosen_pembimbing', $id_dosen_pembimbing_2->id)
                ->orderBy('created_at', 'asc')
                ->get('id');

            foreach ($bimbingan_proposal_pembimbing_2 as $bimbingan_2) {
                $data_bimbingan_proposal_2 = BimbinganProposal::findorfail($bimbingan_2->id);

                $bimbingan_2->topik_bimbingan_proposal = $data_bimbingan_proposal_2->topik_bimbingan_proposal;
                $bimbingan_2->status_persetujuan_bimbingan_proposal = $data_bimbingan_proposal_2->status_persetujuan_bimbingan_proposal;
                $bimbingan_2->tanggal_pengajuan_bimbingan_proposal = $data_bimbingan_proposal_2->created_at->format('Y-m-d');
            }

            $data = [
                'id' => $mahasiswa->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                ],
                'judul_skripsi' => [
                    'id' => $judul_skripsi->id,
                    'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi,
                    'tanggal_pengajuan_judul_skripsi' => $judul_skripsi->created_at->format('Y-m-d H:i:s'),
                ],
                'program_studi' => [
                    'id' => $program_studi->id,
                    'nama_program_studi' => $program_studi->nama_program_studi,
                    'fakultas_program_studi' => $fakultas->nama_fakultas,
                ],
                'data_bimbingan_proposal' => [
                    'dosen_pembimbing_1' => [
                        'dosen' => [
                            'id' => $dosen_pembimbing_1->id,
                            'nama_dosen' => $dosen_pembimbing_1->nama_dosen . ', ' . $dosen_pembimbing_1->gelar_dosen,
                            'nidn_dosen' => $dosen_pembimbing_1->nidn_dosen
                        ],
                        'data_bimbingan'=> $bimbingan_proposal_pembimbing_1,
                    ],
                    'dosen_pembimbing_2' => [
                        'dosen' => [
                            'id' => $dosen_pembimbing_2->id,
                            'nama_dosen' => $dosen_pembimbing_2->nama_dosen . ', ' . $dosen_pembimbing_2->gelar_dosen,
                            'nidn_dosen' => $dosen_pembimbing_2->nidn_dosen
                        ],
                        'data_bimbingan'=> $bimbingan_proposal_pembimbing_2,
                    ]
                ]
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Berita Acara Bimbingan Proposal',
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'You are not allowed at this stage, please complete the process Persyaratan Skripsi',
            ], 400);
        }
    }
}
