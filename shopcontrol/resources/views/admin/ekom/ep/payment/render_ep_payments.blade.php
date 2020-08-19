@if(count($udc_payments) > 0)

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>
                EP Name
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
                ESHO
            </td>
            <td>
                +8801784606060
            </td>
            <td>
                esho@gmail.com
            </td>
            <td style="text-align: right">
                10,050.00
            </td>
            <td style="text-align: right">
                2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/ep/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        <tr>
            <td>
                ep_partner
            </td>
            <td>
                +8801844152086
            </td>
            <td>
                info@ep_partner.com
            </td>
            <td style="text-align: right">
                10,050.00
            </td>
            <td style="text-align: right">
                2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/ep/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        <tr>
            <td>
                ep_partner5
            </td>
            <td>
                09613242424
            </td>
            <td>
                info@ep_partner.com
            </td>
            <td style="text-align: right">
                10,050.00
            </td>
            <td style="text-align: right">
                2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/ep/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        <tr>
            <td>
                ep_partner2
            </td>
            <td>
                +8809606771155
            </td>
            <td>
                info@ep_partner2.com
            </td>
            <td style="text-align: right">
                10,050.00
            </td>
            <td style="text-align: right">
                2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/ep/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        <tr>
            <td>
                ep_partner3
            </td>
            <td>
                +8809612484848
            </td>
            <td>
                support@ep_partner3.com.bd
            </td>
            <td style="text-align: right">
                10,050.00
            </td>
            <td style="text-align: right">
                2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/ep/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        <tr>
            <td>
                OTHOBA
            </td>
            <td>
                +8809613800800
            </td>
            <td>
                support@othoba.com
            </td>
            <td style="text-align: right">
                10,050.00
            </td>
            <td style="text-align: right">
                2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/ep/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        </tbody>
    </table>



    {{--<div class="text-right">--}}
    {{--{!! @$ep_payments->render() !!}--}}
    {{--</div>--}}

@else
    <div class="alert alert-info">
        No data found
    </div>
@endif

