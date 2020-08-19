@extends('frontend.layouts.master')
@section('content')
    <div class="h-bottom-bar">
        <div class="container">
            Store: <a href="#">kicks Store</a>
        </div>
    </div>

    <div class="plx__breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">All Categories</a></li>
                <li><a href="#">Sports &amp; Entertainment</a></li>
                <li class="active">Roller, Skate board &amp;amp; Scooters</li>
            </ol>
        </div>
    </div>

    <!-- Modal -->
    <div id="preCartModal" class="modal pre-cart-modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="pre-cart-header">
                        <span class="success-icon icon-check"></span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">A new item has been added to your Shopping Cart. You now have 2 items in your Shopping Cart.</h5>
                        <div style="margin-top: 10px">
                            <a href="{{url('cart')}}" class="btn btn-sm btn-primary">View Shopping Cart</a> &nbsp;
                            <a href="{{url('product-listing')}}" class="btn btn-sm btn-success">Continue Shopping</a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <p>Buyers Who Bought This Item Also Bought:</p>

                    <div class="featured-items">
                        <div class="box-inner">
                            <div class="f-products owl-carousel productCarousel">
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_21.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_20.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_19.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_18.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_17.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_16.jpg')">
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

    <div class="section">
        <div class="container">
            <div class="detail-main">
                <div class="left-part">
                    <ul id="glasscase" class="gc-start">
                        <li><img src="https://ae01.alicdn.com/kf/HTB17wOiRpXXXXbSXpXXq6xXFXXXk/Nike-Air-Force-1-GS-AF1-Original-Woman-Classic-All-Black-Anti-skid-Cushioning-Breathable-Skatebroad.jpg" alt="Text"/></li>
                        <li><img src="https://ae01.alicdn.com/kf/HTB1Dfp7RpXXXXXKXVXXq6xXFXXXh/Nike-Air-Force-1-GS-AF1-Original-Woman-Classic-All-Black-Anti-skid-Cushioning-Breathable-Skatebroad.jpg" alt="Text"/></li>
                        <li><img src="https://ae01.alicdn.com/kf/HTB1_2CbRpXXXXacXFXXq6xXFXXX3/Nike-Air-Force-1-GS-AF1-Original-Woman-Classic-All-Black-Anti-skid-Cushioning-Breathable-Skatebroad.jpg" alt="Text"/></li>
                        <li><img src="https://ae01.alicdn.com/kf/HTB1ad1kRpXXXXbKXpXXq6xXFXXX3/Nike-Air-Force-1-GS-AF1-Original-Woman-Classic-All-Black-Anti-skid-Cushioning-Breathable-Skatebroad.jpg" alt="Text"/></li>
                    </ul>
                </div>

                <div class="right-part">
                    <div class="detail-header">
                        <h2 class="product-name">Nike Air Force 1 GS AF1 Original Woman Classic All Black Anti-skid Cushioning Breathable Skatebroad Shoes # 314192-117</h2>
                        <a href="#" class="">1 Order</a>
                    </div>

                    <div class="attr-row">
                        <span class="attr-name">Price :</span>
                        <strike>TK 320.00</strike>
                    </div>

                    <div class="attr-row">
                        <span class="attr-name">Discount Price:</span>
                        <span class="d-price">TK 320.00</span>
                        <p>&nbsp;</p>
                    </div>

                    <div class="attr-row">
                        <span class="attr-name">Color:</span>
                        <label for="c-black" class="custom-label">
                            <input type="radio" id="c-black" name="color">
                        <span class="color-box">
                            <img src="https://ae01.alicdn.com/kf/HTB1C.SdRpXXXXcQXpXXq6xXFXXXj/Nike-Air-Force-1-GS-AF1-Original-Woman-Classic-All-Black-Anti-skid-Cushioning-Breathable-Skatebroad.jpg_50x50.jpg"
                                 alt="">
                        </span>
                        </label>
                        <label for="c-red" class="custom-label">
                            <input type="radio" id="c-red" name="color">
                        <span class="color-box">
                            <img src="https://ae01.alicdn.com/kf/HTB1C.SdRpXXXXcQXpXXq6xXFXXXj/Nike-Air-Force-1-GS-AF1-Original-Woman-Classic-All-Black-Anti-skid-Cushioning-Breathable-Skatebroad.jpg_50x50.jpg"
                                 alt="">
                        </span>
                        </label>
                    </div>

                    <div class="attr-row">
                        <span class="attr-name">Quantity:</span>
                        <div class="form-inline">

                            <div class="form-group form-group-sm p-qnt-counter">
                                <input id="pQty" type="number" value="0" class="form-control">
                                <button class="qnt-btn qnt-btn-minus" data-operation="substract" data-qntValue="#pQty">-</button>
                                <button class="qnt-btn qnt-btn-plus" data-operation="add" data-qntValue="#pQty">+</button>
                            </div>

                            piece (522 pieces available)
                        </div>
                    </div>

                    <div class="attr-row">
                        <span class="attr-name">Shoe US Size:</span>

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

                        <p>&nbsp;</p>
                    </div>

                    <div class="attr-row">
                        <span class="attr-name">Fit:</span>
                        Fits true to size, take your normal size
                    </div>

                    <div class="attr-row shipping-text">
                        <span class="attr-name">Shipping:</span>
                        <strong>TK. 160 to Location via <a href="#">UDC Standard Shipping <i class="plx__icon icon-arrow-down"></i></a></strong>
                        <p class="mic-text">Estimated Delivery Time:20-40days &nbsp;<i class="icon-info"></i></p>
                    </div>

                    <div class="attr-row">
                        <span class="attr-name">Total price:</span>
                        <p class="mic-text">Depends on the product properties you select</p>
                    </div>
                    <hr>
                    <p>
                        <a href="javascript://" class="btn btn-primary">Buy Now</a> &nbsp;
                        <a href="javascript://" class="btn btn-success" data-toggle="modal" data-target="#preCartModal">Add to Cart</a> <br>
                        <a href="#" style="display: inline-block; margin-top: 5px;"><i class="icon-heart"></i> Add to Wish List <span class="mic-text">(94 Adds)</span> </a>
                    </p>
                    <hr>
                    <div class="attr-row" style="margin-bottom: 20px">
                        <span class="attr-name">Store Promotion:</span>
                        <div class="promotion-item">
                        <span class="promotion-title">
                            <b>TK 1.00</b> off per <b>TK 199.00</b> &nbsp; <i class="icon-arrow-down-circle"></i>
                        </span>
                            <div class="promotion-dropdown">
                                <div class="pd-body">
                                    <span class="m-item">Seller Discount On all products</span>
                                    <span class="m-item"><span>TK 1.00</span> off per <span>TK 199.00</span></span>
                                    <span class="m-item"><span>TK 1.00</span> off per <span>TK 199.00</span></span>
                                    <span class="m-item"><span>TK 1.00</span> off per <span>TK 199.00</span></span>
                                </div>
                                <div class="pd-footer">
                                    <a href="#">Find more seller discount <i class="icon-arrow-right-circle"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="attr-row">
                        <span class="attr-name">Return Policy:</span>
                        <p>Returns accepted if product not as described, buyer pays return shipping fee; or keep the product & agree refund with seller. View details</p>
                    </div>
                    <div class="attr-row">
                        <span class="attr-name">Seller Guarantees:</span>
                        <p>
                            On-time Delivery <br>
                            <strong>60 days</strong>
                        </p>
                    </div>
                    <!--
                    <div class="attr-row">
                        <span class="attr-name">Payment:</span>
                        <p>
                            <img src="assets/img/cards.png" alt="">
                        </p>
                    </div>
                    -->

                    <div class="pd-horizontal-banner">
                        <img src="assets/img/shield.png" alt="" class="pd-icon">

                        <div class="buy-protection-info">
                            <h3>Escrow Protection</h3>
                            <ul class="buy-protection-info-list">
                                <li class="pd-info-item"><em>Full Refund</em> if you don't receive your order</li>
                                <li class="pd-info-item"><em>Full or&nbsp;Partial Refund</em> , if the item is not as described</li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-right"><a href="#">Learn more
                            <small class="icon-arrow-right"></small>
                        </a></p>
                </div>
            </div>

            <div class="detail-main-layout">
                <div class="left-part">
                    <div class="store-widget">
                    <span class="store-badge" title="Featured Store">
                        <img src="assets/img/icons/medal.png" alt="">
                    </span>
                        <div class="store-header">
                            <span class="mic-text">Sold by</span>
                            <h4 class="store-name"><a href="#">VSD International</a></h4>
                            <span class="mute-text">Dhaka (Uttara)</span>
                        </div>
                        <div class="store-body">
                            <p class="store-message">
                                No feedback score Detailed Seller Ratings information is unavailable when there're less than 10 ratings.
                            </p>
                            <p>Open: <span>3 year(s)</span></p>
                        </div>
                        <div class="store-footer clearfix">
                            <a href="#" class="">Visit Store</a>
                            <a href="#" class="">Follow</a>
                        </div>
                    </div>

                    <div class="s-widget">
                        <h4 class="widget-title">Contact Seller</h4>
                        <a href="#" class=""><i class="icon-envelope-letter"></i> Contact Now</a>
                    </div>

                    <div class="s-widget">
                        <h4 class="widget-title">This Seller's Categories</h4>

                        <ul class="w-category-list">
                            <li>
                                <a href="#cat1" class="expand-btn toggleExpand"></a>
                                <a href="#">2017 Spring Summer New Arrival</a>

                                <ul id="cat1" class="w-sub-category">
                                    <li><a href="#">Short sleeve</a></li>
                                    <li><a href="#">Long sleeve</a></li>
                                    <li><a href="#">Size 4XL</a></li>
                                    <li><a href="#">Quick drying</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#cat2" class="expand-btn toggleExpand"></a>
                                <a href="#">2017 Spring Summer New Arrival</a>

                                <ul id="cat2" class="w-sub-category">
                                    <li><a href="#">Short sleeve</a></li>
                                    <li><a href="#">Long sleeve</a></li>
                                    <li><a href="#">Size 4XL</a></li>
                                    <li><a href="#">Quick drying</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#cat3" class="expand-btn toggleExpand"></a>
                                <a href="#">2017 Spring Summer New Arrival</a>

                                <ul id="cat3" class="w-sub-category">
                                    <li><a href="#">Short sleeve</a></li>
                                    <li><a href="#">Long sleeve</a></li>
                                    <li><a href="#">Size 4XL</a></li>
                                    <li><a href="#">Quick drying</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="s-widget">
                        <h4 class="widget-title">Top Selling Products From This Seller</h4>
                        <div class="product-alt">
                            <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_01.jpg')">
                            </a>
                            <h3 class="product-name"><a href="#">Your product's name</a></h3>
                            <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                        </div>
                        <div class="product-alt">
                            <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_22.jpg')">
                            </a>
                            <h3 class="product-name"><a href="#">Your product's name</a></h3>
                            <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                        </div>
                    </div>
                </div>

                <div class="right-part">
                    <div class="product-description">
                        <ul class="nav nav-pills">
                            <li class="active">
                                <a href="#pd" data-toggle="tab">Product Details</a>
                            </li>
                            <li><a href="#fb" data-toggle="tab">Feedbacks(253)</a>
                            </li>
                            <li><a href="#sp" data-toggle="tab">Shipping &amp; Payment</a>
                            </li>
                            <li><a href="#sg" data-toggle="tab">Seller Guarantees</a>
                            </li>
                        </ul>

                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="pd">
                                <!--<div class="seller-discount-block clearfix">
                                    <div class="part-l">
                                        <h2>Seller Discount</h2>
                                        <h4>On all products</h4>
                                        <p>Time left until promotion ends：11d 0h 0m</p>
                                        <a href="#">Shop Now</a>
                                        <small class="icon-arrow-right"></small>
                                    </div>
                                    <div class="part-r">
                                        <ul>
                                            <li>Get US $3.00 off on orders over US $69.00</li>
                                            <li>Get US $5.00 off on orders over US $110.00</li>
                                        </ul>
                                        <p>(Incl. shipping costs)</p>
                                        <p class="text-muted">If you want to purchase more than one product, please add everything to your Cart first. When you proceed to the checkout page, the Seller Discount will be automatically calculated.</p>
                                    </div>
                                </div>-->

                                <div class="desc-block">
                                    <div class="block-title">Item specifics</div>

                                    <ul class="product-property-list clearfix">
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                        <li>
                                            <span class="property-title">CampTops Type:</span>
                                            <span class="property-desc">Polos</span>
                                        </li>
                                        <li class="clearfix"></li>
                                        <li>
                                            <span class="property-title">Gender:</span>
                                            <span class="property-desc">Men</span>
                                        </li>
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                        <li class="clearfix"></li>
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                        <li class="clearfix"></li>
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                        <li class="clearfix"></li>
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                        <li class="clearfix"></li>
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                        <li>
                                            <span class="property-title">Brand Name:</span>
                                            <span class="property-desc">Pioneer Camp</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="desc-block">
                                    <div class="block-title">Product Descriptions</div>
                                    <img src="https://ae01.alicdn.com/kf/HTB1vqTRJVXXXXaLXXXXq6xXFXXX6/220870536/HTB1vqTRJVXXXXaLXXXXq6xXFXXX6.jpg" alt="" class="img-responsive">
                                    <img src="https://ae01.alicdn.com/kf/HTB1r7efIpXXXXXJXpXXq6xXFXXXU/220870536/HTB1r7efIpXXXXXJXpXXq6xXFXXXU.jpg" alt="" class="img-responsive">
                                </div>
                            </div>

                            <div class="tab-pane" id="fb">
                                <div class="rating-details clearfix">
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
                                        <div class="static-rating-lg" data-value="4.6"></div>
                                        <h4>Average Star Rating: <span>4.9 out of 5</span>
                                            <small>(1,814 votes)</small>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="sp">
                                <div class="desc-block">
                                    <div class="block-title">Shipping</div>

                                    <p>Calculate your shipping cost by region and quantity.</p>
                                    <form class="form-inline">
                                        <div class="form-group form-group-sm">
                                            <label>Quantity: </label>
                                            <input type="number" class="form-control" min="0">
                                        </div>
                                        &nbsp;
                                        <div class="form-group form-group-sm">
                                            <label>Ship to:</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Dhaka</option>
                                                <option value="">Gazipur</option>
                                                <option value="">Mymensingh</option>
                                            </select>
                                        </div>
                                    </form>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Shipping Company</th>
                                            <th>Shipping Cost</th>
                                            <th>Estimated Delivery Time</th>
                                            <th>Tracking Information</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Sundarban Courier</td>
                                            <td>TK 200.00</td>
                                            <td>2-3 days</td>
                                            <td>Available</td>
                                        </tr>
                                        <tr>
                                            <td>Sundarban Courier</td>
                                            <td>TK 200.00</td>
                                            <td>2-3 days</td>
                                            <td>Available</td>
                                        </tr>
                                        <tr>
                                            <td>Sundarban Courier</td>
                                            <td>TK 200.00</td>
                                            <td>2-3 days</td>
                                            <td>Available</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p class="muted-text">Note: Shipping costs shown include fuel surcharges. Import duties, taxes and other customs related charges are not included. Buyers bear all responsibility for all extra charges incurred (if any).</p>
                                    <p class="muted-text">Note: UPS shipping cost savings displayed above reflect discounts offered to AliExpress sellers. They may also include other promotions, subsidies or discounts offered by individual sellers to their buyers, and are only valid on transactions
                                        completed via ---.</p>
                                    <p>IMPORTANT: China Post Air Mail, China Post Air Parcel, HongKong Post Air Mail, HongKong Post Air Parcel may not be tracked and may result in delays or lost parcels.</p>
                                </div>

                                <div class="desc-block">
                                    <div class="block-title"> Packaging Details</div>
                                    <ul class="product-property-list clearfix">
                                        <li>
                                            <span class="property-title">Unit Type:</span>
                                            <span class="property-desc">Price</span>
                                        </li>
                                        <li>
                                            <span class="property-title">piece Package Weight:</span>
                                            <span class="property-desc">0.25kg (0.55lb.)</span>
                                        </li>
                                        <li class="clearfix"></li>
                                        <li>
                                            <span class="property-title">Package Size:</span>
                                            <span class="property-desc">40cm x 30cm x 10cm (15.75in x 11.81in x 3.94in)</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="desc-block">
                                    <div class="block-title"> Payment</div>
                                    <p>We support the following payment methods. All payments made on AliExpress are processed by Alipay.</p>
                                    <img src="assets/img/cards.png" alt="">
                                </div>
                            </div>
                            <div class="tab-pane" id="sg">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td width="100" class="text-center">Return Policy</td>
                                        <td>If the product you receive is not as described or low quality, the seller promises that you may return it before order completion (when you click ‘Confirm Order Received’ or exceed confirmation timeframe), receive a full refund, and that the return
                                            shipping fee will be paid by the seller. Details of the shipping method and fee payment should be agreed with the seller in advance. Or, you can choose to keep the product and agree the refund amount directly with the seller.
                                            long details
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100" class="text-center">Seller Service</td>
                                        <td><strong>On-time Delivery</strong><br>
                                            If you do not receive your purchase within 60 days, you can ask for a full refund before order completion (when you click ‘Confirm Order Received’ or exceed confirmation timeframe).
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="pd-horizontal-banner">
                                    <img src="assets/img/shield.png" alt="" class="pd-icon">

                                    <div class="buy-protection-info">
                                        <h3>Escrow Protection</h3>
                                        <ul class="buy-protection-info-list">
                                            <li class="pd-info-item"><em>Full Refund</em> if you don't receive your order</li>
                                            <li class="pd-info-item"><em>Full or&nbsp;Partial Refund</em> , if the item is not as described</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3>More Products</h3>

                    <div class="featured-items">
                        <div class="box-inner">
                            <div class="box-header clearfix">
                                <h4 class="box-title">From This Seller</h4>
                            </div>

                            <div class="f-products owl-carousel productCarousel">
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_18.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_17.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_16.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_15.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_14.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_13.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="featured-items">
                        <div class="box-inner">
                            <div class="box-header clearfix">
                                <h4 class="box-title">From Other Sellers</h4>
                            </div>

                            <div class="f-products owl-carousel productCarousel">
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_12.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_11.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_10.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_09.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_08.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_07.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
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
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_06.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_05.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_04.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_03.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_02.jpg')">
                                    </a>
                                    <h3 class="product-name"><a href="#">Your product's name</a></h3>
                                    <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                                </div>
                                <div class="product-alt">
                                    <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('public/assets/img/products/product_img_01.jpg')">
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