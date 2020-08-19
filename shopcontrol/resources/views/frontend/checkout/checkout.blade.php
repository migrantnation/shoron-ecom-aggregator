@extends('frontend.layouts.master')
@section('content')
    <div class="plx__breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="{{url('cart')}}">Cart</a></li>
                <li class="active">Checkout</li>
            </ol>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="checkout-wrap">
                <div class="clearfix">
                    @if(@$store_info)

                        <div class="part-l">
                            <div class="client-profile clearfix">
                                <div class="client-avatar"
                                     style="background-image: url('https://ace.iafor.org/wp-content/uploads/sites/10/2017/02/IAFOR-Blank-Avatar-Image.jpg')">
                                </div>
                                <div class="client-desc">
                                    <h2 class="client-name">{{$store_info->store->store_name}}</h2>
                                    <p class="client-location">
                                        <?php
                                        $address = explode(',', $address->full_address);
                                        krsort($address);
                                        $address = implode(', ', $address);
                                        ?>
                                        {{$address}}
                                    </p>

                                    <?php
                                    $util = new \App\Libraries\PlxUtilities();
                                    $created_at = $util->time_different($store_info->created_at);
                                    ?>
                                    <p class="duration">Open: {{$created_at}}</p>
                                </div>
                            </div>
                            <hr>

                            <div class="c-info-block" style="position: relative;">

                                <div class="loading-area" id="checkout_processing" style="display: none">
                                    <div class="plx__loader" id="loading_message">Loading...</div>
                                </div>

                                @if(@$shipping_packages)

                                    <div id="shipping_form">
                                        <form id="shippingForm" name="shippingForm" action="javascript:;" method="post">
                                            <div class="plx__block" style="display: block">
                                                <h4 class="block-title">Shipping Methods</h4>

                                                <ul class="checkout-page-list ">
                                                    {{--PREVIOUSLY SELECTED LP--}}
                                                    <?php $selected_lp = session()->get('logistic_partner');?>

                                                    @forelse($shipping_packages as $shipping_package)
                                                        <?php $id = $shipping_package[0]['id']?>

                                                        <?php $cart_weight = 2000;?>
                                                        @foreach ($shipping_package as $package)
                                                            @foreach ($package->get_weight_price as $value)
                                                                @if ($value->min_weight <= $cart_weight && $value->max_weight >= $cart_weight)

                                                                    <li>
                                                                        <label for="scs{{$id}}" class="custom-radio">
                                                                            <input type="radio" id="scs{{$id}}"
                                                                                   class="required"
                                                                                   required aria-required="true"
                                                                                   name="logistic_partner"
                                                                                   value="{{$id}}"
                                                                                    {{($selected_lp==$id)?'checked="true"':''}}>
                                                                            <span></span>
                                                                            {{$shipping_package[0]['logistic_partner']->lp_name}}
                                                                            {!! ' ( Weight: ' . $value->min_weight . ' - ' . $value->max_weight .' Charge:   TK.'. $value->price.')'!!}

                                                                        </label>
                                                                    </li>

                                                                @endif
                                                            @endforeach
                                                        @endforeach

                                                    @empty

                                                    @endforelse

                                                    <li class="separator-title">
                                                        UDC's Shipping
                                                    </li>

                                                    <li>
                                                        <label for="udcs" class="custom-radio">
                                                            <input type="radio" class="required " required
                                                                   aria-required="true"
                                                                   id="udcs" name="logistic_partner">
                                                            <span></span>
                                                            UDC Standard Shipping (TK. 120.00)
                                                        </label>
                                                    </li>
                                                </ul>

                                                <label class="error" id="logistic_partner_message"></label>
                                            </div>

                                            <div class="plx__block" id="contact_number_form">
                                                <h4 class="block-title">Phone</h4>
                                                <div class="form-group">
                                                    <input type="text" class="form-control required"
                                                           placeholder="Enter your phone number"
                                                           name="contact_number" id="contact_number" value="" required>
                                                    <label class="error" id="contact_number_message"></label>
                                                </div>
                                                <div class="clearfix" style="margin-top: 20px;">
                                                    <a href="{{url('cart')}}" class="pull-left"
                                                       style="margin-top: 10px;">
                                                        <small class="icon-arrow-left"></small>
                                                        &nbsp; Return to Cart</a>
                                                    <button type="submit" class="btn btn-primary pull-right"
                                                            id="submit_shipping_form">Submit
                                                    </button>
                                                </div>
                                            </div>
                                            <label class="error" id="form_message"></label>
                                        </form>
                                    </div>

                                    <div class="plx__block" id="verification_form" style="display: none">
                                        <h4 class="block-title">Phone Number Confirmation</h4>
                                        <div class="form-group">
                                            <label>A text message with a 6-digit verification code was just sent to
                                                <strong>
                                                <span class="contact_number_value"
                                                      style="color:purple; font-weight: 300"></span>.</strong>
                                                If having problem please
                                                <a href="javascript:;" id="resend_varification_code">Resend</a>.</label>
                                            <input type="text" class="form-control" placeholder="Enter the code"
                                                   name="varification_code" id="varification_code" value="">
                                        </div>
                                        <div class="clearfix" style="margin-top: 20px;">
                                            <a href="javascript://" class="pull-left" style="margin-top: 10px;">
                                                <small class="icon-arrow-left"></small> &nbsp; Back</a>
                                            <a href="{{url('thanks-b2b')}}" type="submit"
                                               class="btn btn-primary pull-right">
                                                Place Order
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    @else

                        <div class="part-l">
                            <div class="c-info-block">
                                <div class="plx__block">
                                    <h4 class="block-title">User Information</h4>

                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter your email">
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter your name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter your phone number">
                                    </div>

                                    <div class="clearfix" style="margin-top: 20px;">
                                        <a href="{{url('cart')}}" class="pull-left" style="margin-top: 10px;">
                                            <small class="icon-arrow-left"></small>
                                            &nbsp; Return to Cart</a>
                                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                    </div>
                                </div>

                                <div class="c-info-block">
                                    <div class="plx__block">
                                        <h4 class="block-title">Phone Number Confirmation</h4>

                                        <div class="form-group">
                                            <label>A text message with a 6-digit verification code was just sent to
                                                *****-****14. If having problem please
                                                <a href="#">Resend</a>.</label>
                                            <input type="text" class="form-control" placeholder="Enter the code">
                                        </div>
                                        <div class="clearfix" style="margin-top: 20px;">
                                            <a href="cart.php" class="pull-left" style="margin-top: 10px;">
                                                <small class="icon-arrow-left"></small>
                                                &nbsp; Back</a>
                                            <button type="submit" class="btn btn-primary pull-right">Confirm</button>
                                        </div>
                                    </div>
                                    <div class="plx__block">
                                        <h4 class="block-title">Shipping Address</h4>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select name="" id="" class="form-control">
                                                        <option value="">--Division--</option>
                                                        <option value="1">Dhaka</option>
                                                        <option value="2">Chittagong</option>
                                                        <option value="3">Khulna</option>
                                                        <option value="4">Rajshahi</option>
                                                        <option value="5">Barisal</option>
                                                        <option value="5">Sylhet</option>
                                                        <option value="6">Mymensingh</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select name="" id="" class="form-control">
                                                        <option value="">--District--</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select name="" id="" class="form-control">
                                                        <option value="">--Upozila--</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Your address">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Note" rows="3"></textarea>
                                        </div>

                                        <div class="clearfix" style="margin-top: 20px;">
                                            <a href="javascript://" class="pull-left" style="margin-top: 10px;">
                                                <small class="icon-arrow-left"></small>
                                                &nbsp; Back</a>
                                            <button type="submit" class="btn btn-primary pull-right">Continue to
                                                Shipping Method
                                            </button>
                                        </div>
                                    </div>

                                    <div class="plx__block">
                                        <h4 class="block-title">Shipping Methods</h4>

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

                                        <div class="clearfix" style="margin-top: 20px;">
                                            <a href="javascript://" class="pull-left" style="margin-top: 10px;">
                                                <small class="icon-arrow-left"></small>
                                                &nbsp; Back</a>
                                            <button type="submit" class="btn btn-primary pull-right">Continue to Payment
                                                Method
                                            </button>
                                        </div>
                                    </div>

                                    <div class="plx__block">
                                        <h4 class="block-title">Shipping Methods</h4>

                                        <ul class="checkout-page-list ">
                                            <li>
                                                <label for="bkash" class="custom-radio">
                                                    <input type="radio" id="bkash" name="payment">
                                                    <span></span>
                                                    <img src="assets/img/bkash.png" alt="Bkash"
                                                         style="margin-top: -8px;">
                                                </label>
                                            </li>

                                            <li>
                                                <label for="mastercard" class="custom-radio">
                                                    <input type="radio" id="mastercard" name="payment">
                                                    <span></span>
                                                    <img src="assets/img/mastercard.png" alt="Mastercard"
                                                         style="margin-top: -8px;">
                                                </label>
                                            </li>

                                            <li>
                                                <label for="visa" class="custom-radio">
                                                    <input type="radio" id="visa" name="payment">
                                                    <span></span>
                                                    <img src="assets/img/visa.png" alt="Visa" style="margin-top: -8px;">
                                                </label>
                                            </li>
                                        </ul>

                                        <div class="clearfix" style="margin-top: 20px;">
                                            <a href="javascript://" class="pull-left" style="margin-top: 10px;">
                                                <small class="icon-arrow-left"></small>
                                                &nbsp; Back</a>
                                            <a href="{{url('thanks-b2c')}}" type="submit"
                                               class="btn btn-primary pull-right">Place Order</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif

                    <div class="part-r">
                        <table class="cart-table">
                            <thead>
                            <tr>
                                <th>Product Name &amp; Details</th>
                                <th width="80">Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total_price = 0;
                            ?>
                            @if($cart_content->count()>0)
                                @forelse($cart_content as $item)
                                    <?php
                                    $total_price += $item->qty * $item->price;
                                    ?>
                                    {{$item->attributes}}
                                    <tr>
                                        <td>
                                            <div class="product-img"
                                                 style="background-image: url('{{url("".$item->options->image)}}')"></div>
                                            <div class="product-details">
                                                <h4 class="product-title"><a
                                                            href="{{url($item->options->product_url."/product-details")}}">{{@$item->name}}
                                                        ></a></h4>
                                                @foreach($item->options->attributes as $key => $each_attribute)
                                                    <p>{{$key}}: {{$each_attribute}}</p>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td width="80">
                                            <strong>TK. {{$item->price}}</strong>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            @else
                                <tr>
                                    <td colspan="2 center"><h3>Cart is empty</h3></td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <hr>
                        <div class="clearfix">
                            <button type="submit" class="btn btn-default pull-right" disabled
                                    style="margin-left: 15px;">Apply
                            </button>
                            <div style="overflow: hidden;">
                                <input type="text" class="form-control" placeholder="Discount">
                            </div>
                        </div>
                        <hr>
                        <table style="width: 100%; line-height: 1.9;">
                            <tr>
                                <td>Subtotal</td>
                                <td class="text-right">TK. {{$total_price}}</td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td class="text-right">TK. 0.00</td>
                            </tr>
                            <tr>
                                <td>Taxes</td>
                                <td class="text-right">TK. 0.00</td>
                            </tr>
                        </table>
                        <hr>
                        <table style="width: 100%; line-height: 1.9;">
                            <tr>
                                <td>Total</td>
                                <td class="text-right"><span class="muted-text">TK.</span>
                                    <strong>{{$total_price}}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.js"></script>
    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.validate.js"></script>
    <script>
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#shippingForm").validate({
                messages: {
                    contact_number: "Please enter your contact number",
                    logistic_partner: "Please enter your contact number",
                },
                rules: {
                    contact_number: {
                        required: true
                    },
                    logistic_partner: {
                        required: true
                    }
                }
            });

        });
    </script>

    <script src="{{url('public/js/front/checkout.js')}}"></script>

@endsection