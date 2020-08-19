@extends('admin.layouts.master')
@section('content')
    {{--{{$ep_list}}--}}
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{__('admin_text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{__('_ecom__text.all-ep')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">{{__('_ecom__text.all-ep')}}</span>
                    </div>
                </div>

                <div class="portlet-body">

                    <span style="display: inline-block; margin-bottom: 10px;">Showing 1 to 10 of 25 records</span>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="20">#</th>
                            <th>EP Name</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>Address</th>
                            {{--<th width="220">Actions</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;?>
                        @forelse($ep_list as $ep)
                            <tr id="{{$ep->id}}">
                                <td width="20"><?= $i ?></td>
                                <td>
                                    <a href="{{$ep->ep_url}}" target="_blank">{{$ep->ep_name}}</a>
                                </td>
                                <td>{{$ep->contact_number}}</td>
                                <td>{{$ep->email}}</td>
                                <td>{{$ep->address}}</td>

                                {{--<td width="220" class="text-center">--}}
                                    {{--<a href="{{url("admin/payments/ep-orders/$ep->id")}}" class="btn green btn-xs">--}}
                                        {{--<i class="fa fa-eye"></i> {{__('_ecom__text.orders')}}--}}
                                    {{--</a>--}}
                                    {{--<a href="{{url("admin/edit-ep/$ep->id")}}" class="btn blue btn-xs">--}}
                                        {{--<i class="fa fa-pencil"></i> View--}}
                                    {{--</a>--}}
                                    {{--<a href="javascript:;" class="btn red btn-xs"--}}
                                       {{--data-lp-url="{{$ep->ep_url}}" data-lp-id="{{$ep->id}}">--}}
                                        {{--<i class="fa fa-trash-o"></i> Delete--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                            </tr>
                            <?php $i++;?>
                        @empty
                            <tr>
                                <td colspan="6"><h3>{{__('admin_text.no-result')}}</h3></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection