<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProgramStudi;
use App\Fakultas;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $program_studi = ProgramStudi::get([
            'id',
            'fakultas_id_fakultas',
            'kode_program_studi',
            'nama_program_studi',
            'singkatan_program_studi',
            'status_program_studi',
        ]);

        foreach ($program_studi as $data_program_studi) {

            $data_fakultas = Fakultas::findorfail($data_program_studi->fakultas_id_fakultas);
            $data_program_studi->fakultas = [
                'id' => $data_fakultas->id,
                'nama_fakultas' => $data_fakultas->nama_fakultas
            ];
        }

        $response = [
            'message' => 'List of Data',
            'program_studi' => $program_studi,
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
        $this->validate($request, [
            'fakultas_id_fakultas' => 'required|exists:fakultas,id',
            'kode_program_studi' => 'required|unique:program_studi|numeric|digits:4',
            'nama_program_studi' => 'required|unique:program_studi|min:5',
            'singkatan_program_studi' => 'required|unique:program_studi|min:2',
        ]);

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

            $response = [
                'message' => 'Data added successfully',
                'program_studi' => $data
            ];
            return response()->json($response, 201);
        }

        $response = [
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
    public function show($id)
    {
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
                'created_at' => $program_studi->created_at->diffForHumans(),
                'updated_at' => $program_studi->updated_at->diffForHumans(),
            ];

            $response = [
                'message' => 'Data details',
                'program_studi' => $data
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
            'nama_program_studi' => 'required|min:5|unique:program_studi' . ($id ? ",id,$id" : ''),
            'singkatan_program_studi' => 'required|min:2|unique:program_studi' . ($id ? ",id,$id" : ''),
            'status_program_studi' => 'required|in:Aktif,Non Aktif',
        ]);

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

            $response = [
                'message' => 'Data Edited Successfully',
                'program_studi' => $data
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
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
    public function destroy($id)
    {
        try {
            $program_studi = ProgramStudi::findOrFail($id);
            $program_studi->delete();
            return response()->json([
                'message' => 'Data with id ' . $program_studi->id . ' deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'Sorry the data cannot be deleted, there are still data in other tables that are related to this data!'
            ], 404);
        }
    }

    public function filter_by_fakultas(Request $request)
    {
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

        return response()->json([
            'message' => 'Data program studi at ' . $fakultas->nama_fakultas . ' with an active status',
            'program_studi' => $program_studi
        ], 200);
    }
}
