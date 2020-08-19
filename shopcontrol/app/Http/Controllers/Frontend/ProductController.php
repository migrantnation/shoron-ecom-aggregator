<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\models\Brand;
use App\models\OrderDetail;
use App\models\Product;
use App\models\ProductAttribute;
use App\models\ProductAttributeValue;
use App\models\ProductCategory;
use App\models\ProductDetail;
use App\models\Store;
use App\Libraries\PlxUtilities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{

    public function products()
    {
        $data = array();
        return view('frontend.product.products')->with($data);
    }

    public function product_details($product_url)
    {
        $data = array();

        $product_info = Product::with(['product_attributes', 'product_details'])->where('product_url', '=', $product_url)->first();

        if (@$product_info) {
            $data['store_info'] = Store::with(['ecommerce_partner', 'udc', 'locations'])->find($product_info->store_id);
            $data['product_orders'] = OrderDetail::where('product_id', '', $product_info->id)->get();

            if (@$product_info->product_attributes) {
                foreach ($product_info->product_attributes as $attribute_value) {
                    $attribute_value->values = ProductAttributeValue::where('product_attribute_id', '=', $attribute_value->id)->get();
                }
            }

            $product_info->product_statistics = DB::table('product_statistics')->where('product_id', '=', $product_info->id)->get();
            $data['product_info'] = $product_info;

            return view('frontend.product.product_details')->with($data);
        } else {
            return redirect("all-store");
        }
    }

    public function get_product_info(Request $request)
    {
        $status = 100;
        $response = array();
        $response['request'] = $request->all();
        $plx_utilities = new PlxUtilities();

        $product_id = $request->product_id;
        $product_url = $request->product_url;
        $product_info = Product::where('product_url', '=', $product_url)->first();

        if (@$product_info->id == $product_id) {
            $store_info = Store::with(['ecommerce_partner', 'udc', 'locations'])->find($product_info->store_id);
            $image = url('') . '/content-dir/stores/' . $store_info->store_url . '/products/' . $product_info->product_url . '/' . $product_info->image;

            $status = 200;
            $query = ProductDetail::select();
            $selected_attribute_value = $request->selected_attribute_value;
            array_filter($selected_attribute_value);
            foreach ($selected_attribute_value as $attr_value) {
                if ($attr_value) {
                    $query->whereRaw("FIND_IN_SET('$attr_value', combinations)");
                }
            }
            $response['product_details'] = $product_details = $query->where('product_id', '=', $product_id)->get();

            $total_quantity = null;
            $price = null;
            $product_aku = null;
            $base_sku = '';
            foreach ($product_details as $pd_value) {
                $total_quantity += $pd_value->quantity;
                $price = $pd_value->price;
                $base_sku = $pd_value->sku;
                if ($pd_value->image) {
                    $image = url('') . '/content-dir/stores/' . $store_info->store_url . '/products/' . $product_info->product_url . '/' . $pd_value->image;
                } else {
                    $image = url('') . '/content-dir/stores/' . $store_info->store_url . '/products/' . $product_info->product_url . '/' . $product_info->product_image;
                }
            }

            $product_info->quantity = $total_quantity;
            if ($product_details->count() > 0) {
                $product_info->base_price = $price;
                $product_info->base_sku = $base_sku;
            }

            $response['image'] = $image;
            $response['product_info'] = $product_info;
            $response['message'] = 'success';
        } else {
            $response['message'] = 'product not found';
        }
        echo $plx_utilities->json($status, $response);
        return;
    }

    public function product_detail()
    {
        return view('frontend.product.product_detail');
    }

    public $bread_crumb = array();

    function breadcrumb($category_id)
    {
        $sql = ProductCategory::where('id', '=', $category_id)->get();//"SELECT * FROM files WHERE parentID = ".$parent."";
        foreach ($sql as $main_parent) {
            $this->bread_crumb[] = $main_parent;
            $this->breadcrumb($main_parent->parent_category_id);
        }
    }

    public function get_product_by_category(Request $request, $category_id)
    {
        $util = new PlxUtilities();
        $data = array();
        /*
         * RECEIVING GET VALUE
         * */
        if (Input::get('attribute_value')) {
            $data['attribute_values'] = $attribute_values = Input::get('attribute_value');
            foreach ($attribute_values as $value) {
                $exploded = array_combine(range(1, count($value)), $value);
                $attr_val[] = $exploded;
            }
            $variation_list = $util->combinations($attr_val);
        }
        $data['brand_id'] = $brand_id = Input::get('brand_id');
        $data['min_price'] = $min_price = Input::get('min_price');
        $data['max_price'] = $max_price = Input::get('max_price');
        $data['searchstring'] = $search_string = Input::get('searchstring');
        $data['new_arrival'] = $new_arrival = Input::get('new_arrival');


        /*
         * START CHILD CATEGORIES
         * */
        $data['categories'] = ProductCategory::all()->toArray();
        $data['category_info'] = ProductCategory::where('id', '=', $category_id)->first();

        $data['parent_category_info'] = ProductCategory::where('id', '=', $data['category_info']->parent_category_id)->first();
        $data['category_tree'] = $util->self_tree($data['categories'], $data['category_info']->id);
        $this->breadcrumb($category_id);
        $data['breadcrumb'] = $this->bread_crumb;
        $this->tree_item_id_array($data['category_tree']);
        $child_ids = implode(',', $this->child_ids) . ',' . $category_id;


        /*
         * START PRODUCT ATTRIBUTE FROM THIS CATEGORIES
         * */
        $data['product_attributes'] = DB::table('product_attributes as pa')
            ->leftJoin('products as p', 'p.id', '=', 'pa.product_id')
            ->whereRaw("FIND_IN_SET(category_id,'$child_ids')")
            ->select('pa.*')->get();

        $attribute_list = array();
        foreach ($data['product_attributes'] as $attr_value) {
            if (!@$attribute_list[$attr_value->attribute_name])
                $attribute_list[$attr_value->attribute_name] = 0;
            $attribute_list[$attr_value->attribute_name] += 1;
        }

        arsort($attribute_list);
        $data['attribute_list'] = $attribute_list;
        $attr = 1;
        foreach ($attribute_list as $key => $value) {
            $data['product_attribute_values'][$key] = DB::table('product_attribute_values as pav')
                ->leftJoin('product_attributes as pa', 'pa.id', '=', 'pav.product_attribute_id')
                ->leftJoin('products as p', 'p.id', '=', 'pav.product_id')
                ->where("pa.attribute_name", '=', $key)
                ->whereRaw("FIND_IN_SET(category_id,'$child_ids')")
                ->select('pav.*')->get();
            if ($attr == 10) break; else $attr++;
        }

        /*
         * START PRODUCT LISTING
         * */
        // VARIATION QUERY BUILDER
        $raw_sql = "products.id != 'null'";
        if (@$variation_list) {
            $attr_arr = array();
            foreach ($variation_list as $each_variation) {
                if (is_array($each_variation)) {
                    $find_in_set_arr = array();
                    foreach ($each_variation as $value) {
                        $find_in_set_arr[] = "FIND_IN_SET('$value', combinations)";
                    }
                    $attr_arr[] = '( ' . implode(' AND ', $find_in_set_arr) . ' ) ';
                } else {
                    $find_in_set_arr[] = "FIND_IN_SET('$each_variation', combinations)";
                    $attr_arr[] = '( ' . implode(' AND ', $find_in_set_arr) . ' ) ';
                }
            }
            $raw_sql = '(' . implode(' OR ', $attr_arr) . ')';
        }

        /*
         * START BRAND LIST
         * */
        $data['brands'] = Brand::leftJoin('products', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('product_details as pd', 'products.id', '=', 'pd.product_id')
            ->whereRaw("$raw_sql")
            ->whereRaw("FIND_IN_SET(category_id,'$child_ids')")
            ->select(['brands.id as brand_id', 'brands.brand_name', 'brands.image as brand_image'])
            ->get();
        $data['brands'] = $data['brands']->groupBy('brand_id')->toArray();


        if ($brand_id) {
            $raw_sql .= " AND FIND_IN_SET(brand_id,'$brand_id')";
        }
        /*
         * START PRODUCT PRICE RANGE
         * */
        if ($min_price)
            $raw_sql .= " AND pd.price >= '$min_price'";
        if ($max_price)
            $raw_sql .= "  AND pd.price <= '$max_price' ";

        $data['price_rang'] = $price_rang = Product::leftJoin('product_details as pd', 'products.id', '=', 'pd.product_id')
            ->whereRaw("$raw_sql")
            ->whereRaw("FIND_IN_SET(category_id,'$child_ids')")
            ->selectRaw("MAX(pd.price) AS max_price, MIN(pd.price) AS min_price")
            ->first();
        $data['min_price'] = $min_price = ($min_price == '') ? $price_rang->min_price : $min_price;
        $data['max_price'] = $max_price = ($max_price == '') ? $price_rang->max_price : $max_price;

        /*
         * Search with string
         * */
        if ($search_string) {
            $raw_sql .= " AND (products.product_name like '%$search_string%') or (products.description like '%$search_string%') or (products.short_description like '%$search_string%')";
        }

        /*
         * New Arrival
         * */
        if ($new_arrival) {
            $date = new Carbon();
            $raw_sql .= " AND (products.created_at > '{$date->subWeek()}')";
        }

        /*
         * START PRODUCT LISTING
         * */
        $data['order'] = $order = $request->order;
        if ($order) {
            $data['product_list'] = Product::leftJoin('product_details as pd', 'products.id', '=', 'pd.product_id')
                ->leftJoin('stores as s', 's.id', '=', 'products.store_id')
                ->leftJoin('product_statistics as ps', 'products.id', '=', 'ps.product_id')
                ->whereRaw("$raw_sql")
                ->whereRaw("FIND_IN_SET(category_id,'$child_ids')")
                ->orderBy('ps.total_sold', $order == 1 ? 'DESC' : 'ASC')
                ->get(['ps.average_rating as product_average_rating', 'ps.total_rating as product_total_rating', 'products.*', 'pd.*', 's.*']);
        } else {
            $data['product_list'] = Product::leftJoin('product_details as pd', 'products.id', '=', 'pd.product_id')
                ->leftJoin('stores as s', 's.id', '=', 'products.store_id')
                ->whereRaw("$raw_sql")
                ->whereRaw("FIND_IN_SET(category_id,'$child_ids')")
                ->get();
        }
        $data['product_list'] = $data['product_list']->groupBy('product_id')->toArray();

//        dd($data['product_list']);
        return view('frontend.product.product_listing')->with($data);
    }

    public function set_listing_view_mode($mode)
    {
        $status = session(['list-view' => $mode]);
        return $status;
    }

    public $child_ids = array();

    function tree_item_id_array($category_tree, $child_counter = 0)
    {
        foreach ($category_tree as $key => $element) {
            if (!empty($element['children'])) {
                $child_counter++;
                $this->child_ids[] = $element['id'];
                $this->tree_item_id_array($element['children'], $child_counter);
            } else {
                $this->child_ids[] = $element['id'];
            }
        }
    }

    function array_flatten($array)
    {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public function product_listing()
    {
        return view('frontend.product.product_listing');
    }

    private function json($status = NULL, $response = NULL)
    {
        echo json_encode(array('meta' => array('status' => $status), 'response' => $response));
    }
}