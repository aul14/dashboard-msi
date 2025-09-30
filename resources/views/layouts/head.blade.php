<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ $title ?? '' }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/mdi/css/materialdesignicons.min.css?v=1.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flag-icon-css/css/flag-icon.min.css?v=1.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.base.css?v=1.0.0') }}" />
    <!-- endinject -->
    {{-- Datatable --}}
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css?v=1.0.0') }}"
        type="text/css">
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css?v=1.0.0') }}" type="text/css">
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome/css/font-awesome.min.css?v=1.0.0') }}" />
    <!-- End plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v=1.1.4') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css?v=1.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('assets/date-range/daterangepicker.css?v=1.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap4-toggle.min.css') }}">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-msi.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
