@if(!empty($check) && $check== 3)
    <option value="0">--উপজেলা--</option>
    @foreach($upazilla_tree as $each_location)
        <option value="{{$each_location['id']}}">{{$each_location['location_name']}}</option>
    @endforeach
@endif

@if(!empty($check) && $check== 2)
    <option value="0">--উপজেলা--</option>
    @foreach($upazilla_tree as $each_location)
        <option value="{{$each_location['id']}}">{{$each_location['location_name']}}</option>
    @endforeach
@endif

@if(!empty($check) && $check== 1)
    <option value="0">--জেলা--</option>
    @foreach($district_tree as $each_location)
        <option value="{{$each_location['id']}}">{{$each_location['location_name']}}</option>
    @endforeach
@endif