<?php
/**
 * Created by PhpStorm.
 * User: Parallax Mahabub
 * Date: 3/27/2018
 * Time: 12:18 PM
 */

namespace App\Http\Controllers\admin\ekom;

use App\Libraries\PlxUtilities;
use App\models\KpiReportSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Validator;

class KpiController
{

    public function index(Request $request)
    {
        $status = 100;
        $response = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'settings' => 'start active', 'kpi_settings' => 'active');
        $plx_utilities = new PlxUtilities();
        $response['message'] = '';

        $response['kpi_list'] = KpiReportSetting::paginate(10);

        return view('admin.ekom.kpi.kpi_list')->with($response);
    }

    public function add(Request $request)
    {
        $response = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'settings' => 'start active', 'kpi_settings' => 'active');

        return view('admin.ekom.kpi.add_edit_kpi')->with($response);
    }

    public function edit(Request $request, $id)
    {
        $response = array('side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'settings' => 'start active', 'kpi_settings' => 'active');

        $response['kpi_info'] = KpiReportSetting::find($id);
        if (@$response['kpi_info']) {
            return view('admin.ekom.kpi.add_edit_kpi')->with($response);
        } else {
            return back();
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sale_per_day' => 'required',
            'total_transaction_per_day' => 'required',
            'order_per_entrepreneur_per_day' => 'required',
            'average_fulfillment_time' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $kpi_info = new KpiReportSetting();
            $kpi_info->sale_per_day = $request->sale_per_day;
            $kpi_info->total_transaction_per_day = $request->total_transaction_per_day;
            $kpi_info->order_per_entrepreneur_per_day = $request->order_per_entrepreneur_per_day;
            $kpi_info->average_fulfillment_time = $request->average_fulfillment_time;
            $kpi_info->save();
        }
        return redirect('admin/setting/kpi');
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'sale_per_day' => 'required',
            'total_transaction_per_day' => 'required',
            'order_per_entrepreneur_per_day' => 'required',
            'average_fulfillment_time' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $kpi_info = KpiReportSetting::find($id);
            if ($kpi_info) {
                $kpi_info->sale_per_day = $request->sale_per_day;
                $kpi_info->total_transaction_per_day = $request->total_transaction_per_day;
                $kpi_info->order_per_entrepreneur_per_day = $request->order_per_entrepreneur_per_day;
                $kpi_info->average_fulfillment_time = $request->average_fulfillment_time;
                $kpi_info->save();
            }
        }

        return redirect('admin/setting/kpi');
    }

    public function change_status(Request $request)
    {
        $status = 100;
        $response = array();
        $response['request'] = $request->all();
        $plx_utilities = new PlxUtilities();
        $response['message'] = '';

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $response["message"] = "Some field is required";
        } else {
            $kpi_info = KpiReportSetting::find($request->id);
            if ($kpi_info) {
                $status = 200;
                $response["message"] = "Status has been changed successfully";
            } else {
                $response["message"] = "KPI not found. Please try again";
            }
        }
        echo $plx_utilities->json($status, $response);
        return;
    }


    public function delete(Request $request)
    {
        $status = 100;
        $response = array();
        $response['request'] = $request->all();
        $plx_utilities = new PlxUtilities();
        $response['message'] = '';

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $response["message"] = "Some field is required";
        } else {
            $kpi_info = KpiReportSetting::find($request->id);
            if ($kpi_info) {
                $kpi_info->delete();
                $status = 200;
                $response["message"] = "KPI has been deleted successfully.";
            } else {
                $response["message"] = "KPI not found. Please try again";
            }
        }

        echo $plx_utilities->json($status, $response);
        return;
    }
}