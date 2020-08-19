@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">

    <div class="page-bar">
        <ul class="page-breadcrumb">

            <li>
                <a href="{{url('admin')}}">{{ __('admin_text.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <span>{{ __('admin_text.add_product') }}</span>
            </li>

        </ul>
    </div>

    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <!--<a href="https://199.192.26.175/parallaxcart/admin/merchant" class="">
            <small class="fa fa-angle-left"></small>
            &nbsp;Back Merchant List</a>-->
        <h3 class="margin-top-10 margin-bottom-15"> Add New Product
        &nbsp;
        <small></small>
        <a href="{{url('udc/product-list')}}" class="btn btn-info">পণ্যের তালিকা &nbsp;&nbsp;
                    </a>
        </h3>
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">Product</span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product"> Product </a>
                    </li>
                    <li class="disabled">
                        <a href="javascript:void(0)" disabled="disabled"> Variations </a>
                    </li>
                </ul>
            </div>

            <div class="portlet-body">
                
                                                    
                <form class="row" action="https://199.192.26.175/parallaxcart/admin/4/product" method="post" enctype="multipart/form-data" name="addProductForm" id="addProductForm">

                    <input type="hidden" name="_token" value="IYUHoOn3WeUYeMPHILPNiadpgTNDIj7WMyEqqybJ">

                    
                    <div class="col-sm-8">

                        <div class="form-group">
                            <label>Product Name <span class="alert-required">*</span></label>
                            <input type="text" class="form-control" name="product_name" value="" required>
                            <label class="error"></label>
                        </div>

                        <div class="form-group">
                            <label>Short Description <i>(Less than or equal 160 characters)</i> <span class="alert-required">*</span></label>
                            <input type="text" class="form-control" name="short_description" value="" required>
                            <label class="error"></label>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="summernote"></textarea>
                            <label class="error"></label>
                        </div>

                        <div class="form-group">
                            <label> Product Specification </label>
                            <textarea name="product_specification" class="summernote"></textarea>
                            <label class="error"></label>
                        </div>


                        <div class="form-group">
                            <label>Is Brand Product?</label>
                            <div>
                                <label class="radio-inline"><input class="is-brand" type="radio" value="1" name="isBrand" data-value="yes">Yes</label>
                                <label class="radio-inline"><input class="is-brand" type="radio" value="0" name="isBrand" data-value="no" checked>No</label>
                            </div>

                            <div class="brand-list-wrap margin-top-10" style="display: none;">
                                <ul class="brands-list scroller" style="height: 220px;" data-always-visible="1" data-rail-visible="0">

                                                                            <li>
                                            <label for="brand-1">
                                                <input class="brand-option" type="radio" id="brand-1" name="brand_id" value="1">
                                                <span title="Lereve">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/product-image-170715080841.png" alt="Lereve">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-2">
                                                <input class="brand-option" type="radio" id="brand-2" name="brand_id" value="2">
                                                <span title="Yellow">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/product-image-170715081017.jpg" alt="Yellow">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-3">
                                                <input class="brand-option" type="radio" id="brand-3" name="brand_id" value="3">
                                                <span title="Aarong">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/product-image-170715081108.png" alt="Aarong">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-4">
                                                <input class="brand-option" type="radio" id="brand-4" name="brand_id" value="4">
                                                <span title="Grameen Check">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/product-image-170715081154.png" alt="Grameen Check">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-5">
                                                <input class="brand-option" type="radio" id="brand-5" name="brand_id" value="5">
                                                <span title="Asus">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/product-image-170715081255.png" alt="Asus">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-6">
                                                <input class="brand-option" type="radio" id="brand-6" name="brand_id" value="6">
                                                <span title="HP">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/product-image-170715081449.png" alt="HP">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-7">
                                                <input class="brand-option" type="radio" id="brand-7" name="brand_id" value="7">
                                                <span title="Lenevo">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-lenevo.png" alt="Lenevo">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-8">
                                                <input class="brand-option" type="radio" id="brand-8" name="brand_id" value="8">
                                                <span title="Gigabyte">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-gigabyte.png" alt="Gigabyte">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-9">
                                                <input class="brand-option" type="radio" id="brand-9" name="brand_id" value="9">
                                                <span title="Toshiba">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-toshiba.png" alt="Toshiba">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-10">
                                                <input class="brand-option" type="radio" id="brand-10" name="brand_id" value="10">
                                                <span title="Oppo">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-oppo.png" alt="Oppo">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-11">
                                                <input class="brand-option" type="radio" id="brand-11" name="brand_id" value="11">
                                                <span title="Apple">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-apple.png" alt="Apple">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-12">
                                                <input class="brand-option" type="radio" id="brand-12" name="brand_id" value="12">
                                                <span title="Nokia">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-nokia.png" alt="Nokia">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-13">
                                                <input class="brand-option" type="radio" id="brand-13" name="brand_id" value="13">
                                                <span title="Xiaomi">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-xiaomi.png" alt="Xiaomi">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-14">
                                                <input class="brand-option" type="radio" id="brand-14" name="brand_id" value="14">
                                                <span title="Huawei">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-huawei.png" alt="Huawei">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-15">
                                                <input class="brand-option" type="radio" id="brand-15" name="brand_id" value="15">
                                                <span title="Pran">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-pran.png" alt="Pran">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-16">
                                                <input class="brand-option" type="radio" id="brand-16" name="brand_id" value="16">
                                                <span title="BDFood">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-bdfood.png" alt="BDFood">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-17">
                                                <input class="brand-option" type="radio" id="brand-17" name="brand_id" value="17">
                                                <span title="Maggi">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-maggi.png" alt="Maggi">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-19">
                                                <input class="brand-option" type="radio" id="brand-19" name="brand_id" value="19">
                                                <span title="Lotto">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-lotto.png" alt="Lotto">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-20">
                                                <input class="brand-option" type="radio" id="brand-20" name="brand_id" value="20">
                                                <span title="Teer">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-teer.png" alt="Teer">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-21">
                                                <input class="brand-option" type="radio" id="brand-21" name="brand_id" value="21">
                                                <span title="Lux">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-lux.png" alt="Lux">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-22">
                                                <input class="brand-option" type="radio" id="brand-22" name="brand_id" value="22">
                                                <span title="Ponds">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-ponds.png" alt="Ponds">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-23">
                                                <input class="brand-option" type="radio" id="brand-23" name="brand_id" value="23">
                                                <span title="Clear">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-clear.png" alt="Clear">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-24">
                                                <input class="brand-option" type="radio" id="brand-24" name="brand_id" value="24">
                                                <span title="Radhuni">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-radhuni.png" alt="Radhuni">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-25">
                                                <input class="brand-option" type="radio" id="brand-25" name="brand_id" value="25">
                                                <span title="Fresh">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-fresh.png" alt="Fresh">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-26">
                                                <input class="brand-option" type="radio" id="brand-26" name="brand_id" value="26">
                                                <span title="Jui">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-jui.png" alt="Jui">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-27">
                                                <input class="brand-option" type="radio" id="brand-27" name="brand_id" value="27">
                                                <span title="Horlics">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-horlics.png" alt="Horlics">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-28">
                                                <input class="brand-option" type="radio" id="brand-28" name="brand_id" value="28">
                                                <span title="Walton">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-walton.png" alt="Walton">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-29">
                                                <input class="brand-option" type="radio" id="brand-29" name="brand_id" value="29">
                                                <span title="LG">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-lg.png" alt="LG">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-30">
                                                <input class="brand-option" type="radio" id="brand-30" name="brand_id" value="30">
                                                <span title="Sony">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-Sony.png" alt="Sony">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-31">
                                                <input class="brand-option" type="radio" id="brand-31" name="brand_id" value="31">
                                                <span title="Westecs">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-westecs.png" alt="Westecs">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-32">
                                                <input class="brand-option" type="radio" id="brand-32" name="brand_id" value="32">
                                                <span title="Cats Eye">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-cats-eye.png" alt="Cats Eye">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-33">
                                                <input class="brand-option" type="radio" id="brand-33" name="brand_id" value="33">
                                                <span title="SHAJGOJ">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-shajgoj.png" alt="SHAJGOJ">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-34">
                                                <input class="brand-option" type="radio" id="brand-34" name="brand_id" value="34">
                                                <span title="BABY LAND">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-baby-land.png" alt="BABY LAND">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-35">
                                                <input class="brand-option" type="radio" id="brand-35" name="brand_id" value="35">
                                                <span title="Infinity">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-infinity.png" alt="Infinity">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-36">
                                                <input class="brand-option" type="radio" id="brand-36" name="brand_id" value="36">
                                                <span title="Naborupa">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-naborupa.png" alt="Naborupa">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-37">
                                                <input class="brand-option" type="radio" id="brand-37" name="brand_id" value="37">
                                                <span title="Anjans">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-anjans.png" alt="Anjans">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-38">
                                                <input class="brand-option" type="radio" id="brand-38" name="brand_id" value="38">
                                                <span title="Gentle Park">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/brand-gentle-park.png" alt="Gentle Park">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-39">
                                                <input class="brand-option" type="radio" id="brand-39" name="brand_id" value="39">
                                                <span title="testing brand">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/product-image-170715081808.png" alt="testing brand">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-41">
                                                <input class="brand-option" type="radio" id="brand-41" name="brand_id" value="41">
                                                <span title="Testingss">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/product-image-181008103011.png" alt="Testingss">
                                        </span>
                                            </label>
                                        </li>
                                                                            <li>
                                            <label for="brand-42">
                                                <input class="brand-option" type="radio" id="brand-42" name="brand_id" value="42">
                                                <span title="Kabira">
                                            <img src="https://199.192.26.175/parallaxcart/content-dir/brands/product-image-181117101051.png" alt="Kabira">
                                        </span>
                                            </label>
                                        </li>
                                                                    </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Regular Price <span class="alert-required">*</span></label>
                            <input type="text" class="form-control numeric" name="base_price" id="base_price" required
                                   value="" placeholder="Enter price">
                            <label class="error"></label>
                        </div>


                        <div class="form-group">
                            <label>Is It Flash Selling Product?</label>
                            <div>
                                <label class="radio-inline"><input class="is-flash" type="radio" value="1" name="is_flash_sell" data-value="yes" >Yes</label>
                                <label class="radio-inline"><input class="is-flash" type="radio" value="2" name="is_flash_sell" data-value="no"  checked>No</label>
                            </div>
                        </div>

                        <div class="flash-wrap margin-top-10" style="display: none;">
                            
                            <div class="form-group">
                                <label>Flash Selling Price <span class="alert-required">*</span></label>
                                <input type="number" min="0" step="any" class="form-control numeric" name="flash_sell_price" id="flash_price" required value="" placeholder="Enter Flash Price">
                                <label class="error"></label>
                            </div>
                            <div class="form-group">
                                <label>Flash Selling Date From <span class="alert-required">*</span></label>
                                <input id="datepickerfrom" type="text" class="form-control numeric" name="merchant_flash_sell_start_date" required value="" placeholder="Flash Start Date">
                                <label class="error"></label>
                            </div>
                            <div class="form-group">
                                <label>Flash Selling Date To <span class="alert-required">*</span></label>
                                <input id="datepickerto" type="text" class="form-control numeric" name="merchant_flash_sell_end_date" required value="" placeholder="Flash End Date">
                                <label class="error"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Admin Flash Sell</label>
                            <div>
                                <label class="radio-inline"><input class="is-admin-flash" type="radio" value="1" name="have_admin_flash_sell" data-value="yes" >Yes</label>
                                <label class="radio-inline"><input class="is-admin-flash" type="radio" value="2" name="have_admin_flash_sell" data-value="no"   checked>No</label>
                            </div>
                        </div>

                        <div class="admin-flash-wrap margin-top-10" style="display: none;">
                            
                                
                                
                                    
                                    
                                
                            
                            <div class="form-group">
                                <label>Flash Selling Price <span class="alert-required">*</span></label>
                                <input type="number" min="0" step="any" class="form-control numeric" name="admin_flash_sell_price" id="flash_price" required value="" placeholder="Enter Flash Price">
                                <label class="error"></label>
                            </div>
                            
                                
                                
                                
                            
                            
                                
                                
                                
                            

                            <div class="form-group">
                                <label>Flash Sell Quantity </label>
                                <input  min="0" type="number" class="form-control numeric" name="admin_flash_sell_qty" value="" placeholder="Flash Sell Quantity">
                                <label class="error"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Inventory <span class="alert-required">*</span></label>

                            
                            
                            

                            <input type="number" class="form-control margin-top-15  " required placeholder="Enter quantity "
                                   name="quantity"  min="0" id="quantity" value=""
                                    >

                            <label class="text-info margin-top-10">
                                
                            </label>

                        </div>

                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="clearfix" style="display: block; margin-bottom: 7px">
                                <a href="#" id="expandToggle" class="pull-right">Expand All</a>
                                Category
                            </label>

                            <ul id="plx__tree" class="scroller" style="height: 220px;" data-always-visible="1" data-rail-visible="0"><li id="parent14">                            <label class="plx__radio" for="cat14">
                                <input type="radio" id="cat14" name="category_id"
                                       value="14" >
                                <span></span>
                            </label>
                            <a href="#child14"> Men&#039;s Clothing</a>
                            <ul id="child14"><li id="parent15">                            <label class="plx__radio" for="cat15">
                                <input type="radio" id="cat15" name="category_id"
                                       value="15" >
                                <span></span>
                            </label>
                            <a href="#child15"> Tops &amp; Tees</a>
                            <ul id="child15">                            <li>
                                <label class="plx__radio" for="cat16">
                                    <input type="radio" id="cat16" name="category_id"
                                           value="16" >
                                    <span></span>
                                </label>
                                <span class="l-child">T-Shirts</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat17">
                                    <input type="radio" id="cat17" name="category_id"
                                           value="17" >
                                    <span></span>
                                </label>
                                <span class="l-child">Tank Tops</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat18">
                                    <input type="radio" id="cat18" name="category_id"
                                           value="18" >
                                    <span></span>
                                </label>
                                <span class="l-child">Polo</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat19">
                                    <input type="radio" id="cat19" name="category_id"
                                           value="19" >
                                    <span></span>
                                </label>
                                <span class="l-child">Board Shorts</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat20">
                                    <input type="radio" id="cat20" name="category_id"
                                           value="20" >
                                    <span></span>
                                </label>
                                <span class="l-child">Shirts</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat21">
                                    <input type="radio" id="cat21" name="category_id"
                                           value="21" >
                                    <span></span>
                                </label>
                                <span class="l-child">Hoodies &amp; Sweatshirts</span>
                            </li>
                            </ul></li><li id="parent22">                            <label class="plx__radio" for="cat22">
                                <input type="radio" id="cat22" name="category_id"
                                       value="22" >
                                <span></span>
                            </label>
                            <a href="#child22"> Bottoms</a>
                            <ul id="child22">                            <li>
                                <label class="plx__radio" for="cat23">
                                    <input type="radio" id="cat23" name="category_id"
                                           value="23" >
                                    <span></span>
                                </label>
                                <span class="l-child">Casual Pants</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat24">
                                    <input type="radio" id="cat24" name="category_id"
                                           value="24" >
                                    <span></span>
                                </label>
                                <span class="l-child">Cargo Pants</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat25">
                                    <input type="radio" id="cat25" name="category_id"
                                           value="25" >
                                    <span></span>
                                </label>
                                <span class="l-child">Jeans</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat26">
                                    <input type="radio" id="cat26" name="category_id"
                                           value="26" >
                                    <span></span>
                                </label>
                                <span class="l-child">Sweatpants</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat27">
                                    <input type="radio" id="cat27" name="category_id"
                                           value="27" >
                                    <span></span>
                                </label>
                                <span class="l-child">Harem Pants</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat28">
                                    <input type="radio" id="cat28" name="category_id"
                                           value="28" >
                                    <span></span>
                                </label>
                                <span class="l-child">Shorts</span>
                            </li>
                            </ul></li><li id="parent29">                            <label class="plx__radio" for="cat29">
                                <input type="radio" id="cat29" name="category_id"
                                       value="29" >
                                <span></span>
                            </label>
                            <a href="#child29"> Outerwear &amp; Jackets</a>
                            <ul id="child29">                            <li>
                                <label class="plx__radio" for="cat30">
                                    <input type="radio" id="cat30" name="category_id"
                                           value="30" >
                                    <span></span>
                                </label>
                                <span class="l-child">Jackets</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat31">
                                    <input type="radio" id="cat31" name="category_id"
                                           value="31" >
                                    <span></span>
                                </label>
                                <span class="l-child">Trench</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat32">
                                    <input type="radio" id="cat32" name="category_id"
                                           value="32" >
                                    <span></span>
                                </label>
                                <span class="l-child">Parkas</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat33">
                                    <input type="radio" id="cat33" name="category_id"
                                           value="33" >
                                    <span></span>
                                </label>
                                <span class="l-child">Sweaters</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat34">
                                    <input type="radio" id="cat34" name="category_id"
                                           value="34" >
                                    <span></span>
                                </label>
                                <span class="l-child">Suits &amp; Blazer</span>
                            </li>
                            </ul></li><li id="parent35">                            <label class="plx__radio" for="cat35">
                                <input type="radio" id="cat35" name="category_id"
                                       value="35" >
                                <span></span>
                            </label>
                            <a href="#child35"> Underwear &amp; Loungewear</a>
                            <ul id="child35">                            <li>
                                <label class="plx__radio" for="cat36">
                                    <input type="radio" id="cat36" name="category_id"
                                           value="36" >
                                    <span></span>
                                </label>
                                <span class="l-child">Boxers</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat38">
                                    <input type="radio" id="cat38" name="category_id"
                                           value="38" >
                                    <span></span>
                                </label>
                                <span class="l-child">Briefs</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat39">
                                    <input type="radio" id="cat39" name="category_id"
                                           value="39" >
                                    <span></span>
                                </label>
                                <span class="l-child">Board Shorts</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat40">
                                    <input type="radio" id="cat40" name="category_id"
                                           value="40" >
                                    <span></span>
                                </label>
                                <span class="l-child">Men&#039;s Sleep &amp; Lounge</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat41">
                                    <input type="radio" id="cat41" name="category_id"
                                           value="41" >
                                    <span></span>
                                </label>
                                <span class="l-child">Pajama Sets</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat42">
                                    <input type="radio" id="cat42" name="category_id"
                                           value="42" >
                                    <span></span>
                                </label>
                                <span class="l-child">Robes</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat43">
                                    <input type="radio" id="cat43" name="category_id"
                                           value="43" >
                                    <span></span>
                                </label>
                                <span class="l-child">Socks</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat104">
                                    <input type="radio" id="cat104" name="category_id"
                                           value="104" >
                                    <span></span>
                                </label>
                                <span class="l-child">Gavadings</span>
                            </li>
                            </ul></li><li id="parent44">                            <label class="plx__radio" for="cat44">
                                <input type="radio" id="cat44" name="category_id"
                                       value="44" >
                                <span></span>
                            </label>
                            <a href="#child44"> Accessories</a>
                            <ul id="child44">                            <li>
                                <label class="plx__radio" for="cat45">
                                    <input type="radio" id="cat45" name="category_id"
                                           value="45" >
                                    <span></span>
                                </label>
                                <span class="l-child">Eyewear Frames</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat46">
                                    <input type="radio" id="cat46" name="category_id"
                                           value="46" >
                                    <span></span>
                                </label>
                                <span class="l-child">Baseball Caps</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat47">
                                    <input type="radio" id="cat47" name="category_id"
                                           value="47" >
                                    <span></span>
                                </label>
                                <span class="l-child">Scarves</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat48">
                                    <input type="radio" id="cat48" name="category_id"
                                           value="48" >
                                    <span></span>
                                </label>
                                <span class="l-child">Belts &amp; Cummerbunds</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat49">
                                    <input type="radio" id="cat49" name="category_id"
                                           value="49" >
                                    <span></span>
                                </label>
                                <span class="l-child">Ties &amp; Handkerchiefs</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat50">
                                    <input type="radio" id="cat50" name="category_id"
                                           value="50" >
                                    <span></span>
                                </label>
                                <span class="l-child">Skullies &amp; Beanies</span>
                            </li>
                            </ul></li><li id="parent51">                            <label class="plx__radio" for="cat51">
                                <input type="radio" id="cat51" name="category_id"
                                       value="51" >
                                <span></span>
                            </label>
                            <a href="#child51"> Sunglasses</a>
                            <ul id="child51">                            <li>
                                <label class="plx__radio" for="cat52">
                                    <input type="radio" id="cat52" name="category_id"
                                           value="52" >
                                    <span></span>
                                </label>
                                <span class="l-child">Pilot</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat53">
                                    <input type="radio" id="cat53" name="category_id"
                                           value="53" >
                                    <span></span>
                                </label>
                                <span class="l-child">Wayfarer</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat54">
                                    <input type="radio" id="cat54" name="category_id"
                                           value="54" >
                                    <span></span>
                                </label>
                                <span class="l-child">Square</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat55">
                                    <input type="radio" id="cat55" name="category_id"
                                           value="55" >
                                    <span></span>
                                </label>
                                <span class="l-child">Round</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat56">
                                    <input type="radio" id="cat56" name="category_id"
                                           value="56" >
                                    <span></span>
                                </label>
                                <span class="l-child">Oval</span>
                            </li>
                            </ul></li></ul></li><li id="parent57">                            <label class="plx__radio" for="cat57">
                                <input type="radio" id="cat57" name="category_id"
                                       value="57" >
                                <span></span>
                            </label>
                            <a href="#child57"> Phones &amp; Accessories</a>
                            <ul id="child57"><li id="parent58">                            <label class="plx__radio" for="cat58">
                                <input type="radio" id="cat58" name="category_id"
                                       value="58" >
                                <span></span>
                            </label>
                            <a href="#child58"> Mobile Phones</a>
                            <ul id="child58">                            <li>
                                <label class="plx__radio" for="cat59">
                                    <input type="radio" id="cat59" name="category_id"
                                           value="59" >
                                    <span></span>
                                </label>
                                <span class="l-child">Octa Core</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat60">
                                    <input type="radio" id="cat60" name="category_id"
                                           value="60" >
                                    <span></span>
                                </label>
                                <span class="l-child">Quad Core</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat61">
                                    <input type="radio" id="cat61" name="category_id"
                                           value="61" >
                                    <span></span>
                                </label>
                                <span class="l-child">Single SIM Card</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat62">
                                    <input type="radio" id="cat62" name="category_id"
                                           value="62" >
                                    <span></span>
                                </label>
                                <span class="l-child">Dual SIM Card</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat63">
                                    <input type="radio" id="cat63" name="category_id"
                                           value="63" >
                                    <span></span>
                                </label>
                                <span class="l-child">3GB RAM</span>
                            </li>
                            </ul></li><li id="parent64">                            <label class="plx__radio" for="cat64">
                                <input type="radio" id="cat64" name="category_id"
                                       value="64" >
                                <span></span>
                            </label>
                            <a href="#child64"> Mobile Phone Parts</a>
                            <ul id="child64">                            <li>
                                <label class="plx__radio" for="cat65">
                                    <input type="radio" id="cat65" name="category_id"
                                           value="65" >
                                    <span></span>
                                </label>
                                <span class="l-child">Mobile Phone LCDs</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat66">
                                    <input type="radio" id="cat66" name="category_id"
                                           value="66" >
                                    <span></span>
                                </label>
                                <span class="l-child">Mobile Phone Batteries</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat67">
                                    <input type="radio" id="cat67" name="category_id"
                                           value="67" >
                                    <span></span>
                                </label>
                                <span class="l-child">Mobile Phone Housings</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat68">
                                    <input type="radio" id="cat68" name="category_id"
                                           value="68" >
                                    <span></span>
                                </label>
                                <span class="l-child">Mobile Phone Touch Panel</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat69">
                                    <input type="radio" id="cat69" name="category_id"
                                           value="69" >
                                    <span></span>
                                </label>
                                <span class="l-child">Flex Cables</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat70">
                                    <input type="radio" id="cat70" name="category_id"
                                           value="70" >
                                    <span></span>
                                </label>
                                <span class="l-child">SIM Card &amp; Tools</span>
                            </li>
                            </ul></li><li id="parent71">                            <label class="plx__radio" for="cat71">
                                <input type="radio" id="cat71" name="category_id"
                                       value="71" >
                                <span></span>
                            </label>
                            <a href="#child71"> Mobile Phone Accessories</a>
                            <ul id="child71">                            <li>
                                <label class="plx__radio" for="cat72">
                                    <input type="radio" id="cat72" name="category_id"
                                           value="72" >
                                    <span></span>
                                </label>
                                <span class="l-child">Power Bank</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat73">
                                    <input type="radio" id="cat73" name="category_id"
                                           value="73" >
                                    <span></span>
                                </label>
                                <span class="l-child">Screen Protectors</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat74">
                                    <input type="radio" id="cat74" name="category_id"
                                           value="74" >
                                    <span></span>
                                </label>
                                <span class="l-child">MMobile Phone Cables</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat75">
                                    <input type="radio" id="cat75" name="category_id"
                                           value="75" >
                                    <span></span>
                                </label>
                                <span class="l-child">Mobile Phone Chargers</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat76">
                                    <input type="radio" id="cat76" name="category_id"
                                           value="76" >
                                    <span></span>
                                </label>
                                <span class="l-child">Holders &amp; Stands</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat77">
                                    <input type="radio" id="cat77" name="category_id"
                                           value="77" >
                                    <span></span>
                                </label>
                                <span class="l-child">Mobile Phone Lenses</span>
                            </li>
                            </ul></li></ul></li>                            <li>
                                <label class="plx__radio" for="cat78">
                                    <input type="radio" id="cat78" name="category_id"
                                           value="78" >
                                    <span></span>
                                </label>
                                <span class="l-child">Computer &amp; Office</span>
                            </li>
                            <li id="parent79">                            <label class="plx__radio" for="cat79">
                                <input type="radio" id="cat79" name="category_id"
                                       value="79" >
                                <span></span>
                            </label>
                            <a href="#child79"> Consumer Electronics</a>
                            <ul id="child79">                            <li>
                                <label class="plx__radio" for="cat106">
                                    <input type="radio" id="cat106" name="category_id"
                                           value="106" >
                                    <span></span>
                                </label>
                                <span class="l-child">Pen</span>
                            </li>
                            </ul></li>                            <li>
                                <label class="plx__radio" for="cat80">
                                    <input type="radio" id="cat80" name="category_id"
                                           value="80" >
                                    <span></span>
                                </label>
                                <span class="l-child">Jewelry &amp; Watches</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat81">
                                    <input type="radio" id="cat81" name="category_id"
                                           value="81" >
                                    <span></span>
                                </label>
                                <span class="l-child">Home &amp; Garden, Furniture</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat83">
                                    <input type="radio" id="cat83" name="category_id"
                                           value="83" >
                                    <span></span>
                                </label>
                                <span class="l-child">Toys, Kids &amp; Baby</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat84">
                                    <input type="radio" id="cat84" name="category_id"
                                           value="84" >
                                    <span></span>
                                </label>
                                <span class="l-child">Sports &amp; Outdoors</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat85">
                                    <input type="radio" id="cat85" name="category_id"
                                           value="85" >
                                    <span></span>
                                </label>
                                <span class="l-child">Health &amp; Beauty, Hair</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat86">
                                    <input type="radio" id="cat86" name="category_id"
                                           value="86" >
                                    <span></span>
                                </label>
                                <span class="l-child">Automobiles &amp; Motorcycles</span>
                            </li>
                            <li id="parent94">                            <label class="plx__radio" for="cat94">
                                <input type="radio" id="cat94" name="category_id"
                                       value="94" >
                                <span></span>
                            </label>
                            <a href="#child94"> Women</a>
                            <ul id="child94">                            <li>
                                <label class="plx__radio" for="cat103">
                                    <input type="radio" id="cat103" name="category_id"
                                           value="103" >
                                    <span></span>
                                </label>
                                <span class="l-child">b-tops</span>
                            </li>
                                                        <li>
                                <label class="plx__radio" for="cat105">
                                    <input type="radio" id="cat105" name="category_id"
                                           value="105" >
                                    <span></span>
                                </label>
                                <span class="l-child">Leggings</span>
                            </li>
                            </ul></li></ul>
                            <label class="error"></label>

                        </div>

                        <div class="form-group">
                            <label>Add Image</label>
                            <div class="slim" style="width: 100%;"
                                 data-ratio="1:1"
                                 data-size="400,400"
                                 data-push="true"
                                 data-service="https://199.192.26.175/parallaxcart/admin/upload-image" id="my-cropper">
                                <input type="file" required/>
                                                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <hr>
                        <div class="form-actions text-right">
                            <button type="button" class="btn default">Cancel</button>
                            <button type="button" class="btn blue">Create Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://199.192.26.175/parallaxcart/assets/plugins/jquery_validation/jquery.js"></script>
    <script src="https://199.192.26.175/parallaxcart/assets/plugins/jquery_validation/jquery.validate.js"></script>



    <script>
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#addProductForm").validate({
                messages: {
                    product_name: "Please enter your product title",
                    product_image: "Please select an image",
                    base_price: "Please enter price",
                    weight: "Please enter product weight",
                },
                rules: {
                    category_id: {
                        required: true
                    }
                }
            });

        });
    </script>


    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 200,
                minHeight: null,
                maxHeight: null,
                focus: true
            });
        });

        $('#categoryId').on('change', function () {
            $.ajax({
                type: 'POST',
                url: "https://199.192.26.175/parallaxcart/get-sub-category",
                data: {
                    "_token": "IYUHoOn3WeUYeMPHILPNiadpgTNDIj7WMyEqqybJ",
                    "category_id": this.value
                },
                success: function (data) {
                    $("#subCategory").html(data);
                }
            });
        });

        $(document).ready(function () {
            //called when key is pressed in textbox
            $(".numeric").keypress(function (e) {
                return isFloat(e);
            });
        });

        function isFloat(evt) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            } else {
                //if dot sign entered more than once then don't allow to enter dot sign again. 46 is the code for dot sign
                var parts = evt.srcElement.value.split('.');
                if (parts.length > 1 && charCode == 46) {
                    return false;
                }
                return true;
            }
        }

        $(document).ready(function () {
            preOpen('0', '');
        });

        var locations = [];

        function checkSelected() {
        }

    </script>


    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                var isBrand = $(".is-brand"),
                    brandListWrap = $('.brand-list-wrap');

                brandList();
                $(isBrand).on("change", function () {
                    brandList();
                });

                function brandList() {
                    var checkedValue = $(".is-brand:checked").data("value");
                    if (checkedValue === 'yes') {
                        $(brandListWrap).slideDown(300);
                    } else {
                        $(brandListWrap).slideUp(300);
                    }
                }
            })

            
        }(jQuery))
    </script>

    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                var isFlash = $(".is-flash"),
                    flashWrap = $('.flash-wrap');
                flashSell();
                $(isFlash).on("change", function () {
                    flashSell();
                });

                function flashSell() {
                    var checkedValue = $(".is-flash:checked").data("value");

                    if (checkedValue === 'yes') {
                        $(flashWrap).slideDown(300);
                        $(".flash-wrap :input").prop("disabled", false);
                    } else {
                        $(flashWrap).slideUp(300);
                        $(".flash-wrap :input").prop("disabled", true);
                    }
                }
            })
        }(jQuery))
    </script>

    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                var isAdminFlash = $(".is-admin-flash"),
                    adminFlashWrap = $('.admin-flash-wrap');
                adminFlashSell();
                $(isAdminFlash).on("change", function () {
                    adminFlashSell();
                });

                function adminFlashSell() {
                    var adminCheckedValue = $(".is-admin-flash:checked").data("value");
                    if (adminCheckedValue === 'yes') {
                        $(adminFlashWrap).slideDown(300);
                        $(".admin-flash-wrap :input").prop("disabled", false);
                    } else {
                        $(adminFlashWrap).slideUp(300);
                        $(".admin-flash-wrap :input").prop("disabled", true);
                    }
                }
            })

        }(jQuery))
    </script>
    <script src="https://199.192.26.175/parallaxcart/assets/plugins/slimfit/js/slim.kickstart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script>slim_init();</script>

    <script>
        var datefrom = new Date();
        datefrom.setDate(datefrom.getDate());
        $('#datepickerfrom').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: datefrom,
        }).on('changeDate', function () {
            datefrom = $('#datepickerfrom').val();
            $('#datepickerto').datepicker().datepicker("setDate", new Date(datefrom));
        }).attr('readonly', 'readonly');

        $('#datepickerto').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: datefrom,
        }).attr('readonly', 'readonly');

    </script>

    
    <script>
        var adminDatefrom = new Date();
        adminDatefrom.setDate(adminDatefrom.getDate());
        $('#admindatepickerfrom').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: adminDatefrom,
        }).on('changeDate', function () {
            adminDatefrom = $('#admindatepickerfrom').val();
            $('#admindatepickerto').datepicker().datepicker("setDate", new Date(adminDatefrom));
        }).attr('readonly', 'readonly');

        $('#admindatepickerto').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: adminDatefrom,
        }).attr('readonly', 'readonly');

    </script>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
                    });
    </script>
    <!-- END CONTAINER -->


    <script>
        function add_required_class(ep_id) {
            if ($('#ep_id_' + ep_id).is(":checked") == true) {
                $("#form" + ep_id + " :input").addClass('required');
            } else {
                $("#form" + ep_id + " :input").removeClass('required');
            }
        }
    </script>

    <style>
        .attribute {
            margin-top: 12px;
            border: 1px solid #e3e3e3;
        }

        .attribute .attr-header {
            padding: 5px 15px;
            background-color: #e3e3e3;
        }

        .attribute .attr-body {
            padding: 10px 15px 0;
        }

        .plx__table {
            width: 100%;
        }

        .plx__table td,
        .plx__table th {
            padding: 5px 0;
        }

        #addProductForm label.error {
            width: auto;
            display: inline;
            color: red;
            /*font-style: italic;*/
        }

        .alert-required {
            color: red;
            font-style: italic;
            padding-top: 3px;
        }

    </style>
    <link rel="stylesheet" href="{{url('public/assets/plugins/slimfit/css/slim.min.css')}}">
    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.js"></script>
    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.validate.js"></script>
    <script>
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#addProductForm").validate({
                messages: {
//                    product_name: "Please enter your product title",
//                    product_image: "Please select an image",
//                    price: "Please enter price",
//                    description: "Please enter product weight",
                },
                rules: {
                    category_id: {
                        required: true
                    }
                }
            });

        });
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>


    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 200,
                minHeight: null,
                maxHeight: null,
                focus: true
            });
        });

        $(document).ready(function () {
            //called when key is pressed in textbox
            $(".numeric").keypress(function (e) {
                return isFloat(e);
            });
        });

        function isFloat(evt) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            } else {
                //if dot sign entered more than once then don't allow to enter dot sign again. 46 is the code for dot sign
                var parts = evt.srcElement.value.split('.');
                if (parts.length > 1 && charCode == 46) {
                    return false;
                }
                return true;
            }
        }
        var locations = [];
        function checkSelected() {
        }
    </script>

    <script src="{{url('public/assets/plugins/slimfit/js/slim.kickstart.min.js')}}"></script>
    <script>slim_init();</script>
@endsection