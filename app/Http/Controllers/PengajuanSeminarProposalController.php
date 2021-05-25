<?php

namespace App\Http\Controllers;

use App\BimbinganProposal;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->validate($request, [
            'file_seminar_proposal' => 'required|mimes:pdf|max:5000',
        ]);

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($judul_skripsi)) {
            $response = [
                'message' => 'You are not allowed at this stage, please complete the process pengajuan judul',
            ];
            return response()->json($response, 400);
        }

        $dosen_pembimbing = DosenPembimbing::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->get('id');
        $bimbingan_proposal = BimbinganProposal::whereIn('dosen_pembimbing_id_dosen_pembimbing', $dosen_pembimbing)->first();
        if (is_null($bimbingan_proposal) || $bimbingan_proposal->status_persetujuan_bimbingan_proposal == 'Antrian') {
            $response = [
                'message' => 'You are not allowed at this stage, please complete the process bimbingan proposal',
            ];
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
            $data_file_seminar_proposal->move('fileSeminar/', $seminar_proposal_fileName);

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

            $response = [
                'message' => 'File uploaded successfully',
                'seminar_proposal' => $data
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
                    'message' => 'File updated successfully',
                    'seminar_proposal' => $data
                ];
                return response()->json($response, 200);
            } elseif ($data_seminar_proposal->persetujuan_pembimbing1_seminar_proposal == 'Antrian' || $data_seminar_proposal->persetujuan_pembimbing2_seminar_proposal == 'Antrian') {
                $response = [
                    'message' => 'please wait for the approval of the dosen pembimbing',
                ];
                return response()->json($response, 409);
            }
            $response = [
                'message' => 'It is detected that the seminar proposal has been approved by the dosen pembimbing, you cannot change data',
            ];
            return response()->json($response, 409);
        }
    }

    public function cek_persetujuan_dosbing()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($judul_skripsi)) {
            $response = [
                'message' => 'Judul Skripsi Not Found, please upload data',
            ];
            return response()->json($response, 404);
        }
        $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($seminar_proposal)) {
            $response = [
                'message' => 'Seminar Proposal Not Found, please upload data',
            ];
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
            'created_at' => $seminar_proposal->created_at
        ];

        return response()->json([
            'message' => 'Submission status',
            'status_persetujuan_dosen_pembimbing' => $data
        ], 200);
    }

    public function cek_penguji_dan_waktu()
    {
        // $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        // $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        // if (is_null($judul_skripsi)) {
        //     $response = [
        //         'message' => 'Judul Skripsi Not Found, please upload data',
        //     ];
        //     return response()->json($response, 404);
        // }
        // $seminar_proposal = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        // if (is_null($seminar_proposal)) {
        //     $response = [
        //         'message' => 'Seminar Proposal Not Found, please upload data',
        //     ];
        //     return response()->json($response, 404);
        // } elseif (is_null($seminar_proposal->waktu_seminar_proposal)) {
        //     $response = [
        //         'message' => 'Data not yet determined',
        //     ];
        //     return response()->json($response, 404);
        // }

    }
}
