
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
                                <h3 class="m-widget1__title">Number of Buys</h3>
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
                                <h3 class="m-widget1__title">Orders on Fulfilment </h3>
                                <span class="m-widget1__desc">{{$meta_title}}&nbsp; Active, warehouse left and on delivery orders</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-focus"
                                      style="color: #6f42c1">{{($orders->where('status', 1)->count()+$orders->where('status', 2)->count() + $orders->where('status', 3)->count())}}</span>
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

                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Received orders</h3>
                                <span class="m-widget1__desc">{{$meta_title}}&nbsp;successfully completed orders</span>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-success">{{$orders->where('status', 4)->count()}}</span>
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

<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-12">
                <!--begin:: Widgets/Daily Sales-->
                <div class="m-widget14">
                    <div class="m-widget14__header m--margin-bottom-30">
                        <h3 class="m-widget14__title">
                            {{$meta_title}}&nbsp;buys
                            ({{__('admin_text.tk.')}} {{ number_format($all_sales->total_sale ? (int)(@$all_sales->total_sale) : 0)}}
                            )
                        </h3>
                        <span class="m-widget14__desc">
                            Check out each column for more details
                        </span>
                    </div>
                    <div class="m-widget14__chart" style="height: 400px;">
                        <canvas id="m_chart_daily_sales"
                                height="320"
                                data-label="Buys"
                                data-labels='[{{@$sale_labels}}]'
                                data-sale-values="[{{@$sale_values}}]">

                        </canvas>
                    </div>
                </div>
                <!--end:: Widgets/Daily Sales-->
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
                <?php $class = "col-xs-12 col-sm-6 col-md-4 col-lg-4";?>
            @elseif(@$filter_range == 'year')
                <?php $class = "col-xs-12 col-sm-6 col-md-6 col-lg-6";?>
            @else
                <?php $class = "col-xs-12 col-sm-6 col-md-6 col-lg-6";?>
            @endif


            <div class="{{$class}}">
                <div class="m-portlet m-portlet--border-bottom-brand ">
                    <div class="m-portlet__body">
                        <div class="m-widget26">
                            <div class="m-widget26__number">
                                {{__('admin_text.tk.')}} {{ number_format($all_sales->total_sale ? (int)(@$all_sales->total_sale) : 0)}}
                                <small>{{$meta_title}}&nbsp;Buys</small>
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

            @if(@$filter_range == 'all' || @$filter_range == 'day' )
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
                <div class="m_datatable" id="dc_datatable_latest_orders"
                     data-url="{{url("recent-order-list/dc/$from/$to")}}"
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
        <!--begin:: Widgets/Inbound Bandwidth-->
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
                <!--begin::Widget5-->
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
                <!--end::Widget 5-->
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
            <div class="m-portlet__body">
                <!--begin::Content-->
                <div class="tab-content">
                    <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">
                        <!--begin::m-widget5-->
                        <div class="table-responsive">
                            <table class="table" style="table-layout: fixed">
                                <thead>
                                <tr>
                                    <th class="text-center">eCommerce Name</th>
                                    <th class="text-center">Buys</th>
                                    <th class="text-center">Total Orders</th>
                                    <th class="text-center">Active Orders</th>
                                    <th class="text-center">Warehouse left</th>
                                    <th class="text-center">On Delivery</th>
                                    <th class="text-center">Delivered Orders</th>
                                    <th class="text-center">Cancelled Orders</th>
                                    <th class="text-center">Commission</th>
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
                                        <td>{{__('admin_text.tk.')}} {{number_format($ep_orders->where('status','!=', 5)->sum('udc_commission'), 2)}}</td>

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

                    <div class="tab-pane" id="m_widget5_tab2_content" aria-expanded="false">
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
<!--End::Section-->
{{--@if(@$filter_range == 'all')--}}
{{--@endif--}}
