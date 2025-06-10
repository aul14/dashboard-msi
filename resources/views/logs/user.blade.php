@extends('app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header mb-3">
                <h3 class="page-title">{{ $title }}</h3>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="my-table table my-tableview my-table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="select-filter">User</th>
                            <th class="select-filter">Is Active?</th>
                            <th class="select-filter">IP Address</th>
                            <th class="select-filter">Hostname</th>
                            <th class="select-filter">User Agent</th>
                            <th class="select-filter">Last Login</th>
                            <th class="select-filter">Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script>
        $(function() {
            $.fn.DataTable.ext.pager.numbers_length = 5;
            $('.my-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: 'full_numbers',
                scrollY: "50vh",
                scrollCollapse: true,
                scrollX: true,
                ajax: '{{ route('logs.user') }}',
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="fa fa-angle-right pgn-1" style="color: #0033C4"></span>',
                        sPrevious: '<span class="fa fa-angle-left pgn-2" style="color: #0033C4"></span>',
                        sFirst: '<span class="fa fa-angle-double-left pgn-3" style="color: #0033C4"></span>',
                        sLast: '<span class="fa fa-angle-double-right pgn-4" style="color: #0033C4"></span>',
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user.fullname',
                        name: 'user.fullname'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address'
                    },
                    {
                        data: 'hostname',
                        name: 'hostname'
                    },
                    {
                        data: 'user_agent',
                        name: 'user_agent'
                    },
                    {
                        data: 'last_login',
                        name: 'last_login'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                ],
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all"
                }],

            });
        });
    </script>
@endsection
