<?php

namespace App\Http\Controllers\admin\ep;

use App\Libraries\PlxUtilities;
use App\models\EcommercePartner;
use App\models\_ecom_Setting;
use App\models\LoginInformation;
use App\models\LogisticPartner;
use App\models\Order;
use App\models\OrderTrack;
use App\models\UdcCustomer;
use App\models\User;
use App\models\UserActivitiesLog;
use Carbon\Carbon;
use Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Support\Facades\File;

class EcommercePartnerController extends Controller
{
    public $row_per_page = 10;

    use AuthenticatesUsers;
    protected $redirectTo = 'ep';

    public function showLoginForm()
    {
        if (Auth::guard('ep_admin')->check()) {
            return back()->with('message', 'Unauthenticated Admin');
        }
        $data = array();
        return view('admin.ep.login')->with($data);
    }

    protected function guard()
    {
        return Auth::guard('ep_admin');
    }

    protected function logout()
    {
        Auth::guard('ep_admin')->logout();
        return redirect("ep/login");
    }

    private $function_array = array("d H" => "addHour", "M-d-D" => "addDay", "M-d" => "addDay", "Y-M" => "addMonth");
    private $time_subtraction_func = array("d H" => "subHour", "M-d-D" => "subDay", "M-d" => "subDay", "Y-M" => "subMonth");

    public function get_id_type()
    {
        $data['id'] = Auth::guard('ep_admin')->user()->id;
        $data['user_type'] = 3;
        return $data;
    }

