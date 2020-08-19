@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('udc')}}">Home{{--{{ __('admin_text.home') }}--}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Commission Overview</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">Commission Overview</span>
                </div>
            </div>
            @if(session('poststatus'))
                <div class="alert alert-{{session('poststatus')}} alert-dismissible text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{session('statusmessage')}}
                </div>
                @php
                    session()->forget('poststatus');
                @endphp
            @endif
            <?php $form_url = url('udc/paywellbalance'); ?>

            <div class="portlet-body">

                <!--<form action="#" class="margin-bottom-20"  id="searchingform">-->
                <!--    <div class="row">-->
                <!--        <div class="col-sm-12">-->
                <!--            <div class="form-inline text-right">-->
                <!--                <div class="form-group">-->
                <!--                    <label for="">Search{{--{{ __('admin_text.search') }}--}}:</label>-->
                <!--                    <div class="input-group">-->
                <!--                        <input type="text" class="form-control" id="search_string">-->
                <!--                        <span class="input-group-btn">-->
                <!--                        <button class="btn blue " data-assigned-id="test" type="button" onclick="searchingform()"><i class="fa fa-search"></i></button>-->
                <!--                        </span>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</form>-->

                {{--<span style="display: inline-block; margin-bottom: 10px;"> <strong>Showing from {{($outstanding_dues->currentpage()-1) * $outstanding_dues->perpage() + 1}} to {{(($outstanding_dues->currentpage()-1) * $outstanding_dues->perpage()) + $outstanding_dues->count()}} of {{$outstanding_dues->total()}}</strong></span>--}}
                
                <br>
                <table class="table table-bordered table-hover">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">EP Name</th>
                        <th class="text-center">Outstanding Due</th>
                        <th class="text-center">Details</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($outstanding_dues as $key => $each_due)
                        <?php
                        $get_prev_due = \App\CommissionDisbursementHistory::where('ep_id', $each_due->ep_id)->where('udc_id', \Illuminate\Support\Facades\Auth::user()->id)->orderBy('id', 'desc')->first();
                        if($get_prev_due){
                            $each_due->outstanding_due = @$each_due->outstanding_due + @$get_prev_due->due_amount;
                        }
                        ?>
                        <tr>
                            <td width="20">{{@$key+1}}</td>
                            <td class="text-center">{{@$each_due->ep_info->ep_name}}</td>
                            <td class="text-center">{{@$each_due->outstanding_due ? number_format($each_due->outstanding_due, 2) : 0}}</td>
                            <td class="text-center"><a href="{{url('udc/commission-disburse-details/' . $each_due->ep_id)}}" class="btn btn-info"><i class="fa fa-eye"></i> Details</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center "><h4>No Result Found{{--{{ __('admin_text.no-result') }}--}}</h4></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="overlay-wrap">
                    <div class="anim-overlay">
                        <div class="spinner">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        var deposit_date = new Date();
        deposit_date.setDate(deposit_date.getDate());
        $('#deposit_date').datepicker({
            format: 'mm-dd-yyyy',
            autoclose: true,
            // startDate: deposit_date,
            endDate: deposit_date,
        }).on('changeDate', function () {
            // adminDatefrom = $('#admindatepickerfrom').val();
            // $('#admindatepickerto').datepicker().datepicker("setDate", new Date(adminDatefrom));
        }).attr('readonly', 'readonly');

    </script>

    <style>
        .lighter-container {
            width: 80% !important;
            height: 80% !important;
            top: 30% !important;
            left: 20% !important;
            /*margin: -133.5px -200px;*/
            margin: -8% -8% !important;
        }
    </style>
    <script src="{{url('public/assets/plugins/jquery-lighter/jquery.lighter.js')}}" type="text/javascript"></script>

    <script>
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#addBalanceForm").validate({
                messages: {
                    amount: "Please enter your deposited amount",
                    transaction_number: "Please enter the transaction number",
                    deposit_date: "Please select deposit date",
                },
                rules: {
                    category_id: {
                        required: true
                    }
                }
            });

        });
    </script>

    <script>
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var search_string = $('#search_string').val();
            var page = $(this).attr('href').split('page=')[1];

            $('#render_list').html('');
            $('.overlay-wrap').show();

            var data = {
                search_string: search_string,
                page: page,
            }

            $.ajax({
                url: $(this).attr('href'),
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('.overlay-wrap').hide();
                    $("#render_list").html(html);
                    slim_init();
                }
            });

        });

        $("#searchingform").submit(function (e) {
            searchingform();
            return false;
        });

        function searchingform() {
            var search_string = $('#search_string').val();
            $('#render_list').html('');
            $('.overlay-wrap').show();
            $.ajax({
                type: 'get',
                url: "{{url('udc/paywellbalance')}}",
                data: {
                    "search_string": search_string,
                },
                success: function (data) {
                    $('.overlay-wrap').hide();
                    $("#render_list").html(data);
                    slim_init();
                }
            });
        }
    </script>
@endsection