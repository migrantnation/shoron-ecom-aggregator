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
                <span>{{ __('admin_text.add-seller') }}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <a href="{{route('udc.sellerList')}}" class="">
            <small class="fa fa-angle-left"></small>
            &nbsp;{{ __('admin_text.seller-list') }}</a>
        <h3 class="margin-top-10 margin-bottom-15">{{ __('admin_text.add-seller') }}</h3>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">{{ __('admin_text.seller') }}</span>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            {{--<li>{{ $error }}</li>--}}
                            <p class="text-center">{{$error}}</p>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="portlet-body">
                <form action="{{route('udc.storeSeller')}}" method="post" name="addProductForm" id="addProductForm"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">{{ __('admin_text.name') }}</label>
                                <input type="text" class="form-control" name="seller_name"
                                       value="{{old('seller_name')?old('seller_name'):''}}">
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('admin_text.address') }}</label>
                                <input type="text" class="form-control" name="seller_address"
                                       value="{{old('seller_address')?old('seller_address'):''}}">
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('admin_text.mobile-number') }}</label>
                                <input type="text" class="form-control" name="seller_contact_number"
                                       value="{{old('seller_contact_number')?old('seller_contact_number'):''}}">
                            </div>
                            <hr>

                        </div>
                    </div>
                    <hr>
                    <div class="form-actions text-right">
                        <a href="{{route('udc.sellerList')}}" class="btn default">{{ __('admin_text.cancel') }}</a>
                        <button type="submit" class="btn blue">{{ __('admin_text.add-seller') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection