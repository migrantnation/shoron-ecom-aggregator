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
            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-right">Slno</th>
                        <th>UDC Name</th>
                        <th>Phone Number</th>
                        <th>Mobile Bank Numbers</th>

                        <th class="text-right">Total Orders</th>
                        <th class="text-right">Total Sale</th>
                        <th class="text-right">Total Commission</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $total_order = 0;$total_price = 0;$total_udc_commission = 0;?>
                    @forelse($udc_order_reports as $key=>$each_udc)

                        <tr>
                            <td>{{$page}}</td>
                            <td>{{@$each_udc->name_bn}}</td>

                            <td>{{'+88'.@$each_udc->contact_number}}</td>
                            <td>
                                {{'Bkash: ' . ( @$each_udc->bkash_number? '+88' . @$each_udc->bkash_number: '' )}}
                                <br>
                                {{'Rocket: '. ( @$each_udc->rocket_number?'+88'.@$each_udc->rocket_number : '' ) }}
                            </td>

                            <td class="text-right">
                                <?php
                                $this_udc_order_total = $each_udc->orders->count();
                                $total_order += $this_udc_order_total;
                                ?>
                                {{number_format($this_udc_order_total,0)}}
                            </td>

                            <td class="text-right">
                                <?php
                                $this_udc_total_price = $each_udc->orders->sum('total_price');
                                $total_price += $this_udc_total_price;
                                ?>
                                {{number_format($this_udc_total_price,0)}}
                            </td>

                            <td class="text-right">
                            <?php
                            $this_udc_commission = $each_udc->orders->sum('udc_commission');
                            $total_udc_commission += $this_udc_commission;
                            ?>
                            {{number_format($this_udc_commission,0)}}

                        </tr>
                        <?php $page++; ?>
                    @empty
                    @endforelse
                    <tr>
                        <td colspan="7"></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center"><strong>TOTAL</strong></td>
                        <td class="text-right"><strong>{{number_format($total_order,0)}}</strong></td>
                        <td class="text-right"><strong>{{number_format($total_price,0)}}</strong></td>
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
