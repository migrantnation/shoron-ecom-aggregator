@extends('admin.layouts.master')
@section('content')
    {{--{{$ep_list}}--}}
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('admin')}}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>EP List</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">EP List &nbsp;&nbsp;
        <small></small>
        <a href="{{url('admin/add-ep')}}" class="btn btn-info">Add New &nbsp;&nbsp;<i class="fa fa-plus"></i></a>
    </h1>
    <!-- END PAGE TITLE-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">All E-commerce Partner(EP)</span>
                    </div>
                </div>

                <div class="portlet-body">

                    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $ep_list->count(), "from"=>  0, "to"=>$ep_list->count()])}}</span>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="20">#</th>
                            <th>EP Name</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th width="100">Status</th>
                            <th width="220">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; $status = ''; ?>
                        @forelse($ep_list as $ep)

                            <?php $status = $ep->status == 2 ? 'Activate' : 'Deactivate'; ?>

                            <tr id="{{$ep->id}}">
                                <td width="20"><?= $i ?></td>
                                <td>
                                    <a href="{{$ep->ep_url}}" target="_blank">{{$ep->ep_name}}</a>
                                </td>
                                <td>{{$ep->contact_number}}</td>
                                <td>{{$ep->email}}</td>
                                <td>{{$ep->address}}</td>
                                <td>
                                    <span class="status-{{@$ep->id}}">{{$ep->status == 2 ? 'Inactive' : 'Active'}}</span>
                                </td>

                                <td width="10%" class="text-left">
                                    <a href="{{url("admin/ep/$ep->id/orders")}}" class="btn green btn-xs">
                                        <i class="icon-diamond"></i> Order
                                    </a>
                                    <br>

                                    <a href="{{url("admin/edit-ep/$ep->id")}}" class="btn blue btn-xs">
                                        <i class="fa fa-pencil"></i> View
                                    </a>
                                    <br>
                                    <span class="status-text-{{@$ep->id}}">
                                        <a href="javascript:void(0)" class="btn blue btn-xs change-status"
                                           data-status="{{@$ep->status == 1 ? 2 : 1}}"
                                           data-epid="{{@$ep->id}}">{{@$status}}
                                        </a>
                                    </span>
                                    <br>
                                    <a href="javascript:;" class="btn red btn-xs"
                                       data-lp-url="{{$ep->ep_url}}" data-lp-id="{{$ep->id}}">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php $i++;?>
                        @empty
                            <tr>
                                <td colspan="6"><h3>E-commerce partner not found</h3></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--<script>--}}
    {{--var status;--}}
    {{--var epid;--}}
    {{--var obj;--}}
    {{--$(document).on("click", '.change-status', function (event) {--}}
    {{--status = $(this).data('status');--}}
    {{--epid = $(this).data('epid');--}}
    {{--$.ajax({--}}
    {{--url: "{{url('admin/ep/change-status/')}}" + '/' + epid + '/' + status,--}}
    {{--type: "get",--}}
    {{--dataType: 'json',--}}
    {{--success: function (html) {--}}
    {{--obj = JSON.parse(JSON.stringify(html));--}}
    {{--$(".status-" + epid).html(obj.status);--}}
    {{--$(".status-text-" + epid).html(obj.status_text);--}}
    {{--}--}}
    {{--});--}}
    {{--});--}}
    {{--</script>--}}

    <script>
        var status;
        var epid;
        var obj;

        $(document).on("click", '.change-status', function (event) {
            status = $(this).data('status');
            epid = $(this).data('epid');

            $.confirm({
                icon: 'fa fa-question',
                theme: 'material',
                content: 'Are you sure you want to change this EP status?',
                closeIcon: true,
                animation: 'scale',
                type: 'orange',
                title: 'Confirmation',
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function () {
                            $.ajax({
                                url: "{{url('admin/ep/change-status/')}}" + '/' + epid + '/' + status,
                                type: "get",
                                dataType: 'json',
                                success: function (html) {
                                    obj = JSON.parse(JSON.stringify(html));
                                    $(".status-" + epid).html(obj.status);
                                    $(".status-text-" + epid).html(obj.status_text);
                                    successToast("EP status has been changed successfully");
                                }
                            });
                        }
                    },
                    'cancel': {}
                }
            });
        });
    </script>

@endsection