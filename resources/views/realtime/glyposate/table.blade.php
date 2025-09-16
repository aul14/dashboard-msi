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
        <div class="col-md-12" style="overflow-y: auto;">
            <table id="glyposate-table" class="my-table table my-tableview my-table-striped table-hover w-100">
                <thead></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            startWebsocket();
        });

        function getValueByPath(obj, path) {
            // dukung array index seperti Inv1_Frequency[0]
            return path.split('.').reduce((acc, part) => {
                let match = part.match(/(\w+)\[(\d+)\]/);
                if (match) {
                    let prop = match[1];
                    let index = parseInt(match[2], 10);
                    return acc && acc[prop] ? acc[prop][index] : undefined;
                }
                return acc && acc[part];
            }, obj);
        }

        async function startWebsocket() {
            const tagJsonUrl = "{{ asset('assets/json/glyposate_table.json') }}" + "?v=" + new Date().getTime();
            let response = await fetch(tagJsonUrl);
            let config = await response.json();

            let parameters = config.Parameters;

            // build header
            let thead = $("#glyposate-table thead");
            let tbody = $("#glyposate-table tbody");

            thead.empty();
            tbody.empty();

            let headerRow = $("<tr>");
            headerRow.append("<th>Parameter</th>");
            headerRow.append("<th>Value</th>");
            thead.append(headerRow);

            // build tbody rows, satu parameter = satu baris
            parameters.forEach((p, idx) => {
                let row = $("<tr>");
                row.append(`<td>${p.name_parameter}</td>`);
                row.append(`<td id="param-${idx}">-</td>`);
                tbody.append(row);
            });

            let ws_url = $("input[name=ws_url]").val();
            let ws = new WebSocket(`${ws_url}/Glyposate`);

            ws.onopen = () => console.log("Connection Established");

            // buka websocket...
            ws.onmessage = function(e) {
                let data = JSON.parse(e.data);

                parameters.forEach((p, idx) => {
                    let val = getValueByPath(data, p.key);
                    if (val !== undefined) {
                        $(`#param-${idx}`).text(val);
                    }
                });
            };

            ws.onerror = function(err) {
                console.error("WebSocket error:", err);
            };

            ws.onclose = function() {
                console.warn("WebSocket closed, reconnecting...");
                setTimeout(startWebsocket, 5000);
            };
        }
    </script>
@endsection
