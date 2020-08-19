<?php
$order = $order_info;
$order_status = array("", "Active", "Warehouse Left", "On the Way", "Delivered", "Canceled");
$payment_status = array("", "Paid", "Unpaid");
$payment_status_class = array("", "success", "danger");
?>
    <td width="1%">##</td>

    <td width="18%">
        <strong>Code:</strong>{{ $order->order_code}}<br>
        <strong>Order Date:</strong> {{date('M d, Y', strtotime($order->created_at))}}<br>
        <strong>Delivery Duration:</strong> {{$order->delivery_duration}}
    </td>

    <td width="5%">{{$order->ep_name}} </td>

    <td width="22%">
        {{$order->user->name_en}}<br>
        {{$order->receiver_contact_number}}<br>
        {{$order->delivery_location}}
    </td>

    <td width="5%">
        <span class="label label-sm label-{{$payment_status_class[$order->payment_status]}}">{{$payment_status[$order->payment_status]}}</span>
    </td>

    <td width="5%">
        <span class="label label-sm label-danger">{{$order_status[$order->status]}}</span>
    </td>

    <td width="8%">{{__('_ecom__text.tk.')}}{{$order->total_price}}</td>

    <td width="8%" class="text-left">
        @if($order->status == 1)
            <a href="javascript:;" class="btn blue btn-xs change-status"
               data-order-code="{{$order->order_code}}" data-status="2">
                <i class="fa fa-pencil"></i> {{__('admin_text.receive')}}
            </a>
            <br>
        @elseif($order->status == 2)
            <a href="javascript:;" class="btn blue btn-xs change-status"
               data-order-code="{{$order->order_code}}" data-status="3">
                <i class="fa fa-pencil"></i> {{__('admin_text.on-delivery')}}
            </a>
            <br>
        @endif

        <a href="{{url("lp/order-details/$order->order_code")}}"
           class="btn green btn-xs success btn-xs">
            <i class="fa fa-eye"></i> {{__('admin_text.view')}}
        </a>
        <br>

        <a href="{{url("lp/oder-tracking/$order->order_code")}}"
           class="btn blue btn-xs success btn-xs">
            <i class="fa fa-eye"></i> {{ __('admin_text.tracking-info') }}
        </a>

    </td>