<?php

namespace App\Http\Controllers\api;

use App\Models\LogApi;
use Illuminate\Http\Request;
use App\Models\ConfAutoToSap;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiConfirmationController extends Controller
{
    public function post_confirmation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prod_ord_no' => 'required|string',
            'plant' => 'required|string',
            'work_center' => 'required|string',
            'operation_no' => 'required|string',
            'conf_qty' => 'required|numeric',
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
            $work_center = $request->work_center;
            $conf_qty = $request->conf_qty;
            $operation_no = $request->operation_no;

            foreach ($request->component as $component) {
                ConfAutoToSap::create([
                    'prod_ord_no' => $prod_ord_no,
                    'plant' => $plant,
                    'prod_start' => $prod_start,
                    'prod_end' => $prod_end,
                    'recipient' => $recipient,
                    'work_center' => $work_center,
                    'conf_qty' => $conf_qty,
                    'operation_no' => $operation_no,
                    'parameter_1' => $component['parameter_1'],
                    'parameter_desc_1' => $component['parameter_desc_1'],
                    'parameter_2' => $component['parameter_2'],
                    'parameter_desc_2' => $component['parameter_desc_2'],
                    'parameter_3' => $component['parameter_3'],
                    'parameter_desc_3' => $component['parameter_desc_3'],
                    'parameter_4' => $component['parameter_4'],
                    'parameter_desc_4' => $component['parameter_desc_4'],
                    'parameter_5' => $component['parameter_5'],
                    'parameter_desc_5' => $component['parameter_desc_5'],
                    'parameter_6' => $component['parameter_6'],
                    'parameter_desc_6' => $component['parameter_desc_6'],
                    'insert_time' => now(),
                    'update_time' => now()
                ]);
            }

            $responseSuccess = [
                'success' => true,
                'message' => 'Confirmartion data post successfully.'
            ];

            LogApi::create([
                'type_table' => 'conf_autotosap',
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

    public function get_confirmation($prodOrdNo)
    {
        if (empty($prodOrdNo)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter prod_ord_no is required.'
            ]);
        }

        try {
            $rows = ConfAutoToSap::where('prod_ord_no', $prodOrdNo)->get();

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
                'work_center' => $first->work_center,
                'conf_qty' => $first->conf_qty,
                'operation_no' => $first->operation_no,
                'insert_time' => $first->insert_time,
                'update_time' => $first->update_time,
            ];

            foreach ($rows as $row) {
                $response['component'][] = [
                    'parameter_1' => $row->parameter_1,
                    'parameter_desc_1' => $row->parameter_desc_1,
                    'parameter_2' => $row->parameter_2,
                    'parameter_desc_2' => $row->parameter_desc_2,
                    'parameter_3' => $row->parameter_3,
                    'parameter_desc_3' => $row->parameter_desc_3,
                    'parameter_4' => $row->parameter_4,
                    'parameter_desc_4' => $row->parameter_desc_4,
                    'parameter_5' => $row->parameter_5,
                    'parameter_desc_5' => $row->parameter_desc_5,
                    'parameter_6' => $row->parameter_6,
                    'parameter_desc_6' => $row->parameter_desc_6,
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
