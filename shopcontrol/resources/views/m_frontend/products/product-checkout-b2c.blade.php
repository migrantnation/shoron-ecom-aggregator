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
                <h4 class="m__section-block-title">User Information</h4>
                <div class="m__section-block-content">
                    <input type="text" class="m-b-10 form-control" placeholder="Enter your email">
                    <input type="text" class="m-b-10 form-control" placeholder="Enter your name">
                    <input type="text" class="m-b-5 form-control" placeholder="Enter your phone number">
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


        <div class="">
            <div class="m__section-block">
                <h4 class="m__section-block-title">Shipping Address</h4>
                <div class="m__section-block-content">
                    <select name="" id="" class="m-b-10 form-control">
                        <option value="">--Division--</option>
                        <option value="1">Dhaka</option>
                        <option value="2">Chittagong</option>
                        <option value="3">Khulna</option>
                        <option value="4">Rajshahi</option>
                        <option value="5">Barisal</option>
                        <option value="5">Sylhet</option>
                        <option value="6">Mymensingh</option>
                    </select>
                    <select name="" id="" class="m-b-10 form-control">
                        <option value="">--District--</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <select name="" id="" class="m-b-10 form-control">
                        <option value="">--Upozila--</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <input type="text" class="m-b-10 form-control" placeholder="Your address">
                    <textarea class="m-b-5 form-control" placeholder="Note" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="">
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
        </div>

        <div class="">
            <div class="m__section-block">
                <h4 class="m__section-block-title">Payment Methods</h4>
                <div class="m__section-block-content">
                    <ul class="checkout-page-list ">
                        <li>
                            <label for="bkash" class="custom-radio">
                                <input type="radio" id="bkash" name="payment">
                                <span></span>
                                <img src="{{url('')}}/assets/img/bkash.png" alt="Bkash" style="margin-top: -8px;">
                            </label>
                        </li>

                        <li>
                            <label for="mastercard" class="custom-radio">
                                <input type="radio" id="mastercard" name="payment">
                                <span></span>
                                <img src="{{url('')}}/assets/img/mastercard.png" alt="Mastercard" style="margin-top: -8px;">
                            </label>
                        </li>

                        <li>
                            <label for="visa" class="custom-radio">
                                <input type="radio" id="visa" name="payment">
                                <span></span>
                                <img src="{{url('')}}/assets/img/visa.png" alt="Visa" style="margin-top: -8px;">
                            </label>
                        </li>
                    </ul>
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