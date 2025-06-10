@include('layouts.head')
<div class="container-scroller">
    @include('layouts.topnav')
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper pb-0 pt-1">
                @yield('content')
                <!-- Image loader -->
                <div class="ajax-loader">
                    <img src="{{ asset('assets/images/loader_2.gif') }}" class="img-responsive" />
                </div>
                <!-- Image loader -->
            </div>
            <!-- content-wrapper ends -->
            @include('layouts.footer')
