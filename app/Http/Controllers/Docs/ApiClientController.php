<?php

namespace App\Http\Controllers\Docs;

use App\ApiClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiClientController extends Controller
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
        $api_client = ApiClient::orderBy('user_developer_id', 'asc')->get();
        return view('admin.apiclient.index', compact('api_client'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ApiClient::findorfail($id);
        return view('admin.apiclient.show', compact('data'));
    }
}
