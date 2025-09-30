<?php

namespace App\Http\Controllers;

use App\Models\ZpoSapToAuto;
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

    public function search_no_po(Request $request)
    {
        $search = $request->q;

        $data = ZpoSapToAuto::select('prod_ord_no', 'material_code', 'material_desc', 'qty_production', 'batch')
            ->when($search != '', function ($q) use ($search) {
                $q->where('prod_ord_no', 'like', "%$search%");
            })
            ->groupBy('prod_ord_no', 'material_code', 'material_desc', 'qty_production', 'batch')
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    public function batch_by_no_po(Request $request)
    {
        $noPo = $request->no_po;

        $data = ZpoSapToAuto::where('prod_ord_no', $noPo)->select('batch_code')->get();

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }

        return response()->json($data);
    }
}
