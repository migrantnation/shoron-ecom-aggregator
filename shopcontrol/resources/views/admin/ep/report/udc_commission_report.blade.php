@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('ep')}}">{{ __('_ecom__text.home') }}</a>
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
                            <select class="selectMonth selectMonthall form-control">
                                <option value="">Select Month</option>
                                <option value="all">All</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <select class="selectYear form-control">
                                <option value="">Select Year</option>
                                <option value="all" id="allYear">All</option>
                                @for($i = 2018 ; $i < date('Y') + 5 ; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            {{--periodpickerstart--}}
                            <input id="startDate" type="hidden" name="from"
                                   value="{{@$_POST['from'] ? @$_POST['from'] : @$from}}">
                            {{--periodpickerend--}}
                            <input id="endDate" type="hidden" name="to"
                                   value="{{@$_POST['to'] ? @$_POST['to'] : @$to}}">
                        </div>
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

    <div id="commission-disburse-modal"></div>
    <input type="hidden" name="" id="udcId">

    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>--}}

    <script>

        var url = "{{url('ep/udc-commission')}}";
        $(document).on('click', '.export', function (e) {
            var from = $('#startDate').val();
            var to = $('#endDate').val();
            var export_type = $(this).data('filetype');
            var search_string = $('#search_string').val();

            var selectMonth = $('.selectMonth').val();
            var selectYear = $('.selectYear').val();

            if (selectMonth == '' || selectYear == '') {
                $.alert('Please select Month and Year.');
                return;
            }
            window.location = url + "?from=" + from + "&to=" + to + "&export_type=" + export_type + "&search_string=" + search_string + "";
        });

        $(document).on('click', '.report-filter', function (e) {
            var from = $('#startDate').val();
            var to = $('#endDate').val();
            var selectMonth = $('.selectMonth').val();
            var selectYear = $('.selectYear').val();

            if (selectMonth == '' || selectYear == '') {
                $.alert('Please select Month and Year.');
                return;
            }
            $('#loader').show();

            var data = {
                from: from,
                to: to,
            };
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#report-render").html(html);
                    $('#loader').fadeOut();
                }
            });
        });


        $(document).on('click', '.pagination a', function (e) {
            var from = $('#startDate').val();
            var to = $('#endDate').val();
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
                },success: function (html) {
                    $('#loader').fadeOut();
                    $("#report-render").html(html);
                }
            });
            e.preventDefault();
        });


        //COMMISSION DISBURSEMENT
        $(document).on('change', '.selectMonthall', function (e) {
            if ($(".selectMonth").val() != 'all') {
                $("#allYear").hide();
                if ($(".selectYear").val() == 'all') {
                    $(".selectYear").prop("selectedIndex", 0);
                }
            } else {
                $("#allYear").show();
            }
        });

        //COMMISSION DISBURSEMENT
        $(document).on('change', '.selectMonth , .selectYear', function (e) {
            var startDate = 'all';
            var endDate = 'all';
            if ($(".selectMonth").val() != 'all' && $(".selectYear").val() != 'all') {
                startDate = "01" + "." + $(".selectMonth").val() + "." + $(".selectYear").val();
                endDate = daysInMonth($(".selectMonth").val(), $(".selectYear").val()) + "." + $(".selectMonth").val() + "." + $(".selectYear").val();
            }
            if ($(".selectYear").val() != 'all') {
                if ($(".selectMonth").val() == 'all') {
                    startDate = "01" + "." + "01" + "." + $(".selectYear").val();
                    endDate = daysInMonth('01', $(".selectYear").val()) + "." + "12" + "." + $(".selectYear").val();
                }
            }
            $('#startDate').val(startDate);
            $('#endDate').val(endDate);
        });

        function daysInMonth(month, year) {
            return new Date(year, month, 0).getDate();
        }


        //COMMISSION DISBURSEMENT
        // $(document).on('change', '.selectMonth , .selectYear', function (e) {
        //     var startDate = "01" + "." + $(".selectMonth").val() + "." + $(".selectYear").val();
        //     var endDate = daysInMonth($(".selectMonth").val(), $(".selectYear").val()) + "." + $(".selectMonth").val() + "." + $(".selectYear").val();
        //     $('#startDate').val(startDate);
        //     $('#endDate').val(endDate);
        // });
        //
        // function daysInMonth(month, year) {
        //     return new Date(year, month, 0).getDate();
        // }

        var modalid = '';
        $(document).on('click', '.getcommissiondisbursemodal, .submitDisburse', function (e) {
            var from = $('#startDate').val();
            var to = $('#endDate').val();
            if ($(this).data('targettask') == 'modal') {
                var udc_id = $(this).data('udcid');
                $("#udcId").val(udc_id);
                var disbursement_amount = $(this).data('disbursementamount');
                modalid = $(this).data('modalid');
                $.ajax({
                    url: "{{url('ep/commission-disburse')}}",
                    type: "post",
                    dataType: 'json',
                    data: {
                        from: from,
                        to: to,
                        udc_id: udc_id,
                        disbursement_amount: disbursement_amount,
                        _token: '{{csrf_token()}}',
                        get_modal: 'TRUE',
                    },
                    success: function (html) {
                        $("#commission-disburse-modal").html(html);
                        $("#disbursement_amount").html(disbursement_amount);
                        $(modalid).modal('show');
                    }
                });
            } else if ($(this).data('targettask') == 'submitDisburse') {
                var udc_id = $("#udcId").val();
                var from_date = $("#from-date-id").val();
                var transaction_number = $("#transaction_number").val();
                var mobile_banking_number = $("input[name=mobile_banking_number]").val();

                var commission_amount = $("#commission_amount").val();
                var total_due_amount = $("#total_due_amount").val();
                if((commission_amount > total_due_amount) || (commission_amount < 0)){
                    $('#commission-amount-error').show('slow');
                    return;
                }else{
                    $('#commission-amount-error').hide('slow');
                }

                if (from_date != '') {
                    from = from_date;
                }if(mobile_banking_number == ''){
                    $('#mobile-banking-number-error').show('slow');
                    return;
                }if(transaction_number == ''){
                    $('#mobile-banking-number-error').hide('slow');
                    $('#transaction-error').show('slow');
                    return;
                }




                $('#mobile-banking-number-error').hide('slow');
                $('#transaction-error').hide('slow');

                var formData = new FormData($("#commission-disburse-form")[0]);
                formData.append('_token', '{{csrf_token()}}');
                formData.append('from', from);
                formData.append('to', to);
                formData.append('udc_id', udc_id);
                formData.append('get_modal', "FALSE");
                $.ajax({
                    url: "{{url('ep/commission-disburse')}}",
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (html) {
                        if(html == 1){
                            console.log(html);
                            $(modalid).modal('hide');
                            $('#loader').show();
                            var data = {
                                from: from,
                                to: to,
                            };
                            $.ajax({
                                url: url,
                                type: "get",
                                dataType: 'json',
                                data: data,
                                success: function (html) {
                                    $("#report-render").html(html);
                                    $('#loader').fadeOut();
                                    successToast("Commission has been disbursed successfully.");
                                }
                            });
                        }
                    }
                });
            }
        });

    </script>

    <script>
        $(document).on('change', '#commission_amount', function (e) {
            console.log($("#commission_amount"));
        });

        $(document).on('change', '.existing_transfer_method', function (e) {
            if ($(this).val() == 1) {
                $('#transfer_method_bkash').show('slow');
                $('#transfer_method_rocket').hide('slow');
                $('#transfer_method_bkash').prop("disabled", false);
                $('#transfer_method_rocket').prop("disabled", true);
            } else {
                $('#transfer_method_bkash').hide('slow');
                $('#transfer_method_rocket').show('slow');
                $('#transfer_method_rocket').prop("disabled", false);
                $('#transfer_method_bkash').prop("disabled", true);
            }
        });
        $(document).on('change', '.another_transfer_method', function (e) {
            if ($(this).val() == 2) {
                $('.existing-method').hide('slow');
                $(".existing-method :input").attr("disabled", true);
                $('.additional-method-selection').show('slow');
                $(".additional-method-selection :input").attr("disabled", false);
            } else {
                $('.existing-method').show('slow');
                $(".existing-method :input").attr("disabled", false);
                $('.additional-method-selection').hide('slow');
                $(".additional-method-selection :input").attr("disabled", true);
            }
        });
    </script>


    <script>

        function ajaxpush() {
            var search_string = $('#search_string').val();
            var from = $('#startDate').val();
            var to = $('#endDate').val();
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
                    search_string: search_string,
                },success: function (html) {
                    $('#loader').fadeOut();
                    $("#report-render").html(html);
                }
            });
            e.preventDefault();
        }
    </script>

@endsection