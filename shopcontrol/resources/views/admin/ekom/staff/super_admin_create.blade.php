@extends('admin.layouts.master')
@section('content')

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin/')}}">{{__('_ecom__text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('admin/super-admin-list')}}">{{__('_ecom__text.super-admin-list')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{__('_ecom__text.add-new-super-admin')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->

    <div class="container-alt margin-top-20">
        <a href="{{url('admin/super-admin-list')}}" class=""><small class="fa fa-angle-left"></small> &nbsp;{{__('_ecom__text.back-super-admin-list')}}</a>
        <h3 class="margin-top-10 margin-bottom-15">{{__('_ecom__text.add-new-super-admin')}}</h3>

        <div class="portlet light bordered">
            <div class="portlet-body">
                <form class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.first-name')}}</label>
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.last-name')}}</label>
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.email')}}</label>
                            <input type="email" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.phone')}}</label>
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.password')}}</label>
                            <input type="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.confirm-password')}}</label>
                            <input type="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.role')}}</label>
                            <select name="group" class="form-control">
                                <option value="1" selected>{{__('_ecom__text.super-admin')}}</option>
                                <option value="2">{{__('_ecom__text.admin')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-default">{{__('_ecom__text.cancel')}}</button> &nbsp;
                        <button type="submit" class="btn green">{{__('_ecom__text.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection