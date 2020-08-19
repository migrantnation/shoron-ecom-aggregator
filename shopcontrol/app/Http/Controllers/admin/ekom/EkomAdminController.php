<?php

namespace App\Http\Controllers\admin\ekom;

use App\Libraries\ChangeOrderStatus;
use App\Libraries\PlxUtilities;
use App\models\EpStatistics;
use App\models\KpiReportSetting;
use App\models\LoginInformation;
use App\models\AdminUser;
use App\models\Notice;
use App\models\User;
use App\models\UserActivitiesLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\models\UdcCustomer;
use App\Libraries\EkomEncryption;
use App\Mail\LpCreate;
use App\models\CountryLocation;
use App\models\LogisticPartner;
use App\models\LpShippingPackage;
use App\models\Order;
use App\models\_ecom_Setting;
use App\models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Slim;
use App\models\EcommercePartner;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Arr;
use Validator;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Support\Facades\File;

class EkomAdminController extends Controller
{
    public $row_per_page = 10;

    private $function_array = array("d H" => "addHour", "M-d-D" => "addDay", "M-d" => "addDay", "Y-M" => "addMonth", "week" => "addWeek");
    private $time_subtraction_func = array("d H" => "subHour", "M-d-D" => "subDay", "M-d" => "subDay", "Y-M" => "subMonth", "week" => "addWeek");

    public function get_id_type()
    {
        $data['id'] = Auth::guard('web_admin')->user()->id;
        $data['user_type'] = 'Admin';
        return $data;
    }


    public function get_from_to_time($filter_range, $from, $to)
    {
        $date_format = 'M-d';
        if ($filter_range == 'all') {
            $from = Carbon::createFromDate(2018, 1, 31);
            $to = Carbon::now();
        } else if ($filter_range == 'day') {
            $date_format = 'd H';
            $from = Carbon::today();
            $to = Carbon::now()->endOfDay();
        } else if ($filter_range == 'week') {
            Carbon::setWeekStartsAt(Carbon::SATURDAY);
            $from = Carbon::now()->startOfWeek();
            Carbon::setWeekEndsAt(Carbon::FRIDAY);
            $to = Carbon::now()->endOfWeek();
        } else if ($filter_range == 'month') {
            $from = Carbon::now()->startOfMonth();
            $to = Carbon::now()->endOfMonth();
        } else if ($filter_range == 'lastmonth') {
            $from = new Carbon('first day of last month');
            $from = $from->startOfMonth();
            $to = new Carbon('last day of last month');
            $to = $to->endOfMonth();
        } else if ($filter_range == 'year') {
            $from = Carbon::now()->startOfYear();
            $to = Carbon::now()->endOfYear();
        } else if ($from && !$to) {
            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from . " 00:00:00")));
            $to = Carbon::now()->endOfMonth();
        } else if (!$from && $to) {
            $from = Carbon::createFromDate(2018, 1, 0);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to . " 23:59:59")));
        } else if ($from && $to) {
            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from . " 00:00:00")));
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to . " 23:59:59")));
        } else {
            $from = Carbon::now()->startOfMonth();
            $to = Carbon::now()->endOfMonth();
        }

        return array("from" => $from, "to" => $to, "date_format" => $date_format);
    }


    public function index(Request $request)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['dashboard'] = 'start active open';

        $data['filter_range'] = $request->filter_range = @$request->filter_range ? @$request->filter_range : 'month';
        $data['kpi_info'] = KpiReportSetting::where('kpi_type', "day")->first();

        $data['new_order'] = Order::where('status', '<', '2')->get();
        $orders = Order::where('status', '!=', 5)->get();


        $time_duration = $this->get_from_to_time($request->filter_range, $request->from, $request->to);
        $data['from'] = $from = $time_duration['from'];
        $data['to'] = $to = $time_duration['to'];
        $date_format = $time_duration['date_format'];

        $data['orders'] = Order::where('created_at', '>=', $from)->where('created_at', '<=', $to)->get();
        $data['canceled_orders'] = Order::where('created_at', '>=', $from)->where('created_at', '<=', $to)->where('status', '=', '5')->get();
        $data['order_completed'] = Order::where('status', '4')->where('created_at', '>=', $from)->where('created_at', '<=', $to)->get();
        $data['total_sales'] = $data['orders']->where('created_at', '>=', $from)->where('created_at', '<=', $to)->where('status', '!=', 5)->sum('total_price');
        $data['udc_commission'] = $orders->where('created_at', '>=', $from)->where('created_at', '<=', $to)->where('status', '!=', '5')->sum('udc_commission');


        /*Top Sales Chart*/
        $get_chart_data = $this->get_chart_data(clone $from, clone $to, $date_format, $orders, 1, 0);
        $data['sale_values'] = $get_chart_data['chart_values'];
        $data['sale_labels'] = $get_chart_data['chart_labels'];

        /*Order Stats*/
        $order_chart_data = $this->get_chart_data(clone $from, clone $to, $date_format, $orders, 2, 0);
        $data['order_chart_day_values'] = $order_chart_data['chart_values'];
        $data['order_day_array'] = $order_chart_data['chart_labels'];

        /*USER STATISTICS*/
        $data['registered_users'] = User::where('user_type', 1)->get();
        $data['active_users'] = User::whereHas('orders')->with(['orders'])->where('user_type', 1)->where('status', 1)->get();
        $data['activated_users'] = User::whereHas('udc_package')->where('user_type', 1)->where('status', 1)->get(); 
		$data['non_transacting_users'] = User::whereHas('udc_package')->where('user_type', 1)->where('status', 1)->doesntHave('orders')->get();

        $data['users_out_of_reach'] = User::whereDoesntHave('udc_package', function ($q) {
            $q->where('is_selected', 1);
        })->with(['orders'])->where('user_type', 1)->get();

