@if(@$notices->count() > 0)
    {{--    <span style="display: inline-block; margin-bottom: 10px;">{{__('_ecom__text.search-counts', ['total' => $kpi_list->total(), "from"=>  ($kpi_list->currentpage()-1)*$kpi_list->perpage()+1, "to"=>(($kpi_list->currentpage()-1)*$kpi_list->perpage())+$kpi_list->count()])}}</span>--}}

    <table class="table table-bordered table-hover">

        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="20%">{{__('_ecom__text.notice-message')}}</th>
            <th width="5%">{{__('_ecom__text.actions')}}</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $status_arr = array('1' => 'Active', '1' => 'Inactive');
        $page = 1;
        ?>
        @foreach(@$notices as $key => $notice)
            <tr>
                <td>{{$key+1}}</td>
                <td>{!! @$notice->notice_message!!}</td>

                <td width="10%" class="text-left">

                    <a href="{{url("admin/notice/$notice->id")}}"
                       class="btn green btn-xs edit">
                        <i class="fa fa-edit"></i>&nbsp;&nbsp;{{__('_ecom__text.edit')}}
                    </a>


                    @if($notice->status == 2)
                        <br>
                        <a href="{{url("admin/notice/change-notice-status/$notice->id/1")}}"
                           class="btn green btn-xs">
                            <i class="fa fa-check"></i>&nbsp;&nbsp;{{__('_ecom__text.activate')}}
                        </a>
                    @endif

                    @if($notice->status == 1)
                        <br>
                        <a href="{{url("admin/notice/change-notice-status/$notice->id/2")}}"
                           class="btn green btn-xs edit">
                            <i class="fa fa-close"></i>&nbsp;&nbsp;{{__('_ecom__text.deactivate')}}
                        </a>
                    @endif

                    <br>
                    <a href="{{url("admin/notice/delete/$notice->id")}}"
                       class="btn green btn-xs">
                        <i class="fa fa-trash"></i>&nbsp;&nbsp;{{__('_ecom__text.delete')}}
                    </a>

                </td>

            </tr>

            <?php $page++; ?>

        @endforeach
        </tbody>
    </table>

    <div class="text-right">
        {{--{!! @$kpi_list->render() !!}--}}
    </div>

@else
    <div class="alert alert-info">
        No data found
    </div>
@endif