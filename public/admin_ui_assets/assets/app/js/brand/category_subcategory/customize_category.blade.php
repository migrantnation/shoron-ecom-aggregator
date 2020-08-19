@extends('admin.layouts.master')
@section('content')
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
                <span>Customize Category</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title"> Customize Category
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
                        <span class="caption-subject font-dark sbold">Customize Category</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" id="" action="{{url('admin/update-customize-category'.'/'.$category_info['id'])}}" method="post">
                        {!! csrf_field() !!}
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
                                        <?php show_tree($category_tree, 0, $category_info['id']);?>
                                    </div>
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

    <script>
        $(document).ready(function () {
            preOpen('{{$category_info['main_parent']}}', '{{$category_info['id']}}');
        });
    </script>
@endsection