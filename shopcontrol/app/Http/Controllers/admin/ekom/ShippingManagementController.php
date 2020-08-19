<?php

namespace App\Http\Controllers\admin\ekom;

use App\models\LogisticPartner;
use App\models\LpShippingPackage;
use App\models\PackageWeightPrice;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\CountryLocation;

class ShippingManagementController extends Controller
{
    public function add_shipping_package($lp_url)
    {
        $data = array('menu' => '', 'side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'lp_management' => 'start active open');

        $data['lp_info'] = $lp_info = LogisticPartner::where('lp_url', '=', $lp_url)->first();

        //$data['product_category'] = 'active';
        $locations = CountryLocation::all()->toArray();
        $data['prev_location'] = LpShippingPackage::where('lp_id', '=', 1)// LP ID WILL BE THE SESSION LP USER ID
        ->select(DB::raw('group_concat(to_city_ids) as to_city_ids'))
            ->get()
            ->first();
        //$this->dumpVar($data['prev_location']);
        $data['location_tree'] = $this->commonbuildTree($locations);
        $data['city_list'] = CountryLocation::where('parent_id', '=', 0)->get();


        if (old("from_city_id")) {
            $data['locations'] = CountryLocation::all()->toArray();
            $data['location_tree'] = $this->commonbuildTree($locations);
            $data['prev_location'] = LpShippingPackage::where('lp_id', '=', 1)// LP ID WILL BE THE SESSION LP USER ID
            ->where('from_city_id', '=', old("from_city_id"))
                ->select(DB::raw('group_concat(to_city_ids) as to_city_ids'))
                ->get()
                ->first();
        }

        return view('admin.ekom.lp.shippings.add_shipping_package')->with($data);
    }

    public function store_package(Request $request, $lp_url)
    {
        $rules = array(
            'package_name' => 'required',
            'from_city_id' => 'required',
            'to_city_ids' => 'required',
            'min_weight.*' => 'required',
            'max_weight.*' => 'required',
            'price.*' => 'required'
        );

        $messages = array('to_city_ids.required' => 'Please select at least one above locaiton');
        $validator = Validator::make($request->all(), $rules, $messages);

        $package_name = $request->package_name;
        $lp_id = 1;
        $validator->after(function ($validator) use ($package_name, $lp_id) {
            if ($this->checkpackagename($package_name, $lp_id)) {
                $validator->errors()->add('package_name', 'Package name already exist!');
            }
        });

        if ($validator->fails()) {
            return redirect("admin/lp/add-shipping-package/$lp_url")->withErrors($validator)->withInput();
        } else {
            $package_data = new LpShippingPackage();
            $package_data->package_name = $request->package_name ? $request->package_name : "";
            $package_data->from_city_id = $request->from_city_id ? $request->from_city_id : "";
            $package_data->to_city_ids = $request->to_city_ids ? implode(',', $request->to_city_ids) : "";
            $package_data->lp_id = 1; // LP ID WILL BE THE SESSION LP USER ID
            $package_data->save();

            // PACKAGE WEIGHT PRICE TABLE
            $min_weight = $request->min_weight;
            $max_weight = $request->max_weight;
            $price = $request->price;
            foreach ($min_weight as $key => $value) {
                //CREATE PACKAGE WEIGHT PRICE TABLE INSTANCE
                $package_weight_data = new PackageWeightPrice();

                // SET DATA AND SAVE
                $package_weight_data->min_weight = $value;
                $package_weight_data->max_weight = $max_weight[$key];
                if ($min_weight > $max_weight) {
                    $package_weight_data->min_weight = $max_weight;
                    $package_weight_data->max_weight = $min_weight;
                }
                $package_weight_data->price = $price[$key];
                $package_weight_data->package_id = $package_data->id;
                $package_weight_data->save();
            }

            return redirect("admin/lp/package-list/$lp_url");
        }
    }

    public function edit_package($lp_url, $package_id)
    {
        $data = array('menu' => '', 'side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'lp_management' => 'start active open');

        $data['lp_info'] = $lp_info = LogisticPartner::where('lp_url', '=', $lp_url)->first();
        $data['package_info'] = $package_info = LpShippingPackage::with(['get_weight_price'])->where('id', '=', $package_id)->first();

        $locations = CountryLocation::all()->toArray();
        $data['location_tree'] = $this->commonbuildTree($locations);
        $data['city_list'] = CountryLocation::where('parent_id', '=', 0)->get();


        /*
         * GET LOCATIONS FROM OTHER PACKAGES
         * */
        $data['prev_location'] = LpShippingPackage::where('lp_id', '=', $lp_info->id)
            ->select(DB::raw('group_concat(to_city_ids) as to_city_ids'))
            ->get()->first();

        if (old("from_city_id")) {
            $data['prev_location'] = LpShippingPackage::where('lp_id', '=', $lp_info->id)
                ->where('id', '!=', $package_info->id)
                ->where('from_city_id', '=', old("from_city_id"))
                ->select(DB::raw('group_concat(to_city_ids) as to_city_ids'))
                ->get()
                ->first();
        } else {
            $data['prev_location'] = LpShippingPackage::where('lp_id', '=', $lp_info->id)
                ->where('id', '!=', $package_info->id)
                ->where('from_city_id', '=', $package_info->from_city_id)
                ->select(DB::raw('group_concat(to_city_ids) as to_city_ids'))
                ->first();
        }

//        echo $lp_info->id.'<br>';
//        echo $package_info->id.'<br>';
//        echo $package_info->from_city_id.'<br>';
//        echo $package_info->to_city_ids.'<br>';
//
//        dd($data['prev_location']->to_city_ids);

        return view('admin.ekom.lp.shippings.add_shipping_package')->with($data);
    }

    public function package_list($lp_url)
    {
        $data = array('menu' => '', 'side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'lp_management' => 'start active open');

        $data['lp_info'] = $lp_info = LogisticPartner::where('lp_url', '=', $lp_url)->first();

        $data['package_list'] = $package_info = LpShippingPackage::with(['get_weight_price'])->where('lp_id', '=', 1)->get();

        return view('admin.ekom.lp.shippings.lp_packages')->with($data);
    }

    public function get_location_by_city_id(Request $request)
    {
        $status = 200;
        $data = array();
        $locations = CountryLocation::all()->toArray();
        $location_tree = $this->commonbuildTree($locations);

        $prev_location = LpShippingPackage::where('lp_id', '=', 1)// LP ID WILL BE THE SESSION LP USER ID
        ->where('from_city_id', '=', $request->city_id)
            ->select(DB::raw('group_concat(to_city_ids) as to_city_ids'))
            ->get()
            ->first();
        $location_view = $this->show_tree_access($location_tree, 1, $prev_location->to_city_ids);
        echo $location_view;
    }

    function show_tree_access($location_tree, $child_counter = 1, $prev_city_ids)
    {
        $prev_city_arr = explode(',', $prev_city_ids);
        foreach ($location_tree as $key => $value) {
            $this_id = $value['id'];
            if (in_array($this_id, $prev_city_arr)) {
                $check_result = "checked='true' disabled='true' class='click-disabled'";
                $checked_text = " <i style='color'>Location Already In Another Shipping Package</i> ";
                $checked_opacity = "class='checked_opacity'";
            } else {
                $check_result = '';
                $checked_text = '';
                $checked_opacity = '';
            }
            echo '<li id="l' . $value['id'] . '">';
            echo '<input type="checkbox" name="to_city_ids[]" value=" ' . $value['id'] . '" ' . @$check_result . '> <label ' . $checked_opacity . '>' . $value['location_name'] . $checked_text . '</label>';
            if (!empty($value['children'])) {
                echo '<ul>';
                $this->show_tree_access($value['children'], $value['id'], $prev_city_ids);
                echo '</ul>';
            }
            echo '</li>';
            $child_counter++;
        }
    }

    function commonbuildTree(array $elements, $parentId = 0)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->commonbuildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public function checkpackagename($package_name, $lp_id)
    {
        $checkpackagename = LpShippingPackage::where('package_name', '=', $package_name)
            ->where('lp_id', '=', $lp_id)
            ->first();
        if ($checkpackagename) {
            return true;
        } else {
            return false;
        }
    }
}