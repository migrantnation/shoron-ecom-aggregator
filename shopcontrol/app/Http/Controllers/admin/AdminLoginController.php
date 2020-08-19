<?php

namespace App\Http\Controllers\admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo  = '/admin';
    public function showLoginForm()
    {
        if (Auth::guard('web_admin')->check()){
            return back()->with('message','Unauthenticated Admin');
        }
        $data = array();
        return view('admin.ekom.login')->with($data);
    }
    protected function guard()
    {
        return Auth::guard('web_admin');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/admin');
    }
}
