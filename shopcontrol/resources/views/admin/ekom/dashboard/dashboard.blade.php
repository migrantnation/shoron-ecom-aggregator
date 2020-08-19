@extends('admin.layouts.master_demo')
@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link href="{{asset('public/admin_ui_assets')}}/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('public/admin_ui_assets')}}/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('public/admin_ui_assets')}}/assets/demo/demo6/base/style.bundle.css" rel="stylesheet" type="text/css"/>

    <div class="filter-nav-wrap">
        <div class="filter-nav">
            <form class="form-inline" action="{{url("admin")}}">
                <div class="form-group">
                    <label for="email">Filter By:</label>
                </div> &nbsp; &nbsp;
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-default filter-range" data-value="all">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off" checked
                               value="all"> All
                    </label>
                    <label class="btn btn-default filter-range" data-value="day">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off"
                               value="day"> Today
                    </label>
                    <label class="btn btn-default filter-range" data-value="week">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off"
                               value="week"> This Week
                    </label>
                    <label class="btn btn-default filter-range active" data-value="month">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off"
                               value="month"> This Month
                    </label>
                    <label class="btn btn-default filter-range" data-value="lastmonth">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off"
                               value="lastmonth"> Last Month
                    </label>

                    <label class="btn btn-default filter-range" data-value="year">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off"
                               value="year"> This Year
                    </label>

                    <form class="form-inline" action="javascript:;">
                        <div class="form-group">
                            <input id="periodpickerstart" type="text" name="from" value="{{@$_POST['from'] ? @$_POST['from'] : @$from}}">
                            <input id="periodpickerend" type="text" name="to" value="{{@$_POST['to'] ? @$_POST['to'] : @$to}}">
                        </div>

                        <label class="btn btn-default filter-range" data-value="custom-date-range">
                            <input type="radio" class="view-type" name="view_type" autocomplete="off"
                                   value="year"> Filter
                        </label>
                    </form>


                </div>
            </form>
        </div>
    </div>

    <div class="m-content" style="padding-top: 50px; position: relative" id="dashboard-render">
        @include('admin.ekom.dashboard.render-dashboard')
    </div>

    <script src="{{asset('public/admin_ui_assets')}}/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="{{asset('public/admin_ui_assets')}}/assets/demo/demo6/base/scripts.bundle.js" type="text/javascript"></script>
    <script src="{{asset('public/admin_ui_assets')}}/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
    <script src="{{asset('public/admin_ui_assets')}}/assets/app/js/dashboard.js" type="text/javascript"></script>

    <script>

        var filter_range = "month";

        $(document).on('click', '.filter-range', function (e) {

            $('#loader').show();
            filter_range = $(this).data('value');
            from = $("#periodpickerstart").val();
            to = $("#periodpickerend").val();
            var url = "{{url('admin')}}";

            var data = {
                "filter_range": filter_range,
                "from": from,
                "to": to
            };

            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#dashboard-render").html(html);
                    Dashboard.init();

                    $('#loader').fadeOut();

                    active_user(data);
                    cancel_order_graph(data);
                    ep_statistics_graph(data);
                    _ecom__partners(data);
                    visitor(data);
                    top_users(data);
                    sale_per_day(data);
                    transaction_per_day(data);
                    order_per_entrepreneur_per_day(data);
                    average_delivery_time(data);
                }
            });
        });


        function active_user(data) {
            var URL = '{{url('active-user-graph')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#active-user-graph").html(xhr);
                    Dashboard.initActiveUserChart();
                }
            });
        }

        active_user({"filter_range": "{{@$filter_range}}}"});


        function cancel_order_graph(data) {
            var URL = '{{url('cancel-order-graph')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#cancel-order-graph").html(xhr);
                    Dashboard.initCancelOrderChart();
                }
            });
        }

        cancel_order_graph({"filter_range": "{{@$filter_range}}}"});


        function ep_statistics_graph(data) {
            var URL = '{{url('ep-statistics-graph')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#ep-statistics-graph").html(xhr);
                    Dashboard.initEPStatisticsChart();
                }
            });
        }

        ep_statistics_graph({"filter_range": "{{@$filter_range}}}"});


        function visitor(data) {
            var URL = '{{url('visitors')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#visitors").html(xhr);
                    Dashboard.visitorsChart();
                }
            });
        }

        visitor({"filter_range": "{{@$filter_range}}}"});


        function _ecom__partners(data) {
            var URL = '{{url('_ecom_-partners')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#_ecom_-partners").html(xhr);
                }
            });
        }

        _ecom__partners({"filter_range": "{{@$filter_range}}}"});


        function top_users(data) {
            var URL = '{{url('top-users')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#top-users").html(xhr);
                }
            });
        }

        top_users({"filter_range": "{{@$filter_range}}}"});


        function sale_per_day(data) {
            var URL = '{{url('sale-per-day')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#sale-per-day-kpi-graph").html(xhr);
                    Dashboard.salePerDayChart();
                }
            });
        }

        sale_per_day({"filter_range": "{{@$filter_range}}}"});


        function transaction_per_day(data) {
            var URL = '{{url('transaction-per-day')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#transaction-per-day-kpi-graph").html(xhr);
                    Dashboard.transactionPerDayChart();
                }
            });
        }

        transaction_per_day({"filter_range": "{{@$filter_range}}}"});


        function order_per_entrepreneur_per_day(data) {
            var URL = '{{url('order-per-entrepreneur-per-day')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#opepd-per-day-kpi-graph").html(xhr);
                    Dashboard.opepdChart();
                }
            });
        }

        order_per_entrepreneur_per_day({"filter_range": "{{@$filter_range}}}"});


        function average_delivery_time(data) {
            var URL = '{{url('average-delivery-time')}}';
            $.ajax({
                url: URL,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (xhr) {
                    $("#adt-kpi-graph").html(xhr);
                    Dashboard.averageDeliveryTimeChart();
                }
            });
        }

        average_delivery_time({"filter_range": "{{@$filter_range}}}"});

    </script>
@endsection
