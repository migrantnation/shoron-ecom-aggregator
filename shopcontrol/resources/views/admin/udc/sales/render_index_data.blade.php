@if(count($udc_sales) > 0)

    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => 25, "from"=> 1, "to"=>10])}}</span>

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th width="2%">#</th>
            <th width="15%">{{__("admin_text.order")}}</th>
            <th width="15%">{{__("admin_text.product-name")}}</th>
            <th width="6%">{{__("admin_text.product-quantity")}}</th>
            <th width="10%">{{__("admin_text.ep")}}</th>
            <th width="15%">{{__("admin_text.udc")}}</th>
            <th width="10%">{{__("admin_text.status")}}</th>
            <th width="10%">{{__("admin_text.action")}}</th>
        </tr>
        </thead>
        <tbody>
        <?php $status = array("", "Escro Protected", "On Hold", "Paid");?>
        @foreach(@$udc_sales as $key => $each_data)
            <tr>
                <td>{{$key + 1}}</td>
                <td>
                    {{@$each_data->order_with_buyer->order_code}}
                    <br>
                    {{date("Y-m-d h:i:s", strtotime(@$each_data->created_at))}}
                </td>
                <td>
                    <a href="{{@$each_data->udc_product_detail->product_url}}" target="_blank">
                        {{@$each_data->udc_product_info->product_name}}
                    </a>
                </td>
                <td>{{@$each_data->quantity}}</td>
                <td>{{@$each_data->order_with_buyer->ep_name}}</td>
                <td>{{@$each_data->order_with_buyer->user->center_name}}</td>
                <td>{{@$status[$each_data->order_with_buyer->payment_status]}}</td>

                <td width="10%" class="text-left">
                    <a href="{{url("udc/order-details"."/".$each_data->order_with_buyer->id)}}"
                       class="btn green btn-xs">
                        <i class=" icon-diamond"></i> View Invoice
                    </a>
                    <br>

                    @if(@$each_data->udc_product_id)
                        <a href="{{url("udc/edit-product"."/".@$each_data->udc_product_id)}}"
                           class="btn green btn-xs">
                            <i class=" icon-eye"></i> Product Detail
                        </a>
                        <br>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-right">
        {!! @$udc_sales->render() !!}
    </div>

@else
    <div class="alert alert-info">
        {{__('admin_text.no-result')}}
    </div>
@endif

