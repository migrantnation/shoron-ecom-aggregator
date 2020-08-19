@extends('m_frontend.layouts.master')
@section('content')
    <div class="m__sort-bar">
        <div class="m__sort-header clearfix">
            Sort By
        </div>

        <ul class="m__sort-list">
            <li><input type="radio" class="pull-right" id="popularity" name="sorting"><label for="popularity">Popularity</label></li>
            <li><input type="radio" class="pull-right" id="newest" name="sorting"><label for="newest">Newest</label></li>
            <li><input type="radio" class="pull-right" id="lth" name="sorting"><label for="lth">Price - Low to High</label></li>
            <li><input type="radio" class="pull-right" id="htl" name="sorting"><label for="htl">Price - High to Low</label></li>
        </ul>
    </div>

    <div class="m__filter-navigation">
        <div class="m__filter-nav-header">
            <div class="clearfix">
                <a href="javscript://" class="m__back-btn plx__closeBtn"><i class="pe-7s-angle-left"></i></a>

                <button class="m__clear-btn" type="reset">Clear</button>
                <span>Filter</span>
            </div>
        </div>

        <div class="m__filter-list">
            <div class="m__range">
                <div class="m__range-header clearfix">
                    <div class="m__p-l">
                        <h4 class="m__range-value-title">Min</h4>
                        <span class="m__range-value m__min-val"></span>
                    </div>
                    <div class="m__p-r">
                        <h4 class="m__range-value-title">Max</h4>
                        <span class="m__range-value m__max-val"></span>
                    </div>
                </div>
                <div class="m__rang-bar">
                    <input type="hidden" id="price_ranger" class="range-slider" value="50, 2000"/>
                </div>
            </div>

            <div class="sidebar-widget">
                <ul class="attr-list" style="padding: 0;">
                    <li>
                        <label for=" NewArrivals" class="custom-checkbox">
                            <input type="checkbox" id=" NewArrivals">
                            <span></span>
                            New Arrivals
                        </label>
                    </li>
                    <li>
                        <label for="FreeShipping" class="custom-checkbox">
                            <input type="checkbox" id="FreeShipping">
                            <span></span>
                            Free Shipping
                        </label>
                    </li>
                    <li>
                        <label for="rating" class="custom-checkbox">
                            <div class="static-rating" data-value="4.5"></div>
                            &amp; Up

                            <input type="checkbox" id="rating">
                            <span></span>
                        </label>
                    </li>
                </ul>
            </div>

            {{--<div class="sidebar-widget">--}}
                {{--<h4 class="widget-title"><a href="#brands" class="toggleExpand">Brands</a></h4>--}}

                {{--<div id="brands" style="display: none">--}}

                {{--</div>--}}
            {{--</div>--}}

            <div class="sidebar-widget">
                <h4 class="widget-title"><a href="#material" class="toggleExpand">Material</a></h4>

                <div id="material" style="display: none">
                    <ul class="attr-list">
                        <li>
                            <label for="coton" class="custom-checkbox">
                                <input type="checkbox" id="coton">
                                <span></span>
                                Coton
                            </label>
                        </li>
                        <li>
                            <label for="Linen" class="custom-checkbox">
                                <input type="checkbox" id="Linen">
                                <span></span>
                                Linen
                            </label>
                        </li>
                        <li>
                            <label for="Silk" class="custom-checkbox">
                                <input type="checkbox" id="Silk">
                                <span></span>
                                Silk
                            </label>
                        </li>
                        <li>
                            <label for="Spandex" class="custom-checkbox">
                                <input type="checkbox" id="Spandex">
                                <span></span>
                                Spandex
                            </label>
                        </li>
                        <li>
                            <label for="Polyester" class="custom-checkbox">
                                <input type="checkbox" id="Polyester">
                                <span></span>
                                Polyester
                            </label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-widget">
                <h4 class="widget-title"><a href="#size" class="toggleExpand">Size</a></h4>

                <div id="size" style="display: none">
                    <ul class="attr-list">
                        <li>
                            <label for="4XL" class="custom-checkbox">
                                <input type="checkbox" id="4XL">
                                <span></span>
                                4XL
                            </label>
                        </li>
                        <li>
                            <label for="XXXL" class="custom-checkbox">
                                <input type="checkbox" id="XXXL">
                                <span></span>
                                XXXL
                            </label>
                        </li>
                        <li>
                            <label for="XXL" class="custom-checkbox">
                                <input type="checkbox" id="XXL">
                                <span></span>
                                XXL
                            </label>
                        </li>
                        <li>
                            <label for="XL" class="custom-checkbox">
                                <input type="checkbox" id="XL">
                                <span></span>
                                XL
                            </label>
                        </li>
                        <li>
                            <label for="L" class="custom-checkbox">
                                <input type="checkbox" id="L">
                                <span></span>
                                L
                            </label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-widget">
                <h4 class="widget-title"><a href="#length" class="toggleExpand">Sleeve Length(cm)</a></h4>

                <div id="length" style="display: none">
                    <ul class="attr-list">
                        <li>
                            <label for="Full" class="custom-checkbox">
                                <input type="checkbox" id="Full">
                                <span></span>
                                Full
                            </label>
                        </li>
                        <li>
                            <label for="Short" class="custom-checkbox">
                                <input type="checkbox" id="Short">
                                <span></span>
                                Short
                            </label>
                        </li>
                        <li>
                            <label for="ThreeQuarter" class="custom-checkbox">
                                <input type="checkbox" id="ThreeQuarter">
                                <span></span>
                                Three Quarter
                            </label>
                        </li>
                        <li>
                            <label for="Sleeveless" class="custom-checkbox">
                                <input type="checkbox" id="Sleeveless">
                                <span></span>
                                Sleeveless
                            </label>
                        </li>
                        <li>
                            <label for="Half" class="custom-checkbox">
                                <input type="checkbox" id="Half">
                                <span></span>
                                Half
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="m__filter-nav-footer">
            <div class="clearfix">
                <button class="btn btn-sm btn-primary pull-right">Apply</button>
                <span style="display: inline-block; padding-top: 5px;">25325 Results</span>
            </div>
        </div>
    </div>

    <div class="m__title-bar">
        <a href="{{url('m/category-list')}}" class="m__back-btn"><i class="pe-7s-angle-left"></i></a>
        <div class="clearfix">
            <span class="pull-left m__title">Shirt</span>
            <div class="pull-right m__filtering-btns">
                <a href="javascript://" class="m__view-type m__grid" data-view="grid"><i class="m__icon-grid icon-grid"></i> <i class="m__icon-list icon-list"></i></a>
                <a href="javascript://" class="m__sorting"><i class="pe-7s-shuffle"></i></a>
                <a href="javascript://" class="m__filter"><i class="pe-7s-filter"></i></a>
            </div>
        </div>
    </div>

    <div class="m__product-list">
        <div class="m__row">
            <div class="m__one-half">
                <a href="{{url('m/product/product-details')}}" class="m__listing-product">
                    <div class="ratio-1-1 m__product-thumb" style="background-image: url('{{url('')}}/assets/img/products/product_img_01.jpg');"></div>
                    <div class="m__product-desc">
                        <h4 class="m__product-title">Maecenas leo arcu, efficitur id dui tempor</h4>
                        <p class="m__product-price"><span class="m__a-price">TK. 180.00</span> <strike>TK. 200.00</strike></p>
                        <p class="m__product-rating"><span>4.2 <i class="m__icon pe-7s-star"></i></span> &nbsp;<small>(253)</small></p>
                        <p class="m__store-name"><i class="icon-layers"></i> Name of Store</p>
                    </div>
                </a>
            </div>

            <div class="m__one-half">
                <a href="{{url('m/product/product-details')}}" class="m__listing-product">
                    <div class="ratio-1-1 m__product-thumb" style="background-image: url('{{url('')}}/assets/img/products/product_img_02.jpg');"></div>
                    <div class="m__product-desc">
                        <h4 class="m__product-title">Maecenas leo arcu, efficitur id dui tempor</h4>
                        <p class="m__product-price"><span class="m__a-price">TK. 180.00</span> <strike>TK. 200.00</strike></p>
                        <p class="m__product-rating"><span>4.2 <i class="m__icon pe-7s-star"></i></span> &nbsp;<small>(253)</small></p>
                        <p class="m__store-name"><i class="icon-layers"></i> Name of Store</p>
                    </div>
                </a>
            </div>

            <div class="m__one-half">
                <a href="{{url('m/product/product-details')}}" class="m__listing-product">
                    <div class="ratio-1-1 m__product-thumb" style="background-image: url('{{url('')}}/assets/img/products/product_img_03.jpg');"></div>
                    <div class="m__product-desc">
                        <h4 class="m__product-title">Maecenas leo arcu, efficitur id dui tempor</h4>
                        <p class="m__product-price"><span class="m__a-price">TK. 180.00</span> <strike>TK. 200.00</strike></p>
                        <p class="m__product-rating"><span>4.2 <i class="m__icon pe-7s-star"></i></span> &nbsp;<small>(253)</small></p>
                        <p class="m__store-name"><i class="icon-layers"></i> Name of Store</p>
                    </div>
                </a>
            </div>

            <div class="m__one-half">
                <a href="{{url('m/product/product-details')}}" class="m__listing-product">
                    <div class="ratio-1-1 m__product-thumb" style="background-image: url('{{url('')}}/assets/img/products/product_img_04.jpg');"></div>
                    <div class="m__product-desc">
                        <h4 class="m__product-title">Maecenas leo arcu, efficitur id dui tempor</h4>
                        <p class="m__product-price"><span class="m__a-price">TK. 180.00</span> <strike>TK. 200.00</strike></p>
                        <p class="m__product-rating"><span>4.2 <i class="m__icon pe-7s-star"></i></span> &nbsp;<small>(253)</small></p>
                        <p class="m__store-name"><i class="icon-layers"></i> Name of Store</p>
                    </div>
                </a>
            </div>

            <div class="m__one-half">
                <a href="{{url('m/product/product-details')}}" class="m__listing-product">
                    <div class="ratio-1-1 m__product-thumb" style="background-image: url('{{url('')}}/assets/img/products/product_img_05.jpg');"></div>
                    <div class="m__product-desc">
                        <h4 class="m__product-title">Maecenas leo arcu, efficitur id dui tempor</h4>
                        <p class="m__product-price"><span class="m__a-price">TK. 180.00</span> <strike>TK. 200.00</strike></p>
                        <p class="m__product-rating"><span>4.2 <i class="m__icon pe-7s-star"></i></span> &nbsp;<small>(253)</small></p>
                        <p class="m__store-name"><i class="icon-layers"></i> Name of Store</p>
                    </div>
                </a>
            </div>

            <div class="m__one-half">
                <a href="{{url('m/product/product-details')}}" class="m__listing-product">
                    <div class="ratio-1-1 m__product-thumb" style="background-image: url('{{url('')}}/assets/img/products/product_img_06.jpg');"></div>
                    <div class="m__product-desc">
                        <h4 class="m__product-title">Maecenas leo arcu, efficitur id dui tempor</h4>
                        <p class="m__product-price"><span class="m__a-price">TK. 180.00</span> <strike>TK. 200.00</strike></p>
                        <p class="m__product-rating"><span>4.2 <i class="m__icon pe-7s-star"></i></span> &nbsp;<small>(253)</small></p>
                        <p class="m__store-name"><i class="icon-layers"></i> Name of Store</p>
                    </div>
                </a>
            </div>

            <div class="m__one-half">
                <a href="{{url('m/product/product-details')}}" class="m__listing-product">
                    <div class="ratio-1-1 m__product-thumb" style="background-image: url('{{url('')}}/assets/img/products/product_img_07.jpg');"></div>
                    <div class="m__product-desc">
                        <h4 class="m__product-title">Maecenas leo arcu, efficitur id dui tempor</h4>
                        <p class="m__product-price"><span class="m__a-price">TK. 180.00</span> <strike>TK. 200.00</strike></p>
                        <p class="m__product-rating"><span>4.2 <i class="m__icon pe-7s-star"></i></span> &nbsp;<small>(253)</small></p>
                        <p class="m__store-name"><i class="icon-layers"></i> Name of Store</p>
                    </div>
                </a>
            </div>

            <div class="m__one-half">
                <a href="{{url('m/product/product-details')}}" class="m__listing-product">
                    <div class="ratio-1-1 m__product-thumb" style="background-image: url('{{url('')}}/assets/img/products/product_img_08.jpg');"></div>
                    <div class="m__product-desc">
                        <h4 class="m__product-title">Maecenas leo arcu, efficitur id dui tempor</h4>
                        <p class="m__product-price"><span class="m__a-price">TK. 180.00</span> <strike>TK. 200.00</strike></p>
                        <p class="m__product-rating"><span>4.2 <i class="m__icon pe-7s-star"></i></span> &nbsp;<small>(253)</small></p>
                        <p class="m__store-name"><i class="icon-layers"></i> Name of Store</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script>
//        (function($) {
//            "use strict";
//            $(document).ready(function () {
//                getMinMaxValue(rangeSlider);
//                $(rangeSlider).on("change", function () {
//                    getMinMaxValue(this);
//                });
//            });
//
//            function getMinMaxValue(element) {
//                var rangeValue  = $(element).val(),
//                    newValues = rangeValue.split(',');
//                $('.m__min-val').text(newValues[0]);
//                $('.m__max-val').text(newValues[1]);
//            }
//        } (jQuery))
    </script>
@endsection