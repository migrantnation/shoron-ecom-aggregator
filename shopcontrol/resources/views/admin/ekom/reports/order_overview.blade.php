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
                <span>Order Overview</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> Order Overview
        {{--<small>{{ __('_ecom__text.stat-char-rep') }}</small>--}}
    </h1>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$total_orders->count()}}">0</span>
                    </div>
                    <div class="desc"> Total Orders</div>
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
                        <span data-counter="counterup" data-value="{{$delivered_orders->count()}}">0</span></div>
                    <div class="desc"> Delivered Orders</div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$warehouse_left_orders->count()}}">0</span>
                    </div>
                    <div class="desc"> Orders Left from eCommerce Partners</div>
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
                        <span data-counter="counterup" data-value="{{$on_delivery_orders->count()}}"></span></div>
                    <div class="desc"> Orders on Delivery</div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$average_order_delivery_time}}"></span> Days
                    </div>
                    <div class="desc"> Average Order Delivery Time</div>
                </div>
            </a>
        </div>
        {{--<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="452"></span></div>
                    <div class="desc"> Last Month Registered UDC</div>
                </div>
            </a>
        </div>--}}
    </div>
    <div class="clearfix"></div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase">Last 10 Active Orders</span>
            </div>
        </div>

        <div class="portlet-body">
            <form action="javascript:;" class="table-toolbar" id="SubmitSearch">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="active_from" id="active_from" value="" placeholder="Date YYYY-MM-DD">
                            <span class="input-group-addon"> to </span>
                            <input type="text" class="form-control" name="active_to" id="active_to" value="" placeholder="Date YYYY-MM-DD">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <button class="btn btn-info" id="btn_top_active_orders"><i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>


            <div class="overlay-wrap" id="active-overlay-wrap">
                <div class="anim-overlay">
                    <div class="spinner">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>
            </div>
            <div id="top_active_orders">
                @include('admin.ekom.reports.top_ten_active_orders')
            </div>

        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase">Last 10 Delivered Orders</span>
            </div>
        </div>

        <div class="portlet-body">
            <form action="javascript:;" class="table-toolbar" id="SubmitSearch">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="delivered_from" id="delivered_from" value="" placeholder="Date YYYY-MM-DD">
                            <span class="input-group-addon"> to </span>
                            <input type="text" class="form-control" name="delivered_to" id="delivered_to" value="" placeholder="Date YYYY-MM-DD">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <button class="btn btn-info" id="btn_top_delivered_orders"><i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>

            <div class="overlay-wrap" id="delivered-overlay-wrap">
                <div class="anim-overlay">
                    <div class="spinner">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>
            </div>
            <div id="top_delivered_orders">
                @include('admin.ekom.reports.top_ten_delivered_orders')
            </div>

        </div>
    </div>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script>

        $(document).ready(function () {
            datePickerInit();
        });

        function datePickerInit() {
            $('.input-daterange').datepicker();
        }

        $("#btn_top_active_orders").click(function (e) {
            e.preventDefault();
            top_ten_active_orders();
        });


        $("#btn_top_delivered_orders").click(function (e) {
            e.preventDefault();
            top_ten_delivered_orders();
        });

        function top_ten_active_orders() {
            var from = $('#active_from').val();
            var to = $('#active_to').val();

            $('#top_active_orders').html('');
            $('#active-overlay-wrap').show();

            var data = {
                from: from,
                to: to,
            }
            $.ajax({
                url: "{{url('admin/reports/orders/top-ten-active-orders')}}",
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('#active-overlay-wrap').hide();
                    $("#top_active_orders").html(html);
                    datePickerInit();
                }
            });
        }


        function top_ten_delivered_orders() {
            var from = $('#delivered_from').val();
            var to = $('#delivered_to').val();

            $('#top_delivered_orders').html('');
            $('#delivered-overlay-wrap').show();

            var data = {
                from: from,
                to: to,
            }
            $.ajax({
                url: "{{url('admin/reports/orders/top-ten-delivered-orders')}}",
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('#delivered-overlay-wrap').hide();
                    $("#top_delivered_orders").html(html);
                    datePickerInit();
                }
            });
        }

    </script>

@endsection