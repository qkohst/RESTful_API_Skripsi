<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function users(User $user)
    {
        $users = $user->all();
        return response()->json($users);
    }

    public function profile(User $user)
    {
        $user = $user->find(Auth::user()->id);
        return response()->json($user);
    }
}
