<?php
$cart_content = Cart::content();
?>
@if(Cart::count()>0)
    <ul class="cart-item-list">
        @forelse($cart_content as $item)
            <li>
                <a href="{{url($item->options->product_url."/product-details")}}" class="p-pic"
                   style="background-image: url('{{url("".$item->options->image)}}');"></a>
                <div class="p-desc">
                    <h4 class="p-title"><a href="{{url($item->options->product_url."/product-details")}}">{{$item->name}}</a></h4>
                    <p class="muted-text">{{$item->qty}} x TK {{$item->price}}</p>
                </div>
                <a href="javascript:;" class="pr-btn remove-cart-item" data-row-id="{{$item->rowId}}"><i class="icon-close"></i></a>
            </li>
        @empty
        @endforelse

    </ul>

    <div class="cart-footer">
        <p class="mc-total"><strong>Subtotal: </strong> TK. {{Cart::subtotal()}}</p>

        <a href="{{url('cart')}}" class="btn btn-default btn-block">View Cart</a>
        <a href="{{url('checkout-b2b')}}" class="btn btn-success btn-block">Checkout</a>
    </div>
@else
    {{--When no product in cart--}}
    <div class="empty-container">
        No products in the cart.
    </div>
@endif