<?php

namespace App\Http\Controllers\Frontend;

use App\CartDetail;
use App\Libraries\EkomEncryption;
use App\Libraries\PlxUtilities;
use App\Libraries\ProductSearching;
use App\models\EcommercePartner;
use App\models\EpSession;
use App\models\LogisticPartner;
use App\models\Notice;
use App\models\Order;
use App\models\OrderDetail;
use App\models\Product;
use App\models\ProductAttribute;
use App\models\ProductAttributeValue;
use App\models\ProductCategory;
use App\models\SearchHistory;
use App\models\Store;
use App\models\EpStatistic;
use App\models\UserSpecificSearchHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class EkomFrontController extends Controller
{
    public function ekom_front(Request $request)
    {
        $data = array();
        if(!Auth::user()){
            return view('landing-page.index')->with($data);
        }
        $hot_deals = array();
        $util = new PlxUtilities();

        $util->check_cart_session_time();
        $data['ep_list'] = EcommercePartner::where('status', '=', 1)->get();
        $data['recent_search'] = SearchHistory::orderBy('total_hit', 'desc')->limit(100)->get();
        $data['user_info'] = Auth::user();
        $data['notices'] = Notice::where('status', 1)->limit(1)->get();

        return view('frontend.home')->with($data);
    }

    public function go_to_ep($encrypted_ep_id)
    {
        $user_info = Auth::user();
        $redirect_url = urlencode($_GET['redirect_url']);
        $encrypter = new EkomEncryption();
        $ep_id = $encrypter->decrypt($encrypted_ep_id);

        $get_ep_info = EcommercePartner::find($ep_id);
        $encrypter = new EkomEncryption($ep_id);
        $ekom_auth_token = date('ydmHis') . $encrypter->encrypt();

        $ep_session = new EpSession();
        $ep_session->ep_id = $ep_id;
        $ep_session->user_id = Auth::user()->id;
        $ep_session->auth_token = $ekom_auth_token;
        $ep_session->save();

        $ep_statistics = new EpStatistic();
        $ep_statistics->ep_id = $ep_id;
        $ep_statistics->user_id = Auth::user()->id;
        $ep_statistics->save();

        $base_url = urlencode(url('/'));

        $url = "$get_ep_info->auth_check_url?auth_token=$ekom_auth_token&redirect_url=$redirect_url&api_base_url=$base_url&_ecom__api_base_url=$base_url&secret=$get_ep_info->api_key&rok_key=$get_ep_info->api_key";
        /*if(@$user_info->id == 151){ //Our Test UDC user মোঃ শাকিল
            dd($url);
        }*/
        
        
		if($ep_id == 11 || $ep_id == 12){//Dinratri, ep_partner4
            $url = "$get_ep_info->auth_check_url&auth_token=$ekom_auth_token&redirect_url=$redirect_url&api_base_url=$base_url&_ecom__api_base_url=$base_url&secret=$get_ep_info->api_key";
        }
		
		header("Location: $url");
        exit();
    }

    public function checked_popup()
    {
        $user_info = User::find(Auth::user()->id);
        $user_info->popup_checked = 1;
        $user_info->save();
        return redirect()->back();
    }

    public function search_product(Request $request)
    {
        $data = array();
        $user_info = Auth::user();

        $data['products'] = '';
        $data['product_list'] = array();
        $data['brands'] = array();
        $data['attribute_list'] = array();
        $data['product_attributes'] = array();
        $data['category_info'] = array();
        $data['brand_id'] = '';

        $data['min_price'] = @$request->min_price ? $request->min_price : '';
        $data['max_price'] = @$request->max_price ? $request->max_price : '';
        $min_price = @$request->min_price ? $request->min_price : 0;
        $max_price = @$request->max_price ? $request->max_price : 999999999999;

        $data['search_string'] = @$request->string;
        $data['new_arrival'] = '';

        $ep_list = EcommercePartner::where('status', 1)->get();


        if (filter_var($request->string, FILTER_VALIDATE_URL) ? 1 : 2 == 1) {

            $strings = explode('/', @$request->string);

            if (in_array('www.ep_partner2.com', $strings)) {

                if ($strings[(count($strings) - 3)] == "category") {
                    $search_string = str_replace('-', ' ', $strings[(count($strings) - 4)]);
                } else {
                    $search_string = str_replace('-', ' ', $strings[(count($strings) - 1)]);
                    $search_string = str_replace('html', '', $search_string);
                    $search_string = str_replace('.', '', $search_string);
                }

            } else if (in_array('www.ep_partner5.com', $strings)) {

                $search_string = str_replace('-', ' ', $strings[(count($strings) - 1)]);

                if (strstr($search_string, ".html")) {
                    $search_string = str_replace('html', '', $search_string);
                    $search_string = str_replace('.', '', $search_string);
                }

            } else
                $search_string = str_replace('-', ' ', $strings[(count($strings) - 1)]);

        } else {
            $search_string = $request->string;
        }

        $data['ep_ids'] = '';
        if (@empty($request->ep_ids) === false) {
            if (in_array('all', @$request->ep_ids) != true) {
                $ep_ids = @$request->ep_ids;
                $data['ep_ids'] = implode(',', $ep_ids);
            }
        }

        if ($data['ep_ids'] == '') {
            $eps = EcommercePartner::where('status', 1)->selectRaw('GROUP_CONCAT(id) as ep_ids')->first();
            if (count($eps) > 0) {
                $data['ep_ids'] = $eps->ep_ids;
            }
        }

        if (@$search_string && !$request->ajax()) {
            if (substr($search_string, -1) == '/') {
                $search_string = substr($search_string, 0, -1);
            }

            $user_search_history = UserSpecificSearchHistory::where('search_text', 'like', '%' . $search_string . '%')
                ->where('user_id', $user_info->id)
                ->first();

            if ($user_search_history) {
                $user_search_history->total_hit = @$user_search_history->total_hit + 1;
                $user_search_history->save();
            } else {
                $user_search_history = new UserSpecificSearchHistory();
                $user_search_history->search_text = @$search_string;
                $user_search_history->user_id = $user_info->id;
                $user_search_history->total_hit = 1;
                $user_search_history->save();
            }

            $search_history = SearchHistory::where('search_text', 'like', '%' . $search_string . '%')->first();

            if ($search_history) {
                $search_history->total_hit = @$search_history->total_hit + 1;
                $search_history->save();
            } else {
                $search_history = new SearchHistory();
                $search_history->search_text = @$search_string;
                $search_history->total_hit = 1;
                $search_history->save();
            }
        }

        $product_list = array();

        $data['offset'] = $offset = @$request->offset ? @$request->offset : 0;
        $data['limit'] = $limit = @$request->limit ? $request->limit : 3;

        if (count($ep_list) > 0) {
            if ($request->ajax()) {

                if ($request->ep_id_list === '') {
                    $request->ep_id_list = $data['ep_ids'];
                }

                $search_ep_list = EcommercePartner::where('status', 1)
                    ->where(function ($query) use ($search_string) {
                        if ($search_string == 'Medicine') {
                            $query->where('id', 3); //ONLY ep_partner5 SEARCH
                        }
                    })
                    ->where(function ($query) use ($request) {
                        $ep_id_list = explode(',', $request->ep_id_list);
                        foreach ($ep_id_list as $value) {
                            $query->orWhere('id', $value);
                        }
                    })->get();


                $string = urlencode($search_string);
                foreach ($search_ep_list as $key => $each_ep) {
//                    if ($each_ep->id == 7) {
//                        $header[] = array("rok_key: $each_ep->api_key", "cache-control: no-cache", "Content-Type: application/json", "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36");
//                        $url[] = $each_ep->product_search_url . "?search_query=$string&limit=$limit&offset=$offset";
//                    } else {
                        $header[] = array(
                            "rok_key: $each_ep->api_key",
                            "api_key: $each_ep->api_key", "authorization: $each_ep->authorization",
                            "cache-control: no-cache", "Content-Type: application/json", "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36"
                        );
                        if($each_ep->id == 9){
                            $url[] = $each_ep->product_search_url . "?search_text=$string&search_query=$string&orderway=desc&limit=$limit&offset=$offset&secret=$each_ep->api_key&consumer_key=$each_ep->authorization&consumer_secret=$each_ep->api_key&search=$string&per_page=$limit";
                        }elseif($each_ep->id == 11 || $each_ep->id == 12){//Dinratri, ep_partner4
							$url[] = $each_ep->product_search_url . "&search_text=$string&description=true&search_query=$string&orderway=desc&limit=$limit&offset=$offset&secret=$each_ep->api_key";
						}else{
                            $url[] = $each_ep->product_search_url . "?search_text=$string&search_query=$string&orderway=desc&limit=$limit&offset=$offset&secret=$each_ep->api_key";
                        }
//                    }
                }

                $response = $this->runRequests($url, 10, $header);

                foreach ($search_ep_list as $key => $each_ep) {
                    $ep_products = json_decode(@$response[$key]['result']);

                    if ($each_ep->id == 9) { // Arpon Digital (Woocommerce) Result
                        $products = @$ep_products;
                        if (!empty($products)) {
                            foreach ($products as $value) {
                                $price = str_replace(',', '', @$value->price);
                                if (($price >= $min_price && $price <= $max_price)) {
                                    $value->ep_info = @$each_ep;
                                    $value->product_url = @$value->permalink;
                                    $value->product_name = @$value->name;
                                    $value->product_price = @$value->price;
                                    $value->product_image = @$value->images[0]->src;
                                    array_push($product_list, $value);
                                }
                            }
                        }
                    } else {
                        if (@$ep_products->meta->status == 200) {
                            $products = @$ep_products->response->products;
                            if (!empty($products)) {
                                foreach ($products as $value) {
                                    $price = str_replace(',', '', $value->product_price);
                                    if (($price >= $min_price && $price <= $max_price)) {
                                        $value->ep_info = $each_ep;
                                        array_push($product_list, $value);
                                    }
                                }
                            }
                        }
                    }
                }

                shuffle($product_list);
                $data['product_list'] = $product_list;
            }
        }

        $data['ep_list'] = $ep_list;

        $data['total_row'] = $request->total_row ? $request->total_row : 1;

        if ($request->ajax()) {
            return Response::json(View::make('frontend.product.product_list_render', $data)->render());
        } else {
            return view('frontend.product.product_listing')->with($data);
        }
    }

    public function runRequests($url_array, $thread_width = 5, $header)
    {
        $threads = 0;

        $master = curl_multi_init();

        $results = array();
        $count = 0;

        foreach ($url_array as $key => $url) {
            $curl_opts = array(CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 5,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => $header[$key],
            );
            $ch = curl_init();
            $curl_opts[CURLOPT_URL] = $url;

            curl_setopt_array($ch, $curl_opts);
            curl_multi_add_handle($master, $ch); //push URL for single rec send into curl stack
            $results[$count] = array("url" => $url, "handle" => $ch);
            $threads++;
            $count++;

            if ($threads >= $thread_width) { //start running when stack is full to width
                while ($threads >= $thread_width) {
                    usleep(10);
                    while (($execrun = curl_multi_exec($master, $running)) === -1) {

                    }
                    curl_multi_select($master);

                    // a request was just completed - find out which one and remove it from stack
                    while ($done = curl_multi_info_read($master)) {
                        foreach ($results as &$res) {
                            if ($res['handle'] == $done['handle']) {
                                $res['result'] = curl_multi_getcontent($done['handle']);
                            }
                        }
                        curl_multi_remove_handle($master, $done['handle']);
                        curl_close($done['handle']);
                        $threads--;
                    }
                }
            }
        }

        do { //finish sending remaining queue items when all have been added to curl
            usleep(10);
            while (($execrun = curl_multi_exec($master, $running)) === -1) {

            }

            curl_multi_select($master);

            while ($done = curl_multi_info_read($master)) {
                foreach ($results as &$res) {
                    if ($res['handle'] == $done['handle']) {
                        $res['result'] = curl_multi_getcontent($done['handle']);
                    }
                }

                curl_multi_remove_handle($master, $done['handle']);
                curl_close($done['handle']);
                $threads--;
            }

        } while ($running > 0);

        curl_multi_close($master);
        return $results;
    }

    public function switch_language($lang)
    {
        if (!Session::has('lang')) {
            Session::put('lang', $lang);
        } else {
            Session::put('lang', $lang);
        }
        App::setLocale($lang);
        return back();
    }


    public function partners()
    {
        $data = array();
        $data['e_commerce_partners'] = EcommercePartner::where('status', 1)->get();
        $data['logistic_partners'] = LogisticPartner::where('status', 1)->get();
        return view('frontend.partners')->with($data);
    }

    //AUTO SEARCHING
    public function datalist(Request $request)
    {
        $data = array();
        $isExist = array();
        $data['search_sugstns'] = UserSpecificSearchHistory::where('user_id', Auth::id())->orderBy('total_hit', 'desc')->get();
        if ($data['search_sugstns']) {
            foreach ($data['search_sugstns'] as $sugstn) {
                $isExist[] = $sugstn->search_text;
            }
        }
        $data['sugstns'] = SearchHistory::whereNotIn('search_text', $isExist)->orderBy('total_hit', 'desc')->take(5)->get();
        return Response::json(View::make('frontend.autosearch.render')->with($data)->render());
    }

    public function deleteRow(Request $request)
    {
        UserSpecificSearchHistory::destroy($request->row_id);
        return 1;
    }

    //NEW ORDER TOASTER
    public function new_order_toast(Request $request)
    {
        $data = array();
        $new_order = Order::where('user_id', '!=', Auth::id())->where('status', 1)->with(['order_details', 'ep_info'])->inRandomOrder()->first();
        $encrypter = new EkomEncryption($new_order->ep_info->id);
        $uid = $encrypter->encrypt();
        $product_url = $new_order->order_details[0]->product_url;
        $data['product_url'] = url("go-to-ep/$uid/?redirect_url=$product_url");
        $data['product_name'] = $new_order->order_details[0]->product_name;
        $data['product_image'] = $new_order->order_details[0]->product_image;
        return json_encode($data);
    }
    
    public function completed()
    {
        if(session('order-complete') || session('partner-session-expire')){
            $data = array();
            return view('frontend.user.order-completed')->with($data);
        }
        return redirect('');
    }
}