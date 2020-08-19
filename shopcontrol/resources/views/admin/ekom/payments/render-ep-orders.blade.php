<div class="tab-pane active" id="tab_0">
    <div class="col-md-12">
        <div class="portlet box purple">

            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users"></i> {{__('admin_text.orders')}}
                </div>
            </div>
            <?php $enTobn = new \App\Libraries\PlxUtilities(); ?>
            <div class="portlet-body">

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

                @if(session()->has('message'))
                    <div class="alert alert-success text-center">
                        {{ session()->get('message') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-7">
                        <table style="margin-top: 20px; line-height: 2;">
                            <tr>
                                <td width="150">{{__('admin_text.total-order-value')}}</td>
                                <td width="20">:</td>
                                <td>{{__('admin_text.tk.')}} {{@$total_order_value->total_order_value ? App::isLocale('bn') ? $enTobn->en2bnNumber(@$total_order_value->total_order_value): @$total_order_value->total_order_value : 0}}</td>
                            </tr>
                            <tr>
                                <td width="150">{{__('admin_text.total-due')}}</td>
                                <td width="20">:</td>
                                <td>{{__('admin_text.tk.')}} {{@$total_due->total_due ? App::isLocale('bn') ? $enTobn->en2bnNumber(@$total_due->total_due): @$total_due->total_due : 0}}</td>
                            </tr>
                            <tr>
                                <td width="150">{{__('admin_text.cashout-amount')}}</td>
                                <td width="20">:</td>
                                <td>{{__('admin_text.tk.')}} <span id="cashout_amount">0</span></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-5">
                        <h5>{{__('admin_text.ep-information')}}:</h5>
                        {{__('admin_text.ep-name')}}: &nbsp;&nbsp;{{@$ep_info->ep_name}}<br>
                        {{__('admin_text.contact-number')}}
                        :&nbsp;&nbsp;{{App::isLocale('bn') ? $enTobn->en2bnNumber(@$ep_info->contact_number): @$ep_info->contact_number}}
                        <br>
                        {{__('admin_text.present-address')}}:&nbsp;&nbsp;{{@$ep_info->address}}
                    </div>

                </div>
                <br><br>
                <div class="row">
                    {{--<div class="col-md-6">--}}
                        {{----}}
                    {{--</div>--}}
                    <div class="col-md-12">
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
                    </div>

                </div>


                <form action="{{url('admin/payments/pay-to-ep')}}" method="post" name=""
                      onsubmit="return confirm('{{App::isLocale('bn') ? 'আপনি কি নিশ্চিতভাবে নির্বাচিত অর্ডারের অর্থ প্রদান করতে চান?': 'Are you sure want to disburse payment of selected order(s)?'}}')">
                    {{csrf_field()}}
                    @if($all_orders->count() > 0 )
                        <button disabled="" id="pay-to-button" type="submit"
                                class="btn btn-sm btn-success">{{__('admin_text.disburse-payment')}}</button>
                    @endif
                    <br><br><br>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="20"><input type="checkbox" name="all" @if(old('all')) checked
                                                  @endif class="orders-to-pay all" value="all" data-price="0"></th>
                            <th>{{__('admin_text.order-id')}}</th>
                            <th>{{__('admin_text.order-date')}}</th>
                            <th>{{__('admin_text.order-complete-date')}}</th>
                            <th>{{__('admin_text.udc-agent-name')}}</th>
                            <th class="text-right">{{__('admin_text.grand-total')}}</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse($all_orders as $key => $order)

                            <?php $total_price = (($order->total_price + $order->ep_commission) - ($order->ekom_commission + $order->udc_commission)); ?>

                            <tr>
                                <td width="20"><input type="checkbox"
                                                      @if(old('order_ids') && in_array($order->id, old('order_ids'))) checked
                                                      @endif class="orders-to-pay" name="order_ids[]"
                                                      value="{{$order->id}}" data-price="{{$total_price}}"></td>
                                <td>
                                    <a href="#">{{App::isLocale('bn') ? $enTobn->en2bnNumber($order->order_code): $order->order_code}}</a>
                                </td>
                                <td>{{App::isLocale('bn') ? $enTobn->en2bnNumber((date('Y-m-d',strtotime(@$order->created_at)))) : date('Y-m-d',strtotime(@$order->created_at))}}</td>
                                <td>{{App::isLocale('bn') ? $enTobn->en2bnNumber((date('Y-m-d',strtotime(@$order->updated_at)))) : date('Y-m-d',strtotime(@$order->updated_at))}}</td>
                                <td>{{$order->receiver_name}}</td>
                                <td class="text-right">{{__('admin_text.tk.')}} {{App::isLocale('bn') ? $enTobn->en2bnNumber(number_format((float)$total_price, 2, '.', '')): number_format((float)$total_price, 2, '.', '')}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" align="center">{{__('admin_text.no-result')}}</td>
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
    var total_price = 0;
    var display_price = 0;
    $(document).ready(function () {
        $('.orders-to-pay').each(function () {
            if ($(this).is(':checked')) {
                total_price = parseFloat(total_price) + parseFloat($(this).data("price")) <= 0 ? 0 : (parseFloat(total_price) + parseFloat($(this).data("price"))).toFixed(2);
            }
        });
        $('#cashout_amount').html(total_price);
    });

    $('input.orders-to-pay').on('change', function () {
        if ($(this).val() == 'all') {
            if ($(this).is(':checked')) {
                //CASH AMOUNT CALCULATION
                total_price = 0;
                $('.orders-to-pay').each(function () {
                    total_price = parseFloat(total_price) + parseFloat($(this).data("price")) <= 0 ? 0 : (parseFloat(total_price) + parseFloat($(this).data("price"))).toFixed(2);
                });
                $('input.orders-to-pay').not(this).prop('checked', true);
                $('#pay-to-button').attr('disabled', false);//Enable Pay Button
            } else {
                total_price = 0;
                $('input.orders-to-pay').not(this).prop('checked', false);
                $('#pay-to-button').attr('disabled', true);//Disable Pay Button
            }
        } else {

            $('input.all').not(this).prop('checked', false);

            //CASH AMOUNT CALCULATION
            if ($(this).is(':checked')) {
                total_price = parseFloat(total_price) + parseFloat($(this).data("price")) <= 0 ? 0 : (parseFloat(total_price) + parseFloat($(this).data("price"))).toFixed(2);
            } else {
                total_price = parseFloat(total_price) - parseFloat($(this).data("price")) <= 0 ? 0 : (parseFloat(total_price) - parseFloat($(this).data("price"))).toFixed(2);
            }

            if (parseInt($('.orders-to-pay:checked').length) > 0) {
                $('#pay-to-button').attr('disabled', false);//Enable Pay Button
            } else {
                $('#pay-to-button').attr('disabled', true);//Disable Pay Button
            }
            if (parseInt($('.orders-to-pay:checked').length) + parseInt(1) == $('.orders-to-pay').length) {
                $('input.orders-to-pay').not(this).prop('checked', true);
            }
        }

        var lang = '{{App::isLocale('bn') ? 'bangla' : 'english'}}';
        display_price = lang && lang == 'bangla' ? total_price == 0 ? 0 : total_price.getDigitBanglaFromEnglish() : total_price;
        $('#cashout_amount').html(display_price);
    });


    //ENGLISH TO BANGLA CONVERSION
    var english_number;
    var finalEnlishToBanglaNumber = {
        '0': '০',
        '1': '১',
        '2': '২',
        '3': '৩',
        '4': '৪',
        '5': '৫',
        '6': '৬',
        '7': '৭',
        '8': '৮',
        '9': '৯'
    };
    String.prototype.getDigitBanglaFromEnglish = function () {
        var retStr = this;
        for (var x in finalEnlishToBanglaNumber) {
            retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
        }
        return retStr;
    };

</script>

{{--<input type="checkbox" class="example" />--}}

{{--<input type="checkbox" class="example" />--}}
{{--<input type="checkbox" class="example" />--}}
{{--<input type="checkbox" class="example" />--}}

{{--<script>--}}
    {{--$('input.example').on('change', function() {--}}
        {{--$('input.example').not(this).prop('checked', false);--}}
    {{--});--}}
{{--//    $('input#ff').on('change', function() {--}}
{{--//        $('input.example').not(this).prop('checked', false);--}}
{{--//    });--}}
{{--</script>--}}


{{--<label for="chooseFruit">Choose Your Favourite Fruit</label>--}}
{{--<br />--}}
{{--<input type="radio" name="chooseFruit" value="mango"> Mango </input>--}}
{{--<input type="radio" name="chooseFruit" value="kiwi"> Kiwi </input>--}}
{{--<input type="radio" name="chooseFruit" value="banana"> Banana </input>--}}
{{--<input type="radio" name="chooseFruit" value="orange"> Orange </input>--}}

{{--<br />--}}
{{--<h2> <a href="http://smoothprogramming.com/jquery/toggle-radio-button-using-jquery/" target="_blank">Written by SmoothProgramming.com </a>--}}
{{--</h2>--}}


{{--<script>--}}
    {{--$(document).ready(function() {--}}
        {{--$("input[type=radio]").click(function() {--}}
            {{--// Get the storedValue--}}
            {{--var previousValue = $(this).data('storedValue');--}}
            {{--// if previousValue = true then--}}
            {{--//     Step 1: toggle radio button check mark.--}}
            {{--//     Step 2: save data-StoredValue as false to indicate radio button is unchecked.--}}
            {{--if (previousValue) {--}}
                {{--$(this).prop('checked', !previousValue);--}}
                {{--$(this).data('storedValue', !previousValue);--}}
            {{--}--}}
            {{--// If previousValue is other than true--}}
            {{--//    Step 1: save data-StoredValue as true to for currently checked radio button.--}}
            {{--//    Step 2: save data-StoredValue as false for all non-checked radio buttons.--}}
            {{--else{--}}
                {{--$(this).data('storedValue', true);--}}
                {{--$("input[type=radio]:not(:checked)").data("storedValue", false);--}}
            {{--}--}}
        {{--});--}}
    {{--});--}}
{{--</script>--}}