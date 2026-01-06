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
        <form class="form-search">
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
                <a href="{{ route('report.index') }}" class="btn btn-md btn-warning">Refresh</a>
                <a href="javascript:void(0)" class="btn btn-md btn-primary" onclick="searchReport(event)">Search</a>
                <a href="javascript:void(0)" style="display: none;" id="exportPdfBtn" onclick="exportToPDF(event)"
                    class="btn btn-md btn-danger">Export
                    to PDF</a>

            </div>
        </form>
    </div>
    <div id="row-content">
        <div class="row mt-3">
            <div class="col-12 col-md-3">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">
                            <h6>Total PO</h6>
                            <H5 class="list-po">0</H5>
                        </li>
                        <li class="list-group-item text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Parakuat</h6>
                                    <H5 class="list-po-whp">0</H5>
                                </div>
                                <div class="col-md-6">
                                    <h6>Glyposate</h6>
                                    <H5 class="list-po-whg">0</H5>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">
                            <h6>Total Batch</h6>
                            <H5 class="list-batch">0</H5>
                        </li>
                        <li class="list-group-item text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Parakuat</h6>
                                    <H5 class="list-batch-whp">0</H5>
                                </div>
                                <div class="col-md-6">
                                    <h6>Glyposate</h6>
                                    <H5 class="list-batch-whg">0</H5>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">
                            <h6>Total Time</h6>
                            <H5 class="list-time">0</H5>
                        </li>
                        <li class="list-group-item text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Parakuat</h6>
                                    <H5 class="list-time-whp">0</H5>
                                </div>
                                <div class="col-md-6">
                                    <h6>Glyposate</h6>
                                    <H5 class="list-time-whg">0</H5>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">
                            <h6>Total Product</h6>
                            <H5 class="list-product">0</H5>
                        </li>
                        <li class="list-group-item text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Parakuat</h6>
                                    <H5 class="list-product-whp">0</H5>
                                </div>
                                <div class="col-md-6">
                                    <h6>Glyposate</h6>
                                    <H5 class="list-product-whg">0</H5>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-12 table-responsive">
                <table id="tb_report_produksi" class="my-table table my-tableview my-table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>No PO</th>
                            <th>Batch</th>
                            <th>Start Time</th>
                            <th>Duration</th>
                            <th>Activity</th>
                            <th>Material Code</th>
                            <th>Start</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function searchReport(e) {
            if (e) e.preventDefault();

            let dateStart = $(".form-search input[name=date_start]").val();
            let dateEnd = $(".form-search input[name=date_end]").val();

            if (dateStart.trim() === '') {
                alert('Date start cannot be empty!');
                return
            }

            if (dateEnd.trim() === '') {
                alert('Date end cannot be empty!');
                return
            }

            $.ajax({
                type: "POST",
                url: "{{ route('report.ajax') }}",
                data: {
                    date_start: dateStart,
                    date_end: dateEnd
                },
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: 'Mengirim data...',
                        text: 'Mohon tunggu sebentar.',
                        didOpen: () => Swal.showLoading(),
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                },
                success: function(response) {
                    if (!response.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message ?? 'Sepertinya ada kesalahan.',
                            confirmButtonText: 'OK'
                        });
                        return
                    }

                    $('#exportPdfBtn').show();

                    let summary = response.data_summary;
                    $('.list-po').html(summary.total_po ?? 0);
                    $('.list-po-whp').html(summary.parakuat_po ?? 0);
                    $('.list-po-whg').html(summary.glyposate_po ?? 0);
                    $('.list-batch').html(summary.total_batch ?? 0);
                    $('.list-batch-whp').html(summary.parakuat_batch ?? 0);
                    $('.list-batch-whg').html(summary.glyposate_batch ?? 0);
                    $('.list-time').html(summary.total_time ?? 0);
                    $('.list-time-whp').html(summary.parakuat_time ?? 0);
                    $('.list-time-whg').html(summary.glyposate_time ?? 0);
                    $('.list-product').html(summary.total_product ?? 0);
                    $('.list-product-whp').html(summary.parakuat_product ?? 0);
                    $('.list-product-whg').html(summary.glyposate_product ?? 0);

                    let details = response.data_details;
                    let rowDetails = "";
                    if (details.length === 0) {
                        rowDetails = `<tr><td colspan="8" class="text-center">No Data Found</td></tr>`;
                    } else {
                        let grouped = {};
                        details.forEach(item => {
                            if (!grouped[item.no_po]) {
                                grouped[item.no_po] = [];
                            }
                            grouped[item.no_po].push(item);
                        });

                        // RENDER TABLE
                        $.each(grouped, function(no_po, items) {
                            let rowspan = items.length;

                            items.forEach((item, index) => {
                                rowDetails += `<tr>`;

                                if (index === 0) {
                                    rowDetails +=
                                        `<td rowspan="${rowspan}" style="vertical-align: middle;">${no_po}</td>`;
                                }

                                rowDetails += `
                                    <td>${item.batch}</td>
                                    <td>${item.start_time_po}</td>
                                    <td>${item.duration}</td>
                                    <td>${item.activity}</td>
                                    <td>${item.material_code}</td>
                                    <td>${item.material_start_time}</td>
                                    <td>${item.duration_qty} KG</td>
                                </tr>`;
                            });
                        });
                    }
                    $("#tb_report_produksi tbody").html(rowDetails);
                },
                complete: function() {
                    Swal.close();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat mengirim data: ' + error,
                        confirmButtonText: 'OK'
                    });
                    $('#exportPdfBtn').hide();
                }
            });
        }

        function exportToPDF(e) {
            if (e) e.preventDefault();
            // Get the content of the specific div with id "row-content"
            var contentToPrint = document.getElementById('row-content').innerHTML;

            // Create a new window for printing
            var printWindow = window.open('', '_blank');

            // Write the content to the new window
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print</title>
                        <style>
                            @page {
                               size: A2 landscape;
                            }
                        </style>
                        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css?v=1.0.0') }}" type="text/css">
                        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome/css/font-awesome.min.css?v=1.0.0') }}" />
                        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css?v=1.0.0') }}">
                        <link rel="stylesheet" href="{{ asset('assets/css/style.css?v=1.1.3') }}" />
                    </head>
                    <body>
                        ${contentToPrint}
                    </body>
                </html>
            `);

            // Close the document stream to finish the print
            printWindow.document.close();

            // Trigger the print function for the new window
            setTimeout(function() {
                // Trigger the print function for the new window
                printWindow.print();
            }, 4000); // Adjust the delay duration as needed

        }
    </script>
@endsection
