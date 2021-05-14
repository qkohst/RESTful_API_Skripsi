<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JabatanFungsional;

class JabatanFungsionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan_fungsional = JabatanFungsional::get([
            'id',
            'nama_jabatan_fungsional',
            'deskripsi_jabatan_fungsional'
        ]);

        $response = [
            'message' => 'List of Data',
            'jabatan_fungsional' => $jabatan_fungsional
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
            'nama_jabatan_fungsional' => 'required|unique:jabatan_fungsional|min:5',
            'deskripsi_jabatan_fungsional' => 'required',
        ]);

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
            $response = [
                'message' => 'Data added successfully',
                'jabatan_fungsional' => $data
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
            $jabatan_fungsional = JabatanFungsional::findorfail($id);
            $data = [
                'id' => $jabatan_fungsional->id,
                'nama_jabatan_fungsional' => $jabatan_fungsional->nama_jabatan_fungsional,
                'deskripsi_jabatan_fungsional' => $jabatan_fungsional->deskripsi_jabatan_fungsional,
                'created_at' => $jabatan_fungsional->created_at->diffForHumans(),
                'updated_at' => $jabatan_fungsional->updated_at->diffForHumans(),
            ];
            $response = [
                'message' => 'Data details',
                'jabatan_fungsional' => $data
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
            'deskripsi_jabatan_fungsional' => 'required'
        ]);

        $jabatan_fungsional = JabatanFungsional::findorfail($id);

        $jabatan_fungsional->deskripsi_jabatan_fungsional = $request->input('deskripsi_jabatan_fungsional');

        if (!$jabatan_fungsional->update()) {
            return response()->json([
                'message' => 'an error occurred while updating the data'
            ], 404);
        }

        $data = [
            'id' => $jabatan_fungsional->id,
            'nama_jabatan_fungsional' => $jabatan_fungsional->nama_jabatan_fungsional,
            'deskripsi_jabatan_fungsional' => $jabatan_fungsional->deskripsi_jabatan_fungsional,
            'updated_at' => $jabatan_fungsional->updated_at->diffForHumans(),
        ];
        $response = [
            'message' => 'Data Edited Successfully',
            'jabatan_fungsional' => $data
        ];

        return response()->json($response, 200);
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
            $jabatan_fungsional = JabatanFungsional::findOrFail($id);
            $jabatan_fungsional->delete();
            return response()->json([
                'message' => 'Data with id ' . $jabatan_fungsional->id . ' deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'Sorry the data cannot be deleted, there are still data in other tables that are related to this data!'
            ], 400);
        }
    }
}
