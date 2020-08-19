<div class="tab-pane active" id="tab_0">
    <div class="col-md-12">
        <div class="portlet box default">


            <?php
            $offer_type = array("All", "Active", "Warehouse Left", "On the Way", "Delivered", "Canceled");
            ?>
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users"></i> {{@$_GET['tab_id'] && @$_GET['tab_id'] != 'all' ? $order_type[$_GET['tab_id']] : 'All'}}
                    Orders
                </div>
            </div>

            <div class="portlet-body">

                <form action="javascript:;" class="table-toolbar" id="SubmitSearch">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="input-group date-picker input-daterange" data-date="2012-10-11"
                                 data-date-format="yyyy-mm-dd">

                                <input type="text" class="form-control" name="from" id="from"
                                       value="{{@$_GET['from'] ? @$_GET['from'] : ""}}">

                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="to" id="to"
                                       value="{{@$_GET['to'] ? @$_GET['to'] : ""}}">

                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_string"
                                           value="{{@$_GET['search_string'] ? @$_GET['search_string'] : ""}}">
                                    <span class="input-group-btn">
                                    <button class="btn blue" type="button" id="submit_search" onclick="ajaxpush();">
                                        <i class="fa fa-search"></i>
                                    </button>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $all_orders->total(), "from"=>  ($all_orders->currentpage()-1)*$all_orders->perpage()+1, "to"=>(($all_orders->currentpage()-1)*$all_orders->perpage())+$all_orders->count()])}}</span>

                <table class="table table-bordered table-hover">
                    <thead>

                    <tr>
                        <th width="20">#</th>
                        <th>Offer</th>
                    </tr>

                    </thead>

                    <tbody>

                    @forelse($all_orders as $key => $order)

                        <tr>
                            <td width="1%">{{$page}}</td>

                            <td width="5%"></td>

                            <td width="5%">

                                <a href="javascript:;"
                                   class="plx__btn_lg {{(@$offer->status == 1)?'change-status':'overlay'}}"
                                   data-id="{{$offer->id}}" data-status="2">
                                    <i class="fa fa-check"></i>
                                    <span>Active</span>
                                </a>

                                <a href="javascript:;"
                                   class="plx__btn_lg {{(@$offer->status == 1)?'change-status':'overlay'}}"
                                   data-id="{{$offer->id}}" data-status="2">
                                    <i class="fa fa-close"></i>
                                    <span>Inactive</span>
                                </a>

                            </td>

                        </tr>
                        <?php $page++; ?>
                    @empty
                        <tr>
                            <td colspan="8" align="center">No Orders Available</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="text-right">
    {!! $all_orders->render() !!}
</div>


<script>
    document.getElementById("SubmitSearch").onsubmit = function () {
        ajaxpush();
        return false;
    };


    var page = '{{@$_GET['page']?@$_GET['page']:1}}';

    $('.change-status').on('click', function () {

        var id = $(this).data('id');
        var status = $(this).data('status');

        var search_string = $('#search_string').val();
        var from = $('#from').val();
        var to = $('#to').val();

        $.confirm({
            icon: 'fa fa-question',
            theme: 'material',
            content: 'Are you sure you want to change this offer status?',
            closeIcon: true,
            animation: 'scale',
            type: 'orange',
            title: 'Confirmation',
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function () {

                        var data = {
                            order_code: id,
                            status: status,
                            _token: "{{csrf_token()}}",
                        }

                        $.ajax({
                            url: "{{url('admin/change-offer-status')}}",
                            type: "post",
                            dataType: 'json',
                            data: data,
                            success: function (response) {
                                if (response['meta']['status'] == 200) {
                                    successToast(response['response']['message']);
                                    ajaxpush();
                                    datePickerInit();
                                } else {
                                    warningToast(response['response']['message']);
                                }
                            }
                        });
                    }
                },
                'cancel': {}
            }
        });
    });


</script>