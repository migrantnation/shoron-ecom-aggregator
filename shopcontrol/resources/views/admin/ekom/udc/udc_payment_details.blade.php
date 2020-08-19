@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{__('admin_text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{__('admin_text.udc-payments')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h2 class="page-title">{{__('admin_text.udc-payments')}}
        <small></small>
    </h2>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">{{__('admin_text.udc-payments')}}</span>
                    </div>
                </div>
                <?php
                $enTobn = new \App\Libraries\PlxUtilities();
                ?>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>{{__('admin_text.entrepreneur-information')}}:</h4>
                            <strong>{{__('admin_text.center-name')}}:</strong> &nbsp;&nbsp;{{@$udc_info->center_name}}<br>
                            <strong>{{__('admin_text.entrepreneur-name')}}:</strong>&nbsp;&nbsp;{{App::isLocale('bn') ? @$udc_info->name_bn : $udc_info->name_en}}<br>
                            <strong>{{__('admin_text.contact-number')}}:</strong>&nbsp;&nbsp;{{App::isLocale('bn') ? $enTobn->en2bnNumber(@$udc_info->contact_number) : @$udc_info->contact_number}}<br>

                            <strong>{{__('admin_text.present-address')}}:</strong>&nbsp;&nbsp;{{@$udc_info->present_address}}
                        </div>
                        <div class="col-md-6 text-right">
                            <table style="width: 100%; margin-top: 50px; font-size: 1.2em;" class="margin-bottom-30">
                                <tbody>
                                <tr>
                                    <td style="padding: 4px 0;"><strong>{{__('admin_text.total-earning')}}</strong></td>
                                    <td style="padding: 4px 0;" width="10">:</td>
                                    <td style="padding: 4px 0; width: 120px;">{{__('admin_text.tk.')}} {{@$total_paid->total_paid ? App::isLocale('bn') ? $enTobn->en2bnNumber(@$total_paid->total_paid): @$total_paid->total_paid : 0}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12"><!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light">
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover" id="sample_6">
                                        <thead>
                                        <tr>
                                            <th width="90">
                                                {{__('admin_text.order-id')}}
                                            </th>
                                            <th width="250">
                                                {{__('admin_text.payment-date')}}
                                            </th>
                                            <th class="text-right" width="90">
                                                {{__('admin_text.grand-total')}}
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody>


                                        @forelse($udc_payments as $eachpayment)
                                            <tr>
                                                <td>
                                                    {{App::isLocale('bn') ? $enTobn->en2bnNumber(@$eachpayment->order_code) : @$eachpayment->order_code}}
                                                </td>
                                                <td>
                                                    {{App::isLocale('bn') ? $enTobn->en2bnNumber((date('Y-m-d',strtotime(@$eachpayment->created_at)))) : date('Y-m-d',strtotime(@$eachpayment->created_at))}}
                                                </td>
                                                <td style="text-align: right">
                                                    {{App::isLocale('bn') ? $enTobn->en2bnNumber(@$eachpayment->amount) : @$eachpayment->amount}}
                                                </td>
                                            </tr>
                                        @empty

                                            <tr>
                                                <td colspan="8" align="center">{{__('admin_text.no-result')}}</td>
                                            </tr>

                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection