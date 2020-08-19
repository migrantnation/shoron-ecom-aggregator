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
                <span>{{__('_ecom__text.notice-list')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{__('_ecom__text.notice-list')}}
        <a href="{{url("admin/notice")}}" class="btn btn-default">Add new Notice</a>
    </h1>
    <!-- END PAGE TITLE-->



    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">{{__('_ecom__text.all-notice')}}</span>
                    </div>
                </div>

                <div class="portlet-body">

                    <div id="">

                        <div class="overlay-wrap">
                            <div class="anim-overlay">
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </div>
                        </div>

                        <div id="notice-list">
                            @include('admin.ekom.notice.notice-list')
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection