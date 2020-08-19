<style>
    /* Important part */
    .modal-dialog {
        overflow-y: initial !important
    }

    .modal-body {
        height: 450px;
        overflow-y: auto;
    }
</style>

<div class="modal fade" id="commissionDisburseModal" tabindex="-1" role="dialog"
     aria-labelledby="commissionDisburseModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commissionDisburseModal"><strong>Commission Disbursement</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="commission-disburse-form">
                <div class="modal-body">

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="35%">Order Code</th>
                            <th width="20%">Total Order Value</th>
                            <th width="20%">Total Commission</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $order_code = array();
                        ?>
                        @forelse($get_orders as $key => $order)
                            <?php $order_code[] = $order->order_code;?>
                        @empty
                        @endforelse
                        <tr>
                            <td width="25%">{{ implode(', ', $order_code)}}</td>
                            <td width="10%">{{__('_ecom__text.tk.')}}{{number_format(@$get_orders->sum('total_price'), 2)}}</td>
                            <td width="10%">{{__('_ecom__text.tk.')}}{{number_format(@$commission_for_selected_month, 2)}}</td>
                        </tr>
                        </tbody>
                    </table>


                    <input type="hidden" id="from-date-id"
                           value="{{@$from_date ? date('Y-m-d', strtotime(@$from_date)) : ""}}">
                    <div class="row form-group">
                        <div class="col-md-7">
                            <label for="message-text" class="col-form-label"><strong>Commission for the selected
                                    month:</strong></label>
                        </div>
                        <div class="col-md-5">
                            <strong>BDT {{@$commission_for_selected_month}}</strong>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-7">
                            <label for="message-text" class="col-form-label"><strong>Commission due for previous month(s):</strong></label>
                        </div>
                        <div class="col-md-5">
                            <strong>BDT {{@$commission_for_prev_month + @$prev_due->due_amount}}</strong>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-7">
                            <label for="message-text" class="col-form-label"><strong>Total disbursement amount:</strong></label>
                        </div>
                        <div class="col-md-1">
                            <label for="message-text" class="col-form-label"><strong>BDT</strong></label>
                        </div>
                        <div class="col-md-4">
                            @php $total_commission = @$commission_for_selected_month + @$commission_for_prev_month  + @$prev_due->due_amount ;@endphp
                            <input class="form-control" name="amount" id="commission_amount" value="{{@$total_commission}}" max="{{@$total_commission}}">
                            <span id="commission-amount-error" style="color:red; display: none;"><span><i>Disbursement amount can not be greater than total due amount or negative or empty</i></span></span>
                        </div>
                    </div>

                    <input type="hidden" name="total_due_amount" value="{{@$total_commission}}" id="total_due_amount">

                    @if($udc_info->bkash_number || $udc_info->rocket_number)
                        <div class="row form-group existing-method">
                            <div class="col-md-4">
                                <label for="message-text" class="col-form-label"><strong>Select
                                        Bkash/Rocket:</strong></label>
                            </div>
                            <div class="col-md-3">
                                <select id="transfer_method" class="form-control existing_transfer_method" name="transfer_method">
                                    @if($udc_info->bkash_number != '')
                                        <option value="1">Bkash</option>
                                    @endif
                                    @if($udc_info->rocket_number != '')
                                        <option value="2">Rocket</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-5">
                                @if($udc_info->bkash_number != '')
                                    <input id="transfer_method_bkash" type="number" name="mobile_banking_number" value="{{@$udc_info->bkash_number}}" class="form-control" readonly>
                                @endif
                                @if($udc_info->rocket_number != '')
                                    <input id="transfer_method_rocket" style="display: none;" type="number" name="mobile_banking_number" value="{{@$udc_info->rocket_number}}" class="form-control" readonly>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-7">
                                <label for="message-text" class="col-form-label"><strong>Want to use another Bkash/Rocket?</strong></label>
                            </div>
                            <div class="col-md-5">
                                <select id="transfer_method" class="form-control another_transfer_method" name="">
                                    <option value="1">No</option>
                                    <option value="2">Yes</option>
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="row form-group">
                            <div class="col-md-12 text-center"><strong><i style="color:red;"> This udc does not have any Bkash/Rocket number</i></strong></div>
                        </div>
                    @endif

                    <div class="row form-group additional-method-selection">
                        <div class="col-md-4">
                            <label for="message-text" class="col-form-label"><strong>Select Bkash/Rocket:</strong></label>
                        </div>
                        <div class="col-md-3">
                            <select id="transfer_method" class="form-control" name="transfer_method">
                                <option value="1">Bkash</option>
                                <option value="2">Rocket</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="number" name="mobile_banking_number" class="form-control">
                            <strong id="mobile-banking-number-error" style="color:red; display: none;"><span><i>Please insert account number</i></span></strong>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="message-text" class="col-form-label"><strong>Transaction Number: *</strong></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="transaction_number" id="transaction_number">
                            <strong id="transaction-error" style="color:red; display: none;"><span><i>Please insert the transaction number</i></span></strong>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="message-text" class="col-form-label"><strong>Note:</strong></label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="disbursementnote" name="disburse_note"></textarea>
                        </div>
                    </div>

                </div>
            </form>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submitDisburse" data-targettask="submitDisburse">Submit
                </button>
            </div>

        </div>
    </div>
</div>

<script>

    var bkash = '{{$udc_info->bkash_number}}';
    var rocket = '{{$udc_info->rocket_number}}';

    if (bkash != '' || rocket != '') {
        $('.additional-method-selection').hide();
        $(".additional-method-selection :input").attr("disabled", true);
    }

</script>