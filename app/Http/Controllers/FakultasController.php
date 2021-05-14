<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fakultas;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Fakultas::get([
            'id',
            'kode_fakultas',
            'nama_fakultas',
            'singkatan_fakultas',
            'status_fakultas'
        ]);

        return response()->json([
            'message' => 'List of Data',
            'fakultas' => $data
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
        $this->validate($request, [
            'kode_fakultas' => 'required|unique:fakultas|numeric|digits:2',
            'nama_fakultas' => 'required|unique:fakultas|min:5',
            'singkatan_fakultas' => 'required|unique:fakultas|min:2',
        ]);

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
                'message' => 'Data added successfully',
                'fakultas' => $data
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
            $fakultas = Fakultas::findorfail($id);
            $data = [
                'id' => $fakultas->id,
                'kode_fakultas' => $fakultas->kode_fakultas,
                'nama_fakultas' => $fakultas->nama_fakultas,
                'singkatan_fakultas' => $fakultas->singkatan_fakultas,
                'status_fakultas' => $fakultas->status_fakultas,
                'created_at' => $fakultas->created_at->diffForHumans(),
                'updated_at' => $fakultas->updated_at->diffForHumans(),
            ];
            $response = [
                'message' => 'Data details',
                'fakultas' => $data
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Data not found'
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
            'nama_fakultas' => 'required|min:5|unique:fakultas' . ($id ? ",id,$id" : ''),
            'singkatan_fakultas' => 'required|min:2|unique:fakultas' . ($id ? ",id,$id" : ''),
            'status_fakultas' => 'required|in:Aktif,Non Aktif',
        ]);

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
                'message' => 'Data Edited Successfully',
                'fakultas' => $data
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
            $fakultas = Fakultas::findOrFail($id);
            $fakultas->delete();
            return response()->json([
                'message' => 'Data with id ' . $fakultas->id . ' deleted successfully'

            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'Sorry the data cannot be deleted, there are still data in other tables that are related to this data!'
            ], 400);
        }
    }

    public function filter_status_aktif()
    {
        $fakultas = Fakultas::where('status_fakultas', 'Aktif')->orderBy('kode_fakultas', 'asc')->get([
            'id',
            'kode_fakultas',
            'nama_fakultas',
            'singkatan_fakultas'
        ]);

        return response()->json([
            'message' => 'Data Fakultas with active status',
            'fakultas' => $fakultas
        ], 200);
    }
}
