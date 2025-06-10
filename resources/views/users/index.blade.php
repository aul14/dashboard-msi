@extends('app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header mb-3">
                <h3 class="page-title">{{ $title }}</h3>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <a href="javascript:void(0)" class="btn-sm btn-primary">
                <i class="fa fa-plus"> User Add</i>
            </a>
        </div>
    </div>
    <div class="row ">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="my-table table my-tableview my-table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th width="2px">Action</th>
                            <th>No</th>
                            <th class="select-filter">Fullname</th>
                            <th class="select-filter">Username</th>
                            <th class="select-filter">Email</th>
                            <th class="select-filter">User Level</th>
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
                ajax: '{{ route('users.index') }}',
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="fa fa-angle-right pgn-1" style="color: #0033C4"></span>',
                        sPrevious: '<span class="fa fa-angle-left pgn-2" style="color: #0033C4"></span>',
                        sFirst: '<span class="fa fa-angle-double-left pgn-3" style="color: #0033C4"></span>',
                        sLast: '<span class="fa fa-angle-double-right pgn-4" style="color: #0033C4"></span>',
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'fullname',
                        name: 'fullname'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'level_user',
                        name: 'level_user'
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
