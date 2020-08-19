<div class="tab-pane active" id="tab_0">
    <div class="col-md-12">
        <div class="portlet box default">


            <?php
            $order_type = array("All", "Active", "Warehouse Left", "On the Way", "Delivered", "Canceled", "Orders not in EP");
            $payment_status = new \App\Libraries\ChangeOrderStatus();
            ?>
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users"></i> {{@$_GET['tab_id'] && @$_GET['tab_id'] != 'all' ? $order_type[$_GET['tab_id']] : 'All'}}
                    Orders
                </div>

                <div class="text-right" style="color: #63147a; font-size: 16px; padding: 10px; font-weight: 600">
                    {{'Order Total Value: '. number_format(@$total_price, 0)}}
                    &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;
                    {{'Total Orders: '.number_format(@$total_orders, 0)}}
                </div>
            </div>

            <div class="portlet-body">

                @if(@$limit != 'all')
                    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $all_orders->total(), "from"=>  ($all_orders->currentpage()-1)*$all_orders->perpage()+1, "to"=>(($all_orders->currentpage()-1)*$all_orders->perpage())+$all_orders->count()])}}</span>
                @else
                    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $all_orders->count(), "from"=>  1, "to"=>$all_orders->count()])}}</span>
                @endif

                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="1%">#</th>
                        <th width="30%">Order</th>
                        <th width="25%">Customer</th>
                        <th width="5%">Total</th>
                        <th width="5%" class="text-center">Actions</th>
                        <th width="5%" class="text-center">Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $order_status = array("", "Now order is active", "Order left warehouse", "Order on the way", "Order delivered", "Order canceled");
                    $payment_status = new \App\Libraries\ChangeOrderStatus();
                    $page = $page;
                    ?>

                    @forelse($all_orders as $key => $order)

                        <tr>
                            <td width="1%">{{$page}}</td>

                            <td>
                                <strong>Order ID:</strong> {{ $order->order_code}}
                                <br><br>
                                <strong>EP Order ID:</strong> {{$order->ep_order_id}}<br>
                                <strong>EP Name:</strong> {{$order->ep_name}}<br>
                                <strong>Order Date:</strong> {{date('M d, Y', strtotime($order->created_at))}}
                                <br><br>
                                <strong>LP Order ID:</strong> {{$order->lp_order_id}}<br>
                                <strong>LP Name:</strong> {{$order->lp_name}}<br>
                                <strong>Delivery Duration:</strong> {{$order->delivery_duration}}
                            </td>

                            <td width="25%">
                                {{@$order->user->name_bn}}<br>
                                {{@$order->user->contact_number}}<br>
                                {{@$order->user->district}},&nbsp;
                                {{@$order->user->union}}<br>
                                <strong>Center ID:</strong> {{@$order->user->center_id}}<br>
                                <strong>ENTPREN ID:</strong> {{@$order->user->entrepreneur_id}}
                            </td>

                            <td width="12%">{{__('_ecom__text.tk.')}}{{number_format($order->total_price, 2)}}</td>

                            <td>

                                <a href="{{url('admin/udc/order-details/'. $order->id)}}"
                                   class="btn purple plx__btn_lg" target="_blank">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjNDQzk3RTZFMUI4NDExRTg5Q0NFODYxM0I1QTRFRUZBIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjNDQzk3RTZGMUI4NDExRTg5Q0NFODYxM0I1QTRFRUZBIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6M0NDOTdFNkMxQjg0MTFFODlDQ0U4NjEzQjVBNEVFRkEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6M0NDOTdFNkQxQjg0MTFFODlDQ0U4NjEzQjVBNEVFRkEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7ovQApAAACQ0lEQVR42uzXS0hUURjA8ZnS8DUrG4WS1EQwQlAX4sKwokXurAQhEJcuEwnSyTJEQUF0kaFBq0IhXISLCKRFgVCbAWkjPVBEcqEilFZa6u1/6Js6HO9jHo4i9MGPufc87nfPPec+xm9Zlu8g4ojvgOJQJb6IEPISyqzmOAZl+Gr9iTdIjbH/X7GO+CYCsl2F5v261GPG/nS8if1R3k5FMq8L+I5KPMFEMuc4gF/WvxiNd1510TTqtXZHWaKJvS71UawjTSvbRg5Wk3kfdxtJVdxONKnX4srEmmqjla0gmOwn110jqU/u4RFkoxQ3cCqKPOfkiRfVqv5sOcdPzGEIYbQ6HCMX97V+nqu60CZZE65iSyurRIZsX9P6p+AOto1jtHslbrJJfF3qTmIcM7ggZbV4hSBasOhytQJuiR9Jo6d4qHU66zI1w5i0vOOBW+Jv0uiy7C/J/pJcRrs+1RjTTtotcuxWdRsyZHtOfs/Lr7qVXiPLpt8UlpGOWY9V/iJytifQiXntrL7Ar42oUaurcRh1vlzKxy6j3USXatyBHaPyGUqNg9ZI3TrSjbpBqXuHt/J8n3WY39zIHG9IoZrXHpx2GM09aRc2ykNSrhL9kG21yG5pV24AZ8z7uBj1yPJ4o4TlQANG+Zr2cDimjS4kJ/sJV8zjpTDRH4VbFKJCtp8bdS9Rh34USFkjGuR5rz4YPsT7sVeijSRo1B3He61+XMrLcSne93EkUtGOTfTZ1BfLCNW7ewhbe/XN9f8vTMLxW4ABAJ1UU1KCk9IxAAAAAElFTkSuQmCC"
                                         alt="">
                                    <span>{{__('_ecom__text.view-order-details')}}</span>
                                </a>

                                <a href="javascript:;"
                                   class="plx__btn_lg {{$payment_status->get_payment_status_class(2)}} {{(@$order->status < 2)?'change-status':'overlay'}}"
                                   data-order-code="{{$order->order_code}}" data-status="2">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjNDQzk3RTZFMUI4NDExRTg5Q0NFODYxM0I1QTRFRUZBIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjNDQzk3RTZGMUI4NDExRTg5Q0NFODYxM0I1QTRFRUZBIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6M0NDOTdFNkMxQjg0MTFFODlDQ0U4NjEzQjVBNEVFRkEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6M0NDOTdFNkQxQjg0MTFFODlDQ0U4NjEzQjVBNEVFRkEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7ovQApAAACQ0lEQVR42uzXS0hUURjA8ZnS8DUrG4WS1EQwQlAX4sKwokXurAQhEJcuEwnSyTJEQUF0kaFBq0IhXISLCKRFgVCbAWkjPVBEcqEilFZa6u1/6Js6HO9jHo4i9MGPufc87nfPPec+xm9Zlu8g4ojvgOJQJb6IEPISyqzmOAZl+Gr9iTdIjbH/X7GO+CYCsl2F5v261GPG/nS8if1R3k5FMq8L+I5KPMFEMuc4gF/WvxiNd1510TTqtXZHWaKJvS71UawjTSvbRg5Wk3kfdxtJVdxONKnX4srEmmqjla0gmOwn110jqU/u4RFkoxQ3cCqKPOfkiRfVqv5sOcdPzGEIYbQ6HCMX97V+nqu60CZZE65iSyurRIZsX9P6p+AOto1jtHslbrJJfF3qTmIcM7ggZbV4hSBasOhytQJuiR9Jo6d4qHU66zI1w5i0vOOBW+Jv0uiy7C/J/pJcRrs+1RjTTtotcuxWdRsyZHtOfs/Lr7qVXiPLpt8UlpGOWY9V/iJytifQiXntrL7Ar42oUaurcRh1vlzKxy6j3USXatyBHaPyGUqNg9ZI3TrSjbpBqXuHt/J8n3WY39zIHG9IoZrXHpx2GM09aRc2ykNSrhL9kG21yG5pV24AZ8z7uBj1yPJ4o4TlQANG+Zr2cDimjS4kJ/sJV8zjpTDRH4VbFKJCtp8bdS9Rh34USFkjGuR5rz4YPsT7sVeijSRo1B3He61+XMrLcSne93EkUtGOTfTZ1BfLCNW7ewhbe/XN9f8vTMLxW4ABAJ1UU1KCk9IxAAAAAElFTkSuQmCC"
                                         alt="">
                                    <span>{{__('admin_text.warehouse-left')}}</span>
                                </a>

                                <a href="javascript:;"
                                   class="plx__btn_lg {{$payment_status->get_payment_status_class(3)}} {{(@$order->status < 3)?'change-status':'overlay'}}"
                                   data-order-code="{{$order->order_code}}" data-status="3">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJwSURBVEhL7ZY9SFVxGMZvIhYlZQ0KEQ22SU0tSQUXCULCpWjNTYgGXSLBKCiopaGGWsyGqMEGaUyioa8po8JBQmyIoKXEjyysuLffc3zuvd7zdQ9aDuEDP8///7zPe9577j3nXnPr+v9VLBaPrJI8NPl02VUoFKZXyRx8ZXirT7k2YmAdg99Br61somEqI7fdEhG157yAfm+ziYaTGTnklog0GAbIbA/jSFQ0nKtBn6OJIqMrjhW1L3DK0YowH9fgoaOJIqMrvsecVqG12QO9sAjdji+JYOTtWUadY6nipFWfMftbwlvtu2EB9tkKBqdpt2Op4oSpgyX2QzABWwKDhrgrLfFXrliivhlvHO4EBou4z7UjKGYU+ZqDJbw2+AHt2sTdyW3OZhL58OBrEHtTkntAbVALPaPb7K9I4cGs9+PNc5zhGP6K1RU/VUjPWuVuW4Horxos4TVDB37VjwreDeX/2eAkkT2dOhhvF3TBASL1tmOlE4UH47XAMThIrcF2+mD2F+EnfILv8IZY4s8e9fDN1ee+zzAP72Gva/GDWZ+AWWjXnrKev2GOY0EgRtTLgznqc9TQo65thEGYolbPcWkwfz6qgNkjWL+Gy2oqif1W+A3nS7nl4E/CiNfP4KZbA+E34OlirsALuKuTHoYnFMcEa/1HccY9gfA34KlxopRLgowemQtuLQvvA0yS0XO803ZFmFfhJYHyDcX+OHzDa7SVKHJnYZzsJlt64Xm8X9BiKyqKO0Bv3SvQt5i+/hZp7nEkVeR0T7wFDe/neB0WtHYkWYSaCF+CUbjPPu9SJpFvpG8AHsEwdLq0rrVWLvcHNYe52aLftykAAAAASUVORK5CYII="
                                         alt="">
                                    <span>{{__('admin_text.on-delivery')}}</span>
                                </a>

                                <a href="javascript:;"
                                   class="plx__btn_lg {{$payment_status->get_payment_status_class(4)}} {{(@$order->status < 4)?'change-status':'overlay'}}"
                                   data-order-code="{{$order->order_code}}" data-status="4">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFNSURBVEhL7ZTBasJAFEVDd4YuxG6s2lWxOy2t0lVBi1AU/AR1q3Tl//QDuugH9UO6TzwvvMhkGBEyUQTnwuW93Mm7NwmTiQICAi4SSZLMtC0gTdNY2+pB6BB24BtsqJyB66VL9wJvc4NhizqA7/T/8EeXJXTj0r0gobCO4cgw/6Nvwph+Zes66gfM2piNbXPqA5yeJBSjAYYvjtBn2D9JKGZz2LHNoTxMG36Yuo75AbMlZrEdSpU3vYcTU9ex42BAnrallwWgL6Q6QuU36tGPTT0bOgZulN9iTb2lPsGuLmXgegZrrNufV3Zv+Y3EwCcDKfUXNqDszEddyw4Hlzm9fPpyoTkY3DKYh9/BLrQPBzPUPBzKhebAYB9Okc9+vsMBIzO8sGGor/Db1nXUHxjm4YK9Of2XS68UGG9d5of0SkFATdsCDukBAdeKKNoB222DUfcbldEAAAAASUVORK5CYII="
                                         alt="">
                                    <span>{{ __('_ecom__text.receive-order') }}</span>
                                </a>

                                <a href="javascript:;"
                                   class="plx__btn_lg status-cancel-btn {{($order->status < 5)?'cancel-order-status':'overlay'}}"
                                   data-order-code="{{$order->order_code}}" data-status="5">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkE5RDk0MDRFMUI4QzExRTg4QkZCRTA0QzU4MkJCNkUwIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkE5RDk0MDRGMUI4QzExRTg4QkZCRTA0QzU4MkJCNkUwIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QTlEOTQwNEMxQjhDMTFFODhCRkJFMDRDNTgyQkI2RTAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QTlEOTQwNEQxQjhDMTFFODhCRkJFMDRDNTgyQkI2RTAiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz42HOXbAAABpElEQVR42txXzU7DMAxuIq6sElcEUoVg3Fn7/te13QMUBGignaduD1Ac9BVlmZM63aSiRbKSJo6/2PFPqrquS6ZoOpmoXfWDT6VS6r6IZkTzrOtezwFAcp+oa4h2RPckt3U1/gCoaRU2nAO0wucMGEemvrHGhqmmjfMTQM3e2lLmAMMGfibaW9/XROUYcOwpIaNve2D8NmV7NW14ZE5p7mZBd/MmBBXJOPBqLBRgtM2+kmgOnhUDWrgHPwonYmgAHmX2gHkLyByOYzAuGM1LztsxV3rM20QlEMRxTtSGvN3jvWZPHsoFaihlQnDFmPAO429mLfdpKgYOgG/Q38aCioGde0w9LC0cSZRqVUx1Qj434fLgLL0TvfR5+F9XJx2hrTH1mtE2wdw6prDoiNxbO/e7sRwswZq4sEwWTlpg3qVHcAtnypn0uhwyuxYU8TSUBj3pNR16TOiIIr7zxSnmuKrmvXN9apUZW9WmfwjEFPFQkz4m/jSmSTeuxAk/IgzNwZR7x1tpERdqznn7lnOuzGLKz/Ggtx4TvTLZqOp0Ef9OPwIMACHbBf70vzPNAAAAAElFTkSuQmCC"
                                         alt="">
                                    <span>{{ __('_ecom__text.cancel-order') }}</span>
                                </a>

                            </td>

                            <td class="text-left">
                                <span class="plx__label {{$payment_status->get_payment_status_class($order->status)}}">
                                    {{$order_status[$order->status]}}
                                </span><br><br><br><br>

                                @if($order->ep_log)
                                    <span class="plx__label {{$payment_status->get_payment_status_class($order->status)}}  view-log"
                                          data-ordercode="{{$order->order_code}}"
                                          data-field="ep_log">
                                    View EP Order Log
                                </span>
                                @endif
                                <br><br>

                                @if($order->lp_log)
                                    <span class="plx__label view-log"
                                          data-ordercode="{{$order->order_code}}"
                                          data-field="lp_log">
                                    View LP Order Log
                                </span>
                                @endif
                            </td>

                        </tr>
                        <?php $page++; ?>
                    @empty
                        <tr>
                            <td colspan="8" align="center">No Orders Available</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-6 text-left">
        &nbsp;&nbsp;&nbsp;&nbsp;

        <select name="limit" id="limit" onchange="ajaxpush();">
            <option value="10" {{($limit == 15)?'selected':''}}>15</option>
            {{--<option value="20" {{($limit == 20)?'selected':''}}>20</option>--}}
            {{--<option value="50" {{($limit == 50)?'selected':''}}>50</option>--}}
            {{--<option value="100" {{($limit == 100)?'selected':''}}>100</option>--}}
            <option value="all" {{($limit == "all")?'selected':''}}>All</option>
        </select>
    </div>

    <div class="col-sm-6 text-right">
        @if(@$limit != 'all')
            {!! @$all_orders->render() !!}
        @endif
    </div>

