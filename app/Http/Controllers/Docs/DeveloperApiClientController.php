<?php

namespace App\Http\Controllers\Docs;

use App\ApiClient;
use App\Http\Controllers\Controller;
use App\UserDeveloper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class DeveloperApiClientController extends Controller
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
        $developer = UserDeveloper::where('id', Auth::guard('developer')->user()->id)->first();
        $api_client = ApiClient::where('user_developer_id', $developer->id)->get();
        return view('users.myapp.index', compact('developer', 'api_client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.myapp.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_project' => 'required|unique:api_client|min:4',
            'jenis_platform' => 'required',
            'deskripsi' => 'required|min:5',
        ]);

        $developer = UserDeveloper::where('id', Auth::guard('developer')->user()->id)->first();

        $api_client = new ApiClient([
            'user_developer_id' => $developer->id,
            'nama_project' => $request->input('nama_project'),
            'jenis_platform' => $request->input('jenis_platform'),
            'deskripsi' => $request->input('deskripsi'),
            'api_key' => Str::random(60),
            'status' => 'Aktif',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } elseif ($api_client->save()) {
            return redirect("/developer/myapp")->withSuccess('Project Berhasil Dibuat !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data_api_client = ApiClient::findorfail($id);
        return view('users.myapp.show', compact('data_api_client'));
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
        $data = ApiClient::find($id);
        $data->update($request->all());
        return back()->withSuccess('Status API Key Berhasil Dirubah !');
    }
}
