<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Str;
use App\ApiClient;
use App\TrafficRequest;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request, User $user)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'username' => 'required|numeric',
            'password' => 'min:6'
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


        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'Incorrect username or password'
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

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Login successfully',
            'data' => $data
        ], 200);
    }

    public function gantipassword(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $validator = Validator::make($request->all(), [
            'username' => 'required|numeric',
            'password_lama' => ['required', new MatchOldPassword],
            'password_baru' => ['required', 'min:6'],
            'confirm_password' => ['same:password_baru'],
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

        if (auth()->user()->username != $request->username) {

            $traffic = new TrafficRequest([
                'api_client_id' => $api_client->id,
                'status' => '0',
            ]);
            $traffic->save();

            return response()->json([
                'status'  => 'error',
                'message' => 'username does not match'
            ], 422);
        }
        User::find(auth()->user()->id)->update(['password' => Hash::make($request->password_baru)]);

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Password change successfully.',
        ], 200);
    }

    public function logout(Request $request)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();

        $user = User::where('id', auth()->user()->id)->first();
        $user->api_token = Str::random(100);
        $user->update();

        $traffic = new TrafficRequest([
            'api_client_id' => $api_client->id,
            'status' => '1',
        ]);
        $traffic->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Logout successfully.',
        ], 200);
    }
}
