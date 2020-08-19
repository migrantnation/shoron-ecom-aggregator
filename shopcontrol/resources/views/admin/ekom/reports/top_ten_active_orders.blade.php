<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th width="20">#</th>
            <th>Order</th>
            <th>EP Name</th>
            <th>Customer</th>
            <th>Payment Status</th>
            <th>Order Status</th>
            <th>Total</th>
            <th>DC Commission</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $order_status = array("", "Active", "Warehouse Left", "On the Way", "Delivered", "Canceled");
        $payment_status = new \App\Libraries\ChangeOrderStatus();
        ?>
        @forelse($last_ten_active_orders as $key => $order)

            <tr>
                <td width="1%">{{$key+1}}</td>

                <td width="18%">
                    <strong>Code:</strong>{{ $order->order_code}}<br>
                    <strong>Order Date:</strong> {{date('M d, Y', strtotime($order->created_at))}}<br>
                    <strong>Delivery Duration:</strong> {{$order->delivery_duration}}
                </td>

                <td width="5%">{{$order->ep_name}} </td>

                <td width="22%">
                    {{@$order->user->name_bn}}<br>
                    {{@$order->receiver_contact_number}}<br>
                    {{@$order->delivery_location}}
                </td>

                <td width="5%">
                    <span class="label label-sm label-{{$payment_status->get_payment_status_class($order->payment_status)}}">{{$payment_status->get_payment_status($order->payment_status)}}</span>
                </td>

                <td width="5%">
                                <span class="label label-sm label-{{$payment_status->get_payment_status_class($order->status)}}">
                                    {{$order_status[$order->status]}}
                                </span>
                </td>

                <td width="12%">{{__('_ecom__text.tk.')}}{{number_format($order->total_price, 2)}}</td>
                <td width="8%">{{__('_ecom__text.tk.')}}{{number_format($order->udc_commission, 2)}}</td>

                <td width="8%" class="text-left">
                    <a href="{{url('admin/udc/order-details/'. $order->id)}}" class="btn purple btn-xs">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <br>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" align="center">No Orders Available</td>
            </tr>
        @endforelse


        </tbody>
    </table>
</div>