<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = User::orderBy('users.id', 'DESC')->select('*');
            return DataTables::of($user)
                ->addColumn('action', function ($user) {
                    return view('datatable-modal._action', [
                        'row_id' => $user->id,
                        'edit_url' => route('users.update', $user->id),
                        'delete_url' => route('users.destroy', $user->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $title = 'User Settings';
        return view('users.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
