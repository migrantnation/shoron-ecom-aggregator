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
            <form class="form-inline" action="{{url('admin/reports/commissions')}}">
                <div class="form-group">
                    <label for="email">Date range:</label>
                    <input id="periodpickerstart" type="text" value="12.03.2018">
                    <input id="periodpickerend" type="text" value="16.03.2018">
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

    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <br>
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-red-sunglo hide"></i>
                        <span class="caption-subject text-primary bold uppercase">Commission Summery of All</span>
                        {{--<span class="caption-helper"></span>--}}
                    </div>
                </div>
                <div class="portlet-body">
                    <canvas id="salesChart"
                            data-labels='["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"]'
                            data-values="[500.00, 1200.00, 600.00, 1070.00, 200.00, 1700.00, 600.00, 1000.00, 1020.00, 500.00, 1050.00, 705.00]"
                            height="420"></canvas>
                </div>
            </div>

            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share text-info hide"></i>
                        <span class="caption-subject text-info bold uppercase">Commissions List of All</span>
                        {{--<span class="caption-helper"></span>--}}
                    </div>
                    <div class="actions">
                        <form class="form-inline pull-right">
                            <div class="form-group">
                                <input type="search" class="form-control" placeholder="Search">
                            </div>&nbsp;&nbsp;
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>Date</th>
                            <th>Orders</th>
                            <th>Sales</th>
                            <th width="10%">UDC Total Commission</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Jan 25</td>
                            <td>5</td>
                            <td>৳ {{number_format(3450, 2)}}</td>
                            <td>৳ {{number_format(570, 2)}}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jan 25</td>
                            <td>5</td>
                            <td>৳ {{number_format(3450, 2)}}</td>
                            <td>৳ {{number_format(570, 2)}}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Jan 25</td>
                            <td>5</td>
                            <td>৳ {{number_format(3450, 2)}}</td>
                            <td>৳ {{number_format(570, 2)}}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Jan 25</td>
                            <td>5</td>
                            <td>৳ {{number_format(3450, 2)}}</td>
                            <td>৳ {{number_format(570, 2)}}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Jan 25</td>
                            <td>5</td>
                            <td>৳ {{number_format(3450, 2)}}</td>
                            <td>৳ {{number_format(570, 2)}}</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="text-right">
                        <ul class="pagination">
                            <li><a href="#">1</a></li>
                            <li class="active"><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script>
        (function ($) {
            'use strict';
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
        }(jQuery))
    </script>

@endsection