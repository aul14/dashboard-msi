<?php

namespace App\Http\Controllers;

use App\Models\ZpoSapToAuto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $search = $request->search;
        $mrpController = $request->mrp_controller;

        $data = ZpoSapToAuto::select('prod_ord_no', 'material_code', 'material_desc', 'qty_production', 'batch')
            ->where('status_batch', 'RECEIVED')
            ->when($search != '', function ($q) use ($search) {
                $q->where('prod_ord_no', 'like', "%$search%");
            })
            ->where('mrp_controller', $mrpController)
            ->groupBy('prod_ord_no', 'material_code', 'material_desc', 'qty_production', 'batch')
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    public function batch_by_no_po(Request $request)
    {
        $noPo = $request->no_po;
        $mrpController = $request->mrp_controller;

        $data = ZpoSapToAuto::where('prod_ord_no', $noPo)
            ->where('status_batch', 'RECEIVED')
            ->where('mrp_controller', $mrpController)
            ->select('batch_code', 'material_component', 'material_component_desc', 'material_packing_flag', 'qty_component', 'uom_component')->get();

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
                'batch_number' => 'required',
                'mrp_controller' => 'required'
            ]);

            $poNumber = $request->po_number;
            $batchNumber = $request->batch_number;
            $action = $request->action;
            $mrpController = $request->mrp_controller;
            $noderedUrl = env('NODERED_URL');

            $checkData = ZpoSapToAuto::where('prod_ord_no', $poNumber)
                ->where('batch_code', $batchNumber)
                ->where('mrp_controller', $mrpController)->first();

            if (!$checkData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found'
                ]);
            }

            $endpointNodeRed = $mrpController === 'WHG'
                ? "{$noderedUrl}Glyphosate/update"
                : "{$noderedUrl}Parakuat/update";

            DB::beginTransaction();

            if ($action === 'start') {
                $response = Http::post($endpointNodeRed, [
                    'Action' => 'Start',
                    'PO_Number' => $poNumber,
                    'Kode_Batch' => $batchNumber
                ]);
            } else if ($action === 'finish') {
                $response = Http::post($endpointNodeRed, [
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

            if (!$response->successful()) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Gateway Node-RED tidak bisa diakses'
                ]);
            }

            $result = $response->json();

            if (isset($result['Status']) && $result['Status'] === 'failed') {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'PLC disconnected'
                ]);
            }

            if ($action === 'start') {
                $checkData->status_batch = 'ON PROCESS';
            } else {
                $checkData->status_batch = 'FINISH';
            }

            $checkData->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ucfirst($action) . ' operation successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
