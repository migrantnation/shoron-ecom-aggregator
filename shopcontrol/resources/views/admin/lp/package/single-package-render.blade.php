@forelse($users as $key=>$user)

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

                <div class="col-md-5">

                    <strong>{{$user->center_id}}</strong>
                    {{(@$lp_package->is_selected==1)?'Activated':'Deactivated'}}
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

                <div class="col-md-3">

                    @if(!@$lp_package)
                        <a class="save-package btn btn-primary" data-location-id="{{$user->id}}">
                            Save
                        </a>

                    @endif

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
