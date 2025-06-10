<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlarmLoggerController extends Controller
{
    public function index()
    {
        $title = 'Alarm Logger';
        return view('alarm_logger.index', compact('title'));
    }
}
