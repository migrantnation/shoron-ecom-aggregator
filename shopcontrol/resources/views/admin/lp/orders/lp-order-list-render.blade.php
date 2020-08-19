<div class="tab-pane active" id="tab_0">
    <div class="col-md-12">
        <div class="portlet box default">

            <?php $order_type = array("All", "Active", "Warehouse Left", "On the Way", "Delivered", "Canceled");?>
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

                <form action="javascript:void(0)" class="table-toolbar" id="SubmitSearch">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group input-daterange" data-date="2012-10-11"
                                 data-date-format="yyyy-mm-dd">

                                <input type="text" class="form-control" name="from" id="from"
                                       value="{{@$_GET['from'] ? @$_GET['from'] : ""}}">

                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="to" id="to"
                                       value="{{@$_GET['to'] ? @$_GET['to'] : ""}}">

                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_string"
                                           value="{{@$_GET['search_string'] ? @$_GET['search_string'] : ""}}">
                                    <span class="input-group-btn">
                                <button class="btn blue" type="button" id="submit_search" onclick="ajaxpush();"><i
                                            class="fa fa-search"></i></button>
                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="dropdown" style="display: inline-block">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                    Export
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="javascript:;" class="export" data-filetype="csv">
                                            <i class="fa fa-file-o"></i> CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="export" data-filetype="xlsx">
                                            <i class="fa fa-file-excel-o"></i> Excel
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>


            @if(@$limit != 'all')
                    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $all_orders->total(), "from"=>  ($all_orders->currentpage()-1)*$all_orders->perpage()+1, "to"=>(($all_orders->currentpage()-1)*$all_orders->perpage())+$all_orders->count()])}}</span>
                @else
                    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $all_orders->count(), "from"=>  1, "to"=>$all_orders->count()])}}</span>
                @endif

                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="20">#</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th class="text-center">Actions</th>
                        <th class="text-center">Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $order_status = array("", "Now order is active", "Order left warehouse", "Order on the way", "Order delivered", "Order canceled");
                    $payment_status = new \App\Libraries\ChangeOrderStatus();
                    ?>

                    @forelse($all_orders as $key => $order)

                        <tr id="row-{{$order->order_code}}">
                            <td width="1%">{{$page}}</td>

                            <td width="25%">
                                <strong>Order ID:</strong> {{ $order->order_code}}<br>
                                <strong>LP Order ID:</strong> {{$order->lp_order_id}}<br>
                                <strong>EP Order ID:</strong> {{$order->ep_order_id}}<br>
                                <strong>EP Name:</strong> {{$order->ep_name}}<br>
                                <strong>Order Date:</strong> {{date('M d, Y', strtotime($order->created_at))}}<br>
                                <strong>Delivery Duration:</strong> {{$order->delivery_duration}}
                            </td>

                            <td width="20%">
                                {{@$order->user->name_bn}}<br>
                                {{$order->receiver_contact_number}}<br>
                                {{@$order->user->district}}<br>
                                {{@$order->user->union}}
                            </td>

                            <td width="10%">{{__('_ecom__text.tk.')}}{{number_format(@$order->total_price, 2)}}</td>

                            <td width="5%">

                                <a href="{{url("lp/order-details/$order->order_code")}}"
                                   class="btn purple plx__btn_lg" target="_blank">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjNDQzk3RTZFMUI4NDExRTg5Q0NFODYxM0I1QTRFRUZBIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjNDQzk3RTZGMUI4NDExRTg5Q0NFODYxM0I1QTRFRUZBIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6M0NDOTdFNkMxQjg0MTFFODlDQ0U4NjEzQjVBNEVFRkEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6M0NDOTdFNkQxQjg0MTFFODlDQ0U4NjEzQjVBNEVFRkEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7ovQApAAACQ0lEQVR42uzXS0hUURjA8ZnS8DUrG4WS1EQwQlAX4sKwokXurAQhEJcuEwnSyTJEQUF0kaFBq0IhXISLCKRFgVCbAWkjPVBEcqEilFZa6u1/6Js6HO9jHo4i9MGPufc87nfPPec+xm9Zlu8g4ojvgOJQJb6IEPISyqzmOAZl+Gr9iTdIjbH/X7GO+CYCsl2F5v261GPG/nS8if1R3k5FMq8L+I5KPMFEMuc4gF/WvxiNd1510TTqtXZHWaKJvS71UawjTSvbRg5Wk3kfdxtJVdxONKnX4srEmmqjla0gmOwn110jqU/u4RFkoxQ3cCqKPOfkiRfVqv5sOcdPzGEIYbQ6HCMX97V+nqu60CZZE65iSyurRIZsX9P6p+AOto1jtHslbrJJfF3qTmIcM7ggZbV4hSBasOhytQJuiR9Jo6d4qHU66zI1w5i0vOOBW+Jv0uiy7C/J/pJcRrs+1RjTTtotcuxWdRsyZHtOfs/Lr7qVXiPLpt8UlpGOWY9V/iJytifQiXntrL7Ar42oUaurcRh1vlzKxy6j3USXatyBHaPyGUqNg9ZI3TrSjbpBqXuHt/J8n3WY39zIHG9IoZrXHpx2GM09aRc2ykNSrhL9kG21yG5pV24AZ8z7uBj1yPJ4o4TlQANG+Zr2cDimjS4kJ/sJV8zjpTDRH4VbFKJCtp8bdS9Rh34USFkjGuR5rz4YPsT7sVeijSRo1B3He61+XMrLcSne93EkUtGOTfTZ1BfLCNW7ewhbe/XN9f8vTMLxW4ABAJ1UU1KCk9IxAAAAAElFTkSuQmCC"
                                         alt="">
                                    <span>{{__('_ecom__text.view-order-details')}}</span>
                                </a>

                                <a href="javascript:;"
                                   class="plx__btn_lg {{$payment_status->get_payment_status_class(3)}} {{(@$order->status==2)?'change-status':'overlay'}}"
                                   data-order-code="{{$order->order_code}}" data-status="3">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJwSURBVEhL7ZY9SFVxGMZvIhYlZQ0KEQ22SU0tSQUXCULCpWjNTYgGXSLBKCiopaGGWsyGqMEGaUyioa8po8JBQmyIoKXEjyysuLffc3zuvd7zdQ9aDuEDP8///7zPe9577j3nXnPr+v9VLBaPrJI8NPl02VUoFKZXyRx8ZXirT7k2YmAdg99Br61somEqI7fdEhG157yAfm+ziYaTGTnklog0GAbIbA/jSFQ0nKtBn6OJIqMrjhW1L3DK0YowH9fgoaOJIqMrvsecVqG12QO9sAjdji+JYOTtWUadY6nipFWfMftbwlvtu2EB9tkKBqdpt2Op4oSpgyX2QzABWwKDhrgrLfFXrliivhlvHO4EBou4z7UjKGYU+ZqDJbw2+AHt2sTdyW3OZhL58OBrEHtTkntAbVALPaPb7K9I4cGs9+PNc5zhGP6K1RU/VUjPWuVuW4Horxos4TVDB37VjwreDeX/2eAkkT2dOhhvF3TBASL1tmOlE4UH47XAMThIrcF2+mD2F+EnfILv8IZY4s8e9fDN1ee+zzAP72Gva/GDWZ+AWWjXnrKev2GOY0EgRtTLgznqc9TQo65thEGYolbPcWkwfz6qgNkjWL+Gy2oqif1W+A3nS7nl4E/CiNfP4KZbA+E34OlirsALuKuTHoYnFMcEa/1HccY9gfA34KlxopRLgowemQtuLQvvA0yS0XO803ZFmFfhJYHyDcX+OHzDa7SVKHJnYZzsJlt64Xm8X9BiKyqKO0Bv3SvQt5i+/hZp7nEkVeR0T7wFDe/neB0WtHYkWYSaCF+CUbjPPu9SJpFvpG8AHsEwdLq0rrVWLvcHNYe52aLftykAAAAASUVORK5CYII="
                                         alt="">
                                    <span>{{__('admin_text.on-delivery')}}</span>
                                </a>

                            </td>

                            <td width="8%" class="text-left">

                                <span class="plx__label {{$payment_status->get_payment_status_class($order->status)}}">
                                    {{$order_status[$order->status]}}
                                </span>

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

    $(document).on('click', '.export', function (e) {
        var search_string = $('#search_string').val();
        var from = $('#from').val();
        var to = $('#to').val();
        var export_type = $(this).data('filetype');
        window.location = "{{url('lp/orders')}}" + "?from=" + from + "&to=" + to + "&search_string=" + search_string + "&tab_id=" + tab_id + "&export_type=" + export_type + "";
    });

    $(document).ready(function () {
        $('#search_string').keypress(function (e) {
            if (e.which == 13) {
                e.preventDefault();
                ajaxpush();
            }
        });
    });

    function change_status() {

        $('.change-status').on('click', function () {
            var order_code = $(this).data('order-code');
            var status = $(this).data('status');
            var search_string = $('#search_string').val();
            var from = $('#from').val();
            var to = $('#to').val();

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
                                tab_id: tab_id,
                                search_string: search_string,
                                from: from,
                                to: to,
                                page: page,
                                order_code: order_code,
                                _token: "{{csrf_token()}}",
                                status: status,
                            }

                            $.ajax({
                                url: "{{url('lp/change-order-status')}}",
                                type: "post",
                                dataType: 'json',
                                data: data,
                                success: function (response) {
                                    if (response['meta']['status'] == 200) {
                                        successToast(response['response']['message']);
                                        ajaxpush();
                                        datePickerInit();
                                    } else {
                                        worningToast(response['response']['message']);
                                    }
                                }
                            });
                        }
                    },
                    'cancel': {}
                }
            });
        });
    }

    change_status();
</script>