<?php

namespace App\Http\Controllers\admin\udc;

use App\LoginInformation;
use App\models\UdcCustomer;
use App\models\User;
use App\models\UserActivitiesLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\models\Order;
use App\models\OrderDetail;
use Illuminate\Support\Facades\DB;
use App\models\EcommercePartner;
use App\models\LogisticPartner;
use App\models\ProductSeller;
use App\models\UdcProduct;
use App\models\UdcProductDetail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Validator;


class UdcAdminController extends Controller
{
    public $row_per_page = 10;

    private $function_array = array("d H" => "addHour", "M-d-D" => "addDay", "M-d" => "addDay", "Y-M" => "addMonth");
    private $time_subtraction_func = array("d H" => "subHour", "M-d-D" => "subDay", "M-d" => "subDay", "Y-M" => "subMonth");

    public function get_id_type()
    {
        $data['id'] = Auth::user()->id;
        $data['user_type'] = 1;
        return $data;
    }


    public function dashboard(Request $request)
    {
        $data = array();
        $data['dashboard'] = 'active';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['user_info'] = Auth::user();

        $query_exception = array("1" => "user_id", "2" => "lp_id", "3" => "ep_id");
        $auth_id_type = $this->get_id_type();
        $id = $auth_id_type['id'];
        $user_type = $auth_id_type['user_type'];

        $type_arr = array(
            '1' => 'Sales',
            '2' => 'Orders',
        );

        $type = $request->type ? $type_arr[$request->type] : $type_arr[1];

        /*Number of orders*/
        $data['new_order'] = Order::where('status', '<', '2')->where(function ($q) use ($query_exception, $user_type, $id) {
            $q->where("$query_exception[$user_type]", $id);
        })->get();

        $orders = Order::where('status', '!=', 5)->where(function ($q) use ($query_exception, $user_type, $id) {
            $q->where("$query_exception[$user_type]", $id);
        })->get();

        $to = '';
        $from = '';
        if ($request->filter_range == 'all') {
            $date_format = 'M-d';
            $from = Carbon::createFromDate(2018, 1, 31);
            $to = Carbon::now();
        } else if ($request->filter_range == 'day') {
            $date_format = 'd H';
            $from = Carbon::today();
            $to = Carbon::now()->endOfDay();
        } else if ($request->filter_range == 'week') {
            $date_format = 'M-d';
            Carbon::setWeekStartsAt(Carbon::SATURDAY);
            $from = Carbon::now()->startOfWeek();
            Carbon::setWeekEndsAt(Carbon::FRIDAY);
            $to = Carbon::now()->endOfWeek();
        } else if ($request->filter_range == 'month') {
            $from = Carbon::now()->startOfMonth();
            $to = Carbon::now()->endOfMonth();
            $date_format = 'M-d';
        } else if ($request->filter_range == 'year') {

            $from = Carbon::now()->startOfYear();
            $to = Carbon::now()->endOfYear();
            $date_format = 'Y-M';

        } else if ($request->from && !$request->to) {

            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($request->from . " 00:00:00")));
            $to = Carbon::now()->endOfMonth();
            $date_format = 'M-d';

        } else if (!$request->from && $request->to) {

            $from = Carbon::createFromDate(2018, 1, 0);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($request->to . " 23:59:59")));
            $date_format = 'M-d';

        } else if ($request->from && $request->to) {

            $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($request->from . " 00:00:00")));
            $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($request->to . " 23:59:59")));
            $date_format = 'M-d';

        } else {
            $date_format = 'M-d';
            $filter_range = 'all';
            $from = Carbon::createFromDate(2018, 1, 31);
            $to = Carbon::now();
        }

        $start_date = $from;
        $end_date = $to;

        /*Registered Users*/
        if (@$request->from || @$request->to) {

            $data['registered_dc'] = User::where('user_type', 1)->where('status', 1)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
            $data['orders'] = Order::where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['canceled_orders'] = Order::where('created_at', '>=', $start_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('created_at', '<=', $end_date)->where('status', '=', '5')->get();
            $data['order_completed'] = Order::where('status', '4')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
            $data['all_sales'] = Order::selectRaw('sum(total_price) as total_sale')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '!=', 5)->first();
            $data['udc_commission'] = $orders->where('created_at', '>=', $start_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('created_at', '<=', $end_date)->where('status', '!=', '5')->where('status', '>', '1')->sum('udc_commission');

        } else if (@$request->filter_range == 'all' || !@$request->filter_range) {


            $data['registered_dc'] = User::where('user_type', 1)->where('status', 1)->get();
            $data['orders'] = Order::where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['canceled_orders'] = Order::where('status', '=', '5')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['order_completed'] = $completed_orders = Order::where('status', '4')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['all_sales'] = Order::selectRaw('sum(total_price) as total_sale')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('status', '!=', 5)->first();
            $data['udc_commission'] = $orders->where('status', '!=', '5')->where('status', '>', '1')->sum('udc_commission');

        } else {
            $data['registered_dc'] = User::where('user_type', 1)->where('status', 1)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
            $data['orders'] = Order::where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['canceled_orders'] = Order::where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '=', '5')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['order_completed'] = Order::where('status', '4')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['all_sales'] = Order::selectRaw('sum(total_price) as total_sale')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '!=', 5)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->first();
            $data['udc_commission'] = $orders->where('created_at', '>=', $start_date)->where($query_exception[$user_type], $id)->where('created_at', '<=', $end_date)->where('status', '!=', '5')->where('status', '>', '1')->sum('udc_commission');
        }

        $data['from'] = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from)));
        $data['to'] = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to)));

        $data['filter_range'] = @$request->filter_range ? @$request->filter_range : 'all';

        $from2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from)));
        $to2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to)));

        /*Top Sales Chart*/
        $get_chart_data = $this->get_chart_data($from, $to, $date_format, $orders, 1);
        $data['sale_values'] = $get_chart_data['chart_values'];
        $data['sale_labels'] = $get_chart_data['chart_labels'];

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


        $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from2)));
        $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to2)));

        /*All Sales*/
        //CHART DATA
        $get_chart_data = $this->get_chart_data($from2, $to2, $date_format, $orders, '1');
        $data['sale_chart_values'] = $get_chart_data['chart_values'];
        $data['chart_labels'] = $get_chart_data['chart_labels'];

        /*Today's Orders*/
        $data['todays_order'] = Order::whereRaw('Date(created_at) = CURDATE()')->where(function ($q) use ($query_exception, $user_type, $id) {
            $q->where("$query_exception[$user_type]", $id);
        })->orderBy('created_at', 'desc')->limit(20)->get();
        $data['todays_total_order'] = Order::whereRaw('Date(created_at) = CURDATE()')->where(function ($q) use ($query_exception, $user_type, $id) {
            $q->where("$query_exception[$user_type]", $id);
        })->selectRaw('count(id) as todays_total_order')->where($query_exception[$user_type], $id)->first();
        //CHART DATA
        $get_chart_data = $this->get_chart_data(Carbon::now()->startOfDay(), Carbon::now()->endOfDay(), 'd H', $orders, '2');
        $data['order_chart_values'] = $get_chart_data['chart_values'];
        $data['order_chart_labels'] = $get_chart_data['chart_labels'];

        //COMMISSION CHART
        $from2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from)));
        $to2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to)));
        $get_chart_data = $this->get_chart_data($from, $to, $date_format, $orders, 'commission');
        $data['udc_commission_chart_values'] = $get_chart_data['chart_values'];
        $data['udc_commission_chart_labels'] = $get_chart_data['chart_labels'];

        /*Average Order Delivery Time*/
        $completed_orders = Order::where('status', '4')->where(function ($q) use ($query_exception, $user_type, $id) {
            $q->where("$query_exception[$user_type]", $id);
        })->get();
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
        $average_data = $this->average_delivery_chart($completed_orders);
        $data['avg_delivery'] = $average_data['avg_delivery'];
        $data['avg_delivery_lbl'] = $average_data['avg_delivery_lbl'];


        /*Recent Order List*/
        //**FETCHING RECENT ORDER USING DATATABLE XHR


        /*Activities*/
        if ($request->ajax() && @$request->offset) {
            $data['user_activities'] = UserActivitiesLog::orderBy('id', 'desc')->take(@$request->limit)->skip(@$request->offset)->get();
            return Response::json(View::make('admin.ekom.dashboard._activities_ajax', array('user_activities' => $data['user_activities']))->render());
        } else {
            $data['user_activities'] = UserActivitiesLog::orderBy('id', 'desc')->limit(10)->get();
            $data['total_activities'] = UserActivitiesLog::all();
            $data['total_activities'] = $data['total_activities']->count();
        }


        /*Order Stats*/
        $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from2)));
        $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to2)));
        $order_chart_data = $this->get_chart_data($from2, $to2, $date_format, $orders, 2);
        $data['order_chart_day_values'] = $order_chart_data['chart_values'];
        $data['order_day_array'] = $order_chart_data['chart_labels'];

        /*DAILY VISITOR*/
        $from2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from)));
        $to2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to)));
        $data['todays_visitor'] = LoginInformation::where('created_at', '>', $from)->where('created_at', '<', $to)->get()->count();
        $all_visitors = LoginInformation::get();
        $all_visitors = $this->get_chart_data($from, $to, $date_format, $all_visitors, 'daily_visitor_count');
        $data['daily_visitor_values'] = $all_visitors['chart_values'];
        $data['daily_visitor_labels'] = $all_visitors['chart_labels'];


        $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from2)));
        $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to2)));
        $ep = EcommercePartner::with(['ep_statistics' => function ($q) use ($from2, $to2) {
            $q->where('created_at', '>=', $from2);
            $q->where('created_at', '<=', $to2);
        }])->where('status', 1)->orderBy('id', 'desc')->get();


        $ep_name_labels = array();
        $statistics_chart_labels = array();
        $statistics_chart_values = array();
        $i = 0;
        foreach ($ep as $value) {
            $from2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from)));
            $to2 = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to)));
            $ep_name_labels[] = $value->ep_name;
            $this_ep_cart_data = $this->get_chart_data($from2, $to2, $date_format, $value->ep_statistics, 'ep_statistics');
            if ($i == 0) {
                $statistics_chart_labels = $this_ep_cart_data['chart_labels'];
            }
            $statistics_chart_values[] = $this_ep_cart_data['chart_values'];
            $i++;
        }

        $data['ep_name_labels'] = '"' . implode('", "', $ep_name_labels) . '"';
        $data['statistics_chart_labels'] = $statistics_chart_labels;
        $data['statistics_chart_values'] = '[' . implode('], [', $statistics_chart_values) . ']';

