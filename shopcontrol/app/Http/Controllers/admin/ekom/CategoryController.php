<?php

namespace App\Http\Controllers\admin\ekom;

use App\models\admin\ekom\Product;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\models\ProductCategory;
use App\models\CountryLocation;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /*
     * CATEGORY MANAGEMENT
     *
     * */

    public function add_category()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['product_management'] = 'start active';
        $data['product_category'] = 'active';

        $data['categories'] = ProductCategory::all()->toArray();
        //$data['categories'] = DB::table('product_categories')->get()->toArray();
        $data['category_tree'] = $this->buildTree($data['categories']);
        $locations = CountryLocation::all()->toArray();
        $data['location_tree'] = $this->commonbuildTree($locations);
        //$this->dumpVar($data['location_tree']);

        return view('admin.ekom.category_subcategory.add_edit_category')->with($data);
    }


    public $parent = 0;

    public function store_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        $parent_category_id = $request->parent_category_id;
        $category_name = $request->category_name;
        $type = 'add';
        $validator->after(function ($validator) use ($parent_category_id, $category_name, $type) {
            if ($this->checkExist($parent_category_id, $category_name, $type)) {
                $validator->errors()->add('category_name', 'ইতিমধ্যে এই শ্রেণী বিদ্যমান!');
            }
        });

        if ($validator->fails()) {
            return redirect('admin/add-category')->withErrors($validator)->withInput();
        } else {
            $category_data = new ProductCategory();
            $this->get_parents($request->parent_category_id);
            $category_data->main_parent = $this->parent;
            $category_data->category_name = $request->category_name ? $request->category_name : "";
            $category_data->parent_category_id = $request->parent_category_id ? $request->parent_category_id : 0;
            $category_data->description = $request->description ? $request->description : "";
            $category_data->display_in_home = $request->display_in_home ? $request->display_in_home : 0;
            $category_data->country_location_ids = $request->country_location_ids ? implode(',', $request->country_location_ids) : '';
            $category_data->category_url = $this->create_clean_url($request->category_name);
            //$this->dumpVar($category_data);
            $category_data->save();
            return redirect('admin/category-list');
        }
    }

    public function edit_category($id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['product_management'] = 'start active';
        $data['product_category'] = 'active';

        $data['categories'] = ProductCategory::all()->toArray();
        $data['category_info'] = ProductCategory::where('id', '=', $id)->first()->toArray();
        $data['category_tree'] = $this->buildTree($data['categories']);
        $locations = CountryLocation::all()->toArray();
        $data['location_tree'] = $this->commonbuildTree($locations);
        $data['category_locations'] = explode(',', $data['category_info']['country_location_ids']);
        //$this->dumpVar($data['category_info']);

        return view('admin.ekom.category_subcategory.edit_category')->with($data);
    }

    public function update_category(Request $request, $category_id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        $parent_category_id = $request->parent_category_id;
        $category_name = $request->category_name;

        $validator->after(function ($validator) use ($parent_category_id, $category_name, $category_id) {
            if ($this->checkExist($parent_category_id, $category_name, $category_id)) {
                $validator->errors()->add('category_name', 'ইতিমধ্যে এই শ্রেণী বিদ্যমান!');
            }
        });

        if ($validator->fails()) {
            return redirect('admin/edit-category' . '/' . $category_id)->withErrors($validator)->withInput();
        } else {
            $category_data = new ProductCategory();
            $category_data = ProductCategory::find($category_id);
            $this->get_parents($request->parent_category_id);
            $category_data->main_parent = $this->parent != $category_id ? $this->parent : 0;
            $category_data->category_name = $request->category_name ? $request->category_name : "";
            $category_data->description = $request->description ? $request->description : "";
            $category_data->display_in_home = $request->display_in_home ? $request->display_in_home : 0;
            $category_data->country_location_ids = $request->country_location_ids ? implode(',', $request->country_location_ids) : '';
            $category_data->category_url = $this->create_clean_url($request->category_name);
            if ($request->parent_category_id == $category_id) {
                $category_data->parent_category_id = $category_data->main_parent;
            } else {
                $category_data->parent_category_id = $request->parent_category_id ? $request->parent_category_id : 0;
            }
//            $this->dumpVar($category_id);
            $category_data->save();
            return redirect('admin/category-list');
        }
    }

    public function category_list($id = NULL)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['product_management'] = 'start active';
        $data['product_category'] = 'active';

        $data['location_tree'] = CountryLocation::where('parent_id', '=', 0)->get()->toArray();
        //$this->dumpVar($data['location_tree']);
        //= $this->commonbuildTree($locations);
        if ($id != NULL) {
            $data['category_list'] = ProductCategory::orderBy('position', 'asc')->get()->toArray();
            $data['category_list'] = $this->Tree($data['category_list'], $id);
            $data['parent_category_id'] = $id;
            //$this->dumpVar($data['category_list']);
        } else {
            $data['category_list'] = ProductCategory::orderBy('position', 'asc')->get()->toArray();
            $data['category_list'] = $this->Tree($data['category_list'], 0);
            $data['parent_category_id'] = 0;
        }

        return view('admin.ekom.category_subcategory.category_list')->with($data);
    }

    public $location_track = 0;

    public function get_category_ajax(Request $request)
    {
        $status = 200;
        $data = array();
        $query = ProductCategory::select();
        $tracking_array = array('1' => 'division', '2' => 'district', '3' => 'upazilla');
        $tree_array = array('1' => 'district_tree', '2' => 'upazilla_tree', '3' => 'store_tree');
        if ($request->tracking_id != 4) {
            $location_track = $tracking_array[$request->tracking_id];
            //$this->dumpVar($request->$location_track);
            $tree_track = $tree_array[$request->tracking_id];
            $data[$tree_track] = CountryLocation::where('parent_id', '=', $request->$location_track == 0 ? -1 : $request->$location_track)->get()->toArray();
            $data['check'] = $request->tracking_id;
            $location_view = view('admin.ekom.category_subcategory.location_ajax')->with($data)->render();
            $response['location_view'] = $location_view;
        }
        if (!empty($request->category_name))
            $query->where('category_name', "like", "%$request->category_name%");
        if (!empty($request->division) && $request->division != 0)
            $query->whereRaw("FIND_IN_SET($request->division,country_location_ids)");
        if (!empty($request->district) && $request->district != 0)
            $query->whereRaw("FIND_IN_SET($request->district,country_location_ids)");
        if (!empty($request->upazilla) && $request->upazilla != 0)
            $query->whereRaw("FIND_IN_SET($request->upazilla,country_location_ids)");
        $category_data['category_list'] = $query->orderBy('position', 'asc')->get()->toArray();
        $category_data['category_list'] = $this->Tree($category_data['category_list'], $request->parent_category_id);
        $category_view = view('admin.ekom.category_subcategory.category_list_ajax')->with($category_data)->render();
        $response['category_view'] = $category_view;
        $result = $this->json($status, $response);
        echo $result;
    }


    function get_parents($parent)
    {
        $sql = ProductCategory::where('id', '=', $parent)->get()->toArray();//"SELECT * FROM files WHERE parentID = ".$parent."";
        foreach ($sql as $main_parent) {
            $parent_id = $main_parent['id'];
            if ($main_parent['parent_category_id'] == '0') {
                $this->parent = $main_parent['id'];
            } else {
            }
            $this->get_parents($main_parent['parent_category_id']);
        }
    }

    function Tree(array $elements, $parentId)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_category_id'] == $parentId) {
                $children = $this->Tree($elements, $element['id']);
                if (@$children) {
                    $element['children'] = $children;
                    $total = 0;
                    foreach ($element['children'] as $value) {
                        $total += $value['total_child'];
                    }
                    $element['total_child'] = count(@$element['children']) + $total;
                } else {
                    $element['children'] = '';
                    $element['total_child'] = 0;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_category_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
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

    public function sorting_category(Request $request)
    {
        foreach ($_POST['arrayorder'] as $key => $value) {
            $update = DB::table('product_categories')
                ->where('id', $value)
                ->update(array('position' => $key));
        }
    }

    public function customize_category(Request $request, $category_id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['product_management'] = 'start active';
        $data['product_category'] = 'active';
        if ($request->customize_condition == 1) {
            $data['categories'] = ProductCategory::all()->toArray();
            $data['category_info'] = ProductCategory::where('id', '=', $category_id)->first()->toArray();
            $data['category_tree'] = $this->buildTree($data['categories']);
            $data['side_bar'] = 'ekom_side_bar';
            $data['menu'] = 'product-management';
            $data['sub_menu'] = 'category-list';
            return view('admin.ekom.category_subcategory.customize_category')->with($data);
        } else if ($request->customize_condition == 2) {
            $update_data = ProductCategory::find($category_id);
            $update_data->status = -1;
            $update = $update_data->save();
            if ($update) {
                return redirect('admin/category-list');
            }
        }
    }

    public function update_customize_category(Request $request, $category_id)
    {
        $validator = Validator::make($request->all(), [
            'parent_category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('admin/update-customize-category' . '/' . $category_id)->withErrors($validator)->withInput();
        } else {
            $category_data = ProductCategory::find($category_id);
            $product_info = Product::where('category_id', '=', $category_id)->get();
            if ($product_info->count() > 0) {
                foreach ($product_info as $each_product) {
                    $each_product->category_id = $request->parent_category_id;
                    $each_product->save();
                }
            }
            $category_data = new ProductCategory();
            $category_data = ProductCategory::find($category_id);
            $this->get_parents($request->parent_category_id);
            $category_data->main_parent = $this->parent != $category_id ? $this->parent : 0;
            if ($request->parent_category_id == $category_id) {
                $category_data->parent_category_id = $category_data->main_parent;
            } else {
                $category_data->parent_category_id = $request->parent_category_id ? $request->parent_category_id : 0;
            }
            $category_data->save();
            return redirect('admin/category-list');
        }
    }

    public function checkExist($parent_category_id, $category_name, $category_id = NULL)
    {
        $sub_categories = ProductCategory::where('parent_category_id', '=', $parent_category_id)
            ->where('category_name', '=', $category_name)
            ->first();

        if ($sub_categories->count() > 0 && $sub_categories->id != $category_id) {
            return true;
        } else {
            return false;
        }
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

    public function create_clean_url($str)
    {
        $string6 = '';
        //Lower case everything
        $string = strtolower($str);
        //Make alphanumeric (removes all other characters)
        $string1 = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string2 = preg_replace("/[\s-]+/", " ", $string1);
        //Convert whitespaces and underscore to dash
        $string3 = preg_replace("/[\s_]/", "-", $string2);
        $string4 = preg_replace("/[-]+/", "-", $string3);

        if (substr($string4, 0, 1) == "-") {
            $string5 = substr_replace($string4, '', 0, 1);
        } else {
            $string5 = $string4;
        }

        if (substr($string5, -1) == '-') {
            $string6 = substr_replace($string5, '', (strlen($string5) - 1), (strlen($string5)));
        } else {
            $string6 = $string5;
        }

        return $string6;
    }
}