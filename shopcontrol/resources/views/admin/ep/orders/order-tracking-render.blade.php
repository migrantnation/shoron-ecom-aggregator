@if($order_info)

    @if(@$order_info->status == 5)
        <div class="alert alert-danger fade in alert-dismissible text-center">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

            @forelse(@$tracking_details as $each_tracking)
                @if($each_tracking->status == 5)
                    <strong>Order canceled!</strong>
                    &nbsp; {{@$each_tracking->message_by?' by ' .@$each_tracking->message_by:""}}
                    <br>
                    <strong>Reason:</strong> {{$each_tracking->message}}
                    <br>
                    <span class="tracking-date">{{date('M d, Y h:i a', strtotime(@$each_tracking->created_at))}}</span>
                @endif
            @empty
                No track. <br>Order Updated:
                {{date('M d, Y h:i a', strtotime($order_info->updated_at))}}
            @endforelse
        </div>
    @endif

    <div class="tracking-details">
        <div class="row">
            <div class="col-sm-5 col-md-6">
                <strong class="profile-desc-text">Order Information</strong>

                <table class="plx__table margin-top-10">
                    <tr>
                        <td width="200">{{__('admin_text.order-id')}}</td>
                        <td width="20">:</td>
                        <td width="200">{{@$order_info->order_code}}</td>
                    </tr>
                    <tr>
                        <td width="200">{{__('admin_text.order-date')}}</td>
                        <td width="20">:</td>
                        <td width="200">{{date('d/m/Y', strtotime(@$order_info->created_at))}}</td>
                    </tr>
                    <tr>
                        <td width="200">{{__('admin_text.ep-name')}}</td>
                        <td width="20">:</td>
                        <td width="200">{{@$order_info->ep_name}}</td>
                    </tr>
                    <tr>
                        <td width="200">{{__('admin_text.lp-name')}}</td>
                        <td width="20">:</td>
                        <td width="200">{{@$order_info->lp_name}}</td>
                    </tr>
                    <tr>
                        <td width="200">{{__('admin_text.delivery-duration')}}</td>
                        <td width="20">:</td>
                        <td width="200">{{@$order_info->delivery_duration}}</td>
                    </tr>
                </table>
            </div>
            @if(@\Illuminate\Support\Facades\Auth::user()->id == $order_info->user_id)
                <div class="col-sm-6 col-md-6">
                    <strong class="profile-desc-text">Customer Information</strong>
                    <table class="plx__table margin-top-10">
                        <tr>
                            <td width="200">{{__('admin_text.name')}}</td>
                            <td width="20">:</td>
                            <td width="200">{{@$order_info->UdcCustomer->customer_name}}</td>
                        </tr>
                        <tr>
                            <td width="200">{{__('admin_text.contact-number')}}</td>
                            <td width="20">:</td>
                            <td width="200">{{@$order_info->UdcCustomer->customer_contact_number}}</td>
                        </tr>
                        <tr>
                            <td width="200">{{__('admin_text.address')}}</td>
                            <td width="20">:</td>
                            <td width="200">{{@$order_info->UdcCustomer->customer_address}}</td>
                        </tr>
                    </table>
                </div>
            @else
                <div class="col-sm-6 col-md-6">
                    <strong class="profile-desc-text">{{__('admin_text.entrepreneur-information')}}</strong>
                    <table class="plx__table margin-top-10">
                        <tr>
                            <td width="150">{{__('admin_text.center-name')}}</td>
                            <td width="20">:</td>
                            <td width="250">{{@$order_info->user->center_name}}</td>
                        </tr>
                        <tr>
                            <td width="150">{{__('admin_text.entrepreneur-name')}}</td>
                            <td width="20">:</td>
                            <td width="250">{{App::isLocale('bn') ? @$order_info->user->name_bn : $order_info->user->name_en}}</td>
                        </tr>
                        <tr>
                            <td width="150">{{__('admin_text.contact-number')}}</td>
                            <td width="20">:</td>
                            <td width="250">{{@$order_info->user->contact_number}}</td>
                        </tr>
                        <tr>
                            <td width="150">{{__('admin_text.e-mail')}}</td>
                            <td width="20">:</td>
                            <td width="250">{{@$order_info->user->email}}</td>
                        </tr>
                        <tr>
                            <td width="150">{{__('admin_text.present-address')}}</td>
                            <td width="20">:</td>
                            <td width="250">{{@$order_info->user->present_address}}</td>
                        </tr>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <hr>


    <strong class="profile-desc-text">Order Status</strong>
    <div class="row margin-top-20">
        <div class="col-sm-3">
            <div class="tracking-status-box {{(@$order_info->status > 1) ? 'completed':'active'}}" data-number="1">
                <h4 class="title">Order Placed</h4>
                <i class="icon fa fa-shopping-cart"></i>

                <div class="date">{{date("F d, Y", strtotime(@$order_info->created_at))}}</div>
                <div class="text"></div>
            </div>
        </div>

        @if($order_info->status != 5)

            <div class="col-sm-3">
                <div class="tracking-status-box {{@$order_info->status == 2 ? 'active':(@$order_info->status > 2 ? 'completed':'')}}"
                     data-number="2">
                    <h4 class="title">Warehouse Left</h4>
                    <i class="icon fa fa-home"></i>
                    @if(@$order_info->status < 2)
                        <div class="date">{{'Pending'}}</div>
                    @else
                        <div class="date">{{date("F d, Y", strtotime(@$status_tracking_info[2][0]->created_at))}}</div>
                        <div class="text">
                            {{@$status_tracking_info[2][0]->message}}
                            {{@$status_tracking_info[2][0]->message_by?' by ' .@$status_tracking_info[2][0]->message_by:''}}
                        </div>
                    @endif

                </div>
            </div>

            <div class="col-sm-3">
                <div class="tracking-status-box {{@$order_info->status == 3 ? 'active':(@$order_info->status > 3 ? 'completed':'')}}"
                     data-number="3">
                    <h4 class="title">In Transit</h4>
                    <i class="icon fa fa-truck"></i>
                    @if(@$order_info->status < 3)
                        <div class="date">{{'Pending'}}</div>
                    @else
                        <div class="date">{{date("F d, Y", strtotime(@$status_tracking_info[3][0]->created_at))}}</div>
                        <div class="text">
                            {{@$status_tracking_info[3][0]->message}}
                            {{@$status_tracking_info[3][0]->message_by?' by ' .@$status_tracking_info[3][0]->message_by:''}}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-sm-3">
                <div class="tracking-status-box {{(@$order_info->status == 4) ? 'active':''}}" data-number="4">
                    <h4 class="title">Delivered</h4>
                    <i class="icon fa fa-check-circle"></i>
                    @if(@$order_info->status < 4)
                        <div class="date">{{'Pending'}}</div>
                    @else
                        <div class="date">{{date("F d, Y", strtotime(@$status_tracking_info[4][0]->created_at))}}</div>
                        <div class="text">
                            {{@$status_tracking_info[4][0]->message}}
                            {{@$status_tracking_info[4][0]->message_by?' by ' .@$status_tracking_info[4][0]->message_by:''}}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="col-sm-3">
                <div class="tracking-status-box {{(@$order_info->status == 5) ? 'cancel':''}}" data-number="5">
                    <h4 class="title">Canceled</h4>
                    <i class="icon fa fa-check-circle"></i>
                    <div class="date">{{date("F d, Y", strtotime(@$order_info->created_at))}}</div>
                    <div class="text">{{@$tracking_details[5][0]->message_by?' by ' .@$tracking_details[5][0]->message_by:''}}</div>
                </div>
            </div>
        @endif

    </div>

    <script>
        (function ($) {
            'use strict';
            var heights = [], i;
            $('.tracking-status-box').each(function () {
                heights.push($(this).height());
            });
            var maxHeight = heights.reduce(function (a, b) {
                return Math.max(a, b);
            });
            $('.tracking-status-box').height(maxHeight);
        }(jQuery))
    </script>


    <strong class="profile-desc-text">Tracking Message</strong>
    <div class="tracking-status-wrap margin-top-20">
        <span class="vr-line"></span>
        <div class="status-list">

            <?php
            $step_array = array('1' => 'Preparing Parcel', '2' => 'Warehouse Left', '3' => 'In Transit', '4' => 'Delivered');
            $class_array = array('1' => 'preparing-parcel', '2' => 'warehouse-left', '3' => 'in-transit', '4' => 'stage-delivered');
            ?>

            <div class="tracking-status">
                <div class="status-inner complete-stage">
                    <div class="status-text">
                        <h4 class="status-name">Order Placed</h4>
                        <p>{{date('M d, Y', strtotime(@$order_info->created_at))}}</p>
                    </div>
                </div>
            </div>

            @if(@$order_info->status == 5)
                <div class="tracking-status">
                    <div class="status-inner complete-stage">
                        <div class="status-text">
                            <h4 class="status-name">Canceled</h4>
                            <p class="plx__text">{{$status_tracking_info[5][0]->message}}</p>
                            <span class="tracking-date">{{date('M d, Y h:i a', strtotime(@$status_tracking_info[5][0]->created_at))}}</span>
                        </div>
                    </div>
                </div>
            @else
                @for($i = 2 ; $i <= 4 ; $i++)
                    <div class="tracking-status">
                        <div class="status-inner {{$maxstatus && $i <= $maxstatus ? 'complete-stage' :  $class_array[$i]}}">
                            <div class="status-text">
                                <h4 class="status-name">{{$step_array[$i]}}</h4>
                                {{--<p>{{date('M d, Y', strtotime(@$order_info->updated_at))}}</p>--}}
                                @forelse($tracking_details as $each_tracking)
                                    @if($each_tracking->status == $i)
                                        <p class="plx__text">{{$each_tracking->message}}</p>
                                        <span class="tracking-date">{{date('M d, Y h:i a', strtotime(@$each_tracking->created_at))}}</span>
                                    @endif
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endfor
            @endif


        </div>
    </div>

@else
    <p class="text-center">No Result Found.</p>
@endif

<script>
    document.getElementById("SubmitSearch").onsubmit = function () {
        ajaxpush();
        return false;
    };
</script>