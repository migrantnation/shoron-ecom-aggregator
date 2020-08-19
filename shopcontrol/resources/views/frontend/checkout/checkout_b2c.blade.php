@extends('frontend.layouts.master')
@section('content')
    <div class="plx__breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Cart</a></li>
                <li class="active">Checkout</li>
            </ol>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="checkout-wrap">
                <div class="clearfix">
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
                                        <label>A text message with a 6-digit verification code was just sent to *****-****14. If having problem please
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
                                        <button type="submit" class="btn btn-primary pull-right">Continue to Shipping Method</button>
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
                                        <button type="submit" class="btn btn-primary pull-right">Continue to Payment Method</button>
                                    </div>
                                </div>

                                <div class="plx__block">
                                    <h4 class="block-title">Shipping Methods</h4>

                                    <ul class="checkout-page-list ">
                                        <li>
                                            <label for="bkash" class="custom-radio">
                                                <input type="radio" id="bkash" name="payment">
                                                <span></span>
                                                <img src="public/assets/img/bkash.png" alt="Bkash" style="margin-top: -8px;">
                                            </label>
                                        </li>

                                        <li>
                                            <label for="mastercard" class="custom-radio">
                                                <input type="radio" id="mastercard" name="payment">
                                                <span></span>
                                                <img src="public/assets/img/mastercard.png" alt="Mastercard" style="margin-top: -8px;">
                                            </label>
                                        </li>

                                        <li>
                                            <label for="visa" class="custom-radio">
                                                <input type="radio" id="visa" name="payment">
                                                <span></span>
                                                <img src="public/assets/img/visa.png" alt="Visa" style="margin-top: -8px;">
                                            </label>
                                        </li>
                                    </ul>

                                    <div class="clearfix" style="margin-top: 20px;">
                                        <a href="javascript://" class="pull-left" style="margin-top: 10px;">
                                            <small class="icon-arrow-left"></small>
                                            &nbsp; Back</a>
                                        <a href="{{url('thanks-b2c')}}" type="submit" class="btn btn-primary pull-right">Place Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                            <h4 class="product-title"><a href="{{url($item->options->product_url."/product-details")}}">{{@$item->name}}</a></h4>
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
                                <td class="text-right"><span class="muted-text">TK.</span> <strong>{{$total_price}}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection