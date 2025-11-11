 <!-- partial:partials/_footer.html -->
 <footer class="footer">
     <div class="container">
         <div class="d-sm-flex justify-content-start justify-content-sm-between">
             <span class="text-muted mx-2 text-sm-left d-block d-sm-inline-block fixed-bottom">Copyright
                 © {{ date('Y') }}
                 <a href="javascript:void(0)" target="_blank">PT. Multi Sarana Indotani</a>.
                 All rights reserved.</span>

         </div>
     </div>
 </footer>
 <!-- partial -->
 </div>
 <!-- main-panel ends -->
 </div>
 <!-- page-body-wrapper ends -->
 </div>
 <!-- container-scroller -->
 <!-- plugins:js -->
 {{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
 <script src="{{ asset('assets/js/vendor.bundle.base.js') }}"></script>
 <script src="{{ asset('assets/auth/js/bootstrap.min.js') }}"></script>

 <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
 <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

 <script src="{{ asset('assets/js/jquery.safeform.js') }}"></script>
 <script src="{{ asset('assets/scadavis/synopticapi.js') }}"></script>
 <!-- endinject -->
 <!-- Plugin js for this page -->
 <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
 <!-- End plugin js for this page -->
 <!-- inject:js -->
 {{--  --}}
 <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
 <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
 <script src="{{ asset('assets/js/settings.js') }}"></script>

 {{--  --}}
 <script src="{{ asset('assets/js/moment.min.js') }}"></script>
 <script src="{{ asset('assets/js/moment-with-locales.min.js') }}"></script>
 <script src="{{ asset('assets/js/knockout-min.js') }}"></script>
 <script src="{{ asset('assets/date-range/daterangepicker.js') }}"></script>
 <script src="{{ asset('assets/js/bootstrap4-toggle.min.js') }}"></script>


 <script src="{{ asset('assets/js/highstock.js') }}"></script>

 <input type="hidden" name="ws_url" value="{{ env('WS_URL') }}">
 <input type="hidden" name="elastic_url" value="{{ env('ELASTIC_URL') }}">
 <input type="hidden" name="elastic_index" value="{{ env('ELASTIC_INDEX') }}">

 <script>
     $(function() {
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });

         $(`.select-2`).select2({
             placeholder: 'Search...',
             width: "100%",
             dropdownParent: $(".modal-params"),
             allowClear: true,
         });
         $(`.select2-single`).select2({
             placeholder: 'Search...',
             width: "100%",
             allowClear: true,
         });
         $("input[name=date_start]").daterangepicker({
             forceUpdate: false,
             singleDatePicker: true,
             timeZone: 'Asia/Jakarta',
             timePicker: false,
             timePicker24Hour: true,
             startDate: moment().subtract(0, 'days').startOf('hour'),
             endDate: moment().startOf('hour').add(24, 'hour'),
             locale: {
                 format: 'YYYY-MM-DD'
             },
             autoUpdateInput: false
         });
         $('input[name=date_start]').on('apply.daterangepicker', function(ev, picker) {
             $(this).val(picker.startDate.format('YYYY-MM-DD'));
         });
         $("input[name=date_end]").daterangepicker({
             forceUpdate: false,
             singleDatePicker: true,
             timeZone: 'Asia/Jakarta',
             timePicker: false,
             timePicker24Hour: true,
             startDate: moment().startOf('hour'),
             endDate: moment().startOf('hour').add(24, 'hour'),
             locale: {
                 format: 'YYYY-MM-DD'
             },
             autoUpdateInput: false
         });
         $('input[name=date_end]').on('apply.daterangepicker', function(ev, picker) {
             $(this).val(picker.startDate.format('YYYY-MM-DD'));
         });

     });
 </script>

 <!-- endinject -->
 @yield('script')
 @yield('script_2')
 <!-- End custom js for this page -->
 </body>

 </html>
