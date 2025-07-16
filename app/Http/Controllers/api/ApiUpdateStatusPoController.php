<?php

namespace App\Http\Controllers\api;

use App\Models\LogApi;
use App\Models\ZpoAutoToSap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiUpdateStatusPoController extends Controller
{
    public function post_update_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prod_ord_no' => 'required|string',
            'key_status' => 'required|numeric',
            'last_update_by_sap' => 'required|date_format:Y-m-d H:i:s'
        ]);

        if ($validator->fails()) {
            $error = $validator->messages()->first();
            $response['success'] = false;
            $response['message'] = $error;
            return response()->json($response, 400);
        }


        try {
            $prod_ord_no = $request->prod_ord_no;
            $key_status = $request->key_status;
            $last_update_by_sap = $request->last_update_by_sap;

            $zpoAutoToSap = new ZpoAutoToSap();
            $zpoAutoToSap->prod_ord_no = $prod_ord_no;
            $zpoAutoToSap->key_status = $key_status;
            $zpoAutoToSap->last_update_by_sap = $last_update_by_sap;
            $zpoAutoToSap->save();

            $responseSuccess = [
                'success' => true,
                'message' => 'Update Status PO post successfully.'
            ];

            LogApi::create([
                'type_table' => 'zpo_autotosap',
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

    public function get_update_status($prodOrdNo)
    {
        if (empty($prodOrdNo)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter prod_ord_no is required.'
            ]);
        }

        try {
            $rows = ZpoAutoToSap::where('prod_ord_no', $prodOrdNo)->get();

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
