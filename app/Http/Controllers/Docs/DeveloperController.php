<?php

namespace App\Http\Controllers\Docs;

use App\ApiClient;
use App\Http\Controllers\Controller;
use App\UserDeveloper;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:developer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $developer = UserDeveloper::where('role', 'Developer')
            ->orderBy('nama_depan', 'asc')
            ->get();
        return view('admin.developer.index', compact('developer'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = UserDeveloper::findorfail($id);
        $api_client = ApiClient::where('user_developer_id', $data->id)->get();
        $count_api = $api_client->count();
        return view('admin.developer.show', compact('data', 'api_client', 'count_api'));
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
        $data = UserDeveloper::find($id);
        if ($data->status == 'Aktif') {
            $api_client = ApiClient::where('user_developer_id', $data->id)->get();
            foreach ($api_client as $client){
                $client->update($request->all());
            }
            $data->update($request->all());
            return back()->withSuccess('Status User Berhasil Dirubah !');
        }
        $data->update($request->all());
        return back()->withSuccess('Status User Berhasil Dirubah !');
    }

}
