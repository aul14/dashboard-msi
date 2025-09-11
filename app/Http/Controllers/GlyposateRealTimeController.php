<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlyposateRealTimeController extends Controller
{
    public function index()
    {
        $title = 'Real Time Monitoring Glyposate';
        return view('realtime.glyposate.index', compact('title'));
    }

    public function table_realtime()
    {
        $title = 'Real Time Monitoring Glyposate';
        return view('realtime.glyposate.table', compact('title'));
    }
}
