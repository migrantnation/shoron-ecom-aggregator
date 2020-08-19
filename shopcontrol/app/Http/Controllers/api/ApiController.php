<?php

namespace App\Http\Controllers\api;

use App\AuthToken;
use App\partnerUser;
use App\Libraries\PlxUtilities;
use App\LoginInformation;
use Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';

        $utility = new PlxUtilities();
        $validator = Validator::make($request->all(), [
            'auth_token' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('partner')->withErrors($validator)->withInput();
        } else {
            $auth_token = $request->auth_token;
            $check_token = AuthToken::where('auth_token', $auth_token)
                ->where('access_type', 1)
                ->first();
            if ($check_token) {
                //check user is exist
                //if exist update
                //else create new user
                $login_info = new LoginInformation();
                $login_info->session_token = date("Ymdhis");
                $login_info->save();

                $response['session_token'] = $login_info->session_token;
                $response['message'] = 'user logged in successfully.';
                $status = 200;
            }else{
                $response['message'] = ' something went wrong ';
            }
        }
        $utility->json($status, $response);
    }
}