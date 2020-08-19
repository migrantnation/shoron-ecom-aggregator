<div id="loader" class="loader-overlay">
    <div class="loader">Loading...</div>
</div>

<?php
$report_type = array("all" => "All", "day" => "Today's", "week" => "This week's", "month" => "This month's", "year" => "This year's", "lastmonth" => "Last Month", "custom-date-range" => "");
if ($filter_range) {
    $meta_title = $report_type[$filter_range];
} else {
    $meta_title = "All";
}
?>
<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-12">

                <div class="m-widget14">
                    <div class="m-widget14__header" style="padding: 0px">
                        <h3 class="m-widget14__title">
                            {{ 'Sales '. __('admin_text.tk.') . ' ' . number_format(@$total_sales ? (int)(@$total_sales) : 0) . ' :: Orders ' . array_sum(explode(',',@$order_chart_day_values))}}
                        </h3>
                        <span class="m-widget14__desc">
                            All sales and orders without cancel order
                        </span>
                    </div>
                    <div class="m-widget14__chart" style="height: 250px;">
                        <canvas id="m_chart_daily_sales"
                                data-label="Sales"
                                height="320"
                                data-labels='[{{@$sale_labels}}]'
                                data-orders-values="[{{@$order_chart_day_values}}]"
                                data-sale-values="[{{@$sale_values}}]"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<style>
    .dynamiclink:hover {
        background-color: #e2e2e2 !important;
        text-decoration: none;
        display: block;
    }

    .dynamiclink a {
        text-decoration: none;
    }
</style>

@php
    $from = date("Y-m-d", strtotime($from));
    $to = date("Y-m-d", strtotime($to));
@endphp


