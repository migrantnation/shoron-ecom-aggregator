<div class="m-widget26__number">
    {{@$average_order_delivery_time ? ceil(@$average_order_delivery_time) : 0}} Days
    <small>Average Delivery Time</small>
</div>
<div class="m-widget26__chart" style="height:200px; width: 100%;">
    <canvas id="average_delivery_time_kpi" height="200"
            data-values="[{{@$avg_delivery}}]"
            data-kpi-values="[{{@$avg_delivery_kpi_values}}]"
            data-labels='[{{@$avg_delivery_lbl}}]'></canvas>
</div>