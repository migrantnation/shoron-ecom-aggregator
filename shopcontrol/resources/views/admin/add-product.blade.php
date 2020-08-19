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
                <span>Add Product</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        {{--<a href="#" class="">--}}
            {{--<small class="fa fa-angle-left"></small>--}}
            {{--&nbsp;Back product list</a>--}}
        <h3 class="margin-top-10 margin-bottom-15">Add Product</h3>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">Product</span>
                </div>
            </div>
            <div class="portlet-body">
                <form action="#" method="post" enctype="multipart/form-data"
                      name="addProductForm" id="addProductForm">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="">Product Name</label>
                                <input type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="summernote"></textarea>
                                <label class="error"></label>
                            </div>

                            <div class="form-group">
                                <label for="">Product Price</label>
                                <input type="number" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Add Image</label>
                                <div class="slim" style="width: 300px;"
                                     data-ratio="1:1"
                                     data-size="400,400"
                                     data-service="{{url('admin/upload-image')}}"
                                     id="my-cropper"> {{--assets/plugins/slimfit/async.php--}}
                                    <input type="file"/>
                                </div>
                            </div>

                            <hr>

                            <h4>User Details</h4>

                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Mobile Number</label>
                                <input type="text" class="form-control">
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
                                <label for="">Select EP(eCommerce Partners)</label>

                                <ul class="ep-list">
                                    <li>
                                        <div class="plx__checkbox checkbox">
                                            <label><input type="checkbox" checked value="" class="ep-item"
                                                          data-form="#form1">Ehos.com</label>
                                        </div>
                                        <div id="form1" class="meta-forms">
                                            <div class="form-group form-group-sm">
                                                <label for="">SKU</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="form-group form-group-sm">
                                                <label for="">Permalink</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="plx__checkbox checkbox">
                                            <label><input type="checkbox" value="" class="ep-item" data-form="#form2">Daraz.com</label>
                                        </div>
                                        <div id="form2" class="meta-forms">
                                            <div class="form-group form-group-sm">
                                                <label for="">SKU</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="form-group form-group-sm">
                                                <label for="">Permalink</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="plx__checkbox checkbox">
                                            <label><input type="checkbox" value="" class="ep-item" data-form="#form3">ep_partner.com</label>
                                        </div>
                                        <div id="form3" class="meta-forms">
                                            <div class="form-group form-group-sm">
                                                <label for="">SKU</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="form-group form-group-sm">
                                                <label for="">Permalink</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </li>
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
                        <button type="button" class="btn default">Cancel</button>
                        <button type="submit" class="btn blue">Create Product</button>
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
    <link rel="stylesheet" href="{{url('assets/plugins/slimfit/css/slim.min.css')}}">
    <script src="{{url('assets/plugins/jquery_validation')}}/jquery.js"></script>
    <script src="{{url('assets/plugins/jquery_validation')}}/jquery.validate.js"></script>
    <script>
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#addProductForm").validate({
                messages: {
                    product_name: "Please enter your product title",
                    product_image: "Please select an image",
                    base_price: "Please enter price",
                    weight: "Please enter product weight",
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

        $('#categoryId').on('change', function () {
            $.ajax({
                type: 'POST',
                url: "{{url('get-sub-category')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "category_id": this.value
                },
                success: function (data) {
                    $("#subCategory").html(data);
                }
            });
        })


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

    <script src="{{url('assets/plugins/slimfit/js/slim.kickstart.min.js')}}"></script>
    <script>slim_init();</script>
@endsection