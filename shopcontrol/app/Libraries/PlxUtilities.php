<?php
/**
 * Created by PhpStorm.
 * User: SHAWON
 * Date: 06-07-17
 * Time: 16.26
 */

namespace App\Libraries;


use App\CartDetail;
use App\models\_ecom_Setting;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\Auth;

class PlxUtilities
{
    public function json($status = NULL, $response = NULL)
    {
        echo json_encode(array('meta' => array('status' => $status), 'response' => $response));
    }

    function dumpVar($data)
    {
        echo "<pre>";
        print_r($data);
        exit();
    }

    public function create_clean_url($str)
    {
        $string6 = '';
        //Lower case everything
        $string = strtolower($str);
        //Make alphanumeric (removes all other characters)
        $string1 = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string2 = preg_replace("/[\s-]+/", " ", $string1);
        //Convert whitespaces and underscore to dash
        $string3 = preg_replace("/[\s_]/", "-", $string2);
        $string4 = preg_replace("/[-]+/", "-", $string3);

        if (substr($string4, 0, 1) == "-") {
            $string5 = substr_replace($string4, '', 0, 1);
        } else {
            $string5 = $string4;
        }

        if (substr($string5, -1) == '-') {
            $string6 = substr_replace($string5, '', (strlen($string5) - 1), (strlen($string5)));
        } else {
            $string6 = $string5;
        }

        return $string6;
    }


    //TREE LIBRARY
    function Tree(array $elements, $parentId)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_category_id'] == $parentId) {
                $children = $this->Tree($elements, $element['id']);
                if (@$children) {
                    $element['children'] = $children;
                    $total = 0;
                    foreach ($element['children'] as $value) {
                        $total += $value['total_child'];
                    }
                    $element['total_child'] = count(@$element['children']) + $total;
                } else {
                    $element['children'] = '';
                    $element['total_child'] = 0;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    function self_tree(array $elements, $parentId)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_category_id'] == $parentId) {
                $children = $this->self_tree($elements, $element['id']);
                if (@$children) {
                    $element['children'] = $children;
                    $total = 0;
                    foreach ($element['children'] as $value) {
                        $total += $value['total_child'];
                    }
                    $element['total_child'] = count(@$element['children']) + $total;
                } else {
                    $element['children'] = '';
                    $element['total_child'] = 0;
                }
                $branch[$element['id']] = $element;
            }
        }
        return $branch;
    }

    public function combinations($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        $tmp = $this->combinations($arrays, $i + 1);

        $result = array();
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ? array_merge(array($v), $t) : array($v, $t);
            }
        }

        return $result;
    }

    function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_category_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    //DATETIME LIBRARY

    public function time_different($from_date_time)
    {
        $date1 = new Carbon();
        $diff = $from_date_time->diffForHumans($date1);
        return $diff;
    }

    public function en2bnNumber($number)
    {
        $search_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $replace_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }

    public function bn2enNumber($number)
    {
        $search_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $en_number = str_replace($search_array, $replace_array, $number);
        return $en_number;
    }

    public function check_application_mode()
    {
        $check_mode = _ecom_Setting::first()->application_mode;
        return $check_mode;
    }

    public function check_cart_session_time()
    {
        $cart_info = CartDetail::where('user_id', Auth::user()->id)->first();
        if (@$cart_info) {
            $total_product = json_decode($cart_info->cart_detail);
            if ($cart_info->cart_session_time && strtotime($cart_info->cart_session_time) + 1800 <= time()) { // 30 mins plus
                session()->forget('total_product');
                $cart_info->delete();
            } else {
                session(['total_product' => count(@$total_product->cart)]);
            }
        } else {
            session()->forget('total_product');
        }
    }

    public static function generate_barcode($order_id){
        echo '<br>';
        echo \Milon\Barcode\Facades\DNS1DFacade::getBarcodeSVG("$order_id", "C128A", 1.5, 30);
        echo "<p style='font-color:black; padding-left:35px; padding-right:30px; font-stretch: expanded;letter-spacing: 8px; font-weight: bold; '>$order_id</p>";
    }
}