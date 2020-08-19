@extends('admin.layouts.master')
@section('content')
    <?php
    //        echo "<pre>";
    //        print_r($category_locations);
    //        exit();
    //echo $category_info['id']; exit();
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
    </style>

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="./">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Edit Category</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title"> Edit Category
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
                        <span class="caption-subject font-dark sbold">Edit Category</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" id="add_edit_category"
                          action="{{url('admin/update-category'.'/'.$category_info['id'])}}" method="post">
                        <input type="hidden" name="category_id" value="{{$category_info['id']}}"/>
                        {!! csrf_field() !!}
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Name: </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="Enter Name"
                                           name="category_name" required autofocus
                                           value="{{ $category_info['category_name'] ? $category_info['category_name'] : old('category_name') }}">
                                    <div class="alert-required">
                                        {{$errors->first('category_name')}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Displayed: </label>
                                <div class="col-md-8">
                                    <div class="bootstrap-switch-container" style="width: 129px; margin-left: -8px;">
                                        <span class="bootstrap-switch-label" style="width: 43px;">&nbsp;</span>
                                        <input type="checkbox"
                                               {{@$category_info['display_in_home'] == 1 ? 'checked' : ''}} class="make-switch"
                                               id="test" data-size="small" name="display_in_home"
                                               value="{{@$category_info['display_in_home']}}">
                                    </div>
                                </div>
                            </div>
                            <?php
                            $first = '';
                            function show_tree($category_tree, $child_counter = 0, $category_id)
                            {
                            if ($child_counter == 0) {
                                echo '<ul id="plx__tree">';
                            } else {
                                echo '<ul id="child' . $child_counter . '">';
                            }
                            foreach ($category_tree as $key => $value) {
                            if (!empty($value['children'])) {
                            echo '<li id="parent' . $value['id'] . '">';
                            ?>
                            <label class="plx__radio" for="cat{{$value['id']}}">
                                <input type="radio" id="cat{{$value['id']}}" name="parent_category_id"
                                       value="{{$value['id']}}" {{$value['id'] == $category_id ? 'checked' : ''}}>
                                <span></span>
                            </label>
                            <a href="#child{{$value['id']}}"> {{$value['category_name']}}</a>
                            <?php
                            show_tree($value['children'], $value['id'], $category_id);
                            echo '</li>';
                            } else {
                            ?>
                            <li>
                                <label class="plx__radio" for="cat{{$value['id']}}">
                                    <input type="radio" id="cat{{$value['id']}}" name="parent_category_id"
                                           value="{{$value['id']}}" {{$value['id'] == $category_id ? 'checked' : ''}}>
                                    <span></span>
                                </label>
                                <span class="l-child">{{$value['category_name']}}</span>
                            </li>
                            <?php
                            }
                            }
                            echo '</ul>';
                            }
                            ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Parent Category: </label>
                                <div class="col-md-8">
                                    <div class="portlet light bordered">
                                        <div style="text-align: right">
                                            <a href="#" id="expandToggle">Expand All</a>
                                        </div>
                                        <ul id="plx__tree">
                                            <?php
                                            echo '<li>';
                                            ?>
                                            <label class="plx__radio" for="cat0">
                                                <input type="radio" id="cat0" name="parent_category_id"
                                                       value="0" {{$category_info['parent_category_id'] == 0 ? 'checked' : ''}}>
                                                <span></span>
                                            </label>
                                            <span class="l-child">Home </span>
                                            <?php
                                            echo '</li>';
                                            ?>
                                        </ul>
                                        <?php show_tree($category_tree, 0, $category_info['parent_category_id']);?>
                                    </div>
                                </div>
                            </div>

                            <?php
                            function show_tree_access($location_tree, $child_counter = 1, $category_locations, $category_info)
                            {
                            foreach ($location_tree as $key => $value) {
                            echo '<li id="l' . $value['id'] . '">';
                            ?>
                            <input type="checkbox" name="country_location_ids[]" id="country_location_ids{{$value['id']}}" value="{{$value['id']}}" {{in_array($value['id'], explode(',',$category_info['country_location_ids'])) ? 'checked' : ''}}>
                            <label>{{$value['location_name']}}</label>
                            <?php
                            if (!empty($value['children'])) {
                                echo '<ul>';
                                show_tree_access($value['children'], $value['id'], $category_locations, $category_info);
                                echo '</ul>';
                            }
                            echo '</li>';
                            $child_counter++;
                            }
                            }
                            ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Access To: </label>
                                <div class="col-md-8">
                                    <div class="portlet light bordered">
                                        <ul class="tree">
                                            <?php show_tree_access($location_tree, 1, $category_locations, $category_info);?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Description: </label>
                                <div class="col-md-8">
                                    <textarea class="col-md-8" id="summernote"  name="description"> {{ $category_info['description'] ? $category_info['description'] : old('category_name') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-2 col-md-10">
                                    <button type="submit" class="btn green">Submit</button>
                                    <button type="button" class="btn default">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->


    <script src="{{url('assets/plugins/jquery_validation')}}/jquery.js"></script>
    <script src="{{url('assets/plugins/jquery_validation')}}/jquery.validate.js"></script>
    <script>
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#add_edit_category").validate({
                messages: {
                    category_name: "Please enter the category name"
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 200,
                minHeight: null,
                maxHeight: null,
                focus: true
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            preOpen('{{$category_info['main_parent']}}', '{{$category_info['parent_category_id']}}');
        });
    </script>

    <script>
        var locations = [<?php echo implode(',', $category_locations);?>];
        function checkSelected() {
            for (var i = 0; i <= locations[locations.length - 1]; i++) {
                if (locations.includes(i)) {
                    var checker;
                    checker = $('#l' + i + ' .checkbox');
                    checker[0].classList.add('checked');
                    var arrow;
                    arrow = $('#l' + i + ' .arrow');
                    if (arrow[1]) {
                        arrow[0].classList.add('expanded');
                        arrow[0].classList.remove('collapsed');

                        var childDisplay;
                        childDisplay = $('#l' + i + ' ul');
                        childDisplay[0].style.display = "block";
                    }
                }
            }
        }
    </script>

@endsection