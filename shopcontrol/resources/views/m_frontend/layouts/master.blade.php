<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->


<html lang="en">
<!--<![endif]-->
<head>
    @include('m_frontend.layouts.includes.header_files')
</head>

<body class="plx__page">
    <div class="m__n-overlay"></div>
    @include('m_frontend.layouts.includes.header')

    @yield('content')

    @include('m_frontend.layouts.includes.footer'.@$footer)
    @include('m_frontend.layouts.includes.footer_files'.@$footer)


</body>

</html>