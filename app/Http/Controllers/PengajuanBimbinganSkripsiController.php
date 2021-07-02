<?php

namespace App\Http\Controllers;

use App\BimbinganSkripsi;
use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\Fakultas;
use App\ProgramStudi;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PengajuanBimbinganSkripsiController extends Controller
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

            $cek_seminar = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
            if (is_null($cek_seminar) || $cek_seminar->status_seminar_proposal != 'Selesai') {
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

            $id_dosen_pembimbing = DosenPembimbing::where('juduL_skripsi_id_judul_skripsi', $judul_skripsi->id)->get('id');
            $bimbingan_skripsi = BimbinganSkripsi::whereIn('dosen_pembimbing_id_dosen_pembimbing', $id_dosen_pembimbing)
                ->orderBy('id', 'desc')
                ->get('id');
            foreach ($bimbingan_skripsi as $bimbingan) {
                $data_bimbingan_skripsi = BimbinganSkripsi::findorfail($bimbingan->id);
                $data_dosen_pembimbing = DosenPembimbing::findorfail($data_bimbingan_skripsi->dosen_pembimbing_id_dosen_pembimbing);
                $data_dosen = Dosen::findorfail($data_dosen_pembimbing->dosen_id_dosen);

                $bimbingan->dosen_pembimbing = [
                    'id' => $data_dosen_pembimbing->id,
                    'nama_dosen' => $data_dosen->nama_dosen . ', ' . $data_dosen->gelar_dosen,
                    'nidn_dosen' => $data_dosen->nidn_dosen,
                    'jabatan_dosen_pembimbing' => 'Pembimbing ' . $data_dosen_pembimbing->jabatan_dosen_pembimbing

                ];
                $bimbingan->file_bimbingan_skripsi = [
                    'nama_file' => $data_bimbingan_skripsi->nama_file_bimbingan_skripsi,
                    'url' => 'fileSkripsi/' . $data_bimbingan_skripsi->nama_file_bimbingan_skripsi,
                ];
                $bimbingan->topik_bimbingan_skripsi = $data_bimbingan_skripsi->topik_bimbingan_skripsi;
                $bimbingan->status_persetujuan_bimbingan_skripsi = $data_bimbingan_skripsi->status_persetujuan_bimbingan_skripsi;
                $bimbingan->catatan_bimbingan_skripsi = $data_bimbingan_skripsi->catatan_bimbingan_skripsi;
                $bimbingan->tanggal_pengajuan_bimbingan_skripsi = $data_bimbingan_skripsi->created_at->format('Y-m-d H:i:s');
            }
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'List of Data Bimbingan Skripsi',
                'data' => $bimbingan_skripsi,
            ], 200);
        } catch (\Throwable $th) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'You are not allowed at this stage, please complete the process previous process',
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

        $cek_seminar = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($cek_seminar) || $cek_seminar->status_seminar_proposal != 'Selesai') {
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
        $cek_status_bimbingan = BimbinganSkripsi::whereIn('dosen_pembimbing_id_dosen_pembimbing', $dosen_pembimbing)
            ->where('status_persetujuan_bimbingan_skripsi', 'Antrian')->first();

        if (is_null($cek_status_bimbingan)) {
            $validator = Validator::make($request->all(), [
                'topik_bimbingan_skripsi' => 'required|max:200',
                'nama_file_bimbingan_skripsi' => 'required|mimes:pdf|max:5000',
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

            $data_file_skripsi = $request->file('nama_file_bimbingan_skripsi');
            $skripsi_fileName = 'skripsi-' . $mahasiswa->npm_mahasiswa . '_' . date('mdYHis') . '.' . $data_file_skripsi->getClientOriginalExtension();
            $bimbingan_skripsi = new BimbinganSkripsi([
                'dosen_pembimbing_id_dosen_pembimbing' => $request->dosen_pembimbing_id_dosen_pembimbing,
                'topik_bimbingan_skripsi' => $request->topik_bimbingan_skripsi,
                'nama_file_bimbingan_skripsi' => $skripsi_fileName,
                'status_persetujuan_bimbingan_skripsi' => 'Antrian',
            ]);
            $bimbingan_skripsi->save();
            $data_file_skripsi->move('api/v1/fileSkripsi/', $skripsi_fileName);

            $cekdosen = Dosen::where('id', $cekpembimbing->dosen_id_dosen)->first();

            $data = [
                'id' => $bimbingan_skripsi->id,
                'topik_bimbingan_skripsi' => $bimbingan_skripsi->topik_bimbingan_skripsi,
                'dosen_pembimbing' => [
                    'id' => $request->dosen_pembimbing_id_dosen_pembimbing,
                    'nama_dosen_pembimbing' => $cekdosen->nama_dosen . ', ' . $cekdosen->gelar_dosen,
                ],
                'file_skripsi' => [
                    'nama_file' => $bimbingan_skripsi->nama_file_bimbingan_skripsi,
                    'url' => 'fileSkripsi/' . $bimbingan_skripsi->nama_file_bimbingan_skripsi,
                ],
                'created_at' => $bimbingan_skripsi->created_at->diffForHumans(),
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
            'message' => 'Please wait for approval from the dosen pembimbing in the previous process, before you re-upload skripsi',
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
            $bimbingan_skripsi = BimbinganSkripsi::findorfail($id);
            $dosen_pembimbing = DosenPembimbing::where('id', $bimbingan_skripsi->dosen_pembimbing_id_dosen_pembimbing)->first();
            $dosen = Dosen::where('id', $dosen_pembimbing->dosen_id_dosen)->first();

            $data = [
                'id' => $bimbingan_skripsi->id,
                'topik_bimbingan_skripsi' => $bimbingan_skripsi->topik_bimbingan_skripsi,
                'dosen_pembimbing' => [
                    'id' => $dosen_pembimbing->id,
                    'nama_dosen_pembimbing' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
                    'nidn_dosen_pembimbing' => $dosen->nidn_dosen
                ],
                'file_bimbingan_skripsi' => [
                    'nama_file' => $bimbingan_skripsi->nama_file_bimbingan_skripsi,
                    'url' => 'fileSkripsi/' . $bimbingan_skripsi->nama_file_bimbingan_skripsi,
                ],
                'status_bimbingan_skripsi' => $bimbingan_skripsi->status_persetujuan_bimbingan_skripsi,
                'catatan_bimbingan_skripsi' => $bimbingan_skripsi->catatan_bimbingan_skripsi,
                'tanggal_pengajuan_bimbingan_skripsi' => $bimbingan_skripsi->created_at->format('Y-m-d H:i:s'),
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Bimbingan Skripsi',
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

            $bimbingan_skripsi_pembimbing_1 = BimbinganSkripsi::where('dosen_pembimbing_id_dosen_pembimbing', $id_dosen_pembimbing_1->id)
                ->orderBy('created_at', 'asc')
                ->get('id');

            foreach ($bimbingan_skripsi_pembimbing_1 as $bimbingan_1) {
                $data_bimbingan_skripsi_1 = BimbinganSkripsi::findorfail($bimbingan_1->id);

                $bimbingan_1->topik_bimbingan_skripsi = $data_bimbingan_skripsi_1->topik_bimbingan_skripsi;
                $bimbingan_1->status_persetujuan_bimbingan_skripsi = $data_bimbingan_skripsi_1->status_persetujuan_bimbingan_skripsi;
                $bimbingan_1->tanggal_pengajuan_bimbingan_skripsi = $data_bimbingan_skripsi_1->created_at->format('Y-m-d');
            }

            // Bimbingan Pembimbing 2
            $id_dosen_pembimbing_2 = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_pembimbing', 2]
            ])->first();
            $dosen_pembimbing_2 = Dosen::findorfail($id_dosen_pembimbing_2->dosen_id_dosen);

            $bimbingan_skripsi_pembimbing_2 = BimbinganSkripsi::where('dosen_pembimbing_id_dosen_pembimbing', $id_dosen_pembimbing_2->id)
                ->orderBy('created_at', 'asc')
                ->get('id');

            foreach ($bimbingan_skripsi_pembimbing_2 as $bimbingan_2) {
                $data_bimbingan_skripsi_2 = BimbinganSkripsi::findorfail($bimbingan_2->id);

                $bimbingan_2->topik_bimbingan_skripsi = $data_bimbingan_skripsi_2->topik_bimbingan_skripsi;
                $bimbingan_2->status_persetujuan_bimbingan_skripsi = $data_bimbingan_skripsi_2->status_persetujuan_bimbingan_skripsi;
                $bimbingan_2->tanggal_pengajuan_bimbingan_skripsi = $data_bimbingan_skripsi_2->created_at->format('Y-m-d');
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
                'data_bimbingan_skripsi' => [
                    'dosen_pembimbing_1' => [
                        'dosen' => [
                            'id' => $dosen_pembimbing_1->id,
                            'nama_dosen' => $dosen_pembimbing_1->nama_dosen . ', ' . $dosen_pembimbing_1->gelar_dosen,
                            'nidn_dosen' => $dosen_pembimbing_1->nidn_dosen
                        ],
                        'data_bimbingan'=> $bimbingan_skripsi_pembimbing_1,
                    ],
                    'dosen_pembimbing_2' => [
                        'dosen' => [
                            'id' => $dosen_pembimbing_2->id,
                            'nama_dosen' => $dosen_pembimbing_2->nama_dosen . ', ' . $dosen_pembimbing_2->gelar_dosen,
                            'nidn_dosen' => $dosen_pembimbing_2->nidn_dosen
                        ],
                        'data_bimbingan'=> $bimbingan_skripsi_pembimbing_2,
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
                'message' => 'Berita Acara Bimbingan Skripsi',
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
                'message' => 'You are not allowed at this stage.',
            ], 400);
        }
    }
}
