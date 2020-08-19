<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <title>{{__('text._ecom_')}}</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="{{url('assets')}}/img/favicon.ico" type="image/ico">
    @include('admin.layouts.includes.header_files')
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white page-sidebar-fixed">

<div class="page-wrapper">

    @include('admin.layouts.header.'.@$header)

    <div class="clearfix"></div>
    <div class="page-container">

        @include('admin.layouts.side_bar.'.@$side_bar)

        <div class="page-content-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>

    </div>

    @include('admin.layouts.footer.'.@$footer)

</div>

<script src="{{url('public/admin_ui_assets')}}/layouts/layout/js/jquery.periodpicker.full.min.js" type="text/javascript"></script>
<script>

    // handle sidebar link click
    $('.page-sidebar-menu').on('click', 'li > a.nav-toggle, li > a > span.nav-toggle', function (e) {
        var that = $(this).closest('.nav-item').children('.nav-link');

        /*if (App.getViewPort().width >= resBreakpointMd && !$('.page-sidebar-menu').attr("data-initialized") && $('body').hasClass('page-sidebar-closed') &&  that.parent('li').parent('.page-sidebar-menu').size() === 1) {
            return;
        }*/

        var hasSubMenu = that.next().hasClass('sub-menu');

        /*
        if (App.getViewPort().width >= resBreakpointMd && that.parents('.page-sidebar-menu-hover-submenu').size() === 1) { // exit of hover sidebar menu
            return;
        }

        if (hasSubMenu === false) {
            if (App.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass("in")) { // close the menu on mobile view while laoding a page
                $('.page-header .responsive-toggler').click();
            }
            return;
        }*/

        var parent = that.parent().parent();
        var the = that;
        var menu = $('.page-sidebar-menu');
        var sub = that.next();

        var autoScroll = menu.data("auto-scroll");
        var slideSpeed = parseInt(menu.data("slide-speed"));
        var keepExpand = menu.data("keep-expanded");

        if (!keepExpand) {
            parent.children('li.open').children('a').children('.arrow').removeClass('open');
            parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(slideSpeed);
            parent.children('li.open').removeClass('open');
        }

        var slideOffeset = -200;

        if (sub.is(":visible")) {
            $('.arrow', the).removeClass("open");
            the.parent().removeClass("open");
            sub.slideUp(slideSpeed, function () {
                /*if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    } else {
                        App.scrollTo(the, slideOffeset);
                    }
                }
                handleSidebarAndContentHeight();*/
            });
        } else if (hasSubMenu) {
            $('.arrow', the).addClass("open");
            the.parent().addClass("open");
            sub.slideDown(slideSpeed, function () {
                /*if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    } else {
                        App.scrollTo(the, slideOffeset);
                    }
                }*/
                //handleSidebarAndContentHeight();
            });
        }

        e.preventDefault();
    });

    $(function () {
        "use strict";
        var today = new Date();
        var tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000));
        var d = today.getDate();
        var m = today.getMonth();
        var Y = today.getFullYear();
        var newDate = (1 + d) + '.' + (1 + m) + '.' + Y;

        jQuery('#periodpickerstart').periodpicker({
            end: '#periodpickerend',
            todayButton: false,
            maxDate: newDate,
            formatDate: 'D.MM.YYYY',
            onTodayButtonClick: function () {
                this.regenerate();
                return false;
            }
        });
    });
</script>

</body>

</html>