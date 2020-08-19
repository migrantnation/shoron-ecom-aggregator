@extends('admin.layouts.master')
@section('content')
    <h3 class="page-title">
        All Products <small></small>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-diamond"></i>
                <a href="udc-management.php">Products</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                All Products
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
        </div>
    </div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box purple">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-users"></i> All Products
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
                                Product Name
                            </th>
                            <th>
                                Inventory
                            </th>
                            <th>
                                Type
                            </th>
                            <th>
                                Vendor
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
                                <a href="#">Test Product</a>
                            </td>
                            <td>
                                10
                            </td>
                            <td>
                                Test
                            </td>
                            <td>
                                Test Vendor
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
@endsection