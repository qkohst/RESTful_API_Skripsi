<?php

namespace App\Http\Controllers;

use App\AdminProdi;
use App\FileKrs;
use App\Mahasiswa;
use App\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class PersetujuanKRSController extends Controller
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
        $persetujuan_krs = FileKrs::whereIn('mahasiswa_id_mahasiswa', $mahasiswa)
            ->orderBy('status_persetujuan_admin_prodi_file_krs', 'asc')
            ->orderBy('updated_at', 'asc')
            ->get('id');

        foreach ($persetujuan_krs as $krs) {
            $data_file_krs = FileKrs::findorfail($krs->id);
            $mahasiswa = Mahasiswa::findorfail($data_file_krs->mahasiswa_id_mahasiswa);
            $krs->mahasiswa = [
                'id' => $mahasiswa->id,
                'npm_mahasiswa' => $mahasiswa->npm_mahasiswa,
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa
            ];
            $krs->file_krs = [
                'nama_file' => $data_file_krs->nama_file_krs,
                'url' => 'fileKRS/' . $data_file_krs->nama_file_krs,
            ];
            $krs->tanggal_pengajuan_file_krs = $data_file_krs->created_at->format('Y-m-d H:i:s');
            $krs->status_persetujuan_admin_prodi_file_krs = $data_file_krs->status_persetujuan_admin_prodi_file_krs;
            $krs->catatan_file_krs = $data_file_krs->catatan_file_krs;
        }
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Persetujuan KRS',
            'data' => $persetujuan_krs,
        ], 200);
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
                'status'  => 'success',
                'message' => 'Details Persetujuan KRS',
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
            'status_persetujuan_admin_prodi_file_krs' => 'required|in:Antrian,Disetujui,Ditolak',
            'catatan_file_krs' => 'required|min:1',
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
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Verification is successful',
                'data' => $data,
            ], 200);
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'error',
            'message' => 'the data has been verified, you can not change the verification status'
        ], 400);
    }
}
