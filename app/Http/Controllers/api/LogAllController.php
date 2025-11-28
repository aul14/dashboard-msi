<?php

namespace App\Http\Controllers\api;

use App\Models\LogMesin;
use App\Models\LogRecipient;
use Illuminate\Http\Request;
use App\Models\LogGoodsIssue;
use App\Models\LogConfirmation;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LogAllController extends Controller
{
    /**
     * POST /log/good_issue
     */
    public function goodIssue(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'po_number' => 'required|string',
                'batch' => 'nullable|string',
                'material_number' => 'nullable|string',
                'quantity' => 'nullable|numeric',
                'sloc' => 'nullable|string',
                'start_time' => 'nullable|date',
                'duration' => 'nullable|string',
                'mrp_controller' => 'required|string|in:WHP,WHG'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            $data = LogGoodsIssue::create($validator->validated());

            return response()->json([
                'status' => true,
                'message' => 'Goods Issue created',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * POST /log/confirmation
     */
    public function confirmation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'po_number' => 'required|string',
                'batch' => 'nullable|string',
                'type' => 'nullable|string',
                'duration' => 'nullable|string',
                'type_message' => 'nullable|string',
                'start_time' => 'nullable|date',
                'qty' => 'nullable|numeric',
                'mrp_controller' => 'required|string|in:WHP,WHG'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            $data = LogConfirmation::create($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Confirmation created',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * POST /log/recipient
     */
    public function recipient(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'po_number' => 'required|string',
                'batch' => 'nullable|string',
                'material_number' => 'nullable|string',
                'quantity' => 'nullable|numeric',
                'mrp_controller' => 'required|string|in:WHP,WHG'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            $data = LogRecipient::create($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Recipient created',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * POST /log/mesin
     */
    public function mesin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'datetime' => 'required|date|date_format:Y-m-d H:i:s',
                'description' => 'nullable|string',
                'mrp_controller' => 'required|string|in:WHP,WHG'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            $data = LogMesin::create($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Log Mesin created',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function index_mesin(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $log = LogMesin::query();

        // Hanya filter tanggal kalau dua-duanya diisi
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

        $title = 'Data Log Mesin';

        return view('log.log_mesin_index', compact('date_start', 'date_end', 'title'));
    }

    public function index_good_issue(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $log = LogGoodsIssue::query();

        // Hanya filter tanggal kalau dua-duanya diisi
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

        $title = 'Data Log Good Issues';

        return view('log.log_goodissue_index', compact('date_start', 'date_end', 'title'));
    }

    public function index_confirmation(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $log = LogConfirmation::query();

        // Hanya filter tanggal kalau dua-duanya diisi
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

        $title = 'Data Log Confirmations';

        return view('log.log_confirmation_index', compact('date_start', 'date_end', 'title'));
    }

    public function filter_confirmation(Request $request)
    {
        $po = $request->po_number;
        $batch = $request->batch;

        $log = LogConfirmation::where('po_number', $po)
            ->where('batch', $batch)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            "success" => true,
            "data" => $log
        ]);
    }

    public function index_recipient(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $log = LogRecipient::query();

        // Hanya filter tanggal kalau dua-duanya diisi
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

        $title = 'Data Log Confirmations';

        return view('log.log_recipient_index', compact('date_start', 'date_end', 'title'));
    }
}
