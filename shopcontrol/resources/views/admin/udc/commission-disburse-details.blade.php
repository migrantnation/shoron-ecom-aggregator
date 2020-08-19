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
                <span>UDC Commission</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <div id="report-render">
        @include('admin.udc.render-commission-disburse-details')
    </div>

    <div class="clearfix"></div>

    <div id="commission-disburse-modal"></div>
    <input type="hidden" name="" id="udcId">

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