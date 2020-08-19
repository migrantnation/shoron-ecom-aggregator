{{--<label class="control-label">Variations</label>--}}
<div class="attribute">
    <div class="attr-header clearfix">
        <strong>Variations</strong>
    </div>
    <div class="attr-body">
        <div class="form-group">
            <table class="table table-hover table-light">
                <thead>
                <tr>
                    <th colspan="2">Variation</th>
                    <th class="text-center">Price</th>
                    {{--<th width="12%" class="text-center">SKU</th>--}}
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Image</th>
                    <th width="1%">Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($combined_data as $key=>$cd_value)
                    <tr>
                        <td>
                            @if(is_array(@$cd_value))
                                {{implode(' * ', $cd_value)}}
                                <input type="hidden" name="combinations[a-{{$key + 1}}]" value="{{implode(',',@$cd_value)}}" required>
                            @else
                                {{@$cd_value}}
                                <input type="hidden" name="combinations[a-{{$key + 1}}]" value="{{$cd_value}}" required>
                            @endif
                        </td>

                        <td>:</td>

                        <td>
                            <input type="text" class="form-control numeric error" placeholder="Price" name="variant_price[a-{{$key + 1}}]"
                                   value="" required="required" aria-required="true" id="variant_price-a-{{$key + 1}}">
                        </td>
                        <td>
                            <input type="text" class="form-control numeric error" placeholder="Quantity" data-key="-a{{$key + 1}}"
                                   name="variant_quantity[a-{{$key + 1}}]" required="required" aria-required="true" value="" id="variant_quantity-a-{{$key + 1}}">
                        </td>

                        <td class="text-center">
                            <div class="slim" style="width: 100px; height: 100px; display: inline-block"
                                 data-ratio="1:1"
                                 data-size="400,400"
                                 data-service="{{url('admin/upload-image')}}">
                                <input type="file" class="slim-image"/>
                            </div>
                        </td>

                        <td>
                            <input type="checkbox" data-size="mini" checked="false" data-key="a-{{$key + 1}}"
                                   class="BSswitch" name="variant_required[a-{{$key + 1}}]" id="variant_required-a-{{$key + 1}}" value="1">
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            {{'No variation found'}}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>