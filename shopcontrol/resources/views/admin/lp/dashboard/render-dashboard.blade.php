<div id="loader" class="loader-overlay">
    <div class="loader">Loading...</div>
</div>

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
            <div class="col-xl-6">
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Total orders</h3>
                                <span class="m-widget1__desc">{{$meta_title}}&nbsp; orders</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number green"
                                      style="color: #6f42c1">{{$orders->count()}}</span>
                            </div>
                        </div>
                    </div>


                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Active Orders</h3>
                                <span class="m-widget1__desc">New order placed by digital center</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-focus"
                                      style="color: #6f42c1">{{$orders->where('status', 1)->count()}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Warehouse Left Orders</h3>
                                <span class="m-widget1__desc">Orders left warehouse from EP</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-focus"
                                      style="color: #6f42c1">{{($orders->where('status', 2)->count())}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Orders on delivery</h3>
                                <span class="m-widget1__desc">Orders send to transport</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-success">{{$orders->where('status', 3)->count()}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Delivered Orders</h3>
                                <span class="m-widget1__desc">Orders received by DC</span>
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
                                <span class="m-widget1__desc">Canceled orders</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-danger">{{$canceled_orders->count()}}</span>
                            </div>
                        </div>
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

        <div class="row m-row--full-height">

            @if(@$filter_range == 'all')
                <?php $class = "col-xs-12 col-sm-4 col-md-4 col-lg-4";?>
            @elseif(@$filter_range == 'year')
                <?php $class = "col-xs-12 col-sm-6 col-md-6 col-lg-6";?>
            @else
                <?php $class = "col-xs-12 col-sm-12 col-md-12 col-lg-12";?>
            @endif

            <div class="{{$class}}">
                <div class="m-portlet m-portlet--border-bottom-accent ">
                    <div class="m-portlet__body">
                        <div class="m-widget26">
                            <div class="m-widget26__number" style="font-size: 20px">
                                {{$meta_title}} Delivered Orders ({{$orders->where('status',4)->count()}})
                                <small>Delivered Orders</small>
                            </div>
                            <div class="m-widget26__chart" style="height:180px;">
                                <canvas id="m_chart_quick_stats_5"
                                        data-labels='[{{@$delivered_order_array}}]'
                                        data-values="[{{@$delivered_order_values}}]">

                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
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

                <div class="m_datatable" id="lp_datatable_latest_orders"
                     data-url="{{url("recent-order-list/lp/$from/$to")}}"
                     data-baseURL="{{url('')}}"></div>

            </div>
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
                            {{$meta_title}}&nbsp;Order Stats
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">

                <div class="m-widget20">
                    <div class="m-widget20__number m--font-success">
                        {{array_sum(explode(',',@$order_chart_day_values))}}
                    </div>
                    <div class="m-widget15__chart" style="height:180px;">
                        <canvas id="m_chart_orders_stats"
                                data-labels='[{{@$order_day_array}}]'
                                data-values="[{{@$order_chart_day_values}}]"></canvas>
                    </div>
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
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <div class="tab-content">
                    <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">

                        <div class="table-responsive">
                            <table class="table" style="table-layout: fixed">
                                <thead>
                                <tr>
                                    <th class="text-center">eCommerce Name</th>
                                    <th class="text-center">Sales</th>
                                    <th class="text-center">Total Orders</th>
                                    <th class="text-center">Active Orders</th>
                                    <th class="text-center">Warehouse left</th>
                                    <th class="text-center">On Delivery</th>
                                    <th class="text-center">Delivered Orders</th>
                                    <th class="text-center">Cancelled Orders</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $active_ep = $active_ep->sortBy("status");
                                ?>
                                @forelse($active_ep as $key=>$ep)

                                    <tr class="{{($ep->status != 1)?"plx_disabled":""}}">
                                        <td width="90">
                                            <div class="logo_thumb">
                                                <img class="plx__img m-widget7__img"
                                                     src="{{url("public/content-dir/ecommerce_partners/$ep->ep_logo")}}"
                                                     alt="">
                                            </div>
                                        </td>

                                        @if(@$filter_range == 'all' || !@$filter_range)
                                            <?php $ep_orders = $ep->orders;?>
                                        @else
                                            <?php $ep_orders = $ep->orders->where('created_at', '>=', $from)->where('created_at', '<=', $to);?>
                                        @endif

                                        <td class="text-right">{{__('admin_text.tk.')}} {{number_format($ep_orders->where('status', '!=', 5)->sum('total_price'))}}</td>
                                        <td class="text-center">{{$ep_orders->count()}}</td>
                                        <td class="text-center">{{$ep_orders->where('status', 1)->count()}}</td>
                                        <td class="text-center">{{$ep_orders->where('status', 2)->count()}}</td>
                                        <td class="text-center">{{$ep_orders->where('status', 3)->count()}}</td>
                                        <td class="text-center">{{$ep_orders->where('status', 4)->count()}}</td>
                                        <td class="text-center">{{$ep_orders->where('status', 5)->count()}}</td>

                                    </tr>

                                @empty

                                @endforelse
                                </tbody>
                            </table>
                        </div>

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

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

