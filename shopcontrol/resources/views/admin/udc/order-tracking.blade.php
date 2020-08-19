@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->

    <style>
        .plx__table {
            line-height: 32px;
        }

        .plx__table td {
            vertical-align: top;
        }
    </style>

    <div class="page-bar">

        <ul class="page-breadcrumb">

            <li>
                <a href="{{url('/udc')}}">{{__('admin_text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <span>{{__('admin_text.order-tracking')}}</span>
            </li>

        </ul>

    </div>

    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        {{--<a href="http://plx1.website/e-kom-dev/udc/product-list" class=""><small class="fa fa-angle-left"></small>&nbsp;Order Tracking</a>--}}
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">{{__('admin_text.track-your-order')}}</span>
                </div>
            </div>
            <div class="portlet-body">

                <form action="javascript:void(0)" method="get" id="SubmitSearch">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="search_string" id="search_string"
                                   placeholder="Enter Order ID..." required
                                   value="{{@$_GET['search_string'] ? @$_GET['search_string'] : ''}}">
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-primary" type="submit">{{__('admin_text.search')}}</button>
                        </div>
                    </div>
                </form>

                <hr>

                <div id="tracking-info">
                    @include('admin.udc.order-tracking-render')
                </div>


            </div>
        </div>
    </div>

    <script>
        $("#submit_search").click(function (e) {
            e.preventDefault();
            ajaxpush();
        });

        function ajaxpush() {
            var search_string = $('#search_string').val();
            $.ajax({
                url: "{{url('udc/order-tracking')}}" + "/" + search_string,
                type: "get",
                dataType: 'json',
                success: function (html) {
                    $("#tracking-info").html(html);
                    history.pushState(null, null, this.url);
                }
            });
        }
    </script>
@endsection