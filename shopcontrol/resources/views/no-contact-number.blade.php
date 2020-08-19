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
    <div class="page-not-found">
        <div class="container">
            <div class="content-404">
                {{--<span class="text-404">4<i class="icon-ban"></i>4</span>--}}
                <span class="text-404"><img src="{{url('')}}/admin_ui_assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" style="width:130px"></span>
                <div class="alert alert-warning text-center" style="line-height: 28px;font-size: 18px;padding: 25px;">
                    <strong>আপনার মোবাইল ফোন নম্বর একসেবা সিস্টেমে লিপিবদ্ধ নেই। আপনি আপনার একসেবা একাউন্ট-এ মোবাইল ফোন নম্বর যোগ করে পুনরায় একশপের সার্ভিসে প্রবেশ করুন। একশপে অর্ডার সম্পন্ন করার জন্য মোবাইল ফোন নম্বর খুবই জরুরী।</strong><br><br>
                    <a class="btn btn-primary" href="http://partner.com/">একসেবা</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>