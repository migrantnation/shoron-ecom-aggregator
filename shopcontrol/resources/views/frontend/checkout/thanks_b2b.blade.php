@extends('frontend.layouts.master')
<style>
    .border-boxed {
        padding: 15px;
        border: 1px solid rgba(69, 90, 100, 0.1523);
    }
</style>
@section('content')
    <div class="section" style="min-height: 400px; margin-top: 30px;">
        <div class="container">

            <style>
                .thanks {
                    font-size: 1.2em;
                }
                .thanks p {
                    margin-bottom: 25px;
                }
                .thanks .thanks-title {
                    margin-bottom: 25px;
                }
            </style>
            <div class="row">
                <div class="col-md-6 block-center">
                    <div class="thanks text-center">
                        <h3 class="thanks-title">{{__('text.thank-you')}}</h3>
                        <p class="thanks-text">{{__('text.thanks-msg')}}</p>

                        <p>{{__('text.order-number')}} <strong>#{{@$order_details->order_code}}</strong> ({{__('text.placed-on')}} {{date("d M, Y", strtotime($order_details->created_at))}})</p>

                        <div class="col-sm-12">
                            <div class="col-sm-6"><a href="{{url('udc/order-details/'. @$order_details->id)}}" class="btn btn-info"> {{__('text.order-details')}}</a></div>

                            <div class="col-sm-6"><a href="{{url('')}}" class="btn btn-info"> {{__('text.make-more-order')}} </a></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection