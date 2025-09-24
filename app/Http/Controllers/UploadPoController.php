<?php

namespace App\Http\Controllers;

use App\Models\ZpoSapToAuto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UploadPoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // bungkus query dalam subquery supaya DataTables bisa tambahin limit, offset, dll
            $query = DB::table('zpo_saptoauto as z')
                ->select(
                    DB::raw("
                        CASE 
                            WHEN RIGHT(z.batch_code, 2) = '31' 
                                THEN z.prod_ord_no 
                            ELSE '' 
                        END as no_po
                    "),
                    'z.batch_code as no_batch',
                    'z.status_batch as status',
                    'z.production_start as start',
                    DB::raw("CONCAT(z.material_code, '_', z.material_desc) as material"),
                    DB::raw("CONCAT(z.material_component, '_', z.material_component_desc) as material_finish")
                )
                ->orderBy('z.prod_ord_no')
                ->orderBy('item')
                ->orderBy('batch_code');

            return DataTables::of($query)
                ->addIndexColumn()
                ->make(true);
        }

        $title = 'Upload PO';
        return view('upload_po.index', compact('title'));
    }
}
