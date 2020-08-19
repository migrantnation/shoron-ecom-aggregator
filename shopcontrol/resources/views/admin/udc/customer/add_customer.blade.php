@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{ __('admin_text.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ __('admin_text.add-customer') }}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <a href="{{route('udc.customerList')}}" class="">
            <small class="fa fa-angle-left"></small>
            &nbsp;{{ __('admin_text.customer-list') }}</a>
        <h3 class="margin-top-10 margin-bottom-15">{{ __('admin_text.add-customer') }}</h3>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">{{ __('admin_text.customer') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <form action="{{route('udc.storeCustomer')}}" method="post" name="addProductForm" id="addProductForm"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">{{ __('admin_text.name') }}</label>
                                <input type="text" class="form-control" name="customer_name"
                                       value="{{old('customer_name')?old('customer_name'):''}}">
                                <span class="error">{{''}}</span>
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('admin_text.address') }}</label>
                                <input type="text" class="form-control" name="customer_address"
                                       value="{{old('customer_address')?old('customer_address'):''}}">
                                <span class="error">{{''}}</span>
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('admin_text.mobile-number') }}</label>
                                <input type="text" class="form-control" name="customer_contact_number"
                                       value="{{old('customer_contact_number')?old('customer_contact_number'):''}}">
                                <span class="error">{{''}}</span>
                            </div>
                            <hr>

                        </div>
                    </div>
                    <hr>
                    <div class="form-actions text-right">
                        <a href="{{route('udc.customerList')}}" class="btn default">{{ __('admin_text.cancel') }}</a>
                        <button type="submit" class="btn blue">{{ __('admin_text.add-customer') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection