<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProgramStudi;
use App\Fakultas;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $program_studi = ProgramStudi::orderBy('kode_program_studi', 'asc')
            ->get('id');

        foreach ($program_studi as $prodi) {
            $data_program_studi = ProgramStudi::findorfail($prodi->id);
            $data_fakultas = Fakultas::findorfail($data_program_studi->fakultas_id_fakultas);
            $prodi->fakultas = [
                'id' => $data_fakultas->id,
                'kode_fakultas' => $data_fakultas->kode_fakultas,
                'nama_fakultas' => $data_fakultas->nama_fakultas
            ];
            $prodi->kode_program_studi = $data_program_studi->kode_program_studi;
            $prodi->nama_program_studi = $data_program_studi->nama_program_studi;
            $prodi->singkatan_program_studi = $data_program_studi->singkatan_program_studi;
            $prodi->status_program_studi = $data_program_studi->status_program_studi;
        }

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        $response = [
            'status'  => 'success',
            'message' => 'List of Data Program Studi',
            'data' => $program_studi,
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
            'fakultas_id_fakultas' => 'required|exists:fakultas,id',
            'kode_program_studi' => 'required|unique:program_studi|numeric|digits:4',
            'nama_program_studi' => 'required|unique:program_studi|min:5',
            'singkatan_program_studi' => 'required|unique:program_studi|min:2',
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


        $program_studi = new ProgramStudi([
            'fakultas_id_fakultas' => $request->input('fakultas_id_fakultas'),
            'kode_program_studi' => $request->input('kode_program_studi'),
            'nama_program_studi' => $request->input('nama_program_studi'),
            'singkatan_program_studi' => $request->input('singkatan_program_studi'),
            'status_program_studi' => 'Aktif'
        ]);

        $fakultas = Fakultas::findorfail($request->input('fakultas_id_fakultas'));

        if ($program_studi->save()) {
            $data = [
                'id' => $program_studi->id,
                'fakultas' => [
                    'id' => $fakultas->id,
                    'kode_fakultas' => $fakultas->kode_fakultas,
                    'nama_fakultas' => $fakultas->nama_fakultas,
                ],
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi,
                'singkatan_program_studi' => $program_studi->singkatan_program_studi,
                'status_program_studi' => $program_studi->status_program_studi,
                'created_at' => $program_studi->created_at->diffForHumans(),
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
            $program_studi = ProgramStudi::findorfail($id);
            $fakultas = Fakultas::findorfail($program_studi->fakultas_id_fakultas);

            $data = [
                'id' => $program_studi->id,
                'fakultas' => [
                    'id' => $fakultas->id,
                    'kode_fakultas' => $fakultas->kode_fakultas,
                    'nama_fakultas' => $fakultas->nama_fakultas
                ],
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi,
                'singkatan_program_studi' => $program_studi->singkatan_program_studi,
                'status_program_studi' => $program_studi->status_program_studi,
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            $response = [
                'status'  => 'success',
                'message' => 'Details Data Program Studi',
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
            'nama_program_studi' => 'required|min:5|unique:program_studi' . ($id ? ",id,$id" : ''),
            'singkatan_program_studi' => 'required|min:2|unique:program_studi' . ($id ? ",id,$id" : ''),
            'status_program_studi' => 'required|in:Aktif,Non Aktif',
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

        $program_studi = ProgramStudi::findorfail($id);

        $program_studi->nama_program_studi = $request->input('nama_program_studi');
        $program_studi->singkatan_program_studi = $request->input('singkatan_program_studi');
        $program_studi->status_program_studi = $request->input('status_program_studi');

        $fakultas = Fakultas::findorfail($program_studi->fakultas_id_fakultas);

        try {
            $program_studi->update();
            $data = [
                'id' => $program_studi->id,
                'fakultas' => [
                    'id' => $fakultas->id,
                    'kode_fakultas' => $fakultas->kode_fakultas,
                    'nama_fakultas' => $fakultas->nama_fakultas,
                ],
                'kode_program_studi' => $program_studi->kode_program_studi,
                'nama_program_studi' => $program_studi->nama_program_studi,
                'singkatan_program_studi' => $program_studi->singkatan_program_studi,
                'status_program_studi' => $program_studi->status_program_studi,
                'updated_at' => $program_studi->updated_at->diffForHumans(),
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
            $program_studi = ProgramStudi::findOrFail($id);
            $program_studi->delete();

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data with id ' . $program_studi->id . ' deleted successfully'
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

    public function filter_by_fakultas(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $fakultas = Fakultas::findorfail($request->fakultas_id_fakultas);
        $program_studi = ProgramStudi::where([
            ['fakultas_id_fakultas', $request->fakultas_id_fakultas],
            ['status_program_studi', 'Aktif']
        ])->orderBy('kode_program_studi', 'asc')->get([
            'id',
            'kode_program_studi',
            'nama_program_studi',
            'singkatan_program_studi'
        ]);

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data program studi at ' . $fakultas->nama_fakultas . ' with an active status',
            'data' => $program_studi
        ], 200);
    }
}
