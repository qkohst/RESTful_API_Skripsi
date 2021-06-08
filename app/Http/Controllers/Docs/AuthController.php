<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserDeveloper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{

    public function form_login()
    {
        return view('users.auth.login');
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
        $user = UserDeveloper::where([
            'email' => $request->email,
            'password' => $request->password
        ])->first();
        // dd($user);
        if (is_null($user)) {
            return back()->with('toast_error', 'Email atau Password Salah');
        }
        return redirect('/developer')->withSuccess('Login Berhasil !');
    }

    public function form_register()
    {
        return view('users.auth.register');
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
            // 'password' => $request->input('password'),
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
}
