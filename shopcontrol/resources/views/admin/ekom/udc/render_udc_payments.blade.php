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
                কোলাসিংগ ইউনিয়ন ডিজিটাল সেন্টার ০2
            </td>
            <td>
                +880171138477
            </td>
            <td>
                udc@udc.com
            </td>
            <td style="text-align: right">
                {{__('_ecom__text.tk.')}} 10,050.00
            </td>
            <td style="text-align: right">
                {{__('_ecom__text.tk.')}} 2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/udc/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        <tr>
            <td>
                শ্রীকাইল ইউনিয়ন ডিজিটাল সেন্টার ০১
            </td>
            <td>
                +8801711384758
            </td>
            <td>
                udc@udc.com
            </td>
            <td style="text-align: right">
                {{__('_ecom__text.tk.')}} 10,050.00
            </td>
            <td style="text-align: right">
                {{__('_ecom__text.tk.')}} 2,252.00
            </td>
            <td width="1%">
                <a href="{{url('admin/udc/payments/details')}}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
        <tr>
            <td>
                শ্রীকাইল ইউনিয়ন ডিজিটাল সেন্টার ০১
            </td>
            <td>
                +8801759148687
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
                <a href="{{url('admin/udc/payments/details')}}" class="btn btn-info btn-sm">View</a>
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

