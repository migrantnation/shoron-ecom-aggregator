<?php
if(!empty($lp_list)){
?>
<span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => @$lp_list->total(), "from"=>  (@$lp_list->currentpage()-1)*@$lp_list->perpage()+1, "to"=>((@$lp_list->currentpage()-1)*@$lp_list->perpage())+@$lp_list->count()])}}</span>
<?php
}
?>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="20">#</th>
        <th>LP Name</th>
        <th>Contact No</th>
        <th>Email</th>
        <th>Address</th>
        <th width="100">Status</th>
        <th width="220">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; $status = ''; ?>
    @forelse($lp_list as $lp)

        <?php $status = $lp->status == 2 ? 'Activate' : 'Deactivate'; ?>

        <tr id="{{$lp->id}}">
            <td width="20"><?= $i ?></td>

            <td>
                <a href="javascript:;">{{$lp->lp_name}}</a>
            </td>

            <td>{{$lp->contact_number}}</td>

            <td>{{$lp->email}}</td>
            <td>{{$lp->address}}</td>
            <td>
                <span class="status-{{@$lp->id}}">{{$lp->status == 2 ? 'Inactive' : 'Active'}}</span>
            </td>

            <td width="10%" class="text-left">
                <a href="{{route("admin.lp.orders",$lp->id)}}" class="btn green btn-xs">
                    <i class="icon-diamond"></i> Order
                </a>
                <br>

                <a href="{{route("admin.lp.edit",$lp->id)}}" class="btn blue btn-xs">
                    <i class="fa fa-pencil"></i> Edit
                </a>
                <br>

                <span class="status-text-{{@$lp->id}}">
                <a href="javascript:void(0)" class="btn blue btn-xs change-status"
                   data-status="{{@$lp->status == 1 ? 2 : 1}}"
                   data-lpid="{{@$lp->id}}">{{@$status}}
                </a>
                </span>
                <br>

                <a href="javascript://;" class="btn red btn-xs delete"
                   data-href="{{route('admin.lp.delete',$lp->id)}}">
                    <i class="fa fa-trash-o"></i> Delete
                </a>

                <a href="{{url("admin/lp/packages/$lp->id")}}" class="btn yellow btn-xs">
                    Distribute Package
                </a>

            </td>
        </tr>
        <?php $i++;?>
    @empty
        <tr>
            <td colspan="6"><h3>{{__('admin_text.no-result')}}</h3></td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="text-right">
    {!! $lp_list->render() !!}
</div>