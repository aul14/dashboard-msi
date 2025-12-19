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
                <a href="{{ route('report.index') }}" class="btn btn-md btn-outline-warning">Refresh</a>
                <a href="javascript:void(0)" class="btn btn-md btn-outline-primary" onclick="searchReport(event)">Search</a>

            </div>
        </form>
    </div>
    <div class="row mt-3" id="row-content">
        <div class="col-12 col-md-3">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center">
                        <h6>Total PO</h6>
                        <H5>0</H5>
                    </li>
                    <li class="list-group-item text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Parakuat</h6>
                                <H5>0</H5>
                            </div>
                            <div class="col-md-6">
                                <h6>Glyposate</h6>
                                <H5>0</H5>
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
                        <H5>0</H5>
                    </li>
                    <li class="list-group-item text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Parakuat</h6>
                                <H5>0</H5>
                            </div>
                            <div class="col-md-6">
                                <h6>Glyposate</h6>
                                <H5>0</H5>
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
                        <H5>0</H5>
                    </li>
                    <li class="list-group-item text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Parakuat</h6>
                                <H5>0</H5>
                            </div>
                            <div class="col-md-6">
                                <h6>Glyposate</h6>
                                <H5>0</H5>
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
                        <H5>0</H5>
                    </li>
                    <li class="list-group-item text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Parakuat</h6>
                                <H5>0</H5>
                            </div>
                            <div class="col-md-6">
                                <h6>Glyposate</h6>
                                <H5>0</H5>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mt-3" id="row-table-content">
        <div class="col-12 col-md-12 table-responsive">
            <table id="tb_report_produksi" class="my-table table my-tableview my-table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No PO</th>
                        <th>Batch</th>
                        <th>Start Time</th>
                        <th>Duration</th>
                        <th>Activity</th>
                        <th>Material Code</th>
                        <th>Start</th>
                        <th>Duration</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
                    console.log(response);
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
                }
            });
        }
    </script>
@endsection
