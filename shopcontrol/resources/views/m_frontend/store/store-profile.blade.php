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

    <div class="m__title-bar">
        <a href="{{url('m/category-list')}}" class="m__back-btn"><i class="pe-7s-angle-left"></i></a>
        <span class="m__title">Shirt</span>
    </div>

    <div class="store-widget">
        <div class="store-header">
            <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-01.jpg')}}')">
            </div>

            <div class="store-desc">
                <h4 class="store-name"><a href="#">VSD International</a></h4>
                <p><span class="mute-text">Dhaka (Uttara)</span></p>
                <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                {{--<p>Open: <span>3 year(s)</span></p>--}}
                <p>Total Sells: 1512</p>
            </div>
        </div>
        <div class="store-footer clearfix">
            <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
            <a href="#" class="">Follow</a>
        </div>
    </div>

    <section class="m__section">
        <div class="m__section-header">
            <h4 class="m__section-title">Premium Related Products</h4>
        </div>
        <div class="m__products-block">
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_14.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_15.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_16.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_19.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
        </div>
    </section>

    <div class="m__product-list">
        <div class="m__section-header">
            <a href="javascript://" class="m__sorting m__more-btn btn btn-sm btn-default"><i class="pe-7s-shuffle"></i></a>

            <h4 class="m__section-title">All Products</h4>
        </div>

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
@endsection