<?php

namespace App\Http\Controllers;

use App\models\LogisticPartner;
use \App\models\LpShippingPackage;
use App\models\Order;
use App\models\OrderDetail;
use App\models\OrderInvoice;
use App\models\OrderTrack;
use App\models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;


class DummyController extends Controller
{

    public function udcReport()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.udc.report.report')->with($data);
    }

    public function test_orders(Request $request)
    {


        $test_orders = Order::whereHas('order_details')
            ->whereHas('user', function ($q) {
                $q->where('user_type', 4);
            })->with(['order_details', 'order_invoice', 'order_tracks'])
            ->get();

        $this->create_order_list($test_orders);

        if ($test_orders->count() == 0) {
            echo "<h3>Test order not found</h3>";
        } else {
            echo "<br><br><h3>" . $test_orders->count() . " test order found</h3>";
        }

        echo '<br><br><br><a href="deleteOrdersWithOrderdetails">Delete all Test Order</a>';
    }

    public function create_order_list($orders)
    {
        echo "<table style='width: 100%;'>";
        echo "<tr>";
        echo "<td style='width: 10%;'>Order ID</td>";
        echo "<td style='width: 10%;'>Order Code</td>";
        echo "<td style='width: 10%;'>Customer id</td>";
        echo "<td style='width: 10%;'>Customer Email</td>";
        echo "<td style='width: 10%;'>DC Entrepreneur Name</td>";
        echo "<td style='width: 10%;'>Created At</td>";
        echo "</tr>";

        echo "<tbody>";
        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td style='width: 10%;'>" . @$order->id . "</td>";
            echo "<td style='width: 10%;'>" . @$order->order_code . "</td>";
            echo "<td style='width: 10%;'>" . @$order->user_id . "</td>";
            echo "<td style='width: 10%;'>" . @$order->user->email . "</td>";
            echo "<td style='width: 10%;'>" . @$order->receiver_name . "</td>";
            echo "<td style='width: 10%;'>" . @$order->created_at . "</td>";
            echo '</tr>';
        }
        echo '</tbody>';

        echo '</table>';
    }

    public function deleteOrdersWithOrderdetails(Request $request)
    {
        $order_detail_id_arr = array();
        $order_id_arr = array();
        $order_invoice_arr = array();
        $order_track_arr = array();

        $test_orders = Order::whereHas('order_details')
            ->whereHas('user', function ($q) {
                $q->where('user_type', 4);
            })->with(['order_details', 'order_invoice', 'order_tracks'])
            ->get();

        $this->create_order_list($test_orders);

        foreach ($test_orders as $eachorder) {
            $order_id_arr[] = $eachorder->id;
            foreach ($eachorder->order_details as $each_details) {
                $order_detail_id_arr[] = @$each_details->id;
            }

            $order_invoice_arr[] = @$eachorder->order_invoice->id;

            if ($eachorder->order_tracks) {
                foreach (@$eachorder->order_tracks as $each_track) {
                    $order_track_arr[] = @$each_track->id;
                }
            }

            OrderDetail::destroy($order_detail_id_arr);
            OrderInvoice::destroy($order_invoice_arr);
            OrderTrack::destroy($order_track_arr);
        }

        Order::destroy($order_id_arr);

        $user_info = User::where('id', $request->udc_id)->first();
        if ($request->user_delete) {
            $user_info->destroy($request->udc_id);
        }

        echo "<br><br><br>" . $test_orders->count() . " orders has been deleted successfully";

        return;

//        dd($order_detail_id_arr);
        //dd($order_id_arr);
    }

    public function lpProfile()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.lp.profile.profile')->with($data);
    }

    public function lpReport()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['lp_management'] = 'start active open';
        $data['lp_report'] = 'active';
        return view('admin.not-found')->with($data);
//        return view('admin.ekom.lp.report.report')->with($data);
    }

    public function lpPackages()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.lp.package.package-list')->with($data);
    }

    public function lpPackageEdit()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.lp.package.package-edit')->with($data);
    }

    public function lpPackageCreate()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.lp.package.package-create')->with($data);
    }

    public function lpPaymentUDCList()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.lp.payment.lp-list')->with($data);
    }

    public function lpOrders()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.lp.lp_orders')->with($data);
    }

    public function siteMenu()
    {
        $data = array();
        $data['menu'] = 'site-menu';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.site_menu')->with($data);
    }

    public function login()
    {
        $data = array();
        return view('admin.ekom.login')->with($data);
    }


    public function mIndex()
    {
        $data = array();
        return view('m_frontend.home')->with($data);
    }

    public function categoryList()
    {
        $data = array();
        return view('m_frontend.category-list')->with($data);
    }

    public function productList()
    {
        $data = array();
        return view('m_frontend.products.product-list')->with($data);
    }

    public function productDetails()
    {
        $data = array();
        return view('m_frontend.products.product-details')->with($data);
    }

    public function productCart()
    {
        $data = array();
        return view('m_frontend.products.product-cart')->with($data);
    }

    public function productCheckoutB2B()
    {
        $data = array();
        return view('m_frontend.products.product-checkout-b2b')->with($data);
    }

    public function productCheckoutB2C()
    {
        $data = array();
        return view('m_frontend.products.product-checkout-b2c')->with($data);
    }

    public function storeList()
    {
        $data = array();
        return view('m_frontend.store.store-list')->with($data);
    }

    public function storeProfile()
    {
        $data = array();
        return view('m_frontend.store.store-profile')->with($data);
    }


    public function partnerLogin()
    {
        $data = array();
        return view('frontend.partner.login')->with($data);
    }

    public function partnerIndex()
    {
        $data = array();
        return view('m_frontend.partner.index')->with($data);
    }

    public function dccpProductList()
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.udc.products.dccp-product-list')->with($data);
    }

    public function addProduct()
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        return view('admin.udc.products.add-product')->with($data);
    }


    public function export()
    {
        $writer = WriterFactory::create(Type::XLSX); // for XLSX files
        $adb = File::put('tmp/order.xlsx', '');
        $data['all_orders'] = Order::all();
        $filePath = base_path('/tmp/order.xlsx');
        $writer->openToFile($filePath);

        $index_data = [
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

        $writer->addRow($index_data);

        $order_status = array("", "Active", "Warehouse left", "In Transit", "Delivered", "Canceled");
        foreach ($data['all_orders'] as $key => $order) {
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
        return Response::download($filePath);
    }

    public function udc_package()
    {

        $lps = LogisticPartner::limit(1)->get();

        foreach ($lps as $lp) {

            $udcs = User::whereHas('udc_package_list', function ($q) use ($lp) {
                $q->where('lp_id', $lp->id);
                $q->where(function ($q) use ($lp) {
                    $q->groupBy('location_id')->havingRaw('count(*) > 1');
                });
            })->with(['udc_package_list' => function ($q) use ($lp) {
                $q->where('lp_id', $lp->id);
            }])->get();

            foreach ($udcs as $udc) {
                if (@$udc->udc_package_list->count() > 1) {
                    $udc_packages = @$udc->udc_package_list->take($udc->udc_package_list->count() - 1);
                    dump(@$udc_packages);
                    foreach ($udc_packages as $udc_package) {
//                        $udc_package->delete();
                    }
                }
            }
//            $users = LpShippingPackage::where(function($q)use ($lp){
//                $q->where('lp_id', $lp->id)->groupBy('location_id')->havingRaw('count(*) > 1');
//            })->get();
//
//            echo $lp->lp_name.'<br>';
//            dump($users[0]);
//            dump($users[1]);
//            dump($users[2]);
//            dump($users[3]);
        }

    }

}
