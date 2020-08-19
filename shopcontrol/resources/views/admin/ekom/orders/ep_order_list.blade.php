@extends('admin.layouts.master')
@section('content')

    <?php $ecom_setting = \App\models\_ecom_Setting::first(); ?>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center" id="modal_title"></h4>
                </div>
                <style>
                    .modal-body pre {
                        width: 547px;
                        display: inline-block;
                    }

                </style>
                <div class="modal-body" style="width: 500px;">
                    <p>Headers:</p>
                    <pre id="order-log-headers"></pre>
                    <br><br>
                    <p>CURL Info:</p>
                    <pre id="order-log-ch"></pre>
                    <br><br>
                    <p>Post Data:</p>
                    <pre id="order-log-postdata"></pre>
                    <br><br>
                    <p>Response:</p>
                    <pre id="order-log-response"></pre>
                    <br><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">

        <ul class="page-breadcrumb">
            <li>
                <a href="./">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>
                    @if(@$udc_info->center_name)
                        {{@$udc_info->center_name}}
                    @elseif(@$ep_info->ep_name)
                        {{@$ep_info->ep_name}}
                    @elseif(@$lp->lp_name)
                        {{@$lp->lp_name}}
                    @endif

                    | Order List</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
        @if(@$udc_info->center_name)
            {{@$udc_info->center_name}}
        @elseif(@$ep_info->ep_name)
            {{@$ep_info->ep_name}}
        @elseif(@$lp->lp_name)
            {{@$lp->lp_name}}
        @endif

        || Order List
        <span class="alert alert-info" style="font-size: 15pt; position: absolute; width: 400px; margin: 5px; padding: 10px; background-color: white; top: 45px; right: 15px; ">
            <i class="fa fa-info-circle" style="font-size: 15pt;"></i>
            {{__('_ecom__text.order-cancel-notification', ['hours' => @$ecom_setting->order_cancel_time])}}
        </span>


        <small></small>
    </h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->


    {{--<div class="alert alert-info text-center" style="padding-top: 0; padding-bottom: 0;">--}}
        {{--<h3>--}}
            {{--<i class="fa fa-info-circle" style="font-size: 20pt;"></i>--}}
            {{--{{__('_ecom__text.order-cancel-notification', ['hours' => $ecom_setting->order_cancel_time])}}--}}
        {{--</h3>--}}
    {{--</div>--}}


    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box default" style="margin-top: 11px; margin-bottom: 5px;">
                <div class="portlet-body" style="padding-bottom: 0px; height: 60px;">
                    <form action="javascript:;" class="table-toolbar" id="SubmitSearch">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input id="periodpickerstart" type="text" value="{{@$_GET['from'] ? @$_GET['from'] : ""}}">
                                    <input id="periodpickerend" type="text" value="{{@$_GET['to'] ? @$_GET['to'] : ""}}">
                                </div> &nbsp;
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search_string" name="search_string"
                                               value="{{@$_GET['search_string'] ? @$_GET['search_string'] : ""}}">
                                        <span class="input-group-btn">
                                <button class="btn blue" type="button" id="submit_search" onclick="ajaxpush();"><i
                                            class="fa fa-search"></i></button>
                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="dropdown" style="display: inline-block">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        <i class="fa fa-download"></i> Export
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
                                        <li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

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
                        @include('admin.ekom.orders.render_ep_order_list')
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

        var tab_id = 'all';
        var url = "{{$url}}";
        var page = 1;

        $(document).on('click', '.nav-tabs a', function (e) {
            tab_id = $(this).data('type');
            ajaxpush();
        });

        $(document).on('click', '.pagination a', function (e) {

            e.preventDefault();

            var search_string = $('#search_string').val();
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var page = $(this).attr('href').split('page=')[1];

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

        });

        $("#submit_search").click(function (e) {
            e.preventDefault();
            ajaxpush();
        });

        function ajaxpush() {
            var search_string = $('#search_string').val();
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var limit = $('#limit').val();

            if (limit == 'all') {
                window.location = url + "?search_string=" + search_string + "&from=" + from + "&to=" + to + "&tab_id=" + tab_id + "&limit=" + limit + "";
            }

            $('#ep_orders').html('');
            $('.overlay-wrap').show();

            var data = {
                search_string: search_string,
                from: from,
                to: to,
                tab_id: tab_id,
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
                }
            });
        }

        function export_table(filetype) {
            var search_string = $('#search_string').val();
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var export_type = filetype;
            window.location = url + "?from=" + from + "&to=" + to + "&search_string=" + search_string + "&export_type=" + export_type + "";
        }

        function datePickerInit() {
            $('.input-daterange').datepicker();
        }

    </script>
@endsection