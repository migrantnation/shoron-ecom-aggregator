<?php

namespace App\Http\Controllers\admin\lp;

use App\Libraries\PlxUtilities;
use App\models\CountryLocation;
use App\models\EcommercePartner;
use App\models\LoginInformation;
use App\models\LogisticPartner;
use App\models\LpShippingPackage;
use App\models\Order;
use App\models\OrderTrack;
use App\models\UdcCustomer;
use App\models\User;
use App\models\UserActivitiesLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Validator;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Support\Facades\File;


class LogisticPartnerController extends Controller
{
    public $row_per_page = 10;

    use AuthenticatesUsers;
    protected $redirectTo = 'lp';

    public function showLoginForm()
    {
        if (Auth::guard('lp_admin')->check()) {
            return back()->with('message', 'Unauthenticated Admin');
        }

        $data = array();
        return view('admin.lp.login')->with($data);
    }

    protected function guard()
    {
        return Auth::guard('lp_admin');
    }

    protected function logout()
    {
        Auth::guard('lp_admin')->logout();
        return redirect("lp/login");
    }

    private $function_array = array("d H" => "addHour", "M-d-D" => "addDay", "M-d" => "addDay", "Y-M" => "addMonth");
    private $time_subtraction_func = array("d H" => "subHour", "M-d-D" => "subDay", "M-d" => "subDay", "Y-M" => "subMonth");

    public function get_id_type()
    {
        $data['id'] = Auth::guard('lp_admin')->user()->id;
        $data['user_type'] = '2';
        return $data;
    }

