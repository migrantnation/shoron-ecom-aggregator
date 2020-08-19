@extends('frontend.layouts.master')
@section('content')
    <div class="plx__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="{{url('')}}">Home</a></li>
                        <li class="active">All Store</li>
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
            <div class="featured-items">
                <div class="box-inner">
                    <div class="box-header clearfix">
                        <a href="#" class="view-more">View More</a>
                        <h4 class="box-title">Featured Stores</h4>
                    </div>

                    <div class="f-products owl-carousel productCarousel">
                        @forelse($featured_stores as $fs_value)
                            <div class="plx__store">
                                <div class="store-header">
                                    <?php $image = url($fs_value->store_image_thumb ? './store_images/' . $fs_value->store_image_thumb : 'no-product-image.png');?>

                                    <div class="store-image ratio-16-9" style="background-image: url('{{url($image)}}')">
                                    </div>

                                        <h4 class="store-name"><a href="{{url('store'.'/'.$fs_value->store_url)}}">{{$fs_value->store_name}}</a></h4>
                                        <span class="mute-text"> 
                                            <?php
			                            $location = array();
			                            $location[] = @$fs_value->locations->address;
			                            $location[] = @$fs_value->locations->union;
			                            $location[] = @$fs_value->locations->division;
		                            ?>
		                            @if(!empty($location))
		                                {{implode(', ',$location)}}                            
		                            @endif
                                        </span><br>

                                    @if($fs_value->total_rating)
                                        <div class="static-rating" data-value="4.6"></div>
                                        {{'('.$fs_value->total_rating.')'}}
                                    @endif
                                </div>
                                <div class="store-body">
                                    <p>Open: <span>3 year(s)</span></p>
                                    <p>Total Sells: <span>1512</span></p>
                                </div>
                                <div class="store-footer clearfix">
                                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                                    <a href="#" class="">Follow</a>
                                </div>
                            </div>
                        @empty
                            <p>Featured Store not found yet</p>
                        @endforelse

                    </div>
                </div>
            </div>

            <hr>

            <div class="h-adds-block">
                <a href="#" class="h-add">
                    <img src="assets/img/add-1-600x250.jpg" alt="" class="img-responsive">
                </a>
                <a href="#" class="h-add">
                    <img src="assets/img/add-2-600x250.jpg" alt="" class="img-responsive">
                </a>
            </div>

            <h3 class="section-title">All Stores</h3>

            <form class="form-inline search-bar" role="form">
                <div class="form-group form-group-sm">
                    <label>Search:</label>
                    <input type="search" class="form-control" placeholder="Enter keyword">
                </div>
                &nbsp;

                <div class="form-group form-group-sm">
                    <label>Short by:</label>
                    <select name="" id="" class="form-control">
                        <option value="">--Division--</option>
                        <option value="1">Dhaka</option>
                        <option value="2">Chittagong</option>
                        <option value="3">Khulna</option>
                        <option value="4">Rajshahi</option>
                        <option value="5">Barisal</option>
                        <option value="5">Sylhet</option>
                        <option value="6">Mymensingh</option>
                    </select>
                </div>

                &nbsp;
                <div class="form-group form-group-sm">
                    <select name="" id="" class="form-control">
                        <option value="">--District--</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>

                &nbsp;
                <div class="form-group form-group-sm">
                    <select name="" id="" class="form-control">
                        <option value="">--Upozila--</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>

                &nbsp;
                <button type="button" class="btn btn-sm btn-default">Submit</button>
            </form>

            <div class="row">


                @forelse($stores as $key=>$s_value)
                    <div class="col-md-3">
                        <div class="plx__store">
                            <div class="store-header">
                                <?php $image = url($s_value->store_image_thumb ? './store_images/' . $s_value->store_image_thumb : 'no-product-image.png');?>

                                <div class="store-image ratio-16-9" style="background-image: url('{{$image}}')"></div>

                                <h4 class="store-name"><a href="{{url('store'.'/'.$s_value->store_url)}}">{{$s_value->store_name}}</a></h4>
                                <span class="mute-text">
                                    <?php
		                            $location = array();
		                            $location[] = @$s_value->locations->address;
		                            $location[] = @$s_value->locations->union;
		                            $location[] = @$s_value->locations->division;
	                            ?>
	                            @if(!empty($location))
	                                {{implode(', ',$location)}}                            
	                            @endif
                                </span><br>

                                @if($s_value->total_rating)
                                    <div class="static-rating" data-value="4.6"></div>
                                    {{'('.$s_value->total_rating.')'}}
                                @endif
                            </div>
                            <div class="store-body">
                                <p>Open: <span>3 year(s)</span></p>
                                <p>Total Sells: <span>1512</span></p>
                            </div>
                            <div class="store-footer clearfix">
                                <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                                <a href="#" class="">Follow</a>
                            </div>
                        </div>
                    </div>

                    @if($key>3)
                        <div class="clearfix"></div>
                    @endif
                @empty
                    <p>Store not found yet</p>
                @endforelse

            </div>
        </div>
    </div>

    <div class="banner-add">
        <div class="container">
            <a href="#" class="banner-img">
                <img src="assets/img/sale_banner.jpg" alt="" class="">
            </a>
        </div>
    </div>
@endsection