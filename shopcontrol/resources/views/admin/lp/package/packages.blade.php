@extends('admin.layouts.master')
@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('lp/')}}">{{__('_ecom__text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>
                    {{__('_ecom__text.packages')}}</span>
            </li>
        </ul>
    </div>


    <div class="container-alt margin-top-20">

        <h3 class="margin-top-10 margin-bottom-15">{{__('_ecom__text.packages')}}</h3>

        <div class="portlet light bordered">
            <div class="portlet-body">
                @if(@$lp)

                    <div class="row">
                        <div class="col-md-12">

                            @if(Auth::guard('lp_admin')->user()->for_all_users != 1)
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-4"> Total USER: <strong>{{$users->total()}}</strong> </div>
                                        <div class="col-md-4"> Total distributed Package: <strong>{{$lp->packages->count()}}</strong> </div>
                                        <div class="col-md-4 text-right"> Total Active Package: <strong>{{$lp->packages->where('is_selected', 1)->count()}}</strong> </div>
                                        
                                        <div class="col-md-12">
                                            
                                            <!--<div class="col-md-4">-->
                                            <!--    <div class="form-group">-->
                                            <!--        <div class="input-group">-->
                                            <!--            <input type="text" class="form-control" id="search_string"-->
                                            <!--                   value="{{@$_GET['search_string'] ? @$_GET['search_string'] : ""}}">-->
                                            <!--            <span class="input-group-btn">-->
                                            <!--                <button class="btn blue" type="button" id="btn_search_location">-->
                                            <!--                    <i class="fa fa-search"></i>-->
                                            <!--                </button>-->
                                            <!--            </span>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <br>
                                            
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    {{--<label for="">{{__('_ecom__text.filter-by')}}:</label>--}}
                                                    <div class="input-group">
                                                        <select class="country-location form-control" data-category="division"
                                                                name="division" id="division">
                                                            <option value="">--বিভাগ--</option>
                                                            @forelse($division as $key=>$value)
                                                                <option value="{{$value->division}}" {{@$_GET['division'] && @$_GET['division'] == $value->division ? 'selected' : ''}}>{{$value->division}}</option>
                                                            @empty
                                                                <option>No Division Found</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
            
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select class="country-location form-control" data-category="district"
                                                                name="district" id="district">
                                                            <option value="">--জেলা--</option>
                                                            @if(@$district)
                                                                @forelse(@$district as $each_district)
                                                                    <option value="{{@$each_district->district}}" {{@$each_district->district && @$each_district->district == @$_GET['district'] ? 'selected' : ''}}>{{@$each_district->district}}</option>
                                                                @empty
                                                                @endforelse
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
            
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select class="country-location form-control" data-category="upazila"
                                                                name="upazilla" id="upazilla">
                                                            <option value="">--উপজেলা--</option>
                                                            @if(@$district)
                                                                @forelse(@$upazila as $each_upazila)
                                                                    <option value="{{@$each_upazila->upazila}}" {{@$each_upazila->upazila && $each_upazila->upazila == @$_GET['upazila'] ? 'selected' : ''}}>{{$each_upazila->upazila}}</option>
                                                                @empty
                                                                @endforelse
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
            
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select class="country-location form-control" data-category="union"
                                                                name="union" id="union">
                                                            <option value="">--ইউনিয়ন--</option>
                                                            @if(@$district)
                                                                @forelse(@$union as $each_union)
                                                                    <option value="{{@$each_union->union}}" {{@$each_union->union && @$each_union->union == @$_GET['union'] ? 'selected' : ''}}>{{$each_union->union}}</option>
                                                                @empty
                                                                @endforelse
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
            
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select class="form-control" data-category="package_status"
                                                                name="package_status" id="package_status">
                                                            <option value="all">All</option>
                                                            <option value="1">Activated</option>
                                                            <option value="2">Dectivated</option>
                                                            <option value="3">Not Assigned</option>
                                                        </select>
                                                    </div> &nbsp;
                                                </div>
            
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="search_string"
                                                               placeholder="{{__('_ecom__text.search')}}"
                                                               name="search_string" value="{{@$_GET['search_string']}}">
                                                        <span class="input-group-btn">
                                                            <button class="btn blue" type="button" id="btn_search_location">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
            
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="overlay-wrap" id="package-overlay-wrap">
                                        <div class="anim-overlay">
                                            <div class="spinner">
                                                <div class="bounce1"></div>
                                                <div class="bounce2"></div>
                                                <div class="bounce3"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="package_list">
                                        @include("admin.lp.package.package_list")
                                    </div>

                                </div>
                            @else
                                <h3>You have a single package for all user</h3>
                                <h3>Package value: <b>{{@$lp->charge}}TK</b></h3>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>

    <script>

        $('#btn_search_location').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                find_location();
            }
        });

        $("#btn_search_location").click(function (e) {
            e.preventDefault();
            find_location();
        });

        function find_location() {
            var search_string = $('#search_string').val();
            var division = $('#division').val();
            var district = $('#district').val();
            var upazilla = $('#upazilla').val();
            var union = $('#union').val();
            var package_status = $('#package_status').val();

            $('#package_list').html('');
            $('#package-overlay-wrap').show();

            var data = {
                search_string: search_string,
                division: division,
                district: district,
                upazilla: upazilla,
                union: union,
                package_status: package_status,
                lp_id: "{{@$lp->id}}",
                _token: "{{csrf_token()}}",
            }

            $.ajax({
                url: "{{url("lp/package-location")}}",
                type: "post",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $('#package-overlay-wrap').hide();
                    $("#package_list").html(html);
                    init_actions();
                }
            });
        }

    </script>

    <script>
        $(document).on('change', '.package-distribute', function (e) {

            var status = $('#status_range').val();
            $('#loader').show();
            var data = {
                "filter_range": filter_range,
                "status": status,
            };
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                data: data,
                success: function (html) {
                    $("#report-render").html(html);
                    initChart();
                    $('#loader').fadeOut();
                }
            });
        });

        $(document).on('click', '.pagination a', function (e) {

            e.preventDefault();
            var search_string = $('#search_string').val();
            var division = $('#division').val();
            var district = $('#district').val();
            var upazilla = $('#upazilla').val();
            var union = $('#union').val();
            var package_status = $('#package_status').val();
            $('#package_list').html('');
            $('#package-overlay-wrap').show();

            $.ajax({
                url: "{{url("lp/package-location")}}",
                type: "post",
                dataType: 'json',
                data: {
                    search_string: search_string,
                    lp_id: "{{@$lp->id}}",
                    division: division,
                    district: district,
                    upazilla: upazilla,
                    union: union,
                    package_status: package_status,
                    page: $(this).attr('href').split('page=')[1],
                    _token: "{{csrf_token()}}",
                },
                success: function (html) {
                    $('#package-overlay-wrap').hide();
                    $("#package_list").html(html);
                }
            });
        });

        
        $('.country-location').on('change', function (e) {

            var location_type = $(this).data('category');
            if (location_type == 'union') {
                searchAndFilter();
            }
            $.ajax({
                url: "{{url('country-location')}}",
                type: "get",
                data: {
                    location_type: location_type,
                    location_name: $(this).val(),
                },

                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.meta.status == 200) {
                        var index = data.response.index;
                        var element = $('.country-location')[index];
                        element.innerHTML = data.response.view;

                        if (index == 1) {
                            var element = $('.country-location')[index + 1];
                            if (element) {
                                element.innerHTML = `<option value="">--উপজেলা--</option>`;
                            }

                            var element = $('.country-location')[index + 2];
                            if (element) {
                                element.innerHTML = `<option value="">--ইউনিয়ন--</option>`;
                            }
                        }

                        if (index == 2) {
                            var element = $('.country-location')[index + 1];
                            if (element) {
                                element.innerHTML = `<option value="">--ইউনিয়ন--</option>`;
                            }
                        }
                        searchAndFilter();
                    }
                }
            });
            e.preventDefault();
        });

    </script>
@endsection