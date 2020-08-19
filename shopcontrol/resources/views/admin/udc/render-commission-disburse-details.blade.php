<div class="col-lg-12 col-xs-12 col-sm-12" style="position: relative; margin-top: 25px">

    <div class="portlet light">

        <div class="row full-height">
            <div class="col-lg-12 col-xs-12 col-sm-12">
                <h3 class="page-title">{{ __('_ecom__text.udc-commission') }}</h3>

                {{--<div class="margin-bottom-30">--}}
                    {{--<div class="col-lg-12 col-xs-12 col-sm-4 text-right">--}}
                        {{--<button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button> &nbsp;--}}
                        {{--<div class="dropdown" style="display: inline-block">--}}
                            {{--<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Export--}}
                                {{--<span class="caret"></span></button>--}}
                            {{--<ul class="dropdown-menu">--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:;" class="export" data-filetype="csv">--}}
                                        {{--<i class="fa fa-file-o"></i> CSV--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:;" class="export" data-filetype="xlsx">--}}
                                        {{--<i class="fa fa-file-excel-o"></i> Excel--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}

            </div>
        </div>

        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share text-info hide"></i>
                <span class="caption-subject text-info bold uppercase">UDC Commission From {{@$ep_name}}</span>
            </div>
        </div>

        <div class="portlet-body" id="ep_orders">
            {{--<br>--}}
            <div class="text-left" style="font-size: 14px;">
                <span class="caption-subject text-info bold uppercase">Total Orders:</span>
                <span class="text-info bold" style="padding-left:10px;" id="total_orders"></span>
                <br>
                <span class="caption-subject text-info bold uppercase">Total Price:</span>
                <span class="text-info bold" style="padding-left:10px;" id="total_price">{{number_format(20000/*$total_sales*/,0)}}</span>
                <br>
                <span class="caption-subject text-info bold uppercase">Total Commission:</span>
                <span class="text-info bold" style="padding-left:10px;" id="total_commission">{{number_format(1500/*$total_commission*/,0)}}</span>
                <br>
                <span class="caption-subject text-info bold uppercase">Total Disbursed Commission:</span>
                <span class="text-info bold" style="padding-left:10px;" id="total_disbursed_commission">{{number_format(1500/*$total_commission*/,0)}}</span>
                <br>
                <span class="caption-subject text-info bold uppercase">Outstanding Commission Due:</span>
                <span class="text-info bold" style="padding-left:10px;" id="outstanding_due">{{number_format(1500/*$total_commission*/,0)}}</span>
                <br>
                <br>
                <br>
            </div>

            <!--<div class="row" style="margin-right: 15px;">-->
            <!--    <div class="col-md-7"></div>-->
            <!--    <div class="col-md-5 ">-->
            <!--        <div class="form-group">-->
            <!--            <select class="selectYear form-control">-->
            <!--                <option value="">Select Year</option>-->
            <!--                @for($i = 2018 ; $i < date('Y') + 5 ; $i++)-->
            <!--                    <option value="{{$i}}" {{$i == date('Y') ? 'selected' : ""}}>{{$i}}</option>-->
            <!--                @endfor-->
            <!--            </select>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover">

                    <thead>
                        <tr>
                            <th class="text-center">Month</th>
                            <th class="text-center">Orders</th>
                            <th class="text-center">Price Buy</th>
                            <th class="text-center">Commission</th>
                            <th class="text-center">Disbursed Commission</th>
                            <th class="text-center">Due</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $total_order = 0;
                    $total_price = 0;
                    $total_commission = 0;
                    $total_disbursed_commission = 0;
                    $outstanding_due = 0;
                    ?>
                        @forelse($get_commission_details as $key => $each_commission)

                            <?php
                            $total_order += $each_commission->count();
                            $total_price += $each_commission->sum('sub_total');
                            $total_commission += $each_commission->sum('udc_commission');
                            $total_disbursed_commission += $each_commission->where('is_commission_disburesed', 1)->sum('udc_commission');
                            $outstanding_due += $each_commission->where('is_commission_disburesed', 0)->sum('udc_commission');
                            ?>

                            <tr>
                                <td class="text-center">{{$key}}</td>
                                <td class="text-center">{{$each_commission->count()}}</td>
                                <td class="text-center">{{$each_commission->sum('sub_total')}}</td>
                                <td class="text-center">{{$each_commission->sum('udc_commission')}}</td>
                                <td class="text-center">{{$each_commission->where('is_commission_disburesed', 1)->sum('udc_commission')}}</td>
                                <td class="text-center">{{$each_commission->where('is_commission_disburesed', 0)->sum('udc_commission')}}</td>
                            </tr>

                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 pull-right text-right">
                {{--{!! @$udc_order_reports->render() !!}--}}
            </div>
        </div>

        <div id="loader" class="loader-overlay">
            <div class="loader">Loading...</div>
        </div>
    </div>
</div>

<script>
    $('#total_orders').html({{@$total_order}});
    $('#total_price').html({{@$total_price}});
    $('#total_commission').html({{@$total_commission}});
    $('#total_disbursed_commission').html({{@$total_disbursed_commission}});
    $('#outstanding_due').html({{@$outstanding_due}});
</script>