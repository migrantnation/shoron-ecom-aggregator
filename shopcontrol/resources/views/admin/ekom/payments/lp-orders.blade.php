@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">

        <ul class="page-breadcrumb">
            <li>
                <a href="./">{{__('admin_text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{@$ep_info->center_name}} | {{__('admin_text.orders')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> {{@$ep_info->center_name}} | {{__('admin_text.orders')}}
        <small></small>
    </h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="tabbable-line boxless tabbable-reversed">
                <ul class="nav nav-tabs">
                    <li class="<?php if (empty($_GET['tab_id']) || $_GET['tab_id'] == 0) {
                        echo 'active';
                    }?>">
                        <a href="#tab_0" data-toggle="tab" data-type="0"> {{__('admin_text.orders')}} </a>
                    </li>
                </ul>
                <div class="tab-content" style="background-color: #F4F6F8" id="lp_orders">
                    @include('admin.ekom.payments.render-lp-orders')
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).on('click', '.nav-tabs a', function (e) {
            tab_id = $(this).data('type');
            var data = {
//                tab_id: tab_id,
            }
            $.ajax({
                url: "{{url('admin/payments/lp-orders')}}",
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    history.pushState(null, null, this.url);
                    $("#lp_orders").html(html)
                }
            });

        });


        $(document).on('click', '.pagination a', function (e) {
            var search_string = $('#search_string').val();
            var page = $(this).attr('href').split('page=')[1];
            var data = {
//                tab_id: tab_id,
                search_string: search_string,
                page: page,
            }

            $.ajax({
                url: "{{url('admin/payments/lp-orders')}}",
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    history.pushState(null, null, this.url);
                    $("#lp_orders").html(html);
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
            var data = {
                search_string: search_string,
//                tab_id: tab_id
            }
            $.ajax({
                url: "{{url('admin/payments/lp-orders')}}",
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    history.pushState(null, null, this.url);
                    $("#lp_orders").html(html);
                }
            });
        }
    </script>

@endsection