    public function index(Request $request)
    {
        $data['side_bar'] = 'lp_side_bar';
        $data['header'] = 'lp_header';
        $data['footer'] = 'footer';
        $data['dashboard'] = 'start active open';

        $type_arr = array(
            '1' => 'Sales',
            '2' => 'Orders',
        );

        $type = $request->type ? $type_arr[$request->type] : $type_arr[1];

        $query_exception = array("1" => "user_id", "2" => "lp_id", "3" => "ep_id");
        $auth_id_type = $this->get_id_type();
        $id = $auth_id_type['id'];
        $user_type = $auth_id_type['user_type'];

        /*Number of orders*/
        $data['new_order'] = Order::where('status', '<', '2')->where(function ($q) use ($query_exception, $user_type, $id) {
            if ($user_type != 'Admin') {
                $q->where("$query_exception[$user_type]", $id);
            }
        })->get();

        $orders = Order::where('status', '!=', 5)->where(function ($q) use ($query_exception, $user_type, $id) {
            if ($user_type != 'Admin') {
                $q->where("$query_exception[$user_type]", $id);
            }
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
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->get();
            $data['canceled_orders'] = Order::where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '=', '5')->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->get();
            $data['order_completed'] = Order::where('status', '4')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->get();
            $data['all_sales'] = Order::selectRaw('sum(total_price) as total_sale')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '!=', 5)->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->first();
            $data['udc_commission'] = $orders->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '!=', '5')->sum('udc_commission');

        } else if (@$request->filter_range == 'all' || !@$request->filter_range) {

            $data['registered_dc'] = User::where('user_type', 1)->where('status', 1)->get();
            $data['orders'] = Order::where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->get();

            $data['canceled_orders'] = Order::where('status', '=', '5')->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->get();

            $data['order_completed'] = $completed_orders = Order::where('status', '4')->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->get();

            $data['all_sales'] = Order::selectRaw('sum(total_price) as total_sale')->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->where('status', '!=', 5)->first();

            $data['udc_commission'] = $orders->where('status', '!=', '5')->sum('udc_commission');

        } else {

            $data['registered_dc'] = User::where('user_type', 1)->where('status', 1)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
            $data['orders'] = Order::where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->get();
            $data['canceled_orders'] = Order::where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '=', '5')->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->get();
            $data['order_completed'] = Order::where('status', '4')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->get();
            $data['all_sales'] = Order::selectRaw('sum(total_price) as total_sale')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '!=', 5)->where(function ($q) use ($query_exception, $user_type, $id) {
                if ($user_type != 'Admin') {
                    $q->where("$query_exception[$user_type]", $id);
                }
            })->first();
            $data['udc_commission'] = $orders->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '!=', '5')->sum('udc_commission');

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
        $data['todays_order'] = Order::whereRaw('Date(created_at) = CURDATE()')->orderBy('created_at', 'desc')->where(function ($q) use ($query_exception, $user_type, $id) {
            if ($user_type != 'Admin') {
                $q->where("$query_exception[$user_type]", $id);
            }
        })->limit(20)->get();
        $data['todays_total_order'] = Order::whereRaw('Date(created_at) = CURDATE()')->selectRaw('count(id) as todays_total_order')->where(function ($q) use ($query_exception, $user_type, $id) {
            if ($user_type != 'Admin') {
                $q->where("$query_exception[$user_type]", $id);
            }
        })->first();
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
            if ($user_type != 'Admin') {
                $q->where("$query_exception[$user_type]", $id);
            }
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

        $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($from2)));
        $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($to2)));

        $ep = EcommercePartner::with(['ep_statistics' => function ($q) use ($from2, $to2) {
            $q->where('created_at', '>=', $from2);
            $q->where('created_at', '<=', $to2);
        }])->where('status', 1)->where('status', 1)->where(function ($q) use ($user_type, $id) {
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
        $data['active_ep'] = EcommercePartner::with(["orders" => function ($q) use ($from, $to, $id) {
            $q->where('created_at', '>=', $from);
            $q->where('created_at', '<=', $to);
            $q->where('lp_id', $id);
        }])->get();

        /*Recent Top 5 Users*/
        $data['udc_agents'] = User::whereHas('orders', function ($query) use ($from, $to) {
            $query->where('status', '!=', '5');
            $query->where('created_at', '>=', $from);
            $query->where('created_at', '<=', $to);
        })->with(['orders' => function ($query) use ($from, $to) {
            $query->where('status', '!=', '5');
            $query->where('created_at', '>=', $from);
            $query->where('created_at', '<=', $to);
        }])->withCount(['orders as orders' => function ($query) use ($from, $to) {
            $query->where('status', '!=', '5');
            $query->where('created_at', '>=', $from);
            $query->where('created_at', '<=', $to);
        }])->limit(10)->get()->sortByDesc('orders_count');

        /*Delivered Orders*/
        $delevered_order_chart_data = $this->get_chart_data($from, $to, $date_format, $completed_orders, 2);
        $data['delivered_order_values'] = $delevered_order_chart_data['chart_values'];
        $data['delivered_order_array'] = $delevered_order_chart_data['chart_labels'];

        if ($request->ajax()) {
            return Response::json(View::make('admin.lp.dashboard.render-dashboard', $data)->render());
        } else {
            return view('admin.lp.dashboard.dashboard')->with($data);
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


    public function recent_order_list(Request $request, $from = "", $to = "")
    {
        $meta = array();
        $response = array();

        $meta['page'] = $request->datatable['pagination']['page'];
        $meta['perpage'] = $request->datatable['pagination']['perpage'];
        $meta['sort'] = $request->datatable['sort']['sort'];
        $meta['field'] = $request->datatable['sort']['field'];

        $orders = Order::where('status', '!=', 5)
            ->where('created_at', '>=', "$from")
            ->where('created_at', '<=', "$to")
            ->orderBy($meta['field'], $meta['sort'])
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


    public function myProfile()
    {
        $data = array();
        $data['menu'] = 'profile';
        $data['side_bar'] = 'lp_side_bar';
        $data['header'] = 'lp_header';
        $data['footer'] = 'lp_footer';
        return view('admin.lp.profile.profile')->with($data);
    }

    public function report()
    {
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'lp_side_bar';
        $data['header'] = 'lp_header';
        $data['footer'] = 'lp_footer';
        return view('admin.lp.report.report')->with($data);
    }

    public function lpOrders(Request $request)
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'lp_side_bar';
        $data['header'] = 'lp_header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;

        $data['lp'] = Auth::guard('lp_admin')->user();
        $id = $data['lp']->id;

        $data['url'] = url("lp/orders");

        //Change Order Status
        if ($request->order_code) {
            $change_status = new ChangeOrderStatus();
            $change_status->change_order_status($request->order_code);
        }

        $data['limit'] = $limit = $request->limit;

        $exception_array = array(6912,6913,6914,6915,6916,6917,6918,6919,6920,6921,6922);
        $data['all_orders'] = Order::whereNotIn('id', $exception_array)->orderBy('id', 'desc')->where('lp_id', '=', $id);
        if ($request->search_string || $request->from || $request->to) {

            if ($request->to == '') $request->to = Carbon::now();

            $data['all_orders'] = $data['all_orders']->where(function ($query) use ($request) {
                if (isset($request->tab_id) && $request->tab_id != 'all') {
                    $query->where('status', $request->tab_id);
                }
                if (@$request->from) {
                    $query->where('created_at', '>=', @$request->from . ' 00:00:00');
                }
                if (@$request->to) {
                    $query->where('created_at', '<=', @$request->to . ' 23:59:59');
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
        $data['total_orders'] = $data['all_orders']->count();


        if (@$request->export_type || @$request->limit == 'all')
            $data['all_orders'] = $data['all_orders']->get();
        else
            $data['all_orders'] = $data['all_orders']->paginate($limit)->withPath("?tab_id=" . $request->tab_id);


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
            return Response::json(View::make('admin.lp.orders.lp-order-list-render', $data)->render());
        } else {
            return view('admin.lp.orders.lp_orders')->with($data);
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
        $data['side_bar'] = 'lp_side_bar';
        $data['header'] = 'lp_header';
        $data['footer'] = 'footer';
        $data['orders'] = 'active';

        $data['lp'] = $lp_info = Auth::guard('lp_admin')->user();

        $data['order_info'] = $order_info = Order::with(['order_details', 'order_invoice', 'lp_info', 'UdcCustomer'])
            ->where('order_code', $order_code)
            ->where('lp_id', $lp_info->id)
            ->first();

        if ($data['order_info']) {
            $data['user_info'] = $user_info = User::find(@$order_info->user_id);
            $data['tracking_details'] = OrderTrack::where('order_id', $order_info->id)->get();
            if ($data['tracking_details']) {
                $data['maxstatus'] = $this->getMaxStatus($data['tracking_details']);
            }
            $data['status_tracking_info'] = OrderTrack::where('order_id', @$order_info->id)->get()->groupBy('status');
            $data['udcCustomers'] = UdcCustomer::where('udc_id', @$order_info->user_id)->get();
            return view('admin.ekom.udc.order-details')->with($data);
        } else {
            return redirect()->back();
        }
    }

    public function change_order_status(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';

        if ($request->order_code) {
            $lp_info = Auth::guard('lp_admin')->user();

            if ($lp_info) {
                $changable_code = array(3);

                if (!in_array($request->status, $changable_code)) {
                    $response['message'] = 'You have no access to change order status.';
                } else {
                    $data["order_info"] = $order_info = Order::where('order_code', $request->order_code)->where('lp_id', $lp_info->id)->first();

                    if ($order_info) {

                        if ($order_info->lp_id == $lp_info->id) {

                            if (($request->status == 3 && $order_info->status == 2)) {

                                if ($request->status == 3) {
                                    //SAVE TRACKING INFORMATION
                                    $order_track = new OrderTrack();
                                    $order_track->order_id = $order_info->id;
                                    $order_track->status = $request->status;
                                    $order_track->message_by = $lp_info->lp_name;
                                    $order_track->user_type = "Logistic Partner";
                                    $order_track->message = "Order on the way";
                                    $order_track->save();
                                }

                                $order_info->status = $request->status;
                                $order_info->save();

                                $status = 200;
                                $response['message'] = 'Order status has bean changed successfully.';

                                $data["order_info"] = $order_info = Order::where('order_code', $request->order_code)->first();
                                $response['view'] = View::make('admin.lp.orders.lp_order_row', $data)->render();

                            } else {
                                $order_status = array("2" => "picked up", "3" => "on delivery", "4" => "delivered", "5" => "canceled");
                                $response['message'] = 'You have no access to change this order. This order already ' . @$order_status[$order_info->status];
                            }

                        } else {
                            $response['message'] = 'You have no access to change this order status';
                        }

                    } else {
                        $response['message'] = 'Order not found.';
                    }

                }

            } else {
                $status = 101;
                $response['message'] = 'Your LP is inactive, Please Contact with Ek-Shop Admin';
            }

        } else {
            $response['message'] = 'Order code is required';
        }

        $utility = new PlxUtilities();
        $utility->json($status, $response);
    }


    public function oder_tracking(Request $request, $order_code = 1)
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'lp_side_bar';
        $data['header'] = 'lp_header';
        $data['footer'] = 'footer';
        $data['track_order'] = 'active';

        $data['lp'] = $lp_info = Auth::guard('lp_admin')->user();
        $id = $lp_info->id;

        $data['order_info'] = $order_info = Order::with(['order_details', 'lp_info', 'UdcCustomer'])
            ->where('tracking_id', $order_code)
            ->where('lp_id', $id)
            ->first();

        if ($order_info) {
            $data['tracking_details'] = OrderTrack::where('order_id', $order_info->id)->get();
            if ($data['tracking_details']) {
                $data['maxstatus'] = $this->getMaxStatus($data['tracking_details']);
            }
            $data['status_tracking_info'] = OrderTrack::where('order_id', @$order_info->id)->get()->groupBy('status');
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.lp.orders.order-tracking-render', $data)->render());
        } else {
            return view('admin.lp.orders.order-tracking')->with($data);
        }
    }

    function getMaxStatus($array)
    {
        $max = 0;
        foreach ($array as $k => $v) {
            $max = max(array($max, $v['status']));
        }
        return $max;
    }


    public function save_order_tracking_message(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
            'message' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
        } else {
            $lp_info = Auth::guard('lp_admin')->user();

            $order_info = Order::where('order_code', $request->order_code)->where('lp_id', $lp_info->id)->first();
            if ($order_info) {

                if ($order_info->status > 1) {
                    if ($order_info->lp_id == $lp_info->id) {
                        //SAVE TRACKING INFORMATION
                        $order_track = new OrderTrack();
                        $order_track->order_id = $order_info->id;
                        $order_track->status = $order_info->status;
                        $order_track->message_by = $lp_info->lp_name;
                        $order_track->message = $request->message;
                        $order_track->save();

                        $status = 200;
                        $response['message'] = 'Order tracking message has bean saved successfully.';

                    } else {
                        $response['message'] = 'You have no access to this order status';
                    }
                } else {
                    $response['message'] = 'You have no access to change this order status';
                }
            } else {
                $response['message'] = 'Order not found.';
            }
        }


        $data['order_info'] = $order_info = Order::with(['order_details', 'lp_info', 'UdcCustomer'])
            ->where('order_code', $request->order_code)
            ->where('lp_id', $lp_info->id)
            ->first();

        if ($order_info) {
            $data['tracking_details'] = OrderTrack::where('order_id', $order_info->id)->get();
            if ($data['tracking_details']) {
                $data['maxstatus'] = $this->getMaxStatus($data['tracking_details']);
            }
            $data['status_tracking_info'] = OrderTrack::where('order_id', @$order_info->id)->get()->groupBy('status');
        }

        $response['view'] = View::make('admin.lp.orders.order-tracking-render', $data)->render();

        $utility = new PlxUtilities();
        $utility->json($status, $response);
    }


    //PACKAGE DISTRIBUTION
    public function lpPackageEdit()
    {
        $data['side_bar'] = 'lp_side_bar';
        $data['header'] = 'lp_header';
        $data['footer'] = 'footer';
        $data['lp_packages'] = 'start active open';


        $data['lp'] = $lp_info = Auth::guard('lp_admin')->user();
        $id = $lp_info->id;

        $data['locations'] = CountryLocation::where('tree_level', 0)->get();
        $data['users'] = User::orderBy('division', 'asc')->paginate($this->row_per_page);
        $data['lp'] = LogisticPartner::where('id', $id)->with('packages')->first();

        $data['division'] = User::where('user_type', 1)->select('division')->groupBy('division')->get();
        $data['district'] = User::where('user_type', 1)->where('division', @$input['division'])->select('district')->groupBy('district')->get();
        $data['upazila'] = User::where('user_type', 1)->where('district', @$input['district'])->select('upazila')->groupBy('upazila')->get();
        $data['union'] = User::where('user_type', 1)->where('upazila', @$input['upazila'])->select('union')->groupBy('union')->get();

        return view('admin.lp.package.packages')->with($data);
    }

    public function package_location(Request $request)
    {
        $data = array();
        $data['lp'] = LogisticPartner::where('id', $request->lp_id)->with('packages')->first();
        
        
        $data['users'] = User::where(function($q)use($request){
                if($request->search_string){
                    
                    $q->where('entrepreneur_id', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('contact_number', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('center_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('center_id', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->search_string . '%');
                }
                
            })->where(function($q)use($request){
                
                if($request->division){
                    $q->where('division', 'LIKE', '%' . $request->division . '%');
                }
                if($request->district){
                    $q->where('district', 'LIKE', '%' . $request->district . '%');
                }
                if($request->upazilla){
                    $q->where('upazila', 'LIKE', '%' . $request->upazilla . '%');
                }
                if($request->union){
                    $q->where('union', 'LIKE', '%' . $request->union . '%');
                }
                
            })->where(function($q)use($request){
                
                if($request->package_status == 1){ // Active
                    $q->whereHas('package', function($q)use($request){
                        $q->where('is_selected', 1);
                        $q->where('lp_id', $request->lp_id);
                    });
                }elseif($request->package_status == 2){ // Not Active
                
                    $q->whereHas('package', function($q)use($request){
                        $q->where('is_selected', '0');
                        $q->where('lp_id', $request->lp_id);
                    });
                    
                    // $q->orWhereDoesntHave('package', function($q)use($request){
                    //     $q->where('lp_id', $request->lp_id);
                    // });
                    
                }elseif($request->package_status == 3){ // Not Assigned
                    
                    $q->whereDoesntHave('package', function($q)use($request){
                        $q->where('lp_id', $request->lp_id);
                    });
                    
                }
            })
            ->orderBy('division', 'asc')
            ->paginate($this->row_per_page);
            
        
        return Response::json(View::make('admin.lp.package.package_list', $data)->render());
    }

    public function lpPackageUpdate(Request $request)
    {

        $data['lp'] = $lp_info = Auth::guard('lp_admin')->user();
        $id = $lp_info->id;

        $validator = Validator::make($request->all(), [

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        if ($lp_info) {
            $packages = $lp_info->packages->pluck('location_id')->toArray();
            if ($packages && $request->package) {
                foreach ($packages as $pack) {
                    if (!in_array($pack, $request->package) && in_array($pack, $request->location_id)) {
                        $lpShip = LpShippingPackage::where('location_id', $pack)->where('lp_id', $id)->delete();
                    }
                }
            }

            if ($request->package) {
                foreach ($request->package as $key => $package) {
                    $lpShippingPackage = LpShippingPackage::where('lp_id', $lp_info->id)->where('location_id', $request->location_id[$key])->first();
                    if (!$lpShippingPackage) {
                        $lpShippingPackage = new LpShippingPackage();
                        $lpShippingPackage->lp_id = $lp_info->id;
                        $lpShippingPackage->location_id = $request->location_id[$key];
                    }
                    $lpShippingPackage->delivery_duration = $request->delivery_duration[$key];
                    $lpShippingPackage->price = $request->price[$key];
                    $lpShippingPackage->package_code = @$request->package_code[$key];
                    $lpShippingPackage->updated_by = $lp_info->lp_name;
                    $lpShippingPackage->save();
                }
            }
        }

        return redirect('lp/packages')->with('message', 'Update Successful');
    }


    public function lp_package_list(Request $request)
    {
        $data['side_bar'] = 'lp_side_bar';
        $data['header'] = 'lp_header';
        $data['footer'] = 'footer';
        $data['lp_packages'] = 'start active open';

        $data['locations'] = CountryLocation::where('tree_level', 0)->get();
        $data['users'] = User::orderBy('division', 'asc')->get();
        $data['lp'] = LogisticPartner::where('id', Auth::guard("lp_admin")->user()->id)->with('packages')->first();

        return view('admin.lp.package.packages')->with($data);
    }


    public function save_package(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'location_id' => 'required',
            'price' => 'required',
            'delivery_duration' => 'required',
            'package_code' => '',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $utility->json($status, $response);
        }

        $data['users'] = User::where('id', $request->location_id)->paginate($this->row_per_page);
        $data['lp'] = LogisticPartner::where('id', Auth::guard("lp_admin")->user()->id)->with(['packages' => function ($q) use ($request) {
            $q->where('location_id', $request->location_id);
        }])->first();

        $lp_id = $data['lp']->id;
        $location_id = $request->location_id;
        $price = $request->price;
        $delivery_duration = $request->delivery_duration;
        $package_code = $request->package_code;

        $lpShippingPackage = LpShippingPackage::where('location_id', $location_id)->where('lp_id', $lp_id)->first();
        if ($lpShippingPackage) {
            $lpShippingPackage->lp_id = $lp_id;
            $lpShippingPackage->location_id = $location_id;
            $lpShippingPackage->delivery_duration = $delivery_duration;
            $lpShippingPackage->price = $price;
            $lpShippingPackage->package_code = $package_code;
            $lpShippingPackage->is_selected = 1;

            if (Auth::guard('lp_admin')->check()) {
                $lpShippingPackage->updated_by = "Updated by " . Auth::guard('lp_admin')->user()->lp_name;
            } else {
                $lpShippingPackage->updated_by = "_ecom_ Admin";
            }

            $lpShippingPackage->save();
        } else {
            $lpShippingPackage = new LpShippingPackage();
            $lpShippingPackage->lp_id = $lp_id;
            $lpShippingPackage->location_id = $location_id;
            $lpShippingPackage->delivery_duration = $delivery_duration;
            $lpShippingPackage->price = $price;
            $lpShippingPackage->package_code = $package_code;
            $lpShippingPackage->is_selected = 1;
            $lpShippingPackage->updated_by = "Updated by " . Auth::guard('lp_admin')->user()->lp_name;
            $lpShippingPackage->save();
        }

        $data['lp'] = LogisticPartner::where('id', Auth::guard("lp_admin")->user()->id)->with(['packages' => function ($q) use ($request) {
            $q->where('location_id', $request->location_id);
        }])->first();

        $status = 200;
        $response['message'] = "Package information has been updated successfully";
        $response['view'] = View::make('admin.lp.package.package_list', $data)->render();

        $utility->json($status, $response);
    }

    public function change_package_status(Request $request)
    {

        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'location_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $utility->json($status, $response);
        }

        $data['users'] = User::where('id', $request->location_id)->paginate($this->row_per_page);
        $data['lp'] = LogisticPartner::where('id', Auth::guard("lp_admin")->user()->id)->with(['packages' => function ($q) use ($request) {
            $q->where('location_id', $request->location_id);
        }])->first();

        $lpShippingPackage = LpShippingPackage::where('location_id', $request->location_id)->where('lp_id', $data['lp']->id)->first();
        $lpShippingPackage->is_selected = $request->status;
        $lpShippingPackage->updated_by = "Updated by " . Auth::guard('lp_admin')->user()->lp_name;
        $lpShippingPackage->save();

        $data['lp'] = LogisticPartner::where('id', Auth::guard("lp_admin")->user()->id)->with(['packages' => function ($q) use ($request) {
            $q->where('location_id', $request->location_id);
        }])->first();

        $status = 200;
        $response['message'] = "Package status has been updated successfully";
        $response['view'] = View::make('admin.lp.package.package_list', $data)->render();

        $utility->json($status, $response);
    }

}
