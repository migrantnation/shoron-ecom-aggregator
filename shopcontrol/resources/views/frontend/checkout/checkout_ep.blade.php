@extends('frontend.layouts.master')
@section('content')
    <?php
    $util = new \App\Libraries\PlxUtilities();
    $check_mode = $util->check_application_mode();
    ?>
    <div class="plx__breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{@$base_url.'/'}}">{{__('text.home')}}</a></li>
                <li><a href="{{@$base_url.'cart'}}">{{__('text.cart')}}</a></li>
                <li class="active">{{__('text.checkout')}}</li>
            </ol>
        </div>
    </div>

    <div class="section">
        <div class="container">

            @if($check_mode == 2)
                <div class="alert alert-warning text-center" role="alert" style="margin-bottom: 30px;">
                    <span style="font-size: 1.5em; color: #9C27B0">{{__('text.under-development')}}</span>
                </div>
            @endif

            <div class="checkout-wrap">
                <div class="clearfix">
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
                                <p class="client-location">{{__('text.address')}}
                                    : {{(isset($address))?implode(', ', $address):''}}</p>
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
                                    {{--<a href="#" class="pull-right">{{__('text.change')}}</a>--}}
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
                                             width="60px">                                        &nbsp;
                                    @endif

                                    <a href="{{@$ep_info->ep_url}}">Continue Shopping</a>

                                </p>

                            </div>
                            <form name="lpSelectForm" id="lpSelectForm"
                                  action="{{@$base_url.'select-lp'}}" method="post">
                                <input type="hidden" name="_token" value="{{$csrf_v_token}}">
                                <div class="plx__block">
                                    <h4 class="block-title">{{__('text.shipping-methods')}}</h4>

                                    <?php $pkg = new \App\Libraries\Package(); ?>

                                    <ul class="checkout-page-list">
                                        <?php $package_found = false;?>
                                        @forelse($lps as $lp)
                                            @if($lp->packages)
                                                @forelse($lp->packages as $package)
                                                    <?php $price = App::isLocale('bn') ? $util->en2bnNumber(number_format(@$package->price, 2)) : number_format(@$package->price, 2); ?>

                                                    <li>
                                                        <label class="custom-radio">

                                                            {{--LP SELECTION--}}
                                                            <input type="radio" name="lp_package_id"
                                                                   {{@$cart_details->lp_package_id == @$package->id?'checked':''}}
                                                                   value="{{@$package->id}}" data-package-id="{{@$package->id}}"
                                                                   data-package-price="{{(in_array(@$ep_info->id, @$pkg->freeShippingEp()) && $lp->id != 13)?0.00:@$package->price}}"
                                                                    {{(@$package->lp_id == 1) ? 'checked':''}}>
                                                            <span></span>

                                                            {{--LP LOGO--}}
                                                            @if(@$lp->lp_logo)
                                                                <img src="{{asset("public/content-dir/logistic_partners"."/".@$lp->lp_logo)}}"
                                                                     alt="LP" style="height: 20px; width: auto; margin-right: 5px;">
                                                            @endif

                                                            {{--LP NAME--}}
                                                            {{@$lp->lp_name}}

                                                            {{--LP PACKAGE INFO--}} &nbsp;&nbsp;
                                                            ({{@$package->delivery_duration}}) -
                                                            {{(in_array(@$ep_info->id, @$pkg->freeShippingEp()) && $lp->id != 13)?'Free Shipping':__('text.tk.') . $price}}


                                                            <?php $package_found = true;?>
                                                        </label>
                                                    </li>
                                                @empty
                                                @endforelse
                                            @else
                                            @endif
                                        @empty

                                        @endforelse

                                        @if($package_found != true)
                                            {{__('text.no-lp')}} <b>({{__('text.coming-soon')}})</b>
                                        @endif
                                    </ul>


                                    @if(@$check_mode == 1 || Auth::user()->status == 1)
                                        <div class="clearfix" style="margin-top: 20px;">
                                            <button type="submit"
                                                    class="btn btn-primary pull-right">{{__('text.continue')}}</button>
                                        </div>
                                    @endif
                                </div>

                            </form>

                        </div>
                    </div>

                    <div class="part-r">
                        @include('frontend.cart.cart_detail')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var lang = '{{App::isLocale('bn') ? 'bangla' : 'english'}}';


        $('input[type=radio][name=lp_package_id]').change(function () {
            var display_price = 0.00;
            var package_price = parseFloat($(this).data("package-price"));
            var cart_sub_total = parseFloat($("#cart_sub_total").data('sub-total'));
            var cart_total = (cart_sub_total + package_price);

            cart_total = number_format(cart_total, 2);
            package_price = number_format(package_price, 2);

            package_price = lang && lang == 'bangla' ? package_price == 0 ? 0.00 : (package_price).getDigitBanglaFromEnglish() : (package_price);
            cart_total = lang && lang == 'bangla' ? cart_total == 0 ? 0.00 : (cart_total).getDigitBanglaFromEnglish() : (cart_total);

            $("#delivery_charge").html(package_price);
            $("#cart_total").html(cart_total);
        });

    </script>
@endsection