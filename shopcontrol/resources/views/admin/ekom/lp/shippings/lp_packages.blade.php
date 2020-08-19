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
                <span>LP Package List</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">LP Package List &nbsp;&nbsp;
        <small></small>
        <a href="{{url("admin/lp/add-shipping-package/$lp_info->lp_url")}}" class="btn btn-info">Add New &nbsp;&nbsp;<i class="fa fa-plus"></i></a>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">All Packages</span>
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
                            <th width="20">
                                #
                            </th>
                            <th>
                                Package Name
                            </th>
                            <th width="220">
                                Total Locations
                            </th>
                            <th width="">
                                Rates
                            </th>
                            <th width="220">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($package_list as $key => $each_package)
                            <tr>
                                <td width="20">
                                    {{$key +1 }}
                                </td>
                                <td>
                                    <a href="{{url('admin/lp/package-edit')}}">{{@$each_package->package_name}}</a>
                                </td>
                                <td width="220">
                                    {{count(explode(',',$each_package->to_city_ids))}}
                                </td>

                                <td width="">
                                    <table class="table table-bordered">
                                        @forelse($each_package->get_weight_price as $weight_price)
                                            <tr>
                                                <td width="50%">
                                                    {{($weight_price->min_weight)/1000}}kg - {{($weight_price->max_weight)/1000}}kg
                                                </td>
                                                <td width="50%">
                                                    <strong>TK. {{$weight_price->price}}</strong>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </table>
                                </td>

                                <td width="220" class="text-center">
                                    <div class="form-group form-group-sm">
                                        <a href="{{url("admin/lp/$lp_info->lp_url/package-edit/$each_package->id")}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="#" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection