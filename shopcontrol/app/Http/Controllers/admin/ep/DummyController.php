<?php

namespace App\Http\Controllers\admin\ep;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DummyController extends Controller
{
    public function index(){
        $data = array();
        $data['menu']       = 'dashboard';
        $data['side_bar']   = 'ep_side_bar';
        $data['header']     = 'ep_header';
        $data['footer']     = 'ep_footer';
        return view('admin.ep.dashboard')->with($data);
    }
    public function myProfile(){
        $data = array();
        $data['menu']       = 'profile';
        $data['side_bar']   = 'ep_side_bar';
        $data['header']     = 'ep_header';
        $data['footer']     = 'ep_footer';
        return view('admin.ep.profile.profile')->with($data);
    }
    public function report(){
        $data = array();
        $data['menu']       = 'report';
        $data['side_bar']   = 'ep_side_bar';
        $data['header']     = 'ep_header';
        $data['footer']     = 'ep_footer';
        return view('admin.ep.report.report')->with($data);
    }
}
