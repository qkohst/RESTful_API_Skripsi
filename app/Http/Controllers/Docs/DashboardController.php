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

            // Mobile Traffic
            $mobile_client = ApiClient::where('platform', 'Mobile')->get('id');
            $data_mobile = TrafficRequest::whereIn('api_client_id', $mobile_client)
                ->select([
                    DB::raw('count(id) as `count`'),
                    DB::raw('DATE(created_at) as day')
                ])->groupBy('day')
                ->where('created_at', '>=', Carbon::now()->subMonth(1))
                ->get();

            $date_traffic_mobile = [];
            foreach ($data_mobile as $entry) {
                $date_traffic_mobile[] = $entry->day;
            }

            // Mobile Request Success 
            $mobile_data_success = TrafficRequest::whereIn('api_client_id', $mobile_client)->where('status', '1')
                ->select([
                    DB::raw('count(id) as `count`'),
                    DB::raw('DATE(created_at) as day')
                ])->groupBy('day')
                ->where('created_at', '>=', Carbon::now()->subMonth(1))
                ->get();

            $count_traffic_mobile_success  = [];
            foreach ($mobile_data_success as $entry) {
                $count_traffic_mobile_success[] = $entry->count;
            }

            // Mobile Request Error 
            $mobile_data_error = TrafficRequest::whereIn('api_client_id', $mobile_client)->where('status', '0')
                ->select([
                    DB::raw('count(id) as `count`'),
                    DB::raw('DATE(created_at) as day')
                ])->groupBy('day')
                ->where('created_at', '>=', Carbon::now()->subMonth(1))
                ->get();

            $count_traffic_mobile_error  = [];
            foreach ($mobile_data_error as $entry) {
                $count_traffic_mobile_error[] = $entry->count;
            }

            // Web Traffic
            $web_client = ApiClient::where('platform', 'Web')->get('id');
            $data_web = TrafficRequest::whereIn('api_client_id', $web_client)
                ->select([
                    DB::raw('count(id) as `count`'),
                    DB::raw('DATE(created_at) as day')
                ])->groupBy('day')
                ->where('created_at', '>=', Carbon::now()->subMonth(1))
                ->get();

            $date_traffic_web = [];
            foreach ($data_web as $entry) {
                $date_traffic_web[] = $entry->day;
            }

            // Web Request Success 
            $web_data_success = TrafficRequest::whereIn('api_client_id', $web_client)->where('status', '1')
                ->select([
                    DB::raw('count(id) as `count`'),
                    DB::raw('DATE(created_at) as day')
                ])->groupBy('day')
                ->where('created_at', '>=', Carbon::now()->subMonth(1))
                ->get();

            $count_traffic_web_success  = [];
            foreach ($web_data_success as $entry) {
                $count_traffic_web_success[] = $entry->count;
            }

            // Web Request Error 
            $web_data_error = TrafficRequest::whereIn('api_client_id', $web_client)->where('status', '0')
                ->select([
                    DB::raw('count(id) as `count`'),
                    DB::raw('DATE(created_at) as day')
                ])->groupBy('day')
                ->where('created_at', '>=', Carbon::now()->subMonth(1))
                ->get();

            $count_traffic_web_error  = [];
            foreach ($web_data_error as $entry) {
                $count_traffic_web_error[] = $entry->count;
            }

            return view('admin/dashboard', compact('date_traffic_web', 'count_traffic_web_success', 'count_traffic_web_error', 'date_traffic_mobile', 'count_traffic_mobile_success', 'count_traffic_mobile_error',));
        } elseif (Auth::guard('developer')->user()->role == 'Developer') {
            return view('users/dashboard');
        }
    }
}
