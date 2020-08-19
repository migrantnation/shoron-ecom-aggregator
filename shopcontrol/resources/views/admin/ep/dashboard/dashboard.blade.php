@extends('admin.layouts.master_demo')
@section('content')
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <link href="{{asset('public/admin_ui_assets')}}/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css"
          rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors -->
    <link href="{{asset('public/admin_ui_assets')}}/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('public/admin_ui_assets')}}/assets/demo/demo6/base/style.bundle.css" rel="stylesheet" type="text/css"/>
    <!--end::Base Styles -->

    <div class="filter-nav-wrap">
        <div class="filter-nav">
            <form class="form-inline" action="{{url("admin")}}">
                <div class="form-group">
                    <label for="email">Filter By:</label>
                </div> &nbsp; &nbsp;
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-default filter-range active" data-value="all">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off" checked
                               value="all"> All
                    </label>
                    <label class="btn btn-default filter-range" data-value="day">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off"
                               value="day"> Today
                    </label>
                    <label class="btn btn-default filter-range" data-value="week">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off"
                               value="week"> This Week
                    </label>
                    <label class="btn btn-default filter-range" data-value="month">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off"
                               value="month"> This Month
                    </label>
                    <label class="btn btn-default filter-range" data-value="year">
                        <input type="radio" class="view-type" name="view_type" autocomplete="off"
                               value="year"> This Year
                    </label>
                </div>
            </form>
        </div>
    </div>

    <div class="m-content" style="padding-top: 50px; position: relative" id="dashboard-render">
        @include('admin.ep.dashboard.render-dashboard')
    </div>

    {{--GET ACTIVITIES--}}

    <!--begin::Base Scripts -->
    <script src="{{asset('public/admin_ui_assets')}}/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="{{asset('public/admin_ui_assets')}}/assets/demo/demo6/base/scripts.bundle.js" type="text/javascript"></script>
    <!--end::Base Scripts -->
    <!--begin::Page Vendors -->
    <script src="{{asset('public/admin_ui_assets')}}/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js"
            type="text/javascript"></script>
    <!--end::Page Vendors -->
    <!--begin::Page Snippets -->
    <script src="{{asset('public/admin_ui_assets')}}/assets/app/js/dashboard.js" type="text/javascript"></script>
    <!--end::Page Snippets -->


    <script>

        var total_row = 0;
        total_row = $('.load_activities').length;
        var offset = total_row;
        var limit = 10;
        var url = "{{url('admin?offset=')}}" + offset + '&limit=' + limit;
        var total_activities = parseInt("{{$total_activities}}");

        $('[data-scrollable="scrollable"]').mCustomScrollbar({
            scrollInertia: 0,
            autoDraggerLength: true,
            autoHideScrollbar: true,
            autoExpandScrollbar: false,
            alwaysShowScrollbar: 0,
            axis: $('[data-scrollable="scrollable"]').data('axis') ? el.data('axis') : 'y',
            mouseWheel: {
                scrollAmount: 120,
                preventDefault: true
            },
            callbacks: {
                onScroll: function () {
                    if ((this.mcs.topPct === 100) && (total_activities > total_row)) {
                        get_activities();
                    }
                }
            },
            theme: "minimal-dark"
        });

        function get_activities() {
            $('.loader-alt').show();
            $.ajax({
                type: 'get',
                url: url,
                data: {},

                success: function (data) {
                    $("#load_activities").append(data);
                    $('.loader-alt').hide();
                    total_row = $('.load_activities').length;
                }
            });
        }
        $(document).on('click', '.filter-range', function (e) {
            $('#loader').show();

            var url = "{{url('ep')}}";
            //console.log($(this).data('value'));
            var data = {
                "filter_range": $(this).data('value'),
            };
            console.log(data);
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#dashboard-render").html(html);
                    Dashboard.init();
                    $('[data-scrollable="scrollable"]').mCustomScrollbar({
                        scrollInertia: 0,
                        autoDraggerLength: true,
                        autoHideScrollbar: true,
                        autoExpandScrollbar: false,
                        alwaysShowScrollbar: 0,
                        axis: $('[data-scrollable="scrollable"]').data('axis') ? el.data('axis') : 'y',
                        mouseWheel: {
                            scrollAmount: 120,
                            preventDefault: true
                        },
                        callbacks: {
                            onScroll: function () {
                                if ((this.mcs.topPct === 100) && (total_activities > total_row)) {
                                    get_activities();
                                }
                            }
                        },
                        theme: "minimal-dark"
                    });
                    $('#loader').fadeOut();
                }
            });
        });
    </script>
@endsection
