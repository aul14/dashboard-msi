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
                /* 1️⃣ CALL SAP */
                $responseSAP = Http::withHeaders([
                    'sap-client'   => env('SAP_CLIENT'),
                    'sap-user'     => env('SAP_USER'),
                    'sap-password' => env('SAP_PASSWORD'),
                    'Content-Type' => 'application/json',
                ])
                    ->timeout(30)
                    ->post(env('SAP_URL'), [
                        'ITAB' => 'ZPPMSIINT_UPPO',
                        'DATA' => [
                            [
                                'CAUFV_AUFNR'      => $poNumber,
                                'KEY_STATUS'      => '1',
                                'LASTUPDATE_SAP'  => now()->format('d/m/Y H:i:s'),
                                'LASTUPDATE_AUTO' => now()->format('d/m/Y H:i:s'),
                            ]
                        ]
                    ]);

                if (!$responseSAP->successful()) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'SAP Webservice gagal diakses'
                    ]);
                }

                $sapResult = $responseSAP->json();

                /* 2️⃣ CALL NODE-RED */
                $responseNodeRed = Http::timeout(20)->post($endpointNodeRed, [
                    'Action'      => 'Start',
                    'PO_Number'   => $poNumber,
                    'Kode_Batch'  => $batchNumber
                ]);

                if (!$responseNodeRed->successful()) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'Gateway Node-RED tidak bisa diakses'
                    ]);
                }

                $nodeRedResult = $responseNodeRed->json();

                if (isset($nodeRedResult['Status']) && $nodeRedResult['Status'] === 'failed') {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => $nodeRedResult['message'] ?? 'PLC disconnected'
                    ]);
                }

                /* 3️⃣ UPDATE DATABASE */
                $checkData->status_batch = 'ON PROCESS';
                $checkData->save();
            }


            if ($action === 'finish') {
                $responseNodeRed = Http::post($endpointNodeRed, [
                    'Action' => 'Finish',
                    'PO_Number' => '',
                    'Kode_Batch' => ''
                ]);

                if (!$responseNodeRed->successful()) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'Gateway Node-RED tidak bisa diakses'
                    ]);
                }

                $checkData->status_batch = 'FINISH';
                $checkData->save();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => ucfirst($action) . ' operation successfully.'
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
