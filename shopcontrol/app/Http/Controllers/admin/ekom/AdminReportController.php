<?php

namespace App\Http\Controllers\admin\ekom;

use App\Libraries\ChangeOrderStatus;
use App\models\AdminUser;
use App\models\EpStatistic;
use App\models\KpiReportSetting;
use App\models\LoginInformation;
use App\models\UserActivitiesLog;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\models\UdcCustomer;
use App\Libraries\EkomEncryption;
use App\Mail\LpCreate;
use App\models\CountryLocation;
use App\models\LogisticPartner;
use App\models\Order;
use App\models\OrderDetail;
use App\models\LpShippingPackage;
use App\models\SearchHistory;
use App\models\OverviewReport;
use App\models\_ecom_Setting;
use App\models\Setting;
use App\models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Slim;
use App\models\EcommercePartner;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Validator;
use Illuminate\Support\Facades\DB;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Support\Facades\File;

use Illuminate\Database\Eloquent\Collection;
use League\Csv\Writer;
use Schema;
use SplTempFileObject;

class AdminReportController extends Controller
{
    public $row_per_page = 10;

    private $function_array = array("d H" => "addHour", "M-d-D" => "addDay", "M-d" => "addDay", "Y-M" => "addMonth");
    private $time_subtraction_func = array("d H" => "subHour", "M-d-D" => "subDay", "M-d" => "subDay", "Y-M" => "subMonth");

