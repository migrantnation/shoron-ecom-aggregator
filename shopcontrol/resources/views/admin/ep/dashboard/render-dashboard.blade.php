<div id="loader" class="loader-overlay">
    <div class="loader">Loading...</div>
</div>
<!--Begin::Section-->
<?php
$report_type = array("all" => "All", "day" => "Today's", "week" => "This week's", "month" => "This month's", "year" => "This year's");
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
                <!--begin:: Widgets/Daily Sales-->
                <div class="m-widget14">
                    <div class="m-widget14__header m--margin-bottom-30">
                        <h3 class="m-widget14__title">
                            {{$meta_title}}&nbsp;sales
                            ({{__('admin_text.tk.')}} {{ number_format($all_sales->total_sale ? (int)(@$all_sales->total_sale) : 0)}}
                            :: {{array_sum(explode(',',@$order_chart_day_values))}})
                        </h3>
                        <span class="m-widget14__desc">
                            Check out each column for more details
                        </span>
                    </div>
                    <div class="m-widget14__chart" style="height: 400px;">
                        <canvas id="m_chart_daily_sales"
                                data-label = "Sales"
                                height="320"
                                data-labels='[{{@$sale_labels}}]'
                                data-orders-values="[{{@$order_chart_day_values}}]"
                                data-sale-values="[{{@$sale_values}}]"></canvas>
                    </div>
                </div>
                <!--end:: Widgets/Daily Sales-->
            </div>
        </div>
    </div>
</div>
<!--End::Section-->

<!--Begin::Section-->
<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-6">
                <!--begin:: Widgets/Stats2-1 -->
                <div class="m-widget1">

                    <div class="m-widget1__item">
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
                    </div>

                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Active Orders</h3>
                                <span class="m-widget1__desc">{{$meta_title}}&nbsp; warehouse left and on delivery orders</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-warning"
                                      style="color: #6f42c1">{{($orders->where('status', 1)->count())}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Warehouse Left </h3>
                                <span class="m-widget1__desc">{{$meta_title}}&nbsp; warehouse left orders</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-brand">{{$orders->where('status', 2)->count()}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Orders on Delivery </h3>
                                <span class="m-widget1__desc">{{$meta_title}}&nbsp; on delivery orders</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-focus">{{$orders->where('status', 3)->count()}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Delivered orders</h3>
                                <span class="m-widget1__desc">{{$meta_title}}&nbsp;successfully completed orders</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-success">{{$orders->where('status', 4)->count()}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Cancelled orders</h3>
                                <span class="m-widget1__desc">{{$meta_title}}&nbsp; orders</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-danger">{{$canceled_orders->count()}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:: Widgets/Stats2-1 -->
            </div>
            <div class="col-xl-6">
                <!--begin:: Widgets/Profit Share-->
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
                <!--end:: Widgets/Profit Share-->
            </div>
        </div>
    </div>
</div>
<!--End::Section-->

<!--Begin::Section-->
<div class="row">
    <div class="col-xl-12">
        <!--begin:: Widgets/Quick Stats-->
        <div class="row m-row--full-height">

            @if(@$filter_range == 'all')
                <?php $class = "col-xs-12 col-sm-6 col-md-3 col-lg-3";?>
            @elseif(@$filter_range == 'year')
                <?php $class = "col-xs-12 col-sm-4 col-md-4 col-lg-4";?>
            @else
                <?php $class = "col-xs-12 col-sm-6 col-md-6 col-lg-6";?>
            @endif

            <div class="{{$class}}">
                <div class="m-portlet m-portlet--border-bottom-brand ">
                    <div class="m-portlet__body">
                        <div class="m-widget26">
                            <div class="m-widget26__number">
                                {{__('admin_text.tk.')}} {{ number_format($all_sales->total_sale ? (int)(@$all_sales->total_sale) : 0)}}
                                <small>{{$meta_title}}&nbsp;sales</small>
                            </div>
                            <div class="m-widget26__chart" style="height:200px; width: 100%;">
                                <canvas id="m_chart_quick_stats_1" height="200"
                                        data-values="[{{@$sale_chart_values}}]"
                                        data-labels='[{{@$chart_labels}}]'
                                ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m--space-30"></div>
            </div>

            @if(@$filter_range == 'all')
                <div class="{{$class}}">
                    <div class="m-portlet m-portlet--border-bottom-danger ">
                        <div class="m-portlet__body">
                            <div class="m-widget26">
                                <div class="m-widget26__number">
                                    {{ number_format(@$todays_total_order->todays_total_order ? (int)(@$todays_total_order->todays_total_order) : 0)}}
                                    <small>Today's Orders</small>
                                </div>
                                <div class="m-widget26__chart" style="height:200px; width: 100%;">
                                    <canvas id="m_chart_quick_stats_2" height="200"
                                            data-values="[{{@$order_chart_values}}]"
                                            data-labels='[{{@$order_chart_labels}}]'
                                    ></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="{{$class}}">
                <div class="m-portlet m-portlet--border-bottom-success ">
                    <div class="m-portlet__body">
                        <div class="m-widget26">
                            <div class="m-widget26__number">
                                {{__('admin_text.tk.')}} {{ number_format(@$udc_commission ? (int)(@$udc_commission) : 0)}}
                                <small>{{$meta_title}}&nbsp;UDC Commission</small>
                            </div>
                            <div class="m-widget26__chart" style="height:200px; width: 100%;">
                                <canvas id="m_chart_quick_stats_3" height="200"
                                        data-values="[{{@$udc_commission_chart_values}}]"
                                        data-labels='[{{@$udc_commission_chart_labels}}]'
                                ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(@$filter_range == 'all'||@$filter_range == 'year')
                <div class="{{$class}}">
                    <div class="m-portlet m-portlet--border-bottom-accent ">
                        <div class="m-portlet__body">
                            <div class="m-widget26">
                                <div class="m-widget26__number">
                                    {{@$average_order_delivery_time ? ceil($average_order_delivery_time) : 0}} Days
                                    <small>Average Delivery Time</small>
                                </div>
                                <div class="m-widget26__chart" style="height:200px; width: 100%;">
                                    <canvas id="m_chart_quick_stats_4" height="200"
                                            data-values="[{{@$avg_delivery}}]"
                                            data-labels='[{{@$avg_delivery_lbl}}]'
                                    ></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <!--end:: Widgets/Quick Stats-->
    </div>
</div>
<!--End::Section-->

<!--Begin::Section-->
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
                <!--begin: Datatable -->
                <div class="m_datatable" id="ep_datatable_latest_orders"
                     data-url="{{url("recent-order-list/ep/$from/$to")}}"
                     data-baseURL="{{url('')}}"></div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
</div>
<!--End::Section-->


<!--Begin::Section-->
<div class="row">
    <div class="col-xl-12">
        <!--begin:: Widgets/Best Sellers-->
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Logistics Partners
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin::Content-->
                <div class="tab-content">

                    <style>
                        .logo_thumb {
                            width: 80px;
                            height: 50px;
                            line-height: 50px;
                        }

                        .logo_thumb img {
                            display: inline-block;
                            max-height: 100%;
                            max-width: 100%;
                        }
                    </style>

                    <div class="tab-pane active" id="m_widget5_tab2_content" aria-expanded="true">
                        <!--begin::m-widget5-->
                        <table class="table" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th class="text-center">Logistic name</th>
                                <th class="text-center">Orders Values</th>
                                <th class="text-center">Total Orders</th>
                                <th class="text-center">Active Orders</th>
                                <th class="text-center">Warehouse Left</th>
                                <th class="text-center">On Delivery</th>
                                <th class="text-center">Delivered Orders</th>
                                <th class="text-center">Cancelled Order</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($active_lp as $key=>$lp)
                                <tr>
                                    <td width="90">
                                        <div class="logo_thumb">
                                            <img class="m-widget7__img"
                                                 src="{{url("public/content-dir/logistic_partners/$lp->lp_logo")}}"
                                                 alt="">
                                        </div>
                                    </td>


                                    @if(@$filter_range == 'all' || !@$filter_range)
                                        <?php $lp_orders = $lp->orders;?>
                                    @else
                                        <?php $lp_orders = $lp->orders->where('created_at', '>=', $from)->where('created_at', '<=', $to);?>
                                    @endif

                                    <td class="text-right">{{__('admin_text.tk.')}} {{number_format($lp_orders->where('status', '!=', 5)->sum('total_price'))}}</td>
                                    <td class="text-center">{{$lp_orders->count()}}</td>
                                    <td class="text-center">{{$lp_orders->where('status', 1)->count()}}</td>
                                    <td class="text-center">{{$lp_orders->where('status', 2)->count()}}</td>
                                    <td class="text-center">{{$lp_orders->where('status', 3)->count()}}</td>
                                    <td class="text-center">{{$lp_orders->where('status', 4)->count()}}</td>
                                    <td class="text-center">{{$lp_orders->where('status', 5)->count()}}</td>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Content-->
            </div>
        </div>
        <!--end:: Widgets/Best Sellers-->
    </div>
</div>

