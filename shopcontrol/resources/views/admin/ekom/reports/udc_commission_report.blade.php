@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{ __('_ecom__text.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>UDC Commission Report</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <div class="clearfix"></div>

    <div class="row full-height">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <h3 class="page-title">{{ __('_ecom__text.udc-commission') }}</h3>
            <div class="margin-bottom-30">
                <div class="col-lg-8 col-xs-8 col-sm-8">
                    <form class="form-inline" action="javascript:;">
                        <div class="form-group">
                            <label for="email">Date range:</label>
                            <input id="periodpickerstart" type="text" name="from"
                                   value="{{@$_POST['from'] ? @$_POST['from'] : @$from}}">
                            <input id="periodpickerend" type="text" name="to"
                                   value="{{@$_POST['to'] ? @$_POST['to'] : @$to}}">
                        </div>

                        <div class="form-group">
                            <select name="ep_id" id="ep_id" class="form-control">
                                <option value="all">All EP</option>
                                @forelse($all_eps as $ep)
                                    <option value="{{$ep->id}}">{{$ep->ep_name}}</option>
                                @empty
                                    <option>No EP found</option>
                                @endforelse
                            </select>
                        </div> &nbsp; &nbsp;

                        <div class="form-group">
                            &nbsp;<a href="javascript://" class="btn filter-range btn-info report-filter">Generate</a>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 col-xs-12 col-sm-4 text-right">

                    {{--<button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button> &nbsp;--}}
                    <div class="dropdown" style="display: inline-block">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Export
                            <span class="caret"></span></button>
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
                            {{--<li>--}}
                            {{--<a href="javascript:;" class="export" data-filetype="pdf">--}}
                            {{--<i class="fa fa-file-pdf-o"></i> PDF--}}
                            {{--</a>--}}
                            {{--</li>--}}

                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="clearfix"></div>

    <div id="report-render">
        <div class="col-lg-12 col-xs-12 col-sm-12" style="position: relative; margin-top: 25px">
            <div class="portlet light">
                <div id="loader" class="loader-overlay">
                    <div class="loader">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script>

                {{--$(document).on('click', '.export', function (e) {--}}
                {{--var search_string = $('#search_string').val();--}}
                {{--var from = $('#from').val();--}}
                {{--var to = $('#to').val();--}}
                {{--var export_type = $(this).data('filetype');--}}
                {{--window.location = "{{url('admin/reports/udc-commission')}}" + "?from=" + from + "&to=" + to + "&search_string=" + search_string + "&export_type=" + export_type + "";--}}
                {{--});--}}

                {{--function datePickerInit() {--}}
                {{--$('.input-daterange').datepicker();--}}
                {{--}--}}

                {{--datePickerInit();--}}

        var url = "{{url('admin/reports/udc-commission')}}";


        $(document).on('click', '.export', function (e) {

            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var ep_id = $('#ep_id').val();
            var export_type = $(this).data('filetype');


            if (from == '' || to == '') {
                $.alert('Please select date range.');
                return;
            }
            if (ep_id == '') {
                $.alert('Please select an EP.');
                return;
            }

            window.location = url + "?from=" + from + "&to=" + to + "&ep_id=" + ep_id + "&export_type=" + export_type + "";

        });

        $(document).on('click', '.report-filter', function (e) {
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var ep_id = $('#ep_id').val();


            if (from == '' || to == '') {
                $.alert('Please select date range.');
                return;
            }
            if (ep_id == '') {
                $.alert('Please select an EP.');
                return;
            }

            $('#loader').show();

            var data = {
                from: from,
                to: to,
                ep_id: ep_id,
            };
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#report-render").html(html);
                    $('#loader').fadeOut();
                    $(thisBtn).html('Reset').removeClass('report-filter').attr('href', url);
//                    initChart();
                }
            });
        });

        $(document).on('click', '.pagination a', function (e) {
            var from = $('#periodpickerstart').val();
            var to = $('#periodpickerend').val();
            var ep_id = $('#ep_id').val();

            $('#loader').show();
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: {
                    from: from,
                    to: to,
                    ep_id: ep_id,
                    page: $(this).attr('href').split('page=')[1],
                },
                success: function (html) {
                    $('#loader').fadeOut();
                    $("#report-render").html(html);
                }
            });
            e.preventDefault();
        });

    </script>

@endsection