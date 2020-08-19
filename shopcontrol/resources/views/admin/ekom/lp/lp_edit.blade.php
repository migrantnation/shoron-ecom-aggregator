@extends('admin.layouts.master')
@section('content')
    {{--    {{dd()}}--}}
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin/')}}">{{__('_ecom__text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('admin/lp-list')}}">{{__('_ecom__text.lp-list')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>
                    {{@$lp->id?__('_ecom__text.edit-lp'): __('_ecom__text.add-new-lp')}}</span>
            </li>
        </ul>
    </div>

    <!-- END PAGE BAR -->

    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->

    <div class="container-alt margin-top-20">
        <a href="{{url('admin/lp-list')}}" class="">
            <small class="fa fa-angle-left"></small> &nbsp;{{__('_ecom__text.back-lp-list')}} </a>
        <h3 class="margin-top-10 margin-bottom-15">{{@$lp->id?__('_ecom__text.edit-lp'):__('_ecom__text.add-new-lp')}}</h3>

        <div class="portlet light bordered">
            <div class="portlet-body">

                @php
                    $form_url = @$lp->id? route('admin.lp.update',@$lp->id): route('admin.lp.save');
                @endphp

                <form class="row" method="post" action="{{$form_url}}" id="formID" enctype="multipart/form-data">

                    {{csrf_field()}}

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.name')}}</label>
                            <input type="text" class="form-control" name="lp_name"
                                   value="{{old('lp_name')?old('lp_name'):@$lp->lp_name}}">
                            @if ($errors->has('lp_name'))
                                <span class="alert-required">
                                        <strong>{{ $errors->first('lp_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.lp-short-code')}}</label>
                            <input type="text" class="form-control" name="lp_short_code"
                                   value="{{old('lp_short_code')?old('lp_short_code'):@$lp->lp_short_code}}">
                            <span class="alert-required">
                                <strong>{{ $errors->first('lp_short_code') }}</strong>
                            </span>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.email')}}</label>
                            <input type="email" class="form-control" name="email"
                                   value="{{old('email')?old('email'):@$lp->email}}">
                            @if ($errors->has('email'))
                                <span class="alert-required">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.password')}}</label>
                            <input type="password" class="form-control" name="password">
                            <span class="alert-required">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.confirm-password')}}</label>
                            <input type="password" class="form-control" name="password_confirmation">
                            <span class="alert-required">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.contact-person')}}</label>
                            <input type="text" class="form-control" name="contact_person"
                                   value="{{old('contact_person')?old('contact_person'):@$lp->contact_person}}">
                            @if ($errors->has('contact_person'))
                                <span class="alert-required">
                                        <strong>{{ $errors->first('contact_person') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.phone')}}</label>
                            <input type="text" class="form-control" name="contact_number"
                                   value="{{old('contact_number')?old('contact_number'):@$lp->contact_number}}">
                            @if ($errors->has('contact_number'))
                                <span class="alert-required">
                                        <strong>{{ $errors->first('contact_number') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.default-charge')}}</label>
                            <input type="number" class="form-control" name="charge"
                                   value="{{old('charge')?old('charge'):@$lp->charge}}">
                            @if ($errors->has('default_charge'))
                                <span class="alert-required">
                                        <strong>{{ $errors->first('default_charge') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.lp-commission')}}
                                <small>(%)</small>
                            </label>
                            <input type="number" step=".01" class="form-control" name="lp_commission"
                                   value="{{old('lp_commission')?old('lp_commission'):@$lp->lp_commission}}">
                            @if ($errors->has('lp_commission'))
                                <span class="alert-required">
                                        <strong>{{ $errors->first('lp_commission') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-12">
                        <hr>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.lp-url')}}</label>
                            <input type="email" class="form-control" name="lp_url"
                                   value="{{old('lp_url')?old('lp_url'):@$lp->lp_url}}">
                            <span class="alert-required">
                                <strong>{{ $errors->first('lp_url') }}</strong>
                            </span>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.place-order-api-url')}}
                                <small>(Post method) http://xyz.com</small>
                            </label>
                            <input type="url" class="form-control" name="place_order_api_url"
                                   value="{{old('place_order_api_url')?old('place_order_api_url'):@$lp->place_order_api_url}}">
                            @if ($errors->has('place_order_api_url'))
                                <span class="alert-required">
                                        <strong>{{ $errors->first('place_order_api_url') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.order-status-change-api')}}</label>
                            <input type="email" class="form-control" name="order_status_change_api"
                                   value="{{old('order_status_change_api')?old('order_status_change_api'):@$lp->order_status_change_api}}">
                            <span class="alert-required">
                                <strong>{{ $errors->first('order_status_change_api') }}</strong>
                            </span>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.api-secret')}}</label>
                            <input type="text" class="form-control" name="api_secret"
                                   value="{{old('api_secret')?old('api_secret'):@$lp->api_secret}}">
                            <span class="alert-required">
                                    <strong>{{ $errors->first('api_secret') }}</strong>
                                </span>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.api-key')}}</label>
                            <input type="text" class="form-control" name="api_key"
                                   value="{{old('api_key')?old('api_key'):@$lp->api_key}}">
                            <span class="alert-required">
                                <strong>{{ $errors->first('api_key') }}</strong>
                            </span>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.api-user-id')}}</label>
                            <input type="text" class="form-control" name="api_user_id"
                                   value="{{old('api_user_id')?old('api_user_id'):@$lp->api_user_id}}">
                            <span class="alert-required">
                                <strong>{{ $errors->first('api_user_id') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.api-password')}}</label>
                            <input type="text" class="form-control" name="api_password"
                                   value="{{old('api_password')?old('api_password'):@$lp->api_password}}">
                            <span class="alert-required">
                                <strong>{{ $errors->first('api_password') }}</strong>
                            </span>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <hr>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.address')}}</label>
                            <textarea type="text" class="form-control" name="address"
                                      rows="2">{{old('address')?old('address'):@$lp->address}}</textarea>
                            @if ($errors->has('address'))
                                <span class="alert-required">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.lp-logo')}}</label>
                            <div class="slim1" style="width: 300px;" id="my-cropper">
                                @if(@$lp->lp_logo)
                                    <img src="{{url('').'/public/content-dir/logistic_partners/'.@$lp->lp_logo}}">
                                @endif
                                <input type="file" name="lp_logo"/>
                            </div>
                            <span class="alert-required">
                                <div class="alert-required">{{$errors->first('lp_logo')}}</div>
                            </span>
                        </div>
                    </div>


                    <div class="col-md-12 text-right">
                        <button type="button" class="btn green" id="submit_form">{{__('_ecom__text.save')}}</button>
                    </div>

                </form>

                <hr>

            </div>
        </div>
    </div>


    <link rel="stylesheet" href="{{url('public/assets/plugins/slimfit/css/slim.min.css')}}">

    <script src="{{url('public/assets/plugins/slimfit/js/slim.kickstart.min.js')}}"></script>
    <script>slim_init();</script>

    <script>

        $("#submit_form").click(function (e) {
            $('form').submit();
        });

    </script>
@endsection