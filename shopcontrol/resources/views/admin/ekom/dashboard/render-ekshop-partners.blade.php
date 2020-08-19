<div class="tab-content">
    <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">
        <!--begin::m-widget5-->

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
                @if(@$active_ep)
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
                @endif

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

            @if(@$active_lp)
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
            @endif
            </tbody>
        </table>
    </div>

</div>