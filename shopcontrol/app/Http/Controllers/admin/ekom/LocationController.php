<?php

namespace App\Http\Controllers\admin\ekom;

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
        $status = 200;
        $data = array();
        $parent_id = $request->location_id;

        $location_info = CountryLocation::where('id', $parent_id)->first();
        $data['locations'] = CountryLocation::where('parent_id', $parent_id)->get();

        $data['level'] = $location_info->tree_level;
        $data['view'] = view('admin.ekom.location._ajax')->with($data)->render();

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