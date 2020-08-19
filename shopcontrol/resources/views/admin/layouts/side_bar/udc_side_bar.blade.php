<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->

<?php
$test_center_ids = array(111111, 222222, 666666, 777777, 888888);
?>

<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

            <li class="nav-item {{@$dashboard}}">
                <a href="{{url('udc')}}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('admin_text.dashboard') }}</span>
                </a>
            </li>
            
            <li class="nav-item {{@$purchases}}">
                <a href="{{url('udc/purchases')}}">
                    <i class="fa fa-list"></i>
                    <span class="title">{{ __('admin_text.purchases') }}</span>
                </a>
            </li>

            <li class="nav-item {{@$track_order}}">
                <a href="{{url('udc/order-tracking/1')}}">
                    <i class="fa fa-list"></i>
                    <span class="title">{{__('_ecom__text.track-order')}}</span>
                </a>
            </li>

            @if(!in_array(Auth::user()->center_id, $test_center_ids))
                <li class="nav-item {{@$seller}}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-user"></i>
                        <span class="title">{{ __('admin_text.seller') }}</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="{{@$add_seller}}">
                            <a href="{{route('udc.addSeller')}}">{{ __('admin_text.add-seller') }}</a>
                        </li>
                        <li class="{{@$seller_list}}">
                            <a href="{{route('udc.sellerList')}}">{{ __('admin_text.seller-list') }}</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{@$customer}}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-user"></i>
                        <span class="title">{{ __('admin_text.customer') }}</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="{{@$add_customer}}">
                            <a href="{{route('udc.addCustomer')}}">{{ __('admin_text.add-customer') }}</a>
                        </li>
                        <li class="{{@$customer_list}}">
                            <a href="{{route('udc.customerList')}}">{{ __('admin_text.customer-list') }}</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{@$products}}">
                    <a href="#" class="nav-link nav-toggle">
                        <i class="fa fa-list"></i>
                        <span class="title">{{ __('admin_text.products') }}</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="{{@$add_product}}">
                            <a href="{{url('udc/add-product')}}">
                                {{ __('admin_text.add_product') }}</a>
                        </li>
                        <li class="{{@$product_list_menu}}">
                            <a href="{{url('udc/product-list')}}">
                                {{ __('admin_text.product-list') }}</a>
                        </li>
                    </ul>
                </li>

                {{--<li class="nav-item {{@$sales}}">--}}
                    {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                        {{--<i class="icon-basket"></i>--}}
                        {{--<span class="title">{{ __('admin_text.sale') }}</span>--}}
                        {{--<span class="arrow "></span>--}}
                    {{--</a>--}}
                    {{--<ul class="sub-menu">--}}
                        {{--<li class="{{@$all_sale}}">--}}
                            {{--<a href="{{url('udc/sales')}}">{{ __('admin_text.sale') }}</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}


                {{--<li class="nav-item {{@$wallet}}">--}}
                    {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                        {{--<i class="icon-wallet"></i>--}}
                        {{--<span class="title">{{ __('admin_text.wallet') }}</span>--}}
                        {{--<span class="arrow "></span>--}}
                    {{--</a>--}}
                    {{--<ul class="sub-menu">--}}
                        {{--<li class="{{@$transactions}}">--}}
                            {{--<a href="{{url('udc/transactions')}}">{{ __('admin_text.transaction-history') }}</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}


                {{--<li class="nav-item {{@$report}}">--}}
                    {{--<a href="{{url('udc/report')}}">--}}
                        {{--<i class="fa fa-area-chart"></i>--}}
                        {{--<span class="title">{{ __('admin_text.report') }}</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="heading">--}}
                    {{--<h3 class="uppercase">{{ __('admin_text.sales-channel') }}</h3>--}}
                {{--</li>--}}

                <li class="nav-item {{@$mobile_bank_info}}">
                    <a href="{{url('mobile-bank-information')}}">
                        <i class="fa fa-money"></i>
                        <span class="title">Mobile Bank Information</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('')}}" target="_blank">
                        <i class="fa fa-external-link"></i>
                        <span class="title">{{ __('admin_text._ecom_-home') }}</span>
                    </a>
                </li>
                <li class="nav-item {{@$commission_overview}}">
                    <a href="{{url('udc/udc-commission-overview')}}" target="_blank">
                        <i class="fa fa-money"></i>
                        <span class="title">{{ __('_ecom__text.commission-overview') }}</span>
                    </a>
                </li>
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>