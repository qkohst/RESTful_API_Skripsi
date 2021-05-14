<?php

namespace App\Http\Controllers;

use App\AdminProdi;
use App\FileKrs;
use App\Mahasiswa;
use App\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersetujuanKRSController extends Controller
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
        $persetujuan_krs = FileKrs::whereIn('mahasiswa_id_mahasiswa', $mahasiswa)
            ->orderBy('status_persetujuan_admin_prodi_file_krs', 'asc')
            ->orderBy('updated_at', 'asc')
            ->get([
                'id',
                'mahasiswa_id_mahasiswa',
                'status_persetujuan_admin_prodi_file_krs',
                'catatan_file_krs',
                'created_at',
            ]);

        foreach ($persetujuan_krs as $krs) {
            $mahasiswa = Mahasiswa::findorfail($krs->mahasiswa_id_mahasiswa);
            $krs->mahasiswa = [
                'id' => $mahasiswa->id,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
            ];
        }

        return response()->json([
            'message' => 'List of Data',
            'persetujuan_krs' => $persetujuan_krs,
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
            $file_krs = FileKrs::findorfail($id);
            $mahasiswa = Mahasiswa::findorfail($file_krs->mahasiswa_id_mahasiswa);

            $data = [
                'id' => $file_krs->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'status_persetujuan_admin_prodi_file_krs' => $file_krs->status_persetujuan_admin_prodi_file_krs,
                'catatan_file_krs' => $file_krs->catatan_file_krs,
                'file' => [
                    'nama_file' => $file_krs->nama_file_krs,
                    'url' => 'fileKRS/' . $file_krs->nama_file_krs
                ],
            ];

            $response = [
                'message' => 'Data details',
                'persetujuan_krs' => $data
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
            'status_persetujuan_admin_prodi_file_krs' => 'required|in:Antrian,Disetujui,Ditolak',
            'catatan_file_krs' => 'required|min:1',
        ]);

        $file_krs = FileKrs::findOrFail($id);
        if ($file_krs->status_persetujuan_admin_prodi_file_krs != 'Disetujui') {
            $file_krs->status_persetujuan_admin_prodi_file_krs = $request->input('status_persetujuan_admin_prodi_file_krs');
            $file_krs->catatan_file_krs = $request->input('catatan_file_krs');
            $file_krs->update();

            $mahasiswa = Mahasiswa::findOrFail($file_krs->mahasiswa_id_mahasiswa);

            $data = [
                'id' => $file_krs->id,
                'mahasiswa' => [
                    'id' => $mahasiswa->id,
                    'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                    'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
                ],
                'status_persetujuan_admin_prodi_file_krs' => $file_krs->status_persetujuan_admin_prodi_file_krs,
                'catatan_file_krs' => $file_krs->catatan_file_krs,
                'updated_at' => $file_krs->updated_at->diffForHumans(),
            ];

            return response()->json([
                'message' => 'verification is successful',
                'persetujuan_krs' => $data,
            ], 200);
        }
        return response()->json([
            'message' => 'the data has been verified, you can not change the verification status'
        ], 400);
    }
}
