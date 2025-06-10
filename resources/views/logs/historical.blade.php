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
                                <input type="text" name="date_start" autocomplete="off" required placeholder="Start Date"
                                    class="daterangepicker-field form-control text-center">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                <input type="text" name="date_end" autocomplete="off" required placeholder="End Date"
                                    class="daterangepicker-field form-control text-center">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Plan <span style="color: red;">*</span></label>
                                    <select name="select_plan" id="select_plan" required class="form-select">
                                        <option value="">Search...</option>
                                        <option value="ALL">ALL</option>
                                        <option value="A">EXT-1</option>
                                        <option value="B">EXT-BMB01</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Area <span style="color: red;">*</span></label>
                                    <select name="area" id="area" required class="form-select">
                                        <option value="">Search...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search Parameters <span style="color: red;">*</span></label>
                                    <select class="select-params w-100" name="params[]" required multiple="multiple">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Page per size <span style="color: red;">*</span></label>
                                    <select name="size_form" id="size_form" required class="form-select">
                                        <option value="">Search...</option>
                                        <option value="10">10</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="500">500</option>
                                        <option value="1000">1000</option>
                                        <option value="5000">5000</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Range Interval Report <span style="color: red;">*</span></label>
                                    <select name="interval_report" id="interval_report" required class="form-select">
                                        <option value="">Search...</option>
                                        <option value="1s">1 Second</option>
                                        <option value="1m">1 Minute</option>
                                        <option value="5m">5 Minute</option>
                                        <option value="10m">10 Minute</option>
                                        <option value="30m">30 Minute</option>
                                        <option value="60m">60 Minute</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ route('logs.historical') }}" class="btn btn-md btn-warning">Reset</a>
                        <button type="button" class="btn btn-md btn-primary submitForm">Search</button>
                        <a href="javascript:void(0)" style="display: none;" id="exportPdfBtn"
                            class="btn btn-md btn-danger">Export to PDF</a>
                        <a href="javascript:void(0)" style="display: none;" id="exportExcelBtn"
                            class="btn btn-md btn-success">Export to Excel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
        const selectPlan = document.getElementById('select_plan');
        const areaSelect = document.getElementById('area');

        const options = {
            A: ['PLC', 'Feeder'],
            B: ['Feeder Control Panel', 'Extruder Control Panel', 'P-RAW MATERIAL CHARGING',
                 'P-Water Bed', 'Sorting Machine Control Panel',
                'Panel Blower & Vacuum'
            ],
            ALL: ['PLC', 'Feeder', 'Feeder Control Panel', 'Extruder Control Panel', 'P-RAW MATERIAL CHARGING',
                 'P-Water Bed', 'Sorting Machine Control Panel',
                'Panel Blower & Vacuum'
            ]
        };

        selectPlan.addEventListener('change', function() {
            const selectedValue = this.value;
            const areaOptions = options[selectedValue] || [];

            // Update area options
            areaSelect.innerHTML = `<option value="">Search...</option>`;
            areaOptions.forEach(option => {
                areaSelect.innerHTML += `<option value="${option}">${option}</option>`;
            });
        });
    </script>

    <script>
        let seriesData = [],
            req = [],
            newData = [],
            tagsArray = [],
            isLoading = false,
            dtStart,
            dtEnd,
            paramsId = [],
            jsonValue = [],
            paramsName = [],
            lastShortId,
            dataRes,
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
            });
        });

        $(document).on('click', '.submitForm', function(e) {
            e.preventDefault();

            let params = $('.form-history .select-params').val(),
                date_start = $('.form-history input[name=date_start]').val(),
                date_end = $('.form-history input[name=date_end]').val(),
                size_form = $('.form-history select[name=size_form]').val(),
                interval_report = $('.form-history select[name=interval_report]').val(),
                area = $('.form-history select[name=area]').val();

            if (date_start.trim() === '' && date_end.trim() === '') {
                alert('Daterange cannot be empty!');
                return
            }

            if (area.trim() === '') {
                alert('Area cannot be empty!');
                return
            }

            if (size_form.trim() === '') {
                alert('Page per size cannot be empty!');
                return
            }

            if (interval_report.trim() === '') {
                alert('Range interval report cannot be empty!');
                return
            }

            if (params.length === 0) {
                alert('Parameters cannot be empty!');
                return
            }
            // Get form action and serialize form data
            let formAction = $('.form-history').attr('action');
            let formData = $('.form-history').serialize();
            let date_starts = $('.form-history input[name=date_start]').val();
            let date_ends = $('.form-history input[name=date_end]').val();
            dtStart = date_starts.replace(" ", "T") + ":00";
            dtEnd = date_ends.replace(" ", "T") + ":59";

            if (params.includes('ALL')) {
                getAllParamsByArea(area)
                    .then((paramsArray) => {
                        let len = paramsArray.length;

                        paramsId = [];
                        jsonValue = [];
                        paramsName = [];

                        paramsArray.forEach(val => {
                            paramsId.push(parseFloat(val.split("|")[0]));
                            tagsArray.push(val.split("|")[1]);
                            paramsName.push(val.split("|")[2]);
                            jsonValue.push(val.split("|")[3])
                        });

                        req = [];
                        newData = [];
                        seriesData = [];
                        lastShortId = null;
                        dataRes = null;

                        fetchData(dtStart, dtEnd, paramsId, paramsName, jsonValue);
                    })
                    .catch((error) => {
                        console.error("Error fetching data:", error);
                    });

            } else {
                let paramsArray = params.map(function(item) {
                    return item.replace(/,/g, ';');
                });

                let len = paramsArray.length;

                paramsId = [];
                jsonValue = [];
                paramsName = [];

                paramsArray.forEach(val => {
                    paramsId.push(parseFloat(val.split("|")[0]));
                    tagsArray.push(val.split("|")[1]);
                    paramsName.push(val.split("|")[2]);
                    jsonValue.push(val.split("|")[3])
                });

                req = [];
                newData = [];
                seriesData = [];
                lastShortId = null;
                dataRes = null;

                fetchData(dtStart, dtEnd, paramsId, paramsName, jsonValue);
            }

        });

        function setupInfiniteScroll() {
            $(window).on('scroll', function() {
                handleScroll();
            });
        }

        function handleScroll() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 70 && !isLoading) {
                // Load more data when reaching the bottom of the page
                isLoading = true;
                fetchData(dtStart, dtEnd, paramsId, paramsName, jsonValue, lastShortId);
            }
        }

        async function fetchData(dt_start, dt_end, params_id, params_name, json_value, searchAfter = null) {
            let res, theadData = [],
                tbodyData = [];
            let elastic_urls = $("input[name=elastic_url]").val().split(",");
            let elastic_index = $("input[name=elastic_index]").val();
            const size = $('.form-history select[name=size_form]').val();
            const interval = $('.form-history select[name=interval_report]').val();
            try {
                if (!searchAfter) {
                    $('.ajax-loader').css("visibility", "visible");
                    req = [];
                    newData = [];
                    seriesData = [];
                    lastShortId = null;
                    dataRes = null;
                }

                // const query = {
                //     query: {
                //         bool: {
                //             must: [{
                //                     match_all: {}
                //                 },
                //                 {
                //                     range: {
                //                         created_at: {
                //                             gte: dt_start,
                //                             lte: dt_end
                //                         }
                //                     }
                //                 }
                //             ]
                //         }
                //     },
                //     size: size,
                //     sort: [{
                //         created_at: {
                //             order: "asc"
                //         }
                //     }]
                // };
                const query = {
                    size: 0,
                    query: {
                        bool: {
                            must: [{
                                    match_all: {}
                                },
                                {
                                    range: {
                                        created_at: {
                                            gte: dt_start,
                                            lte: dt_end
                                        }
                                    }
                                }
                            ]
                        }
                    },
                    aggs: {
                        per_minute_data: {
                            composite: {
                                size: size,
                                sources: [{
                                    created_at: {
                                        date_histogram: {
                                            field: "created_at",
                                            fixed_interval: interval
                                        }
                                    }
                                }],
                                // Menambahkan search_after jika tersedia
                                ...(searchAfter && {
                                    after: {
                                        created_at: searchAfter
                                    }
                                })
                            },
                            aggs: {
                                top_document: {
                                    top_hits: {
                                        size: 1,
                                        sort: [{
                                            created_at: {
                                                order: "asc"
                                            }
                                        }]
                                    }
                                }
                            }
                        }
                    }
                };

                // if (searchAfter) {
                //     query.search_after = searchAfter;
                // }

                for (const elastic_url of elastic_urls) {
                    try {
                        const response = await fetch(`${elastic_url}/${elastic_index}/_search`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(query),
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }

                        res = await response.json();
                        break; // Break the loop if successful
                    } catch (error) {
                        console.error(`Error connecting to ${elastic_url}:`, error);
                    }
                }

                if (!res) {
                    throw new Error('All Elasticsearch nodes are unreachable');
                }


                if (res.aggregations.per_minute_data.buckets.length > 0) {

                    // Process the data
                    // dataRes = res.hits.hits.map(hit => hit._source);
                    dataRes = res.aggregations.per_minute_data.buckets.map(bucket => {
                        return bucket.top_document.hits.hits.map(hit => hit._source);
                    }).flat();

                    // Update display after each page fetch
                    const valuesForKeys = getValuesForKeys(dataRes, json_value);
                    const transposedArray = valuesForKeys[0].map((_, index) => valuesForKeys.map(row => row[index]));

                    theadData = params_name;

                    let newDataForPage = [],
                        timestampArray = [],
                        shortTimestamps = [];

                    for (let i = 0; i < params_id.length; i++) {
                        timestampArray.push(dataRes.map(item => {
                            const convDate = convertDate(item.created_at);
                            const jakartaTime = new Date(convDate);
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

                        // Implementasi penukaran elemen kedua dari yang terakhir menjadi yang pertama
                        for (let k = 0; k < Math.floor(dataForParamsId.length / 2); k++) {
                            let temp = dataForParamsId[k][1];
                            dataForParamsId[k][1] = dataForParamsId[dataForParamsId.length - 1 - k][1];
                            dataForParamsId[dataForParamsId.length - 1 - k][1] = temp;
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
                    tbodyData = [];
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


                    // Update the charts and table after processing each page
                    historicalCharts();
                    displayMainTable(theadData, tbodyData, dateTimeData[0], dt_start, dt_end);

                    // Tampilkan data total final dari tabel
                    displayFinalStatisticsLarge(theadData, tbodyData);
                    $('#exportPdfBtn').show();
                    $('#exportExcelBtn').show();

                    // Get the search_after value for the next page
                    // const hits = res.hits.hits;
                    // const lastHit = hits[hits.length - 1];

                    // lastShortId = [convertDateNumber(lastHit._id)];
                    lastShortId = res.aggregations.per_minute_data.after_key.created_at;

                    // await delay(1000); // Adjust the delay as needed
                    // await fetchData(dt_start, dt_end, params_id, params_name, json_value, lastSort);
                    isLoading = false;

                    await setupInfiniteScroll(dt_start, dt_end, params_id, params_name, json_value, lastShortId)
                } else {
                    // Ensure theadData and tbodyData are populated before handling the final state
                    if (theadData.length === 0 && tbodyData.length === 0 && newData.length > 0) {
                        const groupedData = newData.reduce((acc, item) => {
                            const key = item.params_name;
                            if (!acc[key]) {
                                acc[key] = [];
                            }
                            acc[key] = acc[key].concat(item.data);
                            return acc;
                        }, {});

                        req = [];
                        tbodyData = [];
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

                        theadData = params_name;
                    }

                    // All pages have been fetched, finalize display
                    // $('.ajax-loader').css("visibility", "hidden");
                    displayFinalStatisticsLarge(theadData, tbodyData);
                    $('#exportPdfBtn').show();
                    $('#exportExcelBtn').show();

                    req = [];
                    newData = [];
                    seriesData = [];
                }
            } catch (error) {
                console.error('An error occurred:', error);
            } finally {
                $('.ajax-loader').css("visibility", "hidden");
            }
        }

        function getAllParamsByArea(params = '') {
            return new Promise((resolve, reject) => {
                $.ajax({
                    type: "post",
                    url: '{{ route('get.allparams.byarea') }}',
                    data: {
                        params: params
                    },
                    dataType: "json",
                    success: function(res) {
                        let paramsArray = [];
                        $.map(res, function(val, key) {
                            paramsArray.push(
                                `${val.id}|${val.tagParameter}|${val.name}|${val.value}`);
                        });
                        resolve(paramsArray); // Resolve the promise with the data
                    },
                    error: function(err) {
                        reject(err); // Reject the promise on error
                    }
                });
            });
        }

        const delay = ms => new Promise(res => setTimeout(res, ms));

        function convertDateNumber(dateInput) {
            // Check if dateInput is a number (timestamp) and convert to Date object
            const date = new Date(Number(dateInput));

            if (isNaN(date.getTime())) {
                throw new Error("Invalid date input");
            }

            // Increment the date by 1 second
            date.setSeconds(date.getSeconds() + 1);

            // Specify the timezone offset
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

            // Convert to locale string with specified timezone
            const formattedDate = date.toLocaleString('en-US', options);

            // Reformat the locale string to desired format: "YYYY-MM-DD HH:MM:SS"
            const [datePart, timePart] = formattedDate.split(", ");
            const [month, day, year] = datePart.split("/");
            const formattedDateTime = `${year}-${month}-${day}T${timePart}`;

            return formattedDateTime;
        }

        function convertDate(dateString) {
            // Buat objek Date dari string ISO
            const date = new Date(dateString);

            // Ambil komponen tanggal
            const month = String(date.getUTCMonth() + 1).padStart(2, '0');
            const day = String(date.getUTCDate()).padStart(2, '0');
            const year = date.getUTCFullYear();

            // Ambil komponen waktu dalam UTC
            const hours = String(date.getUTCHours()).padStart(2, '0');
            const minutes = String(date.getUTCMinutes()).padStart(2, '0');
            const seconds = String(date.getUTCSeconds()).padStart(2, '0');

            // Gabungkan dalam format yang diinginkan
            const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

            return formattedDate;
        }

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
                    return ` <tr> 
                        <td> 
                            ${index + 1} 
                        </td> 
                        <td> 
                            ${formattedDateTime} 
                        </td>
                        ${row.map((cell, cellIndex) => `<td>${cell}</td>`).join('')} 
                        </tr>`;
                            }).join('')
                        } </tbody> 
                        </table >
                    `
                  );
                }
                // Function to calculate statistics for a column
                function calculateColumnStats(column) {
                    let count = 0;
                    let sum = 0;
                    let min = Number.MAX_VALUE; // Set initial min value to the largest possible number
                    let max = Number.MIN_VALUE; // Set initial max value to the smallest possible number


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
            ${tableStats.map(({ header, stats }) => ` 
            <tr>
                <td> 
                    ${header} 
                </td> 
                <td> 
                    ${formatNumberNoFixed(stats.count)} 
                </td> 
                <td> 
                    ${formatNumberNoFixed(stats.sum)} 
                </td> 
                <td> 
                    ${stats.min} 
                </td> 
                <td> 
                    ${stats.max} 
                </td> 
                <td> 
                    ${formatNumberWithFixed(stats.average)} 
                </td>
                     
            </tr>
                `).join('')}
            </tbody>`);

            $('.tablecharts').find('.final-table').append('<h5 class="text-center">Final Summary Charts</h5>').append(
                finalStatsTable);
        }
        // Function to calculate statistics for a column
        function calculateColumnStats(column) {
            let count = 0;
            let sum = 0;
            let min = Number.MAX_VALUE; // Set initial min value to the largest possible number
            let max = Number.MIN_VALUE; // Set initial max value to the smallest possible number


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
            ${tableStats.map(({ header, stats }) => ` 
            <tr>
                <td> 
                    ${header} 
                </td> 
                <td> 
                    ${formatNumberNoFixed(stats.count)} 
                </td> 
                <td> 
                    ${formatNumberNoFixed(stats.sum)} 
                </td> 
                <td> 
                    ${stats.min} 
                </td> 
                <td> 
                    ${stats.max} 
                </td> 
                <td> 
                    ${formatNumberWithFixed(stats.average)} 
                </td>
                     
            </tr>
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
                const messageObj = obj.message;

                return keys.map(key => {
                    // Split the key to get the path to the value
                    const path = key.split('-');

                    // Traverse the messageObj using the path
                    let value = messageObj;
                    for (const segment of path) {
                        if (value && value.hasOwnProperty(segment)) {
                            value = value[segment];
                        } else {
                            value = 0;
                            break;
                        }
                    }

                    return parseFloat(value);
                });
            });
        }
    </script>
@endsection
