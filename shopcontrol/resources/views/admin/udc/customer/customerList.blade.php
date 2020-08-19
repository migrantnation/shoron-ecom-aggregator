@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('/admin')}}">{{ __('admin_text.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ __('admin_text.customer-list') }}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{ __('admin_text.customer-list') }} &nbsp;
        <small></small>
        <a href="{{route('udc.addCustomer')}}" class="btn btn-info">{{ __('admin_text.add-new') }} &nbsp;&nbsp;<i
                    class="fa fa-plus"></i></a>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">{{ __('admin_text.all-customer') }}</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <form action="#" class="margin-bottom-20">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-inline text-right">
                                    <div class="form-group">
                                        <label for="">{{ __('admin_text.search') }}:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control">
                                            <span class="input-group-btn">
                                            <button class="btn blue" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <span style="display: inline-block; margin-bottom: 10px;">Showing 1 to 10 of 25 records</span>

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin_text.name') }}</th>
                            <th>{{ __('admin_text.mobile-number') }}.</th>
                            <th>{{ __('admin_text.address') }}</th>
                            <th>{{ __('admin_text.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($customerList as $key => $each_customer)
                            <tr>
                                <td width="20">{{$key +1}}</td>
                                <td>{{@$each_customer->customer_name}}</td>
                                <td>{{@$each_customer->customer_contact_number}}</td>
                                <td>{{@$each_customer->customer_address}}</td>
                                <td width="220" class="text-center">
                                    <a href="{{route('udc.editCustomer',$each_customer->id)}}" class="btn blue btn-xs">
                                        <i class="fa fa-pencil"></i> {{ __('admin_text.view') }}
                                    </a>

                                    <a href="{{url('udc/customer'.'/'.$each_customer->id.'/orders')}}"
                                       class="btn blue btn-xs">
                                        <i class="fa fa-pencil"></i> {{ __('admin_text.orders') }}
                                    </a>
                                    {{--<a href="{{route('udc.deleteCustomer',$each_customer->id)}}" onclick="return confirm('Are you sure ?')" class="btn red btn-xs">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>--}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center "><h4>{{ __('admin_text.no-result') }}</h4></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection