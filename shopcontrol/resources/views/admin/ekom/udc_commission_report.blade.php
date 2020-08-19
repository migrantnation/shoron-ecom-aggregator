@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('ep')}}">{{ __('_ecom__text.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Commission Overview</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <div class="clearfix"></div>

    <div class="row full-height">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <h3 class="page-title">Commission Overview</h3>
            <div class="margin-bottom-30">
                <div class="col-lg-8 col-xs-8 col-sm-8">
                    <form class="form-inline" action="javascript:;">
                        <div class="form-group">
                            <label for="email">Month:</label>
                            <select class="selectMonth selectMonthall form-control">
                                <option value="">Select Month</option>
                                <option value="all">All</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>

                            <select class="selectYear form-control">
                                <option value="">Select Year</option>
                                <option value="all" id="allYear">All</option>
                                @for($i = 2018 ; $i < date('Y') + 5 ; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>

                            <select name="ep_id" id="ep_id" class="form-control">
                                <option value="all">All EP</option>
                                @forelse($all_eps as $ep)
                                    <option value="{{$ep->id}}">{{$ep->ep_name}}</option>
                                @empty
                                    <option>No EP found</option>
                                @endforelse
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

    <div id="report-render">
        <div class="col-lg-12 col-xs-12 col-sm-12" style="position: relative; margin-top: 25px">
            <div class="portlet light">
                <div id="loader" class="loader-overlay">
                    <div class="loader">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <script>

        var url = "{{url('admin/reports/commission-overview')}}";
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
            $('#loader').show();

            var data = {
                from: from,
                to: to,
                ep_id: ep_id,
            };
             console.log(ep_id);
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#report-render").html(html);
                    $('#loader').fadeOut();
                }
            });
        });


        $(document).on('click', '.pagination a', function (e) {
            var from = $('#startDate').val();
            var to = $('#endDate').val();
            var ep_id = $('#ep_id').val();

            $('#loader').show();
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: {
                    from: from,
                    to: to,
                    ep_id: ep_id,
                    page: $(this).attr('href').split('page=')[1],
                }, success: function (html) {
                    $('#loader').fadeOut();
                    $("#report-render").html(html);
                }
            });
            e.preventDefault();
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

    <script>

        function ajaxpush() {
            var search_string = $('#search_string').val();
            var from = $('#startDate').val();
            var to = $('#endDate').val();
            var ep_id = $('#ep_id').val();
            $('#loader').show();
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: {
                    from: from,
                    to: to,
                    ep_id: ep_id,
                    search_string: search_string,
                }, success: function (html) {
                    $('#loader').fadeOut();
                    $("#report-render").html(html);
                }
            });
            e.preventDefault();
        }
    </script>

@endsection
