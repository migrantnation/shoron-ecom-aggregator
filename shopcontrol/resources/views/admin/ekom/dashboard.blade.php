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
                <span>{{ __('_ecom__text.dashboard') }}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> {{ __('_ecom__text.ek-shop-panel') }}
        <small>{{ __('_ecom__text.stat-char-rep') }}</small>
    </h1>
    <?php
    $number_translate = new \App\Libraries\PlxUtilities();
    $new_feedback = 1349;
    $total_profit = 12.5;
    $new_orders = 458;
    $brand_popularity = 89;
    ?>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->

    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$registered_dc->count()}}">0</span>
                    </div>
                    <div class="desc"> Registered UDC Members</div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                <div class="visual">
                    <i class="fa fa-list"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$new_order->count()}}">0</span></div>
                    <div class="desc"> New Orders</div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-truck"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$order_completed->count()}}">0</span>
                    </div>
                    <div class="desc"> Delivered Orders</div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$active_ep->count()}}"></span></div>
                    <div class="desc"> eCommerce Partners</div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$active_lp->count()}}"></span></div>
                    <div class="desc"> Logistics Partners</div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                <div class="visual">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="number">{{ __('text.tk.') }}
                        <span data-counter="counterup" data-value="{{number_format($udc_commission,2)}}"></span></div>
                    <div class="desc"> UDC Commission</div>
                </div>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->

    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Recent Orders</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="scroller" style="height: 310px;" data-always-visible="1" data-rail-visible="0">
                        <ul class="activity-list">
                            @forelse($udc_recent_orders as $order)
                                <li>
                                    <p class="act-text">Order Code: <a
                                                href="{{url("udc/order-details/$order->id")}}">{{@$order->order_code}}</a>
                                        - Order
                                        Amount: {{ __('admin_text.tk.') }} {{number_format(@$order->total_price, 2)}}
                                    </p>
                                    <span class="act-time">Order Date: {{date("d M, Y h:i A", strtotime(@$order->created_at))}}
                                        - Delivery Duration: {{@$order->delivery_duration}}</span>
                                </li>
                            @empty
                            @endforelse

                            {{--<li>--}}
                            {{--<p class="act-text">Rahim published an article: <a href="#">465456</a>.</p>--}}
                            {{--<span class="act-time">03 Jul, 2017 21:45 PM</span>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xs-12 col-sm-12">
            <!-- BEGIN REGIONAL STATS PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">

                    <div class="caption">
                        <i class="icon-share font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">On Delivery {{--{{ __('admin_text.regional-stats') }}--}}</span>
                    </div>

                </div>

                <div class="portlet-body">
                    <div class="scroller" style="height: 310px;" data-always-visible="1" data-rail-visible="0">
                        <ul class="activity-list">

                            @forelse($order_on_delivery as $order)
                                <li>
                                    <p class="act-text">Order Code: <a
                                                href="{{url("udc/order-details/$order->id")}}">{{@$order->order_code}}</a>
                                        - Order
                                        Amount: {{ __('admin_text.tk.') }} {{number_format(@$order->total_price, 2)}}
                                    </p>
                                    <span class="act-time">Order Date: {{date("d M, Y h:i A", strtotime(@$order->created_at))}}
                                        - Delivery Duration: {{@$order->delivery_duration}}</span>
                                </li>
                            @empty
                                <p>You don't have any order on delivery right now.</p>
                            @endforelse

                        </ul>
                    </div>
                    <div class="scroller-footer">
                        {{--<div class="btn-arrow-link pull-right">
                            <a href="javascript:;">See All Records</a>
                            <i class="icon-arrow-right"></i>
                        </div>--}}
                    </div>
                </div>

            </div>
            <!-- END REGIONAL STATS PORTLET-->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <!-- BEGIN REGIONAL STATS PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">

                    <div class="caption">
                        <i class="icon-share font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Today's Orders</span>
                    </div>

                </div>

                <div class="portlet-body">
                    <div class="scroller" style="height: 310px;" data-always-visible="1" data-rail-visible="0">
                        <ul class="activity-list">

                            @forelse($todays_order as $order)
                                <li>
                                    <p class="act-text">Order Code: <a
                                                href="{{url("udc/order-details/$order->id")}}">{{@$order->order_code}}</a>
                                        - Order
                                        Amount: {{ __('admin_text.tk.') }} {{number_format(@$order->total_price, 2)}}
                                    </p>
                                    <span class="act-time">Order Date: {{date("d M, Y h:i A", strtotime(@$order->created_at))}}
                                        - Delivery Duration: {{@$order->delivery_duration}}</span>
                                </li>
                            @empty
                                <p>You don't have any active order right now.</p>
                            @endforelse

                        </ul>
                    </div>
                </div>

            </div>
            <!-- END REGIONAL STATS PORTLET-->
        </div>

        <div class="col-lg-6 col-xs-12 col-sm-12">
            <!-- BEGIN REGIONAL STATS PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">

                    <div class="caption">
                        <i class="icon-share font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Orders Overview</span>
                    </div>

                </div>

                <div class="portlet-body">
                    <div class="plx_card -scroller" style="height: 310px;" data-always-visible="1" data-rail-visible="0">
                        <canvas class="margin-bottom-30" id="topRestaurantsByOrders"
                                height="310"
                                data-values="[{{@$chart_day_values}}]"
                                data-labels="{{@$day_array}}"></canvas>
                    </div>
                </div>

            </div>
            <!-- END REGIONAL STATS PORTLET-->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light bordered">

                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bubble font-dark hide"></i>
                        <span class="caption-subject font-hide bold uppercase">Recent UDC Agents</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">

                        @forelse($udc_agents as $each_agents)
                            <div class="col-md-3">
                                <div class="mt-widget-1">
                                    <div class="mt-img">
                                        <img src="{{($each_agents->image!='/files/noimagefound.jpg') ? $each_agents->image : url('public/admin_ui_assets/pages/media/users/blank_avatar.png')}}"
                                             class="img-responsive" width="80"></div>
                                    <div class="mt-body">
                                        <h3 class="mt-username">{{@$each_agents->name_bn}}</h3>
                                        <p class="mt-user-title"><strong>{{@$each_agents->center_name}}</strong></p>
                                        <p class="mt-user-title">{{@$each_agents->present_address}}</p>
                                        <p class="mt-user-title">{{@$each_agents->contact_number}}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script>
        (function () {
            'use strict';
            $(document).ready(function () {
                /*var cardHeight = $('.plx_card').height;
                $('#topRestaurantsByOrders').height(cardHeight);*/
                barChartInit('#topRestaurantsByOrders');
            });
            function barChartInit(canvas) {
                var values = $(canvas).data('values');
                var labels = $(canvas).data('labels');
                var canvasContainer = $(canvas);
                var chartConfig = {
                    type: 'bar',
                    data: {
                        datasets: [{
                            backgroundColor: 'rgba(156, 39, 176, 0.9)',
                            borderColor: 'rgba(156, 39, 176, 1)',
                            borderWidth: 1
                        }
                        // , {
                        //     backgroundColor: 'rgba(255, 39, 176, 0.9)',
                        //     borderColor: 'rgba(255, 39, 176, 1)',
                        //     borderWidth: 1
                        // }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        legend: {
                            display: false,
                            position: 'left'
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                };

                var chartInit = new Chart(canvasContainer, chartConfig);
                var chartData = chartInit.config.data;
                chartData.labels = labels.split(',');
                chartData.datasets[0].label = "Total Orders";
                chartData.datasets[0].data = values;
                // chartData.datasets[1].label = "Testing Delivered Orders";
                // chartData.datasets[1].data = [10, 5, 6, 3, 9, 11, 12];
                chartInit.update();

                /*$(viewType).change(function () {
                    var viewTypeChecked = $(container).find('.view-type:checked'),
                        typeValue = $(viewTypeChecked).val();
                    if (typeValue === 'day') {
                        chartData.datasets[0].data = dayValues;
                        chartData.labels = dayLabels;
                        chart.update();
                    } else if (typeValue === 'week') {
                        chartData.datasets[0].data = weekValues;
                        chartData.labels = weekLabels;
                        chart.update();
                    } else if (typeValue === 'month') {
                        chartData.datasets[0].data = monthValues;
                        chartData.labels = monthLabels;
                        chart.update();
                    } else if (typeValue === 'quarter') {
                        chartData.datasets[0].data = quarterValues;
                        chartData.labels = quarterLabels;
                        chart.update();
                    }  else if (typeValue === 'year') {
                        chartData.datasets[0].data = yearValues;
                        chartData.labels = yearLabels;
                        chart.update();
                    }
                })*/
            }
        }(jQuery))
    </script>

@endsection