<?php

namespace App\Http\Controllers;

use App\Models\ZpoSapToAuto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        $data = ZpoSapToAuto::where('prod_ord_no', $noPo)->where('status_batch', 'RECEIVED')->select('batch_code')->get();

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }

        return response()->json($data);
    }

    public function start_finish_ops(Request $request)
    {
        try {
            $request->validate([
                'action' => 'required',
                'po_number' => 'required',
                'batch_number' => 'required'
            ]);

            $poNumber = $request->po_number;
            $batchNumber = $request->batch_number;
            $action = $request->action;
            $noderedUrl = env('NODERED_URL');

            $checkData = ZpoSapToAuto::where('prod_ord_no', $poNumber)->where('batch_code', $batchNumber)->first();

            if (!$checkData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found'
                ]);
            }

            if ($action === 'start') {
                $checkData->status_batch = 'ON PROCESS';
                $checkData->update();

                Http::post("{$noderedUrl}Parakuat/update", [
                    'Action' => 'Start',
                    'PO_Number' => $poNumber,
                    'Kode_Batch' => $batchNumber
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Start operation successfully.'
                ]);
            } else if ($action === 'finish') {
                $checkData->status_batch = 'FINISH';
                $checkData->update();

                Http::post("{$noderedUrl}Parakuat/update", [
                    'Action' => 'Finish',
                    'PO_Number' => '',
                    'Kode_Batch' => ''
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter action not found'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
