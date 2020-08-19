<div class="m-widget20__number m--font-success">
    {{@$todays_visitor}}
</div>
<div class="m-widget20__chart" style="height:200px;">
    <canvas id="m_chart_visitor"
            data-labels='[{{@$daily_visitor_labels}}]'
            data-values="[{{@$daily_visitor_values}}]"></canvas>
</div>