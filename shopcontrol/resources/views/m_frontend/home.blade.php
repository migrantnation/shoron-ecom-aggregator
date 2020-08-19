@extends('m_frontend.layouts.master')
@section('content')
    <div class="m__category-bar">
        <a href="{{url('m/product/product-list')}}" class="m__cat-item">
            <span class="plx__icon pe-7s-plane"></span>
            <span>Offers</span>
        </a>
        <a href="{{url('m/product/product-list')}}" class="m__cat-item">
            <span class="plx__icon pe-7s-airplay"></span>
            <span>Electronics</span>
        </a>
        <a href="{{url('m/product/product-list')}}" class="m__cat-item">
            <span class="plx__icon pe-7s-wristwatch"></span>
            <span>Shirt</span>
        </a>
        <a href="{{url('m/product/product-list')}}" class="m__cat-item">
            <span class="plx__icon pe-7s-wine"></span>
            <span>Fruit</span>
        </a>
        <a href="{{url('m/category-list')}}" class="m__cat-item">
            <span class="plx__icon pe-7s-way"></span>
            <span>More</span>
        </a>
    </div>

    <div class="m__add-banner owl-carousel">
        <a href="#" class="m__banner"><img src="{{url('public/assets')}}/img/slide_img01.jpg" alt=""></a>
        <a href="#" class="m__banner"><img src="{{url('public/assets')}}/img/slide_img02.jpg" alt=""></a>
        <a href="#" class="m__banner"><img src="{{url('public/assets')}}/img/slide_img03.jpg" alt=""></a>
    </div>

    <section class="m__section">
        <div class="m__section-header">
            <a href="{{url('m/product/product-list')}}" class="m__more-btn btn btn-sm btn-primary">View More</a>
            <h4 class="m__section-title">Featured Products</h4>
        </div>
        <div class="m__products-block">
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_01.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_02.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_03.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_04.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
        </div>
    </section>

    <section class="m__sec-add-banner">
        <img src="{{url('')}}/assets/img/sale_banner.jpg" alt="">
    </section>

    <section class="m__section">
        <div class="m__section-header">
            <a href="{{url('m/product/product-list')}}" class="m__more-btn btn btn-sm btn-primary">View More</a>
            <h4 class="m__section-title">Women</h4>
        </div>
        <div class="m__products-block">
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_01.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_02.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_03.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_04.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
        </div>
    </section>

    <section class="m__section">
        <div class="m__section-header">
            <a href="{{url('m/product/product-list')}}" class="m__more-btn btn btn-sm btn-primary">View More</a>
            <h4 class="m__section-title">T-Shirt</h4>
        </div>
        <div class="m__products-block">
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_06.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_07.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_08.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
            <a href="{{url('m/product/product-details')}}" class="m__product">
                <div class="m__product-thumb ratio-1-1" style="background-image: url('{{url('public/assets/')}}/img/products/product_img_09.jpg')"></div>
                <div class="m__product-desc">
                    <h4 class="m_product-title">Donec et est eget nibh volutpat</h4>
                    <p class="m__product-price"><strike>Tk. 1200.00</strike> <span>Tk. 999.00</span></p>
                </div>
            </a>
        </div>
    </section>

    <section class="m__section">
        <div class="m__section-header">
            <a href="{{url('m/product/product-list')}}" class="m__more-btn btn btn-sm btn-primary">View More</a>
            <h4 class="m__section-title">Electronics</h4>
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
@endsection