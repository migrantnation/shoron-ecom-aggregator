<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Traits\SMSTraits;

use App\CartDetail;
use App\Libraries\Package;
use App\Libraries\PlxUtilities;
use App\models\EcommercePartner;
use App\models\LogisticPartner;
use App\models\CountryLocation;
use App\models\LpShippingPackage;
use App\models\Order;
use App\models\OrderDetail;
use App\models\OrderInvoice;
use App\models\Product;
use App\models\ProductSeller;
use App\models\Store;
use App\models\Udc;
use App\models\UdcCustomer;
use App\models\UdcCustomerPayment;
use App\models\UdcProduct;
use App\models\UdcProductDetail;
use App\models\User;
use App\models\UserActivitiesLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Validator;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    
    use SMSTraits;

    public function place_order()
    {
        $data = array();
        $log_data = array();
        $pkg = new Package();

        //EP INITIALIZATION
        $ep_order = new \stdClass();
        $ep_order->order = new \stdClass();
        $ep_order->order->order_details = array();

        //LP INITIALIZATION
        $lp_order = new \stdClass();
        $lp_order->order = new \stdClass();
        $lp_order->order->order_details = array();
        $lp_post_data = array();

        //DC INFORMATION
        $data['user_info'] = $user_info = Auth::user();

        // CART INFORMATION
        $data['order_details'] = $cart_details = CartDetail::where('user_id', Auth::user()->id)->first();

        $delivery_charge = (in_array($cart_details->ep_id, $pkg->freeShippingEp())  && @$cart_details->lp_id != 13) ? 0.00 : $cart_details->lp_delivery_charge;

        if (!$cart_details)
            return redirect('');

        $lp_package_info = LpShippingPackage::where('id', $cart_details->lp_package_id)->first();

        if (!$cart_details->lp_id)
            return redirect('checkout-ep');

        //WAITING FOR PAYMENT GATEWAY

        $cart_detail = json_decode($cart_details->cart_detail);
        $ep_info = EcommercePartner::where('id', $cart_details->ep_id)->first();
        $lp_info = LogisticPartner::where('id', $cart_details->lp_id)->first();
        $last_order = Order::orderBy('id', 'desc')->first();

        $order_info = new Order(); //product_id

        // ECOMMERCE PARTNER
        $order_info->ep_id = $ep_info->id;
        $order_info->ep_name = $ep_info->ep_name;
        $order_info->ep_contact_person = $ep_info->contact_person;
        $order_info->ep_location = $ep_info->address;
        $order_info->ep_contact_number = $ep_info->contact_number;

        //LOGISTIC PARTNER INFORMATION
        $order_info->lp_id = $cart_details->lp_id;
        $order_info->lp_package_id = $cart_details->lp_package_id;
        $ep_order->order->lp_code = $lp_info->lp_code;
        $ep_order->order->lp_name = $order_info->lp_name = $cart_details->lp_name;
        $ep_order->order->lp_contact_person = $order_info->lp_contact_person = $cart_details->lp_contact_person;
        $ep_order->order->lp_contact_number = $order_info->lp_contact_number = $cart_details->lp_contact_number;

        $ep_order->order->lp_delivery_charge = $order_info->lp_delivery_charge = $order_info->delivery_charge = $delivery_charge;

        $ep_order->order->lp_location = $order_info->lp_location = $cart_details->lp_location;
        $ep_order->order->delivery_duration = $cart_details->delivery_duration;

        $order_info->delivery_duration = $cart_details->delivery_duration;

        $ep_order->order->recipient_center_name = $user_info->center_name;
        $ep_order->order->recipient_name = $cart_details->receiver_name;
        $ep_order->order->recipient_mobile = $cart_details->receiver_contact_number;
        $ep_order->order->recipient_email = $user_info->email;
        $ep_order->order->recipient_division = $user_info->division;
        $ep_order->order->recipient_district = $user_info->district;
        $ep_order->order->recipient_upazila = $user_info->upazila;
        $ep_order->order->recipient_union = $user_info->union;

        //RECIEVER INFORMATION
        $order_info->user_id = $cart_details->user_id;
        $order_info->receiver_name = $cart_details->receiver_name;
        $order_info->receiver_contact_number = $cart_details->receiver_contact_number;
        $order_info->delivery_location = $cart_details->delivery_location;
        $order_info->total_price = $cart_details->total_price;

        $ep_order->order->payment_method = $order_info->payment_method = $cart_details->payment_method;
        $order_info->payment_status = ($cart_details->payment_method == 1) ? 1 : 2;

        //SAVE ORDER DETAILS
        $order_sub_total = 0;
        $number_of_item = 0;
        $total_quantity = 0;
        $total_item = 0;
        $lp_order_detail = array();
        foreach ($cart_detail->cart as $key => $item) {
            $ep_order->order->order_details[$key] = new \stdClass();
            $lp_order->order->order_details[$key] = new \stdClass();

            $ep_order->order->order_details[$key]->product_id = $item->id;
            $ep_order->order->order_details[$key]->product_name = $lp_order->order->order_details[$key]->product_name = $item->name;
            $ep_order->order->order_details[$key]->unit_price = $item->unit_price;
            $ep_order->order->order_details[$key]->quantity = $lp_order->order->order_details[$key]->quantity = $item->qty;
            $ep_order->order->order_details[$key]->price = $item->price;
            $ep_order->order->order_details[$key]->variation_id = @$item->variation_id;
            $ep_order->order->order_details[$key]->option = @$item->option;

            $lp_order_detail[] = 'Name:' . $item->name . '|qty:' . $item->qty . '|Price:' . $item->price;

            //CALCULATING SUBTOTAL
            $order_sub_total += ($item->price);
            $number_of_item += $item->qty;

            $total_quantity += $item->qty;
            $total_item++;
        }

        $ep_order->order->cart_options = @$cart_detail->cart_options;
        $ep_order->order->total = $order_sub_total;

        //TOTAL PRICE
        $order_info->sub_total = $order_sub_total;
        $order_info->total_price = $order_sub_total + $order_info->delivery_charge;

        // COMMISSION
        $order_info->lp_commission = ($order_sub_total / 100) * @$lp_info->lp_commission;
        $order_info->ep_commission = ($order_sub_total / 100) * @$ep_info->ep_commission;
        $order_info->ekom_commission = ($order_sub_total / 100) * number_format(10, 2);
        $ep_post_data['udc_commission'] = $order_info->udc_commission = $cart_details->order_commission;


        $order_info->total_item = @$total_item;
        $order_info->total_quantity = @$total_quantity;
        $order_info->status = 1;
        $order_info->ep_cart_id = @$cart_detail->cart_options->cart_id;
        $order_info->save();
        
        //SMS FOR UDC
        $ep_order->order->order_code = $order_info->order_code = @$ep_info->ep_short_code . @$lp_info->lp_short_code . $order_info->id;
        $sendsmsudc = $this->sendsms($order_info , $user_info, $ep_info, $lp_info, "UDC",1);

        $order_detail_ids = array();
        foreach ($cart_detail->cart as $key => $item) {
            $order_detail = new OrderDetail();

            $product_info = UdcProductDetail::with(['udc_product'])->where('ep_id', $ep_info->id)->where('product_url', $item->product_url)->first();
            if (@$product_info) {
                $product_info->quantity = $product_info->quantity - $item->qty;
                $product_info->sale_quantity = $product_info->sale_quantity + $item->qty;
                $product_info->save();

                $seller_info = User::where('id', $product_info->udc_product->udc_id)->first();
                $order_detail->udc_product_id = $product_info->product_id;
                $order_detail->seller_id = $seller_info->id;
            }

            if (isset($item->commission)) {
                $order_detail->purchase_commission = @$item->commission;
            } else {
                $order_detail->purchase_commission = 0.00;
            }

            $order_detail->order_id = @$order_info->id;
            $order_detail->ep_product_id = $item->id;
            $order_detail->product_name = $item->name;
            $order_detail->product_url = $item->product_url;
            $order_detail->product_image = $item->image;
            $order_detail->unit_price = $item->unit_price;
            $order_detail->quantity = $item->qty;
            $order_detail->price = $item->price;
            $order_detail->save();

            $order_detail_ids[] = $order_detail->id;
        }

        //CREATE INVOICE
        $order_invoice = new OrderInvoice();
        $order_invoice->order_id = $order_info->id;
        $order_invoice->invoice_code = rand(111111, 9999999);
        $order_invoice->transaction_number = rand(111111, 9999999);
        $order_invoice->total_amount = $order_info->total_price;
        $order_invoice->paid_amount = 0.00;
        $order_invoice->save();


        $ep_order->order->order_code = $order_info->order_code = @$ep_info->ep_short_code . @$lp_info->lp_short_code . $order_info->id;
        $ep_order->order->cart_session_id = @$cart_detail->cart_session_id ? @$cart_detail->cart_session_id : "";
		$order_info->tracking_id = @$ep_info->ep_short_code . @$lp_info->lp_short_code . $order_info->id;
        $order_info->save();

        /**
         * PLACE ORDER TO EP
         **/
        $postData = array();
        $ep_post_data['ekom_order'] = json_encode($ep_order);

        if ($ep_info->id == 4)
            $ep_post_data['secret'] = "eccbbed65c5967840b4a8a0cdefb89b1";

        foreach ($ep_post_data as $key => $value)
            $postData[] = $key . '=' . $value;

        $postData = implode("&", $postData);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ep_info->place_order_api_url);

        if ($ep_info->id == 9) {
            $line_items = array();
            foreach ($cart_detail->cart as $key => $item) {
                $line_items[$key]['product_id'] = $item->id;
                $line_items[$key]['quantity'] = $item->qty;
                $wc_customer_id = $item->wc_customer_id;
            }

            $udc_address = array();
            $udc_address[] = $user_info->division;
            $udc_address[] = $user_info->district;
            $udc_address[] = $user_info->upazila;
            $udc_address[] = $user_info->union;
            $udc_address[] = $user_info->contact_number;

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{
                              "payment_method": "COD",
                              "payment_method_title": "Cash On Delivery",
                              "set_paid": false,
                              "billing": {
                                "first_name": "' . $user_info->name_bn . '",
                                "last_name": "",
                                "address_1": "' . implode(',',$udc_address) . '",
                                "address_2": "",
                                "city": "",
                                "state": "",
                                "postcode": "",
                                "country": "Bangladesh",
                                "email": "' . $user_info->email . '",
                                "phone": " "
                              },
                              "shipping": {
                                "first_name": "' . $cart_details->lp_contact_person . ',",
                                "last_name": "' . $cart_details->lp_name . '",
                                "address_1": "' . $cart_details->lp_location . ", Mobile: " .$cart_details->lp_contact_number. '",
                                "address_2": " ",
                                "city": " ",
                                "state": " ",
                                "postcode": " ",
                                "country": "Bangladesh"
                              },
                              "line_items": '.json_encode($line_items).',
                              
                              "shipping_lines": [
                                {
                                  "method_id": "flat_rate",
                                  "method_title": "Flat Rate",
                                  "total": "0"
                                }
                              ]
                            }');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_USERPWD, "$ep_info->authorization:$ep_info->api_key");
            $response = curl_exec($ch);
            
            $order_id = json_decode($response);
            $clear_cart = $this->arpon_clear_cart($ep_info->ep_url ."/_ecom_?_ecom_=clear-cart", @$order_id->id, $wc_customer_id);
            $order_info->ep_order_id = @$order_id->id;
            
            $headers = array();
        } else {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_ENCODING, "");
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, "$postData");
            curl_setopt($ch, CURLOPT_POST, 1);
            $headers = array();
            $headers[] = "api_key: $ep_info->api_key";
            $headers[] = "authorization: $ep_info->authorization";
            $headers[] = "Cache-Control: no-cache";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
        }

        $sent_request = curl_getinfo($ch);
        $log_data['track'] = 'EP INFO';
        $log_data['headers'] = $headers;
        $log_data['ch'] = $sent_request;
        $log_data['postdata'] = $postData;
        $log_data['response'] = $response;

        $ep_log_filename = 'log-ep-' . $order_info->order_code . '.log';
        $order_info->ep_log = $ep_log_filename;
        $this->server_log(json_encode($log_data), $ep_log_filename);


        curl_close($ch);
        $response = json_decode($response);
        if (@$response->meta->status == 200) {
            //SMS FOR EP
            $sendsmsep = $this->sendsms($order_info , $user_info,$ep_info,$lp_info, "EP",1);
            $order_info->ep_order_id = @$response->response->order_id;
        }

        //CREATE ACTIVITY
        $user_activity = new UserActivitiesLog();
        $user_activity->type = "20";
        $user_activity->message = "New order has been placed to " . $ep_info->ep_name;
        $user_activity->ids = $order_info->id;
        $user_activity->save();


        /**
         * PLACE ORDER TO LP
         * */
        if ($lp_info->id == 1) {

            $lp_partner1_post_data['store_id'] = $ep_info->lp_partner1_id;

            // PREPARING POST DATA
            $lp_partner1_post_data['receiver_name'] = $cart_details->receiver_name;
            $lp_partner1_post_data['receiver_address'] = $cart_details->delivery_location;
            $lp_partner1_post_data['receiver_number'] = $cart_details->receiver_contact_number;
            $lp_partner1_post_data['recipient_email'] = @$user_info->email;
            //$lp_partner1_post_data['plane_id'] = $order_info->total_price;
            $lp_partner1_post_data['cost'] = $order_info->total_price;
            $lp_partner1_post_data['instructions'] = '_ecom_ Order';
            if ($lp_order_detail) {
                $lp_partner1_post_data['package_description'] = implode('; ', $lp_order_detail);
            } else {
                $lp_partner1_post_data['package_description'] = 'Product detail not found';
            }
            $lp_partner1_post_data['order_code'] = $order_info->order_code;

            $postData = '';
            foreach ($lp_partner1_post_data as $key => $value) {
                $postData .= $key . '=' . $value . '&';
            }
            rtrim($postData, '&');

            $lp_log_filename = 'log-lp-' . $order_info->order_code . '.log';
            $order_info->lp_log = $lp_log_filename;

            // PLACE ORDER TO lp_partner1 COURIER
            $response = $this->place_order_to_lp_partner1_courier($lp_info->place_order_api_url, $postData, $lp_info, $lp_log_filename);

            $response = json_decode($response);
            if (@$response->success === true) {
                //SMS FOR LP
                $sendsmslp = $this->sendsms($order_info , $user_info,$ep_info,$lp_info, "LP", 1);
                $order_info->lp_order_id = $response->id;
            }

        } elseif ($lp_info->id == 4) {

            $lp_post_data['product_id'] = $order_info->order_code;
            $lp_post_data['order_code'] = $order_info->order_code;
            $lp_post_data['parcel'] = "insert";
            $lp_post_data['ep_name'] = $ep_info->ep_name;
            $lp_post_data['pick_contact_person'] = $ep_info->contact_person;
            $lp_post_data['pick_division'] = @$ep_info->division ? $ep_info->division : '#';
            $lp_post_data['pick_district'] = @$ep_info->district ? $ep_info->district : '#';
            $lp_post_data['pick_thana'] = @$ep_info->thana ? $ep_info->thana : '#';
            $lp_post_data['pick_union'] = @$ep_info->union ? $ep_info->union : '#';
            $lp_post_data['pick_address'] = $ep_info->address;
            $lp_post_data['pick_mobile'] = $ep_info->contact_number;

            $lp_post_data['recipient_name'] = $cart_details->receiver_name;
            $lp_post_data['recipient_mobile'] = $cart_details->receiver_contact_number;
            $lp_post_data['recipient_division'] = $user_info->division;
            $lp_post_data['recipient_district'] = $user_info->district;
            $lp_post_data['recipient_city'] = @$user_info->city ? $user_info->city : '#';
            $lp_post_data['recipient_area'] = @$user_info->thana ? $user_info->thana : '#';
            $lp_post_data['recipient_thana'] = @$user_info->thana ? $user_info->thana : '#';
            $lp_post_data['recipient_union'] = $user_info->union ? $user_info->union : '#';
            $lp_post_data['upazila'] = $user_info->upazila ? $user_info->upazila : '#';
            $lp_post_data['recipient_address'] = $cart_details->delivery_location;

            $lp_post_data['package_code'] = @$lp_package_info->package_code;
            $lp_post_data['shipping_price'] = (int)@$lp_package_info->price;

            $lp_post_data['parcel_detail'] = json_encode($lp_order->order->order_details);
            $lp_post_data['order_status'] = $order_info->status ? $order_info->status : 1;
            $lp_post_data['no_of_items'] = $number_of_item;
            $lp_post_data['product_price'] = $order_info->total_price;
            $lp_post_data['payment_method'] = 1;

            $lp_post_data['ep_id'] = $ep_info->ep_code;

            $postData = '';
            foreach ($lp_post_data as $key => $value) {
                $postData .= $key . '=' . $value . '&';
            }

            rtrim($postData, '&');

            $lp_log_filename = 'log-lp-' . $order_info->order_code . '.log';
            $order_info->lp_log = $lp_log_filename;
            $response = $this->place_order_to_lp_partner5($lp_info->place_order_api_url, $postData, $lp_info, $lp_log_filename);

            $response = json_decode($response);

            if (@$response->response_code == 200) {
                //SMS FOR LP
                $sendsmslp = $this->sendsms($order_info , $user_info,$ep_info,$lp_info, "LP", 1);
                $order_info->lp_order_id = $response->ID;
            }

        } else if ($lp_info->id == 5) {

        } else if ($lp_info->id == 6) {

            $lp_log_filename = 'log-lp-' . $order_info->order_code . '.log';
            $order_info->lp_log = $lp_log_filename;

            $epost_login_response = $this->create_epost_api_token($lp_info, $lp_log_filename);
            $epost_login = json_decode($epost_login_response);

            if (@$epost_login->status_code == 200) {
                // PLACE ORDER TO EPOST
                $e_post_data['api_token'] = 'api_token=' . $epost_login->response->api_token;
                $e_post_data['store_id'] = 'store_id=' . "ek-shop";

                $e_post_data['delivery_name'] = 'delivery_name=' . $cart_details->receiver_name;
                $e_post_data['delivery_email'] = 'delivery_email=' . @$user_info->email;
                $e_post_data['delivery_msisdn'] = 'delivery_msisdn=' . $cart_details->receiver_contact_number;
                $e_post_data['delivery_address'] = 'delivery_address=' . $cart_details->delivery_location;

                $e_post_data['delivery_zone'] = 'delivery_zone=' . "Bangla Motor,Dhaka";
                $e_post_data['charge_id'] = 'charge_id=' . 97;

                $e_post_data['pickup_location'] = 'pickup_location=' . $ep_info->ep_name;
                $e_post_data['delivery_pay_by_cus'] = 'delivery_pay_by_cus=' . 1;
                $e_post_data['merchant_order_id'] = 'merchant_order_id=' . $order_info->order_code;

                $e_post_data['product_title'] = 'product_title=' . implode('; ', $lp_order_detail);
                $e_post_data['url'] = 'url=' . '';
                $e_post_data['unit_price'] = 'unit_price=' . $order_info->total_price;
                $e_post_data['quantity'] = 'quantity=' . 1;

                $e_post_data['width'] = 'width=' . 0;
                $e_post_data['height'] = 'height=' . 0;
                $e_post_data['length'] = 'length=' . 0;
                $e_post_data['weight'] = 'weight=' . 0.5;

                $e_post_data['picking_date'] = 'picking_date=' . date('Y-m-d');

                $postData = implode('&', $e_post_data);

                // PLACE ORDER TO EPOST
                $lp_response = $this->place_order_to_epost($lp_info->place_order_api_url, $postData, $lp_info, $lp_log_filename);

                $lp_response = json_decode($lp_response);
                if (@$lp_response->status_code === 200) {
                    //SMS FOR LP
                    $sendsmslp = $this->sendsms($order_info , $user_info,$ep_info,$lp_info, "LP", 1);
                    $order_info->lp_order_id = $lp_response->response->order_id;
                }
            }
        }

        $order_info->save();

        //CLEAR CART DETAIL
        $cart_details->delete();
        Session::forget('total_product');

        return redirect('invoice/' . $order_info->order_code);

    }

    public function server_log($data, $file_name)
    {

        $log_filename = base_path('custom_log');
        if (!file_exists($log_filename)) {
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/' . $file_name;
        file_put_contents($log_file_data, $data . "\n", FILE_APPEND);

    }
	
	public function arpon_clear_cart($url , $order_id, $wc_customer_id)
    {

        $postData = array();
        $postData[] = 'wc_customer_id' . '=' . $wc_customer_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $postData));
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = "Cache-Control: no-cache";
        $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        return $response;
    }

    public function place_order_to_lp_partner5($url, $postData, $lp_info, $lp_log_filename)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $lp_info->place_order_api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$postData");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = "API_SECRET: $lp_info->api_secret";
        $headers[] = "API_KEY: $lp_info->api_key";
        $headers[] = "USER_ID: $lp_info->api_user_id";
        $headers[] = "Cache-Control: no-cache";
        $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $sent_request = curl_getinfo($ch);

        curl_close($ch);

        $log_data['track'] = 'LP INFO';
        $log_data['headers'] = $headers;
        $log_data['ch'] = $sent_request;
        $log_data['postdata'] = $postData;
        $log_data['response'] = $response;
        $this->server_log(json_encode($log_data), $lp_log_filename);

        return $response;
    }

    public function place_order_to_lp_partner1_courier($url, $postData, $lp_info, $lp_log_filename)
    {
        $curl = curl_init();

        $header = array(
            "accepts: application/json",
            "authorization: Bearer $lp_info->api_secret",
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded;",
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$url",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "$postData",
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        $sent_request = curl_getinfo($curl);
        $err = curl_error($curl);
        curl_close($curl);


        $log_data['track'] = 'LP INFO';
        $log_data['headers'] = $header;
        $log_data['ch'] = $sent_request;
        $log_data['postdata'] = $postData;
        $log_data['response'] = $response;

        $this->server_log(json_encode($log_data), $lp_log_filename);

        return $response;
    }

    public function lp_partner1_create_access_token()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://area51.lp_partner1.com/api/v1/oauth/access_token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"client_id\"\r\n\r\na853162dbc0b3d4a1cd0c63fd8f75073\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"client_secret\"\r\n\r\n5f87da231d9d2dccc8ee2cdc3a28602f\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"username\"\r\n\r\nshjiisan@gmail.com\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"password\"\r\n\r\nasdf\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"grant_type\"\r\n\r\npassword\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"scope\"\r\n\r\ncreate_user_delivery\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER => array(
                "accepts: application/json",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
                "postman-token: ee50209c-394d-334d-da02-38f2fbfe0c57"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return $response;
    }


    public function create_epost_api_token($lp_info, $lp_log_filename)
    {
        $header = array(
            "accepts: application/json",
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded;",
        );
        $postData = "store_user=$lp_info->api_user_id&store_password=$lp_info->api_password&key=$lp_info->api_key";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://app.testpartner.com/lpapi/merchant/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "$postData",
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $sent_request = curl_getinfo($curl);
        curl_close($curl);

        $login_info = json_decode($response);
        if (@$login_info->status_code != 200) {
            $log_data['track'] = 'LP INFO';
            $log_data['headers'] = $header;
            $log_data['ch'] = $sent_request;
            $log_data['postdata'] = $postData;
            $log_data['response'] = $response;
            $this->server_log(json_encode($log_data), $lp_log_filename);
        } else if (@!$login_info->status_code) {
            $log_data['track'] = 'LP INFO';
            $log_data['headers'] = $header;
            $log_data['ch'] = $sent_request;
            $log_data['postdata'] = $postData;
            $log_data['response'] = $response;
            $this->server_log(json_encode($log_data), $lp_log_filename);
        }

        return $response;
    }

    public function place_order_to_epost($url, $postData, $lp_info, $lp_log_filename)
    {

        $header = array(
            "accepts: application/json",
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded;",
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$url",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "$postData",
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $sent_request = curl_getinfo($curl);
        curl_close($curl);

        $log_data['track'] = 'LP INFO';
        $log_data['headers'] = $header;
        $log_data['ch'] = $sent_request;
        $log_data['postdata'] = $postData;
        $log_data['response'] = $response;
        $this->server_log(json_encode($log_data), $lp_log_filename);

        return $response;
    }


    public function invoice($order_code)
    {
        $data = array();
        //DC INFORMATION
        $data['user_info'] = $user_info = Auth::user();

        $data['order_info'] = Order::with(['order_details', 'order_invoice', 'lp_info', 'ep_info'])
            ->where('order_code', $order_code)
            ->where('user_id', $user_info->id)->first();
        if ($data['order_info']) {

            $data['udcCustomers'] = UdcCustomer::where('udc_id', Auth::user()->id)->get();
            return view('frontend.checkout.invoice')->with($data);
        } else {
            return redirect('');
        }
    }

    public function save_customer_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
            'total_amount' => 'required',
            'advance' => '',
            'due' => 'required',
            'note' => '',
            'userExist' => '',
        ]);

        $validator->sometimes('udc_customer_id', 'required', function ($request) {
            return $request->userExist;
        });

        $validator->setAttributeNames(['udc_customer_id' => 'customer']);
        $validator->sometimes('customer_name', 'required', function ($request) {
            return !$request->userExist;
        });


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            if (!$request->userExist) {
                $request['udc_id'] = Auth::user()->id;
                $customer_info = UdcCustomer::create($request->all());
                $request['udc_customer_id'] = $customer_info->id;
            }

            $request['advance'] = ($request->advance != '') ? $request->advance : 0.00;
            UdcCustomerPayment::create($request->all());

            //SAVE CUSTOMER ID ORDER TABLE
            $order_info = Order::where('order_code', $request->order_code)->first();
            $order_info->customer_id = $request['udc_customer_id'];
            $order_info->save();

            return redirect('thanks-b2b');
        }
    }
}
