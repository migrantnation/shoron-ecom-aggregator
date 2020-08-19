<?php

namespace App\Http\Controllers\admin\udc;

use App\Libraries\ChangeOrderStatus;
use App\Libraries\Slim;
use App\models\EcommercePartner;
use App\models\Order;
use App\models\ProductSeller;
use App\models\UdcProduct;
use App\models\UdcProductDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Validator;

class ProductManagement extends Controller
{
    public $row_per_page = 10;

    public function dccpProductList()
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['products'] = 'start active open';
        $data['product_list_menu'] = 'active';

        $data['user_info'] = Auth::user();
        $data['ep_list'] = EcommercePartner::all();
        $data['product_list'] = UdcProduct::where('udc_id', Auth::user()->id)
            ->with(['get_product_details', 'get_seller'])
            ->get();

        return view('admin.udc.products.dccp-product-list')->with($data);
    }

    public function udcSellerList()
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['seller'] = 'start active open';
        $data['seller_list'] = 'active';
        $data['user_info'] = Auth::user();
        $data['sellerList'] = ProductSeller::where('udc_id', Auth::user()->id)->get();
        return view('admin.udc.seller.sellerList')->with($data);
    }

    public function addSeller()
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['seller'] = 'start active open';
        $data['add_seller'] = 'active';
        $data['user_info'] = Auth::user();
        return view('admin.udc.seller.add_seller')->with($data);
    }

    public function storeSeller(Request $request)
    {
        $udc_id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'seller_name' => 'required',
            'seller_address' => 'required',
            'seller_contact_number' => Rule::unique('product_sellers')->where(function ($validator) use ($request, $udc_id) {
                $validator->where('seller_contact_number', $request->seller_contact_number)->where('udc_id', $udc_id);
            })
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $request['udc_id'] = Auth::user()->id;
            $seller = ProductSeller::create($request->all());
            if ($seller) {
                return redirect()->route('udc.sellerList')->with('message', 'Product Seller Created Successfully');
            } else {
                return back()->with('message', 'Something Went Wrong');
            }
        }
    }

    public function editSeller($id)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['seller'] = 'start active open';
        $data['seller_list'] = 'active';
        $data['user_info'] = Auth::user();
        $data['seller_info'] = ProductSeller::find($id);
        return view('admin.udc.seller.edit_seller')->with($data);
    }

    public function updateSeller(Request $request, $id)
    {
        $this->validate($request, [
            'seller_name' => 'required',
            'seller_address' => 'required',
            'seller_contact_number' => 'required|unique:product_sellers'
        ]);
        $seller = ProductSeller::find($id);
        $seller->seller_name = $request->seller_name;
        $seller->seller_address = $request->seller_address;
        $seller->seller_contact_number = $request->seller_contact_number;
        if ($seller->save()) {
            return redirect()->route('udc.sellerList')->with('message', 'Product Seller Created Successfully');
        } else {
            return back()->with('message', 'Product Seller Created Successfully');
        }
    }

    public function add_product()
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['products'] = 'start active open';
        $data['add_product'] = 'active';
        $data['user_info'] = Auth::user();
        $data['ep_list'] = EcommercePartner::all();
        $data['existingUsers'] = ProductSeller::where('udc_id', Auth::user()->id)->get();
        return view('admin.udc.products.add-product')->with($data);
    }

    public function store_product(Request $request)
    {
//
        $sku_array = array();
        $permalink_array = array();
        $quantity_array = array();
        $product_url_array = array();
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'product_image' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect("udc/add-product")->withErrors($validator)->withInput();
        } else {
            if ($request->userExist) {
                $this->validate($request, [
                    'seller_id' => 'required'
                ]);
            } else {
                $this->validate($request, [
                    'seller_name' => 'required',
                    'seller_address' => 'required',
                    'seller_contact_number' => 'required|unique:product_sellers'
                ]);
                $request['udc_id'] = Auth::user()->id;
                $create_seller = ProductSeller::create($request->all());
                $request['seller_id'] = $create_seller->id;
            }
            if ($request->product_image) {
                $image = Slim::getImages('product_image')[0];
                if (isset($image['output']['data'])) {
                    $name = $image['output']['name'];
                    $data = $image['output']['data'];
                    $path = base_path() . '/content-dir/udc_product_images/';
                    $filename = Slim::saveFile($data, $name, $path);
                    $request->request->add(['product_image' => $filename['name']]);
                }
            }
            $request->request->add(['udc_id' => Auth::user()->id]);
            $create_product = UdcProduct::create($request->all());
            if ($create_product) {
                if ($request->ep_id) {
                    foreach ($request->ep_id as $key => $package) {
                        $lpShippingPackage = new UdcProductDetail();
                        $lpShippingPackage->ep_id = $package;
                        $lpShippingPackage->product_id = $create_product->id;
                        $lpShippingPackage->sku = $request->sku[$key];
                        $lpShippingPackage->permalink = $request->permalink[$key];
                        $lpShippingPackage->product_url = $request->product_url[$key];
                        $lpShippingPackage->quantity = $request->quantity[$key];
                        $lpShippingPackage->save();
                    }
                }

            }

            /*if (!empty($request->ep_id)) {

                $sku_array = array_values(array_filter($request->sku));
                $permalink_array = array_values(array_filter($request->sku));
                $quantity_array = array_values(array_filter($request->quantity));

                foreach ($request->ep_id as $key => $each_ep) {
                    $details_data = new UdcProductDetail();
                    $details_data->ep_id = $each_ep;
                    $details_data->product_id = $create_product->id;
                    $details_data->sku = $sku_array[$key];
                    $details_data->permalink = $permalink_array[$key];
                    $details_data->product_url = $product_url_array[$key];
                    $details_data->quantity = $quantity_array[$key];
                    $details_data->save();
                }

            }*/
            return redirect(url('') . '/udc/product-list');
        }
    }


    public function edit_product($product_id)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['products'] = 'start active open';
        $data['product_list_menu'] = 'active';
        $data['user_info'] = Auth::user();
        $data['product_info'] = UdcProduct::where('id', $product_id)
            ->with(['get_seller', 'get_product_details'])
            ->first();
        $data['existingUsers'] = ProductSeller::where('udc_id', Auth::user()->id)->get();
        $data['ep_list'] = EcommercePartner::all();
        return view('admin.udc.products.edit-product')->with($data);
    }


    public function update_product(Request $request)
    {
        $sku_array = array();
        $permalink_array = array();
        $quantity_array = array();
        $product_url_array = array();
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required',
            'description' => 'required',
//            'product_image' => 'required',
            'seller_name' => 'required',
            'seller_address' => 'required',
            'seller_contact_number' => 'required|unique:product_sellers,id,' . $request->seller_id
        ]);
        if ($validator->fails()) {
            return redirect("udc/edit-product/" . $request->product_id)->withErrors($validator)->withInput();
        } else {

            $update_seller = ProductSeller::find($request->seller_id);
            $update_seller->update($request->all());
            if ($request->product_image) {
                $image = Slim::getImages('product_image')[0];
//                dd($image);
                if (isset($image['output']['data'])) {
                    $name = $image['output']['name'];
                    $data = $image['output']['data'];
                    $path = base_path() . '/content-dir/udc_product_images/';
                    $filename = Slim::saveFile($data, $name, $path);
//                    echo $filename['name'];
                    $request->request->add(['product_image' => $filename['name']]);
                }
            } else {
                $request = array_except($request, ['product_image']);
            }

            $update_product = UdcProduct::find($request->product_id);
            $producrDetails = $update_product->get_product_details->pluck('ep_id')->toArray();
            $update_product->update($request->all());

            if ($request->ep_id) {
                $deleteableDetails = array_diff($producrDetails, $request->ep_id);
                UdcProductDetail::whereIn('ep_id', $deleteableDetails)->where('product_id', $update_product->id)->delete();
                foreach ($request->ep_id as $key => $each_ep_detail) {
                    $each_ep_product_detail = UdcProductDetail::where('ep_id', $each_ep_detail)->where('product_id', $update_product->id)->first();
                    if (!$each_ep_product_detail) {
                        $each_ep_product_detail = new UdcProductDetail();
                        $each_ep_product_detail->ep_id = $each_ep_detail;
                        $each_ep_product_detail->product_id = $update_product->id;
                    }
                    $each_ep_product_detail->sku = $request->sku[$key];
                    $each_ep_product_detail->permalink = $request->permalink[$key];
                    $each_ep_product_detail->product_url = $request->product_url[$key];
                    $each_ep_product_detail->quantity = $request->quantity[$key];
                    $each_ep_product_detail->save();
                }
            } elseif (!empty($producrDetails)) {
                UdcProductDetail::whereIn('ep_id', $producrDetails)->where('product_id', $update_product->id)->delete();
            }

            /*if (!empty($request->ep_id)) {
                $sku_array = array_values(array_filter($request->sku));
                $permalink_array = array_values(array_filter($request->sku));
                $quantity_array = array_values(array_filter($request->quantity));

                foreach ($request->ep_id as $key => $each_ep) {
                    $details_data = new UdcProductDetail();
                    $details_data->ep_id = $each_ep;
                    $details_data->product_id = $request->product_id;
                    $details_data->sku = $sku_array[$key];
                    $details_data->permalink = $permalink_array[$key];
                    $details_data->product_url = $product_url_array[$key];
                    $details_data->quantity = $quantity_array[$key];
                    $details_data->save();
                }
            }*/
            return redirect(url('udc/product-list'));
        }
    }

    public function lpOrders(Request $request, $id)
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['lp_management'] = 'start active open';
        $data['lp'] = LogisticPartner::where('id', $id)->first();
        $input = $request->all();
        $data['url'] = url("admin/lp/$id/orders");

        //Change Order Status
        if ($request->order_code) {
            $change_status = new ChangeOrderStatus();
            $change_status->change_order_status($request->order_code);
        }

        if (isset($input['search_string'])) {
            $sstring = $input['search_string'];
            $data['all_orders'] = Order::where('lp_id', '=', $id)
                ->where(function ($query) use ($request) {
                    if ($request->tab_id > 0) {
                        $query->where('status', $request->tab_id);
                    }
                })->where(function ($query) use ($request) {
                    $query->where('order_code', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('ep_name', 'LIKE', '%' . $request->search_string . '%');
                })->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath("?search_string=$sstring&tab_id=$request->tab_id");
        } else {
            if ($request->tab_id) {
                $data['all_orders'] = Order::where('lp_id', '=', $id)->where('status', '=', $request->tab_id)->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath('?tab_id=' . $request->tab_id);
            } else {
                $data['all_orders'] = Order::where('lp_id', '=', $id)->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath('?tab_id=0');
            }
        }

        if ($request->ajax()) {
//            return Response::json(View::make('admin.ekom.lp.render-lp-order-list', array('all_orders' => $data['all_orders']))->render());
            return Response::json(View::make('admin.ekom.orders.render_ep_order_list', array('all_orders' => $data['all_orders']))->render());
        } else {
            return view('admin.ekom.lp.lp_orders')->with($data);
        }
    }
}