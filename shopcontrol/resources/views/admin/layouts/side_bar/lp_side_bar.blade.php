<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->

<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="{{@$dashboard}} nav-item">
                <a href="{{url('lp')}}" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">{{__('_ecom__text.dashboard')}}</span>
                </a>
            </li>

            <li class="{{@$orders}} nav-item">
                <a href="{{url('lp/orders')}}" class="nav-link">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="title">{{__('admin_text.orders')}}</span>
                </a>
            </li>

            <li class="nav-item {{@$track_order}}">
                <a href="{{url('lp/oder-tracking/1')}}">
                    <i class="fa fa-list"></i>
                    <span class="title">{{__('_ecom__text.track-order')}}</span>
                </a>
            </li>

            @if(Auth::guard('lp_admin')->user()->for_all_users != 1)
                <li class="nav-item {{@$lp_packages}}">
                    <a href="{{url("lp/packages")}}">
                        <i class="fa fa-list"></i>
                        <span class="title">{{__('_ecom__text.distribute-package')}}</span>
                    </a>
                </li>
            @endif

            {{--<li class="nav-item {{@$all_menus['plx-'.$menu]}}">--}}
            {{--<a href="{{url('lp/report')}}">--}}
            {{--<i class="fa fa-area-chart"></i>--}}
            {{--<span class="title">Report</span>--}}
            {{--</a>--}}
            {{--</li>--}}
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>