//        $data['users_need_activation'] = User::whereHas('udc_package', function ($q) {
//            $q->where('is_selected', 1);
//        })->where('user_type', 1)->where(function($q){
//            $q->where('status', '=', 0);
//            $q->orWhere('status', '=', 2);
//        })->orWhere('status', '=', 2)->get();

        /*$data['users_need_activation'] = User::where(function($q){
            $q->where('status', '=', 0)->where('user_type', 1);
            $q->whereHas('udc_package', function ($q2) {
                $q2->where('is_selected', 1);
            });
        })->orWhere(function($q){
            $q->where('status', '=', 2)->where('user_type', 1);
            $q->whereHas('udc_package', function ($q2) {
                $q2->where('is_selected', 1);
            });
        })->get();*/
		
		
		
		$data['users_need_activation'] = User::whereHas('udc_package', function ($q) {
            $q->where('is_selected', 1);
        })->where('user_type', 1)
            ->where('status', '=', 0)
           // ->orWhere('status', '=', 2)
            ->get();

        $data['total_registered_users'] = $total = $data['registered_users']->count();
        $data['total_active_users'] = ($total > 0) ? ((100 / $total) * $data['active_users']->count()) : 0;
        $data['total_activated_users'] = $total ? ((100 / $total) * $data['activated_users']->count()) : 0;
        $data['total_users_out_of_reach'] = $total ? ((100 / $total) * $data['users_out_of_reach']->count()) : 0;
        $data['total_users_need_activation'] = $total ? ((100 / $total) * $data['users_need_activation']->count()) : 0;



        /*Order Statistics*/
        $total_orders = $data['orders']->count();
        $new_orders = $data['orders']->where('status', 1)->count();
        $total_warehouse_left_orders = $data['orders']->where('status', 2)->count();
        $total_on_delivery_orders = $data['orders']->where('status', 3)->count();
        $total_delivered_orders = $data['orders']->where('status', 4)->count();
        $total_cancel_orders = $data['orders']->where('status', 5)->count();

        $data['new'] = $total_orders ? ((100 / $total_orders) * $new_orders) : 0;
        $data['warehouse_left'] = $total_orders ? ((100 / $total_orders) * $total_warehouse_left_orders) : 0;
        $data['on_delivery'] = $total_orders ? ((100 / $total_orders) * $total_on_delivery_orders) : 0;
        $data['delivered'] = $total_orders ? ((100 / $total_orders) * $total_delivered_orders) : 0;
        $data['cancelled'] = $total_orders ? ((100 / $total_orders) * $total_cancel_orders) : 0;

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.dashboard.render-dashboard', $data)->render());
        } else {
            return view('admin.ekom.dashboard.dashboard')->with($data);
        }

    }


    public function active_user_graph(Request $request)
    {
        $data = $this->get_from_to_time($request->filter_range, $request->from, $request->to);
        $start_date = $data['from'];
        $end_date = $data['to'];
        $date_format = $data['date_format'];

        $data['active_user'] = User::whereHas('orders')->with(['orders'])
            ->where('user_type', 1)->where('status', 1)->get();

        /*ACTIVE USER*/
        $get_chart_data = $this->active_user_chart_data(clone $start_date, clone $end_date, $date_format);
        $data['active_user_values'] = $result['active_user_values'] = $get_chart_data['chart_values'];

        /*ACTIVATED USER*/
        $data['activated_dc'] = User::whereHas("udc_package")->where('user_type', 1)->where('status', 1)->get();
        $get_chart_data = $this->activated_user_chart_data(clone $start_date, clone $end_date, $date_format, $data['activated_dc']);
        $data['activated_user_values'] = $result['activated_user_values'] = $get_chart_data['chart_values'];
        $data['user_labels'] = $result['user_labels'] = $get_chart_data['chart_labels'];

        return Response::json(View::make('admin.ekom.dashboard.render-active-user-graph', $data)->render());
    }

    public function cancel_order_graph(Request $request)
    {
        $data = $this->get_from_to_time($request->filter_range, $request->from, $request->to);
        $from = $data['from'];
        $to = $data['to'];
        $date_format = $data['date_format'];

        //$data['orders'] = $orders = Order::where('status', '!=', 5)->get();
		
		$orders = Order::where('status', '!=', 5)->get();
		
		$data['orders'] = Order::where('created_at', '>=', $from->toDateTimeString())
            ->where('created_at', '<=', $to->toDateTimeString())
            ->get();

        /*ACTIVE ORDER CHART VALUE*/
        $order_chart_data = $this->get_chart_data(clone $from, clone $to, $date_format, $orders, 2, 0);
        $data['order_chart_values'] = $order_chart_data['chart_values'];

        /*Canceled Order */
        $data['canceled_orders'] = Order::where('created_at', '>=', $from)->where('created_at', '<=', $to)->where('status', '=', '5')->get();
        $get_chart_data = $this->get_chart_data(clone $from, clone $to, $date_format, $data['canceled_orders'], 'count', 0);
        $data['canceled_order_values'] = $get_chart_data['chart_values'];
        $data['active_cancel_graph_labels'] = $get_chart_data['chart_labels'];

        return Response::json(View::make('admin.ekom.dashboard.render-cancel-order-graph', $data)->render());
    }

    public function ep_statistics_graph(Request $request)
    {
        $data = $this->get_from_to_time($request->filter_range, $request->from, $request->to);
        $from = $data['from'];
        $to = $data['to'];
        $date_format = $data['date_format'];


        $ep = EcommercePartner::with(['ep_statistics' => function ($q) use ($from, $to) {
            $q->where('created_at', '>=', $from);
            $q->where('created_at', '<=', $to);
        }])->where('status', 1)->where('status', 1)->orderBy('id', 'desc')->get();

        $ep_name_labels = array();
        $statistics_chart_labels = array();
        $statistics_chart_values = array();
        $i = 0;
        foreach ($ep as $value) {
            $ep_name_labels[] = $value->ep_name;
            $this_ep_cart_data = $this->get_chart_data(clone $from, clone $to, $date_format, $value->ep_statistics, 'ep_statistics', 0);
            if ($i == 0) {
                $statistics_chart_labels = $this_ep_cart_data['chart_labels'];
            }
            $statistics_chart_values[] = $this_ep_cart_data['chart_values'];
            $i++;
        }

        $data['ep_name_labels'] = '"' . implode('", "', $ep_name_labels) . '"';
        $data['statistics_chart_labels'] = $statistics_chart_labels;
        $data['statistics_chart_values'] = '[' . implode('], [', $statistics_chart_values) . ']';

        return Response::json(View::make('admin.ekom.dashboard.render-ep-statistics-graph', $data)->render());
    }

    public function visitors(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';

        $data = $this->get_from_to_time($request->filter_range, $request->from, $request->to);
        $from = $data['from'];
        $to = $data['to'];
        $date_format = $data['date_format'];

        $data['todays_visitor'] = LoginInformation::where('created_at', '>', $from)->where('created_at', '<', $to)->get()->count();
        $all_visitors = LoginInformation::get();
        $all_visitors = $this->get_chart_data(clone $from, clone $to, $date_format, $all_visitors, 'daily_visitor_count', 0);
        $data['daily_visitor_values'] = $all_visitors['chart_values'];
        $data['daily_visitor_labels'] = $all_visitors['chart_labels'];

        return Response::json(View::make('admin.ekom.dashboard.render-visitor-graph', $data)->render());
    }

    public function top_users(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';

        $data = $this->get_from_to_time($request->filter_range, $request->from, $request->to);
        $from = $data['from'];
        $to = $data['to'];
        $date_format = $data['date_format'];

        $data['udc_agents'] = User::whereHas('orders', function ($query) use ($from, $to) {
            $query->where('status', '!=', '5');
            $query->where('created_at', '>=', $from);
            $query->where('created_at', '<=', $to);
        })->with(['orders' => function ($query) use ($from, $to) {
            $query->where('status', '!=', '5');
            $query->where('created_at', '>=', $from);
            $query->where('created_at', '<=', $to);
        }])->where('user_type', 1)->get()->map(function ($user, $key) {
            $user->total_purchase = $user->orders->sum('total_price');
            $user->total_orders = $user->orders->count();
            return $user;
        })->sortByDesc('total_purchase')->take(10);

        return Response::json(View::make('admin.ekom.dashboard.render-top-user', $data)->render());
    }

    public function _ecom__partners(Request $request)
    {
        $data = $this->get_from_to_time($request->filter_range, $request->from, $request->to);
        $from = $data['from'];
        $to = $data['to'];

        $data['active_ep'] = EcommercePartner::with(["orders" => function ($q) use ($from, $to) {
            $q->where('created_at', '>=', $from);
            $q->where('created_at', '<=', $to);
        }])->get();

        $data['active_lp'] = LogisticPartner::with(["orders" => function ($q) use ($from, $to) {
            $q->where('created_at', '>=', $from);
            $q->where('created_at', '<=', $to);
        }])->get();

        return Response::json(View::make('admin.ekom.dashboard.render-_ecom_-partners', $data)->render());
    }

    public function sale_per_day()
    {
        $kpi_from = Carbon::create(2018, 1, 31, 00, 00, 00);
        $kpi_to = Carbon::now();
        $kpi_datediff = $kpi_from->diffInDays($kpi_to);
        $kpi_datediff = ($kpi_datediff < 1) ? 1 : $kpi_datediff;

        $data['kpi_info'] = KpiReportSetting::where('kpi_type', "day")->first();
        $orders = Order::where('status', '!=', 5)->get();

        // SALES PER DAY
        $data['sale_value_per_day'] = $orders->sum('total_price') / $kpi_datediff;
        $get_chart_data = $this->get_kpi_week_chart_data(clone $kpi_from, clone $kpi_to, $orders, $data['kpi_info']->sale_per_day);
        $data['sale_chart_values'] = $get_chart_data['chart_values'];
        $data['sale_chart_kpi_values'] = $get_chart_data['kpi_values'];
        $data['chart_labels'] = $get_chart_data['chart_labels'];

        return Response::json(View::make('admin.ekom.dashboard.render-kpi-graph-sale-per-day', $data)->render());
    }

    public function transaction_per_day()
    {
        $kpi_from = Carbon::create(2018, 1, 31, 00, 00, 00);
        $kpi_to = Carbon::now();
        $kpi_datediff = $kpi_from->diffInDays($kpi_to);
        $kpi_datediff = ($kpi_datediff < 1) ? 1 : $kpi_datediff;

        $data['kpi_info'] = KpiReportSetting::where('kpi_type', "day")->first();
        $orders = Order::where('status', '!=', 5)->get();

        // TRANSACTION PER DAY
        $data['total_transaction_per_day'] = $orders->where('status', 4)->sum('total_price') / $kpi_datediff;
        $get_chart_data = $this->get_kpi_week_chart_data(clone $kpi_from, clone $kpi_to, $orders->where('status', 4), $data['kpi_info']->total_transaction_per_day);
        $data['transaction_chart_values'] = $get_chart_data['chart_values'];
        $data['transaction_chart_kpi_values'] = $get_chart_data['kpi_values'];
        $data['transaction_chart_labels'] = $get_chart_data['chart_labels'];

        return Response::json(View::make('admin.ekom.dashboard.render-kpi-graph-transaction-per-day', $data)->render());
    }

    public function order_per_entrepreneur_per_day()
    {
        $kpi_from = Carbon::create(2018, 1, 31, 00, 00, 00);
        $kpi_to = Carbon::now();
        $kpi_datediff = $kpi_from->diffInDays($kpi_to);
        $kpi_datediff = ($kpi_datediff < 1) ? 1 : $kpi_datediff;
        $date_format = 'M-d';

        $data['kpi_info'] = KpiReportSetting::where('kpi_type', "day")->first();
        $data['orders'] = $orders = Order::where('status', '!=', 5)->get();

        // ORDER PER ENTREPRENEUR PER DAY
        $total_users = User::whereHas("udc_package", function ($q) {
            $q->where('is_selected', 1);
        })->where('status', 1)->get()->count();

        $data['order_per_entrepreneur_per_day'] = (($data['orders']->count() / $total_users) / $kpi_datediff);

        // ORDER PER ENTREPRENEUR PER DAY
        $get_chart_data = $this->get_kpi_chart_data(clone $kpi_from, clone $kpi_to, $date_format, $data['orders'], 3, $data['kpi_info']->order_per_entrepreneur_per_day);
        $data['ord_pr_ent_pr_dy_crt_vals'] = $get_chart_data['chart_values'];
        $data['ord_pr_ent_pr_dy_crt_kpi_vals'] = $get_chart_data['kpi_values'];
        $data['ord_pr_ent_pr_dy_crt_lbls'] = $get_chart_data['chart_labels'];

        return Response::json(View::make('admin.ekom.dashboard.render-kpi-graph-opepd-per-day', $data)->render());
    }

    public function average_delivery_time()
    {
        $kpi_from = Carbon::create(2018, 1, 31, 00, 00, 00);
        $kpi_to = Carbon::now();

        $data['kpi_info'] = KpiReportSetting::where('kpi_type', "day")->first();

        // SALES PER DAY
        $completed_orders = Order::where('status', '4')->get();
        if ($completed_orders) {
            $count = 1;
            $duration = 0;
            foreach ($completed_orders as $each_order) {
                $order_create_date = strtotime($each_order->created_at); // or your date as well
                $order_completed_date = strtotime($each_order->updated_at);
                $datediff = $order_completed_date - $order_create_date;
                $duration += round($datediff / (60 * 60 * 24));
                $count++;
            }
            $data['average_order_delivery_time'] = ($duration / $count);
        }
        /*AVERAGE DELIVERY CHART*/
        $average_data = $this->average_delivery_chart($completed_orders, $data['kpi_info']->average_fulfillment_time);
        $data['avg_delivery'] = $average_data['avg_delivery'];
        $data['avg_delivery_kpi_values'] = @$average_data['kpi_values'];
        $data['avg_delivery_lbl'] = $average_data['avg_delivery_lbl'];

        return Response::json(View::make('admin.ekom.dashboard.render-kpi-graph-average-delivery-time', $data)->render());
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
        $return_data['kpi_values'] = implode(', ', @$kpi);
        return $return_data;
    }

    public function average_delivery_chart($completed_orders, $kpi_value)
    {
        $data = array();
        $avg_date_format = 'Y-M';
        $start_date = Carbon::createFromDate(2018, 1, 5);
        $end_date = Carbon::now();
        $date_func = $this->function_array[$avg_date_format];
        $get_states = $completed_orders->where('created_at', '>', $start_date->toDateTimeString());
        $get_states = $get_states->groupBy(function ($item) use ($avg_date_format) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format("$avg_date_format");
        });

        $get_states_count = $get_states->map(function ($item) {
            if ($item->count() > 0) {
                $count = 1;
                $duration = 0;
                foreach ($item as $each_order) {
                    $order_create_date = strtotime($each_order->created_at); // or your date as well
                    $order_completed_date = strtotime($each_order->updated_at);
                    $datediff = $order_completed_date - $order_create_date;
                    $duration += round($datediff / (60 * 60 * 24));
                    $count++;
                }
                $avg_delivery = ceil(($duration / $count));
            }
            return $avg_delivery;
        });

        $collection_states = collect($get_states_count);

        $chart_labels = array();
        $kpi = array();
        $array_get_states_count = '';
        for ($i = Carbon::createFromDate(2018, 1, 5); $i <= Carbon::now(); $i->$date_func()) {
            if ($avg_date_format == 'd H') {
                $chart_labels[] = date('d H', strtotime($i)) . ":00";
            } else {
                $chart_labels[] = '"' . date("$avg_date_format", strtotime($i)) . '"';
            }

            $kpi[] = $kpi_value;

            $value_i = date("$avg_date_format", strtotime($i));

            if (Arr::exists($collection_states, $value_i) == false) {
                $array_get_states_count .= '0,';
                $get_states_count[$value_i] = 0;
            } else {
                $array_get_states_count .= $get_states_count[$value_i] . ',';
            }
        }
        $data['avg_delivery'] = rtrim($array_get_states_count, ',');
        $data['kpi_values'] = implode(', ', @$kpi);
        $data['avg_delivery_lbl'] = implode(', ', @$chart_labels);
        return $data;
    }

    public function calculate_grow($v1, $v2)
    {
        if ($v1 == 0) {
            return $v2;
        } elseif ($v2 == 0) {
            return $v1;
        } else {
            return number_format(((($v2 - $v1) / $v1) * 100), 0);
        }
    }

    public function activated_user_chart_data($start_date, $end_date, $date_format, $activated_user)
    {
        $return_data = array();
        $date_func = $this->function_array[$date_format];

        $chart_labels = array();
        $array_get_states_count = array();
        for ($i = $start_date; $i <= $end_date; $i->$date_func()) {
            if ($date_format == 'd H') {
                $chart_labels[] = '"' . date('d H', strtotime($i)) . ":00" . '"';
            } else {
                $chart_labels[] = '"' . date("$date_format", strtotime($i)) . '"';
            }

            if ($i->toDateTimeString() <= Carbon::now()) {
                $get_data = $activated_user->where('created_at', '<=', $i->toDateTimeString());
                $array_get_states_count[] = $get_data->count();
            } else {
                $array_get_states_count[] = 0;
            }
        }

        $return_data['chart_values'] = implode(', ', @$array_get_states_count);
        $return_data['chart_labels'] = implode(', ', @$chart_labels);
        return $return_data;
    }

    public function active_user_chart_data($start_date, $end_date, $date_format)
    {
        $return_data = array();
        $date_func = $this->function_array[$date_format];

        $chart_labels = array();
        $array_get_states_count = array();
        for ($i = $start_date; $i <= $end_date; $i->$date_func()) {
            if ($date_format == 'd H') {
                $chart_labels[] = '"' . date('d H', strtotime($i)) . ":00" . '"';
            } else {
                $chart_labels[] = '"' . date("$date_format", strtotime($i)) . '"';
            }

            if ($i->toDateTimeString() <= Carbon::now()) {
                $get_data = User::where('user_type', 1)->where('status', 1)
                    ->whereHas('orders', function ($q) use ($i, $start_date) {
                        $q->where('created_at', '<=', $i->toDateTimeString());
                    });
                $array_get_states_count[] = $get_data->count();
            } else {
                $array_get_states_count[] = 0;
            }
        }

        $return_data['chart_values'] = implode(', ', @$array_get_states_count);
        $return_data['chart_labels'] = implode(', ', @$chart_labels);
        return $return_data;
    }

    public function get_chart_data($start_date, $end_date, $date_format, $orders, $type, $kpi_value)
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
        $return_data['kpi_values'] = implode(', ', @$kpi);
        $return_data['chart_labels'] = implode(', ', @$chart_labels);
        return $return_data;
    }

    public function get_kpi_week_chart_data($start_date, $end_date, $data, $kpi_value)
    {
        $return_data = array();
        $chart_labels = array();
        $chart_values = array();
        $kpi = array();

        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $start_date2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($start_date)));
        $end_date2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($end_date)));

        $end_date_of_last_week = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($end_date2->endOfWeek())));

        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($start_date->startOfWeek())));
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($start_date2->endOfWeek())));

        $i = 1;
        do {
            $this_week_data = $data->where('created_at', '>=', $start_date->toDateTimeString())->where('created_at', '<=', $end_date->toDateTimeString())->sum('total_price');
            $average = ($this_week_data / 7);
            $chart_values[] = '"' . number_format($average, 0, '', '') . '"';
            $kpi[] = $kpi_value;
            $chart_labels[] = '"' . date("M-d", strtotime($start_date)) . '"';

            $start_date = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($start_date->addDay(7))));
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($start_date2->addDay(7))));

            $i++;
        } while ($end_date->toDateTimeString() <= $end_date_of_last_week->toDateTimeString());

        $return_data['chart_values'] = implode(', ', @$chart_values);
        $return_data['kpi_values'] = implode(', ', @$kpi);
        $return_data['chart_labels'] = implode(', ', @$chart_labels);

        return $return_data;
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

    public function json($meta = NULL, $response = NULL)
    {
        echo json_encode(array('meta' => $meta, 'data' => $response));
    }

    public function ep_statistics_get_chart_data($start_date, $end_date, $date_format, $ep_statistics, $type)
    {

        $date_func = $this->function_array[$date_format];
        $return_data = array();
        $ep_name_labels = array();
        $chart_labels = array();
        $array_get_states_count = '';
        $chart_values = '';
        $ii = 0;
//        echo '<pre>';
        foreach ($ep_statistics as $each_ep_statistic) {

            if ($ii == 3) {
                break;
            }
            $ep_name_labels[] = '"' . $each_ep_statistic->ep_name . '"';
            $get_states = $each_ep_statistic->ep_statistics;

            $get_states = $get_states->groupBy(function ($item) use ($date_format) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format("$date_format");
            });

            $get_states_count = $get_states->map(function ($item) {
                return collect($item)->count();
            });

            $collection_states = collect($get_states_count);
            print_r($collection_states);
            for ($i = $start_date; $i <= $end_date; $i->$date_func()) {

                if ($ii == 0) {
                    if ($date_format == 'd H') {
                        $chart_labels[] = '"' . date('d H', strtotime($i)) . ":00" . '"';
                    } else {
                        $chart_labels[] = '"' . date("$date_format", strtotime($i)) . '"';
                    }
                }

                $value_i = date("$date_format", strtotime($i));

                if (Arr::exists($collection_states, $value_i) == false) {
                    $array_get_states_count .= '0,';
                    $get_states_count[$value_i] = 0;
                } else {
                    $array_get_states_count .= $get_states_count[$value_i] . ',';
                }
                print_r($get_states_count);
            }
            $ii++;
            $chart_values .= "[" . rtrim($array_get_states_count, ',') . "],";

        }

        $return_data['ep_name_labels'] = implode(', ', @$ep_name_labels);
        $return_data['chart_labels'] = implode(', ', @$chart_labels);
        $return_data['chart_values'] = rtrim($chart_values, ',');

