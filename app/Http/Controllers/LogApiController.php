<?php

namespace App\Http\Controllers;

use App\Models\LogApi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LogApiController extends Controller
{
    public function log_index(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $log = LogApi::query();

        if (!empty($date_start) && !empty($date_end)) {
            $log->whereBetween('created_at', [
                "{$date_start} 00:00:00",
                "{$date_end} 23:59:59"
            ]);
        }

        $log->orderBy('id', 'DESC')->select('*');

        if ($request->ajax()) {
            return DataTables::of($log)
                ->editColumn('created_at', function ($log) {
                    return !empty($log->created_at) ? date("Y-m-d H:i:s", strtotime($log->created_at)) : null;
                })
                ->rawColumns(['created_at'])
                ->addIndexColumn()
                ->make(true);
        }

        $title = 'Data Log API SAP';

        return view('log_api.index_log', compact('date_start', 'date_end', 'title'));
    }
}
