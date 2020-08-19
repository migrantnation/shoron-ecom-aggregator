@extends('admin.layouts.master_demo')
@section('content')
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <link href="{{asset('public/admin_ui_assets')}}/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css"
          rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors -->
    <link href="{{asset('public/admin_ui_assets')}}/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('public/admin_ui_assets')}}/assets/demo/demo6/base/style.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('public/admin_ui_assets')}}/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->

    <div class="row full-height">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <h3 class="page-title">Logistic Overview</h3>
            <div class="margin-bottom-30">
                <div class="col-lg-8 col-xs-8 col-sm-8">
                    <form class="form-inline" action="javascript:;">
                        <div class="form-group">
                            <label for="email">Date range:</label>
                            <input id="periodpickerstart" type="text" value="">
                            <input id="periodpickerend" type="text" value="">
                        </div> &nbsp;&nbsp;
                        <div class="form-group">
                            <select name="lp_id" id="lp_id" class="form-control">
                                <option value="all">All LP</option>
                                @forelse($all_lps as $lp)
                                    <option value="{{$lp->id}}">{{$lp->lp_name}}</option>
                                @empty
                                    <option>No LP found</option>
                                @endforelse
                            </select>
                        </div> &nbsp; &nbsp;

                        <div class="form-group">
                            &nbsp;<a href="javascript://" class="btn filter-range btn-info report-filter">Generate</a>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>


    <div class="m-content" style="padding-top: 50px; position: relative" id="report-render">
        <div class="col-lg-12 col-xs-12 col-sm-12" style="position: relative; margin-top: 25px">
            <div class="portlet light">
                <div id="loader" class="loader-overlay">
                    <div class="loader">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    {{--GET ACTIVITIES--}}

    <!--begin::Base Scripts -->
    <script src="{{asset('public/admin_ui_assets')}}/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="{{asset('public/admin_ui_assets')}}/assets/demo/demo6/base/scripts.bundle.js" type="text/javascript"></script>
    <!--end::Base Scripts -->
    <!--begin::Page Vendors -->
    <script src="{{asset('public/admin_ui_assets')}}/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js"
            type="text/javascript"></script>
    <!--end::Page Vendors -->
    <!--begin::Page Snippets -->
    <script src="{{asset('public/admin_ui_assets')}}/assets/app/js/dashboard.js" type="text/javascript"></script>
    <!--end::Page Snippets -->

    <script src="{{url('public/admin_ui_assets')}}/layouts/layout/js/jquery.periodpicker.full.min.js" type="text/javascript"></script>

    <script>

        var url = "{{url('admin/reports/logistic')}}";

        $(document).on('click', '.export', function (e) {
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var lp_id = $('#lp_id').val();
            var export_type = $(this).data('filetype');

            if (from == '' || to == '') {
                $.alert('Please select date range.');
                return;
            }
            if (lp_id == '') {
                $.alert('Please Select Logistic Partner.');
                return;
            }

            window.location = url + "?from=" + from + "&to=" + to + "&lp_id=" + lp_id + "&export_type=" + export_type + "";
        });

        $(document).on('click', '.report-filter', function (e) {

            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var thisBtn = $(this);
            var lp_id = $('#lp_id').val();

            if(from == '' || to == ''){
                $.alert('Please select date range.');
                return ;
            }

            $('#loader').show();
            var data = {
                from: from,
                to: to,
                lp_id: lp_id,
            };
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#report-render").html(html);
                    Dashboard.init();
                    $('#loader').fadeOut();
                }
            });
        });

        $( document ).ready(function() {
            var today = new Date();
            var tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000));
            var d = today.getDate();
            var m = today.getMonth();
            var Y = today.getFullYear();
            var newDate = (1 + d) + '.' + (1 + m) + '.' + Y;

            jQuery('#periodpickerstart').periodpicker({
                end: '#periodpickerend',
                todayButton: false,
                maxDate: newDate,
                formatDate: 'D.MM.YYYY',
                onTodayButtonClick: function () {
                    this.regenerate();
                    return false;
                }
            });
        });

    </script>
@endsection