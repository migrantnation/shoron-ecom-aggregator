@extends('frontend.layouts.master')
@section('content')
    <div class="section">
        <div class="container">
            <h3 class="section-title">{{__('text.your-shopping-cart')}}
                <small>(<span id="total_item_count" class="cart-number">{{count(@$cart_content)}}</span> items)</small>
            </h3>
            <hr>

            <?php
            $encrypter = new App\Libraries\EkomEncryption($ep_info->id);
            $uid = $encrypter->encrypt();
            $util = new \App\Libraries\PlxUtilities();
            ?>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-6">
                    <a href="{{url("go-to-ep/$uid/?redirect_url=$ep_info->ep_url")}}">
                        <small class="icon-arrow-left"></small>
                        {{__('text.continue-shopping')}}</a>

                </div>

                <div class="col-md-6 text-right">
                    <a href="{{url('cart/remove-all')}}" class="">{{__('text.remove-all')}}</a>
                </div>

            </div>
            @if(@$cart_content)
                <div class="cart-box">
                    <div class="box-header">
                        <span>{{__('text.seller')}}: <strong>{{@$ep_info->ep_name}}</strong></span>
                    </div>


                    <table class="cart-table">
                        <thead>
                        <tr>
                            <th style="width: 40%;">{{__('text.product-name-&-details')}}</th>
                            <th>{{__('text.quantity')}}</th>
                            <th>{{__('text.unit-cost')}}</th>
                            <th width="50">{{__('text.price')}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $total_price = 0;
                        ?>
                        @forelse($cart_content as $item)
                            <tr id="tr_{{@$item->rowId}}">
                                <td style="width: 40%;">
                                    <div class="product-img"
                                         style="background-image: url('{{$item->image}}')"></div>
                                    <div class="product-details">
                                        <h4 class="product-title"><a
                                                    href="{{@$item->product_url}}">{{@$item->name}}</a>
                                        </h4>
                                    </div>
                                </td>
                                <td>

                                    <div class="form-group form-group-sm p-qnt-counter"> {{App::isLocale('bn')?$util->en2bnNumber(number_format(@$item->qty, 2)):number_format(@$item->qty, 2)}}</div>
                                </td>
                                <td>
                                    <strong>{{__('text.tk.')}}&nbsp;
                                        <span> {{App::isLocale('bn')?$util->en2bnNumber(number_format(@$item->unit_price, 2)):number_format(@$item->unit_price, 2)}}</span></strong>
                                    <small>/ {{__('text.price')}}</small>
                                </td>
                                <td width="80">
                                    {{__('text.tk.')}}&nbsp;{{App::isLocale('bn')?$util->en2bnNumber(number_format(@$item->price, 2)):number_format(@$item->price, 2)}}
                                </td>
                            </tr>

                            <?php $total_price = $total_price + $item->price;?>

                        @empty
                        @endforelse

                        <tr>
                            <td class=""><strong>{{__('text.udc-commission')}} &nbsp;&nbsp; {{__('text.tk.')}} {{App::isLocale('bn')?$util->en2bnNumber(number_format(@$cart_info->order_commission, 2)):number_format(@$cart_info->order_commission, 2)}}</strong></td>

                            <td colspan="4" class="text-right">

                                <span>{{__('text.total')}}: <strong>{{__('text.tk.')}}
                                        <span id="cart_view_total_price">{{App::isLocale('bn')?$util->en2bnNumber(number_format(@$total_price, 2)):number_format(@$total_price, 2)}}</span></strong>
                                </span>
                                <br><br>
                                <a href="{{url('checkout-ep')}}"
                                   class="btn btn-primary">{{__('text.buy-from-this-seller')}}</a>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                    <br>
                </div>

            @else
                {{--When no product in cart--}}
                <div class="empty-container">
                    {{__('text.no-products-in-the-cart')}}.
                </div>
            @endif
        </div>
    </div>
@endsection