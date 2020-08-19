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
                <span>{{@$ep_info->id?"Edit": "Add"}} EP</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <a href="{{url('admin/all-ep')}}" class="">
            <small class="fa fa-angle-left"></small>
            &nbsp;Back EP list</a>
        <h3 class="margin-top-10 margin-bottom-15">{{@$ep_info->id?"Edit": "Add"}} EP</h3>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">EP</span>
                </div>
            </div>
            <div class="portlet-body">

                @php
                    $form_url = @$ep_info->id?url('admin/update-ep'): url('admin/store-ep');
                @endphp

                <form action="{{$form_url}}" method="post" enctype="multipart/form-data"
                      name="addProductForm" id="addProductForm">

                    {{csrf_field()}}

                    @if(@$ep_info->id)
                        <input type="hidden" class="form-control" name="ep_id" value="{{@$ep_info->id}}">
                    @endif

                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="">EP Name</label>
                                <input type="text" class="form-control" name="ep_name"
                                       value="{{old('ep_name')?old('ep_name'):@$ep_info->ep_name}}">
                                <div class="alert-required">{{$errors->first('ep_name')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">EP Short Code</label>
                                <input type="text" class="form-control" name="ep_short_code"
                                       value="{{old('ep_short_code')?old('ep_short_code'):@$ep_info->ep_short_code}}">
                                <div class="alert-required">{{$errors->first('ep_short_code')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Base URL</label>
                                <input type="url" class="form-control" name="ep_url"
                                       value="{{old('ep_url')?old('ep_url'):@$ep_info->ep_url}}">
                                <div class="alert-required">{{$errors->first('ep_url')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Product Search URL</label>
                                <input type="url" class="form-control" name="product_search_url"
                                       value="{{old('product_search_url')?old('product_search_url'):@$ep_info->product_search_url}}">
                                <div class="alert-required">
                                    {{$errors->first('product_search_url')}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Auth Check URL</label>
                                <input type="url" class="form-control" name="auth_check_url"
                                       value="{{old('auth_check_url')?old('auth_check_url'):@$ep_info->auth_check_url}}">
                                <div class="alert-required">{{$errors->first('auth_check_url')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Place Order API URL</label>
                                <input type="url" class="form-control" name="place_order_api_url"
                                       value="{{old('place_order_api_url')?old('place_order_api_url'):@$ep_info->place_order_api_url}}">
                                <div class="alert-required">{{$errors->first('place_order_api_url')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Auth Token </label>
                                <input type="text" class="form-control" name="authorization"
                                       value="{{old('authorization')?old('authorization'):@$ep_info->authorization}}">
                                <div class="alert-required">
                                    {{$errors->first('authorization')}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">API Key</label>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{old('api_key')?old('api_key'):@$ep_info->api_key}}">
                                <div class="alert-required">
                                    {{$errors->first('api_key')}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Edit Logo</label>
                                <div class="slim1" style="width: 300px;"
                                     id="my-cropper1">
                                    @if(@$ep_info->ep_logo)
                                        <img src="{{url('').'/public/content-dir/ecommerce_partners/'.@$ep_info->ep_logo}}">
                                    @endif
                                    <input type="file" name="image"/>
                                </div>
                                <div class="alert-required">{{$errors->first('ep_logo')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">email</label>
                                <input type="email" class="form-control" name="email" autocomplete="false"
                                       value="{{old('email')?old('email'):@$ep_info->email}}">
                                <div class="alert-required">{{$errors->first('email')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="password" autocomplete="false">
                                <div class="alert-required">{{$errors->first('password')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" class="form-control" name="address"
                                       value="{{old('address')?old('address'):@$ep_info->address}}">
                                <div class="alert-required">{{$errors->first('address')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Contact Number</label>
                                <input type="text" class="form-control" name="contact_number"
                                       value="{{old('contact_number')?old('contact_number'):@$ep_info->contact_number}}">
                                <div class="alert-required">{{$errors->first('contact_number')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Contact Person</label>
                                <input type="text" class="form-control" name="contact_person"
                                       value="{{old('contact_person')?old('contact_person'):@$ep_info->contact_person}}">
                                <div class="alert-required">{{$errors->first('contact_person')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Ep Commission</label>
                                <input type="number" class="form-control" name="ep_commission" step="0.1"
                                       value="{{old('ep_commission')?old('ep_commission'):@$ep_info->ep_commission}}">
                                <div class="alert-required">{{$errors->first('ep_commission')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Commission for UDC</label>
                                <input type="number" class="form-control" name="udc_commission" step="0.1"
                                       value="{{old('udc_commission')?old('udc_commission'):@$ep_info->udc_commission}}">
                                <div class="alert-required">{{$errors->first('udc_commission')}}</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-actions text-right">
                                <button type="button" class="btn default">Cancel</button>
                                <button type="submit" class="btn blue">{{@$ep_info->id?"Update": "Save"}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{url('public/assets/plugins/slimfit/css/slim.min.css')}}">

    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 200,
                minHeight: null,
                maxHeight: null,
                focus: true
            });
        });

        $(document).ready(function () {
            //called when key is pressed in textbox
            $(".numeric").keypress(function (e) {
                return isFloat(e);
            });
        });

        function isFloat(evt) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            } else {
                //if dot sign entered more than once then don't allow to enter dot sign again. 46 is the code for dot sign
                var parts = evt.srcElement.value.split('.');
                if (parts.length > 1 && charCode == 46) {
                    return false;
                }
                return true;
            }
        }

        var locations = [];

        function checkSelected() {

        }


    </script>

    <script src="{{url('public/assets/plugins/slimfit/js/slim.kickstart.min.js')}}"></script>
    <script>slim_init();</script>
@endsection