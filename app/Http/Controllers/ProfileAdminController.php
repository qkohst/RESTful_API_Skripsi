<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Admin;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;




class ProfileAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $admin = Admin::where('user_id_user', Auth::user()->id)->first();
        $user = $user->find(Auth::user()->id);

        $data = [
            'id' => $admin->id,
            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
                'role' => $user->role
            ],
            'nama_admin' => $admin->nama_admin,
            'nik_admin' => $admin->nik_admin,
            'nidn_admin' => $admin->nidn_admin,
            'nip_admin' => $admin->nip_admin,
            'tempat_lahir_admin' => $admin->tempat_lahir_admin,
            'tanggal_lahir_admin' => $admin->tanggal_lahir_admin,
            'jenis_kelamin_admin' => $admin->jenis_kelamin_admin,
            'foto_admin' => [
                'nama_file' => $admin->foto_admin,
                'url' => 'fileFotoProfile/' . $admin->foto_admin
            ],
            'email_admin' => $admin->email_admin,
            'no_hp_admin' => $admin->no_hp_admin,
            'tanggal_pembaruan_admin' => $admin->updated_at->format('Y-m-d H:i:s')
        ];

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Profile Admin',
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $admin = Admin::where('user_id_user', Auth::user()->id)->first();
        $id = $admin->id;

        $validator = Validator::make($request->all(), [
            'nama_admin' => 'required|min:5',
            'nidn_admin' => 'required|numeric|digits:10|unique:admin' . ($id ? ",id,$id" : ''),
            'nip_admin' => 'nullable|numeric|digits:18|unique:admin' . ($id ? ",id,$id" : ''),
            'nik_admin' => 'required|numeric|digits:16|unique:admin' . ($id ? ",id,$id" : ''),
            'tempat_lahir_admin' => 'required|min:3',
            'tanggal_lahir_admin' => 'required|date|before:today',
            'jenis_kelamin_admin' => 'required|in:L,P',
            'email_admin' => 'required|email|unique:admin' . ($id ? ",id,$id" : ''),
            'no_hp_admin' => 'required|numeric|digits_between:11,13|unique:admin' . ($id ? ",id,$id" : ''),
            'foto_admin' => 'nullable|image|max:2000'
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

        $admin->nama_admin = $request->input('nama_admin');
        $admin->nidn_admin = $request->input('nidn_admin');
        $admin->nip_admin = $request->input('nip_admin');
        $admin->nik_admin = $request->input('nik_admin');
        $admin->tempat_lahir_admin = $request->input('tempat_lahir_admin');
        $admin->tanggal_lahir_admin = $request->input('tanggal_lahir_admin');
        $admin->jenis_kelamin_admin = $request->input('jenis_kelamin_admin');
        $admin->email_admin = $request->input('email_admin');
        $admin->no_hp_admin = $request->input('no_hp_admin');

        if ($request->hasFile('foto_admin')) {
            $file_foto = $request->file('foto_admin');
            $fotoName = 'img-' . $admin->nidn_admin . '.' . $file_foto->getClientOriginalExtension();
            $file_foto->move('api/v1/fileFotoProfile/', $fotoName);
            $admin->foto_admin = $fotoName;
        }

        $admin->save();

        $user = User::findorfail(Auth::user()->id);

        if ($user->username != $admin->nidn_admin) {
            $user->nama = $admin->nama_admin;
            $user->username = $admin->nidn_admin;
            $user->password = bcrypt($admin->nidn_admin);
            $user->api_token = Str::random(100);
            $user->save();

            $data1 = [
                'id' => $admin->id,
                'user' => [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'username' => $user->username,
                    'api_token' => $user->api_token,
                ],
                'nik_admin' => $admin->nik_admin,
                'nidn_admin' => $admin->nidn_admin,
                'nip_admin' => $admin->nip_admin,
                'tempat_lahir_admin' => $admin->tempat_lahir_admin,
                'tanggal_lahir_admin' => $admin->tanggal_lahir_admin,
                'jenis_kelamin_admin' => $admin->jenis_kelamin_admin,
                'foto_admin' => [
                    'nama_file' => $admin->foto_admin,
                    'url' => 'fileFotoProfile/' . $admin->foto_admin
                ],
                'email_admin' => $admin->email_admin,
                'no_hp_admin' => $admin->no_hp_admin,
                'updated_at' => $admin->updated_at->diffForHumans(),
            ];

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '1',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'User profile and account data has been updated successfully, please log in with new username & password',
                'data' => $data1
            ], 200);
        }

        $data1 = [
            'id' => $admin->id,
            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
                'api_token' => $user->api_token,
            ],
            'nik_admin' => $admin->nik_admin,
            'nidn_admin' => $admin->nidn_admin,
            'nip_admin' => $admin->nip_admin,
            'tempat_lahir_admin' => $admin->tempat_lahir_admin,
            'tanggal_lahir_admin' => $admin->tanggal_lahir_admin,
            'jenis_kelamin_admin' => $admin->jenis_kelamin_admin,
            'foto_admin' => [
                'nama_file' => $admin->foto_admin,
                'url' => 'fileFotoProfile/' . $admin->foto_admin
            ],
            'email_admin' => $admin->email_admin,
            'no_hp_admin' => $admin->no_hp_admin,
            'updated_at' => $admin->updated_at->diffForHumans(),
        ];

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Profile updated successfully',
            'data' => $data1
        ], 200);
    }
}
