<?php

namespace App\Http\Controllers;

use App\AdminProdi;
use App\Dosen;
use App\DosenPembimbing;
use App\DosenPenguji;
use App\JudulSkripsi;
use App\Mahasiswa;
use App\ProgramStudi;
use App\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            $seminar->persetujuan_pembimbing_seminar_proposal = 'Disetujui';
            if (is_null($seminar->waktu_seminar_proposal)) {
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
                } else {
                    $seminar->penguji_dan_waktu_seminar_proposal = 'Menunggu Persetujuan Penguji';
                }
            }
            $seminar->created_at = $data_seminar_proposal->created_at;
        }

        return response()->json([
            'message' => 'List of Data',
            'seminar_proposal' => $seminar_proposal,
        ], 200);
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
                'pembimbing1_seminar_proposal' => $dosen_pembimbing1->nama_dosen . ', ' . $dosen_pembimbing1->gelar_dosen,
                'pembimbing2_seminar_proposal' => $dosen_pembimbing2->nama_dosen . ', ' . $dosen_pembimbing2->gelar_dosen
            ];

            $response = [
                'message' => 'Data details',
                'seminar_proposal' => $data
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Data not found',
            ];

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
        $this->validate($request, [
            'id_dosen_penguji1_seminar_proposal' => 'required|exists:dosen,id',
            'id_dosen_penguji2_seminar_proposal' => 'required|exists:dosen,id',
            'waktu_seminar_proposal' => 'required|date_format:Y-m-d H:i:s|after:today',
            'tempat_seminar_proposal' => 'required|min:3'
        ]);

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
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'id_dosen_penguji1_seminar_proposal' => ['The selected id dosen penguji1 seminar proposal is invalid.']
                ]
            ], 422);
        }
        if ($request->id_dosen_penguji2_seminar_proposal == $dosen_pembimbing1->dosen_id_dosen || $request->id_dosen_penguji2_seminar_proposal == $dosen_pembimbing2->dosen_id_dosen) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'id_dosen_penguji2_seminar_proposal' => ['The selected id dosen penguji2 seminar proposal is invalid.']
                ]
            ], 422);
        }
        if ($request->id_dosen_penguji1_seminar_proposal == $request->id_dosen_penguji2_seminar_proposal) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'id_dosen_penguji2_seminar_proposal' => ['The selected id dosen penguji2 seminar proposal is invalid.']
                ]
            ], 422);
        }

        //Cek apakah data dosenpenguji sudah ada ?
        if (DB::table('dosen_penguji')->where('judul_skripsi_id_judul_skripsi', $judul_skripsi->id)->doesntExist()) {
            $seminar_proposal->waktu_seminar_proposal = $request->waktu_seminar_proposal;
            $seminar_proposal->tempat_seminar_proposal = $request->tempat_seminar_proposal;
            $seminar_proposal->status_seminar_proposal = 'Belum Mulai';
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
                'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal,
                'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal,
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
                'updated_at' => $seminar_proposal->updated_at
            ];

            $response = [
                'message' => 'Data created successfully',
                'seminar_proposal' => $data
            ];
            return response()->json($response, 201);
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
                'message' => 'The submission has been approved by dosen penguji 1 and dosen penguji 2, you cannot change data.',
            ];
            return response()->json($response, 400);
        } elseif ($cek_status_penguji1->persetujuan_dosen_penguji == 'Antrian' || $cek_status_penguji2->persetujuan_dosen_penguji == 'Antrian') {
            $response = [
                'message' => 'Please wait for the approval of the dosen penguji',
            ];
            return response()->json($response, 409);
        }
        $seminar_proposal->waktu_seminar_proposal = $request->waktu_seminar_proposal;
        $seminar_proposal->tempat_seminar_proposal = $request->tempat_seminar_proposal;
        $seminar_proposal->status_seminar_proposal = 'Belum Mulai';
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
            'waktu_seminar_proposal' => $seminar_proposal->waktu_seminar_proposal,
            'tempat_seminar_proposal' => $seminar_proposal->tempat_seminar_proposal,
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
            'updated_at' => $seminar_proposal->updated_at
        ];

        $response = [
            'message' => 'Data updated successfully',
            'seminar_proposal' => $data
        ];
        return response()->json($response, 200);
    }

    public function cek_persetujuan_penguji($id)
    {
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
                'message' => 'Submission status',
                'persetujuan_penguji' => $data
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
