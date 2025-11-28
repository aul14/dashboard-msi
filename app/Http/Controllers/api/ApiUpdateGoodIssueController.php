<?php

namespace App\Http\Controllers\api;

use App\Models\LogApi;
use App\Models\ZgiAutoToSap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiUpdateGoodIssueController extends Controller
{
    public function post_update_gi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prod_ord_no' => 'required|string',
            'plant' => 'required|string',
            'mrp_controller' => 'required|string|in:WHP,WHG',
            'prod_start' => 'required|date_format:Y-m-d H:i:s',
            'prod_end' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response['success'] = false;
            $response['message'] = $error;
            return response()->json($response, 400);
        }

        try {
            DB::beginTransaction();

            $prod_ord_no = $request->prod_ord_no;
            $plant = $request->plant;
            $prod_start = $request->prod_start;
            $prod_end = $request->prod_end;
            $recipient = $request->recipient;

            foreach ($request->component as $component) {
                ZgiAutoToSap::create([
                    'prod_ord_no' => $prod_ord_no,
                    'plant' => $plant,
                    'prod_start' => $prod_start,
                    'prod_end' => $prod_end,
                    'recipient' => $recipient,
                    'mrp_controller' => $request->mrp_controller,
                    'material_number' => $component['material_number'],
                    'qty' => $component['qty'],
                    'uom_material_number' => $component['uom_material_number'],
                    'sloc' => $component['sloc'],
                    'insert_time' => now(),
                    'update_time' => now()
                ]);
            }

            $responseSuccess = [
                'success' => true,
                'message' => 'Update Good Issue data successfully.'
            ];

            LogApi::create([
                'type_table' => 'zgi_autotosap',
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

    public function get_update_gi($prodOrdNo)
    {
        if (empty($prodOrdNo)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter prod_ord_no is required.'
            ]);
        }

        try {
            $rows = ZgiAutoToSap::where('prod_ord_no', $prodOrdNo)->get();

            if ($rows->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found'
                ]);
            }

            $first = $rows->first();

            $response = [
                'prod_ord_no' => $first->prod_ord_no,
                'plant' => $first->plant,
                'prod_start' => $first->prod_start,
                'prod_end' => $first->prod_end,
                'recipient' => $first->recipient,
                'insert_time' => $first->insert_time,
                'update_time' => $first->update_time,
            ];

            foreach ($rows as $row) {
                $response['component'][] = [
                    'material_number' => $row->material_number,
                    'qty' => $row->qty,
                    'uom_material_number' => $row->uom_material_number,
                    'sloc' => $row->sloc,
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
