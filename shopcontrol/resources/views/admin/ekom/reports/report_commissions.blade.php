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
                            <label for="email">Date range:</label>
                            <input id="periodpickerstart" type="text" value="">
                            <input id="periodpickerend" type="text" value="">
                        </div> &nbsp;&nbsp;
                        <div class="form-group">
                            <select name="ep_id" id="ep_id" class="form-control">
                                <option value="all">All EP</option>
                                @forelse($all_eps as $ep)
                                    <option value="{{$ep->id}}">{{$ep->ep_name}}</option>
                                @empty
                                    <option>No EP found</option>
                                @endforelse
                            </select>
                        </div> &nbsp; &nbsp;

                        <div class="form-group">
                            &nbsp;<a href="javascript://" class="btn filter-range btn-info report-filter">Generate</a>
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
        var url = "{{url('admin/reports/commissions')}}";

        $(document).on('click', '.export', function (e) {
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var ep_id = $('#ep_id').val();
            var export_type = $(this).data('filetype');

            if(from == '' || to == ''){
                $.alert('Please select date range.');
                return ;
            }
            if(ep_id == ''){
                $.alert('Please select an EP.');
                return ;
            }
            window.location = url + "?from=" + from + "&to=" + to + "&ep_id=" + ep_id + "&export_type=" + export_type + "";
        });

        $(document).on('click', '.report-filter', function (e) {
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var ep_id = $('#ep_id').val();
            var thisBtn = $(this);


            if(ep_id == ''){
                $.alert('Please select an EP.');
                return ;
            }
            if(from == '' || to == ''){
                $.alert('Please select date range.');
                return ;
            }

            $('#loader').show();
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
                    $("#report-render").html(html);
                    initChart();
                    $('#loader').fadeOut();
                    $(thisBtn).html('Reset')
                        .removeClass('report-filter')
                        .attr('href', '{{url('admin/reports/commissions')}}');
                }
            });
        });

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
                        label: "Commission (৳)",
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

@endsection