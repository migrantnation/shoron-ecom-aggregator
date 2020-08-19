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
                <a href="{{url('admin/lp-list')}}">{{__('_ecom__text.lp-list')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{__('_ecom__text.add-new-lp')}}</span>
            </li>
        </ul>
    </div>

    <!-- END PAGE BAR -->
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->

    <div class="container-alt margin-top-20">
        <a href="{{url('admin/lp-list')}}" class="">
            <small class="fa fa-angle-left"></small> {{__('_ecom__text.back-lp-list')}}</a>
        <h3 class="margin-top-10 margin-bottom-15">{{__('_ecom__text.add-new-lp')}}</h3>

        <div class="portlet light bordered">
            <div class="portlet-body">
                <form class="row" method="post" action="{{route('admin.lp.save')}}">
                    {{csrf_field()}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.name')}}</label>
                            <input type="text" class="form-control" name="lp_name"
                                   value="{{old('lp_name')?old('lp_name'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('lp_name') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.lp-code')}}</label>
                            <input type="text" class="form-control" name="lp_code"
                                   value="{{old('lp_code')?old('lp_code'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('lp_code') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.lp-short-code')}}</label>
                            <input type="text" class="form-control" name="lp_short_code"
                                   value="{{old('lp_short_code')?old('lp_short_code'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('lp_short_code') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.lp-url')}}</label>
                            <input type="email" class="form-control" name="lp_url"
                                   value="{{old('lp_url')?old('lp_url'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('lp_url') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.order-status-change-api')}}</label>
                            <input type="email" class="form-control" name="order_status_change_api"
                                   value="{{old('order_status_change_api')?old('order_status_change_api'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('order_status_change_api') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.email')}}</label>
                            <input type="email" class="form-control" name="email"
                                   value="{{old('email')?old('email'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.password')}}</label>
                            <input type="password" class="form-control" name="password">
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.confirm-password')}}</label>
                            <input type="password" class="form-control" name="password_confirmation">
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.contact-person')}}</label>
                            <input type="text" class="form-control" name="contact_person"
                                   value="{{old('contact_person')?old('contact_person'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('contact_person') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.phone')}}</label>
                            <input type="text" class="form-control" name="contact_number"
                                   value="{{old('contact_number')?old('contact_number'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('contact_number') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.default-charge')}}</label>
                            <input type="number" class="form-control" name="charge"
                                   value="{{old('charge')?old('charge'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('charge') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.lp-commission')}}
                                <small>(%)</small>
                            </label>
                            <input type="number" step=".01" class="form-control" name="lp_commission"
                                   value="{{old('lp_commission')?old('lp_commission'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('lp_commission') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.place-order-api-url')}}
                                <small>(Post)</small>
                            </label>
                            <input type="url" class="form-control" name="place_order_api_url"
                                   value="{{old('place_order_api_url')?old('place_order_api_url'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('place_order_api_url') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.access-token')}}</label>
                            <input type="text" class="form-control" name="access_token"
                                   value="{{old('access_token')?old('access_token'):''}}">
                            <span class="help-block">
                                    <strong>{{ $errors->first('access_token') }}</strong>
                                </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.api-secret')}}</label>
                            <input type="text" class="form-control" name="api_secret"
                                   value="{{old('api_secret')?old('api_secret'):''}}">
                            <span class="help-block">
                                    <strong>{{ $errors->first('api_secret') }}</strong>
                                </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.api-key')}}</label>
                            <input type="text" class="form-control" name="api_key"
                                   value="{{old('api_key')?old('api_key'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('api_key') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.api-user-id')}}</label>
                            <input type="text" class="form-control" name="api_user_id"
                                   value="{{old('api_user_id')?old('api_user_id'):''}}">
                            <span class="help-block">
                                <strong>{{ $errors->first('api_user_id') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.api-password')}}</label>
                            <input type="text" class="form-control" name="api_password"
                                   value="{{old('api_password')?old('api_password'):''}}">
                            <span class="help-block">
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
                            <textarea type="text" class="form-control" name="address" rows="2"></textarea>
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('_ecom__text.lp-logo')}}</label>
                            <div class="slim" style="width: 300px;" id="my-cropper">
                                <input type="file" name="lp_logo"/>
                            </div>
                            <span class="help-block">
                                <div class="alert-required">{{$errors->first('lp_logo')}}</div>
                            </span>
                        </div>
                    </div>


                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn green" id="submit_form">{{__('_ecom__text.save')}}</button>
                    </div>
                </form>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>{{__('_ecom__text.packages')}}</label><br/>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search_string"
                                                   value="{{@$_GET['search_string'] ? @$_GET['search_string'] : ""}}">
                                            <span class="input-group-btn">
                                                <button class="btn blue" type="button" id="btn_search_location"
                                                        onclick="ajaxpush();">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="overlay-wrap" id="package-overlay-wrap">
                                <div class="anim-overlay">
                                    <div class="spinner">
                                        <div class="bounce1"></div>
                                        <div class="bounce2"></div>
                                        <div class="bounce3"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="package_list">
                                @include("admin.ekom.lp.package_list")
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <style>
        .attribute {
            margin-top: 12px;
            border: 1px solid #e3e3e3;
        }

        .attribute .attr-header {
            padding: 5px 15px;
            background-color: #e3e3e3;
        }

        .attribute .attr-body {
            padding: 10px 15px 0;
        }

        .plx__table {
            width: 100%;
        }

        .plx__table td,
        .plx__table th {
            padding: 5px 0;
        }

        #addProductForm label.error {
            width: auto;
            display: inline;
            color: red;
            font-style: italic;
        }

        .alert-required {
            color: red;
            font-style: italic;
            padding-top: 3px;
        }
    </style>
    <link rel="stylesheet" href="{{url('public/assets/plugins/slimfit/css/slim.min.css')}}">

    <script src="{{url('public/assets/plugins/slimfit/js/slim.kickstart.min.js')}}"></script>
    <script>slim_init();</script>




    <script>

        $('form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $("#submit_form").click(function (e) {
            $('form').submit();
        });


        $('#btn_search_location').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                find_location();
            }
        });

        $("#btn_search_location").click(function (e) {
            e.preventDefault();
            find_location();
        });

        function find_location() {
            var search_string = $('#search_string').val();

            $('#package_list').html('');
            $('#package-overlay-wrap').show();

            var data = {
                search_string: search_string,
                lp_id: "{{$lp->id}}",
                _token: "{{csrf_token()}}",
            }

            $.ajax({
                url: "{{url("admin/lp/package-location")}}",
                type: "post",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('#package-overlay-wrap').hide();
                    $("#package_list").html(html);
                }
            });
        }
    </script>

    <script>
        $(document).on('change', '.package-distribute', function (e) {
            var status = $('#status_range').val();
            $('#loader').show();
            var data = {
                "filter_range": filter_range,
                "status": status,
            };
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#report-render").html(html);
                    initChart();
                    $('#loader').fadeOut();
                }
            });
        });
    </script>

@endsection