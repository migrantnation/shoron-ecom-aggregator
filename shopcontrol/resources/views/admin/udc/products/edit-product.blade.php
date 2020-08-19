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
                <span>{{ __('admin_text.edit-product') }}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <a href="{{url('udc/product-list')}}" class="">
            <small class="fa fa-angle-left"></small>
            &nbsp;{{ __('admin_text.product-list') }}</a>
        <h3 class="margin-top-10 margin-bottom-15">{{ __('admin_text.edit-product') }}</h3>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">{{ __('admin_text.product') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <form action="{{url('udc/update-product')}}" method="post" name="addProductForm" id="addProductForm"
                      enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="{{@$product_info->id}}">
                    <input type="hidden" name="seller_id" value="{{@$product_info->seller_id}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="">{{ __('admin_text.product-name') }}</label>
                                <input type="text" class="form-control" name="product_name" required
                                       value="{{@$product_info->product_name}}">
                            </div>

                            <div class="form-group">
                                <label>{{ __('admin_text.description') }}</label>
                                <textarea name="description" class="summernote"
                                          value="">{{@$product_info->description}}</textarea>
                                <label class="error"></label>
                            </div>

                            <div class="form-group">
                                <label for="">{{ __('admin_text.product-price') }}</label>
                                <input type="number" class="form-control" name="price" value="{{@$product_info->price}}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label>{{ __('admin_text.add-image') }}</label>
                                <div class="slim" style="width: 300px;"
                                     data-ratio="1:1"
                                     data-size="400,400"
                                     id="my-cropper">
                                    <img src="{{url('').'public/content-dir/udc_product_images/'.@$product_info->product_image}}">
                                    <input type="file" name="product_image"/>
                                </div>
                            </div>

                            <hr>

                            <h4>{{ __('admin_text.seller-details') }}</h4>


                            <div id="newUserForm">
                                <div class="form-group">
                                    <label for="">{{ __('admin_text.name') }}</label>
                                    <input type="text" class="form-control" name="seller_name" value="{{@$product_info->get_seller->seller_name}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="">{{ __('admin_text.address') }}</label>
                                    <input type="text" class="form-control" name="seller_address" value="{{@$product_info->get_seller->seller_address}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="">{{ __('admin_text.mobile-number') }}</label>
                                    <input type="text" class="form-control" name="seller_contact_number" value="{{@$product_info->get_seller->seller_contact_number}}" required>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-5">
                            <style>
                                .ep-list {
                                    padding: 0;
                                }

                                .ep-list li {
                                    list-style-type: none;
                                }

                                .ep-list .plx__checkbox {
                                    padding-left: 20px;
                                }

                                .ep-list .plx__checkbox label {
                                    font-weight: 600;
                                }

                                .ep-list .meta-forms {
                                    padding: 13px 15px 15px;
                                    background: rgba(0, 0, 0, .05);
                                    display: none;
                                }
                            </style>
                            <div class="form-group">
                                <label for="">{{ __('admin_text.select') }} {{ __('admin_text.ep') }}
                                    &nbsp;({{ __('admin_text.ecommerce-partners') }})</label>

                                <ul class="ep-list">

                                    @forelse($ep_list as $key=>$each_ep)
                                        @php
                                            $ep_details=$product_info->get_product_details->where('ep_id',$each_ep->id)->first();
                                        @endphp
                                        {{--{{dd($ep_details)}}--}}
                                        <li>
                                            <div class="plx__checkbox checkbox">
                                                <label>
                                                    <input onclick="add_required_class('{{$each_ep->id}}')"
                                                           id="ep_id_{{$each_ep->id}}"
                                                           type="checkbox" name="ep_id[{{$key}}]"
                                                           value="{{$each_ep->id}}"
                                                           class="ep-item" {{@$ep_details ? 'checked' : ''}}
                                                           data-form="#form{{$each_ep->id}}">{{$each_ep->ep_name}}
                                                </label>
                                            </div>
                                            <div id="form{{$each_ep->id}}" class="meta-forms">
                                                <div class="form-group form-group-sm">
                                                    <label for="">{{ __('admin_text.sku') }}</label>
                                                    <input type="text"
                                                           class="form-control {{@$ep_details ? 'required' : ''}}"
                                                           name="sku[{{$key}}]" value="{{@$ep_details->sku}}">
                                                </div>
                                                <div class="form-group form-group-sm">
                                                    <label for="">{{ __('admin_text.permalink') }}</label>
                                                    <input type="text"
                                                           class="form-control {{@$ep_details ? 'required' : ''}}"
                                                           name="permalink[{{$key}}]"
                                                           value="{{@$ep_details->permalink}}">
                                                </div>

                                                <div class="form-group form-group-sm">
                                                    <label for="">{{ __('admin_text.product-url') }}/label>
                                                        <input type="text"
                                                               class="form-control {{@$ep_details ? 'required' : ''}}"
                                                               name="product_url[{{$key}}]"
                                                               value="{{@$ep_details->product_url}}">
                                                </div>

                                                <div class="form-group form-group-sm">
                                                    <label for="">{{ __('admin_text.quantity') }}</label>
                                                    <input type="number" class="form-control" name="quantity[{{$key}}]"
                                                           value="{{@$ep_details->quantity}}">
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                                <script>
                                    (function ($) {
                                        var epItem = $('.ep-item');

                                        $(epItem).each(function () {
                                            showMetaForms(this);
                                            $(epItem).change(function () {
                                                showMetaForms(this);
                                            });
                                        });

                                        function showMetaForms(selector) {
                                            var targetForm = $(selector).data("form");
                                            if ($(selector).is(':checked')) {
                                                $(targetForm).show();
                                            } else {
                                                $(targetForm).hide();
                                            }
                                        }
                                    }(jQuery));
                                </script>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-actions text-right">
                        <button type="button" class="btn default">{{ __('admin_text.cancel') }}</button>
                        <button type="submit" class="btn blue">{{ __('admin_text.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function add_required_class(ep_id) {
            if ($('#ep_id_' + ep_id).is(":checked") == true) {
                $("#form" + ep_id + " :input").addClass('required');
            } else {
                $("#form" + ep_id + " :input").removeClass('required');
            }
        }
    </script>

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
            /*font-style: italic;*/
        }

        .alert-required {
            color: red;
            font-style: italic;
            padding-top: 3px;
        }

    </style>
    <link rel="stylesheet" href="{{url('public/assets/plugins/slimfit/css/slim.min.css')}}">
    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.js"></script>
    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.validate.js"></script>
    <script>
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#addProductForm").validate({
                messages: {
//                    product_name: "Please enter your product title",
//                    product_image: "Please select an image",
//                    price: "Please enter price",
//                    description: "Please enter product weight",
                },
                rules: {
                    category_id: {
                        required: true
                    }
                }
            });

        });
    </script>


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