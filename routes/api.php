<?php

use App\Http\Controllers\api\ApiConfirmationController;
use App\Http\Controllers\api\ApiGoodReceiptController;
use App\Http\Controllers\api\ApiUpdateGoodIssueController;
use App\Http\Controllers\api\ApiUpdateStatusPoController;
use App\Http\Controllers\api\ApiUploadPoController;
use App\Http\Controllers\api\LogAllController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/upload_po', [ApiUploadPoController::class, 'post_upload_po']);
Route::get('/upload_po/{prod_ord_no}', [ApiUploadPoController::class, 'get_upload_po']);
Route::get('/upload_po', function () {
    return response()->json([
        'success' => false,
        'message' => 'Parameter prod_ord_no is required.'
    ], 422);
});

Route::post('/update_status_po', [ApiUpdateStatusPoController::class, 'post_update_status']);
Route::get('/update_status_po/{prod_ord_no}', [ApiUpdateStatusPoController::class, 'get_update_status']);
Route::get('/update_status_po', function () {
    return response()->json([
        'success' => false,
        'message' => 'Parameter prod_ord_no is required.'
    ], 422);
});

Route::post('/data_good_issue', [ApiUpdateGoodIssueController::class, 'post_update_gi']);
Route::get('/data_good_issue/{prod_ord_no}', [ApiUpdateGoodIssueController::class, 'get_update_gi']);
Route::get('/data_good_issue', function () {
    return response()->json([
        'success' => false,
        'message' => 'Parameter prod_ord_no is required.'
    ], 422);
});

Route::post('/data_confirmation', [ApiConfirmationController::class, 'post_confirmation']);
Route::get('/data_confirmation/{prod_ord_no}', [ApiConfirmationController::class, 'get_confirmation']);
Route::get('/data_confirmation', function () {
    return response()->json([
        'success' => false,
        'message' => 'Parameter prod_ord_no is required.'
    ], 422);
});

Route::post('/data_good_receipt', [ApiGoodReceiptController::class, 'post_good_receipt']);
Route::get('/data_good_receipt/{prod_ord_no}', [ApiGoodReceiptController::class, 'get_good_receipt']);
Route::get('/data_good_receipt', function () {
    return response()->json([
        'success' => false,
        'message' => 'Parameter prod_ord_no is required.'
    ], 422);
});

Route::prefix('log')->group(function () {
    Route::post('/good_issue', [LogAllController::class, 'goodIssue']);
    Route::post('/confirmation', [LogAllController::class, 'confirmation']);
    Route::post('/recipient', [LogAllController::class, 'recipient']);
    Route::post('/mesin', [LogAllController::class, 'mesin']);
});
