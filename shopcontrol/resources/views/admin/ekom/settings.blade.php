@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin/')}}">{{__('_ecom__text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE CONTENT-->

    <div class="container-alt margin-top-20">
        <div class="portlet light bordered">
            <div class="portlet-body">
                <form class="row" action="{{url('admin/update-setting')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="mode_id" value="{{@$setting_info->id  ? @$setting_info->id : ""}}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Application Mode</label>
                            <select name="mode" class="form-control">
                                <option value="1" {{@$setting_info->application_mode && @$setting_info->application_mode == 1 ? "selected" : ""}}>Production</option>
                                <option value="2" {{@$setting_info->application_mode && @$setting_info->application_mode == 2 ? "selected" : ""}}>Development</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn green">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection