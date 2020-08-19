@if(count($kpi_list) > 0)
{{--    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $kpi_list->total(), "from"=>  ($kpi_list->currentpage()-1)*$kpi_list->perpage()+1, "to"=>(($kpi_list->currentpage()-1)*$kpi_list->perpage())+$kpi_list->count()])}}</span>--}}

    <table class="table table-bordered table-hover">

        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="20%">{{__('_ecom__text.sale-per-day')}}</th>
            <th width="20%">{{__('_ecom__text.total-transaction-per-day')}}</th>
            <th width="20%">{{__('_ecom__text.order-per-entrepreneur-per-day')}}</th>
            <th width="20%">{{__('_ecom__text.average-fulfillment-time')}}</th>
            <th width="5%">{{__('_ecom__text.actions')}}</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $status_arr = array('1' => 'Active', '1' => 'Inactive');
        $page = 1;
        ?>
        @foreach(@$kpi_list as $key => $kpi)
            <tr>
                <td>{{$page}}</td>
                <td>{{@$kpi->sale_per_day}}</td>
                <td>{{@$kpi->total_transaction_per_day}}</td>
                <td>{{@$kpi->order_per_entrepreneur_per_day}}</td>
                <td>{{@$kpi->average_fulfillment_time}}</td>

                <td width="10%" class="text-left">

                    <a href="{{url("admin/setting/kpi/edit/$kpi->id")}}" data-id="{{$kpi->id}}"
                       class="btn green btn-xs edit">
                        <i class="fa fa-edit"></i>{{__('_ecom__text.edit')}}
                    </a>

                </td>

            </tr>

            <?php $page++; ?>

        @endforeach
        </tbody>
    </table>

    <div class="text-right">
        {{--{!! @$kpi_list->render() !!}--}}
    </div>

@else
    <div class="alert alert-info">
        No data found
    </div>
@endif