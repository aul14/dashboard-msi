<?php

namespace App\Http\Controllers;

use App\Models\LogParameter;
use App\Models\Parameter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Real Time Monitoring Glyposate';
        return view('home.index', compact('title'));
    }
}
