<?php $location_type = array("", "জেলা", "উপজেলা", "ইউনিয়ন"); ?>

<option>--{{$location_type[$level+1]}}--</option>
@forelse($locations as $each_location)
    <option value="{{$each_location->location_name}}">{{$each_location->location_name}}</option>
@empty
    <option>No data found</option>
@endforelse