<?php
/**
 * Created by PhpStorm.
 * User: Parallax Mahabub
 * Date: 2/13/2018
 * Time: 1:29 PM
 */

namespace App\Http\Controllers\admin\system;

use App\Libraries\ChangeOrderStatus;
use App\Libraries\EkomEncryption;
use App\Libraries\Slim;

//MODELS
use App\models\LoginInformation;
use App\models\AdminUser;
use App\models\EcommercePartner;
use App\models\_ecom_Setting;
use App\models\EpPayment;
use App\models\EpSession;
use App\models\Location;
use App\models\LogisticPartner;
use App\models\LpPayment;
use App\models\LpShippingPackage;
use App\models\Order;
use App\models\OrderDetail;
use App\models\OrderInvoice;
use App\models\OrderTrack;
use App\models\PackageWeightPrice;
use App\models\Product;
use App\models\ProductSeller;
use App\models\ProductStatistic;
use App\models\ProductAttribute;
use App\models\ProductAttributeValue;
use App\models\ProductCategory;
use App\models\ProductDetail;
use App\models\Store;
use App\models\Udc;
use App\models\UdcCustomer;
use App\models\UdcCustomerPayment;
use App\models\UdcPayment;
use App\models\UdcProduct;
use App\models\UdcProductDetail;
use App\models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SystemReport extends Controller
{
    public function userLoginInformation()
    {
        $login_information = LoginInformation::orderBy('created_at', 'desc')->get();
//        dd($login_information);
        echo "Total: " . $login_information->count() . " <br>";
        echo '<pre>';

        echo '<table>';
        echo '<thead>';
        echo '<th>';
        echo '<td>center_name<td><td>center_id<td><td>name_bn<td><td>name_en<td><td>entrepreneur_id<td><td>sonali_card<td>';
        echo '<td>national_id_no<td><td>center_jurisdiction<td><td>division<td><td>division_bbs<td><td>zilla<td>';
        echo '<td>zilla_bbs<td><td>citycorporation<td><td>municipality<td><td>unionname<td><td>unionname_bbs<td>';
        echo '<td>upazila<td><td>upazila_bbs<td><td>gender<td><td>phone<td><td>mobile<td><td>dob<td><td>email<td>';
        echo '<td>present_address<td>';
        echo '</th>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($login_information as $value) {

            $aggregate_response = json_decode($value->response);
            print_r($aggregate_response);
            if (@$aggregate_response->data) {
                echo '<tr>';
                echo '<td>' . @$aggregate_response->data->center_name . '<td>';
                echo '<td>' . $aggregate_response->data->center_id . '<td>';
                echo '<td>' . $aggregate_response->data->name_bn . '<td>';
                echo '<td>' . $aggregate_response->data->name_en . '<td>';
                echo '<td>' . $aggregate_response->data->entrepreneur_id . '<td>';
                echo '<td>' . $aggregate_response->data->sonali_card . '<td>';
                echo '<td>' . $aggregate_response->data->national_id_no . '<td>';
                echo '<td>' . $aggregate_response->data->center_jurisdiction . '<td>';
                echo '<td>' . $aggregate_response->data->division . '<td>';
                echo '<td>' . $aggregate_response->data->division_bbs . '<td>';
                echo '<td>' . $aggregate_response->data->zilla . '<td>';
                echo '<td>' . $aggregate_response->data->zilla_bbs . '<td>';
                echo '<td>' . @$aggregate_response->data->citycorporation . '<td>';
                echo '<td>' . @$aggregate_response->data->municipality . '<td>';
                echo '<td>' . @$aggregate_response->data->unionname . '<td>';
                echo '<td>' . $aggregate_response->data->unionname_bbs . '<td>';
                echo '<td>' . $aggregate_response->data->upazila . '<td>';
                echo '<td>' . $aggregate_response->data->upazila_bbs . '<td>';
                echo '<td>' . $aggregate_response->data->gender . '<td>';
                echo '<td>' . $aggregate_response->data->phone . '<td>';
                echo '<td>' . $aggregate_response->data->mobile . '<td>';
                echo '<td>' . $aggregate_response->data->dob . '<td>';
                echo '<td>' . $aggregate_response->data->email . '<td>';
                echo '<td>' . $aggregate_response->data->present_address . '<td>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
        echo '</table>';
        exit();

    }
}