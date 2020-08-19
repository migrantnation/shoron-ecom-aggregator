@if(count($udc_payments) > 0)

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>
                UDC Name
            </th>
            <th>
                Phone Number
            </th>
            <th>
                Email
            </th>
            <th>
                Total Earn
            </th>
            <th>
                Ek-Shop Commission
            </th>
            <th>
                Action
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                lp_partner2
            </td>
            <td>
                +8801711384758
            </td>
            <td>
                udc@udc.com
            </td>
            <td style="text-align: right">
                10,050.00
            </td>
            <td style="text-align: right">
                2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/lp/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        <tr>
            <td>
                lp_partner1 Ltd.
            </td>
            <td>
                +8801759148687
            </td>
            <td>
                lp@lp.com
            </td>
            <td style="text-align: right">
                10,050.00
            </td>
            <td style="text-align: right">
                2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/lp/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        </tbody>
    </table>



    {{--<div class="text-right">--}}
    {{--{!! @$udc_payments->render() !!}--}}
    {{--</div>--}}

@else
    <div class="alert alert-info">
        No data found
    </div>
@endif