    private $kpi_type = array("1" => "sale_per_day", "2" => "total_transaction_per_day", "3" => "order_per_entrepreneur_per_day", "4" => "order_per_entrepreneur_per_day");


function getPrevExcelCommission()
    {
        $data = array();
        $data['from'] = "2018-02-01";
        $data['to'] = "2018-10-04";

        $data['udc_order_reports'] = User::whereHas('orders', function ($q) use ($data) {
            $q->where("created_at", ">=", $data['from']);
            $q->where("created_at", "<=", $data['to']);
            $q->where("status", '>', 1);
            $q->where("status", '!=', 5);

        })->with(['orders' => function ($q) use ($data) {

            $q->where("created_at", ">=", $data['from']);
            $q->where("created_at", "<=", $data['to']);
            $q->where("status", '>', 1);
            $q->where("status", '!=', 5);

        }])->orderBy('id', 'desc')->get();

        $writer = WriterFactory::create(Type::XLSX);
        $file_name = "commission-report-" . date("YmdHis") . ".xlsx";
        $filePath = base_path("tmp/" . $file_name);
        $adb = File::put($filePath, '');

        $writer->openToFile($filePath);
        $writer->addRow(array("Entrepreneurs ID", "Total Sales", "Total Commission"));
        foreach ($data['udc_order_reports'] as $key => $each_udc) {
            $user_orders = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5);
            $writer->addRow(array(
                @$each_udc->entrepreneur_id,
                (int)$user_orders->sum('total_price'),
                (int)$user_orders->sum('udc_commission')
            ));
        }
//        $writer->addRow(array("", "", "", "", "", "", "", ""));
//        $writer->addRow(array("", "", "", "", "", "Total Orders", "Total Sales", "Total Commission"));
        $writer->close();
        return Response::download($filePath, $file_name);
    }

    public function get_chart_data($start_date, $end_date, $date_format, $orders, $type)
    {
        $return_data = array();
        $date_func = $this->function_array[$date_format];
        $get_states = $orders->where('created_at', '>', $start_date->toDateTimeString());
        $get_states = $get_states->groupBy(function ($item) use ($date_format) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format("$date_format");
        });

        $get_states_count = $get_states->map(function ($item) use ($type) {
            if ($type == 1) {
                return collect($item)->sum('total_price');
            } elseif ($type == 'commission') {
                return collect($item)->sum('udc_commission');
            } else {
                return collect($item)->count();
            }
        });


        $collection_states = collect($get_states_count);

        $chart_labels = array();
        $array_get_states_count = '';
        for ($i = $start_date; $i <= $end_date; $i->$date_func()) {
            if ($date_format == 'd H') {
                $chart_labels[] = '"' . date('d H', strtotime($i)) . ":00" . '"';
            } else {
                $chart_labels[] = '"' . date("$date_format", strtotime($i)) . '"';
            }

            $value_i = date("$date_format", strtotime($i));

            if (Arr::exists($collection_states, $value_i) == false) {
                $array_get_states_count .= '0,';
                $get_states_count[$value_i] = 0;
            } else {
                $array_get_states_count .= $get_states_count[$value_i] . ',';
            }
        }

        $return_data['chart_values'] = rtrim($array_get_states_count, ',');
        $return_data['chart_labels'] = implode(', ', @$chart_labels);
        return $return_data;
    }

    public function get_order_chart_report($start_date, $end_date, $date_format, $orders, $type)
    {
        $return_data = array();
        $date_func = $this->function_array[$date_format];
        $get_states = $orders->where('created_at', '>', $start_date->toDateTimeString());
        $get_states = $get_states->groupBy(function ($item) use ($date_format) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format("$date_format");
        });
        $get_order_count = $get_states->map(function ($item) use ($type) {
            return collect($item)->count();
        });

        $get_sale_count = $get_states->map(function ($item) use ($type) {
            return collect($item)->sum('total_price');
        });

        $get_commission_count = $get_states->map(function ($item) use ($type) {
            return collect($item)->sum('udc_commission');
        });

        $collection = collect($get_order_count);

        $chart_labels = array();
        $total_sale_chart = array();
        $total_commission_chart = array();
        $array_get_order_count = '';
        for ($i = $start_date; $i <= $end_date; $i->$date_func()) {
            if ($date_format == 'd H') {
                $chart_labels[] = '"' . date('d H', strtotime($i)) . ":00" . '"';
            } else {
                $chart_labels[] = '"' . date("$date_format", strtotime($i)) . '"';
            }

            $value_i = date("$date_format", strtotime($i));

            if (Arr::exists($collection, $value_i) == false) {
                $array_get_order_count .= '0,';
                $get_order_count[$value_i] = 0;

                $total_sale_chart[] = 0;
                $get_sale_count[$value_i] = 0;

                $total_commission_chart[] = 0;
                $get_commission_count[$value_i] = 0;
            } else {
                $array_get_order_count .= $get_order_count[$value_i] . ',';
                $total_sale_chart[] = $get_sale_count[$value_i];
                $total_commission_chart[] = $get_commission_count[$value_i];
            }
        }

        $return_data['chart_order_values'] = rtrim($array_get_order_count, ',');
        $return_data['chart_sale_values'] = implode($total_sale_chart, ',');
        $return_data['chart_commission_values'] = implode($total_commission_chart, ',');
        $return_data['chart_labels'] = implode(', ', @$chart_labels);
        return $return_data;
    }

    public function orders_report(Request $request)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['orders'] = 'active';

        if ($request->from && $request->to) {
            $status = $request->status;
            $orders = Order::where(function ($sql) use ($status) {
                if ($status == 2 || $status == 2 || $status == 3 || $status == 4 || $status == 5) {
                    $sql->where('status', $status);
                }
            })->get();

            $date_format = 'M-d';
            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 00:00:00")));

            $data['from'] = $from2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from)));
            $data['to'] = $to2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to)));

            //CHART DATA
            $get_chart_data = $this->get_order_chart_report($from, $to, $date_format, $orders, '2');

            $data['chart_labels'] = $get_chart_data['chart_labels'];
            $data['chart_order_values'] = $get_chart_data['chart_order_values'];
            $data['chart_sale_values'] = $get_chart_data['chart_sale_values'];


            $chart_labels = explode(",", $data['chart_labels']);
            $chart_order_values = explode(",", $data['chart_order_values']);
            $chart_sale_values = explode(",", $data['chart_sale_values']);

        }

        if (@$request->export_type == 'csv') {

            $writer = WriterFactory::create(Type::CSV);
            $file_name = "order_report-" . date("YmdHis") . ".csv";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createExportFile($writer, $filePath, $chart_labels, $chart_order_values, $chart_sale_values);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'xlsx') {

            $writer = WriterFactory::create(Type::XLSX);
            $file_name = "order_report-" . date("YmdHis") . ".xlsx";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createExportFile($writer, $filePath, $chart_labels, $chart_order_values, $chart_sale_values);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'pdf') {

        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.reports.render_report_orders', $data)->render());
        } else {
            return view('admin.ekom.reports.report_orders')->with($data);
        }
    }

    public function createExportFile($writer, $filePath, $chart_labels, $chart_order_values, $chart_sale_values)
    {
        $writer->openToFile($filePath);
        $header_row = ['Slno', 'Date', 'Number of Orders', 'Sale Value'];
        $writer->addRow($header_row);

        foreach ($chart_labels as $key => $labels) {
            $index_datas = array(
                $key + 1,
                str_replace('"', "", $labels),
                (int)@$chart_order_values[$key],
                @$chart_sale_values[$key] ? number_format((int)$chart_sale_values[$key], 2, '.', '') : "0.00"
            );
            $writer->addRow($index_datas);
        }
        $writer->close();
        return;
    }

    public function sales_report(Request $request)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['sales'] = 'active';


        if ($request->from && $request->to) {
            $orders = Order::where(function ($sql) use ($request) {
                if ($request->ep_id != 'all') {
                    $sql->where('ep_id', $request->ep_id);
                }
                $sql->where('status', '!=', 5);
            })->get();

            $date_format = 'M-d';
            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 00:00:00")));

            $data['from'] = $from2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from)));
            $data['to'] = $to2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to)));

            //CHART DATA
            $get_chart_data = $this->get_order_chart_report($from, $to, $date_format, $orders, '2');

            $data['chart_labels'] = $get_chart_data['chart_labels'];
            $data['chart_order_values'] = $get_chart_data['chart_order_values'];
            $data['chart_sale_values'] = $get_chart_data['chart_sale_values'];

            $chart_labels = explode(",", $data['chart_labels']);
            $chart_order_values = explode(",", $data['chart_order_values']);
            $chart_sale_values = explode(",", $data['chart_sale_values']);

        }


        if (@$request->export_type == 'csv') {

            $writer = WriterFactory::create(Type::CSV);
            $file_name = "sales_report-" . date("YmdHis") . ".csv";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->saleExportFile($writer, $filePath, $chart_labels, $chart_order_values, $chart_sale_values);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'xlsx') {

            $writer = WriterFactory::create(Type::XLSX);
            $file_name = "sales_report-" . date("YmdHis") . ".xlsx";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->saleExportFile($writer, $filePath, $chart_labels, $chart_order_values, $chart_sale_values);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'pdf') {

        }


        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.reports.render_sales_reports', $data)->render());
        } else {
            $data['all_eps'] = EcommercePartner::where('status', 1)->get();
            return view('admin.ekom.reports.report_sales')->with($data);
        }
    }

    public function saleExportFile($writer, $filePath, $chart_labels, $chart_order_values, $chart_sale_values)
    {
        $writer->openToFile($filePath);
        $header_row = ['Slno', 'Date', 'Total Orders', 'Total Sales(tk)', 'Average Order Value'];
        $writer->addRow($header_row);

        foreach ($chart_labels as $key => $labels) {
            $index_datas = array(
                $key + 1,
                str_replace('"', "", $labels),
                $chart_order_values[$key],
                @$chart_sale_values[$key] ? number_format((int)$chart_sale_values[$key], 2) : "0.00",
                @$chart_order_values[$key] != 0 ? number_format(($chart_sale_values[$key] / $chart_order_values[$key]), 2) : '0.00'
            );
            $writer->addRow($index_datas);
        }
        $writer->close();
        return;
    }

    public function commissions_report(Request $request)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['commissions'] = 'active';

        if ($request->from && $request->to) {
            $orders = Order::where(function ($sql) use ($request) {
                if ($request->ep_id != 'all') {
                    $sql->where('ep_id', $request->ep_id);
                }
                $sql->where('status', '!=', 5);
                $sql->where('status', '>', 1);
            })->get();

            $date_format = 'M-d';
            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 00:00:00")));

            $data['from'] = $from2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from)));
            $data['to'] = $to2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to)));

            //CHART DATA
            $get_chart_data = $this->get_order_chart_report($from, $to, $date_format, $orders, '2');

            $data['chart_labels'] = $get_chart_data['chart_labels'];
            $data['chart_order_values'] = $get_chart_data['chart_order_values'];
            $data['chart_sale_values'] = $get_chart_data['chart_sale_values'];
            $data['chart_commission_values'] = $get_chart_data['chart_commission_values'];


            $chart_labels = explode(",", $data['chart_labels']);
            $chart_order_values = explode(",", $data['chart_order_values']);
            $chart_sale_values = explode(",", $data['chart_sale_values']);
            $chart_commission_values = explode(",", $data['chart_commission_values']);

        }

        if (@$request->export_type == 'csv') {

            $writer = WriterFactory::create(Type::CSV);
            $file_name = "commission_report-" . date("YmdHis") . ".csv";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->commissionExportFile($writer, $filePath, $chart_labels, $chart_order_values, $chart_sale_values, $chart_commission_values);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'xlsx') {

            $writer = WriterFactory::create(Type::XLSX);
            $file_name = "commission_report-" . date("YmdHis") . ".xlsx";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->commissionExportFile($writer, $filePath, $chart_labels, $chart_order_values, $chart_sale_values, $chart_commission_values);
            return Response::download($filePath, $file_name);

        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.reports.render_report_commissions', $data)->render());
        } else {
            $data['all_eps'] = EcommercePartner::where('status', 1)->get();
            return view('admin.ekom.reports.report_commissions')->with($data);
        }
    }

    public function commissionExportFile($writer, $filePath, $chart_labels, $chart_order_values, $chart_sale_values, $chart_commission_values)
    {
        $writer->openToFile($filePath);
        $header_row = ['Slno', 'Date', 'Orders', 'Sales', 'UDC Total Commission'];
        $writer->addRow($header_row);

        foreach ($chart_labels as $key => $labels) {
            $index_datas = array(
                $key + 1,
                str_replace('"', "", $labels),
                @$chart_order_values[$key],
                @$chart_sale_values[$key] ? number_format((int)$chart_sale_values[$key], 2) : "0.00",
                @$chart_commission_values[$key] ? number_format((int)$chart_commission_values[$key], 2) : "0.00"
            );
            $writer->addRow($index_datas);
        }
        $writer->close();
        return;
    }

    public function get_kpi_chart_data($start_date, $end_date, $date_format, $orders, $type, $kpi_value)
    {
        $return_data = array();
        $date_func = $this->function_array[$date_format];
        $get_states = $orders->where('created_at', '>=', $start_date->toDateTimeString())
            ->where('created_at', '<=', $end_date->toDateTimeString());


        $get_states = $get_states->groupBy(function ($item) use ($date_format) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format("$date_format");
        });

        $total_users = User::whereHas('udc_package')->where('status', 1)->get()->count();

        $get_states_count = $get_states->map(function ($item) use ($type, $total_users) {

            if ($type == 1) {
                return collect($item)->sum('total_price');
            } elseif ($type == 2) {
                return collect($item->where('status', 4))->sum('total_price');
            } elseif ($type == 3) {

                return number_format(collect($item)->count() / $total_users, 2);

            } elseif ($type == 4) {

                $count = 1;
                $duration = 0;
                foreach ($item as $each_order) {
                    $order_create_date = strtotime($each_order->created_at); // or your date as well
                    $order_completed_date = strtotime($each_order->updated_at);
                    $datediff = $order_completed_date - $order_create_date;
                    $duration += round($datediff / (60 * 60 * 24));
                    $count++;
                }
                $avg_delivery = ceil($duration / $count);

                return $avg_delivery;

            } else {
                return collect($item)->count();
            }

        });

        $collection_states = collect($get_states_count);

        $chart_labels = array();
        $kpi = array();
        $array_get_states_count = '';
        for ($i = $start_date; $i <= $end_date; $i->$date_func()) {
            if ($date_format == 'd H') {
                $chart_labels[] = '"' . date('d H', strtotime($i)) . ":00" . '"';
            } else {
                $chart_labels[] = '"' . date("$date_format", strtotime($i)) . '"';
            }
            $kpi[] = $kpi_value;
            $value_i = date("$date_format", strtotime($i));

            if (Arr::exists($collection_states, $value_i) == false) {
                $array_get_states_count .= '0,';
                $get_states_count[$value_i] = 0;
            } else {
                $array_get_states_count .= $get_states_count[$value_i] . ',';
            }

        }

        $return_data['chart_values'] = rtrim($array_get_states_count, ',');
        $return_data['chart_labels'] = implode(', ', @$chart_labels);
        $return_data['kpi'] = implode(', ', @$kpi);
        return $return_data;
    }

    public function kpi_report(Request $request)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['kpi'] = 'active';


        if (@$request->from && @$request->to) {

            $kpi_info = KpiReportSetting::first();

            $orders = Order::where(function ($sql) use ($request) {
                if ($request->ep_id != 'all') {
                    $sql->where('status', '!=', 5);
                }
            })->get();

            $date_format = 'M-d';

            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));

            $data['from'] = $from2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from)));
            $data['to'] = $to2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to)));

            //CHART DATA
            $kpi_value_title = $this->kpi_type[$request->kpi_type];
            $get_chart_data = $this->get_kpi_chart_data($from, $to, $date_format, $orders, $request->kpi_type, $kpi_info->$kpi_value_title);


            $data['chart_labels'] = $get_chart_data['chart_labels'];
            $data['kpi_chart_values'] = $get_chart_data['chart_values'];
            $data['kpi'] = $get_chart_data['kpi'];
            $data['kpi_type'] = $request->kpi_type;

            $kpi_meta_title = array("1" => "Sale value", "2" => "Total transaction", "3" => "Order per entrepreneur", "4" => "Average fulfilment");

            $chart_labels = explode(",", $data['chart_labels']);
            $kpi_chart_values = explode(",", $data['kpi_chart_values']);

        }

        if (@$request->export_type == 'csv') {

            $writer = WriterFactory::create(Type::CSV);
            $file_name = @$kpi_meta_title[@$request->kpi_type] . "_per_day_report-" . date("YmdHis") . ".csv";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $index_data = array('Slno', 'Date', @$kpi_meta_title[@$request->kpi_type]);
            $this->kpiExportFile($writer, $index_data, $filePath, $chart_labels, $kpi_chart_values);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'xlsx') {

            $writer = WriterFactory::create(Type::XLSX);
            $file_name = @$kpi_meta_title[@$request->kpi_type] . "_per_day_report-" . date("YmdHis") . ".xlsx";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $index_data = array('Slno', 'Date', @$kpi_meta_title[@$request->kpi_type]);
            $this->kpiExportFile($writer, $index_data, $filePath, $chart_labels, $kpi_chart_values);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'pdf') {

        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.reports.render_report_kpi', $data)->render());
        } else {
            return view('admin.ekom.reports.report_kpi')->with($data);
        }
    }

    public function kpiExportFile($writer, $header_row, $filePath, $chart_labels, $kpi_chart_values)
    {
        $writer->openToFile($filePath);
        $writer->addRow($header_row);

        foreach ($chart_labels as $key => $labels) {
            $index_datas = array(
                $key + 1,
                str_replace('"', "", @$labels),
                number_format(@$kpi_chart_values[$key], 2)
            );
            $writer->addRow($index_datas);
        }
        $writer->close();
        return;
    }

    public function udcOverviewExportFile($writer, $header_row, $filePath, $chart_data)
    {
        $chart_labels = explode(",", $chart_data['chart_labels']);
        $chart_onboard_member_values = explode(",", $chart_data['chart_onboard_member_values']);
        $chart_package_distributed_values = explode(",", $chart_data['chart_package_distributed_values']);
        $chart_deactivate_udc_values = explode(",", $chart_data['chart_deactivate_udc_values']);
        $chart_activate_udc_values = explode(",", $chart_data['chart_activate_udc_values']);

        $writer->openToFile($filePath);
        $writer->addRow($header_row);

        foreach ($chart_labels as $key => $labels) {
            $index_datas = array(
                $key + 1,
                str_replace('"', "", @$labels),
                number_format(@$chart_onboard_member_values[$key]),
                number_format(@$chart_package_distributed_values[$key]),
                number_format(@$chart_deactivate_udc_values[$key]),
                number_format(@$chart_activate_udc_values[$key])
            );
            $writer->addRow($index_datas);
        }
        $writer->close();
        return;
    }

    public function udc_overview(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['udc_overview'] = 'active';

        if ($request->from && $request->to) {
            $date_format = 'M-d';
            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));
            $reports = OverviewReport::where("created_at", ">=", $from)
                ->where("created_at", "<=", $to)
                ->get();
            //CHART DATA
            $get_chart_data = $this->get_overview_chart_report($from, $to, $date_format, $reports, '2');

            $data['chart_labels'] = $get_chart_data['chart_labels'];
            $data['chart_onboard_member_values'] = $get_chart_data['chart_onboard_member_values'];
            $data['chart_package_distributed_values'] = $get_chart_data['chart_package_distributed_values'];
            $data['chart_deactivate_udc_values'] = $get_chart_data['chart_deactivate_udc_values'];
            $data['chart_activate_udc_values'] = $get_chart_data['chart_activate_udc_values'];


            $data['total_udc'] = User::get()->where('user_type', 1)->count();

            $data['total_distributed_package'] = User::whereHas('udc_package', function ($q) {
                $q->where('is_selected', 1);
            })->where('user_type', 1)->get()->count();

            $data['total_deactivate_udc'] = User::where('status', 2)->where('user_type', 1)->get()->count();


            if (@$request->export_type == 'csv') {

                $writer = WriterFactory::create(Type::CSV);
                $file_name = "udc-overview-report" . date("YmdHis") . ".csv";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');
                $index_data = array('Slno', 'Date', 'user_member_on_board', 'package_distributed', 'deactivated_udc');
                $this->udcOverviewExportFile($writer, $index_data, $filePath, $get_chart_data);
                return Response::download($filePath, $file_name);

            } else if (@$request->export_type == 'xlsx') {

                $writer = WriterFactory::create(Type::XLSX);
                $file_name = "udc-overview-report" . date("YmdHis") . ".xlsx";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');
                $index_data = array('Slno', 'Date', 'user_member_on_board', 'package_distributed', 'deactivated_udc');
                $this->udcOverviewExportFile($writer, $index_data, $filePath, $get_chart_data);
                return Response::download($filePath, $file_name);
            }
        }


        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.reports.render_report_udc', $data)->render());
        } else {
            return view('admin.ekom.reports.udc_overview')->with($data);
        }
    }

    public function get_overview_chart_report($start_date, $end_date, $date_format, $reports, $type, $lp_id = '')
    {
        $return_data = array();
        $date_func = $this->function_array[$date_format];
        $get_states = $reports->where('created_at', '>=', $start_date->toDateTimeString());
        $get_states = $get_states->groupBy(function ($item) use ($date_format) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format("$date_format");
        });


        $get_onboard_member = $get_states->map(function ($item) use ($type, $lp_id) {
            $tmp = json_decode($item[0]->udc_overview_details);
            return $tmp->udc_member_onboard;
        });

        $get_package_distributed = $get_states->map(function ($item) use ($type, $lp_id) {
            if ($lp_id != '') {
                $tmp = json_decode($item[0]->logistic_overview_details);
                foreach ($tmp as $value) {
                    if ($lp_id == $value->lp_id) {
                        return $value->total_distributed_package;
                    }
                }
            } else {
                $tmp = json_decode($item[0]->udc_overview_details);
                return $tmp->package_distributed;
            }
        });

        $get_deactivate_udc = $get_states->map(function ($item) use ($type) {
            $tmp = json_decode($item[0]->udc_overview_details);
            return $tmp->deactivate_udc;
        });

        $get_activate_udc = $get_states->map(function ($item) use ($type) {
            $tmp = json_decode($item[0]->udc_overview_details);
            return $tmp->activate_udc;
        });

        $collection = collect($get_onboard_member);

        $chart_labels = array();
        $array_get_onboard_member = array();
        $array_get_deactivate_udc = array();
        $array_get_package_distributed = array();
        $array_get_activate_udc = array();
        for ($i = $start_date; $i <= $end_date; $i->$date_func()) {
            if ($date_format == 'd H') {
                $chart_labels[] = '"' . date('d H', strtotime($i)) . ":00" . '"';
            } else {
                $chart_labels[] = '"' . date("$date_format", strtotime($i)) . '"';
            }

            $value_i = date("$date_format", strtotime($i));

            if (Arr::exists($collection, $value_i) == false) {
                $array_get_onboard_member[] = 0;
                $get_onboard_member[$value_i] = 0;

                $array_get_package_distributed[] = 0;
                $get_package_distributed[$value_i] = 0;

                $array_get_deactivate_udc[] = 0;
                $get_deactivate_udc[$value_i] = 0;

                $array_get_activate_udc[] = 0;
                $get_activate_udc[$value_i] = 0;

            } else {
                $array_get_onboard_member[] = $get_onboard_member[$value_i];
                $array_get_package_distributed[] = $get_package_distributed[$value_i];
                $array_get_deactivate_udc[] = $get_deactivate_udc[$value_i];
                $array_get_activate_udc[] = $get_activate_udc[$value_i];
            }
        }

        $return_data['chart_onboard_member_values'] = implode($array_get_onboard_member, ',');
        $return_data['chart_package_distributed_values'] = implode($array_get_package_distributed, ',');
        $return_data['chart_deactivate_udc_values'] = implode($array_get_deactivate_udc, ',');
        $return_data['chart_activate_udc_values'] = implode($array_get_activate_udc, ',');
        $return_data['chart_labels'] = implode($chart_labels, ',');
        return $return_data;
    }

    public function udc_overview_cron_script()
    {
        $check_if_already_run = OverviewReport::where('created_at', '>=', Carbon::now()->startOfDay())->where('created_at', '<=', Carbon::now()->endOfDay())->first();

        if (!$check_if_already_run) {

            $starting_time = OverviewReport::orderBy('id', 'DESC')->first();
            if ($starting_time) {
                $start_date_time = $starting_time->created_at;
            } else {
                $start_date_time = Carbon::now()->startOfDay();
            }
            $overview_data = new OverviewReport();
            $logistic_json_details = array();
            $data = array();
            $udc_json_details = array();

            $package_distributed = array();
            $udcids = array();

            $package_distributed_udcs = LpShippingPackage::where('is_selected', 1)
                ->with(['user'], function ($query) {
                    $query->where('user_type', 1);
                })->get();

            foreach ($package_distributed_udcs as $key => $each) {
                if (!in_array($each->location_id, $udcids) && @$each->user->user_type == 1) { //CHECKING IF USER EXIST AND USER TYPE 1
                    $package_distributed[] = $each;
                }
                $udcids[] = $each->location_id;
            }
            $package_distributed = collect($package_distributed);

            $lp_info = LogisticPartner::with(['distributed_package' => function ($query) use ($start_date_time) {
                $query->where('created_at', '>=', $start_date_time);
                $query->where('created_at', '<=', Carbon::now()->endOfDay());
                $query->where('is_selected', 1);
            }])->get();

            foreach ($lp_info as $each_lp) {
                $data['lp_id'] = $each_lp->id;
                $data['lp_name'] = $each_lp->lp_name;
                $data['total_distributed_package'] = $each_lp->distributed_package->count();
                $logistic_json_details[] = $data;
            }

            $udc_json_details['udc_member_onboard'] = User::where('created_at', '>=', $start_date_time)->where('created_at', '<=', Carbon::now()->endOfDay())->count();
            $udc_json_details['package_distributed'] = $package_distributed->where('created_at', '>=', $start_date_time)->where('created_at', '<=', Carbon::now()->endOfDay())->count();
            $udc_json_details['deactivate_udc'] = User::where('status', 2)->where('updated_at', '>=', $start_date_time)->where('updated_at', '<=', Carbon::now()->endOfDay())->get()->count();
            $udc_json_details['activate_udc'] = User::where('status', 1)->where('updated_at', '>=', $start_date_time)->where('updated_at', '<=', Carbon::now()->endOfDay())->get()->count();
            $overview_data->udc_overview_details = json_encode($udc_json_details);
            $overview_data->logistic_overview_details = json_encode($logistic_json_details);
            $overview_data->save();
        }
    }

    public function logistic_overview(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['logistic_overview'] = 'active';
        $data['all_lps'] = LogisticPartner::all();

        if ($request->from && $request->to) {
            $date_format = 'M-d';
            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));
            $reports = OverviewReport::where("created_at", ">=", $from)->where("created_at", "<=", $to)->get();
            if ($request->lp_id == 'all') {
                //CHART DATA
                $get_chart_data = $this->get_overview_chart_report($from, $to, $date_format, $reports, '2');
            } else {
                //CHART DATA
                $get_chart_data = $this->get_overview_chart_report($from, $to, $date_format, $reports, '2', $request->lp_id);
            }


            $data['chart_labels'] = $get_chart_data['chart_labels'];
            $data['chart_onboard_member_values'] = $get_chart_data['chart_onboard_member_values'];
            $data['chart_package_distributed_values'] = $get_chart_data['chart_package_distributed_values'];
            $data['chart_deactivate_udc_values'] = $get_chart_data['chart_deactivate_udc_values'];
            $data['chart_activate_udc_values'] = $get_chart_data['chart_activate_udc_values'];

            $data['total_udc'] = User::get()->where('user_type', 1)->count();

            $data['total_distributed_package'] = User::whereHas('udc_package', function ($q) {
                $q->where('is_selected', 1);
            })->where('user_type', 1)->get()->count();


            if (@$request->export_type == 'csv') {

                $writer = WriterFactory::create(Type::CSV);
                $file_name = "logistic-overview-report" . date("YmdHis") . ".csv";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');
                $index_data = array('Slno', 'Date', 'user_member_on_board', 'package_distributed', 'deactivated_udc');
                $this->udcOverviewExportFile($writer, $index_data, $filePath, $get_chart_data);
                return Response::download($filePath, $file_name);

            } else if (@$request->export_type == 'xlsx') {

                $writer = WriterFactory::create(Type::XLSX);
                $file_name = "logistic-overview-report" . date("YmdHis") . ".xlsx";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');
                $index_data = array('Slno', 'Date', 'user_member_on_board', 'package_distributed', 'deactivated_udc');
                $this->udcOverviewExportFile($writer, $index_data, $filePath, $get_chart_data);
                return Response::download($filePath, $file_name);
            }
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.reports.render_report_logistic', $data)->render());
        } else {
            return view('admin.ekom.reports.logistic_overview')->with($data);
        }
    }

    public function udcCommissionReportExportFile($writer, $header_row, $filePath, $data)
    {
        $writer->openToFile($filePath);
        $writer->addRow($header_row);

        foreach ($data as $key => $value) {
            $index_datas = array(
                $key + 1,
            );
            $writer->addRow($index_datas);
        }
        $writer->close();
        return;
    }

    public function udc_commission_report(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['udc_commission'] = 'active';

        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;

        if ($request->from && $request->to && $request->ep_id) {

            if ($request->from) {
                $data['from'] = $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            } else {
                $data['from'] = $from = Carbon::now()->startOfMonth();
            }

            if ($request->to) {
                $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));
            } else {
                $data['to'] = $to = Carbon::now()->startOfMonth();
            }

            $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$to")));

            $data['ep_info'] = EcommercePartner::where('id', $request->ep_id)->first();

            $data['udc_order_reports'] = User::whereHas('orders', function ($q) use ($data, $request) {

                $q->where("created_at", ">=", $data['from']);
                $q->where("created_at", "<=", $data['to']);
                $q->where("status", '>', 1);
                $q->where("status", '!=', 5);

                if (@$request->ep_id != 'all') {
                    $q->where("ep_id", $data['ep_info']->id);
                }

            })->with(['orders' => function ($q) use ($data, $request) {

                $q->where("created_at", ">=", $data['from']);
                $q->where("created_at", "<=", $data['to']);
                $q->where("status", '>', 1);
                $q->where("status", '!=', 5);

                if (@$request->ep_id != 'all') {
                    $q->where("ep_id", $data['ep_info']->id);
                }

            }])
            ->orderBy('id', 'desc');

            if (@$request->export_type) {
                $data['udc_order_reports']= $data['udc_order_reports']->get();
            }else{
                $data['udc_order_reports']= $data['udc_order_reports']->paginate($this->row_per_page);
            }

            $data['total_orders'] = Order::where('status', '!=', 5)
                ->where('status', '>', 1)
                ->where("created_at", ">=", $from)
                ->where("created_at", "<=", $to)
                ->where(function ($q) use ($data, $request) {
                    if (@$request->ep_id != 'all') {
                        $q->where("ep_id", $data['ep_info']->id);
                    }
                })->get()->count();

            $data['total_sales'] = Order::where('status', '!=', 5)
                ->where('status', '>', 1)
                ->where("created_at", ">=", $from)
                ->where("created_at", "<=", $to)
                ->where(function ($q) use ($data, $request) {
                    if (@$request->ep_id != 'all') {
                        $q->where("ep_id", $data['ep_info']->id);
                    }
                })->get()->sum('total_price');

            $data['total_commission'] = Order::where('status', '!=', 5)
                ->where('status', '>', 1)
                ->where("created_at", ">=", $from)
                ->where("created_at", "<=", $to)
                ->where(function ($q) use ($data, $request) {
                    if (@$request->ep_id != 'all') {
                        $q->where("ep_id", $data['ep_info']->id);
                    }
                })->get()->sum('udc_commission');

            $ep_id = @$data['ep_info']->id;




            if (@$request->export_type == 'csv') {
                $writer = WriterFactory::create(Type::CSV);
                $file_name = "commission-report-" . date("YmdHis") . ".csv";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');

                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Center ID", "Phone Number", "Mobile Bank Numbers", "Total Orders", "Total Sale", "Total Commission"));

                foreach ($data['udc_order_reports'] as $key => $each_udc) {

                    if ($ep_id) {
                        $user_orders = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('ep_id', $ep_id);
                    } else {
                        $user_orders = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5);
                    }
                    $writer->addRow(array(
                        $key + 1,
                        @$each_udc->name_bn,
                        @$each_udc->center_id,
                        @$each_udc->contact_number,
                        'Bkash: ' . (@$each_udc->bkash_number ? '+88' . @$each_udc->bkash_number : '') . ' || ' . 'Rocket: ' . (@$each_udc->rocket_number ? '+88' . @$each_udc->rocket_number : ''),
                        (int)$user_orders->count(),
                        (int)$user_orders->sum('total_price'),
                        (int)$user_orders->sum('udc_commission')
                    ));
                }

                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "", "Total Orders", "Total Sales", "Total Commission"));
                $writer->addRow(array("", "", "", "", "", $data['total_orders'], $data['total_sales'], $data['total_commission']));
                $writer->close();
                return Response::download($filePath, $file_name);

            } else if (@$request->export_type == 'xlsx') {

                $writer = WriterFactory::create(Type::XLSX);
                $file_name = "commission-report-" . date("YmdHis") . ".xlsx";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');

                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Center ID", "Phone Number", "Mobile Bank Numbers", "Total Orders", "Total Sale", "Total Commission"));
                foreach ($data['udc_order_reports'] as $key => $each_udc) {
                    if ($ep_id) {
                        $user_orders = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('ep_id', $ep_id);
                    } else {
                        $user_orders = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5);
                    }
                    $writer->addRow(array(
                        $key + 1,
                        @$each_udc->name_bn,
                        @$each_udc->center_id,
                        '+88' . @$each_udc->contact_number,
                        'Bkash: ' . (@$each_udc->bkash_number ? '+88' . @$each_udc->bkash_number : '') . ' || ' . 'Rocket: ' . (@$each_udc->rocket_number ? '+88' . @$each_udc->rocket_number : ''),
                        (int)$user_orders->count(),
                        (int)$user_orders->sum('total_price'),
                        (int)$user_orders->sum('udc_commission')
                    ));
                }
                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "", "Total Orders", "Total Sales", "Total Commission"));
                $writer->addRow(array("", "", "", "", "", $data['total_orders'], $data['total_sales'], $data['total_commission']));
                $writer->close();
                return Response::download($filePath, $file_name);

            }

        }

        $data['all_eps'] = EcommercePartner::all();
        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.reports.render_udc_commission_report', $data)->render());
        } else {
            return view('admin.ekom.reports.udc_commission_report')->with($data);
        }
    }

    public function order_overview()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['order_overview'] = 'active';

        /*
         * TOTAL ORDERS
         * */
        $data['total_orders'] = Order::all();

        /*
         * DELIVERY ORDERS
         * */
        $data['delivered_orders'] = Order::where('status', 4)->get();

        /*
         * ORDERS LEFT FROM EP
         * */
        $data['warehouse_left_orders'] = Order::where('status', 2)->get();

        /*
         * ORDERS ON DELIVERY
         * */
        $data['on_delivery_orders'] = Order::where('status', 3)->get();

        /*
         * AVERAGE ORDER DELIVERY TIME
         * */
        $total_time = 0;
        foreach ($data['delivered_orders'] as $value) {
            $order_time = Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at);
            $delivery_time = Carbon::createFromFormat('Y-m-d H:i:s', $value->updated_at);
            $time_difference = $order_time->diffInDays($delivery_time, false);
            $total_time += $time_difference;
        }

        $total_delivery_orders = $data['delivered_orders']->count();
        $data['average_order_delivery_time'] = (int)ceil($total_time / $total_delivery_orders);

        /*
         * LAST TEN ACTIVE ORDERS
         * */
        $data['last_ten_active_orders'] = Order::orderBy('created_at', 'desc')->limit(10)->get();


        /*
         * LAST TEN DELIVERY ORDERS
         * */
        $data['last_ten_delivered_orders'] = Order::where('status', 4)->orderBy('created_at', 'desc')->limit(10)->get();

        /*
         * RENDER VIEW
         * */
        return view('admin.ekom.reports.order_overview')->with($data);

    }

    public function top_ten_active_orders(Request $request)
    {
        $data = array();
        $data['last_ten_active_orders'] = Order::where('created_at', '>=', $request->from . ' 00:00:00')
            ->where('created_at', '<=', $request->to . ' 23:59:59')
            ->where('status', '<', 3)
            ->orderBy('created_at', 'desc')
            ->limit(10)->get();
        return Response::json(View::make('admin.ekom.reports.top_ten_active_orders', $data)->render());
    }

    public function top_ten_delivered_orders(Request $request)
    {
        $data = array();
        $data['last_ten_delivered_orders'] = Order::where('created_at', '>=', $request->from . ' 00:00:00')
            ->where('created_at', '<=', $request->to . ' 23:59:59')
            ->where('status', 4)
            ->orderBy('created_at', 'desc')
            ->limit(10)->get();

        return Response::json(View::make('admin.ekom.reports.top_ten_delivered_orders', $data)->render());
    }

    public function recent_order_list(Request $request, $from = "", $to = "")
    {
        $meta = array();
        $response = array();

        $meta['page'] = $request->datatable['pagination']['page'];
        $meta['perpage'] = $request->datatable['pagination']['perpage'];
        $meta['sort'] = $request->datatable['sort']['sort'];
        $meta['field'] = $request->datatable['sort']['field'];

        if ($meta['field'] == 'status_badge') {
            $sort_field = 'status';
        } else {
            $sort_field = $meta['field'];
        }

        $orders = Order::where('status', '!=', 5)
            ->where('created_at', '>=', "$from")
            ->where('created_at', '<=', "$to")
            ->orderBy($sort_field, $meta['sort'])
            ->get();

        $meta['total'] = $orders->count();
        $meta['pages'] = $meta['total'] / $meta['perpage'];

        $start = ($meta['page'] - 1) * $meta['perpage'];
        $data['orders'] = $orders->slice($start, $meta['perpage']);


        foreach ($data['orders'] as $order) {

            $order_time = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at);
            $delivery_time = Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at);
            $order->process_time = $days = $order_time->diffInDays($delivery_time, false);

            $order_status = array("1" => "New", "2" => "Warehouse Left", "3" => "On Delivery", "4" => "Delivered");
            if ($days <= 2) {
                $order->status_badge = 1;
                $order->status = $order_status[$order->status];
            } else if ($days > 2 && $days <= 5) {
                $order->status_badge = 2;
                $order->status = $order_status[$order->status];
            } else if ($days > 5 && $days <= 7) {
                $order->status_badge = 3;
                $order->status = $order_status[$order->status];
            } else if ($days > 7) {
                $order->status_badge = 4;
                $order->status = $order_status[$order->status];
            }
        }

        $response = $data['orders'];

        $this->json($meta, $response);
    }

    public function ep_recent_order_list(Request $request, $from = "", $to = "")
    {
        $meta = array();
        $response = array();

        $meta['page'] = $request->datatable['pagination']['page'];
        $meta['perpage'] = $request->datatable['pagination']['perpage'];
        $meta['sort'] = $request->datatable['sort']['sort'];
        $meta['field'] = $request->datatable['sort']['field'];

        if ($meta['field'] == 'status_badge') {
            $sort_field = 'status';
        } else {
            $sort_field = $meta['field'];
        }
        
        $exception_array = array(
            6912,6913,6914,6915,6916,6917,6918,6919,6920,6921,6922, 
            11374, 11392, 11394, 11396, 11397, 11398, 11402, 11403,11404,11406,11407,11408,11410,11411,11412,11413,11414,11415,11416,11417,11418
        );
        
        $orders = Order::where('status', '!=', 5)
            ->whereNotIn('id', $exception_array)
            ->where('ep_id', Auth::guard('ep_admin')->user()->id)
            ->where('created_at', '>=', "$from")
            ->where('created_at', '<=', "$to")
            ->orderBy($sort_field, $meta['sort'])
            ->get();

        $meta['total'] = $orders->count();
        $meta['pages'] = $meta['total'] / $meta['perpage'];

        $start = ($meta['page'] - 1) * $meta['perpage'];
        $data['orders'] = $orders->slice($start, $meta['perpage']);


        foreach ($data['orders'] as $order) {

            $order_time = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at);
            $delivery_time = Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at);
            $order->process_time = $days = $order_time->diffInDays($delivery_time, false);

            $order_status = array("1" => "New", "2" => "Warehouse Left", "3" => "On Delivery", "4" => "Delivered");
            if ($days <= 2) {
                $order->status_badge = 1;
                $order->status = $order_status[$order->status];
            } else if ($days > 2 && $days <= 5) {
                $order->status_badge = 2;
                $order->status = $order_status[$order->status];
            } else if ($days > 5 && $days <= 7) {
                $order->status_badge = 3;
                $order->status = $order_status[$order->status];
            } else if ($days > 7) {
                $order->status_badge = 4;
                $order->status = $order_status[$order->status];
            }
        }

        $response = $data['orders'];

        $this->json($meta, $response);
    }

    public function lp_recent_order_list(Request $request, $from = "", $to = "")
    {
        $meta = array();
        $response = array();

        $meta['page'] = $request->datatable['pagination']['page'];
        $meta['perpage'] = $request->datatable['pagination']['perpage'];
        $meta['sort'] = $request->datatable['sort']['sort'];
        $meta['field'] = $request->datatable['sort']['field'];

        if ($meta['field'] == 'status_badge') {
            $sort_field = 'status';
        } else {
            $sort_field = $meta['field'];
        }

        $orders = Order::where('status', '!=', 5)
            ->where('lp_id', Auth::guard('lp_admin')->user()->id)
            ->where('created_at', '>=', "$from")
            ->where('created_at', '<=', "$to")
            ->orderBy($sort_field, $meta['sort'])
            ->get();

        $meta['total'] = $orders->count();
        $meta['pages'] = $meta['total'] / $meta['perpage'];

        $start = ($meta['page'] - 1) * $meta['perpage'];
        $data['orders'] = $orders->slice($start, $meta['perpage']);


        foreach ($data['orders'] as $order) {

            $order_time = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at);
            $delivery_time = Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at);
            $order->process_time = $days = $order_time->diffInDays($delivery_time, false);

            $order_status = array("1" => "New", "2" => "Warehouse Left", "3" => "On Delivery", "4" => "Delivered");
            if ($days <= 2) {
                $order->status_badge = 1;
                $order->status = $order_status[$order->status];
            } else if ($days > 2 && $days <= 5) {
                $order->status_badge = 2;
                $order->status = $order_status[$order->status];
            } else if ($days > 5 && $days <= 7) {
                $order->status_badge = 3;
                $order->status = $order_status[$order->status];
            } else if ($days > 7) {
                $order->status_badge = 4;
                $order->status = $order_status[$order->status];
            }
        }

        $response = $data['orders'];

        $this->json($meta, $response);
    }

    public function dc_recent_order_list(Request $request, $from = '', $to = '')
    {
        $meta = array();
        $response = array();

        $meta['page'] = $request->datatable['pagination']['page'];
        $meta['perpage'] = $request->datatable['pagination']['perpage'];
        $meta['sort'] = $request->datatable['sort']['sort'];
        $meta['field'] = $request->datatable['sort']['field'];

        if ($meta['field'] == 'status_badge') {
            $sort_field = 'status';
        } else {
            $sort_field = $meta['field'];
        }

        $orders = Order::where('status', '!=', 5)
            ->where('user_id', Auth::user()->id)
            ->where('created_at', '>=', "$from")
            ->where('created_at', '<=', "$to")
            ->orderBy($sort_field, $meta['sort'])
            ->get();

        $meta['total'] = $orders->count();
        $meta['pages'] = $meta['total'] / $meta['perpage'];

        $start = ($meta['page'] - 1) * $meta['perpage'];
        $data['orders'] = $orders->slice($start, $meta['perpage']);


        foreach ($data['orders'] as $order) {

            $order_time = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at);
            $delivery_time = Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at);
            $order->process_time = $days = $order_time->diffInDays($delivery_time, false);

            $order_status = array("1" => "New", "2" => "Warehouse Left", "3" => "On Delivery", "4" => "Delivered");
            if ($days <= 2) {
                $order->status_badge = 1;
                $order->status = $order_status[$order->status];
            } else if ($days > 2 && $days <= 5) {
                $order->status_badge = 2;
                $order->status = $order_status[$order->status];
            } else if ($days > 5 && $days <= 7) {
                $order->status_badge = 3;
                $order->status = $order_status[$order->status];
            } else if ($days > 7) {
                $order->status_badge = 4;
                $order->status = $order_status[$order->status];
            }
            $order_date = date('Y-m-d h:i a', strtotime($order->created_at));
            $order->order_date = $order_date;
        }

        $response = $data['orders'];

        $this->json($meta, $response);
    }

    public function json($meta = NULL, $response = NULL)
    {
        echo json_encode(array('meta' => $meta, 'data' => $response));
    }

    public function export()
    {
        $users = User::all();
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $header = Schema::getColumnListing('users');
        $csv->insertOne($header);
        foreach ($users as $user) {
            $csv->insertOne($user->toArray());
        }
        $csv->output("user.csv");
    }
    
    
   public function getrepeatedorders(Request $request)
    {
        $data['getrepeatedorders'] = $orders = OrderDetail::selectRaw('MAX(order_id) as order_id, MAX(product_url) as product_url, MAX(product_name) as product_name, count(ep_product_id) as total_number_of_orders, ep_product_id')
            ->whereNotNull('ep_product_id')
            ->with('order')
            ->groupBy('ep_product_id')
            ->orderBy('total_number_of_orders', 'desc')
            ->get()
            ->take(500);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.udc.dashboard.render-dashboard', $data)->render());
//        } else {
//            return view('admin.udc.dashboard.dashboard')->with($data);
//        }

//        dd($data['getrepeatedorders']);

        $writer = WriterFactory::create(Type::XLSX);
        $file_name = "repeated-orders-report" . date("YmdHis") . ".xlsx";
        $filePath = base_path("tmp/" . $file_name);
        $adb = File::put($filePath, '');
        $this->getrepeatedordersExportFile($writer, $filePath, $orders);
        return Response::download($filePath, $file_name);
    }
    public function getrepeatedordersExportFile($writer, $filePath, $orders)
    {
        $writer->openToFile($filePath);
        $header_row = ['Slno', 'EP Name', 'Product Name', ' Product Link' , 'Total Number of Orders'];
        $writer->addRow($header_row);
        foreach ($orders as $key => $value) {
            $index_datas = array(
                $key + 1,
                @$value->order->ep_name,
                @$value->product_name,
                @$value->product_url,
                @$value->total_number_of_orders,
            );
            $writer->addRow($index_datas);
        }
        $writer->close();
        return;
    }
    public function toptensearchedproducts(Request $request)
    {
        $top_searched_texts = SearchHistory::orderBy('total_hit', 'desc')->get()->take(10);
        $top_searched_products_arr = array();
        foreach ($top_searched_texts as $value){

            $order = OrderDetail::selectRaw('MAX(order_id) as order_id, MAX(product_name) as product_name, MAX(product_url) as product_url, count(ep_product_id) as total_number_of_orders, ep_product_id')
                ->whereNotNull('ep_product_id')
                ->with('order')
                ->groupBy('ep_product_id')
                ->orderBy('total_number_of_orders', 'desc')
                ->where('product_name', "like", "%$value->search_text%")
                ->get()->first();

            $top_searched_products_arr[] = $order;
        }

//        dd($top_searched_arr);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.udc.dashboard.render-dashboard', $data)->render());
//        } else {
//            return view('admin.udc.dashboard.dashboard')->with($data);
//        }

//        dd($data['getrepeatedorders']);

        $writer = WriterFactory::create(Type::XLSX);
        $file_name = "topsearched-products-report" . date("YmdHis") . ".xlsx";
        $filePath = base_path("tmp/" . $file_name);
        $adb = File::put($filePath, '');
        $this->toptensearchedproductsExportFile($writer, $filePath, $top_searched_products_arr, $top_searched_texts);
        return Response::download($filePath, $file_name);
    }
    public function toptensearchedproductsExportFile($writer, $filePath, $top_searched_products_arr, $top_searched_texts)
    {
        $writer->openToFile($filePath);
        $header_row = ['Slno','Product Name','Product Link', 'Searching String'];
        $writer->addRow($header_row);
        foreach ($top_searched_products_arr as $key => $value) {
            $index_datas = array(
                $key + 1,
                @$value->product_name,
                @$value->product_url,
                @$top_searched_texts[$key]->search_text,
            );
            $writer->addRow($index_datas);
        }
        $writer->close();
        return;
    }
    

}