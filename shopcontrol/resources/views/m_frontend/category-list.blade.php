@extends('m_frontend.layouts.master')
@section('content')
    <div class="m__title-bar">
        <a href="{{url('m')}}" class="m__back-btn"><i class="pe-7s-angle-left"></i></a>
        <span>All categories</span>
    </div>

    <div class="m__category-list-wrap">
        <ul class="m__category-list">
            <li><a href="{{url('m/product/product-list')}}">Men's Fashion</a> <a class="m__list-toggle-btn" href="javascript://"></a>
                <ul class="m__sub-list">
                    <li><a href="{{url('m/product/product-list')}}">T-shirt</a></li>
                    <li><a href="{{url('m/product/product-list')}}">Shirt</a> <a class="m__list-toggle-btn" href="javascript://"></a>
                        <ul class="m__sub-list">
                            <li><a href="{{url('m/product/product-list')}}">Long</a></li>
                            <li><a href="{{url('m/product/product-list')}}">Fit</a></li>
                        </ul>
                    </li>
                    <li><a href="{{url('m/product/product-list')}}">Watches</a></li>
                </ul>
            </li>
            <li><a href="{{url('m/product/product-list')}}">Men's Fashion</a> <a class="m__list-toggle-btn" href="javascript://"></a>
                <ul class="m__sub-list">
                    <li><a href="{{url('m/product/product-list')}}">Dress</a> <a class="m__list-toggle-btn" href="javascript://"></a>
                        <ul class="m__sub-list">
                            <li><a href="{{url('m/product/product-list')}}">Shari</a></li>
                            <li><a href="{{url('m/product/product-list')}}">Tops</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Watch</a></li>
                </ul>
            </li>
            <li><a href="{{url('m/product/product-list')}}">Electronics</a> <a class="m__list-toggle-btn" href="javascript://"></a>
                <ul class="m__sub-list">
                    <li><a href="{{url('m/product/product-list')}}">TV</a> <a class="m__list-toggle-btn" href="javascript://"></a>
                        <ul class="m__sub-list">
                            <li><a href="{{url('m/product/product-list')}}">Samsung</a></li>
                            <li><a href="{{url('m/product/product-list')}}">LG</a></li>
                            <li><a href="{{url('m/product/product-list')}}">Walton</a></li>
                        </ul>
                    </li>
                    <li><a href="{{url('m/product/product-list')}}">Mobile</a> <a class="m__list-toggle-btn" href="javascript://"></a>
                        <ul class="m__sub-list">
                            <li><a href="{{url('m/product/product-list')}}">Huawei</a></li>
                            <li><a href="{{url('m/product/product-list')}}">iPhone</a></li>
                            <li><a href="{{url('m/product/product-list')}}">Samsung</a></li>
                        </ul>
                    </li>
                    <li><a href="{{url('m/product/product-list')}}">Laptop</a> <a class="m__list-toggle-btn" href="javascript://"></a>
                        <ul class="m__sub-list">
                            <li><a href="{{url('m/product/product-list')}}">Acer</a></li>
                            <li><a href="{{url('m/product/product-list')}}">Asus</a></li>
                            <li><a href="{{url('m/product/product-list')}}">Dell</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="{{url('m/product/product-list')}}">Furniture</a></li>
            <li><a href="{{url('m/product/product-list')}}">Book</a></li>
            <li><a href="{{url('m/product/product-list')}}">Housing</a></li>
            <li><a href="{{url('m/product/product-list')}}">Fruits</a></li>
            <li><a href="{{url('m/product/product-list')}}">Gifts</a></li>
            <li><a href="{{url('m/product/product-list')}}">Natural Beauty</a></li>
        </ul>
    </div>
@endsection