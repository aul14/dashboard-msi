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
                            <th>Time</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Message</th>
                            <th>Event</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>04-06-2025 16:03:23</td>
                            <td>ALARM</td>
                            <td>ZONE 1</td>
                            <td>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX</td>
                            <td>
                                <span class="badge badge-pill badge-danger">ACTIVE</span>
                            </td>
                        </tr>
                        <tr>
                            <td>04-06-2025 16:03:23</td>
                            <td>ALARM</td>
                            <td>ZONE 1</td>
                            <td>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX</td>
                            <td>
                                <span class="badge badge-pill badge-danger">ACTIVE</span>
                            </td>
                        </tr>
                        <tr>
                            <td>04-06-2025 16:03:23</td>
                            <td>WARNING</td>
                            <td>ZONE 1</td>
                            <td>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX</td>
                            <td>
                                <span class="badge badge-pill badge-warning">ACTIVE</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
