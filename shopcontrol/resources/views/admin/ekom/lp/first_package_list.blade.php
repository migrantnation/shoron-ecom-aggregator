@forelse($searched_user as $key=>$user)

    @php
        if(@$lp->packages){
            $lp_package = @$lp->packages->where('location_id',$user->id)->first();
        }
    @endphp

    <div id="package_info{{$user->id}}">
        <div class="col-md-12">
            <hr>
        </div>

        <div class="col-md-12">
            <div class="row">

                <div class="col-md-4">

                    <strong>{{$user->center_id}}</strong>
                    &nbsp; {{(@$lp_package->is_selected==1)?'Activated':'Deactivated'}}
                    <br>
                    <strong>{{$user->center_name}}</strong> <br>

                    <?php
                    $address = array();
                    $address[] = trim($user->division);
                    $address[] = trim($user->district);
                    $address[] = trim($user->upazila);
                    ?>
                    {{implode(', ', $address)}}
                </div>

                <div class="col-md-2" style="padding: 2px">
                    <input type="number" class="form-control" id="price{{$user->id}}"
                           name="price[{{$key}}]" placeholder="Charge"
                           value="{{@$lp_package?@$lp_package->price:''}}">
                </div>

                <div class="col-md-2" style="padding: 2px">
                    <input type="text" class="form-control" id="delivery_duration{{$user->id}}"
                           name="delivery_duration[{{$key}}]"
                           value="{{@$lp_package?$lp_package->delivery_duration:''}}"
                           placeholder="Time Duration">
                </div>

                @if(@$lp->id == 4)
                    <div class="col-md-1" style="padding: 2px">

                        <input type="text" class="form-control" id="package_code{{$user->id}}"
                               name="package_code[{{$key}}]"
                               value="{{@$lp_package?@$lp_package->package_code:''}}">

                    </div>
                @endif

                <div class="col-md-3">

                    <a class="save-package btn btn-primary" data-location-id="{{$user->id}}">
                        Save
                    </a>
                    @if(@$lp_package)
                        <a class="change-status btn btn-default"
                           data-location-id="{{$user->id}}"
                           data-status="{{(@$lp_package->is_selected == 1)?"0":"1"}}"
                           data-package-id="{{@$lp_package->id}}">

                            {{(@$lp_package->is_selected == 1)?"Deactivate":"Activate"}}

                        </a>
                    @endif
                    <br>

                </div>
            </div>
            <div id="loader{{$user->center_id}}" class="loader-overlay">
                <div class="loader">Loading...</div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="row">
                @if(@$lp_package->updated_by)
                    <div class="col-sm-12 text-left">
                        <span> Updated Time :&nbsp;</span>
                        <span style="color: rgba(255,0,0,0.73)"> <strong> {{date("Y-m-d h:i:s A", strtotime(@$lp_package->updated_at))}} </strong></span>
                    </div>
                    <div class="col-sm-12 text-left">
                        <span> Updated By :&nbsp;</span>
                        <span style="color: rgba(255,0,0,0.73)"> <strong> {{@$lp_package->updated_by}} </strong> </span>
                    </div>
                @endif
                <div class="col-sm-12 text-left">
                    <span> Total Distributed Package :&nbsp;</span>
                    <span style="color: rgba(13,11,212,0.73)">
                            <strong> {{@$user->udc_package_list->where('is_selected',1)->count()}} </strong>
                        </span>

                    <span style="color: rgba(0,195,0,0.73)">
                            <?php $lp_name = array();?>
                        @forelse(@$user->udc_package_list->where('is_selected',1) as $package)
                            <?php
                            $lp_name[] = $package->logistic_partner->lp_name;
                            ?>
                        @empty
                        @endforelse

                        {{(!empty($lp_name))?'('.implode(', ',$lp_name).')':''}}

                        </span>
                </div>
            </div>
        </div>
    </div>
@empty
    <p>No Package</p>
@endforelse

<script>

    $(".save-package").click(function (e) {

        var lp_id = "{{$lp->id}}";
        var location_id = $(this).data('location-id');
        var price = $("#price" + location_id).val();
        var delivery_duration = $("#delivery_duration" + location_id).val();
        var package_code = $("#package_code" + location_id).val();

        if (price == '') {
            $.alert("Price is required");
            return;
        } else if (delivery_duration == '') {
            $.alert("Delivery Duration is required");
            return;
        }

        var data = {
            lp_id: lp_id,
            location_id: location_id,
            price: price,
            delivery_duration: delivery_duration,
            package_code: package_code,
            _token: "{{csrf_token()}}",
        }

        $('#loader' + location_id).show();
        $.ajax({
            url: "{{url("admin/lp/save-package")}}",
            type: "post",
            dataType: 'json',
            data: data,
            success: function (response) {
                $('#loader' + location_id).fadeOut();
                if (response['meta']['status'] == 200) {

                    $("#package_info" + location_id).html(response['response']['view']);
                    successToast("" + response['response']['message']);

                } else if (response['meta']['status'] == 100) {

                    worningToast("" + response['response']['message']);

                } else {

                    worningToast("" + response['response']['message']);
                    window.location.href = '{{url('ep')}}';

                }

            }
        });
    });

    $(".change-status").click(function (e) {

        var lp_id = "{{$lp->id}}";
        var location_id = $(this).data('location-id');
        var status = $(this).data('status');

        var data = {
            lp_id: lp_id,
            location_id: location_id,
            status: status,
            _token: "{{csrf_token()}}",
        }

        $('#loader' + location_id).show();
        $.ajax({
            url: "{{url("admin/lp/change-package-status")}}",
            type: "post",
            dataType: 'json',
            data: data,
            success: function (response) {

                $('#loader' + location_id).fadeOut();

                if (response['meta']['status'] == 200) {
                    $("#package_info" + location_id).html(response['response']['view']);
                    successToast(response['response']['message']);
                } else if (response['meta']['status'] == 100) {
                    worningToast(response['response']['message']);
                } else {
                    worningToast(response['response']['message']);
                    window.location.href = '{{url('ep')}}';
                }

            }
        });
    });

</script>