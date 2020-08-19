<div class="m-widget26__number">
    {{number_format(@$order_per_entrepreneur_per_day?@$order_per_entrepreneur_per_day:0 , 0)}}
    <small>Order per Entrepreneur per day</small>
</div>
<div class="m-widget26__chart" style="height:200px; width: 100%;">
    <canvas id="opepd_kpi" height="200"
            data-values="[{{@$ord_pr_ent_pr_dy_crt_vals}}]"
            data-kpi-values="[{{@$ord_pr_ent_pr_dy_crt_kpi_vals}}]"
            data-labels='[{{@$ord_pr_ent_pr_dy_crt_lbls}}]'
    ></canvas>
</div>