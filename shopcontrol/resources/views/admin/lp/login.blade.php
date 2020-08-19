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
    <meta charset="utf-8"/>
    <title>Ek-Shop - Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="Login" name="description"/>
    <meta content="" name="author"/>
    <meta name="robots" content="noindex, nofollow">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('public/admin_ui_assets')}}/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('public/admin_ui_assets')}}/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('public/admin_ui_assets')}}/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('public/admin_ui_assets')}}/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
          rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('public/admin_ui_assets')}}/global/plugins/select2/css/select2.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('public/admin_ui_assets')}}/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{url('public/admin_ui_assets')}}/global/css/components.min.css" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{url('public/admin_ui_assets')}}/global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{url('public/admin_ui_assets')}}/pages/css/login.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="javascript://">
        <img src="{{url('public/admin_ui_assets')}}/layouts/layout/img/logo.png" alt="" style="width: 120px; display: inline-block">
        {{--Ek-Shop--}}
    </a>
</div>
<div class="content margin-top-30">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="{{url('lp/check-login')}}" method="post">

        {{ csrf_field() }}

        <h3 class="form-title font-green text-center">Logistic Partner Sign In</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Enter your email and password. </span>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">E-Mail Address</label>
            <input class="form-control form-control-solid placeholder-no-fix"
                   type="text" autocomplete="off"
                   id="email" name="email" value="{{ old('email') }}"
                   placeholder="E-mail" required autofocus/>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="Password" id="password" name="password" required/>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-actions text-center">
            <button type="submit" class="btn green uppercase">Login</button>
        </div>

    </form>

</div>

<div class="copyright"> <?= date("Y") ?> © a2i</div>
<!--[if lt IE 9]>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/respond.min.js"></script>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/excanvas.min.js"></script>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{url('public/admin_ui_assets')}}/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{url('public/admin_ui_assets')}}/global/plugins/jquery-validation/js/jquery.validate.min.js"
        type="text/javascript"></script>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/jquery-validation/js/additional-methods.min.js"
        type="text/javascript"></script>
<script src="{{url('public/admin_ui_assets')}}/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{url('public/admin_ui_assets')}}/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{url('public/admin_ui_assets')}}/pages/scripts/login.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
<script>
    $(document).ready(function () {
        $('#clickmewow').click(function () {
            $('#radio1003').attr('checked', 'checked');
        });
    })
</script>
</body>

</html>