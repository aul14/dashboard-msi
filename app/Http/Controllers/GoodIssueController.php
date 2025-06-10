<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoodIssueController extends Controller
{
    public function index()
    {
        $title = 'Good Issue';
        return view('good_issue.index', compact('title'));
    }
}
