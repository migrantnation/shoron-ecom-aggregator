<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    @include('frontend.layouts.includes.header_files')
</head>

<body class="plx__page">

<div>


    @yield('content')
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
                        <p><img src="{{url('public/assets/img/_ecom__logo.png')}}" width="180px"></p>

                        @if(session('order-complete'))
                            <h3 class="thanks-title">অভিনন্দন!!!</h3>
                            <p class="thanks-text">আপনি আপনার পণ্যটি গ্রহণ করেছেন। <br> এক-শপ সেবাটি ব্যবহার করায় আপনাকে অসংখ্য ধন্যবাদ।</p>
                            <p>পরবর্তী কার্যক্রমের জন্য আপনাকে আবার একসেবা হয়ে সিস্টেম এ আসতে হবে।</p>
                        @else
                            <h3 class="thanks-title">দুঃখিত!!!</h3>
                            <p class="thanks-text">একসেবা থেকে আপনাকে দেয়া নির্ধারিত সময় শেষ।</p>
                            <p class="thanks-text">পরবর্তী কার্যক্রমের জন্য আপনাকে আবার একসেবা হয়ে সিস্টেম এ আসতে হবে।</p>
                        @endif


                        <div class="col-sm-12">
                            <div class="col-sm-12"><a href="{{url('')}}" class="btn btn-info text-center">ঠিক আছে </a></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        session()->forget('order-complete');
        session()->forget('partner-session-expire');
    @endphp
</div>

</body>

</html>