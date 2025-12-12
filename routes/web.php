<?php

use App\Http\Controllers\AlarmLoggerController;
use App\Http\Controllers\api\LogAllController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\ConnectionDeviceController;
use App\Http\Controllers\DataAjaxController;
use App\Http\Controllers\FullScreenController;
use App\Http\Controllers\GatewayParamaterController;
use App\Http\Controllers\GlyposateRealTimeController;
use App\Http\Controllers\GoodIssueController;
use App\Http\Controllers\GoodReceiptController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Logs\HistoricalLogsController;
use App\Http\Controllers\Logs\UserLogsController;
use App\Http\Controllers\ParaquatRealTimeController;
use App\Http\Controllers\UploadPoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/start_finish_ops', [ParaquatRealTimeController::class, 'start_finish_ops'])->name('start_finish_ops');


Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/glyposate/real-time', [GlyposateRealTimeController::class, 'index'])->name('glyposate.index');
    Route::get('/paraquat/real-time', [ParaquatRealTimeController::class, 'index'])->name('paraquat.index');
    Route::get('/table/glyposate/real-time', [GlyposateRealTimeController::class, 'table_realtime'])->name('glyposate.table');
    Route::get('/table/paraquat/real-time', [ParaquatRealTimeController::class, 'table_realtime'])->name('paraquat.table');
    Route::get('/upload_po', [UploadPoController::class, 'index'])->name('upload_po.index');
    Route::get('/good_issue', [GoodIssueController::class, 'index'])->name('good_issue.index');
    Route::get('/good_receipt', [GoodReceiptController::class, 'index'])->name('good_receipt.index');
    Route::get('/confirm', [ConfirmationController::class, 'index'])->name('confirm.index');
    Route::get('/alarm_logger', [AlarmLoggerController::class, 'index'])->name('alarm_logger.index');

    Route::get('/log_mesin_index', [LogAllController::class, 'index_mesin'])->name('log_mesin.index');
    Route::get('/log_goodissue_index', [LogAllController::class, 'index_good_issue'])->name('log_goodissue.index');
    Route::get('/log_confirmation_index', [LogAllController::class, 'index_confirmation'])->name('log_confirmation.index');
    Route::get('/log_confirmation_filter', [LogAllController::class, 'filter_confirmation'])->name('log_confirmation.filter');
    Route::get('/log_recipient_index', [LogAllController::class, 'index_recipient'])->name('log_recipient.index');
    Route::post('/add_manual_confirmation', [LogAllController::class, 'confirmation'])->name('add_manual_confirmation');

    Route::post('/search_no_po', [ParaquatRealTimeController::class, 'search_no_po'])->name('search_no_po');
    Route::post('/batch_by_no_po', [ParaquatRealTimeController::class, 'batch_by_no_po'])->name('batch_by_no_po');
    Route::resource('/settings/users', UserController::class);
    Route::get('/test', function () {
        return view('test-websocket-client');
    });
});