//        ->where(function ($q) use ($query_exception, $user_type, $id) {
//        $q->where("$query_exception[$user_type]", $id);
//    })

        /*_ecom_ Partners*/
        $data['active_ep'] = EcommercePartner::with(["orders" => function ($q) use ($from, $to, $query_exception, $user_type, $id) {
            $q->where('created_at', '>=', $from);
            $q->where('created_at', '<=', $to);
            $q->where("$query_exception[$user_type]", $id);
        }])->get();
        $data['active_lp'] = LogisticPartner::with(["orders" => function ($q) use ($from, $to, $query_exception, $user_type, $id) {
            $q->where('created_at', '>=', $from);
            $q->where('created_at', '<=', $to);
            $q->where("$query_exception[$user_type]", $id);
        }])->get();

        if ($request->ajax()) {
            return Response::json(View::make('admin.udc.dashboard.render-dashboard', $data)->render());
        } else {
            return view('admin.udc.dashboard.dashboard')->with($data);
        }

    }


    public function average_delivery_chart($completed_orders)
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
        $array_get_states_count = '';
        for ($i = Carbon::createFromDate(2018, 1, 5); $i <= Carbon::now(); $i->$date_func()) {
            if ($avg_date_format == 'd H') {
                $chart_labels[] = date('d H', strtotime($i)) . ":00";
            } else {
                $chart_labels[] = '"' . date("$avg_date_format", strtotime($i)) . '"';
            }

            $value_i = date("$avg_date_format", strtotime($i));

            if (Arr::exists($collection_states, $value_i) == false) {
                $array_get_states_count .= '0,';
                $get_states_count[$value_i] = 0;
            } else {
                $array_get_states_count .= $get_states_count[$value_i] . ',';
            }
        }
        $data['avg_delivery'] = rtrim($array_get_states_count, ',');
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


    public function myProfile()
    {
        $data = array();
        $data['menu'] = 'profile';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['user_info'] = Auth::user();
        return view('admin.udc.profile.profile')->with($data);
    }

    public function transactions(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['wallet'] = 'start active open';
        $data['transactions'] = 'active';

        $user_id = Auth::user()->id;
        $data['udc_list'] = User::where('status', '=', 1)->get();

        $input = $request->all();

        $data['udc_transactions'] = Order::where('user_id', $user_id)->orderBy('id', 'desc')->paginate($this->row_per_page);


        return view('admin.not-found')->with($data);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.udc.transactions.render_index_data', $data)->render());
//        } else {
//            return view('admin.udc.transactions.index')->with($data);
//        }
    }

    public function sales(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['sales'] = 'start active open';
        $data['all_sale'] = 'active';

        $user_id = Auth::user()->id;
        $data['udc_list'] = User::where('status', '=', 1)->get();

        $input = $request->all();

        $data['udc_sales'] = OrderDetail::with(['order_with_buyer', 'udc_product_info', 'buyer_info', 'udc_product_detail'])
            ->where('seller_id', $user_id)
            ->orderBy('id', 'desc')
            ->paginate(10);

//        dd($data['udc_sales']);

        if ($request->ajax()) {
            return Response::json(View::make('admin.udc.sales.render_index_data', $data)->render());
        } else {
            return view('admin.udc.sales.index')->with($data);
        }
    }

    public function udcCustomerList()
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['customer'] = 'start active open';
        $data['customer_list'] = 'active';
        $data['user_info'] = Auth::user();
        $data['customerList'] = UdcCustomer::where('udc_id', Auth::user()->id)->get();
        return view('admin.udc.customer.customerList')->with($data);
    }

    public function addCustomer()
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['customer'] = 'start active open';
        $data['add_customer'] = 'active';
        $data['user_info'] = Auth::user();
        return view('admin.udc.customer.add_customer')->with($data);
    }

    public function storeCustomer(Request $request)
    {
        $this->validate($request, [
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_contact_number' => 'required|unique:udc_customers'
        ]);

        $request['udc_id'] = Auth::user()->id;
        $seller = UdcCustomer::create($request->all());
        if ($seller) {
            return redirect()->route('udc.customerList')->with('message', 'Customer Created Successfully');
        } else {
            return back()->with('message', 'Customer Created Successfully');
        }
    }

    public function editCustomer($id)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['customer'] = 'start active open';
        $data['customer_list'] = 'active';
        $data['user_info'] = Auth::user();
        $data['customer_info'] = UdcCustomer::find($id);
        return view('admin.udc.customer.edit_customer')->with($data);
    }

    public function updateCustomer(Request $request, $id)
    {
        $this->validate($request, [
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_contact_number' => 'required|unique:udc_customers'
        ]);

        $seller = UdcCustomer::find($id);
        $seller->customer_name = $request->customer_name;
        $seller->customer_address = $request->customer_address;
        $seller->customer_contact_number = $request->customer_contact_number;

        if ($seller->save()) {
            return redirect()->route('udc.customerList')->with('message', 'Customer Created Successfully');
        } else {
            return back()->with('message', 'Customer Created Successfully');
        }
    }

    public function report()
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['reports'] = 'start active open';
        $data['report'] = 'active';

        return view('admin.not-found')->with($data);

