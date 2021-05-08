<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Admin;

class ProfileAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
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
            'tempat_lahir_admin' => $admin->tempat_lahir_admin,
            'tanggal_lahir_admin' => $admin->tanggal_lahir_admin,
            'jenis_kelamin_admin' => $admin->jenis_kelamin_admin,
            'foto_admin' => [
                'nama_file' => $admin->foto_admin,
                'url' => 'fileFotoProfile/' . $admin->foto_admin
            ],
            'email_admin' => $admin->email_admin,
            'no_hp_admin' => $admin->no_hp_admin,
            'status_admin' => $admin->status_admin,
            'updated_at' => $admin->updated_at,
        ];
        return response()->json([
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
        $admin = Admin::where('user_id_user', Auth::user()->id)->first();
        $id = $admin->id;
        $this->validate($request, [
            'nama_admin' => 'required|min:5',
            'nidn_admin' => 'required|numeric|digits:10|unique:admin' . ($id ? ",id,$id" : ''),
            'nip_admin' => 'nullable|numeric|digits:18|unique:admin' . ($id ? ",id,$id" : ''),
            'nik_admin' => 'required|numeric|digits:16|unique:admin' . ($id ? ",id,$id" : ''),
            'tempat_lahir_admin' => 'required|min:3',
            'tanggal_lahir_admin' => 'required|date',
            'jenis_kelamin_admin' => 'required|in:L,P',
            'email_admin' => 'required|email|unique:admin' . ($id ? ",id,$id" : ''),
            'no_hp_admin' => 'required|numeric|digits_between:11,13|unique:admin' . ($id ? ",id,$id" : ''),
            'foto_admin' => 'nullable|mimes:jpg,jpeg,png|max:2000'
        ]);

        $admin->nama_admin = $request->input('nama_admin');
        $admin->nidn_admin = $request->input('nidn_admin');
        $admin->nip_admin = $request->input('nip_admin');
        $admin->nik_admin = $request->input('nik_admin');
        $admin->tempat_lahir_admin = $request->input('tempat_lahir_admin');
        $admin->tanggal_lahir_admin = $request->input('tanggal_lahir_admin');
        $admin->jenis_kelamin_admin = $request->input('jenis_kelamin_admin');
        $admin->email_admin = $request->input('email_admin');
        $admin->no_hp_admin = $request->input('no_hp_admin');

        $file_foto = $request->file('foto_admin');
        $fotoName = date('mdYHis') . '.' . $file_foto->getClientOriginalExtension();
        $file_foto->move('fileFotoProfile/', $fotoName);
        $admin->foto_admin = $fotoName;
        $admin->save();

        $user = User::findorfail(Auth::user()->id);

        if ($user->username != $admin->nidn_admin) {
            $user->nama = $admin->nama_admin;
            $user->username = $admin->nidn_admin;
            $user->password = bcrypt($admin->nidn_admin);
            $user->api_token = bcrypt($admin->nidn_admin . 'Admin');
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
                'tempat_lahir_admin' => $admin->tempat_lahir_admin,
                'tanggal_lahir_admin' => $admin->tanggal_lahir_admin,
                'jenis_kelamin_admin' => $admin->jenis_kelamin_admin,
                'foto_admin' => [
                    'nama_file' => $admin->foto_admin,
                    'url' => 'fileFotoProfile/' . $admin->foto_admin
                ],
                'email_admin' => $admin->email_admin,
                'no_hp_admin' => $admin->no_hp_admin,
                'status_admin' => $admin->status_admin,
                'updated_at' => $admin->updated_at->diffForHumans(),
            ];

            return response()->json([
                'message' => 'User profile and account data has been updated successfully, please log in with new username & password',
                'admin' => $data1
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
            'tempat_lahir_admin' => $admin->tempat_lahir_admin,
            'tanggal_lahir_admin' => $admin->tanggal_lahir_admin,
            'jenis_kelamin_admin' => $admin->jenis_kelamin_admin,
            'foto_admin' => [
                'nama_file' => $admin->foto_admin,
                'url' => 'fileFotoProfile/' . $admin->foto_admin
            ],
            'email_admin' => $admin->email_admin,
            'no_hp_admin' => $admin->no_hp_admin,
            'status_admin' => $admin->status_admin,
            'updated_at' => $admin->updated_at->diffForHumans(),
        ];
        return response()->json([
            'message' => 'Profile updated successfully',
            'admin' => $data1
        ], 200);
    }

    public function gantipassword(Request $request, User $user)
    {
        $this->validate($request, [
            'nidn_admin' => 'required|numeric',
            'password_lama' => 'required|min:6',
            'password_baru' => 'required|min:6',
            'confirm_password' => 'required|min:6'
        ]);

        $user = $user->find(Auth::user()->id);

        if ($user->username != $request->nidn_admin || $user->password != $request->password_lama) {
            return response()->json([
                'error' => 'Incorrect username or password',
                'data' => $user
            ], 401);
        }
        if ($request->password_baru != $request->confirm_password) {
            return response()->json([
                'error' => 'New password confirmation does not match'
            ], 401);
        }
    }
}
