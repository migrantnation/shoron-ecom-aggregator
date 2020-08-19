<?php
$order = $order_info;
$order_status = array("", "Active", "Warehouse Left", "On the Way", "Delivered", "Canceled");
$payment_status = array("", "Paid", "Unpaid");
$payment_status_class = array("", "success", "danger");
?>
<td width="20">##</td>

<td><a href="#">{{$order->order_code}}</a></td>

<td>{{date('M d, Y H:i a', strtotime($order->created_at))}}</td>

<td>{{$order->user->name_en}}</td>

<td>
    <span class="label label-sm label-{{$payment_status_class[$order->payment_status]}}">{{$payment_status[$order->payment_status]}}</span>
</td>

<td><span class="label label-sm label-danger">{{$order_status[$order->status]}}</span></td>

<td>{{__('_ecom__text.tk.')}} {{$order->total_price}}</td>

<td width="220" class="text-left">
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
    @elseif($order->status == 3)
        <a href="javascript:;" class="btn blue btn-xs change-status"
           data-order-code="{{$order->order_code}}" data-status="4">
            <i class="fa fa-pencil"></i> {{__('admin_text.delivered')}}
        </a>
        <br>
    @endif

    <a href="{{url("ep/order-details/$order->order_code")}}"
       class="btn green btn-xs success btn-xs">
        <i class="fa fa-eye"></i> {{__('admin_text.view')}}
    </a>
    <br>

    <a href="{{url("ep/oder-tracking/$order->order_code")}}"
       class="btn blue btn-xs success btn-xs">
        <i class="fa fa-eye"></i> {{ __('admin_text.tracking-info') }}
    </a>

</td>