@extends('admin.layouts.master')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="plx__user-profile clearfix">
    <div class="left-part">
        <div class="profile-inner-block">

            <!-- BEGIN PORTLET -->
            <div class="portlet light ">
                <div class="portlet-body">
                    <div class="clearfix plx__portlet-header">
                        {{--<a href="{{url('admin/').'/'.@$udc_id.'/product'}}" class="pull-right">View More</a>--}}
                        <h3 class="plx_portlet-title">Admin Profile</h3>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="">
                        <form class="form-horizontal" action="{{url('admin/update-profile')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="" class="col-md-3">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{@$admin_info->name}}" required>
                                    <div class="alert-required">{{@$errors->first('name')}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3">Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{@$admin_info->email}}" required>
                                    <div class="alert-required">{{@$errors->first('email')}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3">Current Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="current_password">
                                    <div class="alert-required">{{@$errors->first('current_password')}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3">New Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                    <div class="alert-required">{{@$errors->first('password')}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3">Confirm New Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                    <div class="alert-required">{{@$errors->first('password_confirmation')}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3"></label>
                                <div class="col-md-6">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END PORTLET -->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
    @endsection