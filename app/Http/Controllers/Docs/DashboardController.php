<?php

namespace App\Http\Controllers\Docs;

use App\ApiClient;
use App\Http\Controllers\Controller;
use App\TrafficRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:developer');
    }

    public function index()
    {
        if (Auth::guard('developer')->user()->role == 'Admin') {
            $data = TrafficRequest::select([
                DB::raw('count(id) as `count`'),
                DB::raw('DATE(created_at) as day')
            ])->groupBy('day')
                ->where('created_at', '>=', Carbon::now()->subWeeks(1))
                ->get();

            $date_traffic = [];
            foreach ($data as $entry) {
                $date_traffic[] = $entry->day;
            }

            $count_traffic = [];
            foreach ($data as $entry) {
                $count_traffic[] = $entry->count;
            }
            // Mobile Traffic
            $mobile_client = ApiClient::where('platform', 'Mobile')->get('id');
            $data_mobile = TrafficRequest::whereIn('api_client_id', $mobile_client)
                ->select([
                    DB::raw('count(id) as `count`'),
                    DB::raw('DATE(created_at) as day')
                ])->groupBy('day')
                ->where('created_at', '>=', Carbon::now()->subWeeks(1))
                ->get();


            $count_traffic_mobile = [];
            foreach ($data_mobile as $entry) {
                $count_traffic_mobile[] = $entry->count;
            }
            // Web Traffic
            $web_client = ApiClient::where('platform', 'Web')->get('id');
            $data_web = TrafficRequest::whereIn('api_client_id', $web_client)
                ->select([
                    DB::raw('count(id) as `count`'),
                    DB::raw('DATE(created_at) as day')
                ])->groupBy('day')
                ->where('created_at', '>=', Carbon::now()->subWeeks(1))
                ->get();

            $count_traffic_web = [];
            foreach ($data_web as $entry) {
                $count_traffic_web[] = $entry->count;
            }
            // dd($count_traffic);
            return view('admin/dashboard', compact('date_traffic', 'count_traffic_web', 'count_traffic_mobile'));
        } elseif (Auth::guard('developer')->user()->role == 'Developer') {
            return view('users/dashboard');
        }
    }
}
