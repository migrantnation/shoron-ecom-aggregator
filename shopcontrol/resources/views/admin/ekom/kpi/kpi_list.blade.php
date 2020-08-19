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
                <span>{{__('_ecom__text.kpi-list')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{__('_ecom__text.kpi-list')}}
        <small></small>
    </h1>
    <!-- END PAGE TITLE-->

{{--    <a href="{{url("admin/setting/kpi/add")}}">Add new KPI</a>--}}

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">{{__('_ecom__text.all-kpi')}}</span>
                    </div>
                </div>

                <div class="portlet-body">

                    <div id="">

                        <div class="overlay-wrap">
                            <div class="anim-overlay">
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </div>
                        </div>

                        <div id="kpi-list">
                            @include('admin.ekom.kpi.render_kpi_list')
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        var change_status_url = "{{url('admin/setting/kpi/change-status')}}";
        var index_url = "{{url('admin/setting/kpi')}}";
        var delete_url = "{{url('admin/setting/kpi')}}";

        $(document).ready(function () {

            var page = 1;

            $(document).on('click', '.pagination a', function (e) {
                $('#kpi-list').html('');
                $('.overlay-wrap').show();
                page = $(this).attr('href').split('page=')[1];
                index();
                e.preventDefault();
            });

            function index() {

                $('#kpi-list').html('');
                $('.overlay-wrap').show();

                $.ajax({
                    url: index_url,
                    type: "get",
                    dataType: 'json',
                    data: {
                        page: page
                    },
                    success: function (html) {
                        $('.overlay-wrap').hide();
                        $("#kpi-list").html(html);
                    }
                });
            }
        });

        $(document).on("click", '.change-status', function (event) {

            var id = $(this).data('id');
            var status = $(this).data('status');

            $.confirm({
                icon: 'fa fa-question',
                theme: 'material',
                content: 'Are you sure you want to change this kpi status?',
                closeIcon: true,
                animation: 'scale',
                type: 'orange',
                title: 'Confirmation',
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function () {

                            $('.overlay-wrap').show();

                            $.ajax({
                                url: change_status_url,
                                type: "get",
                                dataType: 'json',
                                data: {
                                    id: id,
                                    status: status
                                },
                                success: function (response) {
                                    $('.overlay-wrap').hide();
                                    if (response['meta']['status'] == 200) {
                                        successToast('Status has been changed successfully');
                                        index();
                                    } else {
                                        warningToast('Status has been changed successfully');
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

    </script>

@endsection