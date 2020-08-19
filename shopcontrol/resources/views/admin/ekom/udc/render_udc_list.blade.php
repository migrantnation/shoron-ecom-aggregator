@if(count($udc_list) > 0)

    @if(@$limit != 'all')
        <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $udc_list->total(), "from"=>  ($udc_list->currentpage()-1)*$udc_list->perpage()+1, "to"=>(($udc_list->currentpage()-1)*$udc_list->perpage())+$udc_list->count()])}}</span>
    @else
        <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $udc_list->count(), "from"=>  1, "to"=>$udc_list->count()])}}</span>
    @endif

    <table class="table table-bordered table-hover">

        <thead>
        <tr>
            <th width="20">#</th>
            <th>UDC</th>
            <th>Entrepreneur Name</th>
            <th>Contact Information</th>
            <th width="250">Order Infomation</th>
            <th>Status</th>
            <th width="220">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $status_arr = array(
            '0' => 'New User',
            '1' => 'Active',
            '2' => 'Inactive',
            '3' => 'Deleted',
        );
        ?>
        @foreach(@$udc_list as $key => $each_udc)
            <tr>
                <td>{{$page}}</td>
                <td>{{@$each_udc->center_name}} <br> <strong>Center ID: {{@$each_udc->center_id}}</strong></td>
                <td>{{@$each_udc->name_bn?$each_udc->name_bn:$each_udc->name_en}}</td>
                <td>
                    {{@$each_udc->contact_number?$each_udc->contact_number:$each_udc->phone}}<br>
                    {{@$each_udc->email}}<br>
                    <?php
                    $address = array();
                    if ($each_udc->union)
                        $address[] = $each_udc->union;

                    if ($each_udc->upazila)
                        $address[] = $each_udc->upazila;

                    if ($each_udc->district)
                        $address[] = $each_udc->district;

                    if ($each_udc->division)
                        $address[] = $each_udc->division;
                    ?>

                    {{implode(', ',$address)}}<br>
                    {{@$each_udc->address}}
                </td>
                <td>
                    @php

                        $url_segment = "/orders?search_string=".@$_GET['search_string']."&from=".@$_GET['from']."&to=".@$_GET['to']."&limit=10";

                    @endphp
                    <a href="{{url("admin/udc/".@$each_udc->id.$url_segment."&tab_id=1")}}">Active Orders: &nbsp;&nbsp;&nbsp;{{@$each_udc->orders->where('status', 1)->count()}}</a><br>
                    <a href="{{url("admin/udc/".@$each_udc->id.$url_segment."&tab_id=2")}}">Warehouse Left Orders:&nbsp;&nbsp;&nbsp;{{@$each_udc->orders->where('status', 2)->count()}}</a><br>
                    <a href="{{url("admin/udc/".@$each_udc->id.$url_segment."&tab_id=3")}}">On Delivery Orders:&nbsp;&nbsp;&nbsp;{{@$each_udc->orders->where('status', 3)->count()}}</a><br>
                    <a href="{{url("admin/udc/".@$each_udc->id.$url_segment."&tab_id=4")}}">Delivered Orders:&nbsp;&nbsp;&nbsp;{{@$each_udc->orders->where('status', 4)->count()}}</a><br>
                    <a href="{{url("admin/udc/".@$each_udc->id.$url_segment."&tab_id=5")}}">Canceled Orders:&nbsp;&nbsp;&nbsp;{{@$each_udc->orders->where('status', 5)->count()}}</a><br>

                </td>
                <td>
                    {{$status_arr[@$each_udc->status]}} <br>
                    <strong style="color:#9C27B0;">{{@$each_udc->udc_package ? "" : "Package not assigned"}}</strong>
                </td>

                <td width="10%" class="text-left">


                    <a href="#" class="btn yellow btn-xs userDeliveryPackage"
                       data-target="#deliveryPackageLp" data-center="{{$each_udc->center_id}}" data-center-name="{{$each_udc->center_name}}" data-user-id="{{$each_udc->id}}" data-entrepreneur-id="{{$each_udc->entrepreneur_id}}">
                        <i class="fa fa-package"></i> Delivery Package
                    </a>
                    <span class="badge badge-success yellow" style="background-color:#c49f47">{{@count($each_udc->udc_package)}}</span>
                    <br>

                    <br>
                    @if($each_udc->status == 0)
                        @if(@$each_udc->udc_package)
                            <a href="javascript:void(0)" class="btn green btn-xs change-status"
                               data-userid="{{@$each_udc->id}}" data-status="1">
                                <i class="fa fa-check"></i> Activate
                            </a>
                        @else
                            <a href="javascript:void(0)" class="btn green btn-xs change-status-package1 userDeliveryPackage"
                               data-userid="{{$each_udc->id}}" data-status="1" 
							   data-center="{{$each_udc->center_id}}" data-user-id="{{$each_udc->id}}"  data-entrepreneur-id="{{$each_udc->entrepreneur_id}}" data-center-name="{{$each_udc->center_name}}"
                               data-target="#deliveryPackageLp" data-centerId="{{$each_udc->center_id}}">
                                <i class="fa fa-check"></i> Activate
                            </a>
                        @endif
                    @elseif($each_udc->status == 1)
                        <a href="javascript:void(0)" class="btn btn-warning btn-xs change-status "
                           data-userid="{{$each_udc->id}}" data-status="0">
                            <i class="fa fa-check-o"></i> Deactivate
                        </a>
                    @elseif($each_udc->status == 2)
                        <a href="javascript:void(0)" class="btn green btn-xs change-status"
                           data-userid="{{@$each_udc->id}}" data-status="1" data-entrepreneur-id="{{$each_udc->entrepreneur_id}}">
                            <i class="fa fa-check"></i> Activate
                        </a>
                    @elseif($each_udc->status == 3)
                        <a href="javascript:void(0)" class="btn red btn-xs"
                           data-userid="{{$each_udc->id}}" data-status="{{$each_udc->status}}">
                            <i class="fa fa-check-o"></i> Deleted
                        </a>
                    @endif
                    <br>
                    <br>
                    <a href="{{url("admin/udc/$each_udc->id".$url_segment)}}"
                       class="btn purple btn-xs">
                        <i class="icon-diamond"></i> Orders
                    </a>
                    <span class="badge badge-success" style="background-color:#8E44AD">{{@$each_udc->orders->count()}}</span>
                    <br>

                    <br><a href="{{url("admin/mobile-bank-information/$each_udc->id")}}"
                           class="btn blue btn-xs">
                        <i class="fa fa-mobile fa-lg"></i> Mobile Bank Information
                    </a><br>

                </td>
            </tr>
            <?php $page++; ?>
        @endforeach
        </tbody>
    </table>


    <div class="row">
        <div class="col-sm-2 text-left">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <select name="limit" id="limit" class="all-filtered">
                <option value="15" {{($limit == 15)?'selected':''}}>15</option>
                <option value="all" {{($limit == "all")?'selected':''}}>All</option>
            </select>
        </div>

        <div class="col-sm-10 text-right">
            @if(@$limit != 'all')
                {!! @$udc_list->render() !!}
            @endif
        </div>

    </div>


    <div class="modal fade" id="deliveryPackageLp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                </div>

                <div class="modal-body">
                    <form action="javascript:;" class="margin-bottom-20">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-inline">

                                    <div class="form-group">
                                        <label for="">Logistic Partner:</label>
                                        <div class="input-group">

                                            <select class="form-control" name="lp_id" id="lp_id">

                                                <option value="">--Select a Logistic Partner--</option>
                                                @forelse(@$all_lp as $key=>$lp)
                                                    <option value="{{$lp->id}}">{{$lp->lp_name}}</option>
                                                @empty
                                                    <option>No Logistic Partner Found</option>
                                                @endforelse

                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <a id="lp-package" class="plx__btn_lg primary">
                                            <i class="icon-diamond"></i>Submit
                                        </a>
                                    </div>
                                    <script>

                                        var centerId = '';
                                        $(".userDeliveryPackage").click(function (e) {
                                            e.preventDefault();
                                            centerId = $(this).data('center');
                                            centerName = $(this).data('center-name');
                                            userId = $(this).data('user-id');
                                            entrepreneurId = $(this).data('entrepreneur-id');
                                            target = $(this).data('target');
                                            $(target).modal('show');


                                        });

                                        $("#lp-package").click(function () {
                                            window.location.href = "{{url("admin/lp/packages")}}/" + ($("#lp_id").val()) + "?search_string=" + entrepreneurId;
                                        });


                                        /*$(".userDeliveryPackage").click(function () {
                                            centerId = $(this).data('center');
                                            console.log(centerId);
                                            $.ajax({
                                                accepts: {
                                                    mycustomtype: 'application/x-www-form-urlencoded; charset=UTF-8'
                                                },
                                                type: "POST",
                                                data: "",
                                                url: "WebForm1.aspx",
                                                dataType: "html",
                                                contentType: "application/x-www-form-urlencoded; charset=UTF-8; multipart/form-data",
                                                cache: false,
                                                timeout: 5000,
                                                beforeSend: OnBeforeSend,
                                                complete: onComplete,
                                                success: onSuccess,
                                                error: onError
                                            });
                                        });*/

                                        var OnBeforeSend = function () {
                                            console.log('OnbeforeSend');
                                        }

                                        var onComplete = function (data) {
                                            console.log('oncomplete');
                                        }

                                        var onSuccess = function (data, textStatus) {
                                            console.log('onsuccess');
                                        }

                                        var onError = function (XMLHttpRequest, Status, errorThrown) {
                                            console.log('XMLHttpRequest: ' + XMLHttpRequest);
                                            console.log('Status: ' + Status);
                                            console.log('errorThrown: ' + errorThrown);

                                            if (Status == 'timeout') {
                                                console.log('time out');
                                            } else if (Status == 'error') {
                                                console.log('error');
                                            }

                                        }


                                    </script>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@else
    <div class="alert alert-info">
        No data found
    </div>
@endif