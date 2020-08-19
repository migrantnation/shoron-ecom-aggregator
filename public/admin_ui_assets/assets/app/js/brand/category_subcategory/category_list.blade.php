@extends('admin.layouts.master')
@section('content')
    {{--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">--}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#list ul").sortable({
                opacity: 0.8, cursor: 'move', update: function () {
                    var order = $(this).sortable("serialize") + '&update=update';
                    var url = '{{url('admin/sorting-category')}}';
                    $.post(url, order, function (theResponse) {
                    });
                }
            });
        });
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
                <span>Category List</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">Category List</h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="table-toolbar">
        <div class="row">
            <div class="col-xs-4">
                <div class="btn-group">
                    <button class="btn">
                        Import
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn">
                        Export
                    </button>
                </div>
            </div>
            <div class="col-xs-8 text-right">
                <div class="btn-group">
                    <a href="{{url('admin/add-category')}}">
                        <button id="sample_editable_1_new" class="btn green">
                            Add New <i class="fa fa-plus"></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box purple">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=""></i> Category List
                    </div>
                </div>

                <div class="portlet-body">
                    @if(count($category_list) > 0)
                        <form action="#" class="table-toolbar" id="sortingForm">
                            <div class="row">

                                <div class="col-sm-2">
                                    <select class="form-control" id="division" onchange="master_ajax(1, this.value)">
                                        <option value="0">--বিভাগ--</option>
                                        @foreach($location_tree as $each_location)
                                            <option value="{{$each_location['id']}}">{{$each_location['location_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <select class="form-control" id="district" onchange="master_ajax(2, this.value)">
                                        <option value="0">--জেলা--</option>
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <select class="form-control" id="upazilla" onchange="master_ajax(3, this.value)">
                                        <option value="0">--উপজেলা--</option>
                                    </select>
                                </div>

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
                                    Category Name
                                </th>
                                <th style="width: 40%;">
                                    Description
                                </th>
                                <th style="width: 20%; text-align: center;">
                                    Total Sub Category
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
                                <?php if (!empty($category_list)): ?>
                                <ul>
                                    <?php foreach ($category_list as $key => $eachcategory): ?>
                                    <li id="arrayorder_<?php echo $eachcategory['id'] ?>">
                                        <span class="col" style="width: 20%;">{{@$eachcategory['category_name']}}</span>
                                        <span class="col"
                                              style="width: 40%;"><?php echo $eachcategory['description'];?></span>
                                        <span class="col"
                                              style="width: 20%;text-align: center;">{{@$eachcategory['total_child']}}</span>
                                        <span class="col text-right">
                                                @if($eachcategory['total_child'] > 0)
                                                <a href="{{url('admin/category-list'). '/'. @$eachcategory['id']}}"
                                                   class="btn green btn-xs">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="btn green btn-xs" disabled="true">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            @endif
                                            <a href="{{url('admin/edit-category'). '/'.@$eachcategory['id']}}"
                                               class="btn blue btn-xs">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a href="javascript:void(0)" onclick="customize_category({{@$eachcategory['id']}})" class="btn red btn-xs">
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
                    "parent_category_id": '{{$parent_category_id}}'
                },
                success: function (data) {
                    obj = JSON.parse(data);
                    if (tracking_id == 1) {
                        $("#district").html(obj.response.location_view);
                        $("#upazilla").html('<option value="0">--উপজেলা--</option>');
                        $("#list").html(obj.response.category_view);
                    }
                    else if (tracking_id == 2) {
                        $("#upazilla").html(obj.response.location_view);
                        $("#list").html(obj.response.category_view);
                    }
                    else if (tracking_id == 3 || tracking_id == 4) {
                        //$("#district").html(obj.response.district_view);
                        $("#list").html(obj.response.category_view);
                    }
                }
            });
        }
    </script>

    <script>
        function customize_category(Category_id){
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
                                <input checked type="radio" name="customize_condition" value="1"> Move into another category
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
@endsection