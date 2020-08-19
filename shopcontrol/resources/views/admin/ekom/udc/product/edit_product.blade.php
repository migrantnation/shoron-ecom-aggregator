@extends('admin.layouts.master')
@section('content')
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
                }
            });
        });
    </script>
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="./">Home</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <a href="{{url("admin/udc_profile/$udc_info->id")}}">UDC </a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <a href="{{url("admin/$udc_info->id/product/")}}">UDC Products</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <span>Edit Product</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <form action="{{url("admin/$udc_id/product".'/'.$product_info->id)}}" method="post" enctype="multipart/form-data"
          name="addProductForm" id="addProductForm">
        {!! csrf_field() !!}
        <input type="hidden" name="udc_id" value="{{@$udc_id}}">
        <!-- BEGIN PAGE TITLE-->
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title"> Edit Product
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="  col-md-8">
                <div class="portlet light bordered">
                    <div class="form-group">
                        <div class="clearfix"><label class=" control-label"><span class="alert-required">*</span>Title</label></div>
                        <input type="text" class="form-control" name="product_name" value="{{ old('product_name')?old('product_name'):$product_info->product_name }}">
                        <div class="alert-required">
                            <ul>{{$errors->first('product_name')}}</ul>
                        </div>

                        <div><p><span class="alert-required"></span>Description</p></div>
                        <div><textarea name="description" id="summernote">{{ old('description')?old('description'):$product_info->description }}</textarea></div>
                        <div class="alert-required">
                            <ul>{{$errors->first('description')}}</ul>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="portlet light bordered " style="background-color: #F5F6F7;">
                    <p><span class="alert-required">*</span>Category</p>

                    <?php $category_selected = array(old('category_id') ? old('category_id') : $product_info->category_id => 'selected');?>
                    <select class="form-control" name="category_id" id="categoryId">
                        @forelse(@$categories as $each_category)
                            <option value="{{@$each_category->id}}" {{@$category_selected[$each_category->id]}}>{{@$each_category->category_name}}</option>
                        @empty
                            <option> No Category</option>
                        @endforelse
                    </select>
                    <div class="alert-required">
                        <ul>{{$errors->first('category_id')}}</ul>
                    </div>

                    <p><span class="alert-required">*</span>Sub Category</p>
                    <?php $sub_category_selected = array(old('sub_category_id') ? old('sub_category_id') : $product_info->sub_category_id => 'selected');?>
                    <select class="form-control" name="sub_category_id" id="subCategory">
                        @forelse(@$sub_categories as $each_sub_category)
                            <option value="{{@$each_sub_category->id}}" {{@$sub_category_selected[$each_sub_category->id]}}>{{@$each_sub_category->sub_category_name}}</option>
                        @empty
                            <option> Not Found</option>
                        @endforelse
                    </select>
                    <div class="alert-required">
                        <ul>{{$errors->first('sub_category_id')}}</ul>
                    </div>
                </div>
            </div>

        </div>
        {{--THIS SECTION IS FOR IMAGE--}}

        <div class="row">
            <div class="col-md-8">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption ">
                            <span class="caption-subject bold uppercase"> Add Images</span>
                        </div>
                    </div>
                    <input type="file" name="product_image">
                    <div class="alert-required">
                        <ul>{{$errors->first('image')}}</ul>
                    </div>
                    <?php $product_image = url($product_info->product_image ? './product_images/' . $product_info->product_image : 'no-product-image.png');?>

                    <img src="{{url("$product_image")}}" width="80px">
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="portlet light bordered">
                    <div class="caption ">
                        <span class="caption-subject bold uppercase"> Pricing*</span>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 10px;">
                            <label><span class="alert-required">*</span>Price</label>
                            <input type="text" class="form-control" name="base_price" id="base_price" value="{{ old('base_price')?old('base_price'):$product_info->base_price }}">
                            <div class="alert-required">
                                <ul>{{$errors->first('base_price')}}</ul>
                            </div>
                        </div>

                        <div class="col-md-6" style="margin-bottom: 10px;"><label>Compare at price</label>
                            <input type="text" class="form-control" name="compare_price" id="compare_price" value="{{ old('compare_price')?old('compare_price'):$product_info->compare_price }}">
                        </div>
                    </div>

                    <div class="row" style="margin: 0px; margin-left: 20px;">
                        <div class="checkbox col-md-6">
                            <label><input type="checkbox" value="1" name="taxable" id="taxable">Charge taxes on this product</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="portlet light bordered">

                    <div class="caption ">
                        <span class="caption-subject bold uppercase"> Inventory </span>
                    </div>

                    <div class="row">

                        <div class="col-md-6" style="margin-bottom: 10px;">
                            <label><span class="alert-required">*</span>SKU (Stock Keeping Unit)</label>
                            <input type="text" class="form-control" name="base_sku" id="base_sku" value="{{ old('base_sku')?old('base_sku'):$product_info->base_sku }}">
                            <div class="alert-required">
                                <ul>{{$errors->first('base_sku')}}</ul>
                            </div>
                        </div>

                        <div class="col-md-6" style="margin-bottom: 10px;">
                            <label> <span class="alert-required">*</span>Weight</label>
                            <input type="number" class="form-control" name="weight" id="weight" value="{{ old('weight')?old('weight'):$product_info->weight }}">
                            <div class="alert-required">
                                <ul>{{$errors->first('weight')}}</ul>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="portlet light bordered">
                    <div class="row">
                        <div class="caption col-md-8">
                            <span class="caption-subject bold uppercase"> Attributes </span>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;" id="attributes">
                        {{--<div class="attribute col-sm-12">--}}
                        {{--<div class="attr-body">--}}
                        {{--<div class="form-group col-sm-6">--}}
                        {{--<label for="" class="control-label">Name</label>--}}
                        {{--<input type="text" class="form-control attribute_name" placeholder="Attribute Name" name="attribute_name[]">--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-sm-6">--}}
                        {{--<label>Value(s)</label>--}}
                        {{--<input type="text" value="" data-role="tagsinput" class="form-control attribute_values"--}}
                        {{--name="attribute_values[]"--}}
                        {{--placeholder="" style="width: 100%;">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="form-group">
                            <div class="caption pull-left col-md-4 "><a href="javascript:;" id="generate_variant"><span class="caption-subject uppercase"><i class="fa fa-gear"></i> Generate</span></a></div>

                            <div class="caption pull-right col-md-4 ">
                                <a id="newAttribute" href="javascript:;"><span class="caption-subject uppercase"><i class="fa fa-plus"></i> Attribute </span></a>
                            </div>
                            <div class="col-sm-12 text-center" style="padding-top: 20px;">
                                <div id="attribute_message" class=" alert-required " style="colod:red"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="form-group">
                            <div id="variations"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 text-left">
                <div class="portlet light bordered text-center">
                    <div class="row text-center">
                        <div class="col-md-12 text-center">
                            <div class="btn-group">
                                <a href="{{url("admin/$udc_id/product")}}">
                                    <button id="sample_editable_1_new" class="btn grey" type="button">
                                        Cancel
                                    </button>
                                </a>
                            </div>
                            <div class="btn-group">
                                <a href="#">
                                    <button id="sample_editable_1_new" class="btn blue">
                                        Update
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </form>

    <script>
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 200,
                minHeight: null,
                maxHeight: null,
                focus: true
            });
        });
    </script>

    <script>
        var appandedSection = function () {
            return `<div class="seefood row">
                            <div class="col-md-4">
                                <div class="">
                                    <label class=" control-label">Option name:</label>
                                    <div class="">
                                        <input type="text" class="form-control attribute_name" placeholder="Name" name="attribute_name[]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                   <div class="">
                                    <label class=" control-label">Option values:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control attribute_values"
                                        placeholder="value" data-role="tagsinput"
                                        name="attribute_values[]">
                                        <span class="input-group-btn">
                                            <button type="button" class="removeOne btn btn-danger pull-right">Remove </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                   </div>
               `;

        };

        $(document).on("click", ".removeOne", function () {
            console.log('fasfdasf');
            $(this).closest(".seefood").remove();
            set_values();
            create_variations();
        });

        $(function () {
            "use strict";
            var attribute_count = 0;
            $(document).on("click", ".removeAttr", function () {
                $(this).closest(".attribute").remove();
                attribute_count--;
                set_values();
                create_variations();
                $("#attribute_message").html("");
            });
            $(document).on("click", "#newAttribute", function (e) {
                if (attribute_count < 2) {
                    e.preventDefault();
                    var attrElement = `
                    <div class="attribute col-sm-12">
                            <a href="javascript:;" class="removeAttr pull-right">X</a>

                        <div class="attr-body">
                            <div class="form-group col-sm-6">
                                <label for="" class="control-label">Name</label>
                                <input type="text" class="form-control attribute_name" placeholder="Attribute Name"
                                        name="attribute_name[]">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="" class="control-label">Value(s)</label>
                                <input type="text" value="" data-role="tagsinput" class="form-control attribute_values" placeholder=""
                                        name="attribute_values[]">
                            </div>
                        </div>
                    </div>
                `;
                    $("#attributes").append(attrElement);
                    $('input[data-role="tagsinput"]').tagsinput('refresh');
                    attribute_count++;
                } else {
                    $("#attribute_message").html("You can create maximum <b>two attribute</b>");
                }
            })
        })
    </script>

    <script>
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

        var attribute_values = [];
        var attribute_name = [];

        $('#generate_variant').on('click', function () {
            set_values();
            create_variations();
        })

        $('.attribute_name').on('blur', function () {
            set_values();
            create_variations();
        })

        $('.attribute_values').on('change', function () {
            set_values();
            create_variations();
        });

        function set_values() {
            attribute_values = [];
            attribute_name = [];
            $('input[name^="attribute_name"]').each(function () {
                attribute_name.push($(this).val());
            });
            $('input[name^="attribute_values"]').each(function () {
                attribute_values.push($(this).val());
            });
        }

        function create_variations() {
            console.log(attribute_values);
            console.log(attribute_name);
            console.log(attribute_values[0]);
            if (attribute_name[0] !== undefined && attribute_name[0] !== null && attribute_name[0] !== ""
                    && attribute_values[0] !== undefined && attribute_values[0] !== null && attribute_values[0] !== "") {
                $.ajax({
                    type: 'POST',
                    url: "{{url('admin/product/get-attribute-variations')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "attribute_name": attribute_name,
                        "attribute_values": attribute_values
                    },
                    success: function (data) {
                        $("#variations").html(data);
                        $("#attribute_message").html("");
                    }
                });
            } else {
                $("#variations").html("");
                $("#attribute_message").html("Please enter attribute <b>Name</b> and <b>Value</b>");
            }
        }
    </script>
@endsection