<?php

namespace App\Http\Controllers\Logs;

use Carbon\Carbon;
use App\Models\LogParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HistoricalLogsController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Historical Logs';
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $area = $request->area;
        if ($request->params) {
            $params = implode(",", array_unique($request->params));
        } else {
            $params = "";
        }


        return view('logs.historical', compact('title', 'date_start', 'date_end', 'area', 'params'));
    }

    public function dataLog(Request $request)
    {
        $this->middleware('throttle:1000,1');
        $dt_start = $request->dt_start;
        $dt_end = $request->dt_end;
        $perPage = 1000;

        // if ($request->ajax()) {
            $data = LogParameter::whereBetween('created_at', [$dt_start, $dt_end])->paginate($perPage, ['message', 'created_at']);

            return response()->json($data);
        // }
    }
}
