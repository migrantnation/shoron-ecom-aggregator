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
                <span class="text-404"></span>
                <p class="text-404-msg">দুঃখিত! পৃষ্ঠা পাওয়া যায় নি</p>

                @if(Request::segment(1) == 'admin')
                    <?php $url = url('admin');?>
                @elseif(Request::segment(1) == 'lp')
                    <?php $url = url('lp');?>
                @elseif(Request::segment(1) == 'ep')
                    <?php $url = url('ep');?>
                @else
                    <?php $url = url('');?>
                @endif

                <a href="{{$url}}" class="btn btn-success" style="min-width: 250px;">আবার চেষ্টা করুন</a>

            </div>
        </div>
    </div>
</div>

@include('frontend.layouts.includes.footer')

</body>

</html>