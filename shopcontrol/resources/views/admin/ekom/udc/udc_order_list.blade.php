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
                <span>{{$udc_info->center_name}} | All Order List</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> {{$udc_info->center_name}} | All Order List
        <small></small>
    </h1>
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
                </ul>
                <div class="tab-content" style="background-color: #F4F6F8" id="udc_orders">
                    {{--@include('admin.ekom.udc.render_udc_order_list')--}}
                    @include('admin.ekom.orders.render_ep_order_list')
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script>

        $(document).ready(function () {
            datePickerInit();
        });

        var tab_id = 0;
        var url = "{{$url}}";
        var page = 1;
        $(document).on('click', '.nav-tabs a', function (e) {
            tab_id = $(this).data('type');
            var search_string = $('#search_string').val();
            var from = $('#from').val();
            var to = $('#to').val();
            var data = {
                tab_id: tab_id,
                search_string: search_string,
                from: from,
                to: to,
            }
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
//                    history.pushState(null, null, this.url);
                    $("#udc_orders").html(html);
                    datePickerInit();
                }
            });
        });

        $(document).on('click', '.pagination a', function (e) {
            var search_string = $('#search_string').val();
            var from = $('#from').val();
            var to = $('#to').val();
            var page = $(this).attr('href').split('page=')[1];

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
//                    history.pushState(null, null, this.url);
                    $("#udc_orders").html(html);
                    datePickerInit();
                }
            });
            e.preventDefault();
        });

        $("#submit_search").click(function (e) {
            e.preventDefault();
            ajaxpush();
        });

        function ajaxpush() {

            var search_string = $('#search_string').val();
            var from = $('#from').val();
            var to = $('#to').val();
            var data = {
                search_string: search_string,
                from: from,
                to: to,
                tab_id: tab_id,
            }

            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
//                    history.pushState(null, null, this.url);
                    $("#udc_orders").html(html);
                    datePickerInit();
                }
            });
        }

        function datePickerInit() {
            $('.input-daterange').datepicker();
        }
    </script>
@endsection