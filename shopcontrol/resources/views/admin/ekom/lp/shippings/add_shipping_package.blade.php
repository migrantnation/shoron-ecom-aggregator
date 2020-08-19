@extends('admin.layouts.master')
@section('content')
    <?php
    //echo "<pre>";
    //print_r(old('to_city_ids'));
    //exit();
    ?>
    <style>
        #add_edit_category label.error {
            width: auto;
            display: inline;
            color: red;
            font-style: italic;
        }

        .alert-required {
            color: red;
            font-style: italic;
            padding-top: 3px;
        }

        .click-disabled > .checked {
            pointer-events: none;
            cursor: pointer;
        }

        .checked_opacity {
            opacity: .5;
        }
    </style>

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Add Package</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title"> Add Package
                <small></small>
            </h1>
        </div>
    </div>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark sbold">Add Package</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" id="package_creation_form"
                          action="{{url("admin/lp/$lp_info->lp_url/store-package")}}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Package Name: </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="Enter Package Name"
                                           name="package_name" required value="{{ old('package_name') }}">
                                    <div class="alert-required">
                                        {{$errors->first('package_name')}}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php
                                $selected_city = array();
                                ?>
                                @if(old('from_city_id'))
                                    <?php $selected_city[old('from_city_id')] = 'selected';?>
                                @elseif(@$package_info->from_city_id)
                                    <?php $selected_city[@$package_info->from_city_id] = 'selected';?>
                                @endif


                                <label class="col-md-2 control-label">From: </label>
                                <div class="col-md-8">
                                    <select class="form-control" name="from_city_id" id="from_city_id" required>
                                        <option value="">--Select City--</option>
                                        @foreach($city_list as $each_city)
                                            <option value="{{@$each_city->id}}" {{@$selected_city[@$each_city->id]}}>
                                                {{@$each_city->location_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div style="display: none;" id="location_div">

                                <?php
                                function show_tree_access($location_tree, $child_counter = 1, $prev_city_ids)
                                {
                                    $prev_city_arr = explode(',', $prev_city_ids);
                                    foreach ($location_tree as $key => $value) {
                                        $this_id = $value['id'];
                                        if (in_array($this_id, $prev_city_arr)) {
                                            $checked_text = " <i style='color'>Location Already In Another Shipping Package</i> ";
                                            $checked_opacity = "class='checked_opacity'";
                                        }

                                        echo '<li id="l' . $value['id'] . '">';
                                        echo '<input type="checkbox" name="to_city_ids[]" value=" ' . $value['id'] . '" > <label ' . @$checked_opacity . '>' . $value['location_name'] . @$checked_text . '</label>';
                                        if (!empty($value['children'])) {
                                            echo '<ul>';
                                            show_tree_access($value['children'], $value['id'], $prev_city_ids);
                                            echo '</ul>';
                                        }
                                        echo '</li>';
                                        $child_counter++;
                                    }
                                }
                                ?>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">To: </label>
                                    <div class="col-md-8">
                                        <div class="portlet light bordered">
                                            <ul class="tree" id="location_tree">

                                                @if(old('from_city_id'))
                                                    {{show_tree_access($location_tree, $child_counter = 1, $prev_location->to_city_ids)}}
                                                    <script>
                                                        $("#location_div").show();
                                                        checkSelected();
                                                    </script>
                                                @else
                                                    {{show_tree_access($location_tree, $child_counter = 1, $prev_location->to_city_ids)}}
                                                    <script>
                                                        $("#location_div").show();
                                                        checkSelected();
                                                    </script>
                                                @endif
                                            </ul>
                                            <div class="alert-required">
                                                {{$errors->first('to_city_ids')}}
{{--                                                {{'previous: ' . $prev_location->to_city_ids.' this package citis: ' . @$package_info->to_city_ids}}--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php
                                    $min_weight = array();
                                    $max_weight = array();
                                    $price = array();
                                    ?>
                                    @if(@$package_info)
                                        <?php
                                        foreach ($package_info->get_weight_price as $weight_price) {
                                            $min_weight[] = $weight_price->min_weight;
                                            $max_weight[] = $weight_price->max_weight;
                                            $price[] = $weight_price->price;
                                        }
                                        ?>
                                    @endif

                                    @if(old('min_weight'))
                                        <?php
                                        $min_weight = old('min_weight');
                                        $max_weight = old('max_weight');
                                        $price = old('price');
                                        ?>
                                    @endif

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Package Weight Price: </label>
                                        <div class="col-md-8">
                                            <table class="table table-hover table-light" id="package_weight_price">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Min Weight</th>
                                                    <th class="text-center">Max Weight</th>
                                                    <th class="text-center">price</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if($min_weight)
                                                    <?php $i = 1;?>
                                                    @forelse($min_weight as $key=>$value)
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control numeric required" placeholder="Min Weight"
                                                                       name="min_weight[]" value="{{$min_weight[$key]}}" required="required" aria-required="true">
                                                                <label class="error">{!! $errors->has('max_weight.'.$key) ? ' Required' : '' !!}</label>
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control numeric required" placeholder="Max Weight" data-key=""
                                                                       name="max_weight[]" required="required" aria-required="true" value="{{$max_weight[$key]}}">
                                                                <label class="error">{!! $errors->has('max_weight.'.$key) ? ' Required' : '' !!}</label>
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control numeric required" placeholder="Price" data-key=""
                                                                       required="required" aria-required="true" value="{{$price[$key]}}" name="price[]">
                                                                <label class="error">{!! $errors->has('price.'.$key) ? ' Required' : '' !!}</label>
                                                            </td>

                                                            @if($i==1)
                                                                <td><a href="javascript:;" id="add_more">Add more</a></td>
                                                            @else
                                                                <td><a href="javascript:;" class="remove-pkg-weight-price">Remove</a></td>

                                                            @endif
                                                        </tr>
                                                        <?php $i++;?>
                                                    @empty

                                                    @endforelse

                                                @else
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control numeric required" placeholder="Min Weight"
                                                                   name="min_weight[]" value="" required="required" aria-required="true">
                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control numeric required" placeholder="Max Weight" data-key=""
                                                                   name="max_weight[]" required="required" aria-required="true" value="">
                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control numeric required" placeholder="Price" data-key=""
                                                                   required="required" aria-required="true" value="" name="price[]">
                                                        </td>
                                                        <td><a href="javascript:;" id="add_more">Add more</a></td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-2 col-md-10">
                                    <button type="submit" class="btn green">Submit</button>
                                    <a href="{{url('admin/lp/package-list/shundarban')}}">
                                        <button type="button" class="btn default">Cancel</button>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->


    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.js"></script>
    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.validate.js"></script>

    <script>
        var locations = '';
        var packageLocations = [];
        locations = [{{"$prev_location->to_city_ids"}}];
    </script>

    @if(old('from_city_id'))
        <script>
            locations = locations.concat([{{ old('to_city_ids') ? implode(',',old('to_city_ids')) : ''}}]);
        </script>
    @elseif(@$package_info->to_city_ids)
        <script>
            locations = locations.concat([{{ $package_info->to_city_ids }}]);
            packageLocations = packageLocations.concat([{{ $package_info->to_city_ids }}]);
        </script>
    @endif

    <script>
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#package_creation_form").validate({
                messages: {
                    package_name: "Please enter your package name",
                    max_weight: "Please enter max weight",
                    min_weight: "Please enter min weight",
                    price: "Please enter price",
                    from_city_id: "Please select location",
                }
            });
        });

        function checkSelected() {
            for (var i = 0; i < locations.length; i++) {
                var checker;
                checker = $('#l' + locations[i] + ' .checkbox');
                $('#l' + locations[i] + ' .checkbox').addClass('checked');

                if (packageLocations.includes(locations[i]) == false) {
                    $('#l' + locations[i]).addClass('click-disabled');
                }

                var arrow;
                arrow = $('#l' + locations[i] + ' .arrow');
                if (arrow[1]) {
                    arrow[0].classList.add('expanded');
                    arrow[0].classList.remove('collapsed');
                    var childDisplay;
                    childDisplay = $('#l' + locations[i] + ' ul');
                    childDisplay[0].style.display = "block";
                }
            }
        }

        $(".remove-pkg-weight-price").on("click", function () {
            $(this).closest(".weight-price").remove();
        });

    </script>

    <script src="{{url("public/js/admin/shipping_package.js")}}"></script>
@endsection