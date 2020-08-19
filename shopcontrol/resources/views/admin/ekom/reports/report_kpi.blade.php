@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{ __('_ecom__text.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ __('_ecom__text.kpi-overview') }}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <div class="clearfix"></div>

    <div class="row full-height">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <h3 class="page-title">
                <span>{{ __('_ecom__text.kpi-overview') }}</span></h3>
            <div class="margin-bottom-30">

                <div class="col-lg-8 col-xs-8 col-sm-8">

                    <form class="form-inline" action="javascript:;">
                        <div class="form-group">
                            <label for="email">Date range:</label>
                            <input id="periodpickerstart" type="text" value="">
                            <input id="periodpickerend" type="text" value="">
                        </div> &nbsp;&nbsp;
                        <div class="form-group">
                            <select name="kpi_type" id="kpi_type" class="form-control">
                                <option value="">--Select KPI Type--</option>
                                <option value="1">Sale value per day</option>
                                <option value="2">Total transaction per day</option>
                                <option value="3">Order per Entrepreneur per day</option>
                                <option value="4">Average Fulfilment time</option>
                            </select>
                        </div> &nbsp; &nbsp;

                        <div class="form-group">
                            &nbsp;<a href="javascript://" class="btn filter-range btn-info report-filter">Generate
                            </a>
                        </div>
                    </form>
                </div>


                <div class="col-lg-4 col-xs-12 col-sm-4 text-right">
                    {{--<button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button> &nbsp;--}}
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
                            {{--<li>--}}
                                {{--<a href="javascript:;" class="export" data-filetype="pdf">--}}
                                    {{--<i class="fa fa-file-pdf-o"></i> PDF--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div id="report-render"></div>

    <div class="clearfix"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script>
        var url = "{{url('admin/reports/kpi')}}";

        $(document).on('click', '.export', function (e) {
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var kpi_type = $('#kpi_type').val();
            var export_type = $(this).data('filetype');

            if (from == '' || to == '') {
                $.alert('Please select date range.');
                return;
            }
            if (kpi_type == '') {
                $.alert('Please select KPI type.');
                return;
            }
            window.location = url + "?from=" + from + "&to=" + to + "&kpi_type=" + kpi_type + "&export_type=" + export_type + "";
        });


        $(document).on('click', '.report-filter', function (e) {
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var kpi_type = $('#kpi_type').val();
            var thisBtn = $(this);

            if (from == '' || to == '') {
                $.alert('Please select date range.');
                return;
            }
            if (kpi_type == '') {
                $.alert('Please select KPI type.');
                return;
            }

            $('#loader').show();
            var data = {
                from: from,
                to: to,
                kpi_type: kpi_type,
            };

            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#report-render").html(html);
                    initChart();
                    $('#loader').fadeOut();
                    $(thisBtn).html('Reset')
                        .removeClass('report-filter')
                        .attr('href', '{{url('admin/reports/kpi')}}');
                }
            });
        });


        initChart();

        function initChart() {
            var canvas = document.getElementById('salesChart');
            var ctx = document.getElementById('salesChart').getContext("2d");
            var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
            gradientStroke.addColorStop(0, '#00B6F4');
            gradientStroke.addColorStop(1, '#8d25a0');
            var gradientFill = ctx.createLinearGradient(500, 0, 100, 0);
            gradientFill.addColorStop(0, "rgba(0, 182, 244, 0.2)");
            gradientFill.addColorStop(1, "rgba(141, 37, 160, 0.2)");
            var target = $(canvas).data('target');
            var label = $(canvas).data('label');
            var labels = $(canvas).data('labels');
            var values = $(canvas).data('values');

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        borderColor: gradientStroke,
                        pointBorderColor: gradientStroke,
                        pointBackgroundColor: gradientStroke,
                        pointHoverBackgroundColor: gradientStroke,
                        pointHoverBorderColor: gradientStroke,
                        pointBorderWidth: 4,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 1,
                        pointRadius: 3,
                        fill: true,
                        backgroundColor: gradientFill,
                        borderWidth: 1,
                        data: values
                    }, {
                        label: "Target",
                        borderColor: gradientStroke,
                        pointBorderWidth: 0,
                        fill: false,
                        borderWidth: 1,
                        data: target
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    animation: {
                        easing: "easeInOutBack"
                    },
                    legend: {
                        display: false,
                        position: "bottom"
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                fontColor: "rgba(141, 37, 160, 0.6)",
                                fontStyle: "bold",
                                beginAtZero: true,
                                maxTicksLimit: 5,
                                padding: 20
                            },
                            gridLines: {
                                drawTicks: false,
                                display: false
                            }

                        }],
                        xAxes: [{
                            gridLines: {
                                zeroLineColor: "transparent"
                            },
                            ticks: {
                                padding: 20,
                                fontColor: "rgba(0, 182, 244, 0.6)",
                                fontStyle: "bold"
                            }
                        }]
                    }
                }
            });
        }
    </script>

@endsection