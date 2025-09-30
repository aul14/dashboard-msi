<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LogApi;
use App\Models\ZpoSapToAuto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiUploadPoController extends Controller
{
    public function post_upload_po(Request $request)
    {
        try {
            DB::beginTransaction();

            $prod_ord_no = $request->prod_ord_no;
            $reservation = $request->reservation;
            $plant = $request->plant;
            $order_type = $request->order_type;
            $production_start = $request->production_start;
            $mrp_controller = $request->mrp_controller;
            $work_center_10 = $request->work_center_10;
            $work_center_20 = $request->work_center_20;
            $work_center_30 = $request->work_center_30;
            $work_center_40 = $request->work_center_40;
            $work_center_50 = $request->work_center_50;
            $work_center_60 = $request->work_center_60;
            $work_center_70 = $request->work_center_70;
            $work_center_80 = $request->work_center_80;
            $work_center_90 = $request->work_center_90;
            $work_center_100 = $request->work_center_100;
            $qty_production = $request->qty_production;
            $material_code = $request->material_code;
            $material_desc = $request->material_desc;
            $uom_material_code = $request->uom_material_code;
            $batch = intval($request->batch);

            // validasi jumlah array component harus sama dengan batch
            if (!is_array($request->component) || count($request->component) !== $batch) {
                return response()->json([
                    'status' => false,
                    'message' => "Jumlah component (" . count($request->component) . ") tidak sesuai dengan batch ($batch)."
                ], 400);
            }

            if ($batch > 0) {
                $start = 31;
                $max   = 99;
                $key = 0;

                // foreach ($request->component as $component) {
                for ($i = $start; $i < $start + $batch && $i <= $max; $i++) {
                    ZpoSapToAuto::create([
                        'prod_ord_no' => $prod_ord_no,
                        'reservation' => $reservation,
                        'plant' => $plant,
                        'order_type' => $order_type,
                        'production_start' => $production_start,
                        'mrp_controller' => $mrp_controller,
                        'work_center_10' => $work_center_10,
                        'work_center_20' => $work_center_20,
                        'work_center_30' => $work_center_30,
                        'work_center_40' => $work_center_40,
                        'work_center_50' => $work_center_50,
                        'work_center_60' => $work_center_60,
                        'work_center_70' => $work_center_70,
                        'work_center_80' => $work_center_80,
                        'work_center_90' => $work_center_90,
                        'work_center_100' => $work_center_100,
                        'qty_production' => $qty_production,
                        'material_code' => $material_code,
                        'material_desc' => $material_desc,
                        'uom_material_code' => $uom_material_code,
                        'batch' => $batch,
                        'batch_code' => date('y') . substr('ABCDEFGHIJKL', date('n') - 1, 1) . date('d') . $i,
                        'item' => $request->component[$key]['item'],
                        'material_component' => $request->component[$key]['material_component'],
                        'material_component_desc' => $request->component[$key]['material_component_desc'],
                        'material_packing_flag' => $request->component[$key]['material_packing_flag'],
                        'qty_component' => $request->component[$key]['qty_component'] / $batch,
                        'uom_component' => $request->component[$key]['uom_component'],
                    ]);
                    $key++;
                }
                // }
            }


            $responseSuccess = [
                'success' => true,
                'message' => 'Upload PO post successfully.'
            ];

            LogApi::create([
                'type_table' => 'zpo_saptoauto',
                'ip_address' => $request->ip(),
                'request_log' => json_encode($request->all()),
                'response_log' => json_encode($responseSuccess)
            ]);

            DB::commit();
            return response()->json($responseSuccess);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function get_upload_po($prodOrdNo)
    {
        if (empty($prodOrdNo)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter prod_ord_no is required.'
            ]);
        }

        try {
            $rows = ZpoSapToAuto::where('prod_ord_no', $prodOrdNo)->get();

            if ($rows->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found'
                ]);
            }

            $first = $rows->first();

            $response = [
                'prod_ord_no' => $first->prod_ord_no,
                'reservation' => $first->reservation,
                'plant' => $first->plant,
                'order_type' => $first->order_type,
                'production_start' => $first->production_start,
                'mrp_controller' => $first->mrp_controller,
                'work_center_10' => $first->work_center_10,
                'work_center_20' => $first->work_center_20,
                'work_center_30' => $first->work_center_30,
                'work_center_40' => $first->work_center_40,
                'work_center_50' => $first->work_center_50,
                'work_center_60' => $first->work_center_60,
                'work_center_70' => $first->work_center_70,
                'work_center_80' => $first->work_center_80,
                'work_center_90' => $first->work_center_90,
                'work_center_100' => $first->work_center_100,
                'qty_production' => $first->qty_production,
                'material_code' => $first->material_code,
                'material_desc' => $first->material_desc,
                'uom_material_code' => $first->uom_material_code,
                'component' => [],
            ];

            foreach ($rows as $row) {
                $response['component'][] = [
                    'item' => $row->item,
                    'material_component' => $row->material_component,
                    'material_component_desc' => $row->material_component_desc,
                    'material_packing_flag' => $row->material_packing_flag,
                    'qty_component' => $row->qty_component,
                    'uom_component' => $row->uom_component,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $response
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