</div>


<script>
    document.getElementById("SubmitSearch").onsubmit = function () {
        ajaxpush();
        return false;
    };

    var url = "{{$url}}";
    $(document).on('click', '.export', function (e) {
        var search_string = $('#search_string').val();
        var from = $('#periodpickerstart').val();
        var to = $('#periodpickerend').val();
        var export_type = $(this).data('filetype');
        window.location = url + "?from=" + from + "&to=" + to + "&search_string=" + search_string + "&tab_id=" + tab_id + "&export_type=" + export_type + "";
    });

    $(document).ready(function () {
        $('#search_string').keypress(function (e) {
            if (e.which == 13) {
                e.preventDefault();
                ajaxpush();
            }
        });
    });

    var page = '{{@$_GET['page']?@$_GET['page']:1}}';

    $('.change-status').on('click', function () {
        var order_code = $(this).data('order-code');
        var status = $(this).data('status');

        $.confirm({
            icon: 'fa fa-question',
            theme: 'material',
            content: 'Are you sure you want to change this order status?',
            closeIcon: true,
            animation: 'scale',
            type: 'orange',
            title: 'Confirmation',
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function () {

                        var data = {
                            order_code: order_code,
                            status: status,
                            _token: "{{csrf_token()}}",
                        }

                        $.ajax({
                            url: "{{url('admin/change-order-status')}}",
                            type: "post",
                            dataType: 'json',
                            data: data,
                            success: function (response) {
                                if (response['meta']['status'] == 200) {
                                    successToast(response['response']['message']);
                                    ajaxpush();
                                    datePickerInit();
                                } else {
                                    warningToast(response['response']['message']);
                                }
                            }
                        });
                    }
                },
                'cancel': {}
            }
        });
    });


    $('.cancel-order-status').on('click', function () {
        var order_code = $(this).data('order-code');
        var status = $(this).data('status');

        $.confirm({
            icon: 'fa fa-question',
            theme: 'material',

            content: 'Are you sure you want to cancel this order?' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<br><label>Enter something here</label>' +
            '<input type="text" placeholder="Please type your reason of cancel" class="message form-control" id="message" required />' +
            '</div>' +
            '</form>',

            closeIcon: true,
            animation: 'scale',
            type: 'orange',
            title: 'Confirmation',
            buttons: {
                formSubmit: {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function () {
                        var message = this.$content.find('#message').val();
                        if (!message) {
                            $.alert('Plese provide a reason for order cancel.');
                            return false;
                        } else {
                            var data = {
                                order_code: order_code,
                                message: message,
                                status: status,
                                _token: "{{csrf_token()}}",
                            }

                            $.ajax({
                                url: "{{url('admin/change-order-status')}}",
                                type: "post",
                                dataType: 'json',
                                data: data,
                                success: function (response) {
                                    if (response['meta']['status'] == 200) {
                                        successToast(response['response']['message']);
                                        ajaxpush();
                                        datePickerInit();
                                    } else if (response['meta']['status'] == 100) {
                                        worningToast(response['response']['message']);
                                    } else if (response['meta']['status'] == 101) {
                                        worningToast(response['response']['message']);
                                        window.location.href = '{{url('ep')}}';
                                    }
                                }
                            });
                        }
                    }
                },
                'cancel': {}
            }
        });
    });


    $('.view-log').on('click', function () {

        var data = {
            field: $(this).data('field'),
            order_code: $(this).data('ordercode'),
        }
        $.ajax({
            url: "{{url("get-order-log")}}",
            type: "get",
            dataType: 'json',
            data: data,
            success: function (response) {

                if (response['meta']['status'] == 200) {
                    log = response['response']['view'];
                    log = JSON.parse(log);

                    $('#modal_title').html(log.track);
                    $('#order-log-headers').html(code_indent(JSON.stringify(log.headers)));
                    $('#order-log-ch').html(code_indent(JSON.stringify(log.ch)));
                    $('#order-log-response').html(code_indent(JSON.stringify(log.response)));
                    $('#order-log-postdata').html(code_indent(JSON.stringify(log.postdata)));
                    $('#myModal').modal('show');

                } else {
                    warningToast(response['response']['message']);
                }
            }
        });
    });

    function code_indent(jsonStr) {
        f = {
            brace: 0
        };
        regeStr = jsonStr.replace(/({|}[,]*|[^{}:]+:[^{}:,]*[,{]*)/g, function (m, p1) {
            var rtnFn = function () {
                    return '<div style="text-indent: ' + (f['brace'] * 20) + 'px;">' + p1 + '</div>';
                },
                rtnStr = 0;
            if (p1.lastIndexOf('{') === (p1.length - 1)) {
                rtnStr = rtnFn();
                f['brace'] += 1;
            } else if (p1.indexOf('}') === 0) {
                f['brace'] -= 1;
                rtnStr = rtnFn();
            } else {
                rtnStr = rtnFn();
            }
            return rtnStr;
        });
        return regeStr;
    }

</script>