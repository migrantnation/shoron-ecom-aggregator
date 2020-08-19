
<?php
$currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<style>
    .lang_active {
        color: #9C27B0 !important;
        font-weight: 700;
    }
</style>

@if(@$user_info->upazila)
    <?php $address[] = @$user_info->upazila?>
@endif

@if(@$user_info->union)
    <?php $address[] = @$user_info->union?>
@endif

@if(@$user_info->district)
    <?php $address[] = @$user_info->district?>
@endif

@if(@$user_info->division)
    <?php $address[] = @$user_info->division?>
@endif


<?php if ($currentUrl == url('/') . '/') { ?>

<header class="home-header header">
    <div class="container-fluid">

        <div class="h-right-part hidden-xs">

            <div class="user-min-account-panel">
                <a href="javascript://"
                   class="user-name">{{@$user_info->name_bn?@$user_info->name_bn:@$user_info->name_en}}<i
                            class="plx__icon icon-arrow-down"></i></a>

                <div class="user-info-dropdown">
                    <div class="dropdown-inner">
                        <div class="info-header">
                            <div class="user-avatar" style="background-image: url('{{@$user_info->image}}')"></div>
                            <div class="user-data">
                                <h4 class="name">{{@$user_info->center_name}}</h4>
                                <span><i>{{__('text.address')}}
                                        :</i> {{(isset($address))?implode(', ', $address):''}}</span>
                                <span><i>{{__('text.mobile-no')}}
                                        :</i> {{@$user_info->contact_number?$user_info->contact_number:@$user_info->phone}}</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="text-right action-btn">
                            <a href="{{url('logout')}}" class="btn btn-sm btn-default"><i class="icon-logout"></i>
                                {{__('text.logout')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="h-left-part">
            <a href="{{url('udc')}}" class="home-logo">
                {{--DCCP Panel--}}
                {{ __('text.control-panel') }}
            </a>
            <ul class="header-nav desktop-only">
                <li><a href="{{'udc/purchases'}}">{{ __('text.recent_purchase') }}</a></li>
                <li><a href="{{'udc/purchases'}}">{{ __('text.recent_orders') }}</a></li>
            </ul>

            <div id="mAccount" class="mobile-only for-home">
                <a href="javascript://" class="m-account"><i class="icon-user"></i></a>
                <div class="m-account-actions">
                    <a href="{{url('udc')}}"><i class="icon-user"></i>&nbsp; {{ __('text.my-account') }}</a>
                    <a href="{{url('logout')}}"><i class="icon-logout"></i>&nbsp; {{ __('text.sign-out') }}</a>
                </div>
            </div>

            <ul class="header-nav lang-list">
                <li><a class="btn btn-sm {{App::isLocale('bn') ? 'lang_active' : ''}}"
                       href="{{url('switch-language/bn')}}">বাংলা</a></li>
                <li><a class="btn btn-sm {{App::isLocale('en') ? 'lang_active' : ''}}"
                       href="{{url('switch-language/en')}}">English</a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</header>

<?php
} else {
?>

<div class="navigation">
    <div class="container">
        <div class="clearfix">
            <div class="h-left">
                <div class="toggle-categories">
                    {{--<button type="button" class="cat-toggle-btn"><i class="plx__toggle-icon icon-menu"></i> <i--}}
                    {{--class="plx__arrow icon-arrow-down"></i></button>--}}
                    {{--<div class="categories">--}}
                    {{--<div class="categories-content-title" data-role="exclude">--}}
                    {{--<span>{{__('text.category')}} >></span>--}}
                    {{--<a href="#">{{__('text.see-all')}} &gt;</a>--}}
                    {{--</div>--}}

                    {{--<ul class="category-list">--}}
                    {{--<li><a href="{{url("search?string=women")}}"--}}
                    {{--class="women">{{__('text.womens-clothing')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=men")}}" class="men">{{__('text.mens-clothing')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=phone")}}"--}}
                    {{--class="phone">{{__('text.phone-&-accessories')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=computer")}}"--}}
                    {{--class="computer">{{__('text.computer-&-office')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=electronics")}}"--}}
                    {{--class="consumer-electronics">{{__('text.consumer-electronic')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=jewelry")}}"--}}
                    {{--class="jewelry">{{__('text.jewelry-&-watch')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=home")}}" class="home">{{__('text.home-&-garden')}}</a>--}}
                    {{--</li>--}}
                    {{--<li><a href="{{url("search?string=bag")}}" class="bags">{{__('text.bags-&-shoes')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=kid")}}"--}}
                    {{--class="kids">{{__('text.toys-kids-and-Baby')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=sport")}}"--}}
                    {{--class="sports">{{__('text.sports-&-outdoors')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=health")}}"--}}
                    {{--class="health">{{__('text.health-&-beauty-hair')}}</a></li>--}}
                    {{--<li><a href="{{url("search?string=automobile")}}"--}}
                    {{--class="automobile">{{__('text.automobile-&-motorcycles')}}</a></li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}
                </div>

                <a href="{{url('/')}}" class="site-logo">
                    <img src="{{asset('public/assets/img/_ecom__logo.png')}}" alt="Ekom" class="">
                </a>
            </div>

            <div class="h-right">
                {{--<a href="#" class="nav-wishlist-box">--}}
                {{--<span class="mic-text">{{__('text.wish')}}</span>--}}
                {{--<span class="mic-text">{{__('text.list')}}</span>--}}
                {{--</a>--}}
                <div class="language-translator">
                    <a class="btn btn-sm mic-text {{App::isLocale('bn') ? 'lang_active' : ''}}"
                       href="{{url('switch-language/bn')}}">বাংলা</a>
                    <a class="btn btn-sm mic-text {{App::isLocale('en') ? 'lang_active' : ''}}"
                       href="{{url('switch-language/en')}}">English</a>
                </div>

                <div class="nav-cart-box">
                    <a href="{{url('cart')}}">{{ __('text.cart') }}</a>
                    @if(session()->get('total_product'))
                        <span class="cart-number">{{ session()->get('total_product') ? session()->get('total_product'):'0' }}</span>
                    @endif
                </div>

                <div class="nav-account-box" style="background-image: url({{ @Auth::user()->image}})">
                    <div id="mAccount" class="mobile-only">
                        <a href="javascript://" class="m-account"><i class="icon-user"></i></a>
                        <div class="m-account-actions">
                            <a href="{{url('udc')}}"><i class="icon-user"></i>&nbsp; {{ __('text.my-account') }}</a>
                            <a href="{{url('logout')}}"><i class="icon-logout"></i>&nbsp; {{ __('text.sign-out') }}</a>
                        </div>
                    </div>

                    <div class="desktop-only">
                        <a href="{{url('udc')}}" class="mic-text">{{ __('text.my-account') }}</a>
                        <span class="user-actions" href="javascript://">
                            <a href="{{url('logout')}}"><i class="icon-logout"></i>&nbsp; {{ __('text.sign-out') }}</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="h-middle">
                <form action="{{url('search/')}}" class="header-search-form" method="get">
                    <div class="input-group search-container">

                        {{--<input type="text" class="form-control" placeholder="খুজুন..." name="string"
                               value="{{@$search_string ? @$search_string : ''}}">--}}

                        <input name="string" id="myInput" onkeyup="myFunction()"
                               value="{{@$search_string ? @$search_string : ''}}" type="text"
                               class="form-control main-search-form"
                               placeholder="খুজুন..." autocomplete="off">

                        <div class="search-result-mini">
                            <ul id="myUL" class="search-list scrollable"></ul>

                            <ul class="search-list alt scrollable">
                                @php
                                    $isExist = array();
                                    $search_sugstns = \App\models\UserSpecificSearchHistory::where('user_id', Auth::id())->orderBy('total_hit', 'desc')->take(5)->get();
                                    $sugstns = \App\models\SearchHistory::orderBy('total_hit', 'desc')->take(5)->get();
                                @endphp

                                @forelse($search_sugstns as $sugstn)
                                    <?php
                                    $isExist[] = $sugstn->search_text;
                                    ?>
                                    <li class="" id="li-{{$sugstn->id}}">
                                        <a class="search-keyword"
                                           href="{{url('search?string='. $sugstn->search_text)}}">{{$sugstn->search_text}}</a>
                                        <a href="javascript:void(0)" class="removeBtn"
                                           data-rowid="{{$sugstn->id}}">Remove</a>
                                    </li>

                                @empty
                                    <li>
                                        <a href="javascript:void(0)">No Recent Search available</a>
                                    </li>
                                @endforelse
                                @php
                                    $sugstns = \App\models\SearchHistory::whereNotIn('search_text', $isExist)->orderBy('total_hit', 'desc')->take(5)->get();
                                @endphp

                                @forelse($sugstns as $sugstn)
                                    <li class="">
                                        <a class="search-keyword"
                                           href="{{url('search?string='. $sugstn->search_text)}}">{{$sugstn->search_text}}</a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>

                        <span class="input-group-btn">
                                <button class="btn btn-default btn-primary" type="submit"><i class="icon-magnifier"></i></button>
                            </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php } ?>

<script>
    (function ($) {
        'use strict';
        $(document).on('click', '.m-account', function (e) {
            e.preventDefault();
            $('.m-account-actions').toggle();
        })
        $(document).mouseup(function (e) {
            var container = $("#mAccount");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $('.m-account-actions').hide();
            }
        });
    }(jQuery))
</script>

