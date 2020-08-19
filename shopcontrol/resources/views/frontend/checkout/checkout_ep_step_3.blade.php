@extends('frontend.layouts.master')
@section('content')
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

                    <form name="" id="" action="{{url('confirm-otc')}}" method="post">
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
                                       {{__('tect.address')}} {{(isset($address))?implode(', ', $address):''}}</p>
                                    <p class="client-location">
                                        {{__('tect.mobile-no')}}.:
                                        {{@$user_info->contact_number?$user_info->contact_number:@$user_info->phone}}
                                    </p>
                                </div>

                            </div>
                            <hr>

                            <div class="c-info-block">
                                <div class="plx__block">
                                    <h4 class="block-title">{{__('text.phone-number-confirmation')}}</h4>

                                    <div class="form-group">
                                        <label>A text message with 6-digits OTP has been sent to
                                            +880****-****{{substr($user_info->contact_number, -3)}}. <br>
                                            Having trouble getting the code, <a href="#">Resend</a>.
                                            &nbsp;&nbsp; {{$user_info->otc}}</label>
                                        <input type="text" class="form-control" placeholder="Enter the code" id="otc" name="otc">
                                        <p class="error">{{ $errors->first('otc')}}</p>
                                    </div>

                                    <div class="clearfix" style="margin-top: 20px;">

                                        <a href="{{url('checkout-step-2')}}" class="pull-left"
                                           style="margin-top: 10px;">
                                            <small class="icon-arrow-left"></small>
                                            &nbsp;  {{__('text.back')}}
                                        </a>

                                        <button type="submit" class="btn btn-primary pull-right">
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
@endsection