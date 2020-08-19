<?php

namespace App\Http\Controllers\admin;

use App\models\CountryLocation;
use App\models\User;
use DB;
use App\models\Location;
use App\models\Udc;
//use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Validator;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function get_next_locations(Request $request)
    {
        $status = 100;
        $data = array();
        $location_name = $request->location_name;
        $location_type = $request->location_type;

        $location_list = array(
            'division' => 'district',
            'district' => 'upazila',
            'upazila' => 'union',
        );
        $index = array(
            'division' => 1,
            'district' => 2,
            'upazila' => 3,
        );
        $location_info = User::where($location_type, $location_name)->select($location_list[$location_type])->groupBy($location_list[$location_type])->get();
        if($location_info){
            $data['locations'] = $location_info;
            $data['level'] = $location_list[$location_type];
            $data['index'] = $index[$location_type];
            $data['view'] = view('admin.location._ajax')->with($data)->render();
//            dd($data['view']);
            $status = 200;
        }
//        $location_name = $request->location_name;
//        $location_info = CountryLocation::where('location_name', $location_name)->first();
//        if($location_info){
//            $data['locations'] = CountryLocation::where('parent_id', $location_info->id)->get();
//            $data['level'] = $location_info->tree_level;
//            $data['view'] = view('admin.location._ajax')->with($data)->render();
//            $status = 200;
//        }

        $result = $this->json($status, $data);
        echo $result;
    }

    private function json($status = NULL, $response = NULL)
    {
        echo json_encode(array('meta' => array('status' => $status), 'response' => $response));
    }

    function dumpVar($data)
    {
        echo "<pre>";
        print_r($data);
        exit();
    }
}