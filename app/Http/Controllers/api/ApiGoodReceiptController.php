<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GrAutoToSap;
use App\Models\LogApi;
use Illuminate\Support\Facades\Validator;

class ApiGoodReceiptController extends Controller
{
    public function post_good_receipt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prod_ord_no' => 'required|string',
            'plant' => 'required|string',
            'material_number' => 'required|string',
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
            $grAutoToSap = new GrAutoToSap();
            $grAutoToSap->prod_ord_no = $request->prod_ord_no;
            $grAutoToSap->plant = $request->plant;
            $grAutoToSap->prod_start = $request->prod_start;
            $grAutoToSap->prod_end = $request->prod_end;
            $grAutoToSap->material_number = $request->material_number;
            $grAutoToSap->qty = $request->qty;
            $grAutoToSap->uom_material_number = $request->uom_material_number;
            $grAutoToSap->sloc = $request->sloc;
            $grAutoToSap->recipient = $request->recipient;
            $grAutoToSap->batch_number = $request->batch_number;
            $grAutoToSap->key_status = $request->key_status;
            $grAutoToSap->mrp_controller = $request->mrp_controller;
            $grAutoToSap->insert_time = now();
            $grAutoToSap->update_time = now();
            $grAutoToSap->save();

            $responseSuccess = [
                'success' => true,
                'message' => 'Good receipt data post successfully.'
            ];

            LogApi::create([
                'type_table' => 'gr_autotosap',
                'ip_address' => $request->ip(),
                'request_log' => json_encode($request->all()),
                'response_log' => json_encode($responseSuccess)
            ]);

            return response()->json($responseSuccess);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function get_good_receipt($prodOrdNo)
    {
        if (empty($prodOrdNo)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter prod_ord_no is required.'
            ]);
        }

        try {
            $rows = GrAutoToSap::where('prod_ord_no', $prodOrdNo)->get();

            if ($rows->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $rows
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
