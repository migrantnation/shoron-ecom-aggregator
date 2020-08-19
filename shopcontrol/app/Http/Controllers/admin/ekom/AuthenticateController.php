<?php

namespace App\Http\Controllers\admin\ekom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthenticateController extends Controller
{

    public function authenticate(Request $request)
    {
        dd($request);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...
            return redirect()->intended('admin');
        }
    }

    public function login()
    {
        $data = array();
        return view('auth.login')->with($data);
    }
}
