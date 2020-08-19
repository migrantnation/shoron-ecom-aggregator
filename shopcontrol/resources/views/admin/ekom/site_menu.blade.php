@extends('admin.layouts.master')
@section('content')

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin/')}}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Site Menu</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->
    <div class="container-alt margin-top-20">
        <h3 class="margin-top-10 margin-bottom-15">Menu</h3>

        <div class="portlet light bordered">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="side-block">
                            <h4 class="block-title">Categories</h4>

                            <ul class="tree side-list">
                                <li>
                                    <div class="arrow collapsed"></div>
                                    <div class="checkbox"></div>
                                    <input type="checkbox" name="" value=" 1"
                                           style="display: none;">
                                    <label class="">Category 1</label>

                                    <ul style="display: none;">
                                        <li>
                                            <div class="arrow collapsed"></div>
                                            <div class="checkbox"></div>
                                            <input type="checkbox" name="" value=" 9"
                                                   style="display: none;">
                                            <label>Sub category-1-1</label>
                                            <ul style="display: none;">
                                                <li>
                                                    <div class="arrow"></div>
                                                    <div class="checkbox"></div>
                                                    <input type="checkbox" name="" value=" 17"
                                                           style="display: none;">
                                                    <label>Sub category-1-1</label>
                                                </li>
                                                <li>
                                                    <div class="arrow"></div>
                                                    <div class="checkbox"></div>
                                                    <input type="checkbox" name="" value=" 25"
                                                           style="display: none;">
                                                    <label>Sub category-1-1</label>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div class="arrow collapsed"></div>
                                            <div class="checkbox"></div>
                                            <input type="checkbox" name="" value=" 9"
                                                   style="display: none;">
                                            <label>Sub category-1-1</label>
                                            <ul style="display: none;">
                                                <li>
                                                    <div class="arrow"></div>
                                                    <div class="checkbox"></div>
                                                    <input type="checkbox" name="" value=" 17"
                                                           style="display: none;">
                                                    <label>Sub category-1-1</label>
                                                </li>
                                                <li>
                                                    <div class="arrow"></div>
                                                    <div class="checkbox"></div>
                                                    <input type="checkbox" name="" value=" 25"
                                                           style="display: none;">
                                                    <label>Sub category-1-1</label>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <div class="arrow collapsed"></div>
                                    <div class="checkbox"></div>
                                    <input type="checkbox" name="" value=" 1"
                                           style="display: none;">
                                    <label class="">Category 2</label>

                                    <ul style="display: none;">
                                        <li>
                                            <div class="arrow collapsed"></div>
                                            <div class="checkbox"></div>
                                            <input type="checkbox" name="" value=" 9"
                                                   style="display: none;">
                                            <label>Sub category-2-1</label>
                                            <ul style="display: none;">
                                                <li>
                                                    <div class="arrow"></div>
                                                    <div class="checkbox"></div>
                                                    <input type="checkbox" name="" value=" 17"
                                                           style="display: none;">
                                                    <label>Sub category-2-1</label>
                                                </li>
                                                <li>
                                                    <div class="arrow"></div>
                                                    <div class="checkbox"></div>
                                                    <input type="checkbox" name="" value=" 25"
                                                           style="display: none;">
                                                    <label>Sub category-2-1</label>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div class="arrow collapsed"></div>
                                            <div class="checkbox"></div>
                                            <input type="checkbox" name="" value=" 9"
                                                   style="display: none;">
                                            <label>Sub category-1-1</label>
                                            <ul style="display: none;">
                                                <li>
                                                    <div class="arrow"></div>
                                                    <div class="checkbox"></div>
                                                    <input type="checkbox" name="" value=" 17"
                                                           style="display: none;">
                                                    <label>Sub category-1-1</label>
                                                </li>
                                                <li>
                                                    <div class="arrow"></div>
                                                    <div class="checkbox"></div>
                                                    <input type="checkbox" name="" value=" 25"
                                                           style="display: none;">
                                                    <label>Sub category-1-1</label>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <div class="side-block-footer">
                                <a href="javascript://" class="btn btn-sm btn-default">Add to Menu</a>
                            </div>
                        </div>

                        <div class="side-block">
                            <h4 class="block-title">Custom Link</h4>

                            <div class="form-group form-group-sm">
                                <label for="">URL</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="">Navigation Label</label>
                                <input type="text" class="form-control">
                            </div>

                            <div class="side-block-footer">
                                <a href="javascript://" class="btn btn-sm btn-default">Add to Menu</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 plx__menu">
                        <div class="dd margin-bottom-20" id="nestable_list_1">
                            <ol class="dd-list">
                                <li class="dd-item" data-id="1">
                                    <div class="dd-handle"> Item 1 </div>
                                    <a href="#" class="expand-collapse-btn">
                                        <i class="icon__collapse fa fa-caret-down"></i>
                                        <i class="icon__expand fa fa-caret-up"></i>
                                    </a>
                                    <div class="options">
                                        <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                        <div>
                                            <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                        </div>
                                    </div>
                                </li>

                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle"> Item 3 </div>

                                    <a href="#" class="expand-collapse-btn">
                                        <i class="icon__collapse fa fa-caret-down"></i>
                                        <i class="icon__expand fa fa-caret-up"></i>
                                    </a>
                                    <div class="options">
                                        <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                        <div>
                                            <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                        </div>
                                    </div>

                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="4">
                                            <div class="dd-handle"> Item 4 </div>

                                            <a href="#" class="expand-collapse-btn">
                                                <i class="icon__collapse fa fa-caret-down"></i>
                                                <i class="icon__expand fa fa-caret-up"></i>
                                            </a>
                                            <div class="options">
                                                <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                                <div>
                                                    <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="6">
                                            <div class="dd-handle"> Custom Link </div>

                                            <a href="#" class="expand-collapse-btn">
                                                <i class="icon__collapse fa fa-caret-down"></i>
                                                <i class="icon__expand fa fa-caret-up"></i>
                                            </a>
                                            <div class="options">
                                                <div class="form-group form-group-sm">
                                                    <label for="">URL</label>
                                                    <input type="text" class="form-control" value="http://example.com/">
                                                </div>
                                                <div class="form-group form-group-sm">
                                                    <label for="">Navigation Label</label>
                                                    <input type="text" class="form-control" value="Custom Link">
                                                </div>

                                                <div>
                                                    <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                                </div>
                                            </div>


                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="5">
                                                    <div class="dd-handle"> Item 5 </div>

                                                    <a href="#" class="expand-collapse-btn">
                                                        <i class="icon__collapse fa fa-caret-down"></i>
                                                        <i class="icon__expand fa fa-caret-up"></i>
                                                    </a>
                                                    <div class="options">
                                                        <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                                        <div>
                                                            <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                </li>



                                <li class="dd-item" data-id="13">
                                    <div class="dd-handle"> Item 13 </div>
                                    <a href="#" class="expand-collapse-btn">
                                        <i class="icon__collapse fa fa-caret-down"></i>
                                        <i class="icon__expand fa fa-caret-up"></i>
                                    </a>
                                    <div class="options">
                                        <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                        <div>
                                            <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                        </div>
                                    </div>
                                </li>

                                <li class="dd-item" data-id="14">
                                    <div class="dd-handle"> Item 14 </div>
                                    <a href="#" class="expand-collapse-btn">
                                        <i class="icon__collapse fa fa-caret-down"></i>
                                        <i class="icon__expand fa fa-caret-up"></i>
                                    </a>
                                    <div class="options">
                                        <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                        <div>
                                            <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                        </div>
                                    </div>
                                </li>

                                <li class="dd-item" data-id="15">
                                    <div class="dd-handle"> Item 15 </div>

                                    <a href="#" class="expand-collapse-btn">
                                        <i class="icon__collapse fa fa-caret-down"></i>
                                        <i class="icon__expand fa fa-caret-up"></i>
                                    </a>
                                    <div class="options">
                                        <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                        <div>
                                            <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                        </div>
                                    </div>

                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="16">
                                            <div class="dd-handle"> Item 16 </div>

                                            <a href="#" class="expand-collapse-btn">
                                                <i class="icon__collapse fa fa-caret-down"></i>
                                                <i class="icon__expand fa fa-caret-up"></i>
                                            </a>
                                            <div class="options">
                                                <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                                <div>
                                                    <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="17">
                                            <div class="dd-handle"> Item 17 </div>

                                            <a href="#" class="expand-collapse-btn">
                                                <i class="icon__collapse fa fa-caret-down"></i>
                                                <i class="icon__expand fa fa-caret-up"></i>
                                            </a>
                                            <div class="options">
                                                <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                                <div>
                                                    <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="18">
                                            <div class="dd-handle"> Custom Link </div>

                                            <a href="#" class="expand-collapse-btn">
                                                <i class="icon__collapse fa fa-caret-down"></i>
                                                <i class="icon__expand fa fa-caret-up"></i>
                                            </a>
                                            <div class="options">
                                                <div class="form-group form-group-sm">
                                                    <label for="">URL</label>
                                                    <input type="text" class="form-control" value="http://example.com/">
                                                </div>
                                                <div class="form-group form-group-sm">
                                                    <label for="">Navigation Label</label>
                                                    <input type="text" class="form-control" value="Custom Link">
                                                </div>

                                                <div>
                                                    <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </li>

                                <li class="dd-item" data-id="2">
                                    <div class="dd-handle"> Item 2 </div>
                                    <a href="#" class="expand-collapse-btn">
                                        <i class="icon__collapse fa fa-caret-down"></i>
                                        <i class="icon__expand fa fa-caret-up"></i>
                                    </a>
                                    <div class="options">
                                        <div class="margin-bottom-10">Link: <a href="#category-link" class="">Item 13</a></div>
                                        <div>
                                            <a href="javascript://" class="text-danger">Remove</a> | <a href="javascript://">Cancel</a>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn green">Create Menu</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(".dd-item").each(function () {
                    var toggleExpandCollapse    = $(this).children(".expand-collapse-btn"),
                        targetBlock             = $(this).children(".options");

                    $(toggleExpandCollapse).on("click", function (e) {
                        e.preventDefault();
                        $(this).toggleClass('open');
                        $(targetBlock).slideToggle("fast");
                    })
                });
            })
        }(jQuery))
    </script>

@endsection