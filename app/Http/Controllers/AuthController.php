<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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

        return response()->json([
            'message' => 'User Registered',
            'user' => $user
        ], 201);
    }

    public function login(Request $request, User $user)
    {
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json([
                'error' => 'Your credential is wrong'
            ], 401);
        }
        $user = $user->find(Auth::user()->id);
        return response()->json([
            'message' => 'Login Success',
            'user' => $user
        ], 201);
    }
}