//        return view('admin.udc.report.report')->with($data);
    }

    public function udc_customer_orders(Request $request, $customer_id)
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['orders'] = 'active';
        $data['customer'] = 'start active open';
        $data['customer_list'] = 'active';

        $data['url'] = url("udc/customer/$customer_id/orders");
        $data['user_info'] = $udc_info = Auth::user();
        $id = $udc_info->id;

        $input = $request->all();
        if (isset($input['search_string'])) {

            $sstring = $input['search_string'];
            $data['all_orders'] = Order::where('user_id', '=', $id)->where('customer_id', $customer_id)
                ->where(function ($query) use ($request) {
                    if ($request->tab_id > 1) {
                        $query->where('status', $request->tab_id);
                    }
                })->where(function ($query) use ($request) {
                    $query->where('order_code', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('ep_name', 'LIKE', '%' . $request->search_string . '%');
                })->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath("?search_string=$sstring&tab_id=$request->tab_id");

        } else {

            if ($request->tab_id) {

                $data['all_orders'] = Order::where('user_id', '=', $id)->where('customer_id', $customer_id)
                    ->where(function ($query) use ($request) {
                        if ($request->tab_id > 1) {
                            $query->where('status', $request->tab_id);
                        }
                    })->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath('?tab_id=' . $request->tab_id);

            } else {
                $data['all_orders'] = Order::where('user_id', '=', $id)->where('customer_id', $customer_id)
                    ->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath('?tab_id=0');
            }
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.udc.render-purchase-list', $data)->render());
        } else {
            return view('admin.udc.purchase-list')->with($data);
        }
    }

    public function mobile_bank_information()
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['orders'] = 'active';
        $data['mobile_bank_info'] = 'start active open';

        $data['user_info'] = $udc_info = Auth::user();

        return view('admin.udc.mobile_bank_info')->with($data);
    }

    public function update_mobile_bank_information(Request $request)
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['orders'] = 'active';
        $data['mobile_bank_info'] = 'start active open';

        $data['user_info'] = $udc_info = Auth::user();

        $validator = Validator::make($request->all(), [
            'bkash_number' => '',
            'rocket_number' => '',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $user_info = User::find($udc_info->id);
            $user_info->bkash_number = $request->bkash_number;
            $user_info->rocket_number = $request->rocket_number;
            $user_info->save();
        }
        return redirect('mobile-bank-information')->with("message", "Mobile Bank Information has been updated.");

    }
    
    
    public function udc_commission_overview(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['commission_overview'] = 'start active';

        $data['outstanding_dues'] = $outstanding_dues = Order::where('is_commission_disburesed', 0)
            ->select(DB::raw("SUM(udc_commission) as outstanding_due, ep_id"))
            ->where('user_id', Auth::user()->id)
            ->where('status', '!=', 5)
            ->where("status", '>', 1)
            ->groupBy('ep_id')
            ->get();
//        dd($outstanding_dues);
        return view('admin.udc.udc-commission-overview')->with($data);
    }

