<?php
$all_menus = array(
    "ep-dashboard" => "active",
    "plx-report" => "active",
//    "udc-management" => "start active",
//    "pro-product-management" => "start active",
);

$sub_menus = array(
    "udc-list" => "active",
    "udcs-payment" => "active",
    "add-add-category" => "active",
    "sub-add-sub-category" => "active",
    "cat-category-list" => "active",
);
?>
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->

<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

            <li class="{{@$dashboard}} nav-item">
                <a href="{{url('ep')}}" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">{{__('_ecom__text.dashboard')}}</span>
                </a>
            </li>

            <li class="{{@$orders}} nav-item">
                <a href="{{url('ep/orders')}}" class="nav-link">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="title">{{__('admin_text.orders')}}</span>
                </a>
            </li>


            <li class="nav-item {{@$track_order}}">
                <a href="{{url('ep/oder-tracking/1')}}">
                    <i class="fa fa-list"></i>
                    <span class="title">{{__('_ecom__text.track-order')}}</span>
                </a>
            </li>

            <li class={{@$udc_commission}} nav-item">
                <a href="{{url('ep/udc-commission')}}">
                    <i class="fa fa-money"></i>
                    {{ __('_ecom__text.udc-commission') }}
                </a>
            </li>
			
			<li class={{@$commission_disburse_list}} nav-item">
                <a href="{{url('ep/disburesed-commission-list')}}">
                    <i class="fa fa-money"></i>
                    প্রদানকৃত কমিশন
                    {{--{{ __('_ecom__text.udc-commission') }}--}}
                </a>
            </li>

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>