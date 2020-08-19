<?php
$location_type = array(
    "district" => "জেলা",
    "upazila" => "উপজেলা",
    "union" => "ইউনিয়ন"
);
?>
<option value="">--{{$location_type[$level]}}--</option>
@forelse($locations as $each_location)
    @if($each_location[$level])
        <option value="{{$each_location[$level]}}">{{$each_location[$level]}}</option>
    @endif
@empty
    <option>No data found</option>
@endforelse