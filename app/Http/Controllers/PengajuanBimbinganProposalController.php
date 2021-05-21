<?php

namespace App\Http\Controllers;

use App\BimbinganProposal;
use App\Dosen;
use App\DosenPembimbing;
use App\JudulSkripsi;
use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanBimbinganProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();
        $bimbingan_proposal = BimbinganProposal::where('dosen_pembimbing_judul_skripsi_id', $judul_skripsi->id)
            ->orderBy('id', 'desc')
            ->get([
                'id',
                'dosen_pembimbing_judul_skripsi_id',
                'dosen_pembimbing_dosen_id',
                'topik_bimbingan_proposal',
                'status_persetujuan_bimbingan_proposal',
                'created_at'
            ]);
        foreach ($bimbingan_proposal as $bimbingan) {
            $dosen_pembimbing = DosenPembimbing::where([
                ['dosen_id_dosen', $bimbingan->dosen_pembimbing_dosen_id],
                ['judul_skripsi_id_judul_skripsi', $bimbingan->dosen_pembimbing_judul_skripsi_id],
            ])->first();
            $dosen = Dosen::findorfail($dosen_pembimbing->dosen_id_dosen);

            $bimbingan->dosen_pembimbing = [
                'id' => $dosen_pembimbing->id,
                'nama_dosen' => $dosen->nama_dosen . ', ' . $dosen->gelar_dosen,
                'nidn_dosen' => $dosen->nidn_dosen,
                'jabatan_dosen_pembimbing' => $dosen_pembimbing->jabatan_dosen_pembimbing
            ];
        }

        return response()->json([
            'message' => 'List of Data',
            'bimbingan_proposal' => $bimbingan_proposal,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $judul_skripsi = JudulSkripsi::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($judul_skripsi)) {
            $response = [
                'message' => 'You are not allowed at this stage, please complete the previous process',
            ];
            return response()->json($response, 400);
        }
        $cek_status_bimbingan = BimbinganProposal::where([
            ['dosen_pembimbing_judul_skripsi_id', $judul_skripsi->id],
            ['status_persetujuan_bimbingan_proposal', 'Antrian'],
        ])->first();
        
        if (is_null($cek_status_bimbingan)) {
            $this->validate($request, [
                'topik_bimbingan_proposal' => 'required|max:200',
                'nama_file_bimbingan_proposal' => 'required|mimes:pdf|max:5000',
                'dosen_pembimbing_dosen_id' => 'required|exists:dosen,id'
            ]);
            $cekdosen = Dosen::where('id', $request->dosen_pembimbing_dosen_id)->first();
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

            $cekpembimbing = DosenPembimbing::where([
                ['dosen_id_dosen', $cekdosen->id],
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
            ])->first();
            if (is_null($cekpembimbing)) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'dosen_id_dosen' => [
                            'The selected dosen id dosen is invalid, please choose another'
                        ]
                    ]
                ], 422);
            }

            $data_file_proposal = $request->file('nama_file_bimbingan_proposal');
            $proposal_fileName = 'proposal-' . $mahasiswa->npm_mahasiswa . '_' . date('mdYHis') . '.' . $data_file_proposal->getClientOriginalExtension();
            $bimbingan_proposal = new BimbinganProposal([
                'dosen_pembimbing_judul_skripsi_id' => $judul_skripsi->id,
                'dosen_pembimbing_dosen_id' => $request->dosen_pembimbing_dosen_id,
                'topik_bimbingan_proposal' => $request->topik_bimbingan_proposal,
                'nama_file_bimbingan_proposal' => $proposal_fileName,
                'status_persetujuan_bimbingan_proposal' => 'Antrian',
            ]);
            $bimbingan_proposal->save();
            $data_file_proposal->move('fileProposal/', $proposal_fileName);

            $data = [
                'id' => $bimbingan_proposal->id,
                'topik_bimbingan_proposal' => $bimbingan_proposal->topik_bimbingan_proposal,
                'dosen_pembimbing' => [
                    'id' => $request->dosen_pembimbing_dosen_id,
                    'nama_dosen_pembimbing' => $cekdosen->nama_dosen . ', ' . $cekdosen->gelar_dosen,
                ],
                'file_proposal' => [
                    'nama_file' => $bimbingan_proposal->nama_file_bimbingan_proposal,
                    'url' => 'fileProposal/' . $bimbingan_proposal->nama_file_bimbingan_proposal,
                ],
                'created_at' => $bimbingan_proposal->created_at->diffForHumans(),
            ];
            $response = [
                'message' => 'File uploaded successfully',
                'bimbingan_proposal' => $data
            ];
            return response()->json($response, 201);
        }
        $response = [
            'message' => 'please wait for approval from the dosen pembimbing in the previous process, before you re-upload proposal skripsi',
        ];
        return response()->json($response, 409);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $bimbingan_proposal = BimbinganProposal::findorfail($id);
            $dosen_pembimbing = Dosen::where('id', $bimbingan_proposal->dosen_pembimbing_dosen_id)->first();

            $data = [
                'id' => $bimbingan_proposal->id,
                'topik_bimbingan_proposal' => $bimbingan_proposal->topik_bimbingan_proposal,
                'dosen_pembimbing' => [
                    'id' => $dosen_pembimbing->id,
                    'nama_dosen_pembimbing' => $dosen_pembimbing->nama_dosen . ', ' . $dosen_pembimbing->gelar_dosen,
                    'nidn_dosen_pembimbing' => $dosen_pembimbing->nidn_dosen
                ],
                'file_bimbingan_proposal' => [
                    'nama_file' => $bimbingan_proposal->nama_file_bimbingan_proposal,
                    'url' => 'fileProposal/' . $bimbingan_proposal->nama_file_bimbingan_proposal,
                ],
                'status_bimbingan_proposal' => $bimbingan_proposal->status_persetujuan_bimbingan_proposal,
                'catatan_bimbingan_proposal' => $bimbingan_proposal->catatan_bimbingan_proposal,
                'created_at' => $bimbingan_proposal->created_at
            ];

            $response = [
                'message' => 'Data details',
                'bimbingan_proposal' => $data
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Data not found',
            ];

            return response()->json($response, 404);
        }
    }
}
