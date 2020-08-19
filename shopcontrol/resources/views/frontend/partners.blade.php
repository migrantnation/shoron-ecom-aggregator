@extends('frontend.layouts.master')
@section('content')
    <section class="partners-wrap">
        <br>
        <div class="container">
            <div class="text-center" style="margin-bottom: 40px;">
                <h3>eCommerce Partners</h3>
            </div>

            <div class="row partner-list">
                @forelse(@$e_commerce_partners as $each_partner)
                    <div class="col-sm-3">
                        {{--<a href="{{@$each_partner->ep_url}}" target="_blank" title="{{@$each_partner->ep_name}}">--}}
                        <div class="partner" title="{{@$each_partner->ep_name}}">
                            <img src="{{url("public/content-dir/ecommerce_partners/$each_partner->ep_logo")}}"
                                 alt="{{@$each_partner->ep_name}}">
                        </div>
                        {{--</a>--}}
                    </div>
                @empty
                @endforelse
            </div>

            <div style="margin-bottom: 50px;">&nbsp;</div>
            <hr>
            <br>
            <div class="text-center" style="margin-bottom: 40px;">
                <h3>Logistic Partners</h3>
            </div>

            <div class="row partner-list">

                @forelse($logistic_partners as $each_partner)

                    <div class="col-sm-3">
                        <div class="partner" title="ep_partner2">
                            <img src="{{url("public/content-dir/logistic_partners/$each_partner->lp_logo")}}"
                                 alt="{{@$each_partner->lp_name}}">
                        </div>
                    </div>

                @empty
                @endforelse

            </div>
            <div style="margin-bottom: 50px;">&nbsp;</div>
        </div>
    </section>
@endsection