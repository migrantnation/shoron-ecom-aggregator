@extends('admin.layouts.master')
@section('content')
    <h3 class="page-title">
        All Orders <small></small>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-diamond"></i>
                <a href="#{{--udc-management.php--}}">Orders</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                All Orders
            </li>
        </ul>
    </div>
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
                    <a href="#">
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
            <div class="tabbable-line boxless tabbable-reversed">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_0" data-toggle="tab"> All Order </a>
                    </li>
                    <li>
                        <a href="#tab_1" data-toggle="tab"> Recent Order </a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab"> Confirm Order </a>
                    </li>
                    <li>
                        <a href="#tab_3" data-toggle="tab"> Delivered Order </a>
                    </li>
                </ul>
                <div class="tab-content" style="background-color: #F4F6F8">
                    <div class="tab-pane active" id="tab_0">
                        <div class="col-md-12">
                            <div class="portlet box purple">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-users"></i> All Orders
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    <form action="#" class="table-toolbar">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control">
                                                <span class="input-group-btn">
                                        <button class="btn blue" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                            </div>
                                        </div>
                                    </form>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th width="20">
                                                #
                                            </th>
                                            <th>
                                                Order
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Customer
                                            </th>
                                            <th>
                                                Payment Status
                                            </th>
                                            <th>
                                                Fullfillment Status
                                            </th>
                                            <th>
                                                Total
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
                                                <a href="#">1021</a>
                                            </td>
                                            <td>
                                                Mar 20, 11:43pm SST
                                            </td>
                                            <td>
                                                Mushfiq Niloy
                                            </td>
                                            <td>
                                                <span class="label label-sm label-success">Paid</span>
                                            </td>
                                            <td>
                                                <span class="label label-sm label-danger">Unfulfilled</span>
                                            </td>
                                            <td>
                                                $211
                                            </td>
                                            <td width="220" class="text-center">

                                                <a href="javascript:;" class="btn blue btn-xs">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <a href="javascript:;" class="btn red btn-xs">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        } ?>
                                        </tbody>
                                    </table>

                                    <div class="text-right">
                                        <ul class="pagination">
                                            <li class="prev disabled"><a href="#" title="First"><i class="fa fa-angle-double-left"></i></a></li>
                                            <li class="prev disabled"><a href="#" title="Prev"><i class="fa fa-angle-left"></i></a></li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li class="next"><a href="#" title="Next"><i class="fa fa-angle-right"></i></a></li>
                                            <li class="next"><a href="#" title="Last"><i class="fa fa-angle-double-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_1">
                        <div class="col-md-12">
                            <div class="portlet box purple">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-users"></i> Recent Orders
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    <form action="#" class="table-toolbar">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control">
                                                <span class="input-group-btn">
                                        <button class="btn blue" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                            </div>
                                        </div>
                                    </form>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th width="20">
                                                #
                                            </th>
                                            <th>
                                                Order
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Customer
                                            </th>
                                            <th>
                                                Payment Status
                                            </th>
                                            <th>
                                                Fullfillment Status
                                            </th>
                                            <th>
                                                Total
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
                                                <a href="#">2015</a>
                                            </td>
                                            <td>
                                                April 20, 11:43pm SST
                                            </td>
                                            <td>
                                                Samsul Bhai
                                            </td>
                                            <td>
                                                <span class="label label-sm label-success">Paid</span>
                                            </td>
                                            <td>
                                                <span class="label label-sm label-danger">Unfulfilled</span>
                                            </td>
                                            <td>
                                                $211
                                            </td>
                                            <td width="220" class="text-center">

                                                <a href="javascript:;" class="btn blue btn-xs">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <a href="javascript:;" class="btn red btn-xs">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        } ?>
                                        </tbody>
                                    </table>

                                    <div class="text-right">
                                        <ul class="pagination">
                                            <li class="prev disabled"><a href="#" title="First"><i class="fa fa-angle-double-left"></i></a></li>
                                            <li class="prev disabled"><a href="#" title="Prev"><i class="fa fa-angle-left"></i></a></li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li class="next"><a href="#" title="Next"><i class="fa fa-angle-right"></i></a></li>
                                            <li class="next"><a href="#" title="Last"><i class="fa fa-angle-double-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="col-md-12">
                            <div class="portlet box purple">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-users"></i> Confirmed Orders
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    <form action="#" class="table-toolbar">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control">
                                                <span class="input-group-btn">
                                        <button class="btn blue" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                            </div>
                                        </div>
                                    </form>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th width="20">
                                                #
                                            </th>
                                            <th>
                                                Order
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Customer
                                            </th>
                                            <th>
                                                Payment Status
                                            </th>
                                            <th>
                                                Fullfillment Status
                                            </th>
                                            <th>
                                                Total
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
                                                <a href="#">1021</a>
                                            </td>
                                            <td>
                                                Mar 20, 11:43pm SST
                                            </td>
                                            <td>
                                                Mushfiq Niloy
                                            </td>
                                            <td>
                                                <span class="label label-sm label-success">Paid</span>
                                            </td>
                                            <td>
                                                <span class="label label-sm label-danger">Unfulfilled</span>
                                            </td>
                                            <td>
                                                $211
                                            </td>
                                            <td width="220" class="text-center">

                                                <a href="javascript:;" class="btn blue btn-xs">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <a href="javascript:;" class="btn red btn-xs">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        } ?>
                                        </tbody>
                                    </table>

                                    <div class="text-right">
                                        <ul class="pagination">
                                            <li class="prev disabled"><a href="#" title="First"><i class="fa fa-angle-double-left"></i></a></li>
                                            <li class="prev disabled"><a href="#" title="Prev"><i class="fa fa-angle-left"></i></a></li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li class="next"><a href="#" title="Next"><i class="fa fa-angle-right"></i></a></li>
                                            <li class="next"><a href="#" title="Last"><i class="fa fa-angle-double-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_3">
                        <div class="col-md-12">
                            <div class="portlet box purple">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-users"></i> Delivered Orders
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    <form action="#" class="table-toolbar">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control">
                                                <span class="input-group-btn">
                                        <button class="btn blue" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                            </div>
                                        </div>
                                    </form>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th width="20">
                                                #
                                            </th>
                                            <th>
                                                Order
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Customer
                                            </th>
                                            <th>
                                                Payment Status
                                            </th>
                                            <th>
                                                Fullfillment Status
                                            </th>
                                            <th>
                                                Total
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
                                                <a href="#">1021</a>
                                            </td>
                                            <td>
                                                Mar 20, 11:43pm SST
                                            </td>
                                            <td>
                                                Mushfiq Niloy
                                            </td>
                                            <td>
                                                <span class="label label-sm label-success">Paid</span>
                                            </td>
                                            <td>
                                                <span class="label label-sm label-danger">Unfulfilled</span>
                                            </td>
                                            <td>
                                                $211
                                            </td>
                                            <td width="220" class="text-center">

                                                <a href="javascript:;" class="btn blue btn-xs">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <a href="javascript:;" class="btn red btn-xs">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        } ?>
                                        </tbody>
                                    </table>

                                    <div class="text-right">
                                        <ul class="pagination">
                                            <li class="prev disabled"><a href="#" title="First"><i class="fa fa-angle-double-left"></i></a></li>
                                            <li class="prev disabled"><a href="#" title="Prev"><i class="fa fa-angle-left"></i></a></li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li class="next"><a href="#" title="Next"><i class="fa fa-angle-right"></i></a></li>
                                            <li class="next"><a href="#" title="Last"><i class="fa fa-angle-double-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection