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

        <a href="{{url('add-product')}}" class="btn btn-info">Add New &nbsp;&nbsp;<i class="fa fa-plus"></i></a>
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
                            {{--<div class="col-sm-6">--}}
                                {{--<div class="form-inline">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="">Sort by:</label>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<select class="form-control">--}}
                                                {{--<option>Newest</option>--}}
                                                {{--<option>Best Seller</option>--}}
                                                {{--<option>Price: low to high</option>--}}
                                                {{--<option>Price: high to low</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="col-sm-12">
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
                            <th>EP Name &amp; Permalink</th>
                            <th>User Details</th>
                            <th width="220">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="20">1</td>
                            <td>EXCLUSIVE KAMIZ & SALWAR</td>
                            <td>
                                <p><strong>Esho.com :-</strong> <a
                                            href="#">http://esho.com/product-name</a></p>
                                <p><strong>Daraz.com :-</strong> <a
                                            href="#">http://daraz.com/product-name</a></p>
                                <p><strong>ep_partner.com :-</strong> <a
                                            href="#">http://ep_partner.com/product-name</a></p>
                            </td>
                            <td>
                                <p>Name:- <strong>Murad Parvez</strong></p>
                                <p>Address:- Jagannathpur Union, Kumarkhali, Kustia</p>
                                <p>Mobile No:- +8801XXXXXXXXX</p>
                            </td>
                            <td width="220" class="text-center">
                                <a href="#" class="btn green btn-xs">
                                    <i class="fa fa-pencil"></i> View
                                </a>
                                <a href="#" class="btn blue btn-xs">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="javascript:;" class="btn red btn-xs">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td width="20">2</td>
                            <td>EXCLUSIVE KAMIZ & SALWAR</td>
                            <td>
                                <p><strong>Esho.com :-</strong> <a
                                            href="#">http://esho.com/product-name</a></p>
                                <p><strong>Daraz.com :-</strong> <a
                                            href="#">http://daraz.com/product-name</a></p>
                                <p><strong>ep_partner.com :-</strong> <a
                                            href="#">http://ep_partner.com/product-name</a></p>
                            </td>
                            <td>
                                <p>Name:- <strong>Murad Parvez</strong></p>
                                <p>Address:- Jagannathpur Union, Kumarkhali, Kustia</p>
                                <p>Mobile No:- +8801XXXXXXXXX</p>
                            </td>
                            <td width="220" class="text-center">
                                <a href="#" class="btn green btn-xs">
                                    <i class="fa fa-pencil"></i> View
                                </a>
                                <a href="#" class="btn blue btn-xs">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="javascript:;" class="btn red btn-xs">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td width="20">3</td>
                            <td>EXCLUSIVE KAMIZ & SALWAR</td>
                            <td>
                                <p><strong>Esho.com :-</strong> <a
                                            href="#">http://esho.com/product-name</a></p>
                                <p><strong>Daraz.com :-</strong> <a
                                            href="#">http://daraz.com/product-name</a></p>
                                <p><strong>ep_partner.com :-</strong> <a
                                            href="#">http://ep_partner.com/product-name</a></p>
                            </td>
                            <td>
                                <p>Name:- <strong>Murad Parvez</strong></p>
                                <p>Address:- Jagannathpur Union, Kumarkhali, Kustia</p>
                                <p>Mobile No:- +8801XXXXXXXXX</p>
                            </td>
                            <td width="220" class="text-center">
                                <a href="#" class="btn green btn-xs">
                                    <i class="fa fa-pencil"></i> View
                                </a>
                                <a href="#" class="btn blue btn-xs">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="javascript:;" class="btn red btn-xs">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection