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
                <span>{{$ep->ep_name}} | All Order List</span>
            </li>
        </ul>
    </div>

    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> {{$ep->ep_name}} | All Order List
        <small></small>
    </h1>
    <?php $ecom_setting = \App\models\_ecom_Setting::first(); ?>
    <div class="alert alert-info text-center" style="padding-top: 0; padding-bottom: 0;">
        <h3><i class="fa fa-info-circle" style="font-size: 20pt;"></i>
            {{__('_ecom__text.order-cancel-notification', ['hours' => $ecom_setting->order_cancel_time])}}
        </h3>
    </div>

    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->

    <div class="row">
        <div class="col-md-12">
            <div class="tabbable-line boxless tabbable-reversed">
                <ul class="nav nav-tabs">
                    <li class="<?php if (empty($_GET['tab_id']) || $_GET['tab_id'] == 'all') {
                        echo 'active';
                    }?>">
                        <a href="#tab_all" data-toggle="tab" data-type="all"> All Orders </a>
                    </li>

                    <li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 1 ? 'active' : ''}}">
                        <a href="#tab_1" data-toggle="tab" data-type="1"> Active Orders </a>
                    </li>


                    <li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 2 ? 'active' : ''}}">
                        <a href="#tab_2" data-toggle="tab" data-type="2"> Warehouse Left Orders </a>
                    </li>

                    <li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 3 ? 'active' : ''}}">
                        <a href="#tab_3" data-toggle="tab" data-type="3"> On the Way Orders </a>
                    </li>
                    <li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 4 ? 'active' : ''}}">
                        <a href="#tab_4" data-toggle="tab" data-type="4"> Delivered Order </a>
                    </li>
                    <li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 5 ? 'active' : ''}}">
                        <a href="#tab_5" data-toggle="tab" data-type="5"> Canceled Order </a>
                    </li>

                    {{--<li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 6 ? 'active' : ''}}">--}}
                    {{--<a href="#tab_6" data-toggle="tab" data-type="6"> Orders not in EP </a>--}}
                    {{--</li>--}}

                </ul>

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

                    <div id="ep_orders">
                        @include('admin.ep.orders.ep-order-list-render')
                    </div>

                </div>
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

        var tab_id = 'all';
        var url = "{{url('ep/orders')}}";
        var page = 1;

        $(document).on('click', '.nav-tabs a', function (e) {
            tab_id = $(this).data('type');
            ajaxpush();
//            var search_string = $('#search_string').val();
//            var from = $('#from').val();
//            var to = $('#to').val();
//            $('#ep_orders').html('');
//            $('.overlay-wrap').show();
//            var data = {
//                tab_id: tab_id,
//                search_string: search_string,
//                from: from,
//                to: to,
//            }
//            $.ajax({
//                url: url,
//                type: "get",
//                dataType: 'json',
//                data: data,
//                success: function (html) {
//                    $('.overlay-wrap').hide();
//                    $("#ep_orders").html(html);
//                    datePickerInit();
//                }
//            });
        });

        $(document).on('click', '.pagination a', function (e) {

            var search_string = $('#search_string').val();
            var from = $('#from').val();
            var to = $('#to').val();
            var page = $(this).attr('href').split('page=')[1];
            var limit = $('#limit').val();
            $('#ep_orders').html('');
            $('.overlay-wrap').show();

            var data = {
                tab_id: tab_id,
                search_string: search_string,
                from: from,
                to: to,
                page: page,
                limit: limit,
            }

            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('.overlay-wrap').hide();
                    $("#ep_orders").html(html);
                    datePickerInit();
                }
            });
            e.preventDefault();
        });

        function ajaxpush() {

            var search_string = $('#search_string').val();
            var from = $('#from').val();
            var to = $('#to').val();
            var limit = $('#limit').val();

            if (limit == 'all') {
                window.location = "{{url('')}}" + "/ep/orders?search_string=" + search_string + "&from=" + from + "&to=" + to + "&tab_id=" + tab_id + "&limit=" + limit + "";
            }

            $('#ep_orders').html('');
            $('.overlay-wrap').show();

            var data = {
                tab_id: tab_id,
                search_string: search_string,
                from: from,
                to: to,
                page: page,
            }

            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('.overlay-wrap').hide();
                    $("#ep_orders").html(html);
                    datePickerInit();
                }
            });
        }
    </script>

@endsection