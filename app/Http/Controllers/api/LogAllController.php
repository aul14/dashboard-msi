<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LogConfirmation;
use App\Models\LogGoodsIssue;
use App\Models\LogMesin;
use App\Models\LogRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LogAllController extends Controller
{
    /**
     * POST /log/good_issue
     */
    public function goodIssue(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'po_number' => 'required|string',
                'batch' => 'nullable|string',
                'material_number' => 'nullable|string',
                'quantity' => 'nullable|numeric',
                'sloc' => 'nullable|string',
                'start_time' => 'nullable|date',
                'duration' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            $data = LogGoodsIssue::create($validator->validated());

            return response()->json([
                'status' => true,
                'message' => 'Goods Issue created',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * POST /log/confirmation
     */
    public function confirmation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'po_number' => 'required|string',
                'batch' => 'nullable|string',
                'type' => 'nullable|string',
                'duration' => 'nullable|string',
                'start_time' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            $data = LogConfirmation::create($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Confirmation created',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * POST /log/recipient
     */
    public function recipient(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'po_number' => 'required|string',
                'batch' => 'nullable|string',
                'material_number' => 'nullable|string',
                'quantity' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            $data = LogRecipient::create($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Recipient created',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * POST /log/mesin
     */
    public function mesin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'datetime' => 'required|date|date_format:Y-m-d H:i:s',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            $data = LogMesin::create($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Log Mesin created',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
