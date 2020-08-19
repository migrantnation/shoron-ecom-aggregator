@extends('frontend.layouts.master')
@section('content')
    <div class="section" style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-9 block-center">
                    <div class="thanks-block">
                        <h3 class="thanks-title">Thank You!</h3>
                        <p class="thanks-text">Your order has successfully placed</p>

                        <a href="{{url('product-listing')}}" class="btn btn-primary">Continue Shopping</a> &nbsp;
                    </div>

                    <h4 class="">Your Invoice</h4>
                    <div class="invoice">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="javascript://" class="invoice-logo">E-Kom</a>
                            </div>
                            <div class="col-xs-6">
                                <p class="text-right">
                                    28 Feb 2013
                                    &nbsp;
                                    <a class="btn btn-sm btn-default" onclick="javascript:window.print();">
                                        Print <i class="fa fa-print"></i>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <h3>About:</h3>
                                <ul class="list-unstyled">
                                    <li>
                                        Drem psum dolor sit amet
                                    </li>
                                    <li>
                                        Laoreet dolore magna
                                    </li>
                                    <li>
                                        Consectetuer adipiscing elit
                                    </li>
                                    <li>
                                        Magna aliquam tincidunt erat volutpat
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-5 col-xs-push-1 invoice-payment">
                                <h3>Order Details:</h3>
                                <table style="line-height: 1.8; width: 100%;">
                                    <tr>
                                        <td><strong>Order No #:</strong></td>
                                        <td class="text-right">542554(DEMO)78</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payment Method:</strong></td>
                                        <td class="text-right">Bkash</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Transaction No:</strong></td>
                                        <td class="text-right">45454DEMO545DEMO</td>
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
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Item
                                        </th>
                                        <th class="hidden-480">
                                            Quantity
                                        </th>
                                        <th class="hidden-480">
                                            Unit Cost
                                        </th>
                                        <th>
                                            Total
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td class="hidden-480">
                                            Server hardware purchase
                                        </td>
                                        <td class="hidden-480">
                                            32
                                        </td>
                                        <td class="hidden-480">
                                            TK. 75
                                        </td>
                                        <td>
                                            TK. 2152
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2
                                        </td>
                                        <td class="hidden-480">
                                            Office furniture purchase
                                        </td>
                                        <td class="hidden-480">
                                            15
                                        </td>
                                        <td class="hidden-480">
                                            TK. 169
                                        </td>
                                        <td>
                                            TK. 4169
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3
                                        </td>
                                        <td class="hidden-480">
                                            Company Anual Dinner Catering
                                        </td>
                                        <td class="hidden-480">
                                            69
                                        </td>
                                        <td class="hidden-480">
                                            TK. 49
                                        </td>
                                        <td>
                                            TK. 1260
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3
                                        </td>
                                        <td class="hidden-480">
                                            Payment for Jan 2013
                                        </td>
                                        <td class="hidden-480">
                                            149
                                        </td>
                                        <td class="hidden-480">
                                            TK. 12
                                        </td>
                                        <td>
                                            TK. 866
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-push-8 col-xs-4 invoice-block">
                                <table style="line-height: 1.8; width: 100%;">
                                    <tr>
                                        <td><strong>Sub - Total amount:</strong></td>
                                        <td class="text-right">TK. 9265</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Discount:</strong></td>
                                        <td class="text-right">12.9%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>VAT:</strong></td>
                                        <td class="text-right">5%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grand Total:</strong></td>
                                        <td class="text-right">TK. 12489</td>
                                    </tr>
                                </table>
                                <br>
                                <div class="text-right">
                                    <a class="btn btn-sm btn-default" onclick="javascript:window.print();">
                                        Print <i class="fa fa-print"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection