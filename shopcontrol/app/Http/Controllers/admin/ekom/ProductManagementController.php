<?php

namespace App\Http\Controllers\admin\ekom;

use App\Libraries\FileProcessing;
use App\Libraries\PlxUtilities;
use App\models\Brand;
use App\models\ProductAttribute;
use App\models\ProductCategory;
use App\models\CountryLocation;
use App\models\Udc;
use App\models\Store;
use App\models\Product;
use App\models\ProductAttributeValue;
use App\models\ProductDetail;
use Illuminate\Support\Facades\View;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ProductManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($udc_id)
    {
        $data = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'udc_management' => 'start active open');

        $data['udc_id'] = $udc_id;
        $data['udc_info'] = $udc_info = Udc::find($udc_id);
        if (@$data['udc_info']) {
            $data['product_list'] = DB::table('products as p')
                ->leftjoin('product_categories as pc', 'pc.id', '=', 'p.category_id')
                ->select('p.*', 'pc.category_name', 'pc.id as cid')
                ->where('store_id', @$udc_info->store_id)
                ->get();
            foreach ($data['product_list'] as $p_value) {
                $p_value->inventory_total = DB::table('products as p')
                    ->leftjoin('product_details as pd', 'pd.product_id', '=', 'p.id')
                    ->select('*')->where('pd.product_id', '=', $p_value->id)
                    ->sum('pd.quantity');
            }
            return view('admin.ekom.udc.product.udc_product_list')->with($data);
        } else {
            return redirect()->route('udc_list');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($udc_id)
    {
        $data = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'udc_management' => 'start active open');

        $data['udc_id'] = $udc_id;

        $data['udc_info'] = $udc_info = DB::table('udcs')->where('id', '=', $udc_id)->first();

        if (@$udc_info) {
            // CATEGORY BASED ON LOCATION ADDRESS ACCESS CONTROL SYSTEM
            // IF STORE LOCATION AND CATEGORY LOCATION IS MATCHED
            $data['categories'] = ProductCategory::whereRaw("FIND_IN_SET('" . $data['udc_info']->location_id . "', country_location_ids)")
                ->where('status', '=', '1')->get()->toArray();
            // BUILD SELECTED CATEGORY TREE
            $data['category_tree'] = $this->buildTree($data['categories']);
            $data['category_id'] = @old("category_id") ? old("category_id") : @$data['categories'][0]->id;
            $this->get_parents($data['category_id']);
            $data['main_parent'] = $this->parent;

            $data['brand_list'] = Brand::get();

            return view('admin.ekom.udc.product.add_product')->with($data);
        } else {
            return redirect()->route('udc_list');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function get_sub_category(Request $request)
    {
        $sub_categories = DB::table('product_sub_categories')
            ->where('category_id', '=', $request->category_id)
            ->get();
        $option_arry = array();

        foreach (@$sub_categories as $each_sub) {
            $option_arry[] = "<option value='" . $each_sub->id . "'> " . $each_sub->sub_category_name . "</option>";
        }

        return implode('', $option_arry);
    }

    public function store(Request $request)
    {
        $util = new PlxUtilities();
        $regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'short_description' => 'max:160',
            'description' => '',
            'product_specification' => '',
            'category_id' => 'required|numeric',
            'base_price' => array('required', 'regex:' . $regex),
            'compare_price' => array(),
            'weight' => array('required', 'regex:' . $regex),
            'quantity' => 'required|numeric',
            'udc_id' => 'required|numeric',
        ]);

        $base_price = $request->base_price;
        $compare_price = $request->compare_price;
        $validator->after(function ($validator) use ($base_price, $compare_price) {
            if ($this->checkComparePrice($base_price, $compare_price) == false) {
                $validator->errors()->add('compare_price', 'Compare price can not be less then base price');
            }
        });

        if ($validator->fails()) {
            return redirect('admin' . '/' . $request->udc_id . '/product/create')->withErrors($validator)->withInput();
        } else {
            $data['udc_info'] = $udc_info = Udc::with(['store'])->find($request->udc_id);

            if (@$data['udc_info']) {

                $product_data = new Product();
                $product_data->product_name = $request->product_name;
                $product_data->short_description = $request->short_description;
                $product_data->description = $request->description;
                $product_data->product_specification = $request->product_specification;
                $product_data->category_id = $request->category_id;
                $product_data->brand_id = $request->brand_id;
                $product_data->product_url = $util->create_clean_url($product_data->product_name) . rand(1111, 99999);
                $product_data->base_price = $request->base_price;
                $product_data->compare_price = $request->compare_price ? $request->compare_price : "0";
                $product_data->base_sku = 'sk-' . rand(11111, 9999) . '-U' . rand(11, 99);
                $product_data->weight = $request->weight;
                $product_data->quantity = $request->quantity;
                $product_data->store_id = $udc_info->store_id ? $udc_info->store_id : "";
                $product_data->store_name = $udc_info->store_name ? $udc_info->store_name : "";
                $product_data->store_url = $udc_info->store_url ? $udc_info->store_url : "";

                if (!empty($request->slim)) {
                    $files = $request->slim;
                    //IMAGE PATH DIRECTORY
                    $image_dir = 'public/content-dir/stores/' . $udc_info->store->store_url . '/products/' . $product_data->product_url . '/';

                    //CREATE PRODUCT IMAGE DIRECTORY
                    if (!is_dir($image_dir)) {
                        $file_processing = new FileProcessing();
                        $file_processing->create_folder(array("folder_path" => $image_dir));
                    }
                    foreach ($files as $fv) {
                        if (@$fv) {
                            $image_data = json_decode($fv);
                            $image_path = $image_data->path;
                            $path_info = pathinfo($image_data->path);
                            if (is_file($image_path)) {

                                $file_name = 'product-image-' . date("ymdHis");

                                $product_data->product_image = $file_name . '.' . $path_info['extension'];

                                // SAVE ORIGINAL IMAGE
                                copy($image_path, $image_dir . $product_data->product_image);

                                // CREATE THUMB IMAGE
                                $product_data->product_image_thumb = $product_image_thumb = $file_name . '-thumb.' . $path_info['extension'];
                                copy($image_path, $image_dir . $product_image_thumb);
                                //RESIZE IMAGE
                                $file_processing = new FileProcessing();
                                $file_processing->smart_resize_image($image_dir . $product_image_thumb,
                                    $string = null,
                                    $width = 50,
                                    $height = 50,
                                    $proportional = false,
                                    $output = $image_dir . $product_image_thumb,
                                    $delete_original = true,
                                    $use_linux_commands = false,
                                    $quality = 100);

                                // CREATE ROUND IMAGE
                                $original_path = $image_dir . $product_image_thumb;
                                $destination_path = $image_dir . '/' . $file_name . '-round.' . $path_info['extension'];
                                $file_processing->convert_image_to_round($original_path, $destination_path);
                                //$product_data->product_image_round = $file_name . '-round.' . $path_info['extension'];
                                unlink($image_path);
                            }
                        }
                    }
                }

                $product_data->save();

                return redirect("admin/$request->udc_id/product/$product_data->product_url/manage-product-attribute/");
            } else {
                return redirect()->route('udc_list');
            }
        }
    }

    /**
     * @param $base_price
     * @param $compare_price
     * @return bool
     */
    public function checkComparePrice($base_price, $compare_price)
    {
        if ($compare_price && $base_price > $compare_price) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $udc_id
     * @param $product_url
     * @return mixed
     */
    public function manage_product_attribute($udc_id, $product_url)
    {
        $data = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'udc_management' => 'start active open');

        $data['udc_id'] = $udc_id;
        $data['udc_info'] = $udc_info = Udc::with(['store'])->find($udc_id);
        if (@$data['udc_info']) {
            $data['product_info'] = $product_data = Product::where('product_url', '=', $product_url)->first();
            $product_id = $product_data->id;

            if (!@$data['product_info']) {
                return redirect("admin/$udc_id/product");
            }
            $data['product_attributes'] = ProductAttribute::where('product_id', '=', $product_id)->get();

            if ($data['product_attributes']) {
                foreach ($data['product_attributes'] as $attribute_value) {
                    $attribute_value->values = ProductAttributeValue::where('product_attribute_id', '=', $attribute_value->id)->get();
                    $attribute_value->variations = ProductDetail::where('product_id', '=', $product_id)->get();
                }
            }

            return view('admin.ekom.udc.product.manage_product_attribute')->with($data);
        } else {
            return redirect()->route('udc_list');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function get_attribute_variations(Request $request)
    {
        $data = Array();
        $attribute_names = $request->attribute_name;
        $attribute_values = $request->attribute_values;
        $attr_val = array();
        foreach ($attribute_values as $value) {
            $exploded = explode(',', $value);
            $exploded = array_combine(range(1, count($exploded)), $exploded);
            $attr_val[] = $exploded;
        }
        $combined_data = $this->combinations($attr_val);
        $data['combined_data'] = $combined_data;

        $view = View::make('admin.ekom.udc.product.variations', $data);
        $contents = $view->render();
        echo $contents;
    }

    public function combinations($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        $tmp = $this->combinations($arrays, $i + 1);

        $result = array();
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ? array_merge(array($v), $t) : array($v, $t);
            }
        }

        return $result;
    }

    function validateVariation($variant_price)
    {
        if (@empty($variant_price)) {
            print_r($variant_price);
            exit();
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * @param Request $request
     * @param $product_url
     * @return mixed
     */
    public function store_product_attribute(Request $request, $product_url)
    {
        $data['store_info'] = $store_info = Store::with(['udc'])->where('store_url', '=', $request->store_url)->first();
        $product_url = $request->product_url;

        $product_data = Product::where('product_url', '=', $product_url)->first();
        $product_id = $product_data->id;
        $product_url = $product_data->product_url;

        if (!@$product_data) {
            return redirect("admin/" . $store_info->udc->id . "/product");
        }

        // SET FORM VALIDATION RULES
        $float_regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
        $variant_required = $request->variant_required;

        if (@$request->attribute_name) {
            if (@$request->variant_price) {
                foreach ($request->variant_price as $key => $val) {
                    if (!empty(@$variant_required)) {
                        if (@$variant_required[$key] == 1) {
                            $rules['variant_price.' . $key] = array('required', 'regex:' . $float_regex);
                            $rules['variant_quantity.' . $key] = array('required', 'numeric');
                        }
                    }
                }
            } else {
                $rules['variant_price'] = array('required');
                $rules['variant_quantity'] = array('required');
            }
        }

        $rules['attribute_name.*'] = 'required';
        $rules['attribute_value.*'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $variant_price = $request->variant_price;
        $validator->after(function ($validator) use ($variant_price) {
            if ($this->validateVariation($variant_price) == false) {
                $validator->errors()->add('variant_price', 'Please Enter variation price data');
                $validator->errors()->add('variant_quantity', 'Please Enter variation quantity data');
            }
        });

        // VALIDATION CHECK AND TAKE ACTIONS
        if ($validator->fails()) {
            return redirect("admin" . "/" . $store_info->udc->id . "/product/$product_url/manage-product-attribute/")
                ->withErrors($validator)->withInput();
        } else {
            $attribute_names = $request->attribute_name;
            $attribute_values = $request->attribute_values;
            if ($attribute_names[0] != null) {
                //SAVE ATTRIBUTE NAME AND VALUE
                foreach ($attribute_names as $key => $an_value) {
                    $attribute_data = ['product_id' => $product_id, 'attribute_name' => $an_value, 'position' => $key + 1];
                    $attribute_id = DB::table('product_attributes')->insertGetId($attribute_data);
                    $attr_vals = explode(',', $attribute_values[$key]);
                    foreach ($attr_vals as $key => $av_val) {
                        $product_attribute_values = new ProductAttributeValue;
                        $product_attribute_values->product_id = $product_id;
                        $product_attribute_values->product_attribute_id = $attribute_id;
                        $product_attribute_values->value = $av_val;
                        $product_attribute_values->position = $key + 1;
                        $product_attribute_values->save();
                    }
                }

                $variant_required = $request->variant_required;
                $combinations = $request->combinations;
                $variant_price = $request->variant_price;
                $variant_quantity = $request->variant_quantity;

                //IMAGE PATH DIRECTORY
                $image_dir = 'public/content-dir/stores/' . $store_info->store_url . '/products/' . $product_data->product_url . '/';

                //CREATE PRODUCT IMAGE DIRECTORY
                if (!is_dir($image_dir)) {
                    $file_processing = new FileProcessing();
                    $file_processing->create_folder(array("folder_path" => $image_dir));
                }

                // SAVE EACH PRODUCT VARIATIONS AND **UPDATE PRODUCT QUANTITY**
                $total_quantity = 0;
                $i = 0;
                $files = $request->slim;
                foreach ($combinations as $key => $c_value) {
                    $Product_detail = new ProductDetail;

                    if (@$files[$i]) {
                        $image_data = json_decode($files[$i]);
                        $image_path = $image_data->path;
                        $path_info = pathinfo($image_data->path);
                        if (is_file($image_path)) {
                            $file_name = 'product-image-' . $i . '-' . date("ymdHis");

                            $Product_detail->image = $file_name . '.' . $path_info['extension'];

                            // SAVE ORIGINAL IMAGE
                            copy($image_path, $image_dir . $Product_detail->image);

                            // CREATE THUMB IMAGE
                            $Product_detail->image_thumb = $image_thumb = $file_name . '-thumb.' . $path_info['extension'];
                            copy($image_path, $image_dir . $image_thumb);
                            //RESIZE IMAGE
                            $file_processing = new FileProcessing();
                            $file_processing->smart_resize_image($image_dir . $image_thumb,
                                $string = null,
                                $width = 50,
                                $height = 50,
                                $proportional = false,
                                $output = $image_dir . $image_thumb,
                                $delete_original = true,
                                $use_linux_commands = false,
                                $quality = 100);

                            unlink($image_path);
                        }
                    }
                    $i++;
                    $Product_detail->product_id = $product_id;
                    $Product_detail->combinations = $combinations[$key];
                    $Product_detail->sku = 'sk-' . rand(11111, 9999) . '-U' . rand(11, 99);
                    $Product_detail->price = $variant_price[$key];
                    $Product_detail->quantity = $variant_quantity[$key];
                    $Product_detail->status = @$variant_required[$key] ? @$variant_required[$key] : 0;
                    $Product_detail->save();

                    if (@$variant_required[$key]) {
                        $total_quantity += $Product_detail->quantity;
                    }
                }

                //UPDATE PRODUCT QUANTITY
                $product_data->quantity = $total_quantity;
                $product_data->save();
            }
            return redirect("admin" . "/" . $store_info->udc->id . "/product");
        }
    }

    public function add_variation(Request $request)
    {
        $data = array();
        $product_id = $request->product_id;
        $product_url = $request->product_url;

        $data['product_info'] = $product_data = Product::where('product_url', '=', $product_url)->first();
        $data['product_attributes'] = ProductAttribute::where('product_id', '=', $product_id)->get();

        echo View::make('admin.ekom.udc.product.add_variation', $data);
    }

    public function save_variation(Request $request)
    {
        //dd($request);
        $product_id = $request->product_id;
        $product_url = $request->product_url;
        $data['product_info'] = $product_info = Product::where('id', '=', $product_id)->first();
        $data['udc_info'] = $udc_info = Udc::where('store_id', '=', $product_info->store_id)->first();
        $data['store_info'] = $store_info = Store::where('id', '=', $product_info->store_id)->first();
        $data['product_attributes'] = ProductAttribute::where('product_id', '=', $product_id)->get();
        $data['product_details'] = $product_all_details = ProductDetail::where('product_id', '=', $product_id)->get();

        // SET FORM VALIDATION RULES
        $float_regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
        $rules['variant_price'] = array('required', 'regex:' . $float_regex);
        $rules['variant_quantity'] = array('required', 'regex:' . $float_regex);
        $rules['attribute_value.*'] = 'required';

        $validator = Validator::make($request->all(), $rules);

        // VALIDATION CHECK AND TAKE ACTIONS
        if ($validator->fails()) {
            return redirect("admin" . "/" . $udc_info->id . "/product/$product_info->id/manage-product-attribute/")
                ->withErrors($validator)->withInput();
        } else {
            $attribute_value = $request->attribute_value;

            $arr = array();
            $last_posision = count($data['product_attributes']);
            foreach ($data['product_attributes'] as $value) {
                $product_attribute_value = new ProductAttributeValue();
                $product_attribute_value->product_attribute_id = $value->id;
                $product_attribute_value->product_id = $product_id;
                $product_attribute_value->value = $attribute_value[$value->id];
                $product_attribute_value->position = $last_posision++;
                $product_attribute_value->save();

                $arr[] = $attribute_value[$value->id];
            }

            $product_detail = new ProductDetail();

            $i = 0;
            $files = $request->slim;

            if (@$files[$i]) {

                //IMAGE PATH DIRECTORY
                $image_dir = 'public/content-dir/stores/' . $store_info->store_url . '/products/' . $product_info->product_url . '/';

                $image_data = json_decode($files[$i]);
                $image_path = $image_data->path;
                $path_info = pathinfo($image_data->path);
                if (is_file($image_path)) {
                    $file_name = 'product-image-' . $i . '-' . date("ymdHis");

                    $product_detail->image = $file_name . '.' . $path_info['extension'];

                    // SAVE ORIGINAL IMAGE
                    copy($image_path, $image_dir . $product_detail->image);

                    // CREATE THUMB IMAGE
                    $product_detail->image_thumb = $image_thumb = $file_name . '-thumb.' . $path_info['extension'];
                    copy($image_path, $image_dir . $image_thumb);
                    //RESIZE IMAGE
                    $file_processing = new FileProcessing();
                    $file_processing->smart_resize_image($image_dir . $image_thumb,
                        $string = null,
                        $width = 50,
                        $height = 50,
                        $proportional = false,
                        $output = $image_dir . $image_thumb,
                        $delete_original = true,
                        $use_linux_commands = false,
                        $quality = 100);

                    unlink($image_path);
                }
            }

            $product_detail->product_id = $product_id;
            $product_detail->sku = 'sk-' . rand(11111, 9999) . '-U' . rand(11, 99);
            $product_detail->combinations = implode(',', $arr);
            $product_detail->price = $request->variant_price;
            $product_detail->quantity = $request->variant_quantity;
            $product_detail->status = $request->variant_required;
            $product_detail->save();

            if ($product_detail->status == 1) {
                $product_info->quantity = $product_info->quantity + $request->variant_quantity;
                $product_info->save();
            }

            return redirect("admin/$udc_info->id/product/$product_info->product_url/manage-product-attribute");
        }
    }

    /**
     * @param Request $request
     * @param $product_url
     * @return mixed
     */
    public function update_product_attribute(Request $request, $product_url)
    {
        $data['store_info'] = $store_info = Store::with(['udc'])->where('store_url', '=', $request->store_url)->first();

        $product_url = $request->product_url;
        $product_info = Product::where('product_url', '=', $product_url)->first();
        $product_id = $product_info->id;

        if (!@$product_info) {
            return redirect("admin/" . $store_info->udc->id . "/product");
        }

        // SET FORM VALIDATION RULES
        $float_regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
        $variant_required = $request->variant_required;
        foreach ($request->variant_price as $key => $val) {
            if (@$variant_required[$key] == 1) {
                $rules['variant_price.' . $key] = array('required', 'regex:' . $float_regex);
                $rules['variant_quantity.' . $key] = array('required', 'numeric');
            }
        }

        $validator = Validator::make($request->all(), $rules);
        $variant_price = $request->variant_price;
        $validator->after(function ($validator) use ($variant_price) {
            if ($this->validateVariation($variant_price) == false) {
                $validator->errors()->add('variant_price', 'Please Enter variation price data');
                $validator->errors()->add('variant_quantity', 'Please Enter variation quantity data');
            }
        });

        // VALIDATION CHECK AND TAKE ACTIONS
        if ($validator->fails()) {
            return redirect("admin" . "/" . $store_info->udc->id . "/product/$product_url/manage-product-attribute/")
                ->withErrors($validator)->withInput();
        } else {

            //DELETE PREVIOUS ATTRIBUTE AND THEIR COMBINATION
            // $this->delete_previous_attribute();

            $data['product_attributes'] = $product_attributes = ProductAttribute::where('product_id', '=', $product_id)->get();

            if ($data['product_attributes'] && $request->recombination == 1) {
                if ($data['product_attributes']) {
                    foreach ($data['product_attributes'] as $value)
                        $value->forceDelete();
                }

                $data['product_attribute_values'] = ProductAttributeValue::where('product_id', '=', $product_id)->get();
                if ($data['product_attribute_values']) {
                    foreach ($data['product_attribute_values'] as $value)
                        $value->forceDelete();
                }

                $data['product_details'] = ProductDetail::where('product_id', '=', $product_id)->get();
                if ($data['product_details']) {
                    foreach ($data['product_details'] as $value)
                        $value->forceDelete();
                }
            }


            // UPDATE OR ADD ATTRIBUTE THEIR VALUE AND COMBINATIONS
            $attribute_names = $request->attribute_name;
            $attribute_values = $request->attribute_values;
            if ($attribute_names[0] != null && $request->recombination == 1) {
                //SAVE ATTRIBUTE NAME AND VALUE
                foreach ($attribute_names as $key => $an_value) {
                    $attribute_data = ['product_id' => $product_id, 'attribute_name' => $an_value, 'position' => $key + 1];
                    $attribute_id = DB::table('product_attributes')->insertGetId($attribute_data);
                    $attr_vals = explode(',', $attribute_values[$key]);
                    foreach ($attr_vals as $key => $av_val) {
                        $product_attribute_values = new ProductAttributeValue;
                        $product_attribute_values->product_id = $product_id;
                        $product_attribute_values->product_attribute_id = $attribute_id;
                        $product_attribute_values->value = $av_val;
                        $product_attribute_values->position = $key + 1;
                        $product_attribute_values->save();
                    }
                }
            }

            $product_detail_id = $request->product_detail_id;
            $variant_required = $request->variant_required;
            $combinations = $request->combinations;
            $variant_price = $request->variant_price;
            $variant_quantity = $request->variant_quantity;

            //IMAGE PATH DIRECTORY
            $image_dir = 'public/content-dir/stores/' . $store_info->store_url . '/products/' . $product_info->product_url . '/';

            //CREATE PRODUCT IMAGE DIRECTORY
            if (!is_dir($image_dir)) {
                $file_processing = new FileProcessing();
                $file_processing->create_folder(array("folder_path" => $image_dir));
            }

            // SAVE EACH PRODUCT VARIATIONS AND **UPDATE PRODUCT QUANTITY**
            $total_quantity = 0;
            $i = 0;
            $files = $request->slim;
            foreach ($combinations as $key => $c_value) {
                $product_detail = new ProductDetail();
                if (@$product_detail_id[$key]) {
                    $product_detail = ProductDetail::find($product_detail_id[$key]);
                    if (!$product_detail) {
                        $product_detail = new ProductDetail();
                    }
                } else {
                    $product_detail->sku = 'sk-' . rand(11111, 9999) . '-U' . rand(11, 99);
                }

                if (@$files[$i]) {
                    $image_data = json_decode($files[$i]);
                    $image_path = $image_data->path;
                    $path_info = pathinfo($image_data->path);
                    if (is_file($image_path)) {
                        $file_name = 'product-image-' . $i . '-' . date("ymdHis");

                        $product_detail->image = $file_name . '.' . $path_info['extension'];

                        // SAVE ORIGINAL IMAGE
                        copy($image_path, $image_dir . $product_detail->image);

                        // CREATE THUMB IMAGE
                        $product_detail->image_thumb = $image_thumb = $file_name . '-thumb.' . $path_info['extension'];
                        copy($image_path, $image_dir . $image_thumb);
                        //RESIZE IMAGE
                        $file_processing = new FileProcessing();
                        $file_processing->smart_resize_image($image_dir . $image_thumb,
                            $string = null,
                            $width = 50,
                            $height = 50,
                            $proportional = false,
                            $output = $image_dir . $image_thumb,
                            $delete_original = true,
                            $use_linux_commands = false,
                            $quality = 100);

                        unlink($image_path);
                    }
                }
                $i++;
                $product_detail->product_id = $product_id;
                $product_detail->combinations = $combinations[$key];
                $product_detail->price = $variant_price[$key];
                $product_detail->quantity = $variant_quantity[$key];
                $product_detail->status = @$variant_required[$key] ? @$variant_required[$key] : 0;
                $product_detail->save();

                if (@$variant_required[$key]) {
                    $total_quantity += $product_detail->quantity;
                }
            }

            //UPDATE PRODUCT QUANTITY
            $product_info->quantity = $total_quantity;
            $product_info->save();
            return redirect("admin" . "/" . $store_info->udc->id . "/product");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($udc_id, $product_id)
    {
        $data = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'udc_management' => 'start active open');

        $data['udc_id'] = $udc_id;
        $data['product_id'] = $product_id;

        $data['product_info'] = Product::with(['product_attributes', 'product_details'])->where('status', '=', '1')->find($product_id);
        $data['udc_info'] = Udc::with(['store'])->where('status', '=', '1')->find($udc_id);

        if ($data['product_info'] === null) {
            return redirect("admin/$udc_id/product");
        }
        $data['category_id'] = old('category_id') ? old('category_id') : $data['product_info']->category_id;
        $this->get_parents($data['category_id']);
        $data['main_parent'] = $this->parent;

        $data['categories'] = ProductCategory::where('status', '=', '1')->get()->toArray();
        $data['category_tree'] = $this->buildTree($data['categories']);

        $data['brand_list'] = Brand::get();

        return view('admin.ekom.udc.product.add_product')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $store_id, $product_id)
    {
        $regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'short_description' => 'max:160',
            'description' => '',
            'product_specification' => '',
            'category_id' => 'required|numeric',
            'base_price' => array('required', 'regex:' . $regex),
            'compare_price' => array('regex:' . $regex),
            'weight' => array('required', 'regex:' . $regex),
            'quantity' => 'required|numeric',
            'udc_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect("admin/$request->udc_id/product/$product_id/edit")->withErrors($validator)->withInput();
        } else {
            $data['store_info'] = $udc_info = Store::with('udc')->find($store_id);
            $data['udc_info'] = $udc_info = Udc::find($request->udc_id);

            if (@$data['udc_info']) {
                $data['udc_info'] = $udc_info = Udc::with(['store'])->find($request->udc_id);

                if (@$data['udc_info']) {

                    $product_data = Product::find($product_id);
                    $product_data->product_name = $request->product_name;
                    $product_data->short_description = $request->short_description;
                    $product_data->description = $request->description;
                    $product_data->product_specification = $request->product_specification;
                    $product_data->category_id = $request->category_id;
                    $product_data->brand_id = $request->brand_id;

                    //$product_data->product_url = $util->create_clean_url($product_data->product_name) . rand(1111, 99999);

                    $product_data->base_price = $request->base_price;
                    $product_data->compare_price = $request->compare_price ? $request->compare_price : "0";
                    $product_data->weight = $request->weight;
                    $product_data->quantity = $request->quantity;
                    $product_data->store_id = $udc_info->store_id ? $udc_info->store_id : "";

                    if (!empty($request->slim)) {
                        $files = $request->slim;
                        //IMAGE PATH DIRECTORY
                        $image_dir = 'public/content-dir/stores/' . $udc_info->store->store_url . '/products/' . $product_data->product_url . '/';

                        //CREATE PRODUCT IMAGE DIRECTORY
                        if (!is_dir($image_dir)) {
                            $file_processing = new FileProcessing();
                            $file_processing->create_folder(array("folder_path" => $image_dir));
                        }
                        foreach ($files as $fv) {
                            if (@$fv) {
                                $image_data = json_decode($fv);
                                $image_path = $image_data->path;
                                $path_info = pathinfo($image_data->path);
                                if (is_file($image_path)) {
                                    $previous_image = $image_dir . '' . $product_data->product_image;
                                    if (is_file($previous_image)) {
                                        unlink($previous_image);
                                    }
                                    $previous_image = $image_dir . '' . $product_data->product_image_thumb;
                                    if (is_file($previous_image)) {
                                        unlink($previous_image);
                                    }

                                    $file_name = 'product-image-' . date("ymdHis");

                                    $product_data->product_image = $file_name . '.' . $path_info['extension'];

                                    // SAVE ORIGINAL IMAGE
                                    copy($image_path, $image_dir . $product_data->product_image);

                                    // CREATE THUMB IMAGE
                                    $product_data->product_image_thumb = $product_image_thumb = $file_name . '-thumb.' . $path_info['extension'];
                                    copy($image_path, $image_dir . $product_image_thumb);
                                    //RESIZE IMAGE
                                    $file_processing = new FileProcessing();
                                    $file_processing->smart_resize_image($image_dir . $product_image_thumb,
                                        $string = null,
                                        $width = 50,
                                        $height = 50,
                                        $proportional = false,
                                        $output = $image_dir . $product_image_thumb,
                                        $delete_original = true,
                                        $use_linux_commands = false,
                                        $quality = 100);

                                    // CREATE ROUND IMAGE
                                    $original_path = $image_dir . $product_image_thumb;
                                    $destination_path = $image_dir . '/' . $file_name . '-round.' . $path_info['extension'];
                                    $file_processing->convert_image_to_round($original_path, $destination_path);
                                    //$product_data->product_image_round = $file_name . '-round.' . $path_info['extension'];
                                    unlink($image_path);
                                }
                            }
                        }
                    }

                    $product_data->save();

                    return redirect("admin/$request->udc_id/product/$product_data->product_url/manage-product-attribute/");
                } else {
                    return redirect()->route('udc_list');
                }

                return redirect("admin/$request->udc_id/product/$product_id/edit");
            }
            return redirect("admin/$request->udc_id/product/");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

    public $parent = 0;

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

    public function sorting_category(Request $request)
    {
        foreach ($_POST['arrayorder'] as $key => $value) {
            $update = DB::table('product_categories')
                ->where('id', $value)
                ->update(array('position' => $key));
        }
    }

}
