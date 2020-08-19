@extends('frontend.layouts.master')
@section('content')

    <?php $util = new \App\Libraries\PlxUtilities();?>

    <div class="plx__breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{url('')}}">{{__('text.home')}}</a></li>
                <li><a href="{{url('cart')}}">{{__('text.cart')}}</a></li>
                <li class="active">{{__('text.checkout')}}</li>
            </ol>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="checkout-wrap-">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="c-info-block">
                            <div class="plx__block">
                                <h4 class="block-title">{{__('text.user-details')}}</h4>

                                <form action="{{url('save-customer-payment')}}" method="post">

                                    {{csrf_field()}}

                                    <input type="hidden" id="order_code" name="order_code"
                                           value="{{$order_info->order_code}}">

                                    <div class="chackbox margin-bottom-10">
                                        <label for=""><input type="checkbox" id="isExistingUser" name="userExist">
                                            {{__('text.existing-customer')}}</label>
                                    </div>

                                    <div id="newUserForm" style="display: none;">
                                        <div class="form-group">
                                            <label for="">{{__('text.name')}}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="customer_name"
                                                   id="customer_name" value="{{old('customer_name')}}">

                                            <p class="error">{{ $errors->first('customer_name')}}</p>

                                        </div>
                                        <div class="form-group">
                                            <label for="">{{__('text.address')}}</label>
                                            <input type="text" class="form-control" name="customer_address"
                                                   id="customer_address" value="{{old('customer_address')}}">

                                            <p class="error">{{ $errors->first('customer_address')}}</p>

                                        </div>
                                        <div class="form-group">
                                            <label for="">{{__('text.phone-number')}}</label>
                                            <input type="text" class="form-control" name="customer_contact_number"
                                                   id="customer_contact_number"
                                                   value="{{old('customer_contact_number')}}">

                                            <p class="error">{{ $errors->first('customer_contact_number')}}</p>

                                        </div>
                                    </div>

                                    <div id="existingUserForm" style="display: none;">
                                        <div class="form-group">
                                            <?php
                                            $selected_customer = array();
                                            if (old('udc_customer_id')) {
                                                $selected_customer[old('udc_customer_id')] = 'selected';
                                            }
                                            ?>
                                            <select name="udc_customer_id" id="" class="form-control">
                                                <option value="">--{{__('text.select')}}--</option>
                                                @forelse($udcCustomers as $customer)
                                                    <option value="{{$customer->id}}" {{@$selected_customer[$customer->id]}}>{{$customer->customer_name}}</option>
                                                @empty

                                                @endforelse
                                            </select>

                                            <p class="error">{{ $errors->first('udc_customer_id')}}</p>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="">{{__('text.total-amount')}}</label>
                                        <input type="number" class="form-control" name="total_amount" id="total_amount"
                                               readonly
                                               value="{{$order_info->total_price}}">

                                        <p class="error">{{ $errors->first('total_amount')}}</p>

                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('text.advance')}}<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="advance" id="advance"
                                               value="{{old('advance')?old('advance'):0}}">

                                        <p class="error">{{ $errors->first('advance')}}</p>

                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('text.due')}}</label>
                                        <input type="number" class="form-control" name="due" id="due" readonly
                                               value="{{old('due')?old('due'):@$order_info->total_price}}">

                                        <p class="error">{{ $errors->first('due')}}</p>

                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('text.note')}}</label>
                                        <textarea name="note" id="note" rows="3"
                                                  class="form-control">{{old('note')}}</textarea>
                                        <p class="error">{{ $errors->first('note')}}</p>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>

                                </form>

                                <script>

                                    function checkUserType() {
                                        if ($('#isExistingUser').prop("checked")) {
                                            $('#existingUserForm').show();
                                            $('#newUserForm').hide();
                                        } else {
                                            $('#newUserForm').show();
                                            $('#existingUserForm').hide();
                                        }
                                    }

                                    $(function ($) {
                                        "use strict";
                                        checkUserType();
                                        $('#isExistingUser').change(function () {
                                            checkUserType();
                                        });

                                        function checkUserType() {
                                            if ($('#isExistingUser').prop("checked")) {
                                                $('#existingUserForm').show();
                                                $('#newUserForm').hide();
                                            } else {
                                                $('#newUserForm').show();
                                                $('#existingUserForm').hide();
                                            }
                                        }
                                    }(jQuery))

                                    $('#advance').on('keyup', function () {
                                        var total = $('#total_amount').val();
                                        var advance = $('#advance').val();
                                        var due = total - advance;
                                        var due = due.toFixed(2);
                                        $('#due').val(due);

                                        if (due < 0) {
                                            $('#advance').val(total);
                                            $('#due').val(0.00);
                                        }
                                    });

                                </script>

                                @if(old('userExist')=='on')
                                    <script>
                                        $('#isExistingUser').prop('checked', true);
                                        checkUserType()
                                    </script>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-7 text-right">
                        <a class="btn btn-sm btn-default" onclick="window.print();">
                            <i class="icon-printer"></i>&nbsp; {{__('text.print')}}
                        </a>
                    </div>


                    <div class="col-sm-7" id="section-to-print">
                        <h4 class="i-m-title text-center">{{__('text.invoice')}} <small>({{date("d M, Y")}})</small></h4>
                        <div class="invoice">
                            <div class="invoice-header">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <img src="{{asset('public/assets/img/_ecom__logo.png')}}" alt="Ek-Shop" class="invoice-logo">
                                        <a href="javascript://" class="home-logo"></a>
                                    </div>
                                    <div class="col-xs-6">
                                        <p class="text-right">
                                            <img src="{{asset('public/assets/img/logo_a2i.png')}}" alt="a2i" class="invoice-logo-alt">
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 invoice-payment">
                                    <h4 class="invoice-title">{{__('text.order-details')}}:</h4>
                                    <table class="i-table">
                                        <tr>
                                            <td><strong>{{__('text.order-no')}}</strong></td>
                                            <td width="10">:</td>
                                            <td class="text-right">{{@$order_info->order_code}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__('text.transaction-no')}}</strong></td>
                                            <td width="10">:</td>
                                            <td class="text-right">{{@$order_info->order_invoice->transaction_number}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__('text.ep')}}</strong></td>
                                            <td width="10">:</td>
                                            <td class="text-right">
                                                @if(@$order_info->ep_info->ep_logo)
                                                    <img src="{{asset("public/content-dir/ecommerce_partners"."/".@$order_info->ep_info->ep_logo)}}" alt="{{@$order_info->ep_info->ep_name}}" class="partner-logo">
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>{{__('text.lp-name')}}</strong></td>
                                            <td width="10">:</td>
                                            <td class="text-right">
                                                @if(@$order_info->lp_info->lp_logo)
                                                    <img src="{{asset("public/content-dir/logistic_partners"."/".@$order_info->lp_info->lp_logo)}}" alt="{{@$order_info->lp_name}}" class="partner-logo">
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>{{__('text.delivery-duration')}}</strong></td>
                                            <td width="10">:</td>
                                            <td class="text-right">{{@$order_info->delivery_duration}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-xs-5 invoice-left-part col-sm-push-1">
                                    <?php \App\Libraries\PlxUtilities::generate_barcode("$order_info->order_code");?>
                                    {{--<h4 class="invoice-title">&nbsp;</h4>--}}
                                    @if(@$user_info->upazila)
                                        <?php $address[] = @$user_info->upazila?>
                                    @endif

                                    @if(@$user_info->union)
                                        <?php $address[] = @$user_info->union?>
                                    @endif

                                    @if(@$user_info->district)
                                        <?php $address[] = @$user_info->district?>
                                    @endif

                                    @if(@$user_info->division)
                                        <?php $address[] = @$user_info->division?>
                                    @endif

                                    <strong>{{@$user_info->center_name}}</strong> <br>
                                    {{__('text.address')}}: {{(isset($address))?implode(', ', $address):''}} <br>
                                    {{__('text.mobile-no')}}
                                    : {{App::isLocale('bn')?$util->en2bnNumber(@$user_info->contact_number?$user_info->contact_number:@$user_info->phone):@$user_info->contact_number?$user_info->contact_number:@$user_info->phone}}

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="40%">{{__('text.item')}}</th>
                                            <th width="10%" class="hidden-480">{{__('text.quantity')}}</th>
                                            <th class="hidden-480 text-right">{{__('text.unit-cost')}}</th>
                                            <th class="text-right">{{__('text.total')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($order_info->order_details as $key=>$item)
                                            <tr>
                                                <td>{{App::isLocale('bn')?$util->en2bnNumber($key+1):$key+1}}</td>
                                                <td width="40%" class="hidden-480">
                                                    {{$item->product_name}} <br>
                                                    <span class="text-muted"></span>
                                                </td>
                                                <td width="10%"
                                                    class="text-center hidden-480">{{App::isLocale('bn')?$util->en2bnNumber($item->quantity):$item->quantity}}</td>
                                                <td class="hidden-480 text-right">{{__('text.tk.')}} {{App::isLocale('bn')?$util->en2bnNumber(number_format($item->unit_price, 2)):number_format($item->unit_price, 2)}}</td>
                                                <td class="text-right">{{__('text.tk.')}} {{App::isLocale('bn')?$util->en2bnNumber(number_format($item->price, 2)):number_format($item->price, 2)}}</td>
                                            </tr>
                                        @empty

                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-push-8 col-xs-4 invoice-block">
                                    <table style="line-height: 1.8; width: 100%;">
                                        <tbody>
                                        <tr>
                                            <td><strong>{{__('text.subtotal')}}:</strong></td>
                                            <td class="text-right">
                                                {{__('text.tk.')}}
                                                {{App::isLocale('bn')?$util->en2bnNumber(number_format($order_info->sub_total, 2)):number_format($order_info->sub_total, 2)}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>{{__('text.delivery-charge')}}</strong></td>
                                            <td class="text-right">
                                                {{__('text.tk.')}}
                                                {{App::isLocale('bn')?$util->en2bnNumber(number_format($order_info->delivery_charge, 2)):number_format($order_info->delivery_charge, 2)}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>{{__('text.grand-total')}}:</strong></td>
                                            <td class="text-right">
                                                {{__('text.tk.')}}
                                                {{App::isLocale('bn')?$util->en2bnNumber(number_format($order_info->total_price, 2)):number_format($order_info->total_price, 2)}}
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

