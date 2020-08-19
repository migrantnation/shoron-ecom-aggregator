<?php
$cart_content = json_decode($cart_details->cart_detail)->cart;
$ep_delivery_charge = $cart_details->ep_delivery_charge;
$lp_delivery_charge = $cart_details->lp_delivery_charge;
$udc_commission = $cart_details->order_commission;

$util = new \App\Libraries\PlxUtilities();
?>
<table class="cart-table">
    <thead>
    <tr>
        <th width="80%">{{__('text.product-name-&-details')}}</th>
        <th width="20%" class="text-right">{{__('text.price')}}</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sub_total = 0;
    $delivery_charge = 0;
    $total = 0;
    $tax = 0;
    ?>
    @forelse($cart_content as $item)
        <tr>
            <td width="60%">
                <div class="product-img"
                     style="background-image: url('{{url("".@$item->image)}}')"></div>
                <div class="product-details">
                    <h4 class="product-title">
                        <a href="{{@$item->product_url}}">{{@$item->name}}</a>
                    </h4>
                    @if(@$item->product_attributes)
                        <span>{!! @$item->product_attributes!!}</span>
                        <br>
                    @endif
                    @if(@$item->product_detail)
                        <span>{!! @$item->product_detail!!}</span>
                        <br>
                    @endif
                    {{__('text.quantity')}}:
                    {{App::isLocale('bn')?$util->en2bnNumber($item->qty):$item->qty}}

                    <br>
                    {{__('text.unit-cost')}}:
                    {{App::isLocale('bn')?$util->en2bnNumber(number_format($item->unit_price, 2)):number_format($item->unit_price, 2)}}
                </div>
            </td>
            <td width="20%" class="text-right" style="vertical-align: top">
                <strong>{{__('text.tk.')}}
                    {{App::isLocale('bn')?$util->en2bnNumber(number_format($item->price, 2)):number_format($item->price, 2)}}
                </strong>
                <?php $sub_total += $item->price?>
            </td>
        </tr>
    @empty

    @endforelse
    </tbody>
</table>

<hr>

<?php $delivery_charge = $ep_delivery_charge + $lp_delivery_charge;?>
<table style="width: 100%; line-height: 1.9;">
    <tr>
        <td width="80%">{{__('text.subtotal')}}</td>
        <td width="20%" class="text-right">{{__('text.tk.')}}
            <span id="cart_sub_total" data-sub-total="{{$sub_total}}">
                {{App::isLocale('bn')?$util->en2bnNumber(number_format($sub_total, 2)):number_format($sub_total, 2)}}
            </span>
        </td>
    </tr>

    <tr>
        <td width="80%">{{__('text.shipping')}}</td>
        <td width="20%" class="text-right">{{__('text.tk.')}}
            <span id="delivery_charge">
                <?php
                $pkg = new \App\Libraries\Package();
                $delivery_charge = (in_array($cart_details->ep_id, $pkg->freeShippingEp())  && @$lp_info->id != 13) ? 0.00 : $delivery_charge;
                ?>
                {{App::isLocale('bn')?$util->en2bnNumber(number_format($delivery_charge, 2)):number_format($delivery_charge, 2)}}

            </span>
        </td>
    </tr>

    <?php $total = $sub_total + $delivery_charge + $tax;?>
</table>
<hr>
<table style="width: 100%; line-height: 1.9;">
    <tr>
        <td>{{__('text.total')}}</td>
        <td class="text-right"><span class="muted-text">{{__('text.tk.')}}</span>
            <strong>
                <span id="cart_total">
                    {{App::isLocale('bn')?$util->en2bnNumber(number_format($total, 2)):number_format($total, 2)}}
                </span>
            </strong>
        </td>
    </tr>
</table>
<hr>
<br>
<table style="width: 100%; line-height: 1.9;">
    <tr>
        <td class=""><strong>{{__('text.udc-commission')}}</strong></td>
        <td class="text-right"><span
                    class="muted-text">{{__('text.tk.')}}</span><strong>{{App::isLocale('bn')?$util->en2bnNumber(number_format($udc_commission, 2)):number_format($udc_commission, 2)}}</strong>
        </td>
    </tr>
</table>