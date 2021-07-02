<?php

namespace App\Http\Controllers;

use App\ApiClient;
use Illuminate\Http\Request;
use App\Fakultas;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;



class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Fakultas::get([
            'id',
            'kode_fakultas',
            'nama_fakultas',
            'singkatan_fakultas',
            'status_fakultas'
        ]);

        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'List of Data Fakultas',
            'data' => $data
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
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'kode_fakultas' => 'required|unique:fakultas|numeric|digits:2',
            'nama_fakultas' => 'required|unique:fakultas|min:5',
            'singkatan_fakultas' => 'required|unique:fakultas|min:2',
        ]);

        if ($validator->fails()) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'error',
                'message' => $validator->messages()->all()[0]
            ];
            return response()->json($response, 422);
        }

        $fakultas = new Fakultas([
            'kode_fakultas' => $request->input('kode_fakultas'),
            'nama_fakultas' => $request->input('nama_fakultas'),
            'singkatan_fakultas' => $request->input('singkatan_fakultas'),
            'status_fakultas' => 'Aktif'
        ]);

        if ($fakultas->save()) {
            $data = [
                'id' => $fakultas->id,
                'kode_fakultas' => $fakultas->kode_fakultas,
                'nama_fakultas' => $fakultas->nama_fakultas,
                'singkatan_fakultas' => $fakultas->singkatan_fakultas,
                'status_fakultas' => $fakultas->status_fakultas,
                'created_at' => $fakultas->created_at->diffForHumans(),
            ];
            $response = [
                'status'  => 'success',
                'message' => 'Data added successfully',
                'data' => $data
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

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
            $fakultas = Fakultas::findorfail($id);
            $data = [
                'id' => $fakultas->id,
                'kode_fakultas' => $fakultas->kode_fakultas,
                'nama_fakultas' => $fakultas->nama_fakultas,
                'singkatan_fakultas' => $fakultas->singkatan_fakultas,
                'status_fakultas' => $fakultas->status_fakultas,
            ];
            $response = [
                'status'  => 'success',
                'message' => 'Details Data Fakultas',
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
                'message' => 'Data not found'
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
            'nama_fakultas' => 'required|min:5|unique:fakultas' . ($id ? ",id,$id" : ''),
            'singkatan_fakultas' => 'required|min:2|unique:fakultas' . ($id ? ",id,$id" : ''),
            'status_fakultas' => 'required|in:Aktif,Non Aktif',
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

        $fakultas = Fakultas::findorfail($id);

        $fakultas->nama_fakultas = $request->input('nama_fakultas');
        $fakultas->singkatan_fakultas = $request->input('singkatan_fakultas');
        $fakultas->status_fakultas = $request->input('status_fakultas');

        try {
            $fakultas->update();
            $data = [
                'id' => $fakultas->id,
                'kode_fakultas' => $fakultas->kode_fakultas,
                'nama_fakultas' => $fakultas->nama_fakultas,
                'singkatan_fakultas' => $fakultas->singkatan_fakultas,
                'status_fakultas' => $fakultas->status_fakultas,
                'updated_at' => $fakultas->updated_at->diffForHumans(),
            ];
            $response = [
                'status'  => 'success',
                'message' => 'Data Edited Successfully',
                'data' => $data
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json($response, 200);
        } catch (\Throwable $th) {

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'an error occurred while updating the data'
            ], 409);
        }
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
            $fakultas = Fakultas::findOrFail($id);
            $fakultas->delete();

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data with id ' . $fakultas->id . ' deleted successfully'

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

    public function filter_status_aktif(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $fakultas = Fakultas::where('status_fakultas', 'Aktif')->orderBy('kode_fakultas', 'asc')->get([
            'id',
            'kode_fakultas',
            'nama_fakultas',
            'singkatan_fakultas'
        ]);

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data Fakultas with status active',
            'data' => $fakultas
        ], 200);
    }
}
