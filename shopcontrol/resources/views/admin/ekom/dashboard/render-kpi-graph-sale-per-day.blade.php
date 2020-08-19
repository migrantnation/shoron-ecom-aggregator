<div class="m-widget26__number">
    {{__('admin_text.tk.')}} {{ number_format(@$sale_value_per_day?@$sale_value_per_day:0 , 0)}}
    <small>Sales per Day</small>
</div>
<div class="m-widget26__chart" style="height:200px; width: 100%;">
    <canvas id="sale_kpi" height="200"
            data-values="[{{@$sale_chart_values}}]"
            data-kpi-values="[{{@$sale_chart_kpi_values}}]"
            data-labels='[{{@$chart_labels}}]'
    ></canvas>
</div>