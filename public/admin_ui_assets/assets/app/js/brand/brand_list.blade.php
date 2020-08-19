@extends('admin.layouts.master')
@section('content')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>

        $(document).ready(function () {
            re_order();
        });
        function re_order() {
            $("#list ul").sortable({
                opacity: 0.8, cursor: 'move', update: function () {
                    var order = $(this).sortable("serialize") + '&update=update';
                    var url = '{{url('admin/sorting-category')}}';
                    $.post(url, order, function (theResponse) {
                    });
                }
            });
        }
    </script>

    <style>
        ul {
            padding: 0px;
            margin: 0px;
        }

        #response {
            padding: 10px;
            background-color: grey;
            border: 2px solid #396;
            margin-bottom: 20px;
        }

        #list li {
            background-color: #efefef;
            padding: 8px 15px;
            list-style: none;
            cursor: move;
            display: table;
            width: 100%;
            border-bottom: 2px solid #fff;
        }

        #list li:nth-child(2n + 2) {
            background-color: #e9e9e9;
        }

        #list li:last-child {
            border-bottom: 0 none;
        }

        #list li .col {
            display: table-cell;
            width: 33.3333333333%;
        }
    </style>

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="./">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Brand List</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">Brand List</h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="container-alt margin-top-20">

        <h3 class="margin-top-10 margin-bottom-15">{{@$brand_info?'Update Brand':'Add New Brand'}}</h3>

        <div class="portlet light bordered">


            <div class="portlet-body">
                @if(@$brand_info)
                    <?php $form_url = url("admin/brand/$brand_info->id"); ?>
                @else
                    <?php $form_url = url('admin/brand'); ?>
                @endif
                <form class="row" action="{{$form_url}}" method="post" enctype="multipart/form-data"
                      name="addProductForm" id="addProductForm">
                    {!! csrf_field() !!}
                    <input type="hidden" name="udc_id" value="{{@$udc_id}}">

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Brand Name <span class="alert-required">*</span></label>
                            <input type="text" class="form-control" name="brand_name" value="{{ old('brand_name')?old('brand_name'):@$brand_info->brand_name }}" required>
                            <label class="error">{{$errors->first('brand_name')}}</label>
                        </div>
                    </div>

                    {{--<div class="col-sm-12"></div>--}}
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Add Image</label>
                            <div class="slim" style="width: 50%;"
                                 {{--data-ratio="1:1"--}}
                                 data-size="400,400"
                                 data-service="{{url('admin/upload-image')}}" id="my-cropper"> {{--assets/plugins/slimfit/async.php--}}

                                <input type="file" {{@$brand_info?'':'required'}}/>
                                @if(@$brand_info->image)
                                    <?php $brand_image = url("content-dir/brands/$brand_info->image");?>
                                    <img src="{{@$brand_image}}" alt="Brand Image"/>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <hr>
                        <div class="form-actions text-right">
                            <button type="submit" class="btn blue">{{@$brand_info?'Update Brand':'Add Brand'}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box purple">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=""></i> Brand List
                    </div>
                </div>

                <div class="portlet-body">
                    @if(count($brand_list) > 0)
                        <form action="#" class="table-toolbar" id="sortingForm">
                            <div class="row">
                                <div class="col-sm-6 col-offset-sm-6 pull-right">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search_category_name">
                                        <span class="input-group-btn">
                                        <button class="btn blue" type="button" onclick="master_ajax(4, 0)"><i
                                                    class="fa fa-search"></i></button>
                                    </span>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 20%;">
                                    Brand Name
                                </th>
                                <th style="width: 40%;">
                                    Brand Image
                                </th>
                                <th style="width: 20%;text-align: center;">
                                    Status
                                </th>
                                <th width="220" style="text-align: center;">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    @else
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div id="list">
                                <?php if (!empty($brand_list)): ?>
                                <?php
                                $status_array = array(
                                        '1' => 'Active',
                                        '2' => 'Inactive',
                                        '-1' => 'Uncategorized',
                                );
                                ?>
                                <ul>
                                    <?php foreach ($brand_list as $key => $eachbrand): ?>
                                    <li id="arrayorder_<?php echo $eachbrand['id'] ?>">
                                        <span class="col" style="width: 20%;">{{@$eachbrand['brand_name']}}</span>
                                        <span class="col" style="width: 40%;">
                                            <?php $image = "content-dir/brands/" . $eachbrand['image'];?>
                                            <img src="{{url($image)}}" width="80">
                                        </span>
                                        <span class="col"
                                              style="width: 20%;text-align: center;"><?php echo $status_array[$eachbrand['status']];?></span>
                                        <span class="col text-right">
                                            <a href="{{url('admin/brand'). '/'.@$eachbrand['id'].'/edit'}}"
                                               class="btn blue btn-xs">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a href="javascript:void(0)"
                                               onclick="customize_category({{@$eachbrand['id']}})"
                                               class="btn red btn-xs">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                            </span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                <h3 style="color: red; text-align: center;color: #555555;"> NO RESULT FOUND</h3>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#sortingForm").submit(function (e) {
            master_ajax(4, 0);
            return false;
        });
    </script>

    <script>
        function master_ajax(tracking_id, selected_id) {
            division = $('#division option:selected').val();
            district = $('#district option:selected').val();
            upazilla = $('#upazilla option:selected').val();
            //get all the category of division value '0'
            if (tracking_id == 1) {
                district = 0;
                upazilla = 0;
            }
            //get all the category of district value '0'
            else if (tracking_id == 2) {
                upazilla = 0;
            }
            //get all the category of by keyword search
            else if (tracking_id == 4) {
                division = division;
                district = district;
                upazilla = upazilla;
            }
            var category_name = $('#search_category_name').val();
            $.ajax({
                type: 'POST',
                url: "{{url('admin/get-master')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "division": division,
                    "district": district,
                    "upazilla": upazilla,
                    "tracking_id": tracking_id,
                    "category_name": category_name,
                },
                success: function (data) {
                    obj = JSON.parse(data);
                    if (tracking_id == 1) {
                        $("#district").html(obj.response.location_view);
                        $("#upazilla").html('<option value="0">--উপজেলা--</option>');
                        $("#list").html(obj.response.category_view);
                        re_order();
                    }
                    else if (tracking_id == 2) {
                        $("#upazilla").html(obj.response.location_view);
                        $("#list").html(obj.response.category_view);
                        re_order();
                    }
                    else if (tracking_id == 3 || tracking_id == 4) {
                        //$("#district").html(obj.response.district_view);
                        $("#list").html(obj.response.category_view);
                        re_order();
                    }
                }
            });
        }
    </script>

    <script>
        function customize_category(Category_id) {
            document.getElementById('category_customize_form').action = '{{url('admin/customize-category/')}}' + '/' + Category_id;
            $('#category_customize').modal('show');
        }
    </script>

    <!-- Delete Modal -->
    <div class="modal fade" id="category_customize" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form method="post" action="" id="category_customize_form">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">Category Customization</h4>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li style="list-style: none;">
                                <input checked type="radio" name="customize_condition" value="1"> Move into another
                                category
                            </li>
                            <li style="list-style: none;">
                                <input type="radio" name="customize_condition" value="2"> Make it uncategorized
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Next</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="{{url('assets/plugins/slimfit/css/slim.min.css')}}">
    <script src="{{url('assets/plugins/slimfit/js/slim.kickstart.min.js')}}"></script>
    <script>slim_init();</script>
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
@endsection