//        dd($return_data);

        return $return_data;
    }

    public function profile()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['dashboard'] = 'start active';
        $data['admin_info'] = AdminUser::where('id', Auth::guard('web_admin')->user()->id)->first();
        return view('admin.ekom.admin_profile')->with($data);
    }

    public function update_profile(Request $request)
    {
        $admin_user = Auth::guard('web_admin')->user();

        if ($request->get('current_password')) {
            if (!(Hash::check($request->get('current_password'), Auth::guard('web_admin')->user()->password))) {
                // The passwords matches
                return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
            }
            if (strcmp($request->get('current_password'), $request->get('password')) == 0) {
                //Current password and new password are same
                return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
            }
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'password' => 'required|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                //Change Password
                $admin_user->password = bcrypt($request->password);
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:admin_users,id, ' . Auth::guard('web_admin')->user()->id
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            //Change Password
            $admin_user->email = $request->get('email');
            $admin_user->name = $request->get('name');
            $admin_user->save();
            return redirect('admin/updatee_logout');
        }
    }

    public function changePassword(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success", "Password changed successfully !");

    }

    public function logout()
    {
        Auth::logout();
        return redirect('admin/login');
    }

    public function supperAdmin()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';

        return view('admin.not-found')->with($data);

//        return view('admin.ekom.staff.super_admin_list')->with($data);
    }

    public function supperAdminCreate()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';
        return view('admin.ekom.staff.super_admin_create')->with($data);
    }

    public function supperAdminEdit()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';
        return view('admin.ekom.staff.super_admin_edit')->with($data);
    }

    public function customerSupport()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';

        return view('admin.not-found')->with($data);

