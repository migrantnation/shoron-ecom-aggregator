@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('/admin')}}">{{ __('admin_text.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ __('admin_text.product-list') }}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{ __('admin_text.product-list') }}&nbsp;
        <small></small>
        <a href="{{url('udc/add-product')}}" class="btn btn-info">{{ __('admin_text.add_product') }} &nbsp;&nbsp;<i
                    class="fa fa-plus"></i></a>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">{{ __('admin_text.all-product') }}</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <form action="#" class="margin-bottom-20">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-inline text-right">
                                    <div class="form-group">
                                        <label for="">{{ __('admin_text.search') }}:</label>
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

                    <div id="render_list">
                        <span style="display: inline-block; margin-bottom: 10px;"> <strong>Showing from 1 to 5 of 10</strong></span>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th width="20" class="text-center">#</th>
            <th style="width: 28%;" class="text-center">Product Name</th>
            <th class="text-center">Inventory</th>
            <th class="text-center">Category</th>
            <th class="text-center">Status</th>
            <th style="width: 35%;" class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>

        <tr id="row_for_product_21">
            <td width="20">1</td>
            <td><a href="javascript:void(0);" target="_blank">2018 Winter Men New Long Casual Hooded Thick Cotton Parkas Jacket Men Casual Solid Pockets Outwear Warm Jackets Parka Coat Men</a></td>
            <td class="text-center">100</td>
            <td class="text-center">Jackets</td>
            <td class="text-center"><span class="status-text-21">Waiting for Approval</span></td>
            <td class="text-center">
                                    <span class="status-btn-21">
                        <a href="javascript:void(0)" data-actionfor="status" data-warningtext="Are you sure you want to change this product status?" class="btn green btn-xs product-action" data-productid="21" data-status="1">
                            Approve
                        </a>
                    </span>
                                                    <span class="status-btn-21">
                        <a href="javascript:void(0)" data-actionfor="status" data-warningtext="Are you sure you want to disapprove this product?" class="btn red btn-xs product-action" data-productid="21" data-status="4">
                            Disapprove
                        </a>
                    </span>
                                <a href="javascript:void(0);" class="btn purple btn-xs" target="_blank">
                    <i class="fa fa-eye"></i> View
                </a>
                <a href="javascript:void(0);" class="btn blue btn-xs">
                    <i class="fa fa-pencil"></i> Edit
                </a>
                <a href="javascript:void(0)" data-productid="21" data-actionfor="delete" data-warningtext="All the associated data will be deleted with deletion this product. Are you sure you want to delete this product?" class="btn red btn-xs product-action">
                    <i class="fa fa-trash-o"></i> Delete
                </a>
            </td>
        </tr>

        
        <tr id="row_for_product_20">
            <td width="20">2</td>
            <td><a href="javascript:void(0);" target="_blank">2018 New Collection Winter Women Jacket Coat Original Fur Collar Women Parkas Fashion Brand Womens Cotton Padded Jacket CY1629BK</a></td>
            <td class="text-center">200</td>
            <td class="text-center">Leggings</td>
            <td class="text-center"><span class="status-text-20">Active</span></td>
            <td class="text-center">
                                    <span class="status-btn-20">
                        <a href="javascript:void(0)" data-actionfor="status" data-warningtext="Are you sure you want to change this product status?" class="btn red btn-xs product-action" data-productid="20" data-status="4">
                            Disapprove
                        </a>
                    </span>
                                                <a href="javascript:void(0);" class="btn purple btn-xs" target="_blank">
                    <i class="fa fa-eye"></i> View
                </a>
                <a href="javascript:void(0);" class="btn blue btn-xs">
                    <i class="fa fa-pencil"></i> Edit
                </a>
                <a href="javascript:void(0)" data-productid="20" data-actionfor="delete" data-warningtext="All the associated data will be deleted with deletion this product. Are you sure you want to delete this product?" class="btn red btn-xs product-action">
                    <i class="fa fa-trash-o"></i> Delete
                </a>
            </td>
        </tr>

        
        <tr id="row_for_product_18">
            <td width="20">3</td>
            <td><a href="javascript:void(0);" target="_blank">Onemix breathable mesh running shoes for men sports sneakers for women lightweight sneakers for outdoor walking trekking shoes</a></td>
            <td class="text-center">500</td>
            <td class="text-center">Sports &amp; Outdoors</td>
            <td class="text-center"><span class="status-text-18">Waiting for Approval</span></td>
            <td class="text-center">
                                    <span class="status-btn-18">
                        <a href="javascript:void(0)" data-actionfor="status" data-warningtext="Are you sure you want to change this product status?" class="btn green btn-xs product-action" data-productid="18" data-status="1">
                            Approve
                        </a>
                    </span>
                                                    <span class="status-btn-18">
                        <a href="javascript:void(0)" data-actionfor="status" data-warningtext="Are you sure you want to disapprove this product?" class="btn red btn-xs product-action" data-productid="18" data-status="4">
                            Disapprove
                        </a>
                    </span>
                                <a href="javascript:void(0);" class="btn purple btn-xs" target="_blank">
                    <i class="fa fa-eye"></i> View
                </a>
                <a href="javascript:void(0);" class="btn blue btn-xs">
                    <i class="fa fa-pencil"></i> Edit
                </a>
                <a href="javascript:void(0)" data-productid="18" data-actionfor="delete" data-warningtext="All the associated data will be deleted with deletion this product. Are you sure you want to delete this product?" class="btn red btn-xs product-action">
                    <i class="fa fa-trash-o"></i> Delete
                </a>
            </td>
        </tr>

        
        <tr id="row_for_product_15">
            <td width="20">4</td>
            <td><a href="javascript:void(0);" target="_blank">This is for testing from merchant</a></td>
            <td class="text-center">200</td>
            <td class="text-center">Mobile Phone Accessories</td>
            <td class="text-center"><span class="status-text-15">Active</span></td>
            <td class="text-center">
                                    <span class="status-btn-15">
                        <a href="javascript:void(0)" data-actionfor="status" data-warningtext="Are you sure you want to change this product status?" class="btn red btn-xs product-action" data-productid="15" data-status="4">
                            Disapprove
                        </a>
                    </span>
                                                <a href=javascript:void(0);" class="btn purple btn-xs" target="_blank">
                    <i class="fa fa-eye"></i> View
                </a>
                <a href="javascript:void(0);" class="btn blue btn-xs">
                    <i class="fa fa-pencil"></i> Edit
                </a>
                <a href="javascript:void(0)" data-productid="15" data-actionfor="delete" data-warningtext="All the associated data will be deleted with deletion this product. Are you sure you want to delete this product?" class="btn red btn-xs product-action">
                    <i class="fa fa-trash-o"></i> Delete
                </a>
            </td>
        </tr>

        
        <tr id="row_for_product_14">
            <td width="20">5</td>
            <td><a href="javascript:void(0);" target="_blank">Sharee</a></td>
            <td class="text-center">85</td>
            <td class="text-center">Women</td>
            <td class="text-center"><span class="status-text-14">Active</span></td>
            <td class="text-center">
                                    <span class="status-btn-14">
                        <a href="javascript:void(0)" data-actionfor="status" data-warningtext="Are you sure you want to change this product status?" class="btn red btn-xs product-action" data-productid="14" data-status="4">
                            Disapprove
                        </a>
                    </span>
                                                <a href="javascript:void(0);" class="btn purple btn-xs" target="_blank">
                    <i class="fa fa-eye"></i> View
                </a>
                <a href="javascript:void(0);" class="btn blue btn-xs">
                    <i class="fa fa-pencil"></i> Edit
                </a>
                <a href="javascript:void(0)" data-productid="14" data-actionfor="delete" data-warningtext="All the associated data will be deleted with deletion this product. Are you sure you want to delete this product?" class="btn red btn-xs product-action">
                    <i class="fa fa-trash-o"></i> Delete
                </a>
            </td>
        </tr>

        
        </tbody>
    </table>
    <div class="text-right">
        <ul class="pagination">
        
                    <li class="disabled"><span>&laquo;</span></li>
        
        
                    
            
            
                                                                        <li class="active"><span>1</span></li>
                                                                                <li><a href="javascript:void(0);">2</a></li>
                                                        
        
                    <li><a href="javascript:void(0);" rel="next">&raquo;</a></li>
            </ul>

    </div>

                </div>
            </div>
        </div>
    </div>
@endsection