    public function index(Request $request)
    {
        $data = array();
        $data['dashboard'] = 'active';
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'ep_footer';
        $data['user_info'] = Auth::guard('ep_admin')->user();

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
            })->where('created_at', '<=', $end_date)->where('status', '!=', '5')->sum('udc_commission');

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
            $data['udc_commission'] = $orders->where('status', '!=', '5')->sum('udc_commission');

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
            $data['udc_commission'] = $orders->where('created_at', '>=', $start_date)->where($query_exception[$user_type], $id)->where('created_at', '<=', $end_date)->where('status', '!=', '5')->sum('udc_commission');

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
        }])->where('status', 1)->where(function ($q) use ($user_type, $id) {
            if ($user_type != 'Admin') {
                $q->where("id", $id);
            }
        })->orderBy('id', 'desc')->get();

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


        /*_ecom_ Partners*/
        $data['active_lp'] = LogisticPartner::with(["orders" => function ($q) use ($from, $to, $query_exception, $user_type, $id) {
            $q->where('created_at', '>=', $from);
            $q->where('created_at', '<=', $to);
            $q->where("$query_exception[$user_type]", $id);
        }])->get();

        if ($request->ajax()) {
            return Response::json(View::make('admin.ep.dashboard.render-dashboard', $data)->render());
        } else {
            return view('admin.ep.dashboard.dashboard')->with($data);
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
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'ep_footer';
        return view('admin.ep.profile.profile')->with($data);
    }

    public function report()
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'ep_footer';
        return view('admin.ep.report.report')->with($data);
    }

    public function epOrders(Request $request)
    {
        $data = array();
        $data['orders'] = 'active';
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'footer';

        $data['ep'] = $ep_info = Auth::guard('ep_admin')->user();
        $id = $ep_info->id;


        $data['limit'] = $limit = $request->limit ? $request->limit : 15;
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $limit) + 1 : 1;

        $data['all_orders'] = Order::where('ep_id', '=', $id);

        if ($request->search_string || $request->from || $request->to) {

            if ($request->to == '') {
                $request->to = Carbon::now();
            }

            $data['all_orders'] = $data['all_orders']->where(function ($query) use ($request) {
                if (@$request->from)
                    $query->where('created_at', '>=', @$request->from . ' 00:00:00');

                if (@$request->to)
                    $query->where('created_at', '<=', @$request->to . ' 23:59:59');

            })->where(function ($query) use ($request) {

                $query->where('order_code', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('lp_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('ep_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('delivery_location', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('receiver_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('receiver_contact_number', 'LIKE', '%' . $request->search_string . '%');

            });
        }

        if (isset($request->tab_id) && $request->tab_id != 'all' && $request->tab_id != '6') {
            $data['all_orders'] = $data['all_orders']->where('status', '=', $request->tab_id);
        } else if ($request->tab_id == '6') {
            $data['all_orders'] = $data['all_orders']->where('ep_order_id', null);
        }

        $data['total_price'] = $data['all_orders']->sum('total_price');
        $data['total_commission'] = $data['all_orders']->sum('udc_commission');
        $data['total_orders'] = $data['all_orders']->count();


        $data['all_orders'] = $data['all_orders']->orderBy('id', 'desc');
        if (@$request->export_type || @$request->limit == 'all') {
            $data['all_orders'] = $data['all_orders']->get();
        } else {
            $data['all_orders'] = $data['all_orders']->paginate($limit)->withPath('?tab_id=' . $request->tab_id);
        }

        if (@$request->export_type == 'csv') {

            $writer = WriterFactory::create(Type::CSV);
            $file_name = "order_list-" . date("YmdHis") . ".csv";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createExportFile($writer, $data['all_orders'], $filePath);
            return Response::download($filePath, $file_name);

        } else if ($request->export_type == 'xlsx') {

            $writer = WriterFactory::create(Type::XLSX);
            $file_name = "order_list-" . date("YmdHis") . ".xlsx";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createExportFile($writer, $data['all_orders'], $filePath);
            return Response::download($filePath, $file_name);

        }


        if ($request->ajax()) {
            return Response::json(View::make('admin.ep.orders.ep-order-list-render', $data)->render());
        } else {
            return view('admin.ep.orders.ep_orders')->with($data);
        }
    }

    public function createExportFile($writer, $all_orders, $filePath)
    {
        $writer->openToFile($filePath);
        $header_row = [
            "Slno",
            "Order ID",
            "Order Date",
            "Delivery Duration",
            "EP Name",
            "LP Name",
            "Digital Center Name",
            "Center ID",
            "Entrepreneur Name",
            "Entrepreneur Contact Number",
            "District",
            "Union",
            "Total price",
            "UDC Commission",
            "Order Status",
        ];
        $writer->addRow($header_row);

        $order_status = array("", "Active", "Warehouse left", "In Transit", "Delivered", "Canceled");
        foreach ($all_orders as $key => $order) {
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
                @$order->udc_commission,
                @$order_status[@$order->status],
            );
            $writer->addRow($index_datas);
        }
        $writer->close();
        return;
    }

    public function order_details($order_code)
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';

        $data['lp'] = $ep_info = Auth::guard('ep_admin')->user();
        $id = $ep_info->id;
        $data['ep'] = EcommercePartner::where('id', $id)->first();

        $data['order_info'] = $order_info = Order::with(['order_details', 'order_invoice', 'lp_info', 'UdcCustomer'])
            ->where('order_code', $order_code)
            ->where('ep_id', $id)
            ->first();

        if ($data['order_info']) {
            $data['user_info'] = $user_info = User::find(@$data['order_info']->user_id);

            $data['tracking_details'] = OrderTrack::where('order_id', $order_info->id)->get();
            if ($data['tracking_details']) {
                $data['maxstatus'] = $this->getMaxStatus($data['tracking_details']);
            }
            $data['status_tracking_info'] = OrderTrack::where('order_id', @$order_info->id)->get()->groupBy('status');

            $data['udcCustomers'] = UdcCustomer::where('udc_id', $data['order_info']->user_id)->get();
            return view('admin.ekom.udc.order-details')->with($data);
        } else {
            return redirect()->back();
        }
    }

    public function oder_tracking(Request $request, $order_code = 1)
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'footer';
        $data['track_order'] = 'active';

        $data['ep'] = $ep_info = Auth::guard('ep_admin')->user();
        $id = $ep_info->id;

        $data['order_info'] = $order_info = Order::with(['order_details', 'lp_info', 'UdcCustomer'])
            ->where('tracking_id', $order_code)
            ->where('ep_id', $id)
            ->first();

        if ($order_info) {
            $data['tracking_details'] = OrderTrack::where('order_id', $order_info->id)->get();
            if ($data['tracking_details']) {
                $data['maxstatus'] = $this->getMaxStatus($data['tracking_details']);
            }
            $data['status_tracking_info'] = OrderTrack::where('order_id', @$order_info->id)->get()->groupBy('status');
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ep.orders.order-tracking-render', $data)->render());
        } else {
            return view('admin.ep.orders.order-tracking')->with($data);
        }
    }

    public function change_order_status(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';

        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
            'status' => 'required',
            'message' => 'required_if:status,5'
        ], [
            'order_code' => 'Order code is required',
            'status' => 'order status is required',
            'message' => 'Valid message is required to cancel this order',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
        } else {
            $ep_info = Auth::guard('ep_admin')->user();

            if ($ep_info) {
                $changable_code = array(2, 5);

                if (!in_array($request->status, $changable_code)) {
                    $response['message'] = 'You have no access to change order status.';
                } else {
                    $order_code = $request->order_code;

                    $data["order_info"] = $order_info = Order::where('order_code', $order_code)->where('ep_id', $ep_info->id)->first();

                    if ($order_info) {
                        $ecom_setting = _ecom_Setting::first();
                        $possible_order_time = Carbon::now()->subHour($ecom_setting->order_cancel_time);

                        if (($order_info->status == 1 && $request->status == 5) && ($order_info->created_at < $possible_order_time)) {
                            $response['message'] = "You can cancel an order within " . @$ecom_setting->order_cancel_time . " hours after placing in your system.";
                        } else if (($request->status == 2 && $order_info->status == 1) || ($request->status == 5 && $order_info->status == 1)) {

                            if ($request->status == 2) {

                                $order_track = new OrderTrack();
                                $order_track->order_id = $order_info->id;
                                $order_track->status = $request->status;
                                $order_track->message_by = $ep_info->ep_name;
                                $order_track->user_type = "Ecommerce Partner";
                                $order_track->message = "Warehouse Left";
                                $order_track->save();

                            } else if ($request->status == 5) {

                                // SAVE ORDER CANCEL MESSAGE
                                $order_track = new OrderTrack();
                                $order_track->order_id = $order_info->id;
                                $order_track->status = $request->status;
                                $order_track->message_by = $ep_info->ep_name;
                                $order_track->user_type = "Ecommerce Partner";
                                $order_track->message = $request->message;
                                $order_track->save();

                            }

                            $order_info->status = $request->status;
                            $order_info->save();

                            $status = 200;
                            $response['message'] = 'Order status has bean changed successfully.';

                            $data["order_info"] = $order_info = Order::where('order_code', $order_code)->first();
                            $response['view'] = View::make('admin.lp.orders.lp_order_row', $data);

                        } else {
                            $order_status = array("2" => "Warehouse left", "3" => "on delivery", "4" => "delivered", "5" => "canceled");
                            $response['message'] = 'You have no access to change this order. This order already ' . @$order_status[$order_info->status];
                        }

                    } else {
                        $response['message'] = 'Order not found.';
                    }
                }
            } else {
                $status = 101;
                $response['message'] = 'Your EP is inactive, Please Contact with Ek-Shop Admin';
            }
        }

        $utility = new PlxUtilities();
        $utility->json($status, $response);
    }

    function getMaxStatus($array)
    {
        $max = 0;
        foreach ($array as $k => $v) {
            $max = max(array($max, $v['status']));
        }
        return $max;
    }

    public function udc_commission_report(Request $request)
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'footer';
        $data['udc_commission'] = 'active';

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

                $q->where("created_at", ">=", $data['from']);
                $q->where("created_at", "<=", $data['to']);
                $q->where("status", '>', 1);
                $q->where("status", '!=', 5);
                $q->where("ep_id", $data['ep_info']->id);

            })->with(['orders' => function ($q) use ($data, $request) {

                $q->where("created_at", ">=", $data['from']);
                $q->where("created_at", "<=", $data['to']);
                $q->where("status", '>', 1);
                $q->where("status", '!=', 5);
                $q->where("ep_id", $data['ep_info']->id);

            }])->orderBy('id', 'desc');

            if (@$request->export_type) {
                $data['udc_order_reports'] = $data['udc_order_reports']->get();
            } else {
                $data['udc_order_reports'] = $data['udc_order_reports']->paginate($this->row_per_page);
            }

            $data['total_orders'] = Order::where('status', '!=', 5)
                ->where("status", '>', 1)
                ->where("created_at", ">=", $from)
                ->where("created_at", "<=", $to)
                ->where("ep_id", $data['ep_info']->id)
                ->get()->count();

            $data['total_sales'] = Order::where('status', '!=', 5)
                ->where("status", '>', 1)
                ->where("created_at", ">=", $from)
                ->where("created_at", "<=", $to)
                ->where("ep_id", $data['ep_info']->id)
                ->get()->sum('total_price');

            $data['total_commission'] = Order::where('status', '!=', 5)
                ->where("status", '>', 1)
                ->where("created_at", ">=", $from)
                ->where("created_at", "<=", $to)
                ->where("ep_id", $data['ep_info']->id)
                ->get()->sum('udc_commission');

            if (@$request->export_type == 'csv') {

                $writer = WriterFactory::create(Type::CSV);
                $file_name = "commission-report-" . date("YmdHis") . ".csv";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');

                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Center ID", "Phone Number", "Mobile Bank Numbers", "Total Orders", "Total Sale", "Total Commission"));
                foreach ($data['udc_order_reports'] as $key => $each_udc) {
                    $writer->addRow(array(
                        $key + 1,
                        @$each_udc->name_bn,
                        @$each_udc->center_id,
                        @$each_udc->contact_number,
                        'Bkash: ' . (@$each_udc->bkash_number ? '+88' . @$each_udc->bkash_number : '') . ' || ' . 'Rocket: ' . (@$each_udc->rocket_number ? '+88' . @$each_udc->rocket_number : ''),
                        (int)@$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->count(),
                        (int)$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('ep_id', $data['ep_info']->id)->sum('total_price'),
                        (int)$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('ep_id', $data['ep_info']->id)->sum('udc_commission')
                    ));
                }
                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "", "total_orders", "total_sales", "total_commission"));
                $writer->addRow(array("", "", "", "", "", number_format($data['total_orders'], 0), number_format($data['total_sales'], 0), number_format($data['total_commission'], 0)));
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
                    $writer->addRow(array(
                        $key + 1,
                        @$each_udc->name_bn,
                        @$each_udc->center_id,
                        '+88' . @$each_udc->contact_number,
                        'Bkash: ' . (@$each_udc->bkash_number ? '+88' . @$each_udc->bkash_number : '') . ' || ' . 'Rocket: ' . (@$each_udc->rocket_number ? '+88' . @$each_udc->rocket_number : ''),
                        (int)@$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->count(),
                        (int)$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('ep_id', $data['ep_info']->id)->sum('total_price'),
                        (int)$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('ep_id', $data['ep_info']->id)->sum('udc_commission')
                    ));
                }
                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "", "total_orders", "total_sales", "total_commission"));
                $writer->addRow(array("", "", "", "", "", number_format($data['total_orders'], 0), number_format($data['total_sales'], 0), number_format($data['total_commission'], 0)));
                $writer->close();
                return Response::download($filePath, $file_name);

            }
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ep.report.render_udc_commission_report', $data)->render());
        } else {
            return view('admin.ep.report.udc_commission_report')->with($data);
        }
    }

}
