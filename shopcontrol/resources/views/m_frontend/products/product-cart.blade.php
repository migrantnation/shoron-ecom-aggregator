
@extends('m_frontend.layouts.master')
@section('content')

    <div class="m__title-bar">
        <a href="{{url('m/product/product-list')}}" class="m__back-btn"><i class="pe-7s-angle-left"></i></a>
        <div class="clearfix">
            <span class="pull-left m__title">My Cart (3)</span>
        </div>
    </div>

    <div class="m__cart">
        <div class="m__section-block m__cart-item">
            <div class="m__section-block-content">
                <div class="m__left-part">
                    <div class="m__item-avatar ratio-1-1" style="background-image: url('{{url('')}}/assets/img/products/product_img_11.jpg');"></div>
                    <div class="form-group form-group-sm p-qnt-counter">
                        <input id="pQty1" type="number" value="0" class="form-control">
                        <button class="qnt-btn qnt-btn-minus" data-operation="substract" data-qntvalue="#pQty1">-</button>
                        <button class="qnt-btn qnt-btn-plus" data-operation="add" data-qntvalue="#pQty1">+</button>
                    </div>
                </div>
                <div class="m__right-part">
                    <h4 class="m__cart-item-title"><a href="{{url('m')}}/product/product-details">Nike Air Force 1 GS AF1 Original Woman Classic All Black Anti-skid Cushioning Breathable Skatebroad Shoes</a></h4>
                    <p class="text-muted"><span>Size: XXL</span>, <span>Color: Red</span></p>
                    <p class="text-muted">Seller: RetailNet</p>
                    <p class="m__price"><span>TK. 1210</span>  <strike>TK. 1533</strike></p>
                </div>
            </div>
            <div class="m__section-block-footer">
                <a href="javascript://">Remove</a>
            </div>
        </div>

        <div class="m__section-block m__cart-item">
            <div class="m__section-block-content">
                <div class="m__left-part">
                    <div class="m__item-avatar ratio-1-1" style="background-image: url('{{url('')}}/assets/img/products/product_img_12.jpg');"></div>
                    <div class="form-group form-group-sm p-qnt-counter">
                        <input id="pQty2" type="number" value="0" class="form-control">
                        <button class="qnt-btn qnt-btn-minus" data-operation="substract" data-qntvalue="#pQty2">-</button>
                        <button class="qnt-btn qnt-btn-plus" data-operation="add" data-qntvalue="#pQty2">+</button>
                    </div>
                </div>
                <div class="m__right-part">
                    <h4 class="m__cart-item-title"><a href="{{url('m')}}/product/product-details">Nike Air Force 1 GS AF1 Original Woman Classic All Black Anti-skid Cushioning Breathable Skatebroad Shoes</a></h4>
                    <p class="text-muted"><span>Size: XXL</span>, <span>Color: Red</span></p>
                    <p class="text-muted">Seller: RetailNet</p>
                    <p class="m__price"><span>TK. 1210</span>  <strike>TK. 1533</strike></p>
                </div>
            </div>
            <div class="m__section-block-footer">
                <a href="javascript://">Remove</a>
            </div>
        </div>

        <div class="m__section-block m__cart-item">
            <div class="m__section-block-content">
                <div class="m__left-part">
                    <div class="m__item-avatar ratio-1-1" style="background-image: url('{{url('')}}/assets/img/products/product_img_13.jpg');"></div>
                    <div class="form-group form-group-sm p-qnt-counter">
                        <input id="pQty3" type="number" value="0" class="form-control">
                        <button class="qnt-btn qnt-btn-minus" data-operation="substract" data-qntvalue="#pQty3">-</button>
                        <button class="qnt-btn qnt-btn-plus" data-operation="add" data-qntvalue="#pQty3">+</button>
                    </div>
                </div>
                <div class="m__right-part">
                    <h4 class="m__cart-item-title"><a href="{{url('m')}}/product/product-details">Nike Air Force 1 GS AF1 Original Woman Classic All Black Anti-skid Cushioning Breathable Skatebroad Shoes</a></h4>
                    <p class="text-muted"><span>Size: XXL</span>, <span>Color: Red</span></p>
                    <p class="text-muted">Seller: RetailNet</p>
                    <p class="m__price"><span>TK. 1210</span>  <strike>TK. 1533</strike></p>
                </div>
            </div>
            <div class="m__section-block-footer">
                <a href="javascript://">Remove</a>
            </div>
        </div>

        <div class="m__section-block">
            <h4 class="m__section-block-title">Price Details</h4>
            <div class="m__section-block-content">
                <table class="m__price-detail-table">
                    <tr>
                        <td>Price (3 items)</td>
                        <td class="text-right">TK 2693</td>
                    </tr>
                    <tr>
                        <td>Delivery</td>
                        <td class="text-right"><span class="text-success">Free</span></td>
                    </tr>
                    <tfoot>
                    <tr>
                        <td>Amount Payable</td>
                        <td class="text-right">TK. 2693</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="m__section-block">
            <h4 class="m__section-block-title">Escrow Protection</h4>
            <div class="m__section-block-content">
                <div class="pd-horizontal-banner">
                    <img src="{{url('')}}/assets/img/shield.png" alt="" class="pd-icon">

                    <div class="buy-protection-info">
                        <ul class="buy-protection-info-list">
                            <li class="pd-info-item"><em>Full Refund</em> if you don't receive your order</li>
                            <li class="pd-info-item"><em>Full or&nbsp;Partial Refund</em> , if the item is not as described</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="m__section-block">
            <div class="m__action-btn m__btns-fixed">
                <div class="m__pd-l-part">
                    <strong>TK 2663</strong>
                </div>
                <div class="m__pd-r-part text-right">
                    <a href="{{url('m/product/checkout-b2b')}}" class="btn btn-success">Checkout</a>
                </div>
            </div>
        </div>
    </div>

@endsection