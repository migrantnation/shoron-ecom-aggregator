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
                <span>Sales Overview</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <div class="clearfix"></div>

    <div class="row full-height">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <h3 class="page-title">Sales Overview</h3>
            <div class="margin-bottom-30">
                <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button> &nbsp;
                <div class="dropdown" style="display: inline-block">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Export
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-file-o"></i> CSV</a></li>
                        <li><a href="#"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                        <li><a href="#"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                    </ul>
                </div>
            </div>
            <form class="form-inline" action="{{url('admin/reports/sales')}}">
                <div class="form-group">
                    <label for="email">Date range:</label>
                    <input id="periodpickerstart" name="from" type="text" value="12.03.2018">
                    <input id="periodpickerend" name="to" type="text" value="16.03.2018">
                </div> &nbsp;&nbsp;
                <div class="form-group">
                    <select name="" id="filter_range" class="form-control">
                        <option value="">--Select Item--</option>
                        <option value="all" selected>All</option>
                        <option value="ep_partner">ep_partner</option>
                        <option value="ep_partner2">ep_partner2</option>
                        <option value="ep_partner3">ep_partner3</option>
                    </select>
                </div> &nbsp; &nbsp;

                <div class="form-group">
                    &nbsp;<button type="submit" class="btn -filter-range btn-info">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <div id="report-render">
        <br>
        @include('admin.ekom.reports.render_sales_reports')
    </div>

    <div class="clearfix"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script>
        initChart();
        function initChart() {
            var canvas = document.getElementById('salesChart');
            var ctx = document.getElementById('salesChart').getContext("2d");
            var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
            gradientStroke.addColorStop(0, '#80b6f4');
            gradientStroke.addColorStop(1, '#8d25a0');
            var gradientFill = ctx.createLinearGradient(500, 0, 100, 0);
            gradientFill.addColorStop(0, "rgba(128, 182, 244, 0.2)");
            gradientFill.addColorStop(1, "rgba(141, 37, 160, 0.2)");
            var labels = $(canvas).data('labels');
            var values = $(canvas).data('values');

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Sales (৳)",
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
                                fontColor: "rgba(0,0,0,0.5)",
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
                                fontColor: "rgba(0,0,0,0.5)",
                                fontStyle: "bold"
                            }
                        }]
                    }
                }
            });
        }

    </script>


    <script>

        var url = "{{url('admin/reports/sales')}}";

        $(document).on('click', '.pagination a', function (e) {
            var filter_range = $('#filter_range').val();
            var status = $('#status_range').val();
            e.preventDefault();
            var search_string = $('#search_string').val();
            var page = $(this).attr('href').split('page=')[1];

            $('#ep_orders').html('');
            $('.overlay-wrap').show();

            var data = {
                search_string: search_string,
                filter_range: filter_range,
                status: status,
                page: page,
            }

            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
//                    history.pushState(null, null, this.url);
                    $('.overlay-wrap').hide();
                    $("#ep_orders").html(html);
                    datePickerInit();
                }
            });

        });


        $(document).on('click', '.filter-range', function (e) {
            var filter_range = $('#filter_range').val();
            var status = $('#status_range').val();
            $('#loader').show();
            var data = {
                "filter_range": filter_range,
                "status": status,
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
                }
            });
        });
    </script>

@endsection