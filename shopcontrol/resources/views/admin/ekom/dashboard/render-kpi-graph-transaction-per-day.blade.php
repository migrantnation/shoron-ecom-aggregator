<div class="m-widget26__number">
    {{__('admin_text.tk.')}} {{ number_format(@$total_transaction_per_day?$total_transaction_per_day:0) }}
    <small>Transaction Per Day</small>
</div>
<div class="m-widget26__chart" style="height:200px; width: 100%;">
    <canvas id="transaction_kpi" height="200"
            data-values="[{{@$transaction_chart_values}}]"
            data-kpi-values="[{{@$transaction_chart_kpi_values}}]"
            data-labels='[{{@$transaction_chart_labels}}]'
    ></canvas>
</div>
