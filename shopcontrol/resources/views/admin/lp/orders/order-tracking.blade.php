@extends('admin.layouts.master')
@section('content')

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
                <a href="{{url('/lp')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Order Tracking</span>
            </li>
        </ul>
    </div>

    <div class="container-alt margin-top-20">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">Track your order</span>
                </div>
            </div>
            <div class="portlet-body">

                <form action="javascript:void(0)" method="get" id="SubmitSearch">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="search_string" id="search_string"
                                   placeholder="Enter Order ID" required
                                   value="{{@$_GET['search_string'] ? @$_GET['search_string'] : @$order_info->order_code}}">
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <hr>

                <div id="tracking-info">
                    @include('admin.lp.orders.order-tracking-render')
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
                url: "{{url('lp/oder-tracking')}}" + "/" + search_string,
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