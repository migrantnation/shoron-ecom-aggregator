
{{--<span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $all_orders->total(), "from"=>  ($all_orders->currentpage()-1)*$all_orders->perpage()+1, "to"=>(($all_orders->currentpage()-1)*$all_orders->perpage())+$all_orders->count()])}}</span>--}}
<?php

$chart_labels = explode(",", $chart_labels);
$chart_order_values = explode(",", $chart_order_values);
$chart_sale_values = explode(",", $chart_sale_values);
$chart_commission_values = explode(",", $chart_commission_values);
?>

<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="4">#</th>
        <th width="24%" class="text-center">Date</th>
        <th width="24%" class="text-center">Orders</th>
        <th width="24%" class="text-right">Sales</th>
        <th width="24%" class="text-right">UDC Total Commission</th>
    </tr>
    </thead>
    <tbody>
    @forelse($chart_labels as $key=>$labels)
        <tr>
            <td><?php echo $key + 1;?></td>
            <td class="text-center">{{str_replace('"', "", $labels)}}</td>
            <td class="text-center">{{$chart_order_values[$key]}}</td>
            <td class="text-right">
                ৳ {{$chart_sale_values[$key]?number_format((int)$chart_sale_values[$key], 2):"0.00"}}
            </td>
            <td class="text-right">
                ৳ {{$chart_commission_values[$key]?number_format((int)$chart_commission_values[$key], 2):"0.00"}}
            </td>
        </tr>
    @empty
    @endforelse
    </tbody>
</table>


<div class="text-right">
    {{--<ul class="pagination">--}}
        {{--<li><a href="#">1</a></li>--}}
        {{--<li class="active"><a href="#">2</a></li>--}}
        {{--<li><a href="#">3</a></li>--}}
        {{--<li><a href="#">4</a></li>--}}
        {{--<li><a href="#">5</a></li>--}}
    {{--</ul>--}}
    {{--{!! $all_orders->render() !!}--}}
</div>