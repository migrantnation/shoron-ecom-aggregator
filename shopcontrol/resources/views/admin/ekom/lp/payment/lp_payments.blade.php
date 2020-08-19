@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>LP Payments</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">LP Payments &nbsp;&nbsp;
        <small></small>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">LP Payments</span>
                    </div>
                </div>

                <div class="portlet-body">

                    <form action="#" class="margin-bottom-20">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <div class="form-inline text-right">
                                    <div class="form-group">
                                        <label for="">Search:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search_string"
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

                    <div id="lp-list">

                        @include('admin.ekom.lp.payment.render_lp_payments')
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.pagination a', function (e) {
//                var page = $(this).attr('href').split('page=')[1];
                $.ajax({
                    url: "{{url('admin/lp')}}",
                    type: "get",
                    dataType: 'json',
                    data: {
                        search_string: $('#search_string').val(),
                        page: $(this).attr('href').split('page=')[1],
                        division: $('#division').val(),
                        district: $('#district').val(),
                        upazilla: $('#upazilla').val(),
                        union: $('#union').val()
                    },

                    success: function (html) {
                        $("#lp-list").html(html);

                        var url = "{{url('admin/lp?')}}"
                            + "search_string=" + $('#search_string').val()
                            + "&page=2"
                            + '&division=' + $('#division').val()
                            + '&district=' + $('#district').val()
                            + '&upazilla=' + $('#upazilla').val()
                            + '&union=' + $('#union').val();

                        history.pushState(null, null, url);
                    }
                });
                e.preventDefault();
            });

            $("#submit_search").click(function (e) {
                e.preventDefault();
                searchAndFilter();
            });

            function searchAndFilter() {
                $.ajax({
                    url: "{{url('admin/lp')}}",
                    type: "get",
                    dataType: 'json',
                    data: {
                        search_string: $('#search_string').val(),
                        division: $('#division').val(),
                        district: $('#district').val(),
                        upazilla: $('#upazilla').val(),
                        union: $('#union').val()
                    },
                    success: function (html) {
                        $("#lp-list").html(html);

                        var url = "{{url('admin/lp?')}}"
                            + "search_string=" + $('#search_string').val()
                            + '&page=1'
                            + '&division=' + $('#division').val()
                            + '&district=' + $('#district').val()
                            + '&upazilla=' + $('#upazilla').val()
                            + '&union=' + $('#union').val();

                        history.pushState(null, null, url);
                    }
                });
            }

            $('.country-location').on('change', function (e) {

                $.ajax({
                    url: "{{url('admin/country-location')}}",
                    type: "get",
                    data: {location_name: $(this).val()},

                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.meta.status == 200) {
                            var index = data.response.level;
                            index++;
                            var element = $('.country-location')[index];
                            element.innerHTML = data.response.view;

                            if (index == 1) {
                                var element = $('.country-location')[index + 1];
                                if (element) {
                                    element.innerHTML = `<option>--Upazilla--</option><option>Select Upazilla</option>`;
                                }

                                var element = $('.country-location')[index + 2];
                                if (element) {
                                    element.innerHTML = `<option>--Union--</option><option>Select Union</option>`;
                                }
                            }

                            if (index == 2) {
                                var element = $('.country-location')[index + 2];
                                if (element) {
                                    element.innerHTML = `<option>--Union--</option><option>Select Union</option>`;
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

@endsection