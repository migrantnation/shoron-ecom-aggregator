@extends('frontend.layouts.master')
@section('content')
    <div class="plx__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">All Categories</a></li>
                        <li><a href="#">Phones & Telecommunications</a></li>
                        <li class="active">Mobile Phones (2,735 Results)</li>
                    </ol>
                </div>
                <div class="col-md-3 col-md-push-1">
                    <form action="#" class="pull-right" style="margin-top: 2px;">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                                <button class="btn btn-default btn-default" type="submit"><i class="icon-magnifier"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="product-listing clearfix">
                <div class="part-l">
                    <div class="sidebar-widget">
                        <h4 class="widget-title"><a href="#relatedCat" class="expand toggleExpand">Related Categories</a></h4>
                        <div id="relatedCat">
                            <a href="#" class="cat-link">< Men's Clothing</a>

                            <ul class="attr-list">
                                <li><a href="#">Casual Shirts</a></li>
                                <li><a href="#">Dress Shirts</a></li>
                                <li><a href="#">Tuxedo Shirts</a></li>
                                <li><a href="#">Short Sleeve Shirts</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="sidebar-widget">
                        <h4 class="widget-title"><a href="#material" class="expand toggleExpand">Material</a></h4>

                        <div id="material">
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
                        <h4 class="widget-title"><a href="#size" class="expand toggleExpand">Size</a></h4>

                        <div id="size">
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
                        <h4 class="widget-title"><a href="#length" class="expand toggleExpand">Sleeve Length(cm)</a></h4>

                        <div id="length">
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

                <div class="part-r">
                    <div class="filter-area">
                        <ul class="brands-list">
                            <li>Brands:</li>
                            <li><a href="#"><img src="assets/img/brands/brand-img-01.jpg" alt=""></a></li>
                            <li><a href="#"><img src="assets/img/brands/brand-img-02.jpg" alt=""></a></li>
                            <li><a href="#"><img src="assets/img/brands/brand-img-03.jpg" alt=""></a></li>
                            <li><a href="#"><img src="assets/img/brands/brand-img-01.jpg" alt=""></a></li>
                            <li><a href="#"><img src="assets/img/brands/brand-img-02.jpg" alt=""></a></li>
                            <li><a href="#"><img src="assets/img/brands/brand-img-03.jpg" alt=""></a></li>
                            <li><a href="#"><img src="assets/img/brands/brand-img-01.jpg" alt=""></a></li>
                            <li><a href="#"><img src="assets/img/brands/brand-img-02.jpg" alt=""></a></li>
                            <li><a href="#"><img src="assets/img/brands/brand-img-03.jpg" alt=""></a></li>
                            <li><a href="#" id="more-brand"><i class="icon-plus"></i> More</a></li>
                        </ul>

                        <div class="filter-attr-list">
                            <form action="#" class="by-price">
                                <span class="f-attr-title">Price:</span>
                                <input type="number" class="f-attr-input" min="0" placeholder="min">
                                <span class="f-dash">-</span>
                                <input type="number" class="f-attr-input" min="0" placeholder="max">
                                <button type="submit" class="f-btn btn-primary">Ok</button>
                            </form>

                            <ul class="historgram clearfix">
                                <li><a href="#"><span style="height: 40%;"></span></a></li>
                                <li><a href="#"><span style="height: 10%;"></span></a></li>
                                <li><a href="#"><span style="height: 33.33%;"></span></a></li>
                                <li><a href="#"><span style="height: 60%;"></span></a></li>
                                <li><a href="#"><span style="height: 80%;"></span></a></li>
                            </ul>

                            <div class="filter-options">
                                <label for=" NewArrivals" class="custom-checkbox">
                                    <input type="checkbox" id=" NewArrivals">
                                    <span></span>
                                    New Arrivals
                                </label>

                                <label for="FreeShipping" class="custom-checkbox">
                                    <input type="checkbox" id="FreeShipping">
                                    <span></span>
                                    Free Shipping
                                </label>



                                <label for="rating" class="custom-checkbox">
                                    <div class="static-rating" data-value="4.5"></div> &amp; Up
                                    <input type="checkbox" id="rating">
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="short-options">
                            <div class="row">
                                <div class="col-md-7">
                                    <span>Short By: </span>
                                    <ul class="short-attr-group clearfix">
                                        <li><a href="#">Best Match</a></li>
                                        <li><a href="#" class="with-arrow">Orders</a></li>
                                        <li><a href="#" class="with-arrow">Newest</a></li>
                                        <li><a href="#" class="with-arrow">Seller Rating</a></li>
                                        <li><a href="#" class="with-arrow active down dubble">Price</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-5">
                                    <div class="clearfix">
                                        <div class="view-type-btns">
                                            <span>View:</span>
                                            <a href="#" class="view-type-btn"><i class="icon-list"></i></a>
                                            <a href="#" class="view-type-btn active"><i class="icon-grid"></i></a>
                                        </div>

                                        <a href="#" class="similar-btn">Group Similar Products</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-list">
                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <a href="#" class="mics-info">2 colors available</a>
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p>Shipping: US $4.00 / piece via Seller's Shipping Method</p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <h3 class="product-title"><a href="{{url('product-details')}}">T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p><strong>Free Shipping</strong></p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p>Shipping: US $4.00 / piece via Seller's Shipping Method</p>
                                    <p class="meta-data"><a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <a href="#" class="mics-info">2 colors available</a>
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p><strong>Free Shipping</strong></p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <a href="#" class="mics-info">2 colors available</a>
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p>Shipping: US $4.00 / piece via Seller's Shipping Method</p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <h3 class="product-title"><a href="{{url('product-details')}}">T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p><strong>Free Shipping</strong></p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p>Shipping: US $4.00 / piece via Seller's Shipping Method</p>
                                    <p class="meta-data"><a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <a href="#" class="mics-info">2 colors available</a>
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p><strong>Free Shipping</strong></p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <a href="#" class="mics-info">2 colors available</a>
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p>Shipping: US $4.00 / piece via Seller's Shipping Method</p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <h3 class="product-title"><a href="{{url('product-details')}}">T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p><strong>Free Shipping</strong></p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p>Shipping: US $4.00 / piece via Seller's Shipping Method</p>
                                    <p class="meta-data"><a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <a href="#" class="mics-info">2 colors available</a>
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p><strong>Free Shipping</strong></p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <a href="#" class="mics-info">2 colors available</a>
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p>Shipping: US $4.00 / piece via Seller's Shipping Method</p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <h3 class="product-title"><a href="{{url('product-details')}}">T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p><strong>Free Shipping</strong></p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p>Shipping: US $4.00 / piece via Seller's Shipping Method</p>
                                    <p class="meta-data"><a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product">
                                <a href="{{url('product-details')}}" class="product-thumb" style="background-image: url('public/assets/img/saved8.svg');"></a>
                                <div class="product-desc">
                                    <a href="#" class="mics-info">2 colors available</a>
                                    <h3 class="product-title"><a href="{{url('product-details')}}">Cotton Men Women T-shirt Big Hand Print Tops Summer Blouse</a></h3>
                                    <p class="price"><strong>Tk. 230.00</strong> <small>/ Piece</small></p>
                                    <p><strong>Free Shipping</strong></p>
                                    <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                    <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                    <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="featured-items">
                        <div class="box-inner">
                            <div class="box-header clearfix">
                                <a href="#" class="view-more">View More</a>
                                <h4 class="box-title">Premium Related Products</h4>
                            </div>

                            <div class="f-products owl-carousel productCarousel">
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/saved8.svg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/saved8.svg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/saved8.svg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/saved8.svg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/saved8.svg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/saved8.svg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection