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
                <span>Disbursement Invoice</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">Disbursement Invoice
        <small></small>
    </h1>

    <!-- END PAGE TITLE-->
    <div class="row">
        <div class="col-md-12">
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
                                    <tbody>
                                        <tr>
                                            <td><strong>UDC Name:</strong></td>
                                            <td class="text-left">{{$disbursed_info->udc->name_bn}}</td>
                                        </tr>

                                        <tr>
                                            <td><strong>Center Name:</strong></td>
                                            <td class="text-left">{{$disbursed_info->udc->center_name}}</td>
                                        </tr>

                                        <tr>
                                            <td><strong>Contact Number:</strong></td>
                                            <td class="text-left">{{$disbursed_info->udc->contact_number}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-6 invoice-payment">
                                <table style="line-height: 1.8; width: 100%;">
                                    <tbody>
                                    <tr>
                                        <td><strong>Disbursement Method:</strong></td>
                                        <td class="text-left">{{$disbursed_info->transfer_method}}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Account Number:</strong></td>
                                        <td class="text-left">{{$disbursed_info->mobile_banking_number}}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Transaction Number:</strong></td>
                                        <td class="text-left">{{$disbursed_info->transaction_number}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Disbursed Date:</strong></td>
                                        <td class="text-left">{{date('M d, Y',strtotime($disbursed_info->created_at))}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th width="30%">Order Code</th>
                                        <th>Disbursement Month</th>
                                        <th class="text-center hidden-480">Total Price</th>
                                        <th class="text-center hidden-480">Total Commission</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $order_code = array();
                                    ?>
                                    @forelse($disbursed_info->udc_orders as $key => $order)
                                        <?php $order_code[] = $order->order_code;?>
                                    @empty
                                    @endforelse
                                    <tr>
                                        <td>{{ implode(', ', $order_code)}}</td>
                                        <td>{{--{{date('M d,Y', strtotime($disbursed_info->disbursement_from_date))}} to --}}{{date('F ,Y ', strtotime($disbursed_info->disbursement_to_date))}}</td>
                                        <td class="text-center hidden-480">{{__('admin_text.tk.')}}{{$disbursed_info->udc_orders->sum('total_price') ? number_format($disbursed_info->udc_orders->sum('total_price'), 2) : ""}}</td>
                                        <td class="text-center hidden-480">{{__('admin_text.tk.')}}{{$disbursed_info->udc_orders->sum('udc_commission') ? number_format($disbursed_info->udc_orders->sum('udc_commission')) : ""}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        @if($disbursed_info->note)
                        <div class="row">
                            <div class="col-xs-12">
                                <i>Note:</i>
                                <p>{{$disbursed_info->note}}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection