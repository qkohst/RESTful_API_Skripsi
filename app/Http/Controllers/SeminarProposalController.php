<?php

namespace App\Http\Controllers;

use App\AdminProdi;
use Illuminate\Support\Carbon;
use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\HasilSeminarProposal;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\ProgramStudi;
use App\Fakultas;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class SeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $admin_prodi = AdminProdi::where('user_id_user', Auth::user()->id)->first();
        $program_studi = ProgramStudi::where('id', $admin_prodi->program_studi_id_program_studi)->first();

        $mahasiswa = Mahasiswa::where('program_studi_id_program_studi', $program_studi->id)->get('id');
        $judul_skripsi = JudulSkripsi::whereIn('mahasiswa_id_mahasiswa', $mahasiswa)->get('id');
        $seminar_proposal = SeminarProposal::whereIn('judul_skripsi_id_judul_skripsi', $judul_skripsi)
            ->where([
                ['persetujuan_pembimbing1_seminar_proposal', 'Disetujui'],
                ['persetujuan_pembimbing2_seminar_proposal', 'Disetujui']
            ])
            ->orderBy('status_seminar_proposal', 'asc')
            ->orderBy('updated_at', 'asc')
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
                'url' => 'fileSeminar/' . $data_seminar_proposal->file_seminar_proposal,
            ];

            if (is_null($data_seminar_proposal->waktu_seminar_proposal)) {
                $seminar->status_seminar_proposal = 'Pengajuan';
            } elseif ($data_seminar_proposal->waktu_seminar_proposal > Carbon::now() && $data_seminar_proposal->status_seminar_proposal == 'Proses') {
                $seminar->status_seminar_proposal = 'Belum Mulai';
            } elseif ($data_seminar_proposal->waktu_seminar_proposal <= Carbon::now() && $data_seminar_proposal->status_seminar_proposal == 'Proses') {
                $seminar->status_seminar_proposal = 'Sedang Berlangsung';
            } elseif ($data_seminar_proposal->status_seminar_proposal == 'Selesai') {
                $seminar->status_seminar_proposal = 'Selesai';
            }

            if (is_null($data_seminar_proposal->waktu_seminar_proposal)) {
                $seminar->penguji_dan_waktu_seminar_proposal = 'Belum Ditentukan';
            } else {
                $data_dosen_penguji1 = DosenPenguji::where([
                    ['judul_skripsi_id_judul_skripsi', $data_judul_skripsi->id],
                    ['jabatan_dosen_penguji', '1']
                ])->first();
                $data_dosen_penguji2 = DosenPenguji::where([
                    ['judul_skripsi_id_judul_skripsi', $data_judul_skripsi->id],
                    ['jabatan_dosen_penguji', '2']
                ])->first();
                if ($data_dosen_penguji1->persetujuan_dosen_penguji == 'Disetujui' && $data_dosen_penguji2->persetujuan_dosen_penguji == 'Disetujui') {
                    $seminar->penguji_dan_waktu_seminar_proposal = 'Telah Ditentukan';
                } elseif ($data_dosen_penguji1->persetujuan_dosen_penguji == 'Ditolak' || $data_dosen_penguji2->persetujuan_dosen_penguji == 'Ditolak') {
                    $seminar->penguji_dan_waktu_seminar_proposal = 'Ditolak Penguji';
                } else {
                    $seminar->penguji_dan_waktu_seminar_proposal = 'Menunggu Persetujuan Penguji';
                }
            }
            $seminar->tanggal_pengajuan_seminar_proposal = $data_seminar_proposal->created_at->format('Y-m-d H:i:s');
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
    public function show(Request $request,  $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        try {
            $seminar_proposal = SeminarProposal::findorfail($id);
            $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
            $pembimbing1 = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_pembimbing', '1']
            ])->first();
            $dosen_pembimbing1 = Dosen::findorfail($pembimbing1->dosen_id_dosen);

            $pembimbing2 = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_pembimbing', '2']
            ])->first();
            $dosen_pembimbing2 = Dosen::findorfail($pembimbing2->dosen_id_dosen);

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
                    'url' => 'fileSeminar/' . $seminar_proposal->file_seminar_proposal,
                ],
                'pembimbing1_seminar_proposal' => $dosen_pembimbing1->nama_dosen . ', ' . $dosen_pembimbing1->gelar_dosen,
                'pembimbing2_seminar_proposal' => $dosen_pembimbing2->nama_dosen . ', ' . $dosen_pembimbing2->gelar_dosen
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
            'id_dosen_penguji1_seminar_proposal' => 'required|exists:dosen,id',
            'id_dosen_penguji2_seminar_proposal' => 'required|exists:dosen,id',
            'waktu_seminar_proposal' => 'required|after:today',
            'tempat_seminar_proposal' => 'required|min:3'
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

        if ($request->id_dosen_penguji1_seminar_proposal == $request->id_dosen_penguji2_seminar_proposal) {
            $response = [
                'status'  => 'error',
                'message' => 'The selected id dosen penguji1 seminar proposal and id dosen penguji2 seminar proposal is duplicate.'
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 422);
        }

        $seminar_proposal = SeminarProposal::findOrFail($id);
        $judul_skripsi = JudulSkripsi::findOrFail($seminar_proposal->judul_skripsi_id_judul_skripsi);
        $mahasiswa = Mahasiswa::findOrFail($judul_skripsi->mahasiswa_id_mahasiswa);
        $dosen_pembimbing1 = DosenPembimbing::where([
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
            ['jabatan_dosen_pembimbing', '1']
        ])->first();
        $dosen_pembimbing2 = DosenPembimbing::where([
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
            ['jabatan_dosen_pembimbing', '2']
        ])->first();

        if ($request->id_dosen_penguji1_seminar_proposal == $dosen_pembimbing1->dosen_id_dosen || $request->id_dosen_penguji1_seminar_proposal == $dosen_pembimbing2->dosen_id_dosen) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'The selected id dosen penguji1 seminar proposal is invalid.',
            ], 422);
        }
        if ($request->id_dosen_penguji2_seminar_proposal == $dosen_pembimbing1->dosen_id_dosen || $request->id_dosen_penguji2_seminar_proposal == $dosen_pembimbing2->dosen_id_dosen) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'The selected id dosen penguji2 seminar proposal is invalid.',
            ], 422);
        }

        //Cek apakah data dosenpenguji sudah ada ?
        if (DB::table('dosen_penguji')->where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->doesntExist()) {
            $seminar_proposal->waktu_seminar_proposal = $request->waktu_seminar_proposal;
            $seminar_proposal->tempat_seminar_proposal = $request->tempat_seminar_proposal;
            $seminar_proposal->status_seminar_proposal = 'Proses';
            $seminar_proposal->update();

            $penguji1 = new DosenPenguji([
                'judul_skripsi_id_judul_skripsi' => $judul_skripsi->id,
                'dosen_id_dosen' => $request->id_dosen_penguji1_seminar_proposal,
                'jabatan_dosen_penguji' => '1',
                'status_dosen_penguji' => 'Antrian'
            ]);
            $penguji1->save();
            $penguji2 = new DosenPenguji([
                'judul_skripsi_id_judul_skripsi' => $judul_skripsi->id,
                'dosen_id_dosen' => $request->id_dosen_penguji2_seminar_proposal,
                'jabatan_dosen_penguji' => '2',
                'status_dosen_penguji' => 'Antrian'
            ]);
            $penguji2->save();

            $dosen_penguji1 = Dosen::findOrFail($penguji1->dosen_id_dosen);
            $dosen_penguji2 = Dosen::findOrFail($penguji2->dosen_id_dosen);

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
                'dosen_penguji1_seminar_proposal' => [
                    'id' => $dosen_penguji1->id,
                    'nama_dosen_penguji1_seminar_proposal' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                    'nidn_dosen_penguji1_seminar_proposal' => $dosen_penguji1->nidn_dosen,
                    'status_penguji1_seminar_proposal' => 'Antrian'
                ],
                'dosen_penguji2_seminar_proposal' => [
                    'id' => $dosen_penguji2->id,
                    'nama_dosen_penguji2_seminar_proposal' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen,
                    'nidn_dosen_penguji2_seminar_proposal' => $dosen_penguji2->nidn_dosen,
                    'status_penguji2_seminar_proposal' => 'Antrian'
                ],
                'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal,
                'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal,
                'updated_at' => $seminar_proposal->updated_at
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Data created successfully',
                'data' => $data
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json($response, 200);
        }
        $cek_status_penguji1 = DosenPenguji::where([
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
            ['jabatan_dosen_penguji', '1']
        ])->first();
        $cek_status_penguji2 = DosenPenguji::where([
            ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
            ['jabatan_dosen_penguji', '2']
        ])->first();

        if ($cek_status_penguji1->persetujuan_dosen_penguji == 'Disetujui' && $cek_status_penguji2->persetujuan_dosen_penguji == 'Disetujui') {
            $response = [
                'status'  => 'error',
                'message' => 'The submission has been approved by dosen penguji 1 and dosen penguji 2, you cannot change data.',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 400);
        } elseif ($cek_status_penguji1->persetujuan_dosen_penguji == 'Antrian' && $cek_status_penguji2->persetujuan_dosen_penguji == 'Antrian') {
            $response = [
                'status'  => 'error',
                'message' => 'Please wait for the approval of the dosen penguji',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 409);
        } elseif ($cek_status_penguji1->persetujuan_dosen_penguji == 'Ditolak' || $cek_status_penguji2->persetujuan_dosen_penguji == 'Ditolak') {
            $seminar_proposal->waktu_seminar_proposal = $request->waktu_seminar_proposal;
            $seminar_proposal->tempat_seminar_proposal = $request->tempat_seminar_proposal;
            $seminar_proposal->status_seminar_proposal = 'Proses';
            $seminar_proposal->update();

            $cek_status_penguji1->dosen_id_dosen = $request->id_dosen_penguji1_seminar_proposal;
            $cek_status_penguji1->persetujuan_dosen_penguji = 'Antrian';
            $cek_status_penguji1->update();

            $cek_status_penguji2->dosen_id_dosen = $request->id_dosen_penguji2_seminar_proposal;
            $cek_status_penguji2->persetujuan_dosen_penguji = 'Antrian';
            $cek_status_penguji2->update();

            $dosen_penguji1 = Dosen::findOrFail($cek_status_penguji1->dosen_id_dosen);
            $dosen_penguji2 = Dosen::findOrFail($cek_status_penguji2->dosen_id_dosen);
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
                'dosen_penguji1_seminar_proposal' => [
                    'id' => $dosen_penguji1->id,
                    'nama_dosen_penguji1_seminar_proposal' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                    'nidn_dosen_penguji1_seminar_proposal' => $dosen_penguji1->nidn_dosen,
                    'status_penguji1_seminar_proposal' => 'Antrian'
                ],
                'dosen_penguji2_seminar_proposal' => [
                    'id' => $dosen_penguji2->id,
                    'nama_dosen_penguji2_seminar_proposal' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen,
                    'nidn_dosen_penguji2_seminar_proposal' => $dosen_penguji2->nidn_dosen,
                    'status_penguji2_seminar_proposal' => 'Antrian'
                ],
                'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal,
                'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal,
                'updated_at' => $seminar_proposal->updated_at
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Data updated successfully',
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


    public function cek_persetujuan_penguji(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        try {
            $seminar_proposal = SeminarProposal::findorfail($id);
            $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
            $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);

            $pembimbing1 = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_pembimbing', '1']
            ])->first();
            $dosen_pembimbing1 = Dosen::findorfail($pembimbing1->dosen_id_dosen);
            $pembimbing2 = DosenPembimbing::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_pembimbing', '2']
            ])->first();
            $dosen_pembimbing2 = Dosen::findorfail($pembimbing2->dosen_id_dosen);

            $penguji1 = DosenPenguji::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_penguji', '1']
            ])->first();
            $dosen_penguji1 = Dosen::findorfail($penguji1->dosen_id_dosen);
            $penguji2 = DosenPenguji::where([
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id],
                ['jabatan_dosen_penguji', '2']
            ])->first();
            $dosen_penguji2 = Dosen::findorfail($penguji2->dosen_id_dosen);

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
                'dosen_pembimbing1' => [
                    'id' => $pembimbing1->id,
                    'nidn_dosen_pembimbing1' => $dosen_pembimbing1->nidn_dosen,
                    'nama_dosen_pembimbing1' => $dosen_pembimbing1->nama_dosen . ', ' . $dosen_pembimbing1->gelar_dosen
                ],
                'dosen_pembimbing2' => [
                    'id' => $pembimbing2->id,
                    'nidn_dosen_pembimbing2' => $dosen_pembimbing2->nidn_dosen,
                    'nama_dosen_pembimbing2' => $dosen_pembimbing2->nama_dosen . ', ' . $dosen_pembimbing2->gelar_dosen
                ],
                'dosen_penguji1' => [
                    'id' => $penguji1->id,
                    'nidn_dosen_penguji1' => $dosen_penguji1->nidn_dosen,
                    'nama_dosen_penguji1' => $dosen_penguji1->nama_dosen . ', ' . $dosen_penguji1->gelar_dosen,
                    'persetujuan_dosen_penguji1' => $penguji1->persetujuan_dosen_penguji
                ],
                'dosen_penguji2' => [
                    'id' => $penguji2->id,
                    'nidn_dosen_penguji2' => $dosen_penguji2->nidn_dosen,
                    'nama_dosen_penguji2' => $dosen_penguji2->nama_dosen . ', ' . $dosen_penguji2->gelar_dosen,
                    'persetujuan_dosen_penguji2' => $penguji2->persetujuan_dosen_penguji
                ],
                'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal,
                'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal
            ];

            $response = [
                'status'  => 'success',
                'message' => 'Submission status',
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

    public function hasil_seminar(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $seminar_proposal = SeminarProposal::findorfail($id);
        $hasil_seminar = HasilSeminarProposal::where('seminar_proposal_id_seminar', $seminar_proposal->id)->get('id');
        if ($hasil_seminar->count() == 4) {
            foreach ($hasil_seminar as $hasil) {
                $data_hasil_seminar = HasilSeminarProposal::findorfail($hasil->id);
                $data_dosen = Dosen::findorfail($data_hasil_seminar->dosen_id_dosen);
                $hasil->nama_dosen_seminar_proposal = $data_dosen->nama_dosen . ', ' . $data_dosen->gelar_dosen;
                $hasil->status_dosen_seminar_proposal = $data_hasil_seminar->jenis_dosen_hasil_seminar_proposal;
                $hasil->status_verifikasi_dosen_seminar_proposal = $data_hasil_seminar->status_verifikasi_hasil_seminar_proposal;
            }
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Details Data Hasil Seminar',
                'data' => $hasil_seminar,
            ], 200);
        }
        $response = [
            'status'  => 'error',
            'message' => 'Incomplete data, please wait until the verification process is complete',
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();

        return response()->json($response, 404);
    }

    public function verifikasi_seminar(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $seminar_proposal = SeminarProposal::findorfail($id);
        if ($seminar_proposal->status_seminar_proposal == 'Selesai') {
            $response = [
                'status'  => 'error',
                'message' => 'Seminar Proposal has been verified',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }

        $hasil_seminar = HasilSeminarProposal::where('seminar_proposal_id_seminar', $seminar_proposal->id)->get();
        if ($hasil_seminar->count() != 4) {
            $response = [
                'status'  => 'error',
                'message' => 'Incomplete data, please wait until the process verification pembimbing & penguji',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json($response, 400);
        }
        $cek_hasil_pembimbing1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 1']
        ])->first();
        $cek_hasil_pembimbing2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 2']
        ])->first();
        $cek_hasil_penguji1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 1']
        ])->first();
        $cek_hasil_penguji2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 2']
        ])->first();

        if ($cek_hasil_pembimbing1->status_verifikasi_hasil_seminar_proposal == 'Lulus Seminar' && $cek_hasil_pembimbing2->status_verifikasi_hasil_seminar_proposal == 'Lulus Seminar' && $cek_hasil_penguji1->status_verifikasi_hasil_seminar_proposal == 'Lulus Seminar' && $cek_hasil_penguji2->status_verifikasi_hasil_seminar_proposal == 'Lulus Seminar') {
            $seminar_proposal->status_seminar_proposal = 'Selesai';
            $seminar_proposal->update();
            $response = [
                'status'  => 'success',
                'message' => 'Verification of the seminar proposal with id ' . $seminar_proposal->id . ' was successful',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();
            return response()->json($response, 200);
        }
        $response = [
            'status'  => 'error',
            'message' => 'Incomplete data, please wait until the verification process is complete',
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();
        return response()->json($response, 400);
    }

    public function daftar_nilai(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $seminar_proposal = SeminarProposal::findorfail($id);
        $judul_skripsi = JudulSkripsi::findorfail($seminar_proposal->judul_skripsi_id_judul_skripsi);
        $mahasiswa = Mahasiswa::findorfail($judul_skripsi->mahasiswa_id_mahasiswa);
        $program_studi = ProgramStudi::findorfail($mahasiswa->program_studi_id_program_studi);
        $fakultas = Fakultas::findorfail($program_studi->fakultas_id_fakultas);


        $nilai_pembimbing1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 1']
        ])->first();

        $nilai_pembimbing2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Pembimbing 2']
        ])->first();

        $nilai_penguji1 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 1']
        ])->first();

        $nilai_penguji2 = HasilSeminarProposal::where([
            ['seminar_proposal_id_seminar', $seminar_proposal->id],
            ['jenis_dosen_hasil_seminar_proposal', 'Penguji 2']
        ])->first();

        if (is_null($nilai_pembimbing1) || is_null($nilai_pembimbing2) || is_null($nilai_penguji1) || is_null($nilai_penguji2)) {
            $response = [
                'status'  => 'error',
                'message' => 'the verification process by the dosen pembimbing and penguji has not been completed',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 400);
        } elseif ($nilai_pembimbing1->status_verifikasi_hasil_seminar_proposal == 'Revisi' || $nilai_pembimbing2->status_verifikasi_hasil_seminar_proposal == 'Revisi' || $nilai_penguji1->status_verifikasi_hasil_seminar_proposal == 'Revisi' || $nilai_penguji2->status_verifikasi_hasil_seminar_proposal == 'Revisi') {
            $response = [
                'status'  => 'error',
                'message' => 'Incomplete data, please wait for the input process to complete',
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();
            return response()->json($response, 400);
        }
        $dosen_pembimbing1 = Dosen::findOrFail($nilai_pembimbing1->dosen_id_dosen);
        $dosen_pembimbing2 = Dosen::findOrFail($nilai_pembimbing2->dosen_id_dosen);
        $dosen_penguji1 = Dosen::findOrFail($nilai_penguji1->dosen_id_dosen);
        $dosen_penguji2 = Dosen::findOrFail($nilai_penguji2->dosen_id_dosen);

        //hitung nilai akhir
        $rata2_nilaia_pembimbing1 = ($nilai_pembimbing1->nilai_a1_hasil_seminar_proposal + $nilai_pembimbing1->nilai_a2_hasil_seminar_proposal + $nilai_pembimbing1->nilai_a3_hasil_seminar_proposal) / 3;
        $rata2_nilaia_pembimbing2 = ($nilai_pembimbing2->nilai_a1_hasil_seminar_proposal + $nilai_pembimbing2->nilai_a2_hasil_seminar_proposal + $nilai_pembimbing2->nilai_a3_hasil_seminar_proposal) / 3;

        $rata2_nilaib_pembimbing1 = ((15 * $nilai_pembimbing1->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_pembimbing1->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_pembimbing1->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_pembimbing1->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_pembimbing1->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_pembimbing1->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_pembimbing1->nilai_b7_hasil_seminar_proposal)) / 100;
        $rata2_nilaib_pembimbing2 = ((15 * $nilai_pembimbing2->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_pembimbing2->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_pembimbing2->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_pembimbing2->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_pembimbing2->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_pembimbing2->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_pembimbing2->nilai_b7_hasil_seminar_proposal)) / 100;

        $rata2_nilaic_pembimbing1 = ((20 * $nilai_pembimbing1->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_pembimbing1->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_pembimbing1->nilai_c3_hasil_seminar_proposal)) / 100;
        $rata2_nilaic_pembimbing2 = ((20 * $nilai_pembimbing2->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_pembimbing2->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_pembimbing2->nilai_c3_hasil_seminar_proposal)) / 100;

        $rata2_nilaib_penguji1 = ((15 * $nilai_penguji1->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_penguji1->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_penguji1->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_penguji1->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_penguji1->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_penguji1->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_penguji1->nilai_b7_hasil_seminar_proposal)) / 100;
        $rata2_nilaib_penguji2 = ((15 * $nilai_penguji2->nilai_b1_hasil_seminar_proposal) + (15 * $nilai_penguji2->nilai_b2_hasil_seminar_proposal) + (15 * $nilai_penguji2->nilai_b3_hasil_seminar_proposal) + (15 * $nilai_penguji2->nilai_b4_hasil_seminar_proposal) + (20 * $nilai_penguji2->nilai_b5_hasil_seminar_proposal) + (10 * $nilai_penguji2->nilai_b6_hasil_seminar_proposal) + (10 * $nilai_penguji2->nilai_b7_hasil_seminar_proposal)) / 100;

        $rata2_nilaic_penguji1 = ((20 * $nilai_penguji1->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_penguji1->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_penguji1->nilai_c3_hasil_seminar_proposal)) / 100;
        $rata2_nilaic_penguji2 = ((20 * $nilai_penguji2->nilai_c1_hasil_seminar_proposal) + (50 * $nilai_penguji2->nilai_c2_hasil_seminar_proposal) + (30 * $nilai_penguji2->nilai_c3_hasil_seminar_proposal)) / 100;

        $rata2_nilaia = ($rata2_nilaia_pembimbing1 + $rata2_nilaia_pembimbing2) / 2;
        $rata2_nilaib = ($rata2_nilaib_pembimbing1 + $rata2_nilaib_pembimbing2 + $rata2_nilaib_penguji1 + $rata2_nilaib_penguji2) / 4;
        $rata2_nilaic = ($rata2_nilaic_pembimbing1 + $rata2_nilaic_pembimbing2 + $rata2_nilaic_penguji1 + $rata2_nilaic_penguji2) / 4;

        $nilai_akhir = ((20 * $rata2_nilaia) + (30 * $rata2_nilaib) + (50 * $rata2_nilaic)) / 100;
        //akhir hitung nilai

        $data = [
            'id' => $seminar_proposal->id,
            'mahasiswa' => [
                'id' => $mahasiswa->id,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
            ],
            'program_studi' => [
                'id' => $program_studi->id,
                'fakultas_program_studi' => $fakultas->nama_fakultas,
                'nama_program_studi' => $program_studi->nama_program_studi,
            ],
            'judul_skripsi' => [
                'id' => $judul_skripsi->id,
                'nama_judul_skripsi' => $judul_skripsi->nama_judul_skripsi,
            ],
            'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal,
            'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal,
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
                    'jumlah_nilai_a_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_a1_hasil_seminar_proposal + $nilai_pembimbing1->nilai_a2_hasil_seminar_proposal + $nilai_pembimbing1->nilai_a3_hasil_seminar_proposal,
                    'rata2_nilai_a_hasil_seminar_proposal' => round($rata2_nilaia_pembimbing1, 0),
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
                    'jumlah_nilai_b_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_b1_hasil_seminar_proposal + $nilai_pembimbing1->nilai_b2_hasil_seminar_proposal + $nilai_pembimbing1->nilai_b3_hasil_seminar_proposal + $nilai_pembimbing1->nilai_b4_hasil_seminar_proposal + $nilai_pembimbing1->nilai_b5_hasil_seminar_proposal + $nilai_pembimbing1->nilai_b6_hasil_seminar_proposal + $nilai_pembimbing1->nilai_b7_hasil_seminar_proposal,
                    'rata2_nilai_b_hasil_seminar_proposal' => round($rata2_nilaib_pembimbing1, 0),
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_seminar_proposal' => 'Nilai Pelaksanaan Seminar Proposal',
                    'nilai_c1_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_c3_hasil_seminar_proposal,
                    'jumlah_nilai_c_hasil_seminar_proposal' => $nilai_pembimbing1->nilai_c1_hasil_seminar_proposal + $nilai_pembimbing1->nilai_c2_hasil_seminar_proposal + $nilai_pembimbing1->nilai_c3_hasil_seminar_proposal,
                    'rata2_nilai_c_hasil_seminar_proposal' => round($rata2_nilaic_pembimbing2, 0),
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
                    'jumlah_nilai_a_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_a1_hasil_seminar_proposal + $nilai_pembimbing2->nilai_a2_hasil_seminar_proposal + $nilai_pembimbing2->nilai_a3_hasil_seminar_proposal,
                    'rata2_nilai_a_hasil_seminar_proposal' => round($rata2_nilaia_pembimbing2, 0),
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
                    'jumlah_nilai_b_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_b1_hasil_seminar_proposal + $nilai_pembimbing2->nilai_b2_hasil_seminar_proposal + $nilai_pembimbing2->nilai_b3_hasil_seminar_proposal + $nilai_pembimbing2->nilai_b4_hasil_seminar_proposal + $nilai_pembimbing2->nilai_b5_hasil_seminar_proposal + $nilai_pembimbing2->nilai_b6_hasil_seminar_proposal + $nilai_pembimbing2->nilai_b7_hasil_seminar_proposal,
                    'rata2_nilai_b_hasil_seminar_proposal' => round($rata2_nilaib_pembimbing2, 0),
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_seminar_proposal' => 'Nilai Pelaksanaan Seminar Proposal',
                    'nilai_c1_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_c3_hasil_seminar_proposal,
                    'jumlah_nilai_c_hasil_seminar_proposal' => $nilai_pembimbing2->nilai_c1_hasil_seminar_proposal + $nilai_pembimbing2->nilai_c2_hasil_seminar_proposal + $nilai_pembimbing2->nilai_c3_hasil_seminar_proposal,
                    'rata2_nilai_c_hasil_seminar_proposal' => round($rata2_nilaic_pembimbing2, 0),
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
                    'jumlah_nilai_b_hasil_seminar_proposal' => $nilai_penguji1->nilai_b1_hasil_seminar_proposal + $nilai_penguji1->nilai_b2_hasil_seminar_proposal + $nilai_penguji1->nilai_b3_hasil_seminar_proposal + $nilai_penguji1->nilai_b4_hasil_seminar_proposal + $nilai_penguji1->nilai_b5_hasil_seminar_proposal + $nilai_penguji1->nilai_b6_hasil_seminar_proposal + $nilai_penguji1->nilai_b7_hasil_seminar_proposal,
                    'rata2_nilai_b_hasil_seminar_proposal' => round($rata2_nilaib_penguji1, 0),
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_seminar_proposal' => 'Nilai Pelaksanaan Seminar Proposal',
                    'nilai_c1_hasil_seminar_proposal' => $nilai_penguji1->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $nilai_penguji1->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $nilai_penguji1->nilai_c3_hasil_seminar_proposal,
                    'jumlah_nilai_c_hasil_seminar_proposal' => $nilai_penguji1->nilai_c1_hasil_seminar_proposal + $nilai_penguji1->nilai_c2_hasil_seminar_proposal + $nilai_penguji1->nilai_c3_hasil_seminar_proposal,
                    'rata2_nilai_c_hasil_seminar_proposal' => round($rata2_nilaic_penguji1, 0),
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
                    'jumlah_nilai_b_hasil_seminar_proposal' => $nilai_penguji2->nilai_b1_hasil_seminar_proposal + $nilai_penguji2->nilai_b2_hasil_seminar_proposal + $nilai_penguji2->nilai_b3_hasil_seminar_proposal + $nilai_penguji2->nilai_b4_hasil_seminar_proposal + $nilai_penguji2->nilai_b5_hasil_seminar_proposal + $nilai_penguji2->nilai_b6_hasil_seminar_proposal + $nilai_penguji2->nilai_b7_hasil_seminar_proposal,
                    'rata2_nilai_b_hasil_seminar_proposal' => round($rata2_nilaib_penguji2, 0),
                ],
                'nilai_c' => [
                    'deskripsi_nilai_c_hasil_seminar_proposal' => 'Nilai Pelaksanaan Seminar Proposal',
                    'nilai_c1_hasil_seminar_proposal' => $nilai_penguji2->nilai_c1_hasil_seminar_proposal,
                    'nilai_c2_hasil_seminar_proposal' => $nilai_penguji2->nilai_c2_hasil_seminar_proposal,
                    'nilai_c3_hasil_seminar_proposal' => $nilai_penguji2->nilai_c3_hasil_seminar_proposal,
                    'jumlah_nilai_c_hasil_seminar_proposal' => $nilai_penguji2->nilai_c1_hasil_seminar_proposal + $nilai_penguji2->nilai_c2_hasil_seminar_proposal + $nilai_penguji2->nilai_c3_hasil_seminar_proposal,
                    'rata2_nilai_c_hasil_seminar_proposal' => round($rata2_nilaic_penguji2, 0),
                ]
            ],
            'rekap_nilai' => [
                'rata2_nilai_a_hasil_seminar_proposal' => round($rata2_nilaia, 0),
                'rata2_nilai_b_hasil_seminar_proposal' => round($rata2_nilaib, 0),
                'rata2_nilai_c_hasil_seminar_proposal' => round($rata2_nilaic, 0),
                'jumlah_rata2_nilai_hasil_seminar_proposal' => round($rata2_nilaia+$rata2_nilaib+$rata2_nilaic, 0),
                'nilai_akhir_hasil_seminar_proposal' => round($nilai_akhir, 0),
            ]
        ];

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Nilai Seminar Proposal',
            'data' => $data,
        ], 200);
    }
}
