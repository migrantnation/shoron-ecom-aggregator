@extends('m_frontend.layouts.master')
@section('content')

    <div class="m__title-bar">
        <a href="{{url('m/product/cart')}}" class="m__back-btn"><i class="pe-7s-angle-left"></i></a>
        <div class="clearfix">
            <span class="pull-left m__title">Checkout</span>
        </div>
    </div>

    <div class="m__cart">
        <div class="">
            <div class="m__section-block">
                <div class="m__section-block-content">
                    <div class="client-profile clearfix">
                        <div class="client-avatar" style="background-image: url('{{url('')}}/assets/img/store-img-01.jpg')">
                        </div>

                        <div class="client-desc">
                            <h2 class="client-name">VSD International</h2>
                            <p class="client-location">Dhaka (Dhanmondi) </p>
                            <p class="duration">Open: 3 year(s)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m__section-block">
                <h4 class="m__section-block-title">Shipping Methods</h4>
                <div class="m__section-block-content">
                    <ul class="checkout-page-list ">
                        <li>
                            <label for="scs" class="custom-radio">
                                <input type="radio" id="scs" name="logistics">
                                <span></span>
                                Sundarban Courier Service (TK. 120.00)
                            </label>
                        </li>

                        <li>
                            <label for="sap" class="custom-radio">
                                <input type="radio" id="sap" name="logistics">
                                <span></span>
                                SA Paribahan (TK. 120.00)
                            </label>
                        </li>

                        <li>
                            <label for="ccs" class="custom-radio">
                                <input type="radio" id="ccs" name="logistics">
                                <span></span>
                                Continental Courier Service (TK. 120.00)
                            </label>
                        </li>

                        <li class="separator-title">
                            UDC's Shipping
                        </li>

                        <li>
                            <label for="udcs" class="custom-radio">
                                <input type="radio" id="udcs" name="logistics">
                                <span></span>
                                UDC Standard Shipping (TK. 120.00)
                            </label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="m__section-block">
                <h4 class="m__section-block-title">Phone</h4>
                <div class="m__section-block-content">
                    <input type="text" class="form-control m-b-5" placeholder="Enter your phone number">
                </div>
            </div>
        </div>

        <div class="">
            <div class="m__section-block">
                <h4 class="m__section-block-title">Phone Number Confirmation</h4>
                <div class="m__section-block-content">
                    <p>A text message with a 6-digit verification code was just sent to *****-****14. If having problem please Resend.</p>
                    <input type="text" class="form-control m-b-5" placeholder="Enter the code">
                </div>
            </div>
        </div>

        <div class="m__section-block">
            <h4 class="m__section-block-title">Price Details</h4>
            <div class="m__section-block-content">
                <div class="clearfix">
                    <button type="submit" class="btn btn-default pull-right" disabled="" style="margin-left: 15px;">Apply</button>
                    <div style="overflow: hidden;">
                        <input type="text" class="form-control" placeholder="Discount">
                    </div>
                </div>

                <hr class="m__hr">

                <table class="m__price-detail-table">
                    <tr>
                        <td>Price (3 items)</td>
                        <td class="text-right">TK 2693</td>
                    </tr>
                    <tr>
                        <td>Delivery</td>
                        <td class="text-right"><span class="text-success">TK. 256</span></td>
                    </tr>
                    <tfoot>
                    <tr>
                        <td>Amount Payable</td>
                        <td class="text-right">TK. 2693</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="m__section-block">
            <div class="m__action-btn m__btns-fixed">
                <div class="m__pd-l-part">
                    <strong>TK 2663</strong>
                </div>
                <div class="m__pd-r-part text-right">
                    <a href="{{url('m')}}/product/checkout" class="btn btn-success">Continue</a>
                </div>
            </div>
        </div>
    </div>

@endsection