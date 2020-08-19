@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('ep')}}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Dashboard</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> Ecommerce Partner(EP) Panel
        <small>statistics, charts and reports</small>
    </h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->

    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-list"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$new_order->count()}}">0</span>
                    </div>
                    <div class="desc"> New Orders</div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-truck"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$order_on_delivery->count()}}">0</span>
                    </div>
                    <div class="desc"> On Delivery</div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                <div class="visual">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$order_completed->count()}}"></span></div>
                    <div class="desc"> Completed Delivery</div>
                </div>
            </a>
        </div>
        {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
        {{--<a class="dashboard-stat dashboard-stat-v2 red" href="#">--}}
        {{--<div class="visual">--}}
        {{--<i class="fa fa-money"></i>--}}
        {{--</div>--}}
        {{--<div class="details">--}}
        {{--<div class="number">{{ __('text.tk.') }}--}}
        {{--<span data-counter="counterup" data-value="{{number_format($udc_commission, 2)}}">0</span></div>--}}
        {{--<div class="desc"> UDC Commission</div>--}}
        {{--</div>--}}
        {{--</a>--}}
        {{--</div>--}}
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->

    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Your Recent Orders</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="scroller" style="height: 310px;" data-always-visible="1" data-rail-visible="0">
                        <ul class="activity-list">

                            @forelse($recent_orders as $order)
                                <li>
                                    <p class="act-text">{{$order->receiver_name. ' '. $order->receiver_contact_number}} - <a href="{{url("ep/order-details/$order->order_code")}}">{{$order->order_code}}</a>.</p>
                                    <span class="act-time">On - {{date("d M, Y h:i A", strtotime($order->created_at))}}</span>
                                </li>
                            @empty
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
        </div>
    </div>

@endsection