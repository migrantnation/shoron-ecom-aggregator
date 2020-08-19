@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{__('_ecom__text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{__('_ecom__text.udc-list')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{__('_ecom__text.udc-list')}}
        <small></small>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">{{__('_ecom__text.all-udc')}}</span>
                    </div>
                    <div class="col-sm-1 pull-right">
                        <div class="dropdown" style="display: inline-block; width: 100px;">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa fa-download"></i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:;" class="export" data-filetype="csv">
                                        <i class="fa fa-file-o"></i> CSV
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="export" data-filetype="xlsx">
                                        <i class="fa fa-file-excel-o"></i> Excel
                                    </a>
                                </li>
                                <li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">

                    <form action="#" class="margin-bottom-20">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-inline">
                                    <div class="form-group">
                                        {{--<label for="">{{__('_ecom__text.filter-by')}}:</label>--}}
                                        <div class="input-group">
                                            <select class="country-location form-control" data-category="division"
                                                    name="division" id="division">
                                                <option value="">--বিভাগ--</option>
                                                @forelse($division as $key=>$value)
                                                    <option value="{{$value->division}}" {{@$_GET['division'] && @$_GET['division'] == $value->division ? 'selected' : ''}}>{{$value->division}}</option>
                                                @empty
                                                    <option>No Division Found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <select class="country-location form-control" data-category="district"
                                                    name="district" id="district">
                                                <option value="">--জেলা--</option>
                                                @if(@$district)
                                                    @forelse(@$district as $each_district)
                                                        <option value="{{@$each_district->district}}" {{@$each_district->district && @$each_district->district == @$_GET['district'] ? 'selected' : ''}}>{{@$each_district->district}}</option>
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <select class="country-location form-control" data-category="upazila"
                                                    name="upazilla" id="upazilla">
                                                <option value="">--উপজেলা--</option>
                                                @if(@$district)
                                                    @forelse(@$upazila as $each_upazila)
                                                        <option value="{{@$each_upazila->upazila}}" {{@$each_upazila->upazila && $each_upazila->upazila == @$_GET['upazila'] ? 'selected' : ''}}>{{$each_upazila->upazila}}</option>
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <select class="country-location form-control" data-category="union"
                                                    name="union" id="union">
                                                <option value="">--ইউনিয়ন--</option>
                                                @if(@$district)
                                                    @forelse(@$union as $each_union)
                                                        <option value="{{@$each_union->union}}" {{@$each_union->union && @$each_union->union == @$_GET['union'] ? 'selected' : ''}}>{{$each_union->union}}</option>
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="periodpickerstart" type="text" value="{{@$_GET['from'] ? @$_GET['from'] : ""}}">
                                            <input id="periodpickerend" type="text" value="{{@$_GET['to'] ? @$_GET['to'] : ""}}">
                                        </div> &nbsp;
                                        <script>/*datePickerInit();*/</script>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search_string"
                                                   placeholder="{{__('_ecom__text.search')}}"
                                                   name="search_string" value="{{@$_GET['search_string']}}">
                                            <span class="input-group-btn">
                                                <button class="btn blue" type="submit" id="submit_search"
                                                        onsubmit="searchAndFilter(event)"><i
                                                            class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>

                    <div id="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tabbable-line boxless tabbable-reversed">
                                    <ul class="nav nav-tabs">
                                        <li class="{{@$_GET['tab_id'] == 'all' || @$_GET['tab_id'] == '' ? 'active' : ''}}">
                                            <a href="#tab_all" data-toggle="tab" data-type="all"> All Registered Users </a>
                                        </li>

                                        <li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 1 ? 'active' : ''}}">
                                            <a href="#tab_1" data-toggle="tab" data-type="1"> Connected Users </a>
                                        </li>

                                        <li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 'transacting' ? 'active' : ''}}">
                                            <a href="#tab_3" data-toggle="tab" data-type="transacting"> Transacting Users </a>
                                        </li>

                                        <li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 'non-transacting' ? 'active' : ''}}">
                                            <a href="#tab_3" data-toggle="tab" data-type="non-transacting"> Non Transacting Users </a>
                                        </li>

                                        <li class="{{@$_GET['tab_id'] && $_GET['tab_id'] == 4 ? 'active' : ''}}">
                                            <a href="#tab_4" data-toggle="tab" data-type="4"> Users Out Of Reach </a>
                                        </li>

                                        <li class="{{(@$_GET['tab_id'] == '0' ) ? 'active' : ''}}">
                                            <a href="#tab_0" data-toggle="tab" data-type="0"> Users Need Activation </a>
                                        </li>

                                    </ul>
                                    <div class="tab-content" style="background-color: #F4F6F8" id="">
                                        <div class="overlay-wrap">
                                            <div class="anim-overlay">
                                                <div class="spinner">
                                                    <div class="bounce1"></div>
                                                    <div class="bounce2"></div>
                                                    <div class="bounce3"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="udc-list">
                                            @include('admin.ekom.udc.render_udc_list')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        var url = "{{url('admin/udc')}}";

        var tab_id = '{{(@$_GET['tab_id']!='')?$_GET['tab_id']:'all'}}';
        var page = 1;

        $(document).ready(function () {
            $(document).on('click', '.nav-tabs a', function (e) {
                tab_id = $(this).data('type');
                searchAndFilter();
            });

            $('#search_string').keypress(function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                    searchAndFilter();
                }
            });

            $(document).on('click', '.pagination a', function (e) {

                $('#udc-list').html('');
                $('.overlay-wrap').show();
                page = $(this).attr('href').split('page=')[1];

                $.ajax({
                    url: url,
                    type: "get",
                    dataType: 'json',
                    data: {
                        search_string: $('#search_string').val(),
                        division: $('#division').val(),
                        district: $('#district').val(),
                        upazila: $('#upazilla').val(),
                        union: $('#union').val(),
                        from: $('#periodpickerstart').val(),
                        to: $('#periodpickerend').val(),
                        tab_id: tab_id,
                        page: page,
                    },

                    success: function (html) {
                        $('.overlay-wrap').hide();
                        $("#udc-list").html(html);
                    }
                });
                e.preventDefault();
            });

            $("#submit_search").click(function (e) {
                e.preventDefault();
                searchAndFilter();
            });


            $(document).on('click', '.export', function (e) {
                var search_string = $('#search_string').val();
                var division = $('#division').val();
                var district = $('#district').val();
                var upazila = $('#upazilla').val();
                var union = $('#union').val();
                var export_type = $(this).data('filetype');
                var from = $('#periodpickerstart').val();
                var to = $('#periodpickerend').val();

                window.location = url + "?division=" + division + "&district=" + district + "&upazila=" + upazila + "&union=" + union + "&search_string=" + search_string + "&export_type=" + export_type + "&tab_id=" + tab_id + "&from=" + from + "&to=" + to + "";
            });


            $(document).on('change', '.all-filtered', function (e) {
                searchAndFilter();
            });

            function searchAndFilter() {
                var search_string = $('#search_string').val();
                var division = $('#division').val();
                var district = $('#district').val();
                var upazila = $('#upazilla').val();
                var union = $('#union').val();
                var limit = $('#limit').val();
                var from = $('#periodpickerstart').val();
                var to = $('#periodpickerend').val();

                if (limit == 'all') {
                    window.location = "{{url('')}}" + "/admin/udc?search_string=" + search_string + "&division=" + division + "&district=" + district + "&upazila=" + upazila + "&union=" + union + "&limit=" + limit + "&tab_id=" + tab_id + "&from=" + from + "&to=" + to + "";
                }

                $('#udc-list').html('');
                $('.overlay-wrap').show();

                $.ajax({
                    url: url,
                    type: "get",
                    dataType: 'json',
                    data: {
                        search_string: $('#search_string').val(),
                        division: $('#division').val(),
                        district: $('#district').val(),
                        upazila: $('#upazilla').val(),
                        union: $('#union').val(),
                        from: $('#periodpickerstart').val(),
                        to: $('#periodpickerend').val(),
                        tab_id: tab_id,
                    },
                    success: function (html) {
                        $('.overlay-wrap').hide();
                        $("#udc-list").html(html);
                    }
                });
            }


            $('.country-location').on('change', function (e) {

                var location_type = $(this).data('category');
                if (location_type == 'union') {
                    searchAndFilter();
                }
                $.ajax({
                    url: "{{url('admin/country-location')}}",
                    type: "get",
                    data: {
                        location_type: location_type,
                        location_name: $(this).val(),
                    },

                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.meta.status == 200) {
                            var index = data.response.index;
                            var element = $('.country-location')[index];
                            element.innerHTML = data.response.view;

                            if (index == 1) {
                                var element = $('.country-location')[index + 1];
                                if (element) {
                                    element.innerHTML = `<option value="">--উপজেলা--</option>`;
                                }

                                var element = $('.country-location')[index + 2];
                                if (element) {
                                    element.innerHTML = `<option value="">--ইউনিয়ন--</option>`;
                                }
                            }

                            if (index == 2) {
                                var element = $('.country-location')[index + 1];
                                if (element) {
                                    element.innerHTML = `<option value="">--ইউনিয়ন--</option>`;
                                }
                            }
                            searchAndFilter();
                        }
                    }
                });
                e.preventDefault();
            });
        });
    </script>

    <script>

        function call_on_page_load() {
            var location_type = 'division';
            if (location_type == 'union') {
                searchAndFilter();
            }
            $.ajax({
                url: "{{url('admin/country-location')}}",
                type: "get",
                data: {
                    location_type: location_type,
                    location_name: '{{@$_GET['division']}}',
                },

                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.meta.status == 200) {
                        var index = data.response.index;
                        var element = $('.country-location')[index];
                        element.innerHTML = data.response.view;

                        if (index == 1) {
                            var element = $('.country-location')[index + 1];
                            if (element) {
                                element.innerHTML = `<option value="">--উপজেলা--</option>`;
                            }

                            var element = $('.country-location')[index + 2];
                            if (element) {
                                element.innerHTML = `<option value="">--ইউনিয়ন--</option>`;
                            }
                        }

                        if (index == 2) {
                            var element = $('.country-location')[index + 1];
                            if (element) {
                                element.innerHTML = `<option value="">--ইউনিয়ন--</option>`;
                            }
                        }
                        searchAndFilter();
                    }
                }
            });
            e.preventDefault();
        }
    </script>

    <script>

        var page = 1;
        $(document).on("click", '.change-status-package', function (event) {

            var user_id = $(this).data('userid');
            var status = $(this).data('status');

            $.confirm({
                icon: 'fa fa-question',
                theme: 'material',
                content: '{{__('admin_text.no-package-notification')}}',
                closeIcon: true,
                animation: 'scale',
                type: 'orange',
                title: 'Confirmation',
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function () {

                            $.confirm({
                                icon: 'fa fa-question',
                                theme: 'material',
                                content: 'Are you sure you want to change this user status?',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'orange',
                                title: 'Confirmation',
                                buttons: {
                                    'confirm': {
                                        text: 'Proceed',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            run_action(user_id, status)
                                        }
                                    },
                                    'cancel': {
                                        action: function () {
                                        }
                                    }
                                }
                            });
                        }
                    },
                    'cancel': {
                        action: function () {
                        }
                    }
                }
            });
        });

        $(document).on("click", '.change-status', function (event) {

            var user_id = $(this).data('userid');
            var status = $(this).data('status');

            $.confirm({
                icon: 'fa fa-question',
                theme: 'material',
                content: 'Are you sure you want to change this user status?',
                closeIcon: true,
                animation: 'scale',
                type: 'orange',
                title: 'Confirmation',
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function () {
                            run_action(user_id, status);
                        }
                    },
                    'cancel': {
                        action: function () {
                        }
                    }
                }
            });
        });

        function run_action(user_id, status) {
            var data = {
                search_string: $('#search_string').val(),
                division: $('#division').val(),
                district: $('#district').val(),
                upazila: $('#upazilla').val(),
                union: $('#union').val(),

                tab_id: tab_id,
                page: page,

                user_id: user_id,
                status: status,
            }
            $('#udc-list').html('');
            $('.overlay-wrap').show();
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (response) {
                    $('.overlay-wrap').hide();
                    $('#udc-list').html(response);
                    successToast('Status has been changed successfully');
                }
            });
        }

    </script>

@endsection