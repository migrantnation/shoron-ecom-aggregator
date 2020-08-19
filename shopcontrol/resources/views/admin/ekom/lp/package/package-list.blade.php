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

        <a href="{{url('admin/lp/package-create')}}" class="btn btn-info">Add New &nbsp;&nbsp;<i class="fa fa-plus"></i></a>
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
                        <?php for($i = 1; $i < 11; $i++) {
                        ?>
                        <tr>
                            <td width="20">
                                <?= $i ?>
                            </td>
                            <td>
                                <a href="{{url('admin/lp/package-edit')}}">Package <?= $i ?></a>
                            </td>
                            <td width="220">
                                <?= rand(20, 5) ?>
                            </td>
                            <td width="">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            0kg - 10kg
                                        </td>
                                        <td>
                                            <strong>TK. 20</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            16Kg - 25Kg
                                        </td>
                                        <td>
                                            <strong>TK. 30</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            26Kg - 35Kg
                                        </td>
                                        <td>
                                            <strong>TK. 30</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            36Kg - 40Kg
                                        </td>
                                        <td>
                                            <strong>TK. 50</strong>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="220" class="text-center">
                                <div class="form-group form-group-sm">
                                    <a href="{{url('admin/lp/package-edit')}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="#" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection