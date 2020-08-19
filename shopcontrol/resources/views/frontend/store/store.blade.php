@extends('frontend.layouts.master')
@section('content')
    <div class="plx__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active">{{@$store_info->store_name}}</li>
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
                    <div class="store-widget">
                        <div class="store-header">
                            <?php $image = url($store_info->store_image_thumb ? './store_images/' . $store_info->store_image_thumb : 'no-product-image.png');?>

                            <div class="store-image ratio-21-9" style="background-image: url('{{url($image)}}')"></div>

                            <h4 class="store-name"><a href="javascript:;">{{@$store_info->store_name}}</a></h4>
                            <span class="mute-text">
                                {{@$store_info->locations->address.', '.@$store_info->locations->union.', '.@$store_info->locations->division}}
                            </span>
                            <br>
                            <div class="static-rating" data-value="3.6"></div>
                            ({{$store_info->total_rating?@$store_info->total_rating:'0'}})
                        </div>
                        <div class="store-body">
                            <p>Open: <span>3 year(s)</span></p>
                            <p><span>Total Sells: 1512</span></p>
                        </div>
                        <div class="store-footer clearfix">
                            <a href="javascript:;" class=""><i class="icon-envelope-letter"></i> Contact</a>
                            <a href="javascript:;" class="">Follow</a>
                        </div>
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
                            <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('{{url('')}}/assets/img/products/product_img_01.jpg')">
                            </a>
                            <h3 class="product-name"><a href="#">Your product's name</a></h3>
                            <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                        </div>
                        <div class="product-alt">
                            <a href="{{url('product-details')}}" class="p-pic" style="background-image: url('{{url('')}}/assets/img/products/product_img_22.jpg')">
                            </a>
                            <h3 class="product-name"><a href="#">Your product's name</a></h3>
                            <span class="price">Tk. 320.00 <small>Tk. 400.00</small></span>
                        </div>
                    </div>
                </div>

                <div class="part-r">
                    <div class="banner-add">
                        <a href="#" class="banner-img">
                            <img src="{{url('public/assets/img/sale_banner.jpg')}}" alt="" class="img-responsive">
                        </a>
                    </div>

                    <div class="featured-items">
                        <div class="box-inner">
                            <div class="box-header clearfix">
                                <a href="#" class="view-more">View More</a>
                                <h4 class="box-title">Premium Related Products</h4>
                            </div>

                            <div class="f-products owl-carousel productCarousel">
                                @forelse($premium_related_products as $prp_value)
                                    <?php $product_image = url($prp_value->product_image ? 'content-dir/stores/' . $store_info->store_url . '/products/' .$prp_value->product_url.'/'. $prp_value->product_image : url('content-dir/no-product-image.png'));?>
                                    <div class="product-alt">
                                        <a href="{{url("$prp_value->product_url/product-details")}}" class="p-pic"
                                           style="background-image: url('{{$product_image}}')">
                                        </a>
                                        <h3 class="product-name"><a href="{{url("$prp_value->product_url/product-details")}}">{{$prp_value->product_name}}</a></h3>
                                        <span class="price">Tk. {{$prp_value->base_price}}
                                            <small>Tk. {{$prp_value->compare_price}}</small></span>
                                    </div>
                                @empty

                                @endforelse
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="filter-area">
                        <div class="short-options">
                            <div class="row">
                                <div class="col-md-7">
                                    <span>Short By: </span>
                                    <ul class="short-attr-group clearfix">
                                        <li><a href="#" class="with-arrow">Orders</a></li>
                                        <li><a href="#" class="with-arrow">Newest</a></li>
                                        <li><a href="#" class="with-arrow">Seller Rating</a></li>
                                        <li><a href="#" class="with-arrow active down dubble">Price</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-5">
                                    <div class="clearfix">
                                        <a href="#" class="similar-btn">Group Similar Products</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-list">

                        @forelse($products as $p_value)
                            <?php $product_image = url($p_value->product_image ? 'content-dir/stores/' . $store_info->store_url . '/products/' . $p_value->product_url. '/' . $p_value->product_image : url('content-dir/no-product-image.png'));?>

                            <div class="product-grid">
                                <div class="product">
                                    <a href="{{url("$p_value->product_url/product-details")}}" class="product-thumb"
                                       style="background-image: url('{{$product_image}}');"></a>
                                    <div class="product-desc">
                                        <a href="#" class="mics-info">2 colors available</a>
                                        <h3 class="product-title">
                                            <a href="{{url("$prp_value->product_url/product-details")}}">{{$p_value->product_name}}</a>
                                        </h3>
                                        <p class="price"><strong>Tk. {{$p_value->base_price}}</strong>
                                            <small>/ Piece</small>
                                        </p>
                                        <p>Shipping: US $4.00 / piece via Seller's Shipping Method</p>
                                        <p class="meta-data"><span class="static-rating" data-value="4.35"></span> (20) | <a href="#">Orders(20)</a></p>
                                        <p><a href="#"><i class="icon-layers"></i> Name of Store</a></p>
                                        <a class="wishlist-btn" href="javascript://"><i class="icon-heart"></i> Add to wish list</a>
                                    </div>
                                </div>
                            </div>
                        @empty

                        @endforelse

                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection