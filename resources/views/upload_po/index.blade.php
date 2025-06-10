@extends('app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header mb-3">
                <h3 class="page-title">{{ $title }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="my-table table my-tableview my-table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>No. PO</th>
                            <th>No. Batch</th>
                            <th>Status</th>
                            <th>Start</th>
                            <th>Material</th>
                            <th>Material Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>956110017258</td>
                            <td>25E2131</td>
                            <td>COMPLETED</td>
                            <td>04-06-2025 16:03:23</td>
                            <td>OA01001_RAMBO GOLD 480 SL WIP_20000(L)</td>
                            <td>RM01004_Glyphosate Acid 95%_7500(Kg)</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>25E2131</td>
                            <td>PROCESSED</td>
                            <td>04-06-2025 16:03:23</td>
                            <td>OA01001_RAMBO GOLD 480 SL WIP_20000(L)</td>
                            <td>RM01004_Glyphosate Acid 95%_7500(Kg)</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>25E2131</td>
                            <td>RECEIVED</td>
                            <td>04-06-2025 16:03:23</td>
                            <td>OA01001_RAMBO GOLD 480 SL WIP_20000(L)</td>
                            <td>RM01004_Glyphosate Acid 95%_7500(Kg)</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>25E2131</td>
                            <td>RECEIVED</td>
                            <td>04-06-2025 16:03:23</td>
                            <td>OA01001_RAMBO GOLD 480 SL WIP_20000(L)</td>
                            <td>RM01004_Glyphosate Acid 95%_7500(Kg)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
