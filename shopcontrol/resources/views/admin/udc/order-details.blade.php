@extends('admin.layouts.master')
@section('content')

    <?php $util = new \App\Libraries\PlxUtilities();?>

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{__('admin_text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{__('admin_text.order-detail')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{__('admin_text.order-detail')}} &nbsp;&nbsp;
        <small></small>
    </h1>

    <?php
    $order_status = 1;
    $order_status = @$order_info->status;
    ?>

    @if($order_status == 5)
        <div class="alert alert-danger fade in alert-dismissible text-center">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Order canceled!</strong>
            &nbsp; {{@$tracking_details[5][0]->message_by?' by ' .@$tracking_details[5][0]->message_by:""}}
            <br>
            <strong>Reason:</strong> {{@$tracking_details[5][0]->message?@$tracking_details[5][0]->message:"EP didn't mansion any reason"}}
        </div>
    @endif


    <!-- END PAGE TITLE-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered clearfix" style="padding: 40px 30px 30px">
                <div class="horizontal-status-bar">
                    <div class="hor-steps clearfix">
                        <div class="hor-step"><i class="plx__icon fa fa-shopping-cart"></i></div>
                        @if($order_status == 5)
                            <div class="hor-step"><i class="plx__icon fa fa-recycle"></i></div>
                        @else
                            {{--<div class="hor-step"><i class="plx__icon fa fa-archive"></i></div>--}}
                            <div class="hor-step"><i class="plx__icon  fa fa-home"></i></div>
                            <div class="hor-step"><i class="plx__icon fa fa-truck"></i></div>
                            <div class="hor-step"><i class="plx__icon fa fa-check-square-o"></i></div>
                        @endif
                    </div>
                    <div class="step-texts">
                        <span class="bar-line"></span>
                        <div class="step-text {{(@$order_status > 0) ? 'step-complete':''}}">Order Placed
                            <br>{{date('M d, Y h:i a', strtotime(@$order_info->created_at))}}</div>

                        @if(@$order_status == 5)
                            <div class="step-text {{(@$order_status == 5 ) ? 'step-cancelled':''}}">
                                Order Canceled
                                <br>
                                {{date('M d, Y h:i a', strtotime(@$order_info->updated_at))}}
                                <br>
                                {{@$tracking_details[5][0]->message_by?' by ' .@$tracking_details[5][0]->message_by:''}}
                            </div>

                        @else
                            {{--<div class="step-text {{(@$order_status > 1 && @$order_status != 5 ) ? 'step-complete':''}}">
                                Preparing Parcel
                                <br> {{ @$tracking_details[2][0]->created_at ?  date('M d, Y h:i a', strtotime(@$tracking_details[2][0]->created_at)) : ""}}
                            </div>--}}
                            <div class="step-text {{(@$order_status > 1 && @$order_status != 5 ) ? 'step-complete':''}}">
                                Warehouse Left
                                <br> {{ @$tracking_details[2][0]->created_at ?  date('M d, Y h:i a', strtotime(@$tracking_details[2][0]->created_at)) : ""}}
                                <br>
                                {{@$tracking_details[2][0]->message}}
                                {{@$tracking_details[2][0]->message_by?' by ' .@$tracking_details[2][0]->message_by:''}}
                            </div>
                            <div class="step-text {{(@$order_status > 2 && @$order_status != 5 ) ? 'step-complete':''}}">
                                In Transit
                                <br>{{ @$tracking_details[3][0]->created_at ?  date('M d, Y h:i a', strtotime(@$tracking_details[3][0]->created_at)) : ""}}
                                <br>
                                {{@$tracking_details[3][0]->message}}
                                {{@$tracking_details[3][0]->message_by?' by ' .@$tracking_details[3][0]->message_by:''}}
                            </div>
                            <div class="step-text {{(@$order_status > 3 && @$order_status != 5 ) ? 'step-complete':''}}">
                                Delivered
                                <br>{{ @$tracking_details[4][0]->created_at ?  date('M d, Y h:i a', strtotime(@$tracking_details[4][0]->created_at)) : ""}}
                                <br>
                                {{@$tracking_details[4][0]->message}}
                                {{@$tracking_details[4][0]->message_by?' by ' .@$tracking_details[4][0]->message_by:''}}
                            </div>
                        @endif


                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>


            <div id="section-to-print" class="portlet light bordered clearfix">

                <div class="col-sm-12">
                    <a class="btn btn-sm btn-default text-right" onclick="javascript:window.print();">
                        {{__('admin_text.print')}} <i class="fa fa-print"></i>
                    </a>
                    <div class="invoice">
                        <hr>
                        <div class="row">
                            <div class="col-xs-6 invoice-payment">
                                <table style="line-height: 1.8; width: 100%;">

                                    <tr>
                                        <td><strong>{{__('admin_text.order-date')}}:</strong></td>
                                        <td class="text-right">{{date('Y-m-d', strtotime(@$order_info->created_at))}}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>{{__('admin_text.order-id')}}:</strong></td>
                                        <td class="text-right">{{@$order_info->order_code}}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>{{__('admin_text.transaction-method')}}:</strong></td>
                                        <td class="text-right">Cash on Delivery</td>
                                    </tr>

                                    <tr>
                                        <td><strong>{{__('admin_text.ep-name')}}:</strong></td>
                                        <td class="text-right">

                                            @if(@$order_info->ep_info->ep_logo)
                                                <img src="{{asset("public/content-dir/ecommerce_partners"."/".@$order_info->ep_info->ep_logo)}}"
                                                     alt="EP" class="" height="28">
                                            @endif
                                            {{@$order_info->ep_name}}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            {{--<div class="col-xs-5 col-sm-push-1">--}}
                            {{--<strong>{{__('admin_text.lp-name')}}:</strong> {{@$order_info->lp_name}}<br>--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-5 col-sm-push-1">--}}
                            {{--<strong>{{__('admin_text.delivery-duration')}}:</strong> {{@$order_info->delivery_duration}}<br>--}}
                            {{--</div>--}}
                            <div class="col-xs-5 col-sm-push-1">
                                <table style="line-height: 1.8; width: 100%;">

                                    <tr>
                                        <td><strong>{{__('admin_text.lp-name')}}:</strong></td>
                                        <td class="text-right">
                                            @if(@$order_info->lp_info->lp_logo)
                                                <img src="{{asset("public/content-dir/logistic_partners"."/".@$order_info->lp_info->lp_logo)}}"
                                                     alt="LP" class="" height="28">
                                            @endif
                                            {{@$order_info->lp_name}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><strong>{{__('admin_text.delivery-duration')}}:</strong></td>
                                        <td class="text-right">{{@$order_info->delivery_duration}}</td>
                                    </tr>
                                    <tr>
                                        <td>

                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('admin_text.item')}}</th>
                                        <th class="hidden-480">{{__('admin_text.quantity')}}</th>
                                        <th class="hidden-480">{{__('admin_text.unit-cost')}}</th>
                                        <th>{{__('admin_text.item')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($order_info->order_details as $key=>$item)
                                        <tr>
                                            <td>{{App::isLocale('bn')?$util->en2bnNumber($key+1):$key+1}}</td>
                                            <td class="hidden-480">
                                                <a href="{{@$item->product_url}}" target="_blank"
                                                   style="text-decoration: none;"> {{$item->product_name}} </a> <br>
                                                <span class="text-muted">{!! @$item->product_attributes !!}</span>
                                            </td>
                                            <td class="text-center hidden-480">{{App::isLocale('bn')?$util->en2bnNumber($item->quantity):$item->quantity}}</td>
                                            <td class="hidden-480">{{__('admin_text.tk.')}} {{App::isLocale('bn')?$util->en2bnNumber(number_format($item->unit_price, 2)):number_format($item->unit_price, 2)}}</td>
                                            <td>{{__('admin_text.tk.')}} {{App::isLocale('bn')?$util->en2bnNumber(number_format($item->price, 2)):number_format($item->price, 2)}}</td>
                                        </tr>
                                    @empty

                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4 invoice-block">
                                <?php \App\Libraries\PlxUtilities::generate_barcode("$order_info->order_code");?>
                            </div>
                            <div class="col-xs-push-4 col-xs-4 invoice-block">
                                <table style="line-height: 1.8; width: 100%;">
                                    <tbody>
                                    <tr>
                                        <td><strong>{{__('admin_text.subtotal')}}:</strong></td>
                                        <td class="text-right">{{App::isLocale('bn')?$util->en2bnNumber(number_format($order_info->sub_total, 2)):number_format($order_info->sub_total, 2)}}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>{{__('admin_text.delivery-charge')}}</strong></td>
                                        <td class="text-right">{{App::isLocale('bn')?$util->en2bnNumber(number_format($order_info->delivery_charge, 2)):number_format($order_info->delivery_charge, 2)}}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>{{__('admin_text.grand-total')}}:</strong></td>
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
                        <hr>
                        <div class="row">
                            <div class="col-xs-7">
                                {{--<h4>{{__('admin_text.entrepreneur-information')}}:</h4>--}}
                                {{--<strong>{{__('admin_text.center-name')}}:</strong>--}}
                                {{--&nbsp;&nbsp;{{@$user_info->center_name}}<br>--}}
                                {{--<strong>{{__('admin_text.entrepreneur-name')}}--}}
                                {{--:</strong>&nbsp;&nbsp;{{App::isLocale('bn') ? @$user_info->name_bn : $user_info->name_en}}--}}
                                {{--<br>--}}
                                {{--<strong>{{__('admin_text.nid')}}--}}
                                {{--:</strong>&nbsp;&nbsp;{{App::isLocale('bn') ? $util->en2bnNumber(@$user_info->national_id_no) : @$user_info->national_id_no}}--}}
                                {{--<br>--}}
                                {{--<strong>{{__('admin_text.division')}}:</strong>&nbsp;&nbsp;{{@$user_info->division}}<br>--}}
                                {{--<strong>{{__('admin_text.district')}}:</strong>&nbsp;&nbsp;{{@$user_info->district}}<br>--}}
                                {{--<strong>{{__('admin_text.upazilla')}}:</strong>&nbsp;&nbsp;{{@$user_info->upazila}}<br>--}}
                                {{--<strong>{{__('admin_text.union')}}:</strong>&nbsp;&nbsp;{{@$user_info->union}}<br>--}}
                                {{--<strong>{{__('admin_text.contact-number')}}--}}
                                {{--:</strong>&nbsp;&nbsp;{{@$user_info->contact_number}}<br>--}}
                                {{--<strong>{{__('admin_text.e-mail')}}:</strong>&nbsp;&nbsp;{{@$user_info->email}}<br>--}}
                                {{--<strong>{{__('admin_text.present-address')}}--}}
                                {{--:</strong>&nbsp;&nbsp;{{@$user_info->present_address}}--}}
                            </div>
                            <div class="col-xs-5">
                                <h4>{{__('admin_text.customer-information')}}:</h4>
                                <strong>{{__('admin_text.customer-name')}}:</strong>
                                &nbsp;&nbsp;{{@$order_info->UdcCustomer->customer_name}}<br>
                                <strong>{{__('admin_text.customer-address')}}
                                    :</strong>&nbsp;&nbsp;{{@$order_info->UdcCustomer->customer_address}}<br>
                                <strong>{{__('admin_text.customer-mobile-number')}}
                                    :</strong>&nbsp;&nbsp;{{@$order_info->UdcCustomer->customer_contact_number}}<br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection