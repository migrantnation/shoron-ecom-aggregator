<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">


            <li class="{{@$dashboard}} nav-item">
                <a href="{{url('admin')}}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{__('_ecom__text.dashboard')}}</span>
                </a>
            </li>


            @if(Auth::guard('web_admin')->user()->id != 3)
                {{--<li class="{{@$staff_management}} nav-item">--}}

                {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                {{--<i class="icon-users"></i>--}}
                {{--<span class="title">{{__('_ecom__text.staff-management')}}</span>--}}
                {{--<span class="arrow "></span>--}}
                {{--</a>--}}

                {{--<ul class="sub-menu">--}}
                {{--<li class="{{@$super_admin}} nav-item">--}}
                {{--<a href="{{url('admin/super-admin-list')}}" class="nav-link nav-toggle">--}}
                {{--{{__('_ecom__text.supper-admin')}}</a>--}}
                {{--</li>--}}
                {{--<li class="{{@$customer_support}} nav-item">--}}
                {{--<a href="{{url('admin/customer-support-list')}}" class="nav-link nav-toggle">--}}
                {{--{{__('_ecom__text.customer-support')}}--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--<li class="{{@$accountant}} nav-item">--}}
                {{--<a href="{{url('admin/accountant-list')}}" class="nav-link nav-toggle">--}}
                {{--{{__('_ecom__text.accountant')}}</a>--}}
                {{--</li>--}}
                {{--<li class="{{@$resulation_manager}} nav-item">--}}
                {{--<a href="{{url('admin/resolution-manager-list')}}" class="nav-link nav-toggle">--}}
                {{--{{__('_ecom__text.resolution-manager')}}</a>--}}
                {{--</li>--}}
                {{--</ul>--}}
                {{--</li>--}}

                <li class="{{@$udc_management}} nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-university"></i>
                        <span class="title">{{__('_ecom__text.udc-management')}}</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu">
                        <li class="{{@$all_udc}}">
                            <a href="{{url('admin/udc')}}">{{__('_ecom__text.all-udc')}}</a>
                        </li>
                        {{--<li class="{{@$udc_payment}}">--}}
                        {{--<a href="{{url('admin/udc/payments')}}">--}}
                        {{--{{__('_ecom__text.udc-payments')}}</a>--}}
                        {{--</li>--}}
                        {{--<li class="{{@$udc_report}}">--}}
                        {{--<a href="{{url('admin/udc/reports')}}">--}}
                        {{--{{__('_ecom__text.udc-report')}}</a>--}}
                        {{--</li>--}}

                        {{--<li class="{{@$udc_transaction}}">--}}
                        {{--<a href="{{url('admin/udc/transactions')}}">--}}
                        {{--{{__('_ecom__text.udc-transaction')}}</a>--}}
                        {{--</li>--}}
                    </ul>
                </li>

                <li class="{{@$lp_management}} nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-truck"></i>
                        <span class="title">{{__('_ecom__text.lp-management')}}</span>
                        <span class="arrow "></span>
                    </a>

                    <ul class="sub-menu">
                        <li class="{{@$all_lp}} nav-item">
                            <a href="{{url('admin/lp-list')}}">
                                {{__('_ecom__text.all-lp')}}</a>
                        </li>
                        {{--<li class="{{@$lp_payment}} nav-item">--}}
                        {{--<a href="{{url('admin/lp/payments')}}">--}}
                        {{--{{__('_ecom__text.lp-payments')}}</a>--}}
                        {{--</li>--}}
                        {{--<li class="{{@$lp_report}} ">--}}
                        {{--<a href="{{url('admin/lp/report')}}">--}}
                        {{--{{__('_ecom__text.lp-report')}}</a>--}}
                        {{--</li>--}}
                    </ul>
                </li>
                <li class="{{@$ep_management}} nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-building-o"></i>
                        <span class="title">{{__('_ecom__text.ep-management')}}</span>
                        <span class="arrow "></span>
                    </a>

                    <ul class="sub-menu">
                        <li class="{{@$all_ep}} nav-item">
                            <a href="{{url('admin/all-ep')}}">
                                {{__('_ecom__text.all-ep')}}</a>
                        </li>
                        {{--<li class="{{@$ep_payment}} nav-item">--}}
                        {{--<a href="{{url('admin/ep/payments')}}">--}}
                        {{--{{__('_ecom__text.ep-payments')}}</a>--}}
                        {{--</li>--}}
                        {{--<li class="{{@$ep_report}}">--}}
                        {{--<a href="{{url('admin/ep/reports')}}">--}}
                        {{--{{__('_ecom__text.ep-report')}}</a>--}}
                        {{--</li>--}}
                    </ul>
                </li>
                <li class="{{@$order_management}} nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="title">{{__('_ecom__text.order-management')}}</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class={{@$ep_order}} nav-item">
                            <a href="{{url('admin/orders/ep-orders')}}">
                                {{__('_ecom__text.orders')}}</a>
                        </li>

                        <li class="nav-item {{@$track_order}}">
                            <a href="{{url('admin/ekom/oder-tracking/1')}}">
                                <span class="title">{{__('_ecom__text.track-order')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{--<li class="{{@$transaction}} nav-item">--}}
                {{--<a href="{{url('admin/transaction')}}">--}}
                {{--<i class="fa fa-money"></i>--}}
                {{--<span class="title">{{__('_ecom__text.transaction')}}</span>--}}
                {{--</a>--}}
                {{--</li>--}}

                {{--<li class="{{@$payments}} nav-item">--}}
                {{--<a href="javascript:void(0)" class="nav-link nav-toggle">--}}
                {{--<i class="fa fa-money"></i>--}}
                {{--<span class="title">{{__('_ecom__text.payments')}}</span>--}}
                {{--<span class="arrow"></span>--}}
                {{--</a>--}}

                {{--<ul class="sub-menu">--}}

                {{--<li class={{@$ep_orders}} nav-item">--}}
                {{--<a href="{{url('admin/payments/all-ep')}}"> {{__('_ecom__text.all-ep')}}</a>--}}
                {{--</li>--}}

                {{--</ul>--}}
                {{--</li>--}}

                {{--<li class="{{@$purchase_management}} nav-item">--}}
                {{--<a href="{{url('admin/purchase-management')}}">--}}
                {{--<i class="fa fa-shopping-cart"></i>--}}
                {{--<span class="title">{{__('_ecom__text.purchase-management')}}</span>--}}
                {{--</a>--}}
                {{--</li>--}}

                {{--<li class="{{@$activity_management}} nav-item">--}}
                {{--<a href="{{url('admin/activity-management')}}">--}}
                {{--<i class="fa fa-random"></i>--}}
                {{--<span class="title">{{__('_ecom__text.activity-management')}}</span>--}}
                {{--</a>--}}
                {{--</li>--}}

                <li class="{{@$reports_management}} nav-item">
                    <a href="javascript:void(0)" class="nav-link nav-toggle">
                        <i class="fa fa-money"></i>
                        <span class="title">{{__('_ecom__text.reports-management')}}</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu">
                        <li class={{@$orders}} nav-item">
                            <a href="{{url('admin/reports/orders')}}">{{__('_ecom__text.order-overview')}}</a>
                        </li>
                        <li class={{@$sales}} nav-item">
                            <a href="{{url('admin/reports/sales')}}">{{__('_ecom__text.sales-overview')}}</a>
                        </li>
                        <li class={{@$commissions}} nav-item">
                            <a href="{{url('admin/reports/commissions')}}">{{__('_ecom__text.commission-overview')}}</a>
                        </li>
                        <li class={{@$kpi}} nav-item">
                            <a href="{{url('admin/reports/kpi')}}">{{__('_ecom__text.kpi-overview')}}</a>
                        </li>

                        <li class={{@$udc_overview}} nav-item">
                            <a href="{{url('admin/reports/udc')}}">{{__('_ecom__text.udc-overview')}}</a>
                        </li>
                        <li class={{@$logistic_overview}} nav-item">
                            <a href="{{url('admin/reports/logistic')}}">{{__('_ecom__text.logistic-overview')}}</a>
                        </li>
                        <li class={{@$udc_commission}} nav-item">
                            <a href="{{url('admin/reports/udc-commission')}}">{{ __('_ecom__text.udc-commission') }}</a>
                        </li>
						
                    <li class={{@$disbursed_udc_commission}} nav-item">
                        <a href="{{url('admin/disburesed-commission-list')}}">
                            প্রদানকৃত কমিশন
                            {{--{{ __('_ecom__text.udc-commission') }}--}}
                        </a>
                    </li>
                    <li class={{@$commission_overview}} nav-item">
                        <a href="{{url('admin/reports/commission-overview')}}">
								কমিশন ওভারভিউ
                        </a>
                    </li>
                    </ul>
                </li>

                {{--<li class="{{@$offers}} nav-item">
                    <a href="{{url('admin/offers')}}" class="nav-link nav-toggle">
                        <i class="fa fa-gift"></i>
                        <span class="title">Offers</span>
                    </a>
                </li>--}}

                <li class="{{@$notice}} nav-item">
                    <a href="{{url('admin/notices')}}" class="nav-link">
                        <i class="fa fa-gift"></i>
                        <span class="title">{{__('_ecom__text.notice')}}</span>
                    </a>
                </li>

                <li class="{{@$settings}} nav-item">

                    <a href="javascript:void(0)" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{__('_ecom__text.settings')}}</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu">
                        <li class="{{@$settings}} nav-item">
                            <a href="{{url('admin/settings')}}">
                                <span class="title">{{__('_ecom__text.settings')}}</span>
                            </a>
                        </li>

                        <li class="{{@$kpi_settings}} nav-item">
                            <a href="{{url('admin/setting/kpi')}}">
                                <span class="title">{{__('_ecom__text.kpi-setting')}}</span>
                            </a>
                        </li>

                    </ul>

                </li>
                
                <!--<li class="{{@$getrepeatedorders}} nav-item">-->
                <!--    <a href="{{url('admin/getrepeatedorders')}}" class="nav-link">-->
                <!--        <i class="fa fa-gift"></i>-->
                <!--        <span class="title">Repeated 500 Products</span>-->
                <!--    </a>-->
                <!--</li>-->

                <!--<li class="{{@$toptensearchedproducts}} nav-item">-->
                <!--    <a href="{{url('admin/toptensearchedproducts')}}" class="nav-link">-->
                <!--        <i class="fa fa-gift"></i>-->
                <!--        <span class="title">Top Ten Searched Products</span>-->
                <!--    </a>-->
                <!--</li>-->
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>