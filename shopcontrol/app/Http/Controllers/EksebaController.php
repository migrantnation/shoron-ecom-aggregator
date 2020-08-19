<?php

namespace App\Http\Controllers;

use App\partnerAuthToken;
use App\partnerUser;
use App\Libraries\PlxUtilities;
use App\LoginInformation;
use App\models\Udc;
use App\models\User;
use App\models\UserActivitiesLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class partnerController extends Controller
{


    public function front($id)
    {
        $data = array();
        $data['get_info'] = partnerUser::where('id', $id)->first();
        return view('frontend.partner.index')->with($data);
    }

    public function go_to_ekom(Request $request, $token)
    {
        $response = array();
        $response['message'] = '';
        $new_user = 0;

        if ($token) {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => "http://partner.com/api/login/$token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            return redirect('');
        }

        $result = json_decode($result);


        if (@$result->status == true && @$result->data) {
            //check user is exist
            $dc_info = @$result->data;

            $user_info = User::where('center_id', $dc_info->center_id)
                ->where('entrepreneur_id', $dc_info->entrepreneur_id)
                ->first();

            if (!$user_info) { //if exist update else create new user
                $user_info = new User();
                $new_user = 1;
            }
            $user_info->center_name = $dc_info->center_name;
            $user_info->center_id = $dc_info->center_id;
            $user_info->name_bn = $dc_info->name_bn;
            $user_info->name_en = $dc_info->name_en;
            $user_info->entrepreneur_id = $dc_info->entrepreneur_id;
            $user_info->national_id_no = $dc_info->national_id_no;

            $user_info->center_jurisdiction = $dc_info->center_jurisdiction;
            $user_info->division = $dc_info->division;
            $user_info->district = $dc_info->zilla;
            $user_info->union = $dc_info->unionname;
            $user_info->upazila = $dc_info->upazila;

            //SAVE NEW ADDRESS


            $user_info->present_address = @$dc_info->present_address;
            $user_info->phone = $dc_info->phone;
            $user_info->contact_number = $dc_info->mobile;
            $user_info->image = $dc_info->photo;
            $user_info->date_of_birth = $dc_info->dob;
            $user_info->email = $dc_info->email;

            $user_info->save();
            if ($dc_info->mobile) {

                if ($new_user == 1) { //CREATE ACTIVITY
                    $user_activity = new UserActivitiesLog();
                    $user_activity->type = "10";
                    $user_activity->message = "New user registered";
                    $user_activity->ids = $user_info->id;
                    $user_activity->save();
                }

                $login_info = new LoginInformation();
                $login_info->session_token = date("Ymdhis");
                $login_info->partner_auth_token = $request->auth_token;
                $login_info->partner_session_token = @$dc_info->token;
                $login_info->user_id = @$user_info->id;
                $login_info->save();

                Auth::loginUsingId($user_info->id);

                if (Auth::check()) {
                    return redirect('');
                } else {
                    return back()->with('message', 'something went wrong');
                }
            } else {
                session_start();
                $_SESSION['NO_CONTACT_NUMBER_CREATED'] = time();
                return redirect('no-contact-number');
            }

        } else {
            return back()->with('message', 'something went wrong');
        }
    }

    public function no_contact_number(Request $request)
    {
        session_start();
        if (!isset($_SESSION['NO_CONTACT_NUMBER_CREATED'])) {
            return redirect('');
        } else if (time() - $_SESSION['NO_CONTACT_NUMBER_CREATED'] > 40) {
            unset($_SESSION['NO_CONTACT_NUMBER_CREATED']);
            return redirect('');
        }
        return view('no-contact-number');
    }


    public function go_to_ekom2(Request $request)
    {
        $user_info = User::where('dc_id', 4476111)->first();
        if ($user_info) {
            Auth::loginUsingId($user_info->id);
            return redirect('');
        } else {
            return redirect('http://partner.com/login');
        }
    }


    public function get_info(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';

        $utility = new PlxUtilities();
        $validator = Validator::make($request->all(), [
            'auth_token' => 'required'
        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
        } else {
            $auth_token = $request->auth_token;
            $check_token = partnerAuthToken::where('auth_token', $auth_token)
                ->first();
            if ($check_token) {
                $response['center_info'] = partnerUser::select('center_name', 'center_id', 'name_bn', 'name_en', 'entrepreneur_id',
                    'sonali_card', 'national_id_no', 'center_jurisdiction', 'division', 'zilla', 'unionname',
                    'upazila', 'phone', 'mobile', 'photo', 'dob', 'logout_url', 'refresh_url', 'save_url', 'email')
                    ->find($check_token->user_id);
                $status = 200;
            } else {
                $response['center_info'] = array();
                $response['message'] = 'Authentication Failed';
            }
        }
        $utility->json($status, $response);
    }

    public function logout(Request $request)
    {
        if (Auth::user()->center_id == 99999 && Auth::user()->entrepreneur_id == 999999999999) {
            $url = url('') . "/login";
        } else if(Auth::user()->direct_user === 1){
            $url = url('login');
        }else {
            $url = "http://partner.com/login";
        }
        Auth::logout();
        return redirect("$url");
    }

    public function partner_login(Request $request)
    {
        $utility = new PlxUtilities();
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $email = Input::get('email');
            $password = Input::get('password');
            if (Auth::attempt(array('email' => $email, 'password' => $password))) {
                return redirect('');
            } else {
                $data = array();
                $data['message'] = "Sorry your credential does not match. Please try again with valid credential.";
                return redirect("login")->withErrors($data);
            }

        }
    }
}