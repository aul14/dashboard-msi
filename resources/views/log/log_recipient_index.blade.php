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
        <form action="{{ route('log_recipient.index') }}" method="get">
            @csrf
            <div class="col-md-6 mt-2 overflow-auto px-0">
                <div class="input-group mb-3">
                    <input type="text" name="date_start" value="{{ $date_start }}" placeholder="Start Date"
                        autocomplete="off" class="daterangepicker-field form-control text-center">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="date_end" value="{{ $date_end }}" placeholder="End Date"
                        autocomplete="off" class="daterangepicker-field form-control text-center">
                </div>
            </div>
            <div class="col-md-12 my-2 px-0">
                <a href="{{ route('log_recipient.index') }}" class="btn btn-md btn-outline-warning">Refresh</a>
                <button type="submit" class="btn btn-md btn-outline-primary">Search</button>

            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="my-table table my-tableview my-table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Created At</th>
                        <th>PO Number</th>
                        <th>Batch</th>
                        <th>Material Number</th>
                        <th>Qty</th>
                        <th>Sloc</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.fn.DataTable.ext.pager.numbers_length = 5;
            $('.my-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                lengthMenu: [50, 100, 150, 200],
                pagingType: 'full_numbers',
                scrollY: "50vh",
                scrollCollapse: true,
                scrollX: true,
                ajax: {
                    type: "get",
                    url: '{{ route('log_recipient.index') }}',
                    data: {
                        date_start: '{{ $date_start }}',
                        date_end: '{{ $date_end }}',
                    },
                    dataType: "json",
                    dataSrc: function(json) {
                        if ($('input[name="date_start"]').val() === '' || $('input[name="date_end"]')
                            .val() === '') {
                            return []; // kosongkan tabel kalau belum pilih tanggal
                        }
                        return json.data;
                    }
                },
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
                        data: 'created_at',
                    },
                    {
                        data: 'po_number',
                    },
                    {
                        data: 'batch',
                    },
                    {
                        data: 'material_number',
                    },
                    {
                        data: 'qty',
                    },
                    {
                        data: 'sloc',
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
