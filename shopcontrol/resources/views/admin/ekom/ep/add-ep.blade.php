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
                <span>Add EP</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <a href="{{url('admin/all-ep')}}" class="">
            <small class="fa fa-angle-left"></small>
            &nbsp;Back EP list</a>
        <h3 class="margin-top-10 margin-bottom-15">Add EP</h3>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">EP</span>
                </div>
            </div>
            <div class="portlet-body">
                <form action="{{url('admin/store-ep')}}" method="post" enctype="multipart/form-data"
                      name="addProductForm" id="addProductForm">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="">EP Name</label>
                                <input type="text" class="form-control" name="ep_name"
                                       value="{{old('ep_name')}}">
                                <div class="alert-required">{{$errors->first('ep_name')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Base URL</label>
                                <input type="url" class="form-control" name="ep_url"
                                       value="{{old('ep_url')}}">
                                <div class="alert-required">
                                    {{$errors->first('ep_url')}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Product Search URL</label>
                                <input type="url" class="form-control" name="product_search_url"
                                       value="{{old('product_search_url')}}">
                                <div class="alert-required">
                                    {{$errors->first('product_search_url')}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Auth Check URL</label>
                                <input type="url" class="form-control" name="auth_check_url"
                                       value="{{old('auth_check_url')}}">
                                <div class="alert-required">
                                    {{$errors->first('auth_check_url')}}
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="">Auth Token</label>
                                <input type="text" class="form-control" name="authorization"
                                       value="{{old('authorization')}}">
                                <div class="alert-required">
                                    {{$errors->first('authorization')}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">API Key</label>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{old('api_key')}}">
                                <div class="alert-required">
                                    {{$errors->first('api_key')}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Place Order API URL</label>
                                <input type="url" class="form-control" name="place_order_api_url"
                                       value="{{old('place_order_api_url')}}">
                                <div class="alert-required">
                                    {{$errors->first('place_order_api_url')}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Add Logo</label>
                                <div class="slim" style="width: 300px;"
                                     id="my-cropper">
                                    <input type="file" name="ep_logo"/>
                                </div>
                                <div class="alert-required">{{$errors->first('ep_logo')}}</div>
                            </div>
                            <div class="form-group">
                                <label for="">email</label>
                                <input type="email" class="form-control" name="email"
                                       value="{{old('email')}}">
                                <div class="alert-required">{{$errors->first('email')}}</div>
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" class="form-control" name="address"
                                       value="{{old('address')}}">
                                <div class="alert-required">{{$errors->first('address')}}</div>
                            </div>
                            <div class="form-group">
                                <label for="">Contact Number</label>
                                <input type="text" class="form-control" name="contact_number"
                                       value="{{old('contact_number')}}">
                                <div class="alert-required">{{$errors->first('contact_number')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Contact Person</label>
                                <input type="text" class="form-control" name="contact_person"
                                       value="{{old('contact_person')}}">
                                <div class="alert-required">{{$errors->first('contact_number')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Ep Commission</label>
                                <input type="number" class="form-control" name="ep_commission" step="0.1"
                                       value="{{old('ep_commission')}}">
                                <div class="alert-required">{{$errors->first('ep_commission')}}</div>
                            </div>

                            <div class="form-group">
                                <label for="">Commission for UDC</label>
                                <input type="number" class="form-control" name="udc_commission" step="0.1"
                                       value="{{old('udc_commission')}}">
                                <div class="alert-required">{{$errors->first('ep_commission')}}</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-actions text-right">
                                <button type="button" class="btn default">Cancel</button>
                                <button type="submit" class="btn blue">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
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