@if(count($udc_transactions) > 0)


    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $udc_transactions->total(), "from"=>  ($udc_transactions->currentpage()-1)*$udc_transactions->perpage()+1, "to"=>(($udc_transactions->currentpage()-1)*$udc_transactions->perpage())+$udc_transactions->count()])}}</span>


    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th width="20">#</th>
            <th>Transaction code</th>
            <th>Order Code</th>
            <th>Payment date</th>
            <th>Transaction Amount</th>
            <th>Transaction Type</th>
            <th>Payment Status</th>
            <th width="220">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $status = array("","Escro Protected","On Hold", "Paid");?>
        @foreach(@$udc_transactions as $key => $each_data)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{'TRANS-'.str_replace('2017', '',$each_data->order_code).rand(111,999)}}</td>
                <td>{{$each_data->order_code}}</td>
                <td>{{$each_data->created_at}}</td>
                <td>{{__('_ecom__text.tk.')}} {{$each_data->total_price}}</td>
                <td>Bank Transaction</td>
                <td>{{$status[$each_data->payment_status]}}</td>

                <td width="10%" class="text-left">
                    <a href="{{url("admin/udc/order-details/$each_data->id")}}"
                       class="btn green btn-xs">
                        <i class=" icon-diamond"></i> View Invoice
                    </a>
                    <br>

                    @if($each_data->status == 1)
                        <a href="javascript:void(0)" class="btn red btn-xs">
                            <i class="fa fa-cancel-o"></i> Inactive
                        </a>
                    @elseif($each_data->status == 2)
                        <a href="javascript:void(0)" class="btn red btn-xs">
                            <i class="fa fa-check-o"></i> Active
                        </a>
                    @endif


                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-right">
        {!! @$udc_transactions->render() !!}
    </div>

@else
    <div class="alert alert-info">
        No data found
    </div>
@endif

