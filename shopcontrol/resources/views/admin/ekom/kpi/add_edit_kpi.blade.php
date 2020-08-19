@extends('admin.layouts.master')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">{{__('_ecom__text.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('admin/setting/kpi')}}">{{__('_ecom__text.kpi-list')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{@$kpi_info->id?__('_ecom__text.edit-kpi'):__('_ecom__text.add-new-kpi')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
        {{@$kpi_info->id?__('_ecom__text.edit-kpi'):__('_ecom__text.add-new-kpi')}}
        <small></small>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="container-alt margin-top-20">

        <div class="portlet light bordered">
            <div class="portlet-body">

                @if(@$kpi_info)
                    <?php $url = url("admin/setting/kpi/update/$kpi_info->id");?>
                @else
                    <?php $url = url("admin/setting/kpi/store");?>
                @endif

                <form class="row" method="post" action="{{$url}}">
                    {{csrf_field()}}

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.sale-per-day')}}</label>
                            <input type="number" step="1" class="form-control" name="sale_per_day"
                                   value="{{old('sale_per_day')?old('sale_per_day'):@$kpi_info->sale_per_day}}">
                            <span class="required">
                                <strong>{{ $errors->first('sale_per_day') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.total-transaction-per-day')}}</label>
                            <input type="number" step="1" class="form-control" name="total_transaction_per_day"
                                   value="{{old('total_transaction_per_day')?old('total_transaction_per_day'):@$kpi_info->total_transaction_per_day}}">
                            <span class="required">
                                <strong>{{ $errors->first('total_transaction_per_day') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.order-per-entrepreneur-per-day')}}</label>
                            <input type="number" step="1" class="form-control" name="order_per_entrepreneur_per_day"
                                   value="{{old('order_per_entrepreneur_per_day')?old('order_per_entrepreneur_per_day'):@$kpi_info->order_per_entrepreneur_per_day}}">
                            <span class="required">
                                <strong>{{ $errors->first('order_per_entrepreneur_per_day') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('_ecom__text.average-fulfillment-time')}}</label>
                            <input type="number" step="1" class="form-control" name="average_fulfillment_time"
                                   value="{{old('average_fulfillment_time')?old('average_fulfillment_time'):@$kpi_info->average_fulfillment_time}}">
                            <span class="required">
                                <strong>{{ $errors->first('average_fulfillment_time') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn green" id="submit_form">
                            {{@$kpi_info?__('_ecom__text.update'):__('_ecom__text.save')}}
                        </button>
                    </div>

                </form>


            </div>
        </div>
    </div>


@endsection