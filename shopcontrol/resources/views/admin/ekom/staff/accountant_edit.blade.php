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
                <a href="{{url('admin/accountant-list')}}">{{__('_ecom__text.accountant-list')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{__('_ecom__text.accountant-details')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->

    <div class="container-alt margin-top-20">
        <a href="{{url('admin/accountant-list')}}" class=""><small class="fa fa-angle-left"></small> &nbsp;{{__('_ecom__text.back-accountant-list')}}</a>
        <h3 class="margin-top-10 margin-bottom-15">{{__('_ecom__text.accountant-overview')}}</h3>

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
                                <option value="1">{{__('_ecom__text.super-admin')}}</option>
                                <option value="2">{{__('_ecom__text.admin')}}</option>
                                <option value="3">{{__('_ecom__text.customer-support')}}</option>
                                <option value="4" selected>{{__('_ecom__text.accountant')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-default">{{__('_ecom__text.cancel')}}</button> &nbsp;
                        <button type="submit" class="btn green">{{__('_ecom__text.update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection