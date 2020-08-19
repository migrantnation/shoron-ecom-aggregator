@extends('admin.layouts.master')
@section('content')

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="./">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                All Disbursement</span>
            </li>
        </ul>
    </div>

    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->

    <div class="clearfix"></div>
    <div class="row full-height">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <h3 class="page-title">All Disbursement</h3>
            <div class="margin-bottom-30">
                <div class="col-lg-8 col-xs-8 col-sm-8">
                    <form class="form-inline" action="javascript:;">
                        <div class="form-group">
                            <label for="email">Month:</label>
                            <select class="selectMonth selectMonthall form-control">
                                <option value="">Select Month</option>
{{--                                <option value="all" {{@$month && @$month == 'all' ? 'selected' : ''}}>All</option>--}}
                                <option value="01" {{@$month && @$month == '01' ? 'selected' : ''}}>January</option>
                                <option value="02" {{@$month && @$month == '02' ? 'selected' : ''}}>February</option>
                                <option value="03" {{@$month && @$month == '03' ? 'selected' : ''}}>March</option>
                                <option value="04" {{@$month && @$month == '04' ? 'selected' : ''}}>April</option>
                                <option value="05" {{@$month && @$month == '05' ? 'selected' : ''}}>May</option>
                                <option value="06" {{@$month && @$month == '06' ? 'selected' : ''}}>June</option>
                                <option value="07" {{@$month && @$month == '07' ? 'selected' : ''}}>July</option>
                                <option value="08" {{@$month && @$month == '08' ? 'selected' : ''}}>August</option>
                                <option value="09" {{@$month && @$month == '09' ? 'selected' : ''}}>September</option>
                                <option value="10" {{@$month && @$month == '10' ? 'selected' : ''}}>October</option>
                                <option value="11" {{@$month && @$month == '11' ? 'selected' : ''}}>November</option>
                                <option value="12" {{@$month && @$month == '12' ? 'selected' : ''}}>December</option>
                            </select>

                            <select class="selectYear form-control">
                                <option value="">Select Year</option>
{{--                                <option value="all" {{@$year && @$year == 'all' ? 'selected' : ''}} id="allYear">All</option>--}}
                                @for($i = 2018 ; $i < date('Y') + 5 ; $i++)
                                    <option value="{{$i}}" {{@$year && @$year == $i ? 'selected' : ''}}>{{$i}}</option>
                                @endfor
                            </select>

                            {{--periodpickerstart--}}
                            <input id="startDate" type="hidden" name="from"
                                   value="{{@$_POST['from'] ? @$_POST['from'] : @$from}}">
                            {{--periodpickerend--}}
                            <input id="endDate" type="hidden" name="to"
                                   value="{{@$_POST['to'] ? @$_POST['to'] : @$to}}">
                        </div>
                        <div class="form-group">
                            &nbsp;<a href="javascript://" class="btn filter-range btn-info report-filter">Generate</a>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 col-xs-12 col-sm-4 text-right">
                    <div class="dropdown" style="display: inline-block">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Export
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:;" class="export" data-filetype="csv">
                                    <i class="fa fa-file-o"></i> CSV
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="export" data-filetype="xlsx">
                                    <i class="fa fa-file-excel-o"></i> Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="tabbable-line boxless tabbable-reversed">
                <div class="tab-content" style="background-color: #F4F6F8" id="">

                    <div class="overlay-wrap">
                        <div class="anim-overlay">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>
                    </div>

                    <div id="disbursed_commission_list">
                        @include('admin.ep.report.render-disbursed-commission-list')
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var search_string = $('#search_string').val();
            var page = $(this).attr('href').split('page=')[1];
            var limit = $('#limit').val();

            var from = $('#startDate').val();
            var to = $('#endDate').val();
            var selectMonth = $('.selectMonth').val();
            var selectYear = $('.selectYear').val();
            var ep_id = $('#ep_id').val();

            $('#disbursed_commission_list').html('');
            $('.overlay-wrap').show();

            var data = {
                page: page,
                limit: limit,
                search_string: search_string,
                from: from,
                to: to,
                ep_id: ep_id,
            }

            $.ajax({
                url: '{{url("ep/disburesed-commission-list")}}',
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('.overlay-wrap').hide();
                    $("#disbursed_commission_list").html(html);
                    datePickerInit();
                }
            });
            e.preventDefault();
        });
    </script>

    <script>

        $("#submit_search").click(function (e) {
            e.preventDefault();
            ajaxpush();
        });

        function ajaxpush() {
            var search_string = $('#search_string').val();
            var from = $('#startDate').val();
            var to = $('#endDate').val();
            var selectMonth = $('.selectMonth').val();
            var selectYear = $('.selectYear').val();
            var ep_id = $('#ep_id').val();

            $('#disbursed_commission_list').html('');
            $('.overlay-wrap').show();
            var data = {
                search_string: search_string,
                from: from,
                to: to,
                ep_id: ep_id,
            }
            $.ajax({
                url: '{{url("ep/disburesed-commission-list")}}',
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('.overlay-wrap').hide();
                    $("#disbursed_commission_list").html(html);
                }
            });
        }
    </script>

    <script>


        var url = "{{url('ep/disburesed-commission-list')}}";
        $(document).on('click', '.export', function (e) {
            var from = $('#startDate').val();
            var to = $('#endDate').val();
            var export_type = $(this).data('filetype');
            var search_string = $('#search_string').val();
            var ep_id = $('#ep_id').val();

            var selectMonth = $('.selectMonth').val();
            var selectYear = $('.selectYear').val();

            if (selectMonth == '' || selectYear == '') {
                $.alert('Please select Month and Year.');
                return;
            }
            window.location = url + "?from=" + from + "&to=" + to + "&export_type=" + export_type + "&ep_id=" + ep_id + "&search_string=" + search_string + "";
        });

        $(document).on('click', '.report-filter', function (e) {
            var from = $('#startDate').val();
            var to = $('#endDate').val();
            var selectMonth = $('.selectMonth').val();
            var selectYear = $('.selectYear').val();
            var ep_id = $('#ep_id').val();

            if (selectMonth == '' || selectYear == '') {
                $.alert('Please select Month and Year.');
                return;
            }
            $('#disbursed_commission_list').html('');
            $('.overlay-wrap').show();

            var data = {
                from: from,
                to: to,
                ep_id: ep_id,
            };
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#disbursed_commission_list").html(html);
                    $('.overlay-wrap').hide();
                }
            });
        });

        //COMMISSION DISBURSEMENT
        $(document).on('change', '.selectMonthall', function (e) {
            if ($(".selectMonth").val() != 'all') {
                $("#allYear").hide();
                if ($(".selectYear").val() == 'all') {
                    $(".selectYear").prop("selectedIndex", 0);
                }
            } else {
                $("#allYear").show();
            }
        });

        //COMMISSION DISBURSEMENT
        $(document).on('change', '.selectMonth , .selectYear', function (e) {

            var startDate = 'all';
            var endDate = 'all';

            if ($(".selectMonth").val() != 'all' && $(".selectYear").val() != 'all') {
                startDate = "01" + "." + $(".selectMonth").val() + "." + $(".selectYear").val();
                endDate = daysInMonth($(".selectMonth").val(), $(".selectYear").val()) + "." + $(".selectMonth").val() + "." + $(".selectYear").val();
            }

            if ($(".selectYear").val() != 'all') {
                if ($(".selectMonth").val() == 'all') {
                    startDate = "01" + "." + "01" + "." + $(".selectYear").val();
                    endDate = daysInMonth('01', $(".selectYear").val()) + "." + "12" + "." + $(".selectYear").val();
                }
            }

            console.log(startDate + "," + endDate);
            // return;

            $('#startDate').val(startDate);
            $('#endDate').val(endDate);
        });

        function daysInMonth(month, year) {
            return new Date(year, month, 0).getDate();
        }
    </script>
@endsection