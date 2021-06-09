<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:developer');
    }

    public function index()
    {
        if (Auth::guard('developer')->user()->role == 'Admin') {
            return view('admin/dashboard');
        }elseif (Auth::guard('developer')->user()->role == 'Developer') {
            return view('users/dashboard');
        }
    }
}
