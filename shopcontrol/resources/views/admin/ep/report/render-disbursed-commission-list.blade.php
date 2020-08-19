<div class="row" style="margin-right: 15px;">
    <div class="col-md-7"></div>
    <div class="col-md-5 ">
        <div class="form-group">
            <div class="input-group">
                <input placeholder="" type="text" class="form-control" id="search_string" value="{{@$_GET['search_string']}}">
                <span class="input-group-btn">
                                <button class="btn blue" type="button" id="submit_search" onclick="ajaxpush();"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane active" id="tab_0">
    <div class="col-md-12">
        <div class="portlet box default">

            <div class="portlet-body">
                <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $disbursed_commission_list->total(), "from"=>  ($disbursed_commission_list->currentpage()-1) * $disbursed_commission_list->perpage()+1, "to"=>(($disbursed_commission_list->currentpage()-1) * $disbursed_commission_list->perpage()) + $disbursed_commission_list->count()])}}</span>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="1%">#</th>
                        <th width="15%">UDC Name</th>
                        <th width="15%">Contact Number</th>
                        <th width="5%">EP Name</th>
                        <th width="20%" class="text-center">Disbursed Amount</th>
                        <th width="10%" class="text-center">Disbursed Date</th>
                        <th width="10%" class="text-center">Selected Month</th>
                        <th width="18%" class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($disbursed_commission_list as $key => $each_disbursed)

                        <tr id="">
                            <td width="1%">{{$page}}</td>
                            <td width="15%">
                                {{$each_disbursed->udc->name_bn}}
                            </td>
                            <td width="2%">
                                {{$each_disbursed->udc->contact_number}}
                            </td>
                            <td width="10%">
                                {{$each_disbursed->ep_info->ep_name}}
                            </td>
                            <td width="10%" class="text-center">{{__('_ecom__text.tk.')}}{{number_format(@$each_disbursed->amount, 2)}}</td>

                            <td width="25%" class="text-center">
                                {{date('M d, Y', strtotime($each_disbursed->created_at))}}<br>
                            </td>

                            <td width="25%" class="text-center">
                                {{date('F', strtotime($each_disbursed->disbursement_from_date))}}<br>
                            </td>

                            <td width="5%" class="text-center">
                                <a class="btn btn-info" href="{{url('ep/disburesement-invoice/'. $each_disbursed->id)}}"><i class="fa fa-eye"> </i> Invoice</a>
                            </td>

                        </tr>
                        <?php $page++; ?>
                    @empty
                        <tr>
                            <td colspan="8" align="center">No Disbursement Available</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 text-right">
        {!! @$disbursed_commission_list->render() !!}
    </div>

</div>