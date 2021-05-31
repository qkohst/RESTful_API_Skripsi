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

class PengajuanBimbinganSkripsiController extends Controller
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

        $cek_seminar = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($cek_seminar) || $cek_seminar->status_seminar_proposal != 'Selesai') {
            $response = [
                'message' => 'You are not allowed at this stage, please complete the previous process',
            ];
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
                'nidn_dosen' => $data_dosen->nidn_dosen
            ];
            $bimbingan->topik_bimbingan_skripsi = $data_bimbingan_skripsi->topik_bimbingan_skripsi;
            $bimbingan->status_persetujuan_bimbingan_skripsi = $data_bimbingan_skripsi->status_persetujuan_bimbingan_skripsi;
            $bimbingan->tanggal_pengajuan_bimbingan_skripsi = $data_bimbingan_skripsi->created_at;
        }

        return response()->json([
            'message' => 'List of Data',
            'bimbingan_skripsi' => $bimbingan_skripsi,
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

        $cek_seminar = SeminarProposal::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->first();
        if (is_null($cek_seminar) || $cek_seminar->status_seminar_proposal != 'Selesai') {
            $response = [
                'message' => 'You are not allowed at this stage, please complete the previous process',
            ];
            return response()->json($response, 400);
        }

        $dosen_pembimbing = DosenPembimbing::where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->get('id');
        $cek_status_bimbingan = BimbinganSkripsi::whereIn('dosen_pembimbing_id_dosen_pembimbing', $dosen_pembimbing)
            ->where('status_persetujuan_bimbingan_skripsi', 'Antrian')->first();

        if (is_null($cek_status_bimbingan)) {
            $this->validate($request, [
                'topik_bimbingan_skripsi' => 'required|max:200',
                'nama_file_bimbingan_skripsi' => 'required|mimes:pdf|max:5000',
                'dosen_pembimbing_id_dosen_pembimbing' => 'required|exists:dosen_pembimbing,id'
            ]);

            $cekpembimbing = DosenPembimbing::where([
                ['id', $request->dosen_pembimbing_id_dosen_pembimbing],
                ['judul_skripsi_id_judul_skripsi', $judul_skripsi->id]
            ])->first();

            if (is_null($cekpembimbing)) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'dosen_pembimbing_id_dosen_pembimbing' => [
                            'The selected dosen pembimbing id dosen pembimbing is invalid, please choose another'
                        ]
                    ]
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
            $data_file_skripsi->move('fileSkripsi/', $skripsi_fileName);

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
                'message' => 'File uploaded successfully',
                'bimbingan_skripsi' => $data
            ];
            return response()->json($response, 201);
        }
        $response = [
            'message' => 'please wait for approval from the dosen pembimbing in the previous process, before you re-upload skripsi',
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
                'tanggal_pengajuan_bimbingan_skripsi' => $bimbingan_skripsi->created_at
            ];

            $response = [
                'message' => 'Data details',
                'bimbingan_skripsi' => $data
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
