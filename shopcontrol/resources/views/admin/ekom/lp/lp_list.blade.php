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
                <span>LP List</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->

    <h1 class="page-title">LP List &nbsp;&nbsp;
        <small></small>
        <a href="{{route('admin.lp.create')}}" class="btn btn-info">Add New &nbsp;&nbsp;<i class="fa fa-plus"></i></a>
    </h1>

    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">

                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">All Logistic Partner(LP)</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <form action="javascript:void(0)" class="margin-bottom-20" id="SubmitSearch">
                        <div class="row">
                            <div class="col-sm-8">
                            </div>

                            <div class="col-sm-4">
                                <div class="form-inline text-right">
                                    <div class="form-group">
                                        <label for="">Search:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search_string" value="{{@$_GET['search_string'] ? @$_GET['search_string'] : ""}}">
                                            <span class="input-group-btn">
                                                <button class="btn blue" id="submit_search" onsubmit="ajaxpush(event)" type="button"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

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
                        <div id="lp-list">
                            @include('admin.ekom.lp.render-lp-list')
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deletemodal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure ? </p>
                </div>
                <div class="modal-footer">

                    <a id="link" class="btn btn-info">Confirm</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(".delete").click(function (e) {
            e.preventDefault();
            $('#deletemodal').modal('show');
            var link = $(this).data('href');
            $('#link').attr('href', link);
            $('.modal-title').text('Delete ?');
            // console.log(dataLink);
        });
    </script>

    <script>

        $(document).ready(function () {
            document.getElementById("SubmitSearch").onsubmit = function () {
                ajaxpush();
                return false;
            };

            $(document).on('click', '.pagination a', function (e) {
                var search_string = $('#search_string').val();
                var page = $(this).attr('href').split('page=')[1];
                $('#lp-list').html('');
                $('.overlay-wrap').show();
                var data = {
                    search_string: search_string,
                    page: page,
                }

                $.ajax({
                    url: "{{url('/admin/lp-list')}}",
                    type: "get",
                    dataType: 'json',
                    data: data,
                    success: function (html) {
                        //history.pushState(null, null, this.url);
                        $('.overlay-wrap').hide();
                        $("#lp-list").html(html)
                    }
                });
                e.preventDefault();
            });

            $("#submit_search").click(function (e) {
                e.preventDefault();
                ajaxpush();
            });

            function ajaxpush() {

                $('#lp-list').html('');
                $('.overlay-wrap').show();

                var search_string = $('#search_string').val();
                var data = {
                    search_string: search_string
                }

                $.ajax({
                    url: "{{url('/admin/lp-list')}}",
                    type: "get",
                    dataType: 'json',
                    data: data,
                    success: function (html) {
                       // history.pushState(null, null, this.url);
                        $('.overlay-wrap').hide();
                        $("#lp-list").html(html)
                    }
                });
            }
        });
    </script>

    <script>
        $('.country-location').on('change', function (e) {
            var data = {location_name: $(this).val()};
            $('#lp-list').html('');
            $('.overlay-wrap').show();
            $.ajax({
                url: "{{url('admin/country-location')}}",
                type: "get",
                data: data,
                success: function (response) {

                    $('.overlay-wrap').hide();
                    
                    var data = JSON.parse(response);
                    var index = data.response.level;
                    index++;
                    var element = $('.country-location')[index];
                    element.innerHTML = data.response.view;

                    if (index == 1) {
                        var element = $('.country-location')[index + 1];
                        element.innerHTML = "<option>--Upazilla--</option><option>Select Upazilla</option>";

                        var element = $('.country-location')[index + 2];
                        element.innerHTML = "<option>--Union--</option><option>Select Union</option>";

                    }
                    if (index == 2) {
                        var element = $('.country-location')[index + 2];
                        element.innerHTML = "<option>--Union--</option><option>Select Union</option>";
                    }
                    ajaxpush();
                }
            });
            e.preventDefault();
        });
    </script>

    <script>
        var status;
        var lpid;
        var obj;

        $(document).on("click", '.change-status', function (event) {
            status = $(this).data('status');
            lpid = $(this).data('lpid');

            $.confirm({
                icon: 'fa fa-question',
                theme: 'material',
                content: 'Are you sure you want to change this LP status?',
                closeIcon: true,
                animation: 'scale',
                type: 'orange',
                title: 'Confirmation',
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function () {
                            $.ajax({
                                url: "{{url('admin/lp/change-status/')}}" + '/' + lpid + '/' + status,
                                type: "get",
                                dataType: 'json',
                                success: function (html) {
                                    obj = JSON.parse(JSON.stringify(html));
                                    $(".status-" + lpid).html(obj.status);
                                    $(".status-text-" + lpid).html(obj.status_text);
                                    successToast("LP status has been changed successfully");
                                }
                            });
                        }
                    },
                    'cancel': {}
                }
            });
        });
    </script>

@endsection