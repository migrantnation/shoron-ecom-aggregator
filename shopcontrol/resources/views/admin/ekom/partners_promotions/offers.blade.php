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
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">Offers
        <small></small>
    </h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="tabbable-line boxless tabbable-reversed">
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
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
            var search_string = $('#search_string').val();
            var from = $('#from').val();
            var to = $('#to').val();
            $('#ep_orders').html('');
            $('.overlay-wrap').show();

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
                    $('.overlay-wrap').hide();
//                    history.pushState(null, null, this.url);
                    $("#ep_orders").html(html);
                    datePickerInit();
                }
            });

        });

        $(document).on('click', '.pagination a', function (e) {

            e.preventDefault();

            var search_string = $('#search_string').val();
            var from = $('#from').val();
            var to = $('#to').val();
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
//                    history.pushState(null, null, this.url);
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
            var from = $('#from').val();
            var to = $('#to').val();

            $('#ep_orders').html('');
            $('.overlay-wrap').show();

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
                    $('.overlay-wrap').hide();
                    $("#ep_orders").html(html);
                    datePickerInit();
                }
            });
        }

        function datePickerInit() {
            $('.input-daterange').datepicker();
        }
    </script>
@endsection