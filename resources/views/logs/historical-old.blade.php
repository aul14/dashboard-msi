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
        <div class="col-lg-12">
            <form action="{{ route('logs.historical') }}" method="get" class="form-history">
                {{-- @csrf --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group overflow-auto">
                            <label>Daterange <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <input type="text" name="date_start" autocomplete="off" required
                                    value="{{ $date_start }}" placeholder="Start Date"
                                    class="daterangepicker-field form-control text-center">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                <input type="text" name="date_end" autocomplete="off" required
                                    value="{{ $date_end }}" placeholder="End Date"
                                    class="daterangepicker-field form-control text-center">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Area <span style="color: red;">*</span></label>
                            <select name="area" id="area" required class="form-select">
                                <option value="">Search...</option>
                                <option value="Feeder Control Panel">Feeder Control Panel</option>
                                <option value="Extruder Control Panel">Extruder Control Panel</option>
                                <option value="P-RAW MATERIAL CHARGING">P-RAW MATERIAL CHARGING</option>
                                <option value="P-Water Cut (Strand Drying)">P-Water Cut (Strand Drying)</option>
                                <option value="P-Water Bed">P-Water Bed</option>
                                <option value="P-Pelletizer">P-Pelletizer</option>
                                <option value="Sorting Machine Control Panel">Sorting Machine Control Panel
                                </option>
                                <option value="Panel Blower & Vacuum">Panel Blower & Vacuum</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Search Parameters <span style="color: red;">*</span></label>
                            <select class="select-params w-100" name="params[]" required multiple="multiple">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ route('logs.historical') }}" class="btn btn-md btn-warning">Reset</a>
                        <button type="button" id="submitForm" class="btn btn-md btn-primary">Search</button>
                        <a href="javascript:void(0)" style="display: none;" id="exportPdfBtn"
                            class="btn btn-md btn-danger">Export to PDF</a>
                        <a href="javascript:void(0)" style="display: none;" id="exportExcelBtn"
                            class="btn btn-md btn-success">Export to Excel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <div class="row row-null">
        <div class="col-lg-12">
            <h5 class="text-center">Historical Charts</h5>
            <div class="msc-blank">
                <div class="msc-blank-icon">⚠</div>
                <div class="msc-blank-title">
                    No records have been added yet
                </div>
                <div class="msc-blank-desc">
                    Please fill in the parameters above first
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row row-notnull" id="row-content">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12 col-charts">
                    <div class="headercharts"></div>
                    <div id="linecharts"></div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12">
                    <div class="tablecharts overflow-auto"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/excel/tableExport.min.js') }}"></script>
    <script src="{{ asset('assets/js/excel/xlsx.full.min.js') }}"></script>

    <script>
        let seriesData = [],
            req = [],
            newData = [],
            tagsArray = [],
            date_starts,
            chart;
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Click button pdf
            $('#exportPdfBtn').on('click', function(e) {
                e.preventDefault();

                exportToPDF();
            });
            // Click button excel
            $('#exportExcelBtn').click(function(e) {
                e.preventDefault();

                exportToExcel();
                // $(".my-tablelogs").tableExport({
                //     type: 'csv',
                //     escape: 'false',
                //     fileName: 'exported_data',
                // });
            });

            $('#submitForm').on('click', function(e) {
                e.preventDefault();

                let params = $('.form-history .select-params').val(),
                    date_start = $('.form-history input[name=date_start]').val(),
                    date_end = $('.form-history input[name=date_end]').val(),
                    area = $('.form-history select[name=area]').val();

                if (date_start.trim() === '' && date_end.trim() === '') {
                    alert('Daterange cannot be empty!');
                    return
                }

                if (area.trim() === '') {
                    alert('Area cannot be empty!');
                    return
                }

                if (params.length === 0) {
                    alert('Parameters cannot be empty!');
                    return
                }
                // Get form action and serialize form data
                let formAction = $('.form-history').attr('action');
                let formData = $('.form-history').serialize();
                let dt_start = `${$('.form-history input[name=date_start]').val()}:00`;
                let dt_end = `${$('.form-history input[name=date_end]').val()}:59`;

                let paramsArray = params.map(function(item) {
                    return item.replace(/,/g, ';');
                });

                let len = paramsArray.length;
                let params_id = [],
                    params_name = [];


                paramsArray.forEach(val => {
                    params_id.push(parseFloat(val.split("|")[0]));
                    tagsArray.push(val.split("|")[1]);
                    params_name.push(val.split("|")[2]);
                });

                req = [];
                newData = [];
                seriesData = [];

                fetchData(1, dt_start, dt_end, params_id, params_name);
            });
        });

        async function fetchData(page, dt_start, dt_end, params_id, params_name) {
            let res, theadData, tbodyData = [];
            try {
                $('.ajax-loader').css("visibility", "visible");

                const response = await fetch('{{ route('logs.historical.data') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        dt_start: dt_start,
                        dt_end: dt_end,
                        page: page,
                        _token: '{{ csrf_token() }}'
                    }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                res = await response.json();

                // Process the data
                let data = res.data;

                const valuesForKeys = getValuesForKeys(data, params_id);
                const transposedArray = valuesForKeys[0].map((_, index) => valuesForKeys.map(row => row[index]));

                let date_starts = dt_start;

                theadData = params_name;

                let newDataForPage = [],
                    timestampArray = [],
                    shortTimestamps = [];

                for (let i = 0; i < params_id.length; i++) {
                    const time = new Date(dt_end).getTime();

                    timestampArray.push(data.map(item => {
                        const jakartaTime = new Date(item.created_at);
                        return jakartaTime.getTime();
                    }));

                    const sortedTimestamps = [...timestampArray[i]].sort((a, b) => b - a);

                    shortTimestamps.push(sortedTimestamps);

                    let dataForParamsId = [];
                    for (let j = -(transposedArray[i].length - 1); j <= 0; j += 1) {
                        dataForParamsId.push([
                            shortTimestamps[i][0 - j],
                            parseFloat(transposedArray[i][0 - j])
                        ]);
                    }
                    newDataForPage.push({
                        params_name: params_name[i],
                        data: dataForParamsId
                    });
                }

                newData = newData.concat(newDataForPage);

                const groupedData = newData.reduce((acc, item) => {
                    const key = item.params_name;
                    if (!acc[key]) {
                        acc[key] = [];
                    }
                    acc[key] = acc[key].concat(item.data);
                    return acc;
                }, {});

                req = [];
                tbodyData = []
                let dateTimeData = [];
                Object.keys(groupedData).forEach(function(key) {
                    tbodyData.push(groupedData[key].map(item => item[1]));
                    dateTimeData.push(groupedData[key].map(item => item[0]));

                    req.push({
                        "name": key,
                        "marker": {
                            enabled: true
                        },
                        "data": groupedData[key]
                    });
                });

                seriesData = req;

                historicalCharts();

                // Display the main table
                displayMainTable(theadData, tbodyData, dateTimeData[0], dt_start, dt_end);

                // Fetch the next page if needed
                if (res.current_page < res.last_page) {
                    await delay(1000); // Adjust the delay as needed
                    await fetchData(res.current_page + 1, dt_start, dt_end, params_id, params_name);
                }
            } catch (error) {
                console.error('An error occurred:', error);
            } finally {
                if (res.current_page === res.last_page) {
                    $('.ajax-loader').css("visibility", "hidden");
                    // Calculate and display final statistics table
                    displayFinalStatisticsLarge(theadData, tbodyData);

                    req = [];
                    newData = [];
                    seriesData = [];

                    $('#exportPdfBtn').show();
                    $('#exportExcelBtn').show();
                }


            }
        }

        const delay = ms => new Promise(res => setTimeout(res, ms));

        function exportToExcel() {
            // Show image container
            $('.ajax-loader').css("visibility", "visible");

            // Create a workbook
            let wb = XLSX.utils.book_new();

            // Create an empty worksheet
            let ws = XLSX.utils.aoa_to_sheet([]);

            // Extract the title
            let title = "Report Historical Logs";

            // Append the title to the worksheet data
            ws = XLSX.utils.sheet_add_aoa(ws, [
                [title]
            ], {
                origin: -1
            });

            $(".navbar table tbody tr").each(function() {
                let rowData = [];
                $(this).find('td').each(function() {
                    rowData.push($(this).text());
                });
            });

            // Extract data from the headercharts div
            let headerData = [];
            $(".headercharts table tbody tr").each(function() {
                let rowData = [];
                $(this).find('td').each(function() {
                    rowData.push($(this).text());
                });
                headerData.push(rowData);
            });

            // Append the header data to the worksheet data
            ws = XLSX.utils.sheet_add_aoa(ws, headerData, {
                origin: -1
            });

            // Iterate over each table with the class 'my-tablelogs'
            $(".my-tablelogs").each(function(index) {
                // Convert the table to a 2D array
                let tableData = [];

                // Extract the table header
                let headerRow = [];
                $(this).find('thead th').each(function() {
                    headerRow.push($(this).text());
                });
                tableData.push(headerRow);

                // Extract the table rows
                $(this).find('tbody tr').each(function() {
                    let rowData = [];
                    $(this).find('td').each(function() {
                        rowData.push($(this).text());
                    });
                    tableData.push(rowData);
                });

                // Append the table data to the worksheet data
                ws = XLSX.utils.sheet_add_aoa(ws, tableData, {
                    origin: -1
                });
            });

            // Add the worksheet to the workbook
            XLSX.utils.book_append_sheet(wb, ws, 'CombinedSheet');

            // Save the workbook as XLSX
            XLSX.writeFile(wb, 'exported_data.xlsx', {
                bookSST: true
            });

            // Hide image container after export completion
            $('.ajax-loader').css("visibility", "hidden");
        }

        function exportToPDF() {
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
                                size: landscape;
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

        function formatNumberWithFixed(number) {
            return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        function formatNumberNoFixed(number) {
            return number.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,');
        }

        function historicalCharts() {
            Highcharts.stockChart('linecharts', {
                chart: {
                    animation: false,
                    zoomType: 'x',

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
                    text: 'Historical Charts'
                },
                legend: {
                    enabled: true,
                },
                exporting: {
                    enabled: false
                },
                series: seriesData
            });
        }
        // Function to display the main table
        function displayMainTable(theadData, tbodyData, dateTimeData, dateStart, dateEnd) {
            $('.headercharts').html('');
            $('.tablecharts').html('');
            $('.tablecharts').append('<div class="final-table"></div>');
            $('.headercharts').append(`
                <nav class="navbar top-navbar col-lg-12 col-12 mt-3">
                    <div class="container p-0 m-0">
                        <div class="text-center navbar-brand-wrapper">
                            <a class="navbar-brand brand-logo" href="javascript:void(0)">
                                <img src="{{ asset('assets/images/logo-dic.webp') }}" alt="logo" width="230" />
                                <span class="font-12 d-block font-weight-light">
                                    PT DIC Astra Chemicals
                                </span>
                            </a>
                        </div>
                        <h4>
                            Report Historical Logs
                        </h4>
                        
                    </div>
                </nav>
                <hr class="m-0">
                <table class="mt-3" style="font-size: 13px;">
                        <tr>
                            <td>Daterange</td>
                            <td>:</td>
                            <td>${dateStart} - ${dateEnd}</td>
                        </tr>
                        <tr>
                            <td>Parameters</td>
                            <td>:</td>
                            <td>${theadData.join(', ')}</td>
                        </tr>
                    <tr>
                        <td>Print By</td>
                        <td>:</td>
                        <td> {{ auth()->user()->fullname }}</td>
                    </tr>
                    <tr>
                        <td>Print Date</td>
                        <td>:</td>
                        <td> {{ now() }}</td>
                    </tr>
                </table>
            `);
            $('.tablecharts').append('<h5 class="text-center">Table Charts</h5>');
            $('.tablecharts').append(
                `<table id="exportTable" class="table my-tablelogs my-table-striped table-hover w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>DateTime</th>
                    ${theadData.map(header => `<th>${header}</th>`).join('')}
                </tr>
            </thead>
            <tbody>
                ${transpose(tbodyData).map((row, index) => {
                    const dateObject = new Date(dateTimeData[index]);
                    const options = {
                        timeZone: 'Asia/Jakarta',
                        hour12: false,
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    };
                    const formattedDateTime = dateObject.toLocaleString('en-US', options);
                    return ` < tr > < td > $ {
                    index + 1
                } < /td> <
                td > $ {
                    formattedDateTime
                } < /td>
                $ {
                    row.map((cell, cellIndex) => `<td>${cell}</td>`).join('')
                } <
                /tr>`;
        }).join('')
    } <
    /tbody> <
    /table>`
        );
        }
        // Function to calculate statistics for a column
        function calculateColumnStats(column) {
            let count = 0;
            let sum = 0;
            let min = Number.MAX_VALUE;
            let max = Number.MIN_VALUE;

            for (let i = 0; i < column.length; i++) {
                const value = column[i];

                // Count
                count++;

                // Sum
                sum += value;

                // Min
                min = Math.min(min, value);

                // Max
                max = Math.max(max, value);
            }

            // Average
            const average = sum / count;

            return {
                count,
                sum,
                min,
                max,
                average,
            };
        }

        // Function to calculate statistics for each column in the transposed data
        function calculateTableStatsLarge(theadData, tbodyData) {
            const columnStats = transpose(tbodyData).map(calculateColumnStats);

            const tableStats = theadData.map((header, index) => {
                return {
                    header,
                    stats: columnStats[index],
                };
            });

            return tableStats;
        }

        // Function to display final statistics table
        function displayFinalStatisticsLarge(theadData, tbodyData) {
            const tableStats = calculateTableStatsLarge(theadData, transpose(tbodyData));

            const finalStatsTable = $(
                '<table id="exportTable" class="table my-tablelogs my-table-striped table-hover w-100 mb-3">').append(`
            <thead>
                <tr>
                    <th>Column</th>
                    <th>Count</th>
                    <th>Sum</th>
                    <th>Min</th>
                    <th>Max</th>
                    <th>Average</th>
                </tr>
            </thead>
            <tbody>
            ${tableStats.map(({ header, stats }) => ` <
                tr >
                <
                td > $ {
                    header
                } < /td> <
                td > $ {
                    formatNumberNoFixed(stats.count)
                } < /td> <
                td > $ {
                    formatNumberNoFixed(stats.sum)
                } < /td> <
                td > $ {
                    stats.min
                } < /td> <
                td > $ {
                    stats.max
                } < /td> <
                td > $ {
                    formatNumberWithFixed(stats.average)
                } < /td> <
                /tr>
                `).join('')}
            </tbody>`);

            $('.tablecharts').find('.final-table').append('<h5 class="text-center">Final Summary Charts</h5>').append(
                finalStatsTable);
        }

        // Transpose the tbodyData
        function transpose(array) {
            return array[0].map((col, i) => array.map(row => row[i]));
        }


        function getValueByKey(obj, key) {
            return obj[key];
        }

        // Function to get values for specific keys from the "message" property
        function getValuesForKeys(array, keys) {
            return array.map(obj => {
                const messageObj = JSON.parse(obj.message);
                return keys.map(key => messageObj[key]);
            });
        }
    </script>
@endsection
