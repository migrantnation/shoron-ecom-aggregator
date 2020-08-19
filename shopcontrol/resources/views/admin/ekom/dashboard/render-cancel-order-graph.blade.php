<div class="m-widget14__header" style="padding: 0px">
    <h3 class="m-widget14__title">
        {{ 'Order '.number_format(@$orders->count(), 0).' :: Canceled ' .number_format(@$canceled_orders ? (int)(@$canceled_orders->count()) : 0)}}
    </h3>
    <span class="m-widget14__desc">
        Check out each line for more details
    </span>
</div>
<div class="m-widget14__chart" style="height: 250px;">
    <canvas id="cancellationOrderChart"
            data-label="Sales"
            height="320"
            data-labels='[{{@$active_cancel_graph_labels}}]'
            data-orders-values="[{{@$order_chart_values}}]"
            data-sale-values="[{{@$canceled_order_values}}]"></canvas>
</div>