//    public function commission_disburse_details(Request $request)
//    {
//        $data = array();
//        $data['side_bar'] = 'udc_side_bar';
//        $data['header'] = 'udc_header';
//        $data['footer'] = 'udc_footer';
//        $data['commission_overview'] = 'start active';
//
//        $data['outstanding_dues'] = $outstanding_dues = Order::where('is_commission_disburesed', 0)
//            ->select(DB::raw("SUM(udc_commission) as outstanding_due, ep_id"))
//            ->where('user_id', Auth::user()->id)
//            ->where('status', '!=', 5)
//            ->where("status", '>', 1)
//            ->groupBy('ep_id')
//            ->get();
////        dd($outstanding_dues);
//
//        return view('admin.udc.commission-disburse-details')->with($data);
//    }


    public function commission_disburse_details(Request $request, $ep_id)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['commission_overview'] = 'start active';

        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;

        if ($request->from && $request->to) {

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

            $data['ep_info'] = $ep_info = Auth::guard('ep_admin')->user();

            $data['udc_order_reports'] = User::whereHas('orders', function ($q) use ($data, $request) {
                $q->where("status", '>', 1);
                $q->where("status", '!=', 5);
                $q->where("ep_id", $data['ep_info']->id);
                if ($request->search_string) {
                    $q->where('name_bn', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('name_en', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('contact_number', 'LIKE', '%' . $request->search_string . '%');
                }
            })->with(['orders' => function ($q) use ($data, $request) {

                if (@$request->from != 'all') {
                    $q->where("created_at", ">=", $data['from']);
                    $q->where("created_at", "<=", $data['to']);
                }

                $q->where("status", '>', 1);
                $q->where('is_commission_disburesed', '=', 0);
                $q->where("status", '!=', 5);
                $q->where("ep_id", $data['ep_info']->id);
            }])->with(['total_disbursed_commission', 'last_disburse_info' => function ($q) {
                $q->orderBy('id', 'desc');
            }, 'get_prev_due_commission' => function ($query) use ($from, $ep_info, $request) {

                if (@$request->from != 'all') {
                    $query->where("created_at", ">=", "2018-07-01"); //FROM JULY
                    $query->where("created_at", "<=", $from/*"2018-06-30"*/);
                }

                $query->where('ep_id', $ep_info->id);
                $query->where('is_commission_disburesed', '=', 0);
                $query->where('status', '!=', 5);
                $query->where("status", '>', 1);
            }])->orderBy('id', 'desc');

            if (@$request->export_type) {
                $data['udc_order_reports'] = $data['udc_order_reports']->get();
            } else {
                $data['udc_order_reports'] = $data['udc_order_reports']->paginate($this->row_per_page);
            }

            $data['total_orders'] = Order::where(function ($q) use ($data, $from, $to, $request) {
                if (@$request->from != 'all') {
                    $q->where("created_at", ">=", $from);
                    $q->where("created_at", "<=", $to);
                }
                $q->where('status', '!=', 5);
                $q->where("status", '>', 1);
                $q->where('is_commission_disburesed', '=', 0);
                $q->where("ep_id", $data['ep_info']->id);

            })->get()->count();

            $data['total_sales'] = Order::where( function ($q) use ($data, $from, $to, $request) {
                if (@$request->from != 'all') {
                    $q->where("created_at", ">=", $from);
                    $q->where("created_at", "<=", $to);
                }
                $q->where('status', '!=', 5);
                $q->where("status", '>', 1);
                $q->where('is_commission_disburesed', '=', 0);
                $q->where("ep_id", $data['ep_info']->id);

            })->get()->sum('total_price');

            $data['total_commission'] = Order::where(function ($q) use ($data, $from, $to, $request) {
                if (@$request->from != 'all') {
                    $q->where("created_at", ">=", $from);
                    $q->where("created_at", "<=", $to);
                }
                $q->where('status', '!=', 5);
                $q->where("status", '>', 1);
                $q->where('is_commission_disburesed', '=', 0);
                $q->where("ep_id", $data['ep_info']->id);

            })->get()->sum('udc_commission');

//            if (@$request->export_type == 'csv') {
//
//                $writer = WriterFactory::create(Type::CSV);
//                $file_name = "commission-report-" . date("YmdHis") . ".csv";
//                $filePath = base_path("tmp/" . $file_name);
//                $adb = File::put($filePath, '');
//
//                $total_disbursed_commission = 0;
//                $total_outstanding_commission = 0;
//                $this_udc_commission = 0;
//                $writer->openToFile($filePath);
//                $writer->addRow(array("Slno", "UDC Name", "Center ID", "Phone Number", "Mobile Bank Numbers", "Total Orders", "Total Sale", "Disbursed Commission", "Outstanding Commission", "Total Commission"));
//                foreach ($data['udc_order_reports'] as $key => $each_udc) {
//
//                    $this_udc_commission = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('udc_commission');
//                    $total_disbursed_commission += @$each_udc->total_disbursed_commission->sum('amount');
//                    $total_outstanding_commission += $this_udc_commission + @$each_udc->total_disbursed_commission->sum('due_amount') + @$each_udc->get_prev_due_commission->sum('udc_commission');
//
//                    $writer->addRow(array(
//                        $key + 1,
//                        @$each_udc->name_bn,
//                        @$each_udc->center_id,
//                        @$each_udc->contact_number,
//                        'Bkash: ' . (@$each_udc->bkash_number ? '+88' . @$each_udc->bkash_number : '') . ' || ' . 'Rocket: ' . (@$each_udc->rocket_number ? '+88' . @$each_udc->rocket_number : ''),
//                        number_format((@$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->count()), 0),
//                        number_format($each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('total_price'), 0),
//                        number_format(@$each_udc->total_disbursed_commission->sum('amount'), 0),
//                        number_format($each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('udc_commission') + @$each_udc->total_disbursed_commission->sum('due_amount') + @$each_udc->get_prev_due_commission->sum('udc_commission'), 0),
//                        number_format($this_udc_commission, 0)
//                    ));
//                }
//                $writer->addRow(array("", "", "", "", "", "", "", ""));
//                $writer->addRow(array("", "", "", "", "", "total_orders", "total_sales", "total_disbursed_commission", "total_outstanding_commission", "total_commission"));
//                $writer->addRow(array("", "", "", "", "", number_format($data['total_orders'], 0), number_format($data['total_sales'], 0), number_format(@$total_disbursed_commission, 0), number_format($total_outstanding_commission, 0), number_format($data['total_commission'], 0)));
//                $writer->close();
//                return Response::download($filePath, $file_name);
//
//            } else if (@$request->export_type == 'xlsx') {
//
//                $writer = WriterFactory::create(Type::XLSX);
//                $file_name = "commission-report-" . date("YmdHis") . ".xlsx";
//                $filePath = base_path("tmp/" . $file_name);
//                $adb = File::put($filePath, '');
//
//                $total_disbursed_commission = 0;
//                $total_outstanding_commission = 0;
//                $this_udc_commission = 0;
//                $writer->openToFile($filePath);
//                $writer->addRow(array("Slno", "UDC Name", "Center ID", "Phone Number", "Mobile Bank Numbers", "Total Orders", "Total Sale", "Disbursed Commission", "Outstanding Commission", "Total Commission"));
//                foreach ($data['udc_order_reports'] as $key => $each_udc) {
//
//                    $this_udc_commission = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('udc_commission');
//                    $total_disbursed_commission += @$each_udc->total_disbursed_commission->sum('amount');
//                    $total_outstanding_commission += $this_udc_commission + @$each_udc->total_disbursed_commission->sum('due_amount') + @$each_udc->get_prev_due_commission->sum('udc_commission');
//
//                    $writer->addRow(array(
//                        $key + 1,
//                        @$each_udc->name_bn,
//                        @$each_udc->center_id,
//                        @$each_udc->contact_number,
//                        'Bkash: ' . (@$each_udc->bkash_number ? '+88' . @$each_udc->bkash_number : '') . ' || ' . 'Rocket: ' . (@$each_udc->rocket_number ? '+88' . @$each_udc->rocket_number : ''),
//                        number_format((@$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->count()), 0),
//                        number_format($each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('total_price'), 0),
//                        number_format(@$each_udc->total_disbursed_commission->sum('amount'), 0),
//                        number_format($each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('udc_commission') + @$each_udc->total_disbursed_commission->sum('due_amount') + @$each_udc->get_prev_due_commission->sum('udc_commission'), 0),
//                        number_format($this_udc_commission, 0)
//                    ));
//                }
//                $writer->addRow(array("", "", "", "", "", "", "", ""));
//                $writer->addRow(array("", "", "", "", "", "total_orders", "total_sales", "total_disbursed_commission", "total_outstanding_commission", "total_commission"));
//                $writer->addRow(array("", "", "", "", "", number_format($data['total_orders'], 0), number_format($data['total_sales'], 0), number_format(@$total_disbursed_commission, 0), number_format($total_outstanding_commission, 0), number_format($data['total_commission'], 0)));
//                $writer->close();
//                return Response::download($filePath, $file_name);
//
//            }
        }else{
            $data['get_commission_details'] = $get_commission_details = Order::where('ep_id', $ep_id)
                ->where('user_id', Auth::user()->id)
                ->where('status', '!=', 5)
                ->where("status", '>', 1)
                ->get()->groupBy(function ($item) {
                    return $item->created_at->format('F-y');
                });
        }

        $data['ep_name'] = EcommercePartner::where('id', $ep_id)->first()->ep_name;

        if ($request->ajax()) {
            return Response::json(View::make('admin.udc.render-commission-disburse-details', $data)->render());
        } else {
            return view('admin.udc.commission-disburse-details')->with($data);
        }
    }

}
