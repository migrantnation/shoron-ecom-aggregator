<div class="col-lg-12 col-xs-12 col-sm-12" style="position: relative; margin-top: 25px">

    <div class="portlet light">

        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share text-info hide"></i>
                <span class="caption-subject text-info bold uppercase">UDC Commission From {{@$ep_name}}</span>
            </div>
        </div>

        <div class="portlet-body" id="ep_orders">
            {{--<br>--}}
            {{--<div class="text-left" style="font-size: 14px;">--}}
            {{--<span class="caption-subject text-info bold uppercase">Total Orders:</span>--}}
            {{--<span class="text-info bold" style="padding-left:10px;"--}}
            {{--id="total_orders">{{number_format($total_orders,0)}}</span>--}}
            {{--<br>--}}
            {{--<span class="caption-subject text-info bold uppercase">Total Sale:</span>--}}
            {{--<span class="text-info bold" style="padding-left:10px;"--}}
            {{--id="total_orders">{{number_format($total_sales,0)}}</span>--}}
            {{--<br>--}}
            {{--<span class="caption-subject text-info bold uppercase">Total Commission:</span>--}}
            {{--<span class="text-info bold" style="padding-left:10px;"--}}
            {{--id="total_orders">{{number_format($total_commission,0)}}</span>--}}
            {{--<br>--}}
            {{--<br>--}}
            {{--</div>--}}


            <div class="row" style="margin-right: 15px;">
                <div class="col-md-7"></div>
                <div class="col-md-5 ">
                    <div class="form-group">
                        <div class="input-group">
                            <input placeholder="" type="text" class="form-control" id="search_string" value="{{@$_GET['search_string']}}">
                            <span class="input-group-btn">
                                <button class="btn blue" type="button" id="submit_search" onclick="ajaxpush();"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $udc_order_reports->total(), "from"=>  ($udc_order_reports->currentpage()-1) * $udc_order_reports->perpage()+1, "to"=>(($udc_order_reports->currentpage()-1) * $udc_order_reports->perpage()) + $udc_order_reports->count()])}}</span>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Slno</th>
                        <th>UDC Name</th>
                        <th class="text-center">Total Commission</th>
                        <th class="text-center">Paid Commission</th>
                        <th class="text-center">Due Commission</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_order = 0;
                    $total_price = 0;
                    $total_udc_commission = 0;
                    $total_paid_commission = 0;
                    $total_due_commission = 0;
                    ?>
                    @forelse($udc_order_reports as $key => $each_udc)
                        <?php
                        $this_udc_commission = $each_udc->orders->where('status', '!=', 5)->sum('udc_commission');
                        $total_udc_commission += $this_udc_commission;

                        $this_udc_paid_commission = $each_udc->orders->where('status', '!=', 5)->where('is_commission_disburesed', '=', 1)->sum('udc_commission');//PAID COMMISSION
                        $total_paid_commission += $this_udc_paid_commission;

                        $this_udc_due_commission = $each_udc->orders->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->sum('udc_commission'); //DUE COMMISSION
                        $total_due_commission += $this_udc_due_commission;
                        ?>
                        <tr>
                            <td>{{$page}}</td>
                            <td>{{@$each_udc->name_bn}}</td>
                            <td class="text-center">
                                {{number_format($this_udc_commission,0)}}
                            </td>
                            <td class="text-center">
                                {{number_format($this_udc_paid_commission,0)}}
                            </td>
                            <td class="text-center">
                                {{number_format($this_udc_due_commission,0)}}
                            </td>
                            <td class="text-center">
                                @if($this_udc_paid_commission)
                                    <?php
                                    $from = $startDate && $startDate != "all" ? date('Y-m-d',strtotime($startDate)) : $startDate ;
                                    $to = $endDate && $endDate != "all" ? date('Y-m-d',strtotime($endDate)) : $endDate ;
                                    ?>
                                    <a target="_blank" href="{{url('admin/disburesed-commission-list?from='. @$from .'&to='. $to . '&ep_id='. @$ep_id . '&search_string='.$each_udc->name_bn)}}">
                                        <button type="button"  class="btn btn-xs btn-primary" data-targettask="modal">Show Disbursement</button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <?php $page++; ?>
                    @empty
                    @endforelse
                    <tr>
                        <td colspan="12"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center"><strong>TOTAL</strong></td>
                        <td class="text-center"><strong>{{number_format($total_udc_commission,0)}}</strong></td>
                        <td class="text-center"><strong>{{number_format($total_paid_commission,0)}}</strong></td>
                        <td class="text-center"><strong>{{number_format($total_due_commission,0)}}</strong></td>
                        <td class="text-center"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 pull-right text-right">
                {!! @$udc_order_reports->render() !!}
            </div>
        </div>

        <div id="loader" class="loader-overlay">
            <div class="loader">Loading...</div>
        </div>
    </div>
</div>
