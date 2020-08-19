<!--Begin::Section Order Stats-->


<style>
    .uppercase {
        line-height: 25px !important;
    }
</style>

<div class="row">
    <div class="col-xl-12">
        <!--begin:: Widgets/Outbound Bandwidth-->
        <div class="m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit "
             style="min-height: 100px">
            <div class="m-portlet__body">
                <div class="text-left col-md-8" style="font-size: 14px;">
                    <?php
                    $total_onboard = 0;
                    $total_package_distributed = 0;
                    $onboard = explode(',', $chart_onboard_member_values);
                    $package_distributed = explode(',', $chart_package_distributed_values);
                    foreach ($onboard as $key => $each_total) {
                        $total_onboard += $onboard[$key];
                        $total_package_distributed += $package_distributed[$key];
                    }
                    ?>
                    <span class="caption-subject text-info bold uppercase">Filtered Result:</span>
                    <br>
                    <span class="caption-subject text-info bold uppercase">UDC Member on Board:</span>
                    <span class="text-info bold" style="padding-left:10px;" id="total_udc">{{@$total_onboard}}</span>
                    <br>
                    <span class="caption-subject text-info bold uppercase">Package Distributed:</span>
                    <span class="text-info bold" style="padding-left:10px;"
                          id="total_package">{{@$total_package_distributed}}</span>
                </div>
                <div class="text-left col-md-4" style="font-size: 14px;">
                    <span class="caption-subject text-info bold uppercase">Total:</span>
                    <br>
                    <span class="caption-subject text-info bold uppercase">Total UDC Member on Board:</span>
                    <span class="text-info bold" style="padding-left:10px;" id="total_udc">{{@$total_udc}}</span>
                    <br>
                    <span class="caption-subject text-info bold uppercase">Total Package Distributed:</span>
                    <span class="text-info bold" style="padding-left:10px;"
                          id="total_package">{{@$total_distributed_package}}</span>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="portlet-body" id="ep_orders">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-red-sunglo hide"></i>
                        <span class="caption-subject text-primary bold uppercase">Logistic Overview Chart</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <canvas id="m_chart_bandwidth2" height="270"
                            data-ep-name='["UDC member on board","Package Distributed"]'
                            data-labels='[{{@$chart_labels}}]'
                            data-values="[[{{@$chart_onboard_member_values}}],[{{@$chart_package_distributed_values}}]]">
                    </canvas>
                </div>
            </div>
            <!--end::Widget 5-->
        </div>
    </div>
    <!--end:: Widgets/Outbound Bandwidth-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="portlet-body" id="ep_orders">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-red-sunglo hide"></i>
                        <span class="caption-subject text-primary bold uppercase">Logistic Overview Per Day</span>
                    </div>
                </div>
                <div class="portlet-body">

                    <?php
                    $chart_labels = explode(",", $chart_labels);
                    $chart_onboard_member_values = explode(",", $chart_onboard_member_values);
                    $chart_package_distributed_values = explode(",", $chart_package_distributed_values);
                    $chart_deactivate_udc_values = explode(",", $chart_deactivate_udc_values);
                    ?>

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="6%">#</th>
                            <th width="15%" class="text-center">Date</th>
                            <th width="20%" class="text-center">UDC member on board</th>
                            <th width="20%" class="text-center">Package Distributed</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($chart_labels as $key=>$labels)
                            <tr>
                                <td><?php echo $key + 1;?></td>
                                <td class="text-center">{{str_replace('"', "", @$labels)}}</td>
                                <td class="text-right">{{@$chart_onboard_member_values[$key]}}</td>
                                <td class="text-right">{{@$chart_package_distributed_values[$key]}}</td>
                            </tr>
                        @empty
                        @endforelse
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong>Total: {{@$total_onboard}}</strong></td>
                            <td class="text-right"><strong>Total: {{@$total_package_distributed}}</strong></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

                <div id="loader" class="loader-overlay">
                    <div class="loader">Loading...</div>
                </div>

            </div>
        </div>
    </div>

</div>
<!--End::Section-->