<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
    public function index()
    {
        $title = 'Confirmation';
        return view('confirmation.index', compact('title'));
    }
}
