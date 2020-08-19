<div class="col-lg-12 col-xs-12 col-sm-12" style="position: relative; margin-top: 25px">
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject text-info bold uppercase">Orders Overview of Active</span>
                {{--<span class="caption-helper"></span>--}}
            </div>
        </div>
        <div class="portlet-body">
            <canvas id="orderChart"
                    data-labels='[{{@$chart_labels}}]'
                    data-values="[{{@$chart_order_values}}]"
                    data-sale="[{{@$chart_sale_values}}]"
                    height="300"></canvas>
        </div>
    </div>

    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject  text-info bold uppercase">List of Active Orders</span>
                {{--<span class="caption-helper"></span>--}}
            </div>
            <div class="actions">
                <form class="form-inline pull-right">
                    {{--<div class="form-group">--}}
                        {{--<input type="search" class="form-control" placeholder="Search" name="search_string"--}}
                               {{--id="search_string">--}}
                    {{--</div>&nbsp;&nbsp;--}}
                    {{--<button type="button" class="btn btn-info"><i class="fa fa-search"></i></button>--}}
                </form>
            </div>
        </div>
        <div class="portlet-body" id="ep_orders">
            @include('admin.ekom.reports.render_order_list')
        </div>
    </div>


    <div id="loader" class="loader-overlay">
        <div class="loader">Loading...</div>
    </div>
</div>