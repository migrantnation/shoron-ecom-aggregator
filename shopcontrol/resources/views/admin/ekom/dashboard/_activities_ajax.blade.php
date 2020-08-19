@forelse($user_activities as $activity)
    <?php

    if ($activity->type == 10 || $activity->type == 11 || $activity->type == 12 || $activity->type == 13) {
        $url = url('/admin/udc?ids=') . $activity->ids;
    } else {
        $url = url('/admin/orders/ep-orders?ids=') . $activity->ids;
    }

    ?>

    <a href="{{$url}}">
        <div class="m-timeline-3__item m-timeline-3__item--info load_activities">
                <span class="m-timeline-3__item-time" style="width: 4.7rem;">
                    {{date("H:i", strtotime($activity->created_at))}}
                    <small style="font-size: .6em; display: block">{{date("d-m-Y", strtotime($activity->created_at))}}</small>
                </span>
            <div class="m-timeline-3__item-desc">
                <span class="m-timeline-3__item-text"
                      style="display: block; margin: 12px 0">
                    {{$activity->message}}
                </span>
            </div>
        </div>
    </a>

@empty
@endforelse