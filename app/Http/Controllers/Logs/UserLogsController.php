<?php

namespace App\Http\Controllers\Logs;

use App\Models\LogUser;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class UserLogsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $logs = LogUser::with('user')->select('*');
            return DataTables::of($logs)
                ->editColumn('is_active', function ($logs) {
                    return $logs->is_active ? 'Login' : 'Logout';
                })
                ->editColumn('updated_at', function ($logs) {
                    return date('Y-m-d H:i:s', $logs->update_at);
                })
                ->addIndexColumn()
                ->make(true);
        }

        $title = 'User Logs';
        return view('logs.user', compact('title'));
    }
}
