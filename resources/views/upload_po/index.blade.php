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
                            {{-- <th>No</th> --}}
                            <th>No. PO</th>
                            <th>No. Batch</th>
                            <th>Status</th>
                            <th>Start</th>
                            <th>Material</th>
                            <th>Material Finish</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
        $.fn.DataTable.ext.pager.numbers_length = 5;

        $('.my-table').DataTable({
            processing: true,
            serverSide: true,
            pagingType: 'full_numbers',
            scrollY: "50vh",
            scrollCollapse: true,
            searching: false,
            pageLength: 50,
            scrollX: true,
            ajax: '{{ route('upload_po.index') }}',
            oLanguage: {
                oPaginate: {
                    sNext: '<span class="fa fa-angle-right pgn-1" style="color: #0033C4"></span>',
                    sPrevious: '<span class="fa fa-angle-left pgn-2" style="color: #0033C4"></span>',
                    sFirst: '<span class="fa fa-angle-double-left pgn-3" style="color: #0033C4"></span>',
                    sLast: '<span class="fa fa-angle-double-right pgn-4" style="color: #0033C4"></span>',
                }
            },
            columns: [
                // {
                //     data: 'DT_RowIndex',
                //     name: 'DT_RowIndex',
                //     orderable: false,
                //     searchable: false
                // },
                {
                    data: 'no_po',
                    name: 'no_po'
                },
                {
                    data: 'no_batch',
                    name: 'no_batch'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row, meta) {
                        if (type === 'display') {
                            if (data === 'RECEIVED') {
                                return '<span class="badge badge-pill badge-warning">RECEIVED</span>';
                            } else if (data === 'PROCESSED') {
                                return '<span class="badge badge-pill badge-info">PROCESSED</span>';
                            } else if (data === 'COMPLETED') {
                                return '<span class="badge badge-pill badge-success">COMPLETED</span>';
                            } else {
                                return `<span class="badge badge-pill badge-dark">${data}</span>`;
                            }
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'start',
                    name: 'start'
                },
                {
                    data: 'material',
                    name: 'material'
                },
                {
                    data: 'material_finish',
                    name: 'material_finish'
                },
            ],
            columnDefs: [{
                defaultContent: "-",
                targets: "_all"
            }],
        });
    </script>
@endsection
