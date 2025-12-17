@extends('app')
@section('content')
    <style>
        .icon {
            width: 50px;
            display: block;
            margin: 0 auto;
        }

        .label {
            margin-top: 5px;
            font-size: 0.9rem;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header mb-3">
                <h3 class="page-title">{{ $title }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <p class="mb-2">Status Connection</p>
            <div class="d-flex justify-content-center align-items-center">
                <div class="row w-100 text-center align-items-center">

                    <!-- Dashboard -->
                    <div class="col-auto">
                        <img src="{{ asset('assets/images/connections/dashboard.png') }}" class="icon" alt="Dashboard">
                        <p class="label">Dashboard</p>
                    </div>

                    <!-- Line -->
                    <div class="col">
                        <div class="border-top border-dark" style="height:2px;"></div>
                    </div>

                    <!-- Gateway -->
                    <div class="col-auto">
                        <img id="dashboard-gateway" src="{{ asset('assets/images/connections/on.png') }}" class="icon"
                            alt="Gateway">
                        <p class="label" id="label-dashboard-gateway">Connection</p>
                    </div>

                    <div class="col">
                        <div class="border-top border-dark" style="height:2px;"></div>
                    </div>

                    <div class="col-auto">
                        <img src="{{ asset('assets/images/connections/gateway.jpg') }}" class="icon" alt="Gateway">
                        <p class="label">Communication Gateway</p>
                    </div>

                    <div class="col">
                        <div class="border-top border-dark" style="height:2px;"></div>
                    </div>

                    <div class="col-auto">
                        <img id="plc-gateway" src="{{ asset('assets/images/connections/on.png') }}" class="icon"
                            alt="Gateway">
                        <p class="label" id="label-plc-gateway">Connection</p>
                    </div>

                    <!-- Line -->
                    <div class="col">
                        <div class="border-top border-dark" style="height:2px;"></div>
                    </div>

                    <!-- PLC -->
                    <div class="col-auto">
                        <img src="{{ asset('assets/images/connections/plc.png') }}" class="icon" alt="PLC">
                        <p class="label">PLC</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="col-md-12 mb-2">
                <button class="btn btn-lg btn-primary w-100" style="height:70px;"
                    onclick="openModalOperation()">Operation</button>
            </div>
            <div class="col-md-12 mb-2">
                <button class="btn btn-lg btn-primary w-100" style="height:70px;" onclick="openModalAlarms()">Alarm</button>
            </div>
            <div class="col-md-12 mb-2">
                <button class="btn btn-lg btn-primary w-100" style="height:70px;"
                    onclick="openModalSettings()">Settings</button>
            </div>
            <div class="col-md-12 mb-2">
                <a href="{{ route('paraquat.table') }}" class="btn btn-lg btn-primary w-100" style="height:70px;">
                    Table Parameter
                </a>
            </div>
            <div class="col-md-12 mb-2">
                <button onclick="openModalRealtimeLog()" class="btn btn-lg btn-primary w-100" style="height:70px;">
                    Realtime Log Machine
                </button>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4 my-2">
                    <div class="card-body bg-dark text-white" id="status-mesin-card">
                        Status Mesin
                    </div>
                </div>
                <div class="col-md-4 my-2">
                    <div class="card-body bg-dark text-white" id="po-no-card">
                        PO Number
                    </div>
                </div>
                <div class="col-md-4 my-2">
                    <div class="card-body bg-dark text-white" id="batch-code-card">
                        Batch Code
                    </div>
                </div>
                <div class="col-md-4 my-2">
                    <div class="card-body bg-dark text-white" id="duration-card">
                        Duration
                    </div>
                </div>
                <div class="col-md-4 my-2">
                    <div class="card-body bg-dark text-white" id="mode-machine-card">
                        Mode Machine
                    </div>
                </div>
                <div class="col-md-4 my-2">
                    <button id="btn-toggle-view" class="btn btn-lg btn-warning w-100 px-0">
                        Status Production
                    </button>
                </div>
            </div>
            <!-- SVG DEFAULT -->
            <div id="svg-container">
                <div class="row">
                    <div class="col-lg-12 col-sm-12" id="example-svg"></div>
                </div>
            </div>

            <!-- TABLE (HIDDEN BY DEFAULT) -->
            <div id="table-container" style="display:none;">
                <button id="btn-refresh" class="btn btn-primary mb-3" style="display:none;">
                    Refresh Table
                </button>
                <button id="create-data" class="btn btn-danger mb-3" style="display:none;">
                    Add Manual
                </button>

                <table class="table table-bordered" id="confirm-table">
                    <thead>
                        <tr>
                            <th>DateTime</th>
                            <th>PO Number</th>
                            <th>Batch</th>
                            <th>Type</th>
                            <th>Message</th>
                            <th>Qty</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('realtime.paraquat.modal.operation')
    @include('realtime.paraquat.modal.settings')
    @include('realtime.paraquat.modal.parameter_setting')
    @include('realtime.paraquat.modal.recipe_editor')
    @include('realtime.paraquat.modal.alarm')
    @include('realtime.paraquat.modal.realtime_log')
    @include('realtime.paraquat.modal.detail_operation')
    @include('realtime.paraquat.modal.create_manual')
@endsection
@section('script')
    <script>
        let wsAlarm = null;
        let wsConnectedAlarm = false;
        let wsRealtimeLog = null;
        let wsConnectedRealtimeLog = false;
        let currentPO = null;
        let currentBatch = null;
        let tableVisible = false;

        $(function() {
            startWebsocket();

            $('#modalOperation').on('shown.bs.modal', function() {
                $(`.select-nopo`).select2({
                    placeholder: 'Search...',
                    dropdownParent: $('#modalOperation'),
                    width: "100%",
                    allowClear: true,
                    ajax: {
                        url: '{{ route('search_no_po') }}',
                        dataType: 'json',
                        data: function(params) {
                            return {
                                search: params.term,
                                mrp_controller: 'WHP',
                            };
                        },
                        type: 'POST',
                        delay: 0,
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.prod_ord_no,
                                        id: item.prod_ord_no,
                                        prod_ord_no: item.prod_ord_no,
                                        material_code: item.material_code,
                                        material_desc: item.material_desc,
                                        qty_production: item.qty_production,
                                        batch: item.batch,
                                    }
                                })
                            };
                        },
                        cache: false
                    }
                }).on('select2:select', function(e) {
                    let poNumber = e.params.data.prod_ord_no;
                    let materialCode = e.params.data.material_code;
                    let materialDesc = e.params.data.material_desc;
                    let qtyProduction = e.params.data.qty_production;
                    let batch = e.params.data.batch;

                    $('#material_desc').val(materialDesc);
                    $('#uom_material_code').val(materialCode);
                    $('#qty_production').val(qtyProduction);
                    $('#batch').val(batch);

                    if (poNumber) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('batch_by_no_po') }}",
                            data: {
                                no_po: poNumber,
                                mrp_controller: 'WHP',
                            },
                            dataType: "json",
                            success: function(response) {
                                // kosongkan dulu option sebelumnya
                                $('#batch_code').empty();

                                // tambahkan option kosong default
                                $('#batch_code').append('<option value=""></option>');

                                // loop data response
                                $.each(response, function(index, item) {
                                    $('#batch_code').append(
                                        $('<option>', {
                                            value: item.batch_code,
                                            text: item.batch_code
                                        })
                                    );
                                });

                                $('#modalDetailOperation').on('shown.bs.modal',
                                    function() {
                                        let rows = "";

                                        if (response.length === 0) {
                                            rows =
                                                `<tr><td colspan="6" class="text-center">No Data Found</td></tr>`;
                                        } else {
                                            $.each(response, function(index, item) {
                                                rows += `
                                            <tr>
                                                <td>${index+1}</td>
                                                <td>${item.material_component}</td>
                                                <td>${item.material_component_desc}</td>
                                                <td>${item.material_packing_flag}</td>
                                                <td>${item.qty_component}</td>
                                                <td>${item.uom_component}</td>
                                            </tr>`;
                                            });
                                        }
                                        $("#tbl_detail_ops tbody").html(rows);
                                    }
                                )
                            }
                        });
                    }
                });
            })

            $("#modalAlarms").on("hidden.bs.modal", function() {
                if (wsAlarm) {
                    wsAlarm.close();
                    wsAlarm = null;
                    wsConnectedAlarm = false;
                }
            });

            $("#modalCreateManual").on("shown.bs.modal", function() {
                $('input[name=add_no_po]').val(currentPO);
                $('input[name=add_batch]').val(currentBatch);
            });

            $("#btn-toggle-view").on("click", function() {
                tableVisible = !tableVisible;

                if (tableVisible) {
                    $("#svg-container").hide();
                    $("#table-container").show();
                    $("#btn-refresh").show();
                    $("#create-data").show();
                    $(this).text("Back to HMI");

                    if (currentPO && currentBatch) {
                        loadTable(currentPO, currentBatch);
                    }
                } else {
                    $("#svg-container").show();
                    $("#table-container").hide();
                    $("#btn-refresh").hide();
                    $("#create-data").hide();
                    $(this).text("Status Production");
                }
            });

            $("#btn-refresh").on("click", function() {
                if (currentPO && currentBatch) {
                    loadTable(currentPO, currentBatch);
                }
            });

            $("#create-data").on("click", function() {
                if (!currentPO && !currentBatch) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Mesin belum di start. data po dan batch belum tersedia.',
                        confirmButtonText: 'OK'
                    });
                    return
                }
                $('#modalCreateManual').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#modalCreateManual").modal('show');

            });
        });

        function startWebsocket() {
            const tagJsonUrl = "{{ asset('assets/json/paraquat.json') }}" + "?v=" + new Date().getTime();
            let tagMap = {};

            fetch(tagJsonUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(map => {
                    tagMap = map;

                    let ws_url = $("input[name=ws_url]").val();
                    let ws = new WebSocket(`${ws_url}/Parakuat`);

                    ws.onopen = () => console.log('Connection Established');

                    let svgExample = "{{ asset('assets/images/svg/Paraquat_Graphic_V1.svg') }}" + "?v=" + new Date()
                        .getTime();
                    scadavisInit({
                        container: 'example-svg',
                        iframeparams: 'frameborder="0" height="450" width="100%"',
                        svgurl: svgExample
                    }).then(sv => {
                        sv.zoomTo(0.60);
                        sv.enableTools(true, true);
                        sv.hideWatermark();

                        ws.onmessage = function(e) {
                            let data = JSON.parse(e.data);
                            let dataWs = data.Data;

                            Object.entries(tagMap).forEach(([path, selector]) => {
                                const value = getValueByPath(data, path);
                                if (value !== undefined) {
                                    sv.storeValue(selector, value);
                                }
                            });

                            sv.updateValues();

                            currentPO = dataWs.Analog.PO_Number;
                            currentBatch = dataWs.Analog.Kode_Batch;

                            let statusConnect = dataWs.Status.bool;
                            let plcStatusConnect = dataWs.Digital.PLC_Connection;
                            let statusMesinCard = dataWs.Buffer.StatusMesin;
                            let poNumberCard = dataWs.Analog.PO_Number;
                            let batchCodeCard = dataWs.Analog.Kode_Batch;
                            let durationCard = dataWs.Buffer.Duration;
                            let modeMachineCard = dataWs.Digital.Control_ON_OFF_Auto == 1 ? "Auto" :
                                "Manual";

                            let $imgDashboard = $("#dashboard-gateway");
                            if (statusConnect == 1) {
                                $imgDashboard.attr("src",
                                    "{{ asset('assets/images/connections/on.png') }}");
                                $imgDashboard.addClass("blink");
                                $('#label-dashboard-gateway').html('Connected');
                            } else {
                                $imgDashboard.attr("src",
                                    "{{ asset('assets/images/connections/off.png') }}");
                                $imgDashboard.addClass("blink");
                                $('#label-dashboard-gateway').html('Disconnected');
                            }

                            let $imgPlc = $("#plc-gateway");
                            if (plcStatusConnect == 1) {
                                $imgPlc.attr("src", "{{ asset('assets/images/connections/on.png') }}");
                                $imgPlc.addClass("blink");
                                $('#label-plc-gateway').html('Connected');
                            } else {
                                $imgPlc.attr("src", "{{ asset('assets/images/connections/off.png') }}");
                                $imgPlc.addClass("blink");
                                $('#label-plc-gateway').html('Disconnected');
                            }

                            $('#status-mesin-card').html(`Status Mesin: ${statusMesinCard}`)
                            $('#po-no-card').html(`PO Number: ${poNumberCard}`)
                            $('#batch-code-card').html(`Batch Code: ${batchCodeCard}`)
                            $('#duration-card').html(`Duration: ${durationCard}`)
                            $('#mode-machine-card').html(`Mode Machine: ${modeMachineCard}`)

                            $('#modalSettings').on('shown.bs.modal', function() {
                                let setRM1 = dataWs.Analog.RM1;
                                let setRM2 = dataWs.Analog.RM2;
                                let setRM3 = dataWs.Analog.RM3;
                                let setRM4 = dataWs.Analog.RM4;
                                let setStorage1 = dataWs.Analog.Storage1;
                                let setStorage2 = dataWs.Analog.Storage2;
                                let setStorage3 = dataWs.Analog.Storage3;
                                let setStorage4 = dataWs.Analog.Storage4;

                                $('#setting_rm1').val(setRM1);
                                $('#setting_rm2').val(setRM2);
                                $('#setting_rm3').val(setRM3);
                                $('#setting_rm4').val(setRM4);
                                $('#setting_storage1').val(setStorage1);
                                $('#setting_storage2').val(setStorage2);
                                $('#setting_storage3').val(setStorage3);
                                $('#setting_storage4').val(setStorage4);
                            })

                            $('#modalParameterSetting').on('shown.bs.modal', function() {
                                let setParamStep1 = dataWs.Analog.Setting_Parm_Step1;
                                let setParamStep2 = dataWs.Analog.Setting_Parm_Step2;
                                let setParamStep3 = dataWs.Analog.Setting_Parm_Step3;
                                let setParamStep4 = dataWs.Analog.Setting_Parm_Step4;
                                let setParamSpeed1 = dataWs.Analog.Setting_Parm_Speed1;
                                let setParamSpeed2 = dataWs.Analog.Setting_Parm_Speed2;

                                $('#Setting_Param_Step1').val(setParamStep1);
                                $('#Setting_Param_Step2').val(setParamStep2);
                                $('#Setting_Param_Step3').val(setParamStep3);
                                $('#Setting_Param_Step4').val(setParamStep4);
                                $('#Setting_Param_Speed1').val(setParamSpeed1);
                                $('#Setting_Param_Speed2').val(setParamSpeed2);
                            })

                            $('#modalSettings').on('shown.bs.modal', function() {
                                const RM_1 = dataWs.Analog.RM1;
                                const RM_2 = dataWs.Analog.RM2;
                                const RM_3 = dataWs.Analog.RM3;
                                const RM_4 = dataWs.Analog.RM4;
                                const Storage_1 = dataWs.Analog.Storage1;
                                const Storage_2 = dataWs.Analog.Storage2;
                                const Storage_3 = dataWs.Analog.Storage3;
                                const Storage_4 = dataWs.Analog.Storage4;

                                $('#RM1').val(RM_1);
                                $('#RM2').val(RM_2);
                                $('#RM3').val(RM_3);
                                $('#RM4').val(RM_4);
                                $('#Storage1').val(Storage_1);
                                $('#Storage2').val(Storage_2);
                                $('#Storage3').val(Storage_3);
                                $('#Storage4').val(Storage_4);
                            })

                            $('#modalRecipeEditor').on('shown.bs.modal', function() {
                                for (let i = 1; i <= 4; i++) {
                                    $('#row_recipe_' + i + '_tag').text(dataWs.Analog[
                                        'Edit_Recipe' + i + '_Tag']);
                                    for (let j = 1; j <= 4; j++) {
                                        $('#row_recipe_' + i + '_step' + j).text(dataWs.Analog[
                                            'Edit_Recipe' + i + '_Step' + j]);
                                    }
                                }
                            })
                        };
                    });

                    ws.onerror = function(err) {
                        console.error('WebSocket error:', err);
                    };

                    ws.onclose = function() {
                        // connection closed, discard old websocket and create a new one in 5s
                        ws = null
                        setTimeout(startWebsocket, 5000)
                    }
                }).catch(err => {
                    console.error('Gagal memuat tagMap JSON:', err);
                });
        }

        function loadTable(po, batch) {
            $.ajax({
                url: "{{ route('log_confirmation.filter') }}",
                type: "GET",
                data: {
                    po_number: po,
                    batch: batch,
                    mrp_controller: 'WHP',
                },
                beforeSend: function() {
                    $("#confirm-table tbody").html(
                        `<tr><td colspan="7" class="text-center">Loading...</td></tr>`
                    );
                },
                success: function(res) {
                    let rows = "";

                    if (res.data.length === 0) {
                        rows = `<tr><td colspan="7" class="text-center">No Data Found</td></tr>`;
                    } else {
                        res.data.forEach(item => {
                            rows += `
                            <tr>
                                <td>${formatDate(item.created_at)}</td>
                                <td>${item.po_number}</td>
                                <td>${item.batch}</td>
                                <td>${item.type}</td>
                                <td>${item.type_message}</td>
                                <td>${item.qty}</td>
                                <td>${item.duration}</td>
                            </tr>`;
                        });
                    }

                    $("#confirm-table tbody").html(rows);
                }
            });
        }

        function formatDate(dateString) {
            const d = new Date(dateString);
            return d.getFullYear() + "-" +
                String(d.getMonth() + 1).padStart(2, '0') + "-" +
                String(d.getDate()).padStart(2, '0') + " " +
                String(d.getHours()).padStart(2, '0') + ":" +
                String(d.getMinutes()).padStart(2, '0') + ":" +
                String(d.getSeconds()).padStart(2, '0');
        }

        function getValueByPath(obj, path) {
            return path.split('.').reduce((acc, part) => acc && acc[part], obj);
        }

        function btnStartFinishOperation(optionBtn) {
            let noPo = $('select[name=prod_ord_no]').val() ? $('select[name=prod_ord_no]').val() : currentPO;
            let batchNumber = $('select[name=batch_code]').val() ? $('select[name=batch_code]').val() : currentBatch;

            if (optionBtn === 'start') {
                // 🔹 Validasi: pastikan tidak kosong
                if (!noPo || !batchNumber) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data belum lengkap',
                        text: 'Nomor PO dan Kode Batch wajib diisi!',
                        confirmButtonText: 'OK'
                    });
                    return; // hentikan eksekusi
                }
            }

            // 🔹 Kirim API POST
            $.ajax({
                url: '{{ route('start_finish_ops') }}',
                type: 'POST',
                data: {
                    action: optionBtn,
                    po_number: noPo,
                    batch_number: batchNumber,
                    mrp_controller: 'WHP',
                },
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil dikirim!',
                        confirmButtonText: 'OK'
                    });
                    $('#modalOperation').hide();
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

        function btnEditSettings(button) {
            const row = button.closest('.form-group');
            const input = row.querySelector('input');
            input.removeAttribute('readonly');
            input.focus();
        }

        function btnSaveSettings(button) {
            const row = button.closest('.form-group');
            const input = row.querySelector('input');
            const key = input.id.replace('setting_', ''); // contoh: setting_rm1 -> rm1
            const value = input.value.trim();

            // Siapkan body JSON
            const body = {};
            body[key] = value;

            input.setAttribute('readonly', true);

            $.ajax({
                url: '{{ env('NODERED_URL') }}' + 'Parakuat/SettingParameter',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(body),
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil dikirim!',
                        confirmButtonText: 'OK'
                    });
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

        function btnSaveAddManual(button) {
            $.ajax({
                type: "POST",
                url: "{{ route('add_manual_confirmation') }}",
                data: {
                    po_number: $('input[name=add_no_po]').val(),
                    batch: $('input[name=add_batch]').val(),
                    type: $('select[name=add_type]').val(),
                    duration: $('input[name=add_duration]').val(),
                    type_message: $('input[name=add_type_message]').val(),
                    material_number: $('input[name=add_material_number]').val(),
                    sloc: $('input[name=add_sloc]').val(),
                    type_message: $('input[name=add_type_message]').val(),
                    qty: $('input[name=add_qty]').val(),
                    start_time: new Date().toISOString().slice(0, 19).replace('T', ' '),
                    mrp_controller: 'WHP'
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
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });

                        loadTable($('input[name=add_no_po]').val(), $('input[name=add_batch]').val())
                        $('#modalCreateManual').hide()
                        return
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message ?? 'Sepertinya ada kesalahan.',
                            confirmButtonText: 'OK'
                        });
                        return
                    }
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

        function openModalRealtimeLog() {
            $('#modalRealtimeLog').modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modalRealtimeLog").modal('show');

            if (!wsConnectedRealtimeLog) {
                connectWebSocketRealtimeLog();
            }
        }

        function openModalDetailOperation() {
            $('#modalDetailOperation').modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modalDetailOperation").modal('show');
        }

        function connectWebSocketRealtimeLog() {
            let wsUrlRtLog = $("input[name=ws_url]").val();

            wsRealtimeLog = new WebSocket(`${wsUrlRtLog}/Parakuat/RealTimeLog`);

            wsRealtimeLog.onopen = function() {
                console.log("WS Connected Realtime Log");
                wsConnectedRealtimeLog = true;
            };

            wsRealtimeLog.onmessage = function(event) {
                try {
                    const logList = document.getElementById("logList");

                    const li = document.createElement("li");
                    li.classList.add("list-group-item");

                    li.textContent = event.data;

                    logList.appendChild(li);
                } catch (e) {
                    console.error("Invalid JSON:", e);
                }
            };

            wsRealtimeLog.onerror = function() {
                console.error("WS Realtime Log Error");
            };

            wsRealtimeLog.onclose = function() {
                console.log("WS Realtime Log closed");
                wsConnectedRealtimeLog = false;
            };
        }

        function openModalOperation() {
            $('#modalOperation').modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modalOperation").modal('show');
        }

        function openModalSettings() {
            $('#modalSettings').modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modalSettings").modal('show');
        }

        function openModalAlarms() {
            $('#modalAlarms').modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modalAlarms").modal('show');

            if (!wsConnectedAlarm) {
                connectWebSocketAlarm();
            }
        }

        function connectWebSocketAlarm() {
            let wsUrlAlarm = $("input[name=ws_url]").val();

            wsAlarm = new WebSocket(`${wsUrlAlarm}/Parakuat/Alarm`);

            wsAlarm.onopen = function() {
                console.log("WS Connected Alarm");
                wsConnectedAlarm = true;
            };

            wsAlarm.onmessage = function(event) {
                try {
                    const data = JSON.parse(event.data);
                    renderAlarmTable(data);
                } catch (e) {
                    console.error("Invalid JSON:", e);
                }
            };

            wsAlarm.onerror = function() {
                console.error("WS Alarm Error");
            };

            wsAlarm.onclose = function() {
                console.log("WS Alarm Closed");
                wsConnectedAlarm = false;
            };
        }


        function renderAlarmTable(data) {
            let tbody = $("#tbl-alarms tbody");
            tbody.empty();

            let index = 1;

            Object.keys(data).forEach(key => {
                let item = data[key];

                tbody.append(`
                    <tr style="color:${item.color};font-weight:bold;">
                        <td>${index++}</td>
                        <td>${item.alarm}</td>
                        <td>${item.massage}</td>
                        <td>${item.values}</td>
                        <td>${item.start} (${item.duration})</td>
                    </tr>
                `);
            });
        }

        function openModalParameterSett() {
            // sembunyikan modal utama
            $("#modalSettings").modal('hide');

            // buka modal kedua
            $('#modalParameterSetting').modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modalParameterSetting").modal('show');

            // ketika modal kedua ditutup, tampilkan lagi modal utama
            $('#modalParameterSetting').off('hidden.bs.modal').on('hidden.bs.modal', function() {
                $("#modalSettings").modal('show');
            });
        }

        function openModalRecipe() {
            // sembunyikan modal utama
            $("#modalSettings").modal('hide');

            // buka modal ketiga
            $('#modalRecipeEditor').modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modalRecipeEditor").modal('show');

            // ketika modal ketiga ditutup, tampilkan lagi modal utama
            $('#modalRecipeEditor').off('hidden.bs.modal').on('hidden.bs.modal', function() {
                $("#modalSettings").modal('show');
            });
        }
    </script>
@endsection
