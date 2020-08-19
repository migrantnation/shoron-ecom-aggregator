<div class="col-lg-12 col-xs-12 col-sm-12" style="position: relative; margin-top: 25px">
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-red-sunglo hide"></i>
                <span class="caption-subject text-primary bold uppercase">Sales Overview of All</span>
            </div>
        </div>
        <div class="portlet-body">
            <canvas id="salesChart"
                    data-labels='[{{@$chart_labels}}]'
                    data-values="[{{@$chart_sale_values}}]"
                    height="420"></canvas>
        </div>
    </div>

    <div class="portlet light">

        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share text-info hide"></i>
                <span class="caption-subject text-info bold uppercase">Sales list of All</span>
                {{--<span class="caption-helper"></span>--}}
            </div>
            <div class="actions">
                <form class="form-inline pull-right">
                    <div class="input-group">
                        {{--<input type="text" class="form-control" id="search_string"--}}
                               {{--value="{{@$_GET['search_string'] ? @$_GET['search_string'] : ""}}">--}}
                        {{--<span class="input-group-btn">--}}
                        {{--<button class="btn blue" type="button" id="submit_search" onclick="ajaxpush();">--}}
                            {{--<i class="fa fa-search"></i>--}}
                        {{--</button>--}}
                    </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="portlet-body" id="ep_orders">
            @include('admin.ekom.reports.render_sales_list')
        </div>

        <div id="loader" class="loader-overlay">
            <div class="loader">Loading...</div>
        </div>
    </div>
</div>
