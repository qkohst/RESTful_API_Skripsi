<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JabatanFungsional;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;


class JabatanFungsionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $jabatan_fungsional = JabatanFungsional::orderby('nama_jabatan_fungsional', 'asc')->get([
            'id',
            'nama_jabatan_fungsional',
            'deskripsi_jabatan_fungsional'
        ]);

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        $response = [
            'status'  => 'success',
            'message' => 'List of Data Jabatan Fungsional',
            'data' => $jabatan_fungsional
        ];
        return response()->json($response, 200);
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

        $validator = Validator::make($request->all(), [
            'nama_jabatan_fungsional' => 'required|unique:jabatan_fungsional|min:5',
            'deskripsi_jabatan_fungsional' => 'required',
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


        $jabatan_fungsional = new JabatanFungsional([
            'nama_jabatan_fungsional' => $request->input('nama_jabatan_fungsional'),
            'deskripsi_jabatan_fungsional' => $request->input('deskripsi_jabatan_fungsional'),
        ]);

        if ($jabatan_fungsional->save()) {
            $data = [
                'id' => $jabatan_fungsional->id,
                'nama_jabatan_fungsional' => $jabatan_fungsional->nama_jabatan_fungsional,
                'deskripsi_jabatan_fungsional' => $jabatan_fungsional->deskripsi_jabatan_fungsional,
                'created_at' => $jabatan_fungsional->created_at->diffForHumans(),
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'success',
                'message' => 'Data added successfully',
                'data' => $data
            ];
            return response()->json($response, 201);
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '0',
        ]);
        $traffic->save();

        $response = [
            'status'  => 'error',
            'message' => 'an error occurred while saving the data'
        ];
        return response()->json($response, 404);
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
            $jabatan_fungsional = JabatanFungsional::findorfail($id);
            $data = [
                'id' => $jabatan_fungsional->id,
                'nama_jabatan_fungsional' => $jabatan_fungsional->nama_jabatan_fungsional,
                'deskripsi_jabatan_fungsional' => $jabatan_fungsional->deskripsi_jabatan_fungsional,
            ];
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Jabatan Fungsional',
                'data' => $data
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'error',
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
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'deskripsi_jabatan_fungsional' => 'required'
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

        $jabatan_fungsional = JabatanFungsional::findorfail($id);

        $jabatan_fungsional->deskripsi_jabatan_fungsional = $request->input('deskripsi_jabatan_fungsional');

        if (!$jabatan_fungsional->update()) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'an error occurred while updating the data'
            ], 404);
        }

        $data = [
            'id' => $jabatan_fungsional->id,
            'nama_jabatan_fungsional' => $jabatan_fungsional->nama_jabatan_fungsional,
            'deskripsi_jabatan_fungsional' => $jabatan_fungsional->deskripsi_jabatan_fungsional,
            'updated_at' => $jabatan_fungsional->updated_at->diffForHumans(),
        ];
        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        $response = [
            'status'  => 'success',
            'message' => 'Data Edited Successfully',
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        try {
            $jabatan_fungsional = JabatanFungsional::findOrFail($id);
            $jabatan_fungsional->delete();
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data with id ' . $jabatan_fungsional->id . ' deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry the data cannot be deleted, there are still data in other tables that are related to this data!'
            ], 400);
        }
    }
}
