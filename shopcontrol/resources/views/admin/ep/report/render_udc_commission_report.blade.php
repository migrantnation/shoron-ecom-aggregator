<div class="col-lg-12 col-xs-12 col-sm-12" style="position: relative; margin-top: 25px">

    <div class="portlet light">

        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share text-info hide"></i>
                <span class="caption-subject text-info bold uppercase">UDC Commission From {{(@$request->ep_id!='all')?@$ep_info->ep_name:'All EP'}}</span>
            </div>

        </div>

        <div class="portlet-body" id="ep_orders">
            {{--<br>--}}
            <div class="text-left" style="font-size: 14px;">
                <span class="caption-subject text-info bold uppercase">Total Orders:</span>
                <span class="text-info bold" style="padding-left:10px;"
                      id="total_orders">{{number_format($total_orders,0)}}</span>
                <br>
                <span class="caption-subject text-info bold uppercase">Total Sale:</span>
                <span class="text-info bold" style="padding-left:10px;"
                      id="total_orders">{{number_format($total_sales,0)}}</span>
                <br>
                <span class="caption-subject text-info bold uppercase">Total Commission:</span>
                <span class="text-info bold" style="padding-left:10px;"
                      id="total_orders">{{number_format($total_commission,0)}}</span>
                <br>
                <br>
            </div>


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

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Slno</th>
                        <th>UDC Name</th>
                        <th>Contact Number</th>
                        <th>Mobile Bank Numbers</th>
                        <th class="text-right">Total Orders</th>
                        <th class="text-right">Total Sale</th>
                        <th class="text-right">Disbursed Commission</th>
                        <th class="text-right">Outstanding Due</th>
                        <th class="text-right">Total Commission</th>
                        @if($show_btn == "TRUE")
                            <th class="text-right">Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_order = 0;
                    $total_price = 0;
                    $total_udc_commission = 0;

                    $total_disbursed_commission = 0;
                    $total_outstanding_commission = 0;
                    ?>
                    @if($show_btn == "TRUE")
                        @forelse($udc_order_reports as $key => $each_udc)
                            <tr>
                                <td>{{$page}}</td>
                                <td>{{@$each_udc->name_bn}}</td>
                                <td>{{/*'+88'.*/@$each_udc->contact_number}}</td>

                                <td>
                                    {{'Bkash: ' . (@$each_udc->bkash_number?'+88'.@$each_udc->bkash_number:'')}}
                                    <br>
                                    {{'Rocket: '. (@$each_udc->rocket_number?'+88'.@$each_udc->rocket_number:'')}}
                                </td>

                                <td class="text-right">
                                    <?php
                                    $this_udc_order_total = $each_udc->orders->where('status', '!=', 5)->count();
                                    $total_order += $this_udc_order_total;
                                    ?>
                                    {{number_format($this_udc_order_total,0)}}
                                </td>

                                <td class="text-right">
                                    <?php
                                    $this_udc_total_price = $each_udc->orders->where('status', '!=', 5)->sum('total_price');
                                    $total_price += $this_udc_total_price;
                                    ?>
                                    {{number_format($this_udc_total_price,0)}}
                                </td>

                                <td class="text-right">
                                    {{@$each_udc->total_disbursed_commission->sum('amount')}}
                                </td>

                                <td class="text-right">
                                    <?php
                                    $this_udc_commission = $each_udc->orders->where('status', '!=', 5)->sum('udc_commission');
                                    $total_udc_commission += $this_udc_commission;
                                    ?>
                                        {{number_format($this_udc_commission + @$each_udc->last_disburse_info->due_amount ,0)}}
                                </td>

                                <td class="text-right">
                                    <?php
                                    $this_udc_commission = $each_udc->orders->where('status', '!=', 5)->sum('udc_commission');
                                    $total_udc_commission += $this_udc_commission;
                                    ?>
                                    {{number_format($this_udc_commission,0)}}
                                </td>

                                <td>
                                    <button type="button" class="btn btn-xs btn-primary getcommissiondisbursemodal" data-targettask="modal" data-disbursementamount="{{$this_udc_commission}}" data-udcid="{{$each_udc->id}}" data-modalid="#commissionDisburseModal">Disburse Commission</button>
                                </td>

                            </tr>
                            <?php $page++; ?>
                        @empty
                        @endforelse
                    @else

                        @forelse($udc_order_reports as $key => $each_udc)
                            <tr>
                                <td>{{$page}}</td>
                                <td>{{@$each_udc->name_bn}}</td>
                                <td>{{/*'+88'.*/@$each_udc->contact_number}}</td>

                                <td>
                                    {{'Bkash: ' . (@$each_udc->bkash_number?'+88'.@$each_udc->bkash_number:'')}}
                                    <br>
                                    {{'Rocket: '. (@$each_udc->rocket_number?'+88'.@$each_udc->rocket_number:'')}}
                                </td>

                                <td class="text-right">
                                    <?php
                                    $this_udc_order_total = $each_udc->orders->where('status', '!=', 5)->count();
                                    $total_order += $this_udc_order_total;
                                    $total_disbursed_commission += @$each_udc->total_disbursed_commission->sum('amount');
                                    $total_outstanding_commission += @$this_udc_commission + @$each_udc->total_disbursed_commission->sum('due_amount') + @$each_udc->get_prev_due_commission->sum('udc_commission');
                                    ?>
                                    {{number_format($this_udc_order_total,0)}}
                                </td>

                                <td class="text-right">
                                    <?php
                                    $this_udc_total_price = $each_udc->orders->where('status', '!=', 5)->sum('total_price');
                                    $total_price += $this_udc_total_price;
                                    ?>
                                    {{number_format($this_udc_total_price,0)}}
                                </td>

                                <td class="text-right">
                                    {{@$each_udc->total_disbursed_commission->sum('amount')}}
                                </td>

                                <td class="text-right">
                                    <?php
                                    $this_udc_commission = $each_udc->orders->where('status', '!=', 5)->sum('udc_commission');
                                    $total_udc_commission += $this_udc_commission;
                                    ?>
                                    {{number_format($this_udc_commission + @$each_udc->last_disburse_info->due_amount ,0)}}
                                </td>

                                <td class="text-right">
                                    <?php
                                    $this_udc_commission = $each_udc->orders->where('status', '!=', 5)->sum('udc_commission');
                                    $total_udc_commission += $this_udc_commission;
                                    ?>
                                    {{number_format($this_udc_commission,0)}}
                                </td>

                            </tr>
                            <?php $page++; ?>
                        @empty
                        @endforelse
                    @endif
                    <tr>
                        <td colspan="7"></td>
                    </tr>


                    <tr>
                        <td colspan="4" class="text-center"><strong>TOTAL</strong></td>
                        <td class="text-right"><strong>{{number_format($total_order,0)}}</strong></td>
                        <td class="text-right"><strong>{{number_format($total_price,0)}}</strong></td>
                        <td class="text-right"><strong>{{number_format($total_disbursed_commission,0)}}</strong></td>
                        <td class="text-right"><strong>{{number_format($total_outstanding_commission,0)}}</strong></td>
                        <td class="text-right"><strong>{{number_format($total_udc_commission,0)}}</strong></td>
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