<?php

$kpi_meta_title = array("1" => "Sale value", "2" => "Total transaction", "3" => "Order per entrepreneur", "4" => "Average fulfilment");

?>
<div class="col-lg-12 col-xs-12 col-sm-12" style="position: relative; margin-top: 25px;">
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-red-sunglo hide"></i>
                <span class="caption-subject text-primary bold uppercase">{{@$kpi_meta_title[@$kpi_type]}} per day</span>
            </div>
        </div>
        <div class="portlet-body">
            <canvas id="salesChart"
                    data-label="Orders"
                    data-target='[{{@$kpi}}]'
                    data-labels='[{{@$chart_labels}}]'
                    data-values="[{{@$kpi_chart_values}}]"
                    height="420"></canvas>
        </div>
    </div>


    <div class="portlet-body" id="ep_orders">
        {{--@include('admin.ekom.reports.render_sales_list')--}}
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-share font-red-sunglo hide"></i>
                    <span class="caption-subject text-primary bold uppercase">{{@$kpi_meta_title[@$kpi_type]}} per day</span>
                    {{--<span class="caption-helper"></span>--}}
                </div>
            </div>
            <div class="portlet-body">

                <?php

                $chart_labels = explode(",", $chart_labels);
                $kpi_chart_values = explode(",", $kpi_chart_values);
                ?>

                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="6%">#</th>
                        <th width="32%" class="text-center">Date</th>
                        <th width="32%" class="text-right">{{@$kpi_meta_title[@$kpi_type]}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($chart_labels as $key=>$labels)
                        <tr>
                            <td><?php echo $key + 1;?></td>
                            <td class="text-center">{{str_replace('"', "", @$labels)}}</td>
                            <td class="text-right">{{number_format(@$kpi_chart_values[$key], 2)}}</td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>

                {{--<div class="text-right">--}}
                {{--<ul class="pagination">--}}
                {{--<li><a href="#">1</a></li>--}}
                {{--<li class="active"><a href="#">2</a></li>--}}
                {{--<li><a href="#">3</a></li>--}}
                {{--<li><a href="#">4</a></li>--}}
                {{--<li><a href="#">5</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

    <div id="loader" class="loader-overlay">
        <div class="loader">Loading...</div>
    </div>
</div>