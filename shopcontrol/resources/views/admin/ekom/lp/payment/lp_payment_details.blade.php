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
                <span>LP Payments</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h2 class="page-title">LP Payments
        <small></small>
    </h2>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">LP Payments</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="margin-bottom-30" name="payForm" action="http://devteam.website/meet/payments/pay-to-vendor-store" method="post">
                                <input name="vendor_id" value="150" type="hidden">
                                <input name="total_earning" value="0" type="hidden">
                                <input name="total_paid" value="12121" type="hidden">

                                <fieldset class="form-group">
                                    <label>Amount</label>
                                    <input name="amount" class="form-control" required="required" type="number">
                                </fieldset>

                                <fieldset class="form-group">
                                    <label>Note</label>
                                    <textarea name="note" class="form-control" rows="3"></textarea>
                                </fieldset>

                                <div class="clearfix">
                                    <button type="submit" class="pull-right btn btn-primary">Pay Now</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <table style="width: 100%; margin-top: 50px; font-size: 1.2em;" class="margin-bottom-30">
                                <tbody><tr>
                                    <td style="padding: 4px 0;"><strong>Vendor Earning</strong></td>
                                    <td style="padding: 4px 0;" width="10">:</td>
                                    <td style="padding: 4px 0; width: 120px;">16,121.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 4px 0;"><strong>Total Paid</strong></td>
                                    <td style="padding: 4px 0;" width="10">:</td>
                                    <td style="padding: 4px 0; width: 120px;">2,121.00</td>
                                </tr>

                                <tr>
                                    <td style="padding: 4px 0;"><strong>Total Due</strong></td>
                                    <td style="padding: 4px 0;" width="10">:</td>
                                    <td style="padding: 4px 0; width: 120px;">14,000.00</td>
                                </tr>
                                </tbody></table>
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
                                                Date
                                            </th>
                                            <th width="250">
                                                Note
                                            </th>
                                            <th class="text-right" width="90">
                                                Amount
                                            </th>
                                            <th class="text-right" width="90">
                                                Due on date
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                12-11-2017
                                            </td>
                                            <td>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus, iure.
                                            </td>
                                            <td style="text-align: right">
                                                12,121.00
                                            </td>
                                            <td style="text-align: right">
                                                12,121.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                12-10-2017
                                            </td>
                                            <td>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus, iure.
                                            </td>
                                            <td style="text-align: right">
                                                12,121.00
                                            </td>
                                            <td style="text-align: right">
                                                12,121.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                12-09-2017
                                            </td>
                                            <td>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus, iure.
                                            </td>
                                            <td style="text-align: right">
                                                12,121.00
                                            </td>
                                            <td style="text-align: right">
                                                12,121.00
                                            </td>
                                        </tr>
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