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
                        <div class="client-profile clearfix">
                            <div class="client-avatar"
                                 style="background-image: url('https://ace.iafor.org/wp-content/uploads/sites/10/2017/02/IAFOR-Blank-Avatar-Image.jpg')">
                            </div>
                            <div class="client-desc">
                                <h2 class="client-name">VSD International</h2>
                                <p class="client-location">Dhaka (Dhanmondi) </p>
                                <p class="duration">Open: 3 year(s)</p>
                            </div>
                        </div>
                        <hr>

                        <div class="c-info-block">
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
                            </div>

                            <div class="plx__block">
                                <h4 class="block-title">Phone</h4>
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

                            <div class="plx__block">
                                <h4 class="block-title">Phone Number Confirmation</h4>
                                <div class="form-group">
                                    <label>A text message with a 6-digit verification code was just sent to
                                        *****-****14. If having problem please
                                        <a href="#">Resend</a>.</label>
                                    <input type="text" class="form-control" placeholder="Enter the code">
                                </div>
                                <div class="clearfix" style="margin-top: 20px;">
                                    <a href="javascript://" class="pull-left" style="margin-top: 10px;">
                                        <small class="icon-arrow-left"></small>
                                        &nbsp; Back</a>
                                    <a href="{{url('thanks-b2b')}}" type="submit" class="btn btn-primary pull-right">Place
                                        Order</a>
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
                                            <h4 class="product-title"><a href="{{url($item->options->product_url."/product-details")}}">{{@$item->name}}></a></h4>
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