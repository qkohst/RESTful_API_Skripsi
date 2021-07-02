<?php

namespace App\Http\Controllers\Docs;

use App\ApiClient;
use App\Http\Controllers\Controller;
use App\TrafficRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:developer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $api_client = ApiClient::orderBy('user_developer_id', 'asc')->get();
        return view('admin.apiclient.index', compact('api_client'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Traffic Request
        $data = TrafficRequest::where('api_client_id', $id)
            ->select([
                DB::raw('count(id) as `count`'),
                DB::raw('DATE(created_at) as day')
            ])->groupBy('day')
            ->where('created_at', '>=', Carbon::now()->subWeeks(1))
            ->get();

        $date_traffic = [];
        foreach ($data as $entry) {
            $date_traffic[] = $entry->day;
        }

        // Request Success 
        $data_success = TrafficRequest::where([
            ['api_client_id', $id],
            ['status', '1']
        ])
            ->select([
                DB::raw('count(id) as `count`'),
                DB::raw('DATE(created_at) as day')
            ])->groupBy('day')
            ->where('created_at', '>=', Carbon::now()->subWeeks(1))
            ->get();

        $count_traffic_success  = [];
        foreach ($data_success as $entry) {
            $count_traffic_success[] = $entry->count;
        }

        // Request Errors 
        $data_errors = TrafficRequest::where([
            ['api_client_id', $id],
            ['status', '0']
        ])
            ->select([
                DB::raw('count(id) as `count`'),
                DB::raw('DATE(created_at) as day')
            ])->groupBy('day')
            ->where('created_at', '>=', Carbon::now()->subWeeks(1))
            ->get();

        $count_traffic_errors  = [];
        foreach ($data_errors as $entry) {
            $count_traffic_errors[] = $entry->count;
        }
        $data = ApiClient::findorfail($id);

        return view('admin.apiclient.show', compact('data', 'date_traffic', 'count_traffic_success', 'count_traffic_errors'));
    }
}
