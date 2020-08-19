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
                          action="{{url('admin/lp/store-package')}}" method="post">
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
                                <label class="col-md-2 control-label">From: </label>
                                <div class="col-md-8">
                                    <select class="form-control" name="from_city_id" id="from_city_id"
                                            onchange="get_location(this.value)" required>
                                        <option value="">--Select City--</option>
                                        @foreach($city_list as $each_city)
                                            <option value="{{@$each_city->id}}" {{old('from_city_id') && old('from_city_id') == $each_city->id ? "selected" : ""}}>{{@$each_city->location_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div style="display: none;" id="location_div">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">To: </label>
                                    <div class="col-md-8">
                                        <div class="portlet light bordered">
                                            <ul class="tree" id="location_tree">
                                            </ul>
                                            <div class="alert-required">
                                                {{$errors->first('to_city_ids')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Min Weight (gm) *: </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" placeholder="Enter Min Weight"
                                               name="min_weight" required value="{{ old('min_weight') }}">
                                        <span class="alert-required">
                                            {{$errors->first('min_weight')}}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Max Weight (gm) *: </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" placeholder="Enter Max Weight"
                                               name="max_weight" required value="{{ old('max_weight') }}">
                                        <div class="alert-required">
                                            {{$errors->first('max_weight')}}
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-2 control-label">Price *: </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" placeholder="Enter Price"
                                               name="price" required value="{{ old('price') }}">
                                        <div class="alert-required">
                                            {{$errors->first('price')}}
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

    {{--{{implode(',',old('to_city_ids'))}}--}}
    <!-- END CONTENT BODY -->

    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.js"></script>
    <script src="{{url('public/assets/plugins/jquery_validation')}}/jquery.validate.js"></script>
    <script>
        var locations = '';
        locations = [{{"$prev_location->to_city_ids"}}];
    </script>

    @if(old('from_city_id'))
        <script>
            locations = locations.concat([{{ old('to_city_ids') ? implode(',',old('to_city_ids')) : ''}}]);
            $(document).ready(function () {
                get_location({{old('from_city_id') ? old('from_city_id') : "-1"}});
            });
        </script>
    @endif

    <script>
        function get_location(city_id) {

            if (city_id > 0) {
                $.ajax({
                    type: 'POST',
                    url: "{{url('admin/lp/get-location-by-city-id')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "city_id": city_id
                    },
                    success: function (data) {
                        $("#location_tree").html(data);
                        location_tree_for_package();
                        $("#location_div").show();
                        checkSelected();
                    }
                });
            }
            else {
                $("#location_div").hide();
            }
        }
    </script>

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
    </script>

    <script>
        function checkSelected() {
            for (var i = 0; i < locations.length; i++) {
                console.log(locations[i]);
                if (locations.includes(locations[i])) {
                    var checker;
                    checker = $('#l' + locations[i] + ' .checkbox');
                    $('#l' + locations[i] + ' .checkbox').addClass('checked');
                    $('#l' + locations[i]).addClass('click-disabled');
                    console.log(checker);
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
        }
    </script>

@endsection