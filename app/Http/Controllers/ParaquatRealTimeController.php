<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParaquatRealTimeController extends Controller
{
    public function index()
    {
        $title = 'Real Time Monitoring Paraquat';
        return view('realtime.paraquat.index', compact('title'));
    }

    public function table_realtime()
    {
        $title = 'Real Time Monitoring Paraquat';
        return view('realtime.paraquat.table', compact('title'));
    }
}
