<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function report_index(Request $request)
    {
        $title = 'Data Report';
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        return view('report.report_index', compact('date_start', 'date_end', 'title'));
    }

    public function ajax_report(Request $request)
    {
        try {
            $date_start = $request->date_start;
            $date_end = $request->date_end;
            $report = [];

            if (!empty($date_start) && !empty($date_end)) {
                $start = $date_start . ' 00:00:00';
                $end   = $date_end . ' 23:59:59';

                $summary = DB::selectOne("
                    WITH base_po AS (
                        SELECT DISTINCT
                            prod_ord_no,
                            batch_code,
                            mrp_controller,
                            qty_production,
                            production_start,
                            status_batch
                        FROM zpo_saptoauto
                        WHERE production_start BETWEEN ? AND ?
                    ),
                    po_summary AS (
                        SELECT
                            COUNT(DISTINCT prod_ord_no) AS total_po,
                            COUNT(DISTINCT prod_ord_no) FILTER (WHERE status_batch = 'FINISH' AND mrp_controller = 'WHP') AS parakuat_po,
                            COUNT(DISTINCT prod_ord_no) FILTER (WHERE status_batch = 'FINISH' AND mrp_controller = 'WHG') AS glyposate_po,
                            COUNT(DISTINCT prod_ord_no) FILTER (WHERE mrp_controller = 'WHP') AS po_whp,
                            COUNT(DISTINCT prod_ord_no) FILTER (WHERE mrp_controller = 'WHG') AS po_whg
                        FROM base_po
                    ),
                    batch_summary AS (
                        SELECT
                            COUNT(DISTINCT batch_code) AS total_batch,
                            COUNT(DISTINCT batch_code) FILTER (WHERE mrp_controller = 'WHP') AS parakuat_batch,
                            COUNT(DISTINCT batch_code) FILTER (WHERE mrp_controller = 'WHG') AS glyposate_batch
                        FROM base_po
                    ),
                    product_summary AS (
                        SELECT
                            SUM(qty_production) AS total_product,
                            SUM(qty_production) FILTER (WHERE mrp_controller = 'WHP') AS parakuat_product,
                            SUM(qty_production) FILTER (WHERE mrp_controller = 'WHG') AS glyposate_product
                        FROM base_po
                    ),
                    time_summary AS (
                        SELECT
                            SUM(lc.duration::INTERVAL) AS total_time,
                            SUM(lc.duration::INTERVAL) FILTER (WHERE z.mrp_controller = 'WHP') AS parakuat_time,
                            SUM(lc.duration::INTERVAL) FILTER (WHERE z.mrp_controller = 'WHG') AS glyposate_time
                        FROM log_confirmation lc
                        JOIN zpo_saptoauto z ON z.prod_ord_no = lc.po_number
                        WHERE lc.created_at BETWEEN ? AND ?
                            AND lc.type IN ('RM', 'Charging', 'Mixing', 'Transfer', 'DownTime')
                    ),
                    rm_summary AS (
                        SELECT
                            SUM(lc.qty) AS total_rm,
                            SUM(lc.qty) FILTER (WHERE z.mrp_controller = 'WHP') AS parakuat_rm,
                            SUM(lc.qty) FILTER (WHERE z.mrp_controller = 'WHG') AS glyposate_rm
                        FROM log_confirmation lc
                        JOIN zpo_saptoauto z ON z.prod_ord_no = lc.po_number
                        WHERE lc.type = 'RM'
                        AND lc.created_at BETWEEN ? AND ?
                    )
                    SELECT *
                    FROM po_summary, batch_summary, product_summary, time_summary, rm_summary
                ", [$start, $end, $start, $end, $start, $end]);


                $details = DB::select("
                    SELECT
                    lc.po_number            AS no_po,
                    lc.batch                AS batch,
                    z.production_start      AS start_time_po,
                    lc.duration::INTERVAL   AS duration,
                    lc.type                 AS activity,
                    lc.type_message         AS material_code,
                    lc.start_time           AS material_start_time,
                    lc.qty                  AS duration_qty,
                    z.mrp_controller
                    FROM log_confirmation lc
                    JOIN zpo_saptoauto z ON z.prod_ord_no = lc.po_number
                    WHERE lc.created_at BETWEEN ? AND ?
                    ORDER BY lc.po_number, lc.start_time
                ", [$start, $end]);
            }

            return response()->json([
                'success' => true,
                'data_summary' => $summary,
                'data_details' => $details
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
