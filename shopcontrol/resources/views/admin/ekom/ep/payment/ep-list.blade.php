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
                <span>LP List</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">LP List &nbsp;&nbsp;
        <small></small>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">All Logistic Partner(LP)</span>
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
                                        <label for="">Filter by:</label>
                                        <div class="input-group">
                                            <select class="form-control">
                                                <option>--Division--</option>
                                                <option>Dhaka</option>
                                                <option>Chittagong</option>
                                                <option>Khulna</option>
                                                <option>Rajshahi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select class="form-control">
                                                <option>--District--</option>
                                                <option>First Select Division</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select class="form-control">
                                                <option>--Upzilla--</option>
                                                <option>First Select Division &amp; District</option>
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
                            <th width="20">
                                #
                            </th>
                            <th>
                                LP Name
                            </th>
                            <th>
                                Contact No
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Address
                            </th>
                            <th>Total Payment</th>
                            <th width="100">
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
                                <a href="#">Pathau Ltd.</a>
                            </td>
                            <td>
                                01XXXXXXXXX
                            </td>
                            <td>
                                info@example.com
                            </td>
                            <td>
                                Shajadpur, Gulshan, Dhaka - 1212
                            </td>
                            <td>
                                30
                            </td>
                            <td width="100" class="text-center">
                                <a href="{{url('admin')}}" class="btn blue btn-xs">
                                    <i class="fa fa-eye"></i> View Payments
                                </a>
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