@extends('admin.layouts.master')
@section('content')
        <!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{url('admin')}}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{url("admin/$udc_info->id/product")}}">Udc Product</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{@$product_info?'Update Product':'Add New Product'}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->

<!-- BEGIN PAGE CONTENT-->
<div class="container-alt margin-top-20">
    <a href="{{url("admin/$udc_info->id/product")}}" class="">
        <small class="fa fa-angle-left"></small>
        &nbsp;Back product list</a>
    <h3 class="margin-top-10 margin-bottom-15">{{@$product_info?'Update Product':'Add New Product'}}</h3>

    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-dark bold uppercase">Product</span>
            </div>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#product"> Product </a>
                </li>
                <li class="{{@$product_info ? '' : "disabled"}}">
                    <a href="{{@$product_info?url('admin'.'/'.@$udc_info->id.'/product/'.@$product_info->product_url.'/manage-product-attribute'):'javascript:;'}}" disabled="disabled"> Variations </a>
                </li>
            </ul>
        </div>

        <div class="portlet-body">
            @if(@$product_info)
                <?php $form_url = url("admin/$udc_info->id/product/$product_info->id/update"); ?>
            @else
                <?php $form_url = url('admin' . '/' . $udc_id . '/product'); ?>
            @endif
            <form class="row" action="{{$form_url}}" method="post" enctype="multipart/form-data"
                  name="addProductForm" id="addProductForm">
                {!! csrf_field() !!}
                <input type="hidden" name="udc_id" value="{{@$udc_id}}">

                <div class="col-sm-8">
                    <div class="form-group">
                        <label>Product Name <span class="alert-required">*</span></label>
                        <input type="text" class="form-control" name="product_name" value="{{ old('product_name')?old('product_name'):@$product_info->product_name }}" required>
                        <label class="error">{{$errors->first('product_name')}}</label>
                    </div>

                    <div class="form-group">
                        <label>Short Description <i>(Less than or equal 160 characters)</i> <span class="alert-required">*</span></label>
                        <input type="text" class="form-control" name="short_description" value="{{ old('short_description')?old('short_description'):@$product_info->short_description }}" required>
                        <label class="error">{{$errors->first('short_description')}}</label>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="summernote">{{ old('description')?old('description'):@$product_info->description }}</textarea>
                        <label class="error">{{$errors->first('description')}}</label>
                    </div>

                    <div class="form-group">
                        <label> Product Specification </label>
                        <textarea name="product_specification" class="summernote">{{ old('product_specification')?old('product_specification'):@$product_info->product_specification }}</textarea>
                        <label class="error">{{$errors->first('product_specification')}}</label>
                    </div>


                    <div class="form-group">
                        <label>Is brand product?</label>
                        <div>
                            <label class="radio-inline"><input class="is-brand" type="radio" value="1" name="isBrand" data-value="yes">Yes</label>
                            <label class="radio-inline"><input class="is-brand" type="radio" value="0" name="isBrand" data-value="no" checked>No</label>
                        </div>

                        <div class="brand-list-wrap margin-top-10" style="display: {{@$product_info->brand_id?'block':'none'}};">
                            <ul class="brands-list scroller" style="height: 220px;" data-always-visible="1" data-rail-visible="0">

                                @forelse(@$brand_list as $each_brand)
                                    <li>
                                        <label for="brand-{{$each_brand->id}}">
                                            <input type="radio" id="brand-{{$each_brand->id}}" name="brand_id" value="{{$each_brand->id}}">
                                        <span title="{{$each_brand->brand_name}}">
                                            <img src="{{url("public/content-dir/brands/".$each_brand->image)}}" alt="{{$each_brand->brand_name}}">
                                        </span>
                                        </label>
                                    </li>
                                @empty

                                @endforelse
                            </ul>
                        </div>
                    </div>

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

                            @if(old('brand_id'))
                                $("input[value='1']").attr('checked', true);
                            $("input[value='{{old('brand_id')}}']").attr('checked', true);
                            @elseif(@$product_info->brand_id)
                                $("input[value='1']").attr('checked', true);
                            $("input[value='{{@$product_info->brand_id}}']").attr('checked', true);
                            @endif

                        }(jQuery))
                    </script>


                    <div class="form-group">
                        <label>Price <span class="alert-required">*</span></label>
                        <input type="text" class="form-control numeric" name="base_price" id="base_price" required
                               value="{{ old('base_price')?old('base_price'):@$product_info->base_price }}" placeholder="Enter price">
                        <label class="error">{{$errors->first('base_price')}}</label>
                    </div>


                    <div class="form-group">
                        <label>Inventory <span class="alert-required">*</span></label>
                        <input type="number" class="form-control" required placeholder="Enter weight in gram"
                               name="weight" id="weight" value="{{old('weight')?old('weight'):@$product_info->weight}}">
                        <label class="error">{{$errors->first('weight')}}</label>

                        <input type="number" class="form-control margin-top-15  " required placeholder="Enter quantity "
                               name="quantity" id="quantity" value="{{old('quantity')?old('quantity'):@$product_info->quantity}}"
                                {{@$product_info->product_attributes?'readonly':''}}>

                        <label class="text-info margin-top-10">{{$errors->first('quantity')}}
                            {{@$product_info->product_attributes?'Enter product quantity in variations':''}}
                        </label>
                    </div>


                    <div class="form-group">
                        <label>Store Name <span class="alert-required">*</span></label>
                        <input type="text" class="form-control" required placeholder="Enter weight in gram"
                               name="store_name" id="store_name" value="{{old('store_name')?old('store_name'):@$product_info->store_name}}">
                        <label class="error">{{$errors->first('store_name')}}</label>
                    </div>

                    <div class="form-group">
                        <label>Ep Url <span class="alert-required">*</span></label>
                        <input type="text" class="form-control" required placeholder="Enter weight in gram"
                               name="store_url" id="store_url" value="{{old('store_url')?old('store_url'):@$product_info->store_url}}">
                        <label class="error">{{$errors->first('store_url')}}</label>
                    </div>

                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="clearfix" style="display: block; margin-bottom: 7px">
                            <a href="#" id="expandToggle" class="pull-right">Expand All</a>
                            Category
                        </label>

                        <?php
                        $first = '';
                        function show_tree($category_tree, $child_counter = 0, $category_id)
                        {
                        if ($child_counter == 0) {
                            echo '<ul id="plx__tree" class="scroller" style="height: 220px;" data-always-visible="1" data-rail-visible="0">';
                        } else {
                            echo '<ul id="child' . $child_counter . '">';
                        }
                        foreach ($category_tree as $key => $value) {
                        if (!empty($value['children'])) {
                        echo '<li id="parent' . $value['id'] . '">';
                        ?>
                        <label class="plx__radio" for="cat{{$value['id']}}">
                            <input type="radio" id="cat{{$value['id']}}" name="category_id"
                                   value="{{$value['id']}}" {{$value['id'] == $category_id ? 'checked' : ''}}>
                            <span></span>
                        </label>
                        <a href="#child{{$value['id']}}"> {{$value['category_name']}}</a>
                        <?php
                        show_tree($value['children'], $value['id'], $category_id);
                        echo '</li>';
                        } else {
                        ?>
                        <li>
                            <label class="plx__radio" for="cat{{$value['id']}}">
                                <input type="radio" id="cat{{$value['id']}}" name="category_id"
                                       value="{{$value['id']}}" {{$value['id'] == $category_id ? 'checked' : ''}}>
                                <span></span>
                            </label>
                            <span class="l-child">{{$value['category_name']}}</span>
                        </li>
                        <?php
                        }
                        }
                        echo '</ul>';
                        }

                        show_tree($category_tree, 0, $category_id);
                        ?>

                        <label class="error">{{$errors->first('category_id')}}</label>

                    </div>

                    <div class="form-group">
                        <label>Add Image</label>
                        <div class="slim" style="width: 100%;"
                             data-ratio="1:1"
                             data-size="400,400"
                             data-service="{{url('admin/upload-image')}}" id="my-cropper"> {{--assets/plugins/slimfit/async.php--}}

                            <input type="file" {{@$product_info?'':'required'}}/>
                            @if(@$product_info->product_image)
                                <?php $product_image = url('public/content-dir/stores/' . $udc_info->store->store_url . '/products/' . $product_info->product_url . '/' . $product_info->product_image);?>
                                <img src="{{@$product_image}}" alt="Product Image"/>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <hr>
                    <div class="form-actions text-right">
                        <button type="button" class="btn default">Cancel</button>
                        <button type="submit" class="btn blue">{{@$product_info?'Update Product':'Create Product'}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
        font-style: italic;
    }

    .alert-required {
        color: red;
        font-style: italic;
        padding-top: 3px;
    }

</style>
<link rel="stylesheet" href="{{url('assets/plugins/slimfit/css/slim.min.css')}}">
<script src="{{url('assets/plugins/jquery_validation')}}/jquery.js"></script>
<script src="{{url('assets/plugins/jquery_validation')}}/jquery.validate.js"></script>
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
            url: "{{url('get-sub-category')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "category_id": this.value
            },
            success: function (data) {
                $("#subCategory").html(data);
            }
        });
    })


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
        preOpen('{{$main_parent}}', '{{$category_id}}');
    });


    var locations = [];
    function checkSelected() {

    }


</script>

<script src="{{url('assets/plugins/slimfit/js/slim.kickstart.min.js')}}"></script>
<script>slim_init();</script>
@endsection