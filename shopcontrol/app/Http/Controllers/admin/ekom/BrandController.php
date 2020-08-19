<?php

namespace App\Http\Controllers\admin\ekom;

use App\models\Brand;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function brand_list($id = NULL)
    {
        $data = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'product_management' => 'start active', 'product_brand' => 'active');

        $data['brand_list'] = Brand::orderBy('position', 'asc')->get()->toArray();
        return view('admin.ekom.brand.brand_list')->with($data);
    }

    public function store_brand(Request $request)
    {
        $data = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'product_management' => 'start active', 'product_brand' => 'active');

        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|max:255'
        ]);

        $brand_name = $request->brand_name;
        $validator->after(function ($validator) use ($brand_name) {
            if ($this->checkExist($brand_name)) {
                $validator->errors()->add('brand_name', 'ইতিমধ্যে বিদ্যমান!');
            }
        });

        if ($validator->fails()) {
            return redirect("admin/brand-list")->withErrors($validator)->withInput();
        } else {
            $brand_info = new Brand();
            $brand_info->brand_name = $request->brand_name;

            // UPLOAD BRAND IMAGE
            if (!empty($request->slim)) {
                $files = $request->slim;
                //IMAGE PATH DIRECTORY
                $image_dir = 'public/content-dir/brands/';
                foreach ($files as $fv) {
                    if (@$fv) {
                        $image_data = json_decode($fv);
                        $image_path = $image_data->path;
                        $path_info = pathinfo($image_data->path);
                        if (is_file($image_path)) {
                            $file_name = 'product-image-' . date("ymdHis");
                            $brand_info->image = $file_name . '.' . $path_info['extension'];
                            // SAVE ORIGINAL IMAGE
                            copy($image_path, $image_dir . $brand_info->image);
                            unlink($image_path);
                        }
                    }
                }
            }

            $brand_info->save();
            return redirect('admin/brand-list');
        }
    }

    public function edit_brand($id)
    {
        $data = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'product_management' => 'start active', 'product_brand' => 'active');

        $data['brand_info'] = $brand_info = Brand::find($id);
        if ($brand_info->count()) {
            $data['brand_list'] = Brand::orderBy('position', 'asc')->get()->toArray();
            return view('admin.ekom.brand.brand_list')->with($data);
        } else {
            return redirect("admin/brand-list");
        }
    }

    public function update_brand(Request $request, $id)
    {
        $data = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'product_management' => 'start active', 'product_brand' => 'active');

        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|max:255'
        ]);

        $brand_name = $request->brand_name;
        $validator->after(function ($validator) use ($brand_name) {
            if ($this->checkExist($brand_name)) {
                $validator->errors()->add('brand_name', 'ইতিমধ্যে বিদ্যমান!');
            }
        });

        $brand_info = Brand::find($id);
        if (!$brand_info->count()) {
            return redirect("admin/brand");
        }

        if ($validator->fails()) {
            return redirect("admin/brand/$id/edit")->withErrors($validator)->withInput();
        } else {
            $brand_info = Brand::find($id);
            $brand_info->brand_name = $request->brand_name;

            // UPLOAD BRAND IMAGE
            if (!empty($request->slim)) {
                $files = $request->slim;
                //IMAGE PATH DIRECTORY
                $image_dir = 'public/content-dir/brands/';
                foreach ($files as $fv) {
                    if (@$fv) {
                        $image_data = json_decode($fv);
                        $image_path = $image_data->path;
                        $path_info = pathinfo($image_data->path);
                        if (is_file($image_path)) {
                            $file_name = 'product-image-' . date("ymdHis");
                            $brand_info->image = $file_name . '.' . $path_info['extension'];
                            // SAVE ORIGINAL IMAGE
                            copy($image_path, $image_dir . $brand_info->image);
                            unlink($image_path);
                        }
                    }
                }
            }
            $brand_info->save();
            return redirect('admin/brand-list');
        }
    }

    public function checkExist($brand_name)
    {
        $brand = Brand::where('brand_name', '=', $brand_name)->get();
        if ($brand->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_brand(Request $request, $id)
    {
        $status = 100;
        $response = array();
        $response['request'] = $request->all();
        $plx_utilities = new PlxUtilities();
        $response['message'] = '';


        echo $plx_utilities->json($status, $response);
        return;
    }
}
