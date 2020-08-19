<div class="m-widget14__header" style="padding: 0px">
    <h3 class="m-widget14__title">
        {{ 'User Active '. (@$active_user?number_format(@$active_user->count(), 0):0) .' :: Activated ' .number_format(@$activated_dc ? (int)(@$activated_dc->count()) : 0)}}
    </h3>
    <span class="m-widget14__desc">
        Check out each line for more details
    </span>
</div>
<div class="m-widget14__chart" style="height: 250px;">
    <canvas id="inactiveUserBarChart"
            data-label="Sales"
            height="320"
            data-labels='[{{@$user_labels}}]'
            data-orders-values="[{{@$activated_user_values}}]"
            data-sale-values="[{{@$active_user_values}}]"></canvas>
</div>