<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-6">

                <div class="m-widget1">
                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/udc?tab_id=all"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Registered Users</h3>
                                    <span class="m-widget1__desc">Onboard Digital Center</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-brand">{{@$registered_users->count()}}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/udc?tab_id=1"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Connected Users</h3>
                                    <span class="m-widget1__desc">Activated Digital Center</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-brand yellow">{{@$activated_users->count()}}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/udc?tab_id=transacting"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Transacting Users</h3>
                                    <span class="m-widget1__desc">Digital center who have at least one order</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-brand yellow">{{ @$active_users->count()}}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/udc?tab_id=non-transacting"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Non Transacting Users</h3>
                                    <span class="m-widget1__desc">Digital center without any order</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-brand yellow">{{@$non_transacting_users->count()}}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/udc?tab_id=4"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Users Out Of Reach</h3>
                                    <span class="m-widget1__desc">Digital centers who are out of reach</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-brand yellow">{{@$users_out_of_reach->count()}}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/udc?tab_id=0"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Users Need Activation</h3>
                                    <span class="m-widget1__desc">Digital centers who need activation</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-brand yellow">{{@$users_need_activation->count()}}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

            <div class="col-xl-6">
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <h3 class="m-widget14__title">
                            User Statistics
                        </h3>
                    </div>
                    <div class="row  align-items-center">
                        <div class="col">
                            <div>
                                <canvas id="m_userStatistics" height="250"
                                        data-colors='["#6f42c1", "#34bfa3", "#ffb822", "#ffb822", "#f4516c"]'
                                        data-labels='["Connected", "Transacting","Non Transacting", "Out Of Reach", "Need Activation"]'
                                        data-values="[{{@$activated_users->count() . ','. @$active_users->count() . ','. @$non_transacting_users->count() . ','. @$users_out_of_reach->count() . ','. @$users_need_activation->count()}}]">
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-6">

                <div class="m-widget1">

                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/orders/ep-orders?from=$from&to=$to"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Number of orders</h3>
                                    <span class="m-widget1__desc">{{$meta_title}}&nbsp; orders</span>
                                </div>
                                <div class="col m--align-right">
                                <span class="m-widget1__number m--font-warning"
                                      style="color: #6f42c1">{{$orders->count()}}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/orders/ep-orders?from=$from&to=$to&tab_id=2"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Orders on Fulfilment </h3>
                                    <span class="m-widget1__desc">{{$meta_title}}&nbsp; warehouse left and on delivery orders</span>
                                </div>
                                <div class="col m--align-right">
                                <span class="m-widget1__number m--font-focus"
                                      style="color: #6f42c1">{{($orders->where('status', 1)->count()+$orders->where('status', 2)->count() + $orders->where('status', 3)->count())}}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/orders/ep-orders?from=$from&to=$to&tab_id=5"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Cancelled orders</h3>
                                    <span class="m-widget1__desc">{{$meta_title}}&nbsp; orders</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-danger">{{$canceled_orders->count()}}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="m-widget1__item dynamiclink">
                        <a href="{{(Auth::guard('web_admin')->user()->id != 3)?url("admin/orders/ep-orders?from=$from&to=$to&tab_id=4"):'javascript:;'}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Delivered orders</h3>
                                    <span class="m-widget1__desc">{{$meta_title}}
                                        &nbsp;successfully completed orders</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-success">{{$orders->where('status', 4)->count()}}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <h3 class="m-widget14__title">
                            {{$meta_title}}&nbsp;Order Statistics
                        </h3>
                        <span class="m-widget14__desc">
                            Check {{$meta_title}}&nbsp;Order Status
                        </span>
                    </div>
                    <div class="row  align-items-center">
                        <div class="col">
                            <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 160px">
                                <div class="m-widget14__stat">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="m-widget14__legends">
                                <div class="m-widget14__legend">
                                    <span class="m-widget14__legend-bullet m--bg-warning"></span>
                                    <span class="m-widget14__legend-text newOrder" data-value="{{$new}}">
                                        {{number_format($new)}}% New Orders
                                    </span>
                                </div>
                                <div class="m-widget14__legend">
                                    <span class="m-widget14__legend-bullet m--bg-info"></span>
                                    <span class="m-widget14__legend-text warehouseLeft"
                                          data-value="{{$warehouse_left}}">
                                        {{number_format($warehouse_left)}}% Warehouse Left
                                    </span>
                                </div>
                                <div class="m-widget14__legend">
                                    <span class="m-widget14__legend-bullet m--bg-primary"></span>
                                    <span class="m-widget14__legend-text onDelivery"
                                          data-value="{{$on_delivery}}">
                                        {{number_format($on_delivery)}}% On Delivery
                                    </span>
                                </div>
                                <div class="m-widget14__legend">
                                    <span class="m-widget14__legend-bullet m--bg-success"></span>
                                    <span class="m-widget14__legend-text deliveredOrders"
                                          data-value="{{$delivered}}">
                                        {{number_format($delivered)}}% Delivered Orders
                                    </span>
                                </div>
                                <div class="m-widget14__legend">
                                    <span class="m-widget14__legend-bullet m--bg-danger"></span>
                                    <span class="m-widget14__legend-text cancelledOrders"
                                          data-value="{{$cancelled}}">
                                        {{number_format($cancelled)}}% Cancelled Orders
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <h4 class="section-title" style="margin-bottom: 15px">Key Performance Indicator</h4>

        <div class="row">

            <?php $class = "col-xs-12 col-sm-6 col-md-6 col-lg-6";?>


            <div class="{{$class}}">
                <div class="m-portlet m-portlet--border-bottom-brand ">
                    <div class="m-portlet__body">
                        <div class="m-widget26" id="sale-per-day-kpi-graph">
                            @include('admin.ekom.dashboard.render-kpi-graph-sale-per-day')
                        </div>
                    </div>
                </div>
            </div>


            <div class="{{$class}}">
                <div class="m-portlet m-portlet--border-bottom-danger ">
                    <div class="m-portlet__body">
                        <div class="m-widget26" id="transaction-per-day-kpi-graph">
                            @include('admin.ekom.dashboard.render-kpi-graph-transaction-per-day')
                        </div>
                    </div>
                </div>
            </div>


            {{--<div class="{{$class}}">--}}
            {{--<div class="m-portlet m-portlet--border-bottom-success ">--}}
            {{--<div class="m-portlet__body">--}}
            {{--<div class="m-widget26" id="opepd-per-day-kpi-graph">--}}
            {{--@include('admin.ekom.dashboard.render-kpi-graph-opepd-per-day')--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class="{{$class}}">--}}
            {{--<div class="m-portlet m-portlet--border-bottom-accent ">--}}
            {{--<div class="m-portlet__body">--}}
            {{--<div class="m-widget26" id="adt-kpi-graph">--}}
            {{--@include('admin.ekom.dashboard.render-kpi-graph-average-delivery-time')--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}

        </div>

    </div>
</div>


<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-12">

                <div class="m-widget14" id="active-user-graph">
                    @include('admin.ekom.dashboard.render-active-user-graph')
                </div>

            </div>
        </div>
    </div>
</div>


<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-12">

                <div class="m-widget14" id="cancel-order-graph">
                    @include('admin.ekom.dashboard.render-cancel-order-graph')
                </div>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit "
             style="min-height: 300px" id="ep-statistics-graph">
            @include('admin.ekom.dashboard.render-ep-statistics-graph')
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit "
             style="min-height: 300px">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{$meta_title}} Visitors
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-widget20" id="visitors">
                    @include('admin.ekom.dashboard.render-visitor-graph')
                </div>
            </div>
        </div>
        <div class="m--space-30"></div>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            _ecom_ Partners
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm"
                        role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="plx__nav-link nav-link m-tabs__link active" data-toggle="plx_tab"
                               href="#m_widget5_tab1_content" role="tab">
                                eCommerce
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="plx__nav-link nav-link m-tabs__link" data-toggle="plx_tab"
                               href="#m_widget5_tab2_content"
                               role="tab">
                                Logistics
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body" id="_ecom_-partners">
                <div id="_ecom_-partners-loader" class="loader-overlay">
                    <div class="loader">Loading...</div>
                </div>
                @include('admin.ekom.dashboard.render-_ecom_-partners')
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="m-portlet m-portlet--mobile ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Recent Order List
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m_datatable" id="m_datatable_latest_orders"
                     data-url="{{url("recent-order-list/admin/$from/$to")}}"
                     data-baseURL="{{url('')}}"></div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Top Digital Center
                        </h3>
                    </div>
                </div>
            </div>

            <div class="m-portlet__body">
                <div class="m-widget4">
                    <div class="row" id="top-users">
                        @include('admin.ekom.dashboard.render-top-user')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>