//        return view('admin.ekom.staff.customer_support_list')->with($data);
    }

    public function customerSupportCreate()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';
        return view('admin.ekom.staff.customer_support_create')->with($data);
    }

    public function customerSupportEdit()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';
        return view('admin.ekom.staff.customer_support_edit')->with($data);
    }

    public function accountant()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';

        return view('admin.not-found')->with($data);

//        return view('admin.ekom.staff.accountant_list')->with($data);
    }

    public function accountantCreate()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';
        return view('admin.ekom.staff.accountant_create')->with($data);
    }

    public function accountantEdit()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';
        return view('admin.ekom.staff.accountant_edit')->with($data);
    }

    public function resolutionManager()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['staff_management'] = 'start active open';

        return view('admin.not-found')->with($data);

//        return view('admin.ekom.staff.resolution_manager_list')->with($data);
    }

    public function resolutionManagerCreate()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.staff.resolution_manager_create')->with($data);
    }

    public function resolutionManagerEdit()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.staff.resolution_manager_edit')->with($data);
    }

    public function _ecom__orders(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['order_management'] = 'start active open';
        $data['all_ep'] = 'active';
        $data['url'] = url('admin/orders/ep-orders');


        //Change Order Status
        if ($request->order_code) {
            $change_status = new ChangeOrderStatus();
            $change_status->change_order_status($request->order_code);
        }

        $data['limit'] = $limit = $request->limit ? $request->limit : 15;
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $limit) + 1 : 1;

        $data['all_orders'] = Order::orderBy('id', 'desc');
        if ($request->search_string || $request->from || $request->to || $request->limit == 'all') {

            $data['all_orders'] = Order::where(function ($query) use ($request) {

                if (@$request->from != '') {
                    $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
                }
                if (@$request->to != '') {
                    $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));
                }

            })->where(function ($query) use ($request) {

                $query->where('order_code', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('lp_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('ep_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('delivery_location', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('receiver_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('receiver_contact_number', 'LIKE', '%' . $request->search_string . '%');

            })->orderBy('id', 'desc');
        }

        if (isset($request->tab_id) && $request->tab_id != 'all' && $request->tab_id != '6')
            $data['all_orders'] = $data['all_orders']->where('status', '=', $request->tab_id);
        else if ($request->tab_id == '6')
            $data['all_orders'] = $data['all_orders']->where('ep_order_id', null);


        $data['total_price'] = $data['all_orders']->sum('total_price');
        $data['total_commission'] = $data['all_orders']->sum('udc_commission');
        $data['total_orders'] = $data['all_orders']->count();

        if (@$request->export_type || @$request->limit == 'all')
            $data['all_orders'] = $data['all_orders']->get();
        else
            $data['all_orders'] = $data['all_orders']->paginate($limit)->withPath('?tab_id=' . $request->tab_id);


        if (@$request->export_type == 'csv') {

            $writer = WriterFactory::create(Type::CSV);
            $file_name = "order_list-" . date("YmdHis") . ".csv";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createExportFile($writer, $data['all_orders'], $filePath);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'xlsx') {

            $writer = WriterFactory::create(Type::XLSX);
            $file_name = "order_list-" . date("YmdHis") . ".xlsx";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createExportFile($writer, $data['all_orders'], $filePath);
            return Response::download($filePath, $file_name);

        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.orders.render_ep_order_list', $data)->render());
        } else {
            return view('admin.ekom.orders.ep_order_list')->with($data);
        }
    }


    public function createExportFile($writer, $orders, $filePath)
    {
        $writer->openToFile($filePath);
        $header_row = ["Slno", "Order ID", "Order Date", "Delivery Duration", "EP Name", "LP Name",
            "Digital Center Name", "Center ID", "Entrepreneur Name", "Entrepreneur Contact Number", "District",
            "Union", "Total price", "Order Status",
        ];
        $writer->addRow($header_row);

        $order_status = array("", "Active", "Warehouse left", "In Transit", "Delivered", "Canceled");
        foreach ($orders as $key => $order) {
            $index_datas = array(
                $key + 1,
                @$order->order_code,
                date("Y-m-d H:i:s", strtotime(@$order->created_at)),
                @$order->delivery_duration,
                @$order->ep_name,
                @$order->lp_name,
                @$order->user->center_name,
                @$order->user->center_id,
                @$order->user->name_bn,
                @$order->user->contact_number,
                @$order->user->district,
                @$order->user->union,
                @$order->total_price,
                @$order_status[@$order->status],
            );
            $writer->addRow($index_datas);
        }

        $total_row = [
            "", "", "", "", "", "", "", "", "Total Orders ", "", $orders->count(),
            "Total Price ", $orders->sum('total_price'), "",
        ];
        $writer->addRow($total_row);

        $writer->close();
        return;
    }

    //UNLINKED PAGES

    public function settings()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['settings'] = 'start active';
        $data['setting_info'] = _ecom_Setting::first();

        return view('admin.ekom.settings')->with($data);
//        return view('admin.not-found')->with($data);
    }

    public function update_setting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mode' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect("admin/settings")->withErrors($validator)->withInput();
        } else {
            $mode_info = new _ecom_Setting();
            if ($request->mode_id) {
                $mode_info = _ecom_Setting::find($request->mode_id);
            }
            $mode_info->application_mode = $request->mode;
            $mode_info->save();
            return redirect("admin/settings");
        }
    }

    public function report_management()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active';
        return view('admin.not-found')->with($data);
    }

    public function activity_management()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['activity_management'] = 'start active';
        return view('admin.not-found')->with($data);
    }

    public function purchase_management()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['purchase_management'] = 'start active';
        return view('admin.not-found')->with($data);
    }

    public function transaction()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['transaction'] = 'start active';
        return view('admin.not-found')->with($data);
    }

    //PARTNERS PROMOTIONS

    public function offers(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['partners_promotions'] = 'start active';

        $data['url'] = url('admin/offers');
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;

        $input = $request->all();

        if ($request->search_string || $request->from || $request->to) {
            if ($request->to == '') {
                $request->to = Carbon::now();
            }

            $data['all_offers'] = Offer::where(function ($query) use ($request) {

                if (@$request->from) {
                    $query->where('created_at', '>=', @$request->from . ' 00:00:00');
                }
                if (@$request->to) {
                    $query->where('created_at', '<=', @$request->to . ' 23:59:59');
                }

            })->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath("?search_string=$request->search_string");

        } else {
            $data['all_offers'] = Offer::orderBy('id', 'desc')->paginate($this->row_per_page);
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.partners_promotions.render-offers', $data)->render());
        } else {
            return view('admin.ekom.partners_promotions.offers')->with($data);
        }

        return view('admin.ekom.partners_promotions.offers')->with($data);
    }

    public function add_offer()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['partners_promotions'] = 'start active';
        return view('admin.ekom.partners_promotions.offers')->with($data);
    }

    public function save_offer()
    {

    }

    public function change_offer_status()
    {

    }


    public function export_udc()
    {
        $data['udcs'] = $udcs = User::where('user_type', 1)->with(['udc_package_list' => function ($q) {
            $q->with(['logistic_partner']);
        }])->get();


        $data['active_udc'] = $udcs->where('status', 1);
        $data['deactivate_udc'] = $udcs->where('status', '!=', 1);

        $data['package_distributed_udc'] = array();
        $data['package_not_distributed_udc'] = array();

        foreach ($udcs as $udc) {
            if (@$udc->udc_package_list->where('is_selected', 1)->count() > 0) {
                $udc->total_package = @$udc->udc_package_list->where('is_selected', 1)->count();
                $data['package_distributed_udc'][] = $udc;
            } else {
                $data['package_not_distributed_udc'][] = $udc;
            }
        }

        $filePath = public_path("onboard-udc.CSV");
        $this->write_and_export($data['udcs'], $filePath);
//        return Response::download($filePath);

        $filePath = public_path("active-udc.CSV");
        $this->write_and_export($data['active_udc'], $filePath);
//        return Response::download($filePath);

        $filePath = public_path("deactivated-udc.CSV");
        $this->write_and_export($data['deactivate_udc'], $filePath);
//        return Response::download($filePath);

        $filePath = public_path("package-distributed-udc.CSV");
        $this->write_and_export($data['package_distributed_udc'], $filePath);
//        return Response::download($filePath);

        $filePath = public_path("package-not-distributed-udc.CSV");
        $this->write_and_export($data['package_not_distributed_udc'], $filePath);
        return Response::download($filePath);

    }

    public function write_and_export($object, $filePath)
    {
        $writer = WriterFactory::create(Type::CSV); // for XLSX files
        $writer->openToFile($filePath); // write data to a file or to a PHP stream
        //$writer->openToBrowser($fileName); // stream data directly to the browser

        $index_data = array(
            "Slno",
            "Center ID",
            "Digital Center Name",
            "Entrepreneur Name",
            "Entrepreneur Contact Number",
            "Email",
            "Division",
            "District",
            "Upazila",
            "Union",
            "Address",
            "Total Package Distributed"
        );

        $writer->addRow($index_data); // add a row at a time//

        $i = 1;
        foreach ($object as $key => $udc) {
            $lp_names = array();

            if (!empty(@$udc->udc_package_list)) {
                foreach ($udc->udc_package_list as $package)
                    $lp_names[] = @$package->logistic_partner->lp_name;
            }

            $index_datas = array(
                $i,
                @$udc->center_id,
                @$udc->center_name,
                @$udc->name_bn,
                @$udc->contact_number,
                @$udc->email,
                @$udc->division,
                @$udc->district,
                @$udc->upazila,
                @$udc->union,
                @$udc->address,
                @$udc->created_at,
                @$udc->udc_package_list->where('is_selected', 1)->count() . '(' . implode(', ', $lp_names) . ')',
            );

            $writer->addRow($index_datas);

            $i++;
        }

        $writer->close();
    }


    public function mobile_bank_information($user_id)
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';
        $data['mobile_bank_info'] = 'start active open';

        $data['user_info'] = $user_info = User::find($user_id);

        return view('admin.ekom.udc.mobile_bank_info')->with($data);
    }

    public function update_mobile_bank_information(Request $request)
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';
        $data['mobile_bank_info'] = 'start active open';

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'bkash_number' => '',
            'rocket_number' => '',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $user_info = User::find($request->user_id);
            $user_info->bkash_number = $request->bkash_number;
            $user_info->rocket_number = $request->rocket_number;
            $user_info->save();
        }
        return redirect("admin/mobile-bank-information/$request->user_id")->with("message", "Mobile Bank Information has been updated.");

    }


    public function notices()
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';
        $data['notice'] = 'start active open';

        $data['notices'] = Notice::all();
        return view('admin.ekom.notice.notices')->with($data);
    }

    public function delete_notice($id)
    {
        $notice_info = Notice::find($id);
        $notice_info->delete();
        return redirect('admin/notices');
    }

    public function change_notice_status($id, $status)
    {
        $notice_info = Notice::find($id);
        $notice_info->status = $status;
        $notice_info->save();
        return redirect('admin/notices');
    }

    public function add_notice()
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';
        $data['notice'] = 'start active open';

        return view('admin.ekom.notice.edit-notice')->with($data);
    }

    public function edit_notice($id)
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';
        $data['notice'] = 'start active open';

        $data['notice_info'] = Notice::find($id);

        return view('admin.ekom.notice.edit-notice')->with($data);
    }


    public function store_notice(Request $request)
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';
        $data['notice'] = 'start active open';

        $validator = Validator::make($request->all(), [
            'notice_message' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $notice_info = new Notice();
            $notice_info->notice_message = $request->notice_message;
            $notice_info->save();
        }
        return redirect("admin/notices")->with("message", "Notice Information has been Saved.");
    }

    public function update_notice(Request $request)
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';
        $data['notice'] = 'start active open';

        $validator = Validator::make($request->all(), [
            'notice_id' => 'required',
            'notice_message' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $notice_info = Notice::find($request->notice_id);
            $notice_info->notice_message = $request->notice_message;
            $notice_info->save();
        }
        return redirect("admin/notices")->with("message", "Notice Information has been updated.");
    }

    public function dumpVar($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit();
    }

    public function top_udc()
    {
        $data = array();


        $from2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("2018-01-31 00:00:00")));
        $to2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("2018-04-08 23:59:59")));

        $users = User::with(['orders'])->get();
        $groupCount = $users->map(function ($user, $key) {
            $user->total_purchase = $user->orders->sum('total_price');
            return $user;
        });
        $top_users = $groupCount->sortByDesc('total_purchase');

        dd($data);
    }

}