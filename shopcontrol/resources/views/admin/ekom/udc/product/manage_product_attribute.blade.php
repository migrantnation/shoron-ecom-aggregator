@extends('admin.layouts.master')
@section('content')

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <link rel="stylesheet" href="{{url('assets/plugins/slimfit/css/slim.min.css')}}">
    <script src="{{url('assets/plugins/jquery_validation')}}/stylesheet.css"></script>
    <script src="{{url('assets/plugins/jquery_validation')}}/jquery.js"></script>
    <script src="{{url('assets/plugins/jquery_validation')}}/jquery.validate.js"></script>
    <script>
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#productAttributeForm").validate({
                messages: {
                    attribute_name: "Please enter your attribute name",
                    attribute_values: "Please enter attribute value",
                    variant_price: "Please enter price",
                    variant_sku: "Please enter product weight",
                    variant_quantity: "Please enter product quantity",
                }
            });
        });
    </script>
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="./">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url("admin/$udc_info->id/product")}}">Udc Product</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{@$product_attributes->count()>0?'Update Variations':'Add Variations'}}</span>
            </li>
        </ul>
    </div>


    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <h3 class="margin-top-10 margin-bottom-15">{{@$product_attributes->count()>0?'Manage product variations':'Add Product Variations'}}</h3>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">Variations</span>
                </div>
                <ul class="nav nav-tabs">
                    <li>
                        <a href="{{url("admin/$udc_info->id/product/$product_info->id/edit")}}"> Product </a>
                    </li>
                    <li class="active">
                        <a href="{{@$product_info?url('admin'.'/'.@$udc_info->id.'/product/'.@$product_info->product_url.'/manage-product-attribute'):'javascript:;'}}">
                            Variations </a>
                    </li>
                </ul>
            </div>

            <div class="portlet-body">
                @if($product_attributes->count() >0)
                    <?php $form_url = "admin/$udc_info->id/product/$product_info->product_url/update-product-attribute";?>
                @else
                    <?php $form_url = "admin/$udc_info->id/product/$product_info->product_url/store-product-attribute";?>
                @endif


                <form action="{{url("$form_url")}}" method="post" enctype="multipart/form-data"
                      name="productAttributeForm" id="productAttributeForm" novalidate="novalidate">

                    {!! csrf_field() !!}

                    <input type="hidden" name="recombination" id="recombination" value="0">
                    <input type="hidden" name="store_url" value="{{@$udc_info->store->store_url}}">

                    @if(@$product_attributes->count() >0)
                        <?php
                        $total_attribute = 0;
                        $attribute_name = array();
                        $attribute_value = array();
                        $variant_required = array();
                        $combinations = array();
                        $variant_price = array();
                        $variant_quantity = array();

                        $variations = array();
                        foreach ($product_attributes as $at_value) {
                            $attribute_name[] = $at_value->attribute_name;
                            $value = array();
                            //ATTRIBUTE VALUE
                            foreach ($at_value->values as $att_value) {
                                $value[] = $att_value->value;
                            }
                            $attribute_value[] = implode(',', $value);
                            $variations = $at_value;
                        }

                        $variation_arr = array();
                        if ($variations)
                            foreach ($at_value->variations as $variation) {
                                $product_detail_id[] = $variation->id;
                                $combinations[] = $variation->combinations;
                                $variant_price[] = $variation->price;
                                $variant_quantity[] = $variation->quantity;
                                $variant_image[] = $variation->image;
                                $variant_image_thumb[] = $variation->image_thumb;
                                $variant_required[] = $variation->status;
                            }
                        ?>
                    @else
                        <?php
                        $total_attribute = 0;
                        $attribute_name = old('attribute_name');
                        $attribute_value = old('attribute_values');
                        $variant_required = old('variant_required');
                        $combinations = old('combinations');
                        $variant_price = old('variant_price');
                        $variant_quantity = old('variant_quantity');

                        //                        echo '<pre>';
                        //                        print_r($attribute_value);

                        ?>
                    @endif


                    <div id="attributes">

                        <div id="attribute_message" class=" alert-required " style="colod:red">{{$errors->first('variant_price')}}</div>

                        @if(@$attribute_name)

                            @forelse($attribute_name as $key=>$each_attribute)
                                <div class="attribute">
                                    {{--<a href="javascript:;" class="removeAttr pull-right">X</a>--}}
                                    <div class="attr-body row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="" class="control-label">Name</label>
                                                <input type="text" class="form-control attribute_name"
                                                       placeholder="Variation Name"
                                                       name="attribute_name[]" value="{{$each_attribute}}" required>
                                                <label>{{$errors->first('attribute_name.'.$key)}}</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="" class="control-label">Value(s)</label>
                                                <input type="text" data-role="tagsinput"
                                                       class="form-control attribute_values" placeholder="Values"
                                                       name="attribute_values[]" value="{{$attribute_value[$key]}}"
                                                       required aria-required="true">
                                                <label>{{$errors->first('attribute_values.'.$key)}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $total_attribute++;?>
                            @empty

                            @endforelse
                        @else

                            <?php $total_attribute++;?>
                            <div class="attribute">
                                <div class="attr-body row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="control-label">Name</label>
                                            <input type="text" class="form-control attribute_name"
                                                   placeholder="Attribute Name"
                                                   name="attribute_name[]" value="" required>
                                            <label>{{$errors->first('attribute_name.0')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="control-label">Value(s)</label>
                                            <input type="text" data-role="tagsinput"
                                                   class="form-control attribute_values" placeholder="Values"
                                                   name="attribute_values[]" value="" required>
                                            <label>{{$errors->first('attribute_values.0')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row margin-top-20">
                        <div class="col-xs-6">
                            <a href="javascript:;" id="generate_variant"><span class="caption-subject uppercase"><i
                                            class="fa fa-cubes"></i> Generate</span></a>
                        </div>

                        <div class="col-xs-6 text-right">
                            <a id="newAttribute" href="javascript:;"><span class="caption-subject uppercase"><i
                                            class="fa fa-plus"></i> Add Variation</span></a>
                        </div>
                    </div>


                    <div id="variations" class="margin-top-15">
                        @if(@$combinations)
                            <div class="attribute">
                                <div class="attr-header clearfix">
                                    <strong>Variants</strong>

                                    <span class="text-right" style="float: right">
                                        <a href="javascript:;" class="add_variation" id="add_variation"
                                           data-product-id="{{@$product_info->id}}"
                                           data-product-url="{{@$product_info->product_url}}"
                                           data-toggle="modal" data-target="#addVariationModal">
                                            Add New Variation
                                        </a>
                                    </span>
                                </div>

                                <div class="attr-body">
                                    <table class="table table-hover table-light">
                                        <thead>
                                        <tr>
                                            <th colspan="2">Variation</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Image</th>
                                            <th width="1%">Status</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        @forelse($combinations as $key=>$value)
                                            <tr>
                                                <input type="hidden" name="product_detail_id[]"
                                                       value="{{@$product_detail_id[$key]}}">
                                                <td>
                                                    @if(is_array(@$cd_value))
                                                        <input type="hidden" name="combinations[{{$key}}]"
                                                               value="{{$combinations[$key]}}" required>
                                                    @else
                                                        {{@$cd_value}}
                                                        <input type="hidden" name="combinations[{{$key}}]"
                                                               value="{{$combinations[$key]}}" required>
                                                    @endif
                                                    {{@$combinations[$key]}}
                                                </td>

                                                <td>:</td>

                                                <td>
                                                    <input type="text" class="form-control numeric error"
                                                           placeholder="Price" name="variant_price[{{$key}}]"
                                                           value="{{$variant_price[$key]}}" required="required"
                                                           aria-required="true" id="variant_price-{{$key}}">
                                                    <label class="error">{{$errors->first('variant_price.' . $key)}}</label>
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control numeric error"
                                                           placeholder="Quantity" data-key="-{{$key}}"
                                                           name="variant_quantity[{{$key}}]" required="required"
                                                           aria-required="true"
                                                           value="{{$variant_quantity[$key]}}"
                                                           id="variant_quantity-{{$key}}">
                                                    <label class="error">{{$errors->first('variant_quantity.' . $key)}}</label>
                                                </td>

                                                <td class="text-center">
                                                    <div class="slim"
                                                         style="width: 100px; height: 100px; display: inline-block"
                                                         data-ratio="1:1"
                                                         data-size="400,400"
                                                         data-service="{{url('admin/upload-image')}}">
                                                        <input type="file" class="slim-image"/>
                                                        @if(@$variant_image[$key])
                                                            <?php $product_image = url('public/content-dir/stores/' . $udc_info->store->store_url . '/products/' . $product_info->product_url . '/' . $variant_image[$key]);?>
                                                            <img src="{{@$product_image}}" alt="Product Image"/>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" data-size="mini"
                                                                   {{($variant_required[$key] == 1)?'checked="checked"':''}}
                                                                   data-toggle="toggle" data-key="{{$key}}"
                                                                   name="variant_required[{{$key}}]"
                                                                   id="variant_required-{{$key}}" value="1">
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">{{'No variation found'}}</td>
                                            </tr>
                                        @endforelse
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        @endif

                    </div>

                    <hr>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-sm-6">
                                <a class="btn grey" href="{{url("admin/$udc_info->id/product/$product_info->id/edit")}}"> Back </a>
                                <a class="btn grey" href="{{url("admin/$udc_info->id/product")}}"> Skip </a>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button id="sample_editable_1_new" class="btn purple" type="submit">
                                    <span>{{@$product_attributes->count()>0?'Update Variations':'Save Variations'}}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addVariationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add New Variation </h4>
                </div>

                <div class="modal-body" id="variationForm">

                </div>
            </div>
        </div>
    </div>

    <script src="{{url('assets/plugins/slimfit/js/slim.kickstart.min.js')}}"></script>
    <script>slim_init();</script>

    <script>

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

    <script>
        var totalAttibute = '{{@$total_attribute}}';
        var baseUrl = "{{url('')}}";
        var csrfToken = '{{ csrf_token() }}';
    </script>


    <script src="{{asset('public/js/add_product.js')}}"></script>
@endsection