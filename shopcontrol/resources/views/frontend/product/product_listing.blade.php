
@extends('frontend.layouts.master')
@section('content')

    <div class="plx__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-8">
                    <ol class="breadcrumb">
                        <li>{{__('text.search-result-for')}}:
                            <strong>{{@$search_string ? @$search_string : ''}}</strong></li>
                    </ol>
                </div>

                {{--<div class="col-xs-3 col-xs-push-1">
                    <form action="{{url('search')}}" class="header-search-form" method="get" style="margin-top: 1px">
                        <div class="pull-right" style="margin-top: 2px;">
                            <div class="input-group input-group-sm">
                                @if(!empty($_GET['ep_ids']))
                                    @forelse(@$_GET['ep_ids'] as $key=>$value)
                                        <input type="hidden" name="ep_ids[]" value="{{$value}}">
                                    @empty
                                    @endforelse
                                @endif

                                <input type="text" class="form-control" placeholder="খুজুন..." name="string"
                                       value="{{@$search_string ? @$search_string : ''}}">
                                <span class="input-group-btn">
                                <button class="btn btn-default btn-primary" type="submit"><i class="icon-magnifier"></i></button>
                            </span>
                            </div>
                        </div>
                    </form>
                </div>--}}
            </div>
        </div>
    </div>

    <form id="product_list_form" action="{{url("search")}}" method="get">
        <input type="hidden" name="string" value="{{@$search_string}}">
        <div class="section">
            <div class="container">
                <div class="product-listing clearfix">
                    <div class="part-l">
                        <div class="sidebar-widget">
                            <h4 class="widget-title">
                                <a href="#cat_list" class="expand toggleExpand">{{__('text.all-category')}}</a>
                            </h4>

                            {{--<h4 class="plx__title">
                                <a href="#" class="">
                                    {{__('text.all-category')}}
                                </a>
                            </h4>--}}

                            <div class="widget-content" id="cat_list">
                                <ul class="category-list">
                                    <li><a href="{{url("search?string=women")}}"
                                           class="women">{{__('text.womens-clothing')}}</a></li>
                                    <li><a href="{{url("search?string=men")}}"
                                           class="men">{{__('text.mens-clothing')}}</a></li>
                                    <li><a href="{{url("search?string=phone")}}"
                                           class="phone">{{__('text.phone-&-accessories')}}</a></li>
                                    <li><a href="{{url("search?string=computer")}}"
                                           class="computer">{{__('text.computer-&-office')}}</a></li>
                                    <li><a href="{{url("search?string=electronics")}}"
                                           class="consumer-electronics">{{__('text.consumer-electronic')}}</a></li>
                                    <li><a href="{{url("search?string=jewelry")}}"
                                           class="jewelry">{{__('text.jewelry-&-watch')}}</a></li>
                                    <li><a href="{{url("search?string=home")}}"
                                           class="home">{{__('text.home-&-garden')}}</a></li>
                                    <li><a href="{{url("search?string=bag")}}"
                                           class="bags">{{__('text.bags-&-shoes')}}</a></li>
                                    <li><a href="{{url("search?string=kid")}}"
                                           class="kids">{{__('text.toys-kids-and-Baby')}}</a></li>
                                    <li><a href="{{url("search?string=sport")}}"
                                           class="sports">{{__('text.sports-&-outdoors')}}</a></li>
                                    <li><a href="{{url("search?string=health")}}"
                                           class="health">{{__('text.health-&-beauty-hair')}}</a></li>
                                    <li><a href="{{url("search?string=automobile")}}"
                                           class="automobile">{{__('text.automobile-&-motorcycles')}}</a></li>
                                </ul>
                            </div>
                        </div>


                        <div class="sidebar-widget">
                            <h4 class="widget-title">
                                <a href="#ep_list" class="expand toggleExpand">Partners</a>
                                <button type="submit" class="w-submit-btn f-btn btn-primary">Ok</button>
                            </h4>

                            <?php
                            $ep_id_list = array('');
                            if (@$_GET['ep_ids']) {
                                $ep_id_list = $_GET['ep_ids'];
                            }
                            ?>

                            <div class="widget-content" id="ep_list">
                                <ul class="attr-list">
                                    <li>
                                        <label for="ep_id_0" class="custom-checkbox">
                                            <input class="rsDefault refineItem" type="checkbox" id="ep_id_0" value="all"
                                                   @if(count($ep_id_list) == (count($ep_list)+1)){{'checked'}}@endif
                                                   name="ep_ids[]">
                                            <span></span>
                                            All
                                        </label>
                                    </li>


                                    @forelse($ep_list as $key=>$each_ep)
                                        <li>
                                            <label for="ep_id_{{$each_ep->id}}" class="custom-checkbox">
                                                <input class="refineItem" type="checkbox" name="ep_ids[]"
                                                       id="ep_id_{{$each_ep->id}}" value="{{$each_ep->id}}"
                                                @if(in_array($each_ep->id, $ep_id_list)){{'checked'}}@endif>
                                                <span></span>
                                                {!! $each_ep->ep_name !!}
                                            </label>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        @forelse($attribute_list as $key=>$each_attribute)

                            <div class="sidebar-widget">

                                <h4 class="widget-title">
                                    <a href="#{{$key}}" class="expand toggleExpand">{{$key}}</a>
                                    <button type="submit" class="w-submit-btn f-btn btn-primary">Ok</button>
                                </h4>

                                <div id="{{$key}}">
                                    <ul class="attr-list">
                                        <?php
                                        $attribute_array = array();
                                        ?>
                                        @forelse(@$product_attribute_values[$key] as $value)
                                            <li>
                                                @if(!@$attribute_array[$value->value])
                                                    <label for="attr_{{$value->id}}" class="custom-checkbox">
                                                        <input type="checkbox" name="attribute_value[{{$key}}][]"
                                                               id="attr_{{$value->id}}" value="{{$value->value}}"
                                                        @if(@$attribute_values[$key]){{in_array($value->value, @$attribute_values[$key])?'checked':''}}@endif
                                                        >
                                                        <span></span>
                                                        {!! $value->value !!}
                                                    </label>
                                                    <?php $attribute_array[$value->value] = true;?>
                                                @endif
                                            </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        @empty
                        @endforelse

                    </div>

                    <div class="part-r">
                        <style>
                            .brands-list {
                                padding: 0;
                            }

                            .brands-list li {
                                display: inline-block;
                                margin: 0 5px 9px 0;
                                vertical-align: middle;
                            }

                            .brands-list label {
                                display: block;
                                cursor: pointer;
                            }

                            .brands-list label input[type='radio'] {
                                display: none;
                            }

                            .brands-list label span {
                                height: 44px;
                                width: 80px;
                                line-height: 42px;
                                text-align: center;
                                display: block;
                                border: 1px solid rgba(69, 90, 100, 0.1523);
                                -webkit-border-radius: 3px;
                                -moz-border-radius: 3px;
                                border-radius: 3px;
                                overflow: hidden;
                            }

                            .brands-list label input[type='radio']:checked ~ span {
                                border: 1px solid #9C27B0;
                            }

                            .brands-list label img {
                                display: inline-block;
                                max-width: 100%;
                                max-height: 100%;
                            }

                        </style>

                        <div class="filter-area" style="display: none">
                            @if(count($brands)>0)
                                <ul class="brands-list">
                                    <li>Brands:</li>
                                    @forelse($brands as $b_key=>$each_brand)
                                        <?php $brand_info = head($each_brand)?>
                                        <li class="{{($brand_id == $brand_info['brand_id'])?'active':''}}">
                                            <label for="brand-{{$brand_info['brand_id']}}">
                                                <input type="radio" id="brand-{{$brand_info['brand_id']}}"
                                                       name="brand_id" onchange="$('#product_list_form').submit()"
                                                       value="{{$brand_info['brand_id']}}">
                                                <span title="{{$brand_info['brand_name']}}">
                                                    <img src="{{url("content-dir/brands/".$brand_info['brand_image'])}}"
                                                         alt="{{$brand_info['brand_name']}}">
                                                </span>
                                            </label>
                                        </li>
                                    @empty
                                    @endforelse
                                    <li><a href="#" id="more-brand"><i class="icon-plus"></i> More</a></li>
                                </ul>
                                <script>
                                    @if(@$brand_id)
                                    $("input[value='1']").attr('checked', true);
                                    $("input[value='{{@$brand_id}}']").attr('checked', true);
                                    @endif
                                </script>
                            @endif


                            <div class="filter-attr-list">
                                <div class="by-price">
                                    <span class="f-attr-title">{{__('text.price')}}:</span>
                                    <input type="number" class="f-attr-input" min="0" placeholder="min"
                                           name="min_price" id="min_price"
                                           value="{{$min_price}}">
                                    <span class="f-dash">-</span>
                                    <input type="number" class="f-attr-input" min="0" placeholder="max"
                                           name="max_price" id="max_price"
                                           value="{{$max_price}}">
                                    <button type="submit" class="f-btn btn-primary">Ok</button>
                                </div>

                                <ul class="historgram clearfix">
                                    <li><a href="#"><span style="height: 40%;"></span></a></li>
                                    <li><a href="#"><span style="height: 10%;"></span></a></li>
                                    <li><a href="#"><span style="height: 33.33%;"></span></a></li>
                                    <li><a href="#"><span style="height: 60%;"></span></a></li>
                                    <li><a href="#"><span style="height: 80%;"></span></a></li>
                                </ul>

                                <div class="filter-options">
                                    <label for=" NewArrivals" class="custom-checkbox">
                                        <input type="checkbox" id=" NewArrivals" name="new_arrival" value="1"
                                               {{@$_GET['new_arrival'] == 1 ? 'checked' : ''}} onclick="$('#product_list_form').submit()">
                                        <span></span>
                                        {{__('text.new-arrivals')}}
                                    </label>

                                    <label for="rating" class="custom-checkbox">
                                        <div class="static-rating" data-value="4.5"></div>
                                        &amp; Up
                                        <input type="checkbox" id="rating">
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="short-options">
                                <div class="row">
                                    <div class="col-md-7">
                                        <span>{{__('text.sort-by')}}: </span>
                                        <ul class="short-attr-group clearfix">
                                            <li><a href="#">{{__('text.best-match')}}</a></li>
                                            <li><a href="#" class="with-arrow">
                                                    <button class="btn btn-sm" type="button" name="order"
                                                            value="{{@$_GET['order'] == 1 ? 2 : 1}}"> {{__('text.order')}}
                                                    </button>
                                                </a>
                                            </li>
                                            <li><a href="#" class="with-arrow">{{__('text.newest')}}</a></li>
                                            <li><a href="#" class="with-arrow">{{__('text.seller-rating')}}</a></li>
                                            <li><a href="#"
                                                   class="with-arrow active down dubble">{{__('text.price')}}</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="clearfix">
                                            <div class="view-type-btns">
                                                <span>{{__('text.view')}}:</span>
                                                <a href="#" class="view-type-btn" data-role="list-view"><i
                                                            class="icon-list"></i></a>
                                                <a href="#" class="view-type-btn active" data-role="grid-view"><i
                                                            class="icon-grid"></i></a>
                                            </div>
                                            <a href="#" class="similar-btn">Group Similar Products</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            (function ($) {
                                "use strict";
                                $(document).ready(function () {
                                    var check_view_mode = '{{@session()->get('list-view')}}';
                                    if (check_view_mode == 1) {
                                        $('.product-list').addClass("list-view");
                                    }
                                    var viewTypeBtn = $(".view-type-btn");
                                    $(viewTypeBtn).on("click", function (e) {
                                        e.preventDefault();
                                        var role = $(this).data("role");
                                        $(viewTypeBtn).removeClass("active");
                                        $(this).addClass("active");
                                        if (role == "list-view") {
                                            set_session_mode(1);
                                            $('.product-list').addClass("list-view");
                                        } else {
                                            set_session_mode(2);
                                            $('.product-list').removeClass("list-view");
                                        }
                                    })
                                })
                            }(jQuery))

                            function set_session_mode(session_value) {
                                var url = '{{url('set_listing_view_mode'). '/'}}' + session_value;
                                $.ajax({
                                    type: 'get',
                                    url: url,
                                    data: {},
                                    success: function (data) {
                                    }
                                });
                            }
                        </script>

                        <div class="product-list">
                            @include('frontend.product.product_list_render')

                            <div class="clearfix"></div>
                            <div id="scrollLoader" class="col-sm-12" style="margin-top: 40px; display: block; text-align: center">
                                <div class="entry clearfix">
                                    <div class="loader-box">
                                        <div class="box-inner">
                                            <div class="loader-circle"></div>
                                            <div class="loader-line-mask">
                                                <div class="loader-line"></div>
                                            </div>
                                            <img class="loader-logo" src="{{asset("public/assets/img/loading_logo.png")}}" alt="_ecom_">
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="entry" style="height: 148px;">
                                    <div class="">
                                        <div id="loader">
                                            <div class="dot"></div>
                                            <div class="dot"></div>
                                            <div class="dot"></div>
                                            <div class="dot"></div>
                                            <div class="dot"></div>
                                            <div class="dot"></div>
                                            <div class="dot"></div>
                                            <div class="dot"></div>
                                            <div class="lading"></div>
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <script>

        var total_row;
        var offset = 0;
        var searching = false;

        function isScrolledIntoView(elem) {
            var docViewTop = $(window).scrollTop();
            var docViewBottom = docViewTop + $(window).height();

            var elemTop = $(elem).offset().top;
            var elemBottom = elemTop + $(elem).height();

            return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
        }

        function search_product(limit) {
            searching = true;
            total_row = $('.product-list > .productWrap').length + 1;

            console.log('productWrap count: ' + $('.product-list > .productWrap').length);
            console.log('next product: ' + total_row);

            $.ajax({
                type: 'get',
                url: baseUrl + "/search?string={{$search_string}}&limit=" + limit + "&offset=" + offset + "&total_row=" + total_row + "&ep_id_list={{@$ep_ids}}&min_price={{$min_price}}&max_price={{$max_price}}",
                data: {
                    "_token": csrfToken,
                    "ep_id_list": "{{@$ep_ids}}",
                },
                success: function (data) {
                    $("#scrollLoader").remove();
                    searching = false;
                    $(".product-list").append(data);
                    offset;
                }
            });
        }

        function firstSearch() {
            $.ajax({
                type: 'get',
                url: baseUrl + "/search?string={{$search_string}}",
                data: {
                    "_token": csrfToken,
                    "ep_id_list": "{{@$ep_ids}}",
                },
                success: function (data) {
                    $("#scrollLoader").remove();
                    searching = false;
                    $(".product-list").append(data);
                }
            });
        }


        $(window).scroll(function () {

            if ($('.nextSearch').length) {

                if (searching == false) {
                    if (isScrolledIntoView($('.entry'))) {
                        searching = true;
                        search_product(10);
                    }
                }
            }
        });

        $(document).ready(function () {
            $('input.refineItem').on('change', function () {
                console.log($(this).length);
                if ($(this).val() === 'all') {
                    if ($(this).is(':checked')) {
                        $('input.refineItem').not(this).prop('checked', true);
                    } else {
                        $('input.refineItem').not(this).prop('checked', false);
                    }
                } else {
                    $('input.rsDefault').not(this).prop('checked', false);
                    if (parseInt($('.refineItem:checked').length) + parseInt(1) === $('.refineItem').length) {
                        $('input.refineItem').not(this).prop('checked', true);
                    }
                }
            });
        })

        //        firstSearch();
        search_product(3);
    </script>

    <script src="{{url("public/js/front/product_listing.js")}}"></script>
@endsection