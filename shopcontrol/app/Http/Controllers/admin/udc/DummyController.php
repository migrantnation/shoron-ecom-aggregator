<?php

namespace App\Http\Controllers\admin\udc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DummyController extends Controller
{
    public function index(){
        $data = array();
        $data['menu'] = 'dashboard';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        return view('admin.udc.dashboard')->with($data);
    }
    public function myProfile(){
        $data = array();
        $data['menu'] = 'profile';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        return view('admin.udc.profile.profile')->with($data);
    }
    public function report(){
        $data = array();
        $data['menu'] = 'report';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        return view('admin.udc.report.report')->with($data);
    }
    public function purchases(){
        $data = array();
        $data['menu'] = 'purchases';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        return view('admin.udc.purchase-list')->with($data);
    }
}
