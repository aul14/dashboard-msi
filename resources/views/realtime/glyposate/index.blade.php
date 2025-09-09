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
        <div class="col-md-4 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-1">
                            <div class="form-group row mb-1">
                                <label for="connection_status" class="col-sm-5 col-form-label">Connection Status</label>
                                <div class="col-sm-7">
                                    <input type="checkbox" name="connection_status" id="connection_status" value="connected"
                                        data-toggle="toggle" data-on="Connected" data-off="Disconnected"
                                        data-onstyle="primary" data-offstyle="danger">
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="mode" class="col-sm-5 col-form-label">Mode</label>
                                <div class="col-sm-7">
                                    <input type="checkbox" name="mode" id="mode" value="manual" data-toggle="toggle"
                                        data-on="Manual" data-off="Auto" data-onstyle="primary" data-offstyle="danger">
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="comment_process" class="col-sm-5 col-form-label">Comment Process</label>
                                <div class="col-sm-7">
                                    <input type="text" name="comment_process" id="comment_process" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="control" class="col-sm-5 col-form-label">Control</label>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="control" id="control" value="on" data-toggle="toggle"
                                        data-on="ON" data-off="OFF" data-onstyle="primary" data-offstyle="danger">
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-primary">Setting</button>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="po_number" class="col-sm-5 col-form-label">PO Number</label>
                                <div class="col-sm-7">
                                    <select name="po_number" id="po_number" class="form-select">
                                        <option value="">PO Number</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="batch_code" class="col-sm-5 col-form-label">Batch Code</label>
                                <div class="col-sm-7">
                                    <select name="batch_code" id="batch_code" class="form-select">
                                        <option value="">Batch Code</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="auto_process" class="col-sm-5 col-form-label">Auto Process</label>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-primary">Start</button>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="storage" class="col-sm-5 col-form-label">Storage</label>
                                <div class="col-sm-7">
                                    <select name="storage" id="storage" class="form-select">
                                        <option value="">Storage</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body p-1">
                                            <h6>RM STATUS</h6>
                                            <div class="form-group row mb-1">
                                                <p class="col-sm-8">Glyposate Acid</p>
                                                <p class="col-sm-4 px-0">7.500</p>
                                            </div>
                                            <div class="form-group row mb-1">
                                                <p class="col-sm-8">Ammonia Cair</p>
                                                <p class="col-sm-4 px-0">7.500</p>
                                            </div>
                                            <div class="form-group row mb-1">
                                                <p class="col-sm-8">Adsee C70 A</p>
                                                <p class="col-sm-4 px-0">7.500</p>
                                            </div>
                                            <div class="form-group row mb-1">
                                                <p class="col-sm-8">Mono Ethylen Glycol Tech</p>
                                                <p class="col-sm-4 px-0">7.500</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body p-1">
                                            <h6>STORAGE STATUS</h6>
                                            <div class="form-group row mb-1">
                                                <p class="col-sm-8">Storage-1</p>
                                                <p class="col-sm-4 px-0">9250</p>
                                            </div>
                                            <div class="form-group row mb-1">
                                                <p class="col-sm-8">Storage-2</p>
                                                <p class="col-sm-4 px-0">9250</p>
                                            </div>
                                            <div class="form-group row mb-1">
                                                <p class="col-sm-8">Storage-3</p>
                                                <p class="col-sm-4 px-0">9250</p>
                                            </div>
                                            <div class="form-group row mb-1">
                                                <p class="col-sm-8">Storage-4</p>
                                                <p class="col-sm-4 px-0">9250</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body p-1">
                                            <h6>MIXER STATUS</h6>
                                            <div class="form-group row mb-1">
                                                <p class="col-sm-8">Mixer</p>
                                                <p class="col-sm-4 px-0">4580</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="col-lg-12 col-sm-12" id="example-svg"></div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            startWebsocket();
        });

        function startWebsocket() {
            const tagJsonUrl = "{{ asset('assets/json/testtag.json') }}";

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
                    let ws = new WebSocket(`${ws_url}/Gyposat`);

                    ws.onopen = () => console.log('Connection Established');

                    let svgExample = "{{ asset('assets/images/svg/Glyphosate_Graphic_V2.svg') }}";
                    scadavisInit({
                        container: 'example-svg',
                        iframeparams: 'frameborder="0" height="400" width="800"',
                        svgurl: svgExample
                    }).then(sv => {
                        sv.zoomTo(0.45);
                        sv.enableTools(true, true);
                        sv.hideWatermark();

                        ws.onmessage = function(e) {
                            let data = JSON.parse(e.data);

                            // Object.entries(tagMap).forEach(([path, selector]) => {
                            //     const value = getValueByPath(data, path);
                            //     if (value !== undefined) {
                            //         sv.storeValue(selector, value);
                            //     }
                            // });

                            // sv.updateValues();
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
