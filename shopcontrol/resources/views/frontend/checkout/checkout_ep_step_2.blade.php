@extends('frontend.layouts.master')
@section('content')

    <?php
    $util = new \App\Libraries\PlxUtilities();
    ?>

    <div id="page-freezer" class="loading-overlay" style="display: none">
        <div class="loading-inner">
            <div class="loader-box">
                <div class="box-inner">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img class="loader-logo"
                         src="{{asset("public/assets/img/loading_logo.png")}}" alt="_ecom_">
                </div>
            </div>
            <div class="loading-text"><span>Processing...</span></div>
        </div>
    </div>

    <div class="plx__breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{url('')}}">{{__('text.home')}}</a></li>
                <li><a href="{{url('cart')}}">{{__('text.cart')}}</a></li>
                <li class="active">{{__('text.checkout')}}</li>
            </ol>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="checkout-wrap">
                <div class="clearfix">
                    <form name="" id="place-order-form" action="{{url('send-otc')}}" method="post">
                        {{csrf_field()}}
                        <div class="part-l">
                            <div class="client-profile clearfix">
                                <div class="client-avatar"
                                     style="background-image: url('https://ace.iafor.org/wp-content/uploads/sites/10/2017/02/IAFOR-Blank-Avatar-Image.jpg')">
                                </div>
                                @if(@$user_info->upazila)
                                    <?php $address[] = @$user_info->upazila?>
                                @endif

                                @if(@$user_info->union)
                                    <?php $address[] = @$user_info->union?>
                                @endif

                                @if(@$user_info->district)
                                    <?php $address[] = @$user_info->district?>
                                @endif

                                @if(@$user_info->division)
                                    <?php $address[] = @$user_info->division?>
                                @endif

                                <div class="client-desc">
                                    <h2 class="client-name">{{@$user_info->center_name}}</h2>
                                    <p class="client-location">
                                        {{__('text.address')}}: {{(isset($address))?implode(', ', $address):''}}</p>
                                    <p class="client-location">
                                        {{__('text.mobile-no')}}.:
                                        {{@$user_info->contact_number?$user_info->contact_number:@$user_info->phone}}
                                    </p>
                                </div>
                            </div>
                            <hr>

                            <div class="c-info-block">
                                <div class="plx__block">
                                    <div class="clearfix">
                                        <h4 class="block-title">{{__('text.shipping-address')}}</h4>
                                    </div>

                                    <p>{{(isset($address))?implode(', ', $address):''}}</p>
                                </div>

                                <div class="plx__block">
                                    <div class="clearfix">
                                        <h4 class="block-title">{{__('text.ep')}}</h4>
                                    </div>

                                    <p>
                                        &nbsp; {{@$ep_info->ep_name}}&nbsp;&nbsp;

                                        @if(@$ep_info->ep_logo)
                                            <img src="{{asset("public/content-dir/ecommerce_partners"."/".@$ep_info->ep_logo)}}"
                                                 width="60px">
                                        @endif

                                        <a href="{{@$ep_info->ep_url}}">Continue Shopping</a>

                                    </p>

                                </div>

                                <div class="plx__block">
                                    <h4 class="block-title">{{__('text.shipping-methods')}}</h4>

                                    <p>

                                        {{@$cart_details->lp_name}} &nbsp;

                                        {{--LP LOGO--}}
                                        @if(@$lp_info->lp_logo)
                                            <img src="{{asset("public/content-dir/logistic_partners"."/".@$lp_info->lp_logo)}}"
                                                 alt="LP" style="height: 20px; margin-right: 5px;">
                                        @endif

                                        ({{@$cart_details->delivery_duration}}) -
                                        <?php
                                        $pkg = new \App\Libraries\Package();
                                        $delivery_charge = @$cart_details->lp_delivery_charge;
                                        ?>
                                        @if(in_array($cart_details->ep_id, $pkg->freeShippingEp())  && @$lp_info->id != 13)
                                            <strong>{{"Free Shipping"}}</strong>
                                        @else
                                            <strong>
                                                {{__('text.tk.')}}
                                                {{App::isLocale('bn')?$util->en2bnNumber(number_format($delivery_charge, 2)):number_format($delivery_charge, 2)}}
                                            </strong>
                                        @endif

                                    </p>
                                </div>

                                <div class="plx__block">
                                    <h4 class="block-title">{{__('text.phone')}}</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" readonly
                                               placeholder="Enter your phone number" name="contact_number"
                                               value="{{@$user_info->contact_number}}">
                                    </div>
                                </div>


                                <div class="plx__block ">
                                    <h4 class="block-title">{{__('text.payment-methods')}}</h4>

                                    <ul class="checkout-page-list">
                                        <li>
                                            <label class="">
                                                <input type="radio" name="payment_method"
                                                       {{$cart_details->payment_method == 1 ? 'checked':''}}
                                                       value="1" checked> &nbsp;{{__('text.cash-on-delivery')}}

                                            </label>
                                        </li>
                                        <li>
                                            <label class="">
                                                <input disabled type="radio" name="payment_method"
                                                       {{$cart_details->payment_method == 2 ? 'checked':''}}
                                                       value="2">&nbsp; <strike
                                                        style="opacity: .4">{{__('text.other-payment-methods')}}</strike>
                                                (শীঘ্রই আসছে)

                                            </label>
                                        </li>
                                    </ul>
                                    <p class="error">{{@session('payment-method-exception')}}</p>
                                </div>

                                <div class="plx__block">
                                    <div class="clearfix" style="margin-top: 20px;">
                                        <a href="{{url('checkout-ep')}}" class="pull-left" style="margin-top: 10px;">
                                            <small class="icon-arrow-left"></small>
                                            &nbsp; {{__('text.back')}}
                                        </a>
                                        <button type="button" class="btn btn-primary pull-right continue" id="btnDisabled">
                                            {{__('text.place-order')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="part-r">
                        @include('frontend.cart.cart_detail')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.continue').on('click', function () {

            $.confirm({
                icon: 'fa fa-question',
                theme: 'material',
                content: '{{__('text.place-order-confirm-text')}}',
                closeIcon: true,
                animation: 'scale',
                type: 'orange',
                title: '{{__('text.confirmation')}}',
                buttons: {
                    'confirm': {
                        text: '{{__('text.continue')}}',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#page-freezer').show();
                            $('#btnDisabled').attr("disabled", true);
                            $("#place-order-form").submit();
                        }
                    },
                    '{{__('_ecom__text.cancel')}}': {}
                }
            });
        });

    </script>

@endsection