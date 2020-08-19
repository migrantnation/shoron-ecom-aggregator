@extends('admin.layouts.master')
@section('content')
    {{--    {{dd()}}--}}
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin/')}}">{{__('_ecom__text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('admin/lp-list')}}">{{__('_ecom__text.lp-list')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>
                    {{__('_ecom__text.packages')}}</span>
            </li>
        </ul>
    </div>

    <!-- END PAGE BAR -->

    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->

    <div class="container-alt margin-top-20">
        <a href="{{url('admin/lp-list')}}" class="">
            <small class="fa fa-angle-left"></small> &nbsp;{{__('_ecom__text.back-lp-list')}} </a>
        <h3 class="margin-top-10 margin-bottom-15">{{__('_ecom__text.packages')}}</h3>

        <div class="portlet light bordered">
            <div class="portlet-body">
                @if(@$lp)

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        Total USER: {{$users->count()}}<br>
                                        Total distributed Package: {{$lp->packages->count()}}<br>
                                        Total Active Package: {{$lp->packages->where('is_selected', 1)->count()}}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="search_string"
                                                       value="{{@$_GET['search_string'] ? @$_GET['search_string'] : ""}}">
                                                <span class="input-group-btn">
                                                <button class="btn blue" type="button" id="btn_search_location">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="overlay-wrap" id="package-overlay-wrap">
                                    <div class="anim-overlay">
                                        <div class="spinner">
                                            <div class="bounce1"></div>
                                            <div class="bounce2"></div>
                                            <div class="bounce3"></div>
                                        </div>
                                    </div>
                                </div>

                                <div id="package_list">
                                    @include("admin.ekom.lp.package_list")
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>

    <script>

        $('#btn_search_location').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                find_location();
            }
        });

        $("#btn_search_location").click(function (e) {
            e.preventDefault();
            find_location();
        });

        function find_location() {
            var search_string = $('#search_string').val();

            $('#package_list').html('');
            $('#package-overlay-wrap').show();

            var data = {
                search_string: search_string,
                lp_id: "{{@$lp->id}}",
                _token: "{{csrf_token()}}",
            }

            $.ajax({
                url: "{{url("admin/lp/package-location")}}",
                type: "post",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('#package-overlay-wrap').hide();
                    $("#package_list").html(html);
                    init_actions();
                }
            });
        }


        //        $( document ).ready(function() {
        //find_location();
        //        });
    </script>

    <script>
        $(document).on('change', '.package-distribute', function (e) {

            var status = $('#status_range').val();
            $('#loader').show();
            var data = {
                "filter_range": filter_range,
                "status": status,
            };
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#report-render").html(html);
                    initChart();
                    $('#loader').fadeOut();
                }
            });
        });

        $(document).on('click', '.pagination a', function (e) {

            e.preventDefault();
            var search_string = $('#search_string').val();
            $('#package_list').html('');
            $('#package-overlay-wrap').show();

            $.ajax({
                url: "{{url("admin/lp/package-location")}}",
                type: "post",
                dataType: 'json',
                data: {
                    search_string: search_string,
                    lp_id: "{{@$lp->id}}",
                    page: $(this).attr('href').split('page=')[1],
                    _token: "{{csrf_token()}}",
                },
                success: function (html) {
                    $('#package-overlay-wrap').hide();
                    $("#package_list").html(html);
                }
            });
        });

    </script>
@endsection