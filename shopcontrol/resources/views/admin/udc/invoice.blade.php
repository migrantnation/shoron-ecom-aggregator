@extends('admin.layouts.master')
@section('content')

    <?php $util = new \App\Libraries\PlxUtilities();?>

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Order Details</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">Order Details &nbsp;&nbsp;
        <small></small>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered clearfix">

                <div class="col-sm-12" id="section-to-print">
                    <a class="btn btn-sm btn-default text-right" onclick="javascript:window.print();">
                        {{__('admin_text.print')}} <i class="fa fa-print"></i>
                    </a>
                    <div class="invoice">
                        <hr>
                        <div class="row">
                            <div class="col-sm-12" id="section-to-print">
                                <h4 class="text-center">{{__('text.invoice')}}</h4>
                                <div class="invoice">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <img src="{{asset('public/assets/img/_ecom__logo.png')}}" alt="Ek-Shop" class=""
                                                 width="80px">
                                            <a href="javascript://" class="home-logo"></a>
                                        </div>
                                        <div class="col-xs-6">
                                            <p class="text-right">
                                                {{date("d M, Y")}}
                                            </p>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-6 invoice-payment">
                                            <h4>{{__('text.order-details')}}:</h4>
                                            <table style="line-height: 1.8; width: 100%;">
                                                <tr>
                                                    <td><strong>{{__('text.order-id')}}:</strong></td>
                                                    <td class="text-right">{{@$order_info->order_code}}</td>
                                                </tr>

                                                <tr>
                                                    <td><strong>{{__('text.transaction-no')}}:</strong></td>
                                                    <td class="text-right">{{@$order_info->order_invoice->transaction_number}}</td>
                                                </tr>

                                                <tr>
                                                    <td><strong>{{__('text.ep')}}:</strong></td>
                                                    <td class="text-right">
                                                        @if(@$order_info->ep_info->ep_logo)
                                                            <img src="{{asset("public/content-dir/ecommerce_partners"."/".@$order_info->ep_info->ep_logo)}}"
                                                                 alt="EP" class="" width="40px">
                                                        @endif
                                                        &nbsp; {{@$order_info->ep_info->ep_name}}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>{{__('text.lp-name')}}:</strong></td>
                                                    <td class="text-right">
                                                        @if(@$order_info->lp_info->lp_logo)
                                                            <img src="{{asset("public/content-dir/logistic_partners"."/".@$order_info->lp_info->lp_logo)}}"
                                                                 alt="LP" class="" width="40px">
                                                        @endif
                                                        &nbsp; {{@$order_info->lp_name}}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>{{__('text.delivery-duration')}}:</strong></td>
                                                    <td class="text-right">{{@$order_info->delivery_duration}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-xs-5 col-sm-push-1">
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
                                            {{__('text.address')}}: {{(isset($address))?implode(', ', $address):''}}
                                            <br>
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
                        <br>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection