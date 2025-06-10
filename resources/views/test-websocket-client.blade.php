<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TESTING</title>
</head>

<body>
    <h1>HELLO WORLD</h1>
    <H3 class="test"></H3>

    <div id="container"></div>

    <input type="hidden" name="ws_url" value="{{ env('WS_URL') }}">



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="http://www.datejs.com/build/date.js" type="text/javascript"></script>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>

</body>

<script>
    $(function() {
        // Create the chart
        Highcharts.stockChart('container', {
            chart: {
                events: {
                    load: function() {
                        const chart = this;
                        const series = chart.series[0];

                        // Fungsi untuk memperbarui titik data setiap detik
                        setInterval(() => {
                            const x = (new Date()).getTime(),
                                y = Math.round(Math.random() * 100);

                            series.addPoint([x, y], true, true);

                            // Hanya tampilkan tooltip di titik terakhir jika kursor tidak di grafik
                            if (!chart.pointer.inClass(chart.container,
                                    'highcharts-mouse-over')) {
                                chart.tooltip.refresh(series.points[series.points.length -
                                    1]);
                            }
                        }, 1000);

                        // Event listener untuk menghilangkan tooltip jika kursor keluar
                        Highcharts.addEvent(chart.container, 'mouseleave', function() {
                            chart.tooltip.refresh(series.points[series.points.length - 1]);
                        });

                        // Event listener untuk mengembalikan tooltip agar mengikuti kursor saat ada interaksi
                        Highcharts.addEvent(chart.container, 'mousemove', function() {
                            chart.tooltip.hide();
                        });
                    }
                }
            },
            credits: {
                enabled: false
            },
            accessibility: {
                enabled: false
            },
            time: {
                useUTC: false
            },
            rangeSelector: {
                buttons: [{
                    count: 1,
                    type: 'minute',
                    text: '1M'
                }, {
                    count: 5,
                    type: 'minute',
                    text: '5M'
                }, {
                    count: 10,
                    type: 'minute',
                    text: '10M'
                }, {
                    count: 30,
                    type: 'minute',
                    text: '30M'
                }, {
                    count: 60,
                    type: 'minute',
                    text: '60M'
                }, {
                    type: 'all',
                    text: 'All'
                }],
                inputEnabled: false,
                selected: 0
            },
            title: {
                text: 'Live random data'
            },
            exporting: {
                enabled: false
            },
            tooltip: {
                enabled: true,
                split: true,
                followPointer: true, // Tooltip mengikuti kursor
                hideDelay: 0 // Tooltip tidak menghilang saat kursor keluar
            },
            xAxis: {
                crosshair: {
                    color: 'gray',
                    dashStyle: 'solid'
                }
            },
            series: [{
                name: 'Random data',
                data: (function() {
                    const data = [],
                        time = (new Date()).getTime();

                    for (let i = -3377; i <= 0; i += 1) {
                        data.push([
                            time + i * 1000,
                            Math.round(Math.random() * 100)
                        ]);
                    }
                    return data;
                }())
            }]
        });



    });
    $(function() {
        function addZero(i) {
            if (i < 10) {
                i = "0" + i
            }
            return i;
        }

        function startWebsocket() {
            let ws_url = $("input[name=ws_url]").val();

            var ws = new WebSocket(`${ws_url}/WS`);

            ws.onopen = function(event) {
                console.log('Connection Established');
            };

            ws.onmessage = function(e) {
                var data = JSON.parse(e.data);

                $(".test").html(
                    `websocket message event: TAG 1 = ${data.TAG1}, TAG 2 = ${data.TAG2}, TAG 3 = ${data.TAG3}`
                );
            }

            ws.onclose = function() {
                // connection closed, discard old websocket and create a new one in 5s
                ws = null
                setTimeout(startWebsocket, 5000)
            }
        }

        startWebsocket();

    });
</script>

</html>
