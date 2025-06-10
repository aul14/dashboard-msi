<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadPoController extends Controller
{
    public function index()
    {
        $title = 'Upload PO';
        return view('upload_po.index', compact('title'));
    }
}
