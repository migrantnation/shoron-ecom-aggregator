@extends('m_frontend.layouts.master')
@section('content')
    {{--<div class="m__title-bar">--}}
        {{--<a href="{{url('m/category-list')}}" class="m__back-btn"><i class="pe-7s-angle-left"></i></a>--}}
        {{--<div class="clearfix">--}}
            {{--<span class="pull-left m__title">Shirt</span>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="m__product-details">
        <div class="m__product-image-carousel owl-carousel m__zoom-gallery">
            <div class="m__carousel-item">
                <a href="https://weneedfun.com/wp-content/uploads/2016/10/Watch-Wallpapers-HD20.jpg" class="ratio-16-9" style="background-image: url('https://weneedfun.com/wp-content/uploads/2016/10/Watch-Wallpapers-HD20.jpg')"></a>
            </div>
            <div class="m__carousel-item">
                <a href="{{url('')}}/assets/img/products/product_img_01.jpg" class="ratio-16-9" style="background-image: url('{{url('')}}/assets/img/products/product_img_01.jpg')"></a>
            </div>
            <div class="m__carousel-item">
                <a href="{{url('')}}/assets/img/products/product_img_02.jpg" class="ratio-16-9" style="background-image: url('{{url('')}}/assets/img/products/product_img_02.jpg')"></a>
            </div>
            <div class="m__carousel-item">
                <a href="{{url('')}}/assets/img/products/product_img_03.jpg" class="ratio-16-9" style="background-image: url('{{url('')}}/assets/img/products/product_img_03.jpg')"></a>
            </div>
            <div class="m__carousel-item">
                <a href="{{url('')}}/assets/img/products/product_img_04.jpg" class="ratio-16-9" style="background-image: url('{{url('')}}/assets/img/products/product_img_04.jpg')"></a>
            </div>
            <div class="m__carousel-item">
                <a href="{{url('')}}/assets/img/products/product_img_05.jpg" class="ratio-16-9" style="background-image: url('{{url('')}}/assets/img/products/product_img_05.jpg')"></a>
            </div>
        </div>

        {{--<div id="productThumb" class="m__d-product-thumb">--}}
            {{--<div class="carousel">--}}
                {{--<ul class="carousel_inner">--}}
                    {{--<li class="item" style="background-image: url('https://weneedfun.com/wp-content/uploads/2016/10/Watch-Wallpapers-HD20.jpg');" data-url="https://weneedfun.com/wp-content/uploads/2016/10/Watch-Wallpapers-HD20.jpg"></li>--}}
                    {{--<li class="item" style="background-image: url('{{url('')}}/assets/img/products/product_img_01.jpg');" data-url="{{url('')}}/assets/img/products/product_img_01.jpg"></li>--}}
                    {{--<li class="item" style="background-image: url('{{url('')}}/assets/img/products/product_img_02.jpg');" data-url="{{url('')}}/assets/img/products/product_img_02.jpg"></li>--}}
                    {{--<li class="item" style="background-image: url('{{url('')}}/assets/img/products/product_img_03.jpg');" data-url="{{url('')}}/assets/img/products/product_img_03.jpg"></li>--}}
                    {{--<li class="item" style="background-image: url('{{url('')}}/assets/img/products/product_img_04.jpg');" data-url="{{url('')}}/assets/img/products/product_img_04.jpg"></li>--}}
                    {{--<li class="item" style="background-image: url('{{url('')}}/assets/img/products/product_img_05.jpg');" data-url="{{url('')}}/assets/img/products/product_img_05.jpg"></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="m__core-details">
            <div class="m__detail-header">
                <h2 class="m__product-title">Nike Air Force 1 GS AF1 Original Woman Classic All Black Anti-skid Cushioning Breathable Skatebroad Shoes # 314192-117</h2>
                <p class="muted-text">(1 Order)</p>
                <p class="m__price"><span>TK. 2563.00</span> <strike>TK. 3000.00</strike></p>
                <p class="m__rating"><span class="m__rated">3.7 <i class="pe-7s-star"></i></span> 235 ratings</p>
            </div>

            <div class="m__section-block">
                <h4 class="m__section-block-title">Colors</h4>
                <div class="m__section-block-content">
                    <label for="c-black" class="custom-label">
                        <input type="radio" id="c-black" name="color">
                        <span class="color-box">
                            <img src="https://ae01.alicdn.com/kf/HTB1C.SdRpXXXXcQXpXXq6xXFXXXj/Nike-Air-Force-1-GS-AF1-Original-Woman-Classic-All-Black-Anti-skid-Cushioning-Breathable-Skatebroad.jpg_50x50.jpg" alt="">
                        </span>
                    </label>
                    <label for="c-red" class="custom-label">
                        <input type="radio" id="c-red" name="color">
                        <span class="color-box">
                            <img src="https://ae01.alicdn.com/kf/HTB1C.SdRpXXXXcQXpXXq6xXFXXXj/Nike-Air-Force-1-GS-AF1-Original-Woman-Classic-All-Black-Anti-skid-Cushioning-Breathable-Skatebroad.jpg_50x50.jpg" alt="">
                        </span>
                    </label>
                </div>
            </div>

            <div class="m__section-block">
                <h4 class="m__section-block-title">Shoe US Size</h4>
                <div class="m__section-block-content">
                    <label class="plx__tag" for="size1">
                        <input type="radio" name="size" id="size1">
                        <span class="size-box">1564145425</span>
                    </label>

                    <label class="plx__tag" for="size2">
                        <input type="radio" name="size" id="size2">
                        <span class="size-box">1564145425</span>
                    </label>

                    <label class="plx__tag" for="size3">
                        <input type="radio" name="size" id="size3">
                        <span class="size-box">1564145425</span>
                    </label>
                </div>
            </div>

            <div id="btnList" class="m__section-block">
                <div class="m__section-block-content">
                    <div class="m__pd-l-part">
                        <a href="javascript://" class="btn btn-block btn-info">Add to Cart</a>
                    </div>
                    <div class="m__pd-r-part">
                        <a href="javascript://" class="btn btn-block btn-primary">Buy Now</a>
                    </div>
                </div>

                <div class="m__action-btn">
                    <div class="m__pd-l-part">
                        <a href="javascript://" class="btn btn-block btn-info">Add to Cart</a>
                    </div>
                    <div class="m__pd-r-part">
                        <a href="javascript://" class="btn btn-block btn-primary">Buy Now</a>
                    </div>
                </div>
            </div>

            <div class="m__section-block">
                <h4 class="m__section-block-title">Escrow Protection</h4>
                <div class="m__section-block-content">
                    <div class="pd-horizontal-banner">
                        <img src="{{url('')}}/assets/img/shield.png" alt="" class="pd-icon">

                        <div class="buy-protection-info">
                            <ul class="buy-protection-info-list">
                                <li class="pd-info-item"><em>Full Refund</em> if you don't receive your order</li>
                                <li class="pd-info-item"><em>Full or&nbsp;Partial Refund</em> , if the item is not as described</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m__section-block">
                <div class="m__nav-tab">
                    <a href="#description" class="m__nav-item current">Description</a>
                    <a href="#specification" class="m__nav-item">Specification</a>
                </div>

                <div id="description" class="m__tab-content m__section-block-content active">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat fugit id illum ipsum laboriosam minus nemo sed, vel voluptas voluptatem?</p>
                    <p>Ipsum dolor sit amet, consectetur adipisicing elit. Ea, voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat fugit id illum ipsum laboriosam minus nemo sed, vel voluptas voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci assumenda molestias mollitia quaerat ullam! Assumenda exercitationem facere harum laborum minima.</p>
                    <p>Ipsum dolor sit amet, consectetur adipisicing elit. Ea, voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat fugit id illum ipsum laboriosam minus nemo sed, vel voluptas voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci assumenda molestias mollitia quaerat ullam! Assumenda exercitationem facere harum laborum minima.</p>
                </div>
                <div id="specification" class="m__tab-content m__specification m__section-block-content">
                    <p>Ipsum dolor sit amet, consectetur adipisicing elit. Ea, voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat fugit id illum ipsum laboriosam minus nemo sed, vel voluptas voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci assumenda molestias mollitia quaerat ullam! Assumenda exercitationem facere harum laborum minima.</p>
                    <p>Ipsum dolor sit amet, consectetur adipisicing elit. Ea, voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat fugit id illum ipsum laboriosam minus nemo sed, vel voluptas voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci assumenda molestias mollitia quaerat ullam! Assumenda exercitationem facere harum laborum minima.</p>
                    <p>Ipsum dolor sit amet, consectetur adipisicing elit. Ea, voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat fugit id illum ipsum laboriosam minus nemo sed, vel voluptas voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci assumenda molestias mollitia quaerat ullam! Assumenda exercitationem facere harum laborum minima.</p>
                    <p>Ipsum dolor sit amet, consectetur adipisicing elit. Ea, voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat fugit id illum ipsum laboriosam minus nemo sed, vel voluptas voluptatem?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci assumenda molestias mollitia quaerat ullam! Assumenda exercitationem facere harum laborum minima.</p>
                </div>
            </div>

            <div class="m__section-block">
                <h4 class="m__section-block-title">Rating</h4>

                <div class="m__section-block-content">
                    <div class="m__rating-details clearfix">
                        <ul class="rate-list">
                            <li>
                                <span class="r-title">5 Stars</span>
                                <a href="#" class="r-number">1,623</a>
                                <span class="r-graph"><span class="active-bar" style="width: 60%;"></span></span>
                            </li>

                            <li>
                                <span class="r-title">5 Stars</span>
                                <a href="#" class="r-number">1200</a>
                                <span class="r-graph"><span class="active-bar" style="width: 35%;"></span></span>
                            </li>

                            <li>
                                <span class="r-title">3 Stars</span>
                                <a href="#" class="r-number">230</a>
                                <span class="r-graph"><span class="active-bar" style="width: 10%;"></span></span>
                            </li>

                            <li>
                                <span class="r-title">2 Stars</span>
                                <a href="#" class="r-number">50</a>
                                <span class="r-graph"><span class="active-bar" style="width: 3%;"></span></span>
                            </li>

                            <li>
                                <span class="r-title">1 Stars</span>
                                <a href="#" class="r-number">02</a>
                                <span class="r-graph"><span class="active-bar" style="width: 2%;"></span></span>
                            </li>
                        </ul>
                        <div class="rate-score">
                            <div class="static-rating" data-value="4.6"></div>
                            <h6>Average Star Rating: <span>4.9 out of 5</span> <small>(1,814 votes)</small></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection