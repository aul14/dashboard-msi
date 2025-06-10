<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoodReceiptController extends Controller
{
    public function index()
    {
        $title = 'Good Receipt';
        return view('good_receipt.index', compact('title'));
    }
}
