<div class="f-products owl-carousel productCarousel" id="hot_deal_products">
    @forelse($ep_list as $each_list)
        @if($each_list->products)
            <?php
            $encrypter = new App\Libraries\EkomEncryption($each_list->id);
            $uid = $encrypter->encrypt();
            ?>
            @forelse($each_list->products as $each_product)
                <?php
                $product_url = urlencode($each_product->product_url);
                $price = (int)$each_product->product_price;
                ?>

                <div class="product-alt">
                    <a href="{{url("go-to-ep/$uid/?redirect_url=$product_url")}}" class="p-pic"
                       style="background-image: url('{{$each_product->product_image}}')">
                    </a>
                    <h3 class="product-name"><a href="{{url("go-to-ep/$uid/?redirect_url=$product_url")}}">{{$each_product->product_name}}</a>
                    </h3>
                    <span class="price">{{__('text.tk.')}}. {{number_format($price, 2)}}
                </span>
                </div>

            @empty
            @endforelse
        @endif
    @empty
    @endforelse
</div>