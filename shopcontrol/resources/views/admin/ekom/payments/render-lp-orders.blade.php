<div class="tab-pane active" id="tab_0">
    <div class="col-md-12">
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users"></i> {{__('admin_text.orders')}}
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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                {{--<li>{{ $error }}</li>--}}
                                <p class="text-center">{{App::isLocale('bn') ? 'একটি পেমেন্ট করতে অনুগ্রহ করে নীচের অর্ডার তালিকা থেকে কমপক্ষে একটি অর্ডার নির্বাচন করুন': 'Please select at least one order from below order list to make a payment.'}}</p>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{url('admin/payments/pay-to-lp')}}" method="post" name="">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-sm btn-success">{{__('admin_text.disburse-payment')}}</button>
                    <br><br><br>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="20"><input type="checkbox" name="all" @if(old('all')) checked @endif class="orders-to-pay all" value="all"></th>
                            <th>{{__('admin_text.order')}}</th>
                            <th>{{__('admin_text.order-date')}}</th>
                            <th>{{__('admin_text.customer-name')}}</th>
                            {{--<th>Payment Status</th>--}}
                            {{--<th>Fullfillment Status</th>--}}
                            <th>{{__('admin_text.grand-total')}}</th>
                        </tr>
                        </thead>
                        <?php $enTobn = new \App\Libraries\PlxUtilities(); ?>
                        <tbody>
                        @forelse($all_orders as $key => $order)

                            <tr>
                                <td width="20"><input type="checkbox" @if(old('order_ids') && in_array($order->id, old('order_ids'))) checked @endif class="orders-to-pay" name="order_ids[]" value="{{$order->id}}"></td>

                                <td><a href="#">{{App::isLocale('bn') ? $enTobn->en2bnNumber($order->order_code): $order->order_code}}</a></td>

                                <td>{{date('M d, Y H:i a', strtotime($order->created_at))}}</td>

                                <td>{{$order->user->name_en}}</td>

                                {{--<td>--}}
                                {{--<span class="label label-sm label-{{$order->payment_status==1?'success':'danger'}}">{{$order->payment_status==1?'Paid':'Unpaid'}}</span>--}}
                                {{--</td>--}}

                                {{--<td>--}}
                                {{--<span class="label label-sm label-danger">{{$order->status==1?'Active':($order->status==2?"Shipped":($order->status==3?"Completed":'Inactive'))}}</span>--}}
                                {{--</td>--}}

                                <td>{{__('admin_text.tk.')}} {{App::isLocale('bn') ? $enTobn->en2bnNumber($order->lp_delivery_charge): $order->lp_delivery_charge}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" align="center">No Orders Available</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </form>
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


<script>
    $('input.orders-to-pay').on('change', function () {
        if ($(this).val() == 'all') {
            if ($(this).is(':checked')) {
                $('input.orders-to-pay').not(this).prop('checked', true);
            } else {
                $('input.orders-to-pay').not(this).prop('checked', false);
            }
        } else {
            $('input.all').not(this).prop('checked', false);
            if (parseInt($('.orders-to-pay:checked').length) + parseInt(1) == $('.orders-to-pay').length) {
                $('input.orders-to-pay').not(this).prop('checked', true);
            }
        }
    });
</script>