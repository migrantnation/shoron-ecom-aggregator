@extends('m_frontend.layouts.master')
@section('content')
    <div class="m__sort-bar">
        <div class="m__sort-header clearfix">
            Sort By
        </div>

        <ul class="m__sort-list">
            <li><input type="radio" class="pull-right" id="popularity" name="sorting"><label for="popularity">Popularity</label></li>
            <li><input type="radio" class="pull-right" id="newest" name="sorting"><label for="newest">Newest</label></li>
            <li><input type="radio" class="pull-right" id="lth" name="sorting"><label for="lth">Price - Low to High</label></li>
            <li><input type="radio" class="pull-right" id="htl" name="sorting"><label for="htl">Price - High to Low</label></li>
        </ul>
    </div>

    <div class="m__title-bar">
        <a href="{{url('m/category-list')}}" class="m__back-btn"><i class="pe-7s-angle-left"></i></a>
        <span class="m__title">Store List</span>
    </div>


    <div class="m__store-list">
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-01.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-02.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-03.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-04.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-01.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-02.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-03.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-04.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-01.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-02.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-03.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
        <div class="m__store-block">
            <div class="store-widget">
                <div class="store-header">
                    <div class="store-image ratio-1-1" style="background-image: url('{{url('public/assets/img/store-img-04.jpg')}}')">
                    </div>

                    <div class="store-desc">
                        <h4 class="store-name"><a href="#">VSD International</a></h4>
                        <p><span class="mute-text">Dhaka (Uttara)</span></p>
                        <p><span class="static-rating" data-value="3.6"></span> (30)</p>
                        {{--<p>Open: <span>3 year(s)</span></p>--}}
                        <p>Total Sells: 1512</p>
                    </div>
                </div>
                <div class="store-footer clearfix">
                    <a href="#" class=""><i class="icon-envelope-letter"></i> Contact</a>
                    <a href="#" class="">Follow</a>
                </div>
            </div>
        </div>
    </div>
@endsection