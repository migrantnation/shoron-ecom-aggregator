<form action="{{url("admin/product/save-variation")}}" method="post" enctype="multipart/form-data"
      name="addVariationForm" id="addVariationForm" novalidate="novalidate">
    {{csrf_field()}}
    <input type="hidden" name="product_id" id="product_id" value="{{@$product_info->id}}">
    <input type="hidden" name="product_url" id="product_url" value="{{@$product_info->product_url}}">

    <div class="row">
        @forelse($product_attributes as $value)
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{$value->attribute_name}} <span class="alert-required">* </span></label>
                    <input type="text" class="form-control error"
                           placeholder="New value for {{$value->attribute_name}} attribute"
                           name="attribute_value[{{$value->id}}]" value="" required="required" aria-required="true">
                    <span class="error">{{$errors->first('weight')}}</span>
                </div>
            </div>
        @empty
        @endforelse
    </div>

    <hr>

    <table class="table table-hover table-light">
        <thead>
        <tr>
            <th>Price <span class="alert-required">*</span></th>
            <th>Quantity <span class="alert-required">*</span></th>
            <th>Image <span class="alert-required">*</span></th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <input type="text" class="form-control numeric error" placeholder="Variation Price"
                name="variant_price" id="variant_price" value=""
                required="required" aria-required="true">
                <span class="error">{{$errors->first('weight')}}</span>
            </td>
            <td>
                <input type="text" class="form-control numeric error" placeholder="Variation Quantity" data-key=""
                       name="variant_quantity" id="variant_quantity" value=""
                       required="required" aria-required="true">
                <span class="error">{{$errors->first('variant_quantity')}}</span>
            </td>
            <td>
                <div class="slim" style="width: 100px; height: 100px; display: inline-block"
                     data-ratio="1:1"
                     data-size="400,400"
                     data-service="{{url('admin/upload-image')}}">
                    <input type="file" class="slim-image"/>
                </div>
                <span class="error">{{$errors->first('variant_quantity')}}</span>
            </td>
            <td>
                <input type="checkbox" data-off-text="Off" data-on-text="On" data-size="mini" checked="false" data-key="" class="BSswitch"
                       name="variant_required" id="variant_required" value="1"
                       required="required" aria-required="true">
                <span class="error">{{$errors->first('variant_required')}}</span>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        {{--<button type="button" class="btn btn-primary" id="save_variation">Save variation</button>--}}
        <button type="submit" id="sample_editable_1_new" class="btn purple">
            Save variation
        </button>
    </div>
</form>


