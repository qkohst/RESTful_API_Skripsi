<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Nanti Hapus
    public function register(Request $request, User $user)
    {
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required|numeric|unique:users',
            'password' => 'required|min:6'
        ]);
        $user = $user->create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'Admin',
            'api_token' => bcrypt($request->username . 'Admin'),
        ]);

        $data = [
            'id' => $user->id,
            'nama' => $user->nama,
            'username' => $user->username,
            'role' => $user->role,
            'api_token' => $user->api_token,
            'registered_at' => $user->created_at->diffForHumans(),
        ];
        return response()->json([
            'message' => 'Registration is successful',
            'user' => $data,
        ], 201);
    }

    public function login(Request $request, User $user)
    {
        $this->validate($request, [
            'username' => 'required|numeric',
            'password' => 'required|min:6'
        ]);
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json([
                'error' => 'Incorrect username or password'
            ], 401);
        }

        $user = $user->find(Auth::user()->id);

        $data = [
            'id' => $user->id,
            'nama' => $user->nama,
            'username' => $user->username,
            'role' => $user->role,
            'api_token' => $user->api_token,
        ];
        return response()->json([
            'message' => 'Login successfully',
            'user' => $data
        ], 200);
    }
}
