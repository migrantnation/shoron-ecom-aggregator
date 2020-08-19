<?php

namespace App\Http\Controllers\admin\ep;

use App\CommissionDisbursementHistory;
use App\Http\Traits\SMSTraits;
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

    use AuthenticatesUsers, SMSTraits;
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

    public $exception_array = array(
            6912,6913,6914,6915,6916,6917,6918,6919,6920,6921,6922, 
            11374, 11392, 11394, 11396, 11397, 11398, 11402, 11403,11404,11406,11407,11408,11410,11411,11412,11413,11414,11415,11416,11417,11418
        );
        

    public $udc_exception_array = array(
        3173, 3174, 3175, 3176, 3177, 3178, 3179, 3180, 3181, 3182, 3183, 3184, 3185, 3186, 3187, 3188, 3189, 3190, 3191, 3192
    );
        
        
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
        $data['new_order'] = Order::whereNotIn('id', $this->exception_array)->where('status', '<', '2')->where(function ($q) use ($query_exception, $user_type, $id) {
            $q->where("$query_exception[$user_type]", $id);
        })->get();

        $orders = Order::whereNotIn('id', $this->exception_array)->where('status', '!=', 5)->where(function ($q) use ($query_exception, $user_type, $id) {
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

            $data['orders'] = Order::whereNotIn('id', $this->exception_array)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();

            $data['canceled_orders'] = Order::whereNotIn('id', $this->exception_array)->where('created_at', '>=', $start_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('created_at', '<=', $end_date)->where('status', '=', '5')->get();

            $data['order_completed'] = Order::whereNotIn('id', $this->exception_array)->where('status', '4')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();

            $data['all_sales'] = Order::whereNotIn('id', $this->exception_array)->selectRaw('sum(total_price) as total_sale')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '!=', 5)->first();

            $data['udc_commission'] = $orders->where('created_at', '>=', $start_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('created_at', '<=', $end_date)->where('status', '!=', '5')->sum('udc_commission');

        } else if (@$request->filter_range == 'all' || !@$request->filter_range) {

            $data['registered_dc'] = User::where('user_type', 1)->where('status', 1)->get();

            $data['orders'] = Order::whereNotIn('id', $this->exception_array)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();

            $data['canceled_orders'] = Order::whereNotIn('id', $this->exception_array)->where('status', '=', '5')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();

            $data['order_completed'] = $completed_orders = Order::whereNotIn('id', $this->exception_array)->where('status', '4')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();

            $data['all_sales'] = Order::whereNotIn('id', $this->exception_array)->selectRaw('sum(total_price) as total_sale')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->where('status', '!=', 5)->first();
            $data['udc_commission'] = $orders->where('status', '!=', '5')->sum('udc_commission');

        } else {

            $data['registered_dc'] = User::where('user_type', 1)->where('status', 1)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
            $data['orders'] = Order::whereNotIn('id', $this->exception_array)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['canceled_orders'] = Order::whereNotIn('id', $this->exception_array)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '=', '5')->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['order_completed'] = Order::whereNotIn('id', $this->exception_array)->where('status', '4')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where(function ($q) use ($query_exception, $user_type, $id) {
                $q->where("$query_exception[$user_type]", $id);
            })->get();
            $data['all_sales'] = Order::whereNotIn('id', $this->exception_array)->selectRaw('sum(total_price) as total_sale')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status', '!=', 5)->where(function ($q) use ($query_exception, $user_type, $id) {
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
        $data['todays_order'] = Order::whereNotIn('id', $this->exception_array)->whereRaw('Date(created_at) = CURDATE()')->where(function ($q) use ($query_exception, $user_type, $id) {
            $q->where("$query_exception[$user_type]", $id);
        })->orderBy('created_at', 'desc')->limit(20)->get();
        $data['todays_total_order'] = Order::whereNotIn('id', $this->exception_array)->whereRaw('Date(created_at) = CURDATE()')->where(function ($q) use ($query_exception, $user_type, $id) {
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
        $completed_orders = Order::whereNotIn('id', $this->exception_array)->where('status', '4')->where(function ($q) use ($query_exception, $user_type, $id) {
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

            
        $data['all_orders'] = Order::whereNotIn('id', $this->exception_array)->where('ep_id', '=', $id);
        //dd($data['all_orders']);
        
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
                                
                                //SMS
                                $user_info = User::find($order_info->user_id);
                                $ep_info = EcommercePartner::find($order_info->ep_id);
                                $lp_info = LogisticPartner::find($order_info->lp_id);

                                $sending_to = array('UDC','EP','LP');

                                foreach ($sending_to as $value){
                                    $sendsms = $this->sendsms($order_info, $user_info,$ep_info,$lp_info, $value, 5);
                                }
                                
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

            if (date('Y-m-d', strtotime($from)) < "2018-07-01") {
                $data['show_btn'] = 'FALSE';
            } else {
                $data['show_btn'] = 'TRUE';
            }

            if ($request->to) {
                $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));
            } else {
                $data['to'] = $to = Carbon::now()->startOfMonth();
            }

            $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$to")));

            $data['ep_info'] = $ep_info = Auth::guard('ep_admin')->user();

            $data['udc_order_reports'] = User::whereNotIn('id', $this->udc_exception_array)->whereHas('orders', function ($q) use ($data, $request) {

                $q->where("status", '>', 1);
                $q->where("status", '!=', 5);

//                $q->where('is_commission_disburesed', '=', 0);

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

            $data['total_orders'] = Order::whereNotIn('id', $this->exception_array)->where(function ($q) use ($data, $from, $to, $request) {
                    if (@$request->from != 'all') {
                        $q->where("created_at", ">=", $from);
                        $q->where("created_at", "<=", $to);
                    }
                    $q->where('status', '!=', 5);
                    $q->where("status", '>', 1);
                    $q->where('is_commission_disburesed', '=', 0);
                    $q->where("ep_id", $data['ep_info']->id);

            })->get()->count();

            $data['total_sales'] = Order::whereNotIn('id', $this->exception_array)->where( function ($q) use ($data, $from, $to, $request) {
                    if (@$request->from != 'all') {
                        $q->where("created_at", ">=", $from);
                        $q->where("created_at", "<=", $to);
                    }
                    $q->where('status', '!=', 5);
                    $q->where("status", '>', 1);
                    $q->where('is_commission_disburesed', '=', 0);
                    $q->where("ep_id", $data['ep_info']->id);

                })->get()->sum('total_price');

            $data['total_commission'] = Order::whereNotIn('id', $this->exception_array)->where(function ($q) use ($data, $from, $to, $request) {
                if (@$request->from != 'all') {
                    $q->where("created_at", ">=", $from);
                    $q->where("created_at", "<=", $to);
                }
                $q->where('status', '!=', 5);
                $q->where("status", '>', 1);
                $q->where('is_commission_disburesed', '=', 0);
                $q->where("ep_id", $data['ep_info']->id);

            })->get()->sum('udc_commission');

            if (@$request->export_type == 'csv') {

                $writer = WriterFactory::create(Type::CSV);
                $file_name = "commission-report-" . date("YmdHis") . ".csv";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');

                $total_disbursed_commission = 0;
                $total_outstanding_commission = 0;
                $this_udc_commission = 0;
                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Center ID", "Phone Number", "Mobile Bank Numbers", "Total Orders", "Total Sale", "Disbursed Commission", "Outstanding Commission", "Total Commission"));
                foreach ($data['udc_order_reports'] as $key => $each_udc) {

                    $this_udc_commission = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('udc_commission');
                    $total_disbursed_commission += @$each_udc->total_disbursed_commission->sum('amount');
                    $total_outstanding_commission += $this_udc_commission + @$each_udc->total_disbursed_commission->sum('due_amount') + @$each_udc->get_prev_due_commission->sum('udc_commission');

                    $writer->addRow(array(
                        $key + 1,
                        @$each_udc->name_bn,
                        @$each_udc->center_id,
                        @$each_udc->contact_number,
                        'Bkash: ' . (@$each_udc->bkash_number ? '+88' . @$each_udc->bkash_number : '') . ' || ' . 'Rocket: ' . (@$each_udc->rocket_number ? '+88' . @$each_udc->rocket_number : ''),
                        number_format((@$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->count()), 0),
                        number_format($each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('total_price'), 0),
                        number_format(@$each_udc->total_disbursed_commission->sum('amount'), 0),
                        number_format($each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('udc_commission') + @$each_udc->total_disbursed_commission->sum('due_amount') + @$each_udc->get_prev_due_commission->sum('udc_commission'), 0),
                        number_format($this_udc_commission, 0)
                    ));
                }
                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "", "total_orders", "total_sales", "total_disbursed_commission", "total_outstanding_commission", "total_commission"));
                $writer->addRow(array("", "", "", "", "", number_format($data['total_orders'], 0), number_format($data['total_sales'], 0), number_format(@$total_disbursed_commission, 0), number_format($total_outstanding_commission, 0), number_format($data['total_commission'], 0)));
                $writer->close();
                return Response::download($filePath, $file_name);

            } else if (@$request->export_type == 'xlsx') {

                $writer = WriterFactory::create(Type::XLSX);
                $file_name = "commission-report-" . date("YmdHis") . ".xlsx";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');

                $total_disbursed_commission = 0;
                $total_outstanding_commission = 0;
                $this_udc_commission = 0;
                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Center ID", "Phone Number", "Mobile Bank Numbers", "Total Orders", "Total Sale", "Disbursed Commission", "Outstanding Commission", "Total Commission"));
                foreach ($data['udc_order_reports'] as $key => $each_udc) {

                    $this_udc_commission = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('udc_commission');
                    $total_disbursed_commission += @$each_udc->total_disbursed_commission->sum('amount');
                    $total_outstanding_commission += $this_udc_commission + @$each_udc->total_disbursed_commission->sum('due_amount') + @$each_udc->get_prev_due_commission->sum('udc_commission');

                    $writer->addRow(array(
                        $key + 1,
                        @$each_udc->name_bn,
                        @$each_udc->center_id,
                        @$each_udc->contact_number,
                        'Bkash: ' . (@$each_udc->bkash_number ? '+88' . @$each_udc->bkash_number : '') . ' || ' . 'Rocket: ' . (@$each_udc->rocket_number ? '+88' . @$each_udc->rocket_number : ''),
                        number_format((@$each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->count()), 0),
                        number_format($each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('total_price'), 0),
                        number_format(@$each_udc->total_disbursed_commission->sum('amount'), 0),
                        number_format($each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->where('ep_id', $data['ep_info']->id)->sum('udc_commission') + @$each_udc->total_disbursed_commission->sum('due_amount') + @$each_udc->get_prev_due_commission->sum('udc_commission'), 0),
                        number_format($this_udc_commission, 0)
                    ));
                }
                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "", "total_orders", "total_sales", "total_disbursed_commission", "total_outstanding_commission", "total_commission"));
                $writer->addRow(array("", "", "", "", "", number_format($data['total_orders'], 0), number_format($data['total_sales'], 0), number_format(@$total_disbursed_commission, 0), number_format($total_outstanding_commission, 0), number_format($data['total_commission'], 0)));
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

    public function commission_disburse(Request $request)
    {

        $status = 100;
        $response = array();
        $response['message'] = '';
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'footer';
        $data['udc_commission'] = 'active';

        $data['ep_info'] = $ep_info = Auth::guard('ep_admin')->user();
        $data['from'] = $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
        $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));

        $get_due_order = Order::where(function ($query) use ($request, $from, $to, $ep_info) {
            $query->where("created_at", ">=", "2018-07-01"); //FROM JUNE
            $query->where("created_at", "<=", $from/*"2018-07-31"*/);
            $query->where('ep_id', $ep_info->id);
            $query->where('user_id', $request->udc_id);
            $query->where('is_commission_disburesed', '=', 0);
            $query->where('status', '!=', 5);
            $query->where("status", '>', 1);
        })->orderBy('created_at', 'asc')->get();

        if ($get_due_order->count() > 0 && $request->get_modal !== "TRUE") {
            $from = date('Y-m-d', strtotime(@$get_due_order[0]->created_at));
        }

        $data['get_orders'] = $orders = Order::where(function ($query) use ($request, $from, $to, $ep_info) {
            $query->where("created_at", ">=", $from);
            $query->where("created_at", "<=", $to);
            $query->where('ep_id', $ep_info->id);
            $query->where('user_id', $request->udc_id);
            $query->where('is_commission_disburesed', '=', 0);
            $query->where('status', '!=', 5);
            $query->where("status", '>', 1);
        })->orderBy('created_at', 'asc')->get();

        $data['prev_due'] = CommissionDisbursementHistory::where('ep_id', $ep_info->id)->where('udc_id', $request->udc_id)->orderBy('id', 'desc')->first();
        $prev_due_amount = @$data['prev_due']->due_amount ? @$data['prev_due']->due_amount : 0;
        if ($request->get_modal === "TRUE") {
			
			$data['from_date'] = @$get_due_order[0]->created_at;
            $data['udc_info'] = User::find($request->udc_id);
            $data['commission_for_selected_month'] = @$data['get_orders']->sum('udc_commission');
            $data['commission_for_prev_month'] = @$get_due_order->sum('udc_commission');
            return Response::json(View::make('admin.ep.report.commission-disburse-modal', $data)->render());
        }

        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'udc_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $utility = new PlxUtilities();
            return $utility->json($status, $response);
        } else {

            foreach ($orders as $order) {
                $order_update = Order::find($order->id);
                $order_update->is_commission_disburesed = 1;
                $order_update->save();
            }

            $due_amount = $orders->sum('udc_commission') + @$prev_due_amount;
            if ($due_amount) {
                $due_amount = $due_amount == $request->amount ? 0.00 : $due_amount - $request->amount;
            } else {
                $due_amount = 0.00;
            }

            $disbursement_data = new CommissionDisbursementHistory();
            $disbursement_data->udc_id = $request->udc_id;
            $disbursement_data->ep_id = $ep_info->id;
            $disbursement_data->amount = $request->amount;
            $disbursement_data->due_amount = @$due_amount;
            $disbursement_data->disbursement_from_date = $from;
            $disbursement_data->disbursement_to_date = $to;
            $disbursement_data->transfer_method = $request->transfer_method && $request->transfer_method == 1 ? "Bkash" : "Rocket";
            $disbursement_data->mobile_banking_number = @$request->mobile_banking_number;
            $disbursement_data->transaction_number = @$request->transaction_number;
            $disbursement_data->note = $request->disburse_note;
//            dd($prev_due_amount);
//            dd($disbursement_data);
            $disbursement_data->save();
            return 1;
        }
    }

    public function disburesed_commission_list(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'footer';
        $data['commission_disburse_list'] = 'active';

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

            $monthDiff = date('m', strtotime($data['to'])) - date('m', strtotime($data['from']));
            $data['month'] = $request->from && $request->from == "all" ? $request->from : $monthDiff > 1 ? 'all' : date('m', strtotime($data['from']));
            $data['year'] = $request->to && $request->to == "all" ? $request->to : date('Y', strtotime($data['from']));
            $data['epId'] = $request->ep_id;

            $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$to")));
            $data['ep_info'] = $ep_info = EcommercePartner::where('id', Auth::guard('ep_admin')->user()->id)->first();

//            $data['ep_name'] = $request->ep_id &&  $request->ep_id == 'all' ? "All EP" : $data['ep_info']->ep_name;
            $data['ep_id'] = Auth::guard('ep_admin')->user()->id;

            $data['disbursed_commission_list'] = CommissionDisbursementHistory::where(function ($q) use ($data, $request) {
                if(@$request->from != 'all'){
                    $q->where("disbursement_from_date", ">=", $data['from']);
                    $q->where("disbursement_to_date", "<=", $data['to']);
                }if ($request->search_string && $request->search_string != 'undefined') {
                    $q->whereHas('udc', function ($query) use ($request) {
                        $query->where('name_bn', 'LIKE', '%' . $request->search_string . '%')
                            ->orWhere('name_en', 'LIKE', '%' . $request->search_string . '%')
                            ->orWhere('contact_number', 'LIKE', '%' . $request->search_string . '%');
                    })->orderBy('id', 'desc')->paginate($this->row_per_page);
                }})->where('ep_id', Auth::guard('ep_admin')->user()->id)->orderBy('id', 'desc')->paginate($this->row_per_page);

            $ep_id = @$data['ep_info']->id;
            $total_disbursed_amount = 0;
            if (@$request->export_type == 'csv') {
                $writer = WriterFactory::create(Type::CSV);
                $file_name = "commission-report-" . date("YmdHis") . ".csv";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');

                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Contact Number", "EP Name",  "Disbursed Amount", "Disbursed Date", "Selected Month"));

                foreach ($data['disbursed_commission_list'] as $key => $each_commission) {
                    $total_disbursed_amount += @$each_commission->amount;
                    $writer->addRow(array(
                        $key + 1,
                        @$each_commission->udc->name_bn,
                        @$each_commission->udc->contact_number,
                        @$each_commission->ep_info->ep_name,
                        number_format(@$each_commission->amount),
                        date('M d, Y', strtotime(@$each_commission->created_at)),
                        date('F', strtotime(@$each_commission->disbursement_from_date))
                    ));
                }

                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "Total Disbursed Amount"));
                $writer->addRow(array("", "", "", "", number_format($total_disbursed_amount, 0)));
                $writer->close();
                return Response::download($filePath, $file_name);

            } else if (@$request->export_type == 'xlsx') {

                $writer = WriterFactory::create(Type::XLSX);
                $file_name = "commission-report-" . date("YmdHis") . ".xlsx";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');
                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Contact Number", "EP Name",  "Disbursed Amount", "Disbursed Date", "Selected Month"));

                foreach ($data['disbursed_commission_list'] as $key => $each_commission) {

                    $total_disbursed_amount += @$each_commission->amount;

                    $writer->addRow(array(
                        $key + 1,
                        @$each_commission->udc->name_bn,
                        @$each_commission->udc->contact_number,
                        @$each_commission->ep_info->ep_name,
                        number_format(@$each_commission->amount),
                        date('M d, Y', strtotime(@$each_commission->created_at)),
                        date('F', strtotime(@$each_commission->disbursement_from_date))
                    ));
                }
                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "Total Disbursed Amount"));
                $writer->addRow(array("", "", "", "", number_format($total_disbursed_amount, 0)));
                $writer->close();
                return Response::download($filePath, $file_name);

            }
        }else{
            $data['disbursed_commission_list'] = CommissionDisbursementHistory::where(function ($q) use ($data, $request) {if ($request->search_string) {
                $q->whereHas('udc', function ($query) use ($request) {
                    $query->where('name_bn', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('name_en', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('contact_number', 'LIKE', '%' . $request->search_string . '%');
                })->orderBy('id', 'desc')->paginate($this->row_per_page);
            }})->where('ep_id', Auth::guard('ep_admin')->user()->id)->orderBy('id', 'desc')->paginate($this->row_per_page);
        }

        $data['all_eps'] = EcommercePartner::all();

        if ($request->ajax()) {
            return Response::json(View::make('admin.ep.report.render-disbursed-commission-list', $data)->render());
        } else {
            return view('admin.ep.report.disburesed-commission-list')->with($data);
        }
    }

    public function disburesement_invoice(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ep_side_bar';
        $data['header'] = 'ep_header';
        $data['footer'] = 'footer';
        $data['commission_disburse_list'] = 'active';

        $get_disbursed = CommissionDisbursementHistory::find($request->id);

        $data['disbursed_info'] = $disbursed_info = CommissionDisbursementHistory::with(['udc_orders' => function ($query) use ($get_disbursed) {
            $query->where("created_at", ">=", $get_disbursed->disbursement_from_date);
            $query->where("created_at", "<=", $get_disbursed->disbursement_to_date);
            $query->where('ep_id', $get_disbursed->ep_id);
            $query->where('user_id', $get_disbursed->udc_id);
            $query->where('is_commission_disburesed', '=', 1);
            $query->where('status', '!=', 5);
        }])->where('id', $request->id)
            ->first();

        return view('admin.ep.report.disburesement-invoice')->with($data);
    }
}
