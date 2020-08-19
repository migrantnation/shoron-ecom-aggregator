@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
    <ul class="page-breadcrumb">
    <li>
        <a href="{{url('/admin')}}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Product List</span>
    </li>
    </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">Product List&nbsp;
    <small></small>

    <a href="{{url('admin').'/'.@$udc_id.'/product/create'}}" class="btn btn-info">Add New &nbsp;&nbsp;<i class="fa fa-plus"></i></a>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">All Products</span>
                    </div>

                    <div class="actions">
                        <a href="javascript:;" class="btn btn-default btn-sm">
                            Import </a>
                        <a href="javascript:;" class="btn btn-default btn-sm">
                            Export </a>
                    </div>
                </div>

                <div class="portlet-body">
                    <form action="#" class="margin-bottom-20">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <label for="">Sort by:</label>
                                        <div class="input-group">
                                            <select class="form-control">
                                                <option>Newest</option>
                                                <option>Best Seller</option>
                                                <option>Price: low to high</option>
                                                <option>Price: high to low</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-inline text-right">
                                    <div class="form-group">
                                        <label for="">Search:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control">
                                            <span class="input-group-btn">
                                            <button class="btn blue" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <span style="display: inline-block; margin-bottom: 10px;">Showing 1 to 10 of 25 records</span>

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="20">#</th>
                            <th>Product Name</th>
                            <th>Inventory</th>
                            <th>Category</th>
                            <th>Vendor</th>
                            <th width="220">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if($product_list)

                            <?php foreach($product_list as $key=>$p_value) {?>
                            <tr>
                                <td width="20">{{$key+1}}</td>
                                <td><a href="{{url('').'/'.$p_value->product_url.'/product-details'}}">{{$p_value->product_name}}</a></td>
                                <td>{{$p_value->quantity}}</td>
                                <td>{{$p_value->category_name?$p_value->category_name:'N/A'}}</td>
                                <td></td>
                                <td width="220" class="text-center">
                                    <a href="{{url('').'/'.$p_value->product_url.'/product-details'}}" class="btn purple btn-xs" target="_blank">
                                        <i class="fa fa-pencil"></i> View
                                    </a>
                                    <a href="{{url('admin').'/'.$udc_id.'/product/'.$p_value->id.'/edit'}}" class="btn blue btn-xs">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                    <a href="javascript:;" class="btn red btn-xs">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php
                            } ?>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection