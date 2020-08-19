<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    {{--<meta charset="utf-8"/>--}}
    <title>a2i | Rural eCommerce Portal</title>
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    {{--<meta content="width=device-width, initial-scale=1.0" name="viewport"/>--}}
    {{--<meta http-equiv="Content-type" content="text/html; charset=utf-8">--}}
    {{--<meta content="" name="description"/>--}}
    {{--<meta content="" name="author"/>--}}
    <meta name="robots" content="noindex, nofollow">
    @include('ep.layouts.includes.header_files')
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white page-sidebar-fixed">
<div class="page-wrapper">

    <!-- BEGIN HEADER -->
@include('ep.layouts.includes.header')
<!-- END HEADER -->
    <div class="clearfix"></div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
    @include('ep.layouts.includes.'.@$side_bar)
    <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    @include('ep.layouts.includes.footer')
    @include('ep.layouts.includes.footer_files')
</div>
<!-- END FOOTER -->
</body>
<!-- END BODY -->
</html>