<?php

namespace App\Http\Controllers;

use App\FileKrs;
use App\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PersyaratanSkripsiController extends Controller
{
    public function uploadkrs(Request $request)
    {
        $this->validate($request, [
            'file_krs' => 'required|mimes:jpg,jpeg,png|max:2000',
        ]);

        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $data_krs_mahasiswa = FileKrs::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        $data_file_krs = $request->file('file_krs');
        $krs_fileName = 'krs-' . $mahasiswa->npm_mahasiswa . '.' . $data_file_krs->getClientOriginalExtension();

        if (is_null($data_krs_mahasiswa)) {
            $file_krs = new FileKrs([
                'mahasiswa_id_mahasiswa' => $mahasiswa->id,
                'nama_file_krs' => $krs_fileName,
                'statuspersetujuan_admin_prodi_file_krs' => 'Antrian',
            ]);
            $file_krs->save();
            $data_file_krs->move('fileKRS/', $krs_fileName);

            $data = [
                'id' => $file_krs->id,
                'file_krs' => [
                    'nama_file' => $file_krs->nama_file_krs,
                    'url' => 'fileKRS/' . $file_krs->nama_file_krs,
                ],
                'created_at' => $file_krs->created_at->diffForHumans(),
            ];

            $response = [
                'message' => 'File uploaded successfully',
                'file_krs' => $data
            ];
            return response()->json($response, 201);
        } else {
            if ($data_krs_mahasiswa->statuspersetujuan_admin_prodi_file_krs == 'Ditolak') {
                $data_krs_mahasiswa->nama_file_krs = $krs_fileName;
                $data_krs_mahasiswa->statuspersetujuan_admin_prodi_file_krs = 'Antrian';
                $data_krs_mahasiswa->catatan_file_krs = '';
                $data_krs_mahasiswa->update();

                $data = [
                    'id' => $data_krs_mahasiswa->id,
                    'file_krs' => [
                        'nama_file' => $data_krs_mahasiswa->nama_file_krs,
                        'url' => 'fileKRS/' . $data_krs_mahasiswa->nama_file_krs,
                    ],
                    'updated_at' => $data_krs_mahasiswa->updated_at->diffForHumans(),
                ];

                $response = [
                    'message' => 'File updated successfully',
                    'file_krs' => $data
                ];
                return response()->json($response, 200);
            } elseif ($data_krs_mahasiswa->statuspersetujuan_admin_prodi_file_krs == 'Antrian') {
                $response = [
                    'message' => 'detects that you have uploaded a file KRS, please wait for the approval of the admin prodi',
                ];
                return response()->json($response, 409);
            }
            $response = [
                'message' => 'It is detected that the file krs has been approved by the admin prodi, you cannot change the krs file krs',
            ];
            return response()->json($response, 409);
        }
    }

    public function lihat_status_krs()
    {
        $mahasiswa = Mahasiswa::where('user_id_user', Auth::user()->id)->first();
        $file_krs = FileKrs::where('mahasiswa_id_mahasiswa', $mahasiswa->id)->first();

        if (is_null($file_krs)) {
            $response = [
                'message' => 'File KRS Not Found, please upload the file',
            ];
            return response()->json($response, 404);
        }

        $data = [
            'id' => $file_krs->id,
            'file_krs' => [
                'nama_file' => $file_krs->nama_file_krs,
                'url' => 'fileKRS/' . $file_krs->nama_file_krs,
            ],
            'statuspersetujuan_admin_prodi_file_krs' => $file_krs->statuspersetujuan_admin_prodi_file_krs,
            'catatan_file_krs' => $file_krs->catatan_file_krs,
            'created_at' => $file_krs->created_at->diffForHumans(),
        ];
        return response()->json($data, 200);
    }
}
