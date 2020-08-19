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
    @include('frontend.layouts.includes.header')
    @include('warning')
    @yield('content')
    @include('frontend.layouts.includes.footer'.@$footer)

    @include('frontend.layouts.includes.footer_files'.@$footer)

    <div id="promoToast" class="promo-toast show"></div>
</div>

<?php
$message = session()->get("message");
session()->forget("message");
?>

@if($message)
    <script>
        errorToast("{!! $message !!}");
    </script>
@endif

<script>
    var url = "{{url('new-order-toast')}}";

    setInterval(function () {
        newOrderToast();
    }, 20000);
    $(document).on('click', '.closeToast', function (e) {
        e.preventDefault();
        $(this).closest('#promoToast').removeClass('show');
    });
    function newOrderToast() {
        $.ajax({
            url: url,
            type: "get",
            dataType: 'json',
            data: {},
            success: function (html) {
                var img = '';
                if (html.product_image) {
                    img = `<img src="${html.product_image}" alt="">`;;
                }
                $('#promoToast').html(`
                    <a target="_blank" href="${html.product_url}" class="promo-product clearfix">
                        <span class="closeToast">&times;</span>
                        ${img}
                        <div class="promo-desc">
                            {{ __('text.already-buy-notice') }} <br> <span class="product-name">${html.product_name}</span>
                        </div>
                    </a>
                `).addClass('show');
            }
        });
        setTimeout(function(){
            $('#promoToast').removeClass('show');
        }, 10000);
    }
</script>

</body>

</html>