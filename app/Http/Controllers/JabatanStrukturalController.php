<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JabatanStruktural;

class JabatanStrukturalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan_struktural = JabatanStruktural::get([
            'id',
            'nama_jabatan_struktural',
            'deskripsi_jabatan_struktural'
        ]);

        $response = [
            'message' => 'List of Data',
            'jabatan_struktural' => $jabatan_struktural
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
            'nama_jabatan_struktural' => 'required|unique:jabatan_struktural|min:5',
            'deskripsi_jabatan_struktural' => 'required',
        ]);

        $jabatan_struktural = new JabatanStruktural([
            'nama_jabatan_struktural' => $request->input('nama_jabatan_struktural'),
            'deskripsi_jabatan_struktural' => $request->input('deskripsi_jabatan_struktural'),
        ]);

        if ($jabatan_struktural->save()) {
            $data = [
                'id' => $jabatan_struktural->id,
                'nama_jabatan_struktural' => $jabatan_struktural->nama_jabatan_struktural,
                'deskripsi_jabatan_struktural' => $jabatan_struktural->deskripsi_jabatan_struktural,
                'created_at' => $jabatan_struktural->created_at->diffForHumans(),
            ];
            $response = [
                'message' => 'Data added successfully',
                'jabatan_struktural' => $data
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
            $jabatan_struktural = JabatanStruktural::findorfail($id);
            $data = [
                'id' => $jabatan_struktural->id,
                'nama_jabatan_struktural' => $jabatan_struktural->nama_jabatan_struktural,
                'deskripsi_jabatan_struktural' => $jabatan_struktural->deskripsi_jabatan_struktural,
                'created_at' => $jabatan_struktural->created_at->diffForHumans(),
                'updated_at' => $jabatan_struktural->updated_at->diffForHumans(),
            ];
            $response = [
                'message' => 'Data details',
                'jabatan_struktural' => $data
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
            'deskripsi_jabatan_struktural' => 'required'
        ]);

        $jabatan_struktural = JabatanStruktural::findorfail($id);

        $jabatan_struktural->deskripsi_jabatan_struktural = $request->input('deskripsi_jabatan_struktural');

        if (!$jabatan_struktural->update()) {
            return response()->json([
                'message' => 'an error occurred while updating the data'
            ], 404);
        }

        $data = [
            'id' => $jabatan_struktural->id,
            'nama_jabatan_struktural' => $jabatan_struktural->nama_jabatan_struktural,
            'deskripsi_jabatan_struktural' => $jabatan_struktural->deskripsi_jabatan_struktural,
            'updated_at' => $jabatan_struktural->updated_at->diffForHumans(),
        ];
        $response = [
            'message' => 'Data Edited Successfully',
            'jabatan_struktural' => $data
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
            $jabatan_struktural = JabatanStruktural::findOrFail($id);
            $jabatan_struktural->delete();
            return response()->json([
                'message' => 'Data with id ' . $jabatan_struktural->id . ' deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'Sorry the data cannot be deleted, there are still data in other tables that are related to this data!'
            ], 400);
        }
    }
}
