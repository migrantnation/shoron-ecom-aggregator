<?php $total_product = 0; $i = $total_row ? $total_row : 1;?>

<div class="nextSearch"></div>

<?php
$popup_checked = \Illuminate\Support\Facades\Auth::user()->popup_checked;
$status = \Illuminate\Support\Facades\Auth::user()->status;
?>
@forelse($product_list as $product)
    <?php
    $encrypter = new App\Libraries\EkomEncryption($product->ep_info->id);
    $uid = $encrypter->encrypt();
    ?>
    <div class="product-grid productWrap" id="{{$i}}">
        <div class="product">

            <?php
            $product_url = urlencode($product->product_url);
            ?>

            @if(($popup_checked == 0 && $status == 0) || $status == 0)
                <a href="javascript:void(0)" class="product-thumb" data-toggle="modal" data-target="notification_popup" onclick="$('#notification_popup').modal('show');"
                   style="background-image: url('{{$product->product_image}}');">
                    <span></span>
                </a>
            @else
                <a href="{{url("go-to-ep/$uid/?redirect_url=$product_url")}}" class="product-thumb"
                   style="background-image: url('{{$product->product_image}}');" target="_blank">
                    <span></span>
                </a>
            @endif

            <div class="product-desc">
                <span class="ep-ribbon">{{strtoupper($product->ep_info->ep_name)}}</span>

                <h3 class="product-title">
                    <a href="{{url("go-to-ep/$uid/?redirect_url=$product_url")}}">
                        {{strtoupper($product->product_name)}}
                    </a>
                </h3>
                <p class="price">
                    <?php
                    $price = ceil(@$product->product_price);
                    $price = str_replace(',', '', $price);
                    ?>
                    <strong>{{__('text.tk.')}} {{number_format($price, 2)}}</strong>
                    <small>/{{__('text.piece')}}</small>
                </p>
            </div>

        </div>
    </div>


    <?php
    if ($i % 4 == 0) {
    ?>
    <div class="clearfix"></div>
    <?php
    }
    $i++;
    $total_product++;
    ?>
@empty
@endforelse

@if(@$total_product > 0)
    <div id="scrollLoader" class="col-sm-12" style="text-align: center; margin-top: 40px; display: block;">

        <div class="entry" style="height: 120px">
            <div class="loader-box">
                <div class="box-inner">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img class="loader-logo" src="{{asset('public/assets/img/_ecom__logo.png')}}" alt="_ecom_">
                </div>
            </div>
        </div>

        {{--<div class="entry" style="height: 148px;">
            <div class="">
                <div id="loader">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="lading"></div>
                </div>
            </div>
        </div>--}}
    </div>

@endif

<script>
    offset = '{{($offset+$limit)}}';
</script>

