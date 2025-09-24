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
                        <img src="{{ asset('assets/images/connections/on.png') }}" class="icon" alt="Gateway">
                        <p class="label">Connection</p>
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
                <button class="btn btn-lg btn-primary w-100" style="height:70px;">Operation</button>
            </div>
            <div class="col-md-12 mb-2">
                <button class="btn btn-lg btn-primary w-100" style="height:70px;">HMI Mesin</button>
            </div>
            <div class="col-md-12 mb-2">
                <button class="btn btn-lg btn-primary w-100" style="height:70px;">Settings</button>
            </div>
            <div class="col-md-12 mb-2">
                <button class="btn btn-lg btn-primary w-100" style="height:70px;">Table Parameter</button>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <div class="col-md-2">
                    <div class="card-body bg-dark text-white">
                        Status Mesin
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body bg-dark text-white">
                        PO Number
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body bg-dark text-white">
                        Batch Code
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body bg-dark text-white">
                        Duration
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body bg-dark text-white">
                        Auto/Manual
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-lg btn-warning w-100 px-0">
                        Status Production
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12" id="example-svg"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            startWebsocket();
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
                        iframeparams: 'frameborder="0" height="400" width="930"',
                        svgurl: svgExample
                    }).then(sv => {
                        sv.zoomTo(0.55);
                        sv.enableTools(true, true);
                        sv.hideWatermark();

                        ws.onmessage = function(e) {
                            let data = JSON.parse(e.data);

                            Object.entries(tagMap).forEach(([path, selector]) => {
                                const value = getValueByPath(data, path);
                                if (value !== undefined) {
                                    sv.storeValue(selector, value);
                                }
                            });

                            sv.updateValues();
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

        function getValueByPath(obj, path) {
            return path.split('.').reduce((acc, part) => acc && acc[part], obj);
        }
    </script>
@endsection
