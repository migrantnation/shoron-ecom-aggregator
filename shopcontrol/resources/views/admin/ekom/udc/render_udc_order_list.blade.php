<div class="tab-pane active" id="tab_0">
    <div class="col-md-12">
        <div class="portlet box purple">

            <?php $order_type = array("All", "Pending", "Received", "Delivered");?>
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users"></i> {{@$_GET['tab_id']?$order_type[$_GET['tab_id']]:'All'}} Orders
                </div>
            </div>

            <div class="portlet-body">

                <form action="#" class="table-toolbar" id="SubmitSearch">
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
                </form>

                <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $all_orders->total(), "from"=>  ($all_orders->currentpage()-1)*$all_orders->perpage()+1, "to"=>(($all_orders->currentpage()-1)*$all_orders->perpage())+$all_orders->count()])}}</span>

                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="20">#</th>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Payment Status</th>
                        <th>Fullfillment Status</th>
                        <th>Total</th>
                        <th width="220">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($all_orders as $key => $order)

                        <tr>
                            <td width="20">{{$key+1}}</td>

                            <td><a href="#">{{$order->order_code}}</a></td>

                            <td>{{date('M d, Y H:i a', strtotime($order->created_at))}}</td>

                            <td>{{$order->user->name_bn}}</td>

                            <td>
                                <span class="label label-sm label-{{$order->payment_status==1?'success':'danger'}}">{{$order->payment_status==1?'Paid':'Unpaid'}}</span>
                            </td>

                            <td>
                                <span class="label label-sm label-danger">{{$order->status==1?'Active':($order->status==2?"Shipped":($order->status==3?"Completed":'Inactive'))}}</span>
                            </td>

                            <td>{{__('_ecom__text.tk.')}} {{$order->total_price}}</td>

                            <td width="10%" class="text-left">

                                {{--<a href="javascript:;" class="btn red btn-xs">--}}
                                    {{--<i class="fa fa-trash-o"></i> Cancel--}}
                                {{--</a>--}}
                                {{--<br>--}}

                                <a href="{{url('admin/udc/order-details/'. $order->id)}}" class="btn success btn-xs">
                                    <i class="fa fa-eye"></i> View
                                </a>
                                <br>
                                {{--<a href="{{url("udc/oder-tracking/$order->id")}}" class="btn green btn-xs">--}}
                                    {{--<i class="fa fa-pencil"></i> {{ __('admin_text.tracking-info') }}--}}
                                {{--</a>--}}

                                <a href="{{url("admin/ekom/oder-tracking/$order->order_code")}}" class="btn green btn-xs">
                                    <i class="fa fa-pencil"></i> {{ __('admin_text.tracking-info') }}
                                </a>

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
        </div>
    </div>
</div>

<div class="text-right">
    {!! $all_orders->render() !!}
</div>
<script>
    document.getElementById("SubmitSearch").onsubmit = function () {
        ajaxpush();
        return false;
    };
</script>