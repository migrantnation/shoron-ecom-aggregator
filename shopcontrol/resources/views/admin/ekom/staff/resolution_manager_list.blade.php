@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{__('_ecom__text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{__('_ecom__text.resolution-manager-list')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{__('_ecom__text.resolution-manager-list')}}
        <small></small>

        <a href="{{url('admin/resolution-manager/create')}}" class="btn btn-info">{{__('_ecom__text.add-new')}} &nbsp;&nbsp;<i class="fa fa-plus"></i></a>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">{{__('_ecom__text.all-resolution-manager')}}</span>
                    </div>

                    <div class="actions">
                        <a href="javascript:;" class="btn btn-default btn-sm">
                            {{__('_ecom__text.import')}} </a>
                        <a href="javascript:;" class="btn btn-default btn-sm">
                            {{__('_ecom__text.export')}} </a>
                    </div>
                </div>

                <div class="portlet-body">
                    <form class="form-inline text-right">
                        <div class="form-group">
                            <label for="">{{__('_ecom__text.search')}}:</label>
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <span class="input-group-btn">
                            <button class="btn blue" type="button"><i class="fa fa-search"></i></button>
                        </span>
                            </div>
                        </div>
                    </form>

                    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => 25, "from"=> 1, "to"=>10])}}</span>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="20">
                                #
                            </th>
                            <th>
                                {{__('_ecom__text.id')}}
                            </th>
                            <th>
                                {{__('_ecom__text.name')}}
                            </th>
                            <th>
                                {{__('_ecom__text.role')}}
                            </th>
                            <th width="220">
                                {{__('_ecom__text.actions')}}
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
                                <a href="#">1234502</a>
                            </td>
                            <td>
                                Rahim Uddin
                            </td>
                            <td>
                                Resolution Manager
                            </td>
                            <td width="180" class="text-center">
                                <a href="{{url('admin/resolution-manager/edit')}}" class="btn blue btn-xs">
                                    <i class="fa fa-pencil"></i> {{__('_ecom__text.edit')}}
                                </a>
                                <a href="javascript:;" class="btn red btn-xs">
                                    <i class="fa fa-trash-o"></i> {{__('_ecom__text.delete')}}
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