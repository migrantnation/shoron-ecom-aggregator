<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Line Awesome -->
    <link rel="stylesheet" href="{{url('public/landing_assets')}}/css/line-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url('public/landing_assets')}}/css/bootstrap.min.css">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{url('public/landing_assets')}}/css/magnific-popup.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{url('public/landing_assets')}}/css/style.min.css">

    <title>এক-শপ</title>
</head>

<body>
<header class="header home-page">
    <div class="main-navbar">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="./"><img src="{{url('public/landing_assets/img/logo.png')}}" alt="_ecom_" height="50"></a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="plx__icon-open la la-reorder"></i>
                    <i class="plx__icon-close la la-close"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                         <li class="nav-item" style="margin-right: 10px">
                            <a class="nav-link btn btn-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSeRvBEP8ZGPKUdWQQ9Z8YHAwvWKfWdaZPV4HBN91LjMgh-Hzw/viewform?c=0&w=1&fbclid=IwAR0pB_9DPEtP3fYrbkU0fpVWbvS8Usm96b87-aURPg0wPQHsWa04tg7Mfq0">গ্রামীণ পণ্য বিক্রয়</a>
                        </li>
                        @if(!Illuminate\Support\Facades\Auth::guard('web_admin')->user())
                            <li class="nav-item" style="margin-right: 10px">
                                <a class="nav-link btn btn-outline-success" href="{{url('admin/login')}}">অ্যাডমিন
                                    লগইন</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link btn btn-success" href="http://partner.com/login">লগইন</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="header-content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-8">
                    <h2 class="title-lg mb-3">একশপঃ জনগনের দোরগোড়ায় ই-কমার্স সেবা</h2>
                    <p class="sub-title mb-4">একশপ দেশব্যাপী ৫ হাজারেরও বেশি ইউনিয়ন ডিজিটাল সেন্টারের মাধ্যমে
                        গ্রামীণ জনগোষ্ঠীকে ই-কমার্স সেবার আওতায় নিয়ে এসেছে</p>
                    <!--<a href="#" class="btn btn-lg btn-primary">ই-সেবা সমূহ</a>-->
                </div>
            </div>
        </div>
    </div>
    <div id="headerPoster" data-vide-bg="mp4: {{url('public/landing_assets/videos/-color')}}, webm: {{url('public/landing_assets/videos/color')}}{{--assets/videos/color--}}, ogv: {{url('public/landing_assets/videos/color')}}{{--assets/videos/color--}}, poster: {{url('public/landing_assets/videos/header_banner')}}{{--assets/videos/header_banner--}}"
         data-vide-options="posterType: png, loop: true, muted: false, position: 0% 0%">
    </div>
</header>

<div class="section info-section" style="background-image: url('public/landing_assets/img/info_section.jpg')">
    <div class="container">
        <div class="section-header">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <h2 class="section-title-alt">একশপ a2i প্রোগ্রামের আওতায় তৈরি একটি ই-কমার্স মার্কেটপ্লেস যাতে
                        দেশের সকল ই-কমার্স প্লাটফর্ম যুক্ত রয়েছে.</h2>
                </div>
            </div>
        </div>

        <div class="plx_info-row">
            <div class="plx_info-col">
                <ul class="info-list">
                    <li>
                        <a href="{{base_url()}}/search?string=Sharee"><span class="plx_icon la la-arrow-right"></span>
                            <span>শাড়ী</span></a>
                    </li>
                    <li>
                        <a href="{{base_url()}}/search?string=Medicine"><span class="plx_icon la la-arrow-right"></span>
                            <span>ঔষধ</span></a>
                    </li>
                    <li>
                        <a href="{{base_url()}}/search?string=Salwar%20Kameez"><span class="plx_icon la la-arrow-right"></span>
                            <span>সালোয়ার কামিজ</span></a>
                    </li>
                    <li>
                        <a href="{{base_url()}}/search?string=Pant"><span class="plx_icon la la-arrow-right"></span>
                            <span>প্যান্ট</span></a>
                    </li>
                    <li>
                        <a href="{{base_url()}}/search?string=Shirt"><span class="plx_icon la la-arrow-right"></span>
                            <span>শার্ট</span></a>
                    </li>
                </ul>
            </div>
            <div class="plx_info-col center">
                <img src="{{url('public/landing_assets/img/infographic.png')}}" alt="infograph" style="max-width: 100%; height: auto">
            </div>
            <div class="plx_info-col">
                <ul class="info-list">
                    <li>
                        <a href="{{base_url()}}/search?string=Watch"><span class="plx_icon la la-arrow-right"></span>
                            <span>ঘড়ি</span></a>
                    </li>
                    <li>
                        <a href="{{base_url()}}/search?string=Mobile"><span class="plx_icon la la-arrow-right"></span>
                            <span>মোবাইল</span></a>
                    </li>
                    <li>
                        <a href="{{base_url()}}/search?string=TV"><span class="plx_icon la la-arrow-right"></span>
                            <span>টিভি</span></a>
                    </li>
                    <li>
                        <a href="{{base_url()}}/search?string=Jewellery"><span class="plx_icon la la-arrow-right"></span>
                            <span>জুয়েলারী</span></a>
                    </li>
                    <li>
                        <a href="{{base_url()}}/search?string=Panjabi"><span class="plx_icon la la-arrow-right"></span>
                            <span>পাঞ্জাবী</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="section plx_video-sec">
    <div class="container">
        <div class="plx_video-sec-inner">
            <div class="plx_video-col">
                <div class="aspect-ratio video-desc ratio-4-3">
                    <div class="aspect-ratio-inner desc-inner">
                        <div class="desc-content">
                            <h2 class="desc-title mb-4">৫১১৫ টি ইউনিয়ন ডিজিটাল সেন্টারের মাধ্যমে ১০,৩৩৫,৪৯৯ টাকার
                                বিক্রয় সম্পন্ন হয়েছে</h2>
                            <a href="" class="btn btn-lg btn-primary">বিস্তারিত</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="plx_video-col">
                <div class="aspect-ratio ratio-4-3 video-container" style="background-image: url('public/landing_assets/img/video_thumb.jpg')">
                    <div class="aspect-ratio-inner">
                        <a href="https://www.youtube.com/watch?v=4J9-YqKxDCQ" class="popup-youtube video-play-btn"><span
                                    class="la la-play"></span></a>
                    </div>
                </div>
            </div>
            <!--<div class="col-sm-12">-->
            <!--<div class="row">-->
            <!--<div class="col-md-6 video-desc">-->
            <!--<div class="aspect-ratio ratio-4-3">-->
            <!--<div class="aspect-ratio-inner desc-inner">-->
            <!--<div class="desc-content">-->
            <!--<h2 class="mb-4">একসেবা ৫১১৫ টি ডিজিটাল সেন্টারের মাধ্যমে ১৫২৯১৫০ টি সেবা প্রদান করেছে।</h2>-->
            <!--<a href="#" class="btn btn-lg btn-primary">বিস্তারিত</a>-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="col-md-6 video-container" style="background-image: url('assets/img/video_thumb.jpg')">-->
            <!--<a href="https://www.youtube.com/watch?v=UghmZyE5RNs" class="popup-youtube video-play-btn"><span class="la la-play"></span></a>-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->
        </div>
    </div>
</div>

<div class="section service-list">
    <div class="container">
        <div class="row">
            <!--<div class="col-md-4">
            <div class="c-block w-img bg_purple">
                <div class="block-content">
                    <h4 class="block-title">WHY WATER?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A assumenda corporis illum odio odit optio, quibusdam reiciendis. Consectetur ducimus ex neque quas ullam? Illum, laboriosam odio officia quam quia quisquam!</p>
                    <a href="#" class="btn btn-lg">Learn More</a>
                </div>
            </div>
        </div>-->
            <div class="col-md-4">
                <div class="c-block bg_purple">
                    <div class="aspect-ratio ratio-16-9" style="background-image: url('public/landing_assets/img/categories_img/women.jpg')">

                    </div>
                    <div class="block-content">
                        <h4 class="block-title">শাড়ী</h4>
                        <a href="{{base_url()}}/search?string=Sharee" class="btn btn-lg">বিস্তারিত</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="c-block bg_secondary">
                    <div class="aspect-ratio ratio-16-9" style="background-image: url('public/landing_assets/img/categories_img/t_shirt.jpg')">

                    </div>
                    <div class="block-content">
                        <h4 class="block-title">টি-শার্ট</h4>
                        <a href="{{base_url()}}/search?string=T-Shirt" class="btn btn-lg">বিস্তারিত</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="c-block bg_green">
                    <div class="aspect-ratio ratio-16-9" style="background-image: url('public/landing_assets/img/categories_img/electronics.jpg')">

                    </div>
                    <div class="block-content">
                        <h4 class="block-title">ইলেকট্রনিক্স</h4>
                        <a href="{{base_url()}}/search?string=electronics" class="btn btn-lg">বিস্তারিত</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="c-block bg_indigo">
                    <div class="aspect-ratio ratio-16-9" style="background-image: url('public/landing_assets/img/categories_img/jewelry.jpg')">

                    </div>
                    <div class="block-content">
                        <h4 class="block-title">জুয়েলারি</h4>
                        <a href="{{base_url()}}/search?string=Jewellery" class="btn btn-lg">বিস্তারিত</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="c-block bg_purple">
                    <div class="aspect-ratio ratio-16-9" style="background-image: url('public/landing_assets/img/categories_img/pant.jpg')">

                    </div>
                    <div class="block-content">
                        <h4 class="block-title">প্যান্ট</h4>
                        <a href="{{base_url()}}/search?string=Pant" class="btn btn-lg">বিস্তারিত</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="c-block bg_primary">
                    <div class="aspect-ratio ratio-16-9" style="background-image: url('public/landing_assets/img/categories_img/watch.jpg')">

                    </div>
                    <div class="block-content">
                        <h4 class="block-title">ঘড়ি</h4>
                        <a href="{{base_url()}}/search?string=Watch" class="btn btn-lg">বিস্তারিত</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section monthly-featured">
    <div class="container">
        <div class="section-header text-center">
            <h3 class="section-title">সেরা ইউনিয়ন ডিজিটাল সেন্টারে</h3>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="profile-card">
                    <div class="profile-card-body">
                        <div class="profile-avatar" style="background-image: url('http://partner.com/files/entrepreneur/picture/901137f8-5ac9-47ed-9d9c-10a5075bd117.jpg')"></div>
                        <div class="profile-info pt-4">
                            <h4 class="name mb-2">মোঃ ইসরাইল</h4>
                            <p class="mb-2">হালসা ইউনিয়ন ডিজিটাল সেন্টার ০১</p>
                            <p class="mb-2">Total Purchase: ৳ 71,297.00</p>
                            <p>Total Orders: 2</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="profile-card">
                    <div class="profile-card-body">
                        <div class="profile-avatar" style="background-image: url('http://partner.com/files/entrepreneur/picture_ent/3ae57558-be17-4dc1-9682-78f0b32a55ad.jpg')"></div>
                        <div class="profile-info pt-4">
                            <h4 class="name mb-2">রওশন হাবীব</h4>
                            <p class="mb-2">বাউড়া ইউনিয়ন ডিজিটাল সেন্টার ০১</p>
                            <p class="mb-2">Total Purchase: ৳ 45,365.00</p>
                            <p>Total Orders: 6</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="copyright-area">
        <div class="container">
            <div class="copyright-inner">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <ul class="footer-menu">
                            <li><a href="#">সহযোগিতায়</a></li>
                            <li><a href="#">যোগাযোগ</a></li>
                            <li><a href="#">সাইটম্যাপ</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 text-right">
                        <span class="d-inline">পরিকল্পনা ও বাস্তবায়নে</span> &nbsp;&nbsp;
                        <img src='{{url('public/landing_assets/img/a2i.png')}}' alt="bd" height="30" class="d-inline"> &nbsp;
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        &copy; সর্বস্বত্ব স্বত্বাধিকার সংরক্ষিত a2i ২০১৮
                    </div>
                    <div class="col text-right">
                        <!--<ul class="footer-menu">-->
                        <!--<li><a href="#">একসেবা সম্পর্কে</a></li>-->
                        <!--<li><a href="#">সহযোগিতায়</a></li>-->
                        <!--<li><a href="#">যোগাযোগ</a></li>-->
                        <!--<li><a href="#">সাইটম্যাপ</a></li>-->
                        <!--</ul>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{url('public/landing_assets')}}/js/jquery.min.js"></script>
<script src="{{url('public/landing_assets')}}/js/popper.min.js"></script>
<script src="{{url('public/landing_assets')}}/js/bootstrap.min.js"></script>

<!-- Plugins -->
<script src="{{url('public/landing_assets')}}/js/jquery.vide.min.js"></script>
<script src="{{url('public/landing_assets')}}/js/jquery.magnific-popup.min.js"></script>
<script src="{{url('public/landing_assets')}}/js/jquery.sticky-sidebar.min.js"></script>

<!-- Main Scripts -->
<script src="{{url('public/landing_assets')}}/js/scripts.js"></script>
</body>

</html>