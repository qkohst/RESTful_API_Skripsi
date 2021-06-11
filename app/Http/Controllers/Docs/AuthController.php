<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserDeveloper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:developer')->except('logout');
    }

    public function form_login()
    {
        return view('auth.login');
    }

    public function post_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
        if (!Auth::guard('developer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->with('toast_error', 'Email atau Password Salah');
        }
        return redirect('/dashboard')->withSuccess('Login Berhasil !');
    }

    public function form_register()
    {
        return view('auth.register');
    }

    public function post_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depan' => 'required|min:3',
            'nama_belakang' => 'required|min:2',
            'email' => 'required|unique:user_developer|email',
            'password' => 'required|min:6',
            'konfirmasi_password' => 'same:password',
        ]);

        $user_developer = new UserDeveloper([
            'nama_depan' => $request->input('nama_depan'),
            'nama_belakang' => $request->input('nama_belakang'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => 'Developer',
            'status' => 'Aktif',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } elseif ($user_developer->save()) {
            return redirect('/login')->withSuccess('Pendaftaran Berhasil Silahkan Login !');
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('developer')->check()) // this means that the admin was logged in.
        {
            Auth::guard('developer')->logout();
            return redirect('/login')->withSuccess('Logout Berhasil !');
        }
    }
}
