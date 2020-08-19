<div class="m-portlet__head">
    <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
                EP Traffic Statistics
            </h3>
        </div>
    </div>
</div>
<div class="m-portlet__body">
    <div class="m-widget20">
        <div class="m-widget20__chart" style="height:230px;">
            <canvas id="m_chart_bandwidth2" height="270"
                    data-ep-name='[{{@$ep_name_labels}}]'
                    data-labels='[{{@$statistics_chart_labels}}]'
                    data-values="[{{@$statistics_chart_values}}]">
            </canvas>
        </div>
    </div>
</div>