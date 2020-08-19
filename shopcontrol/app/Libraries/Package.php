<?php
/**
 * Created by PhpStorm.
 * User: SHAWON
 * Date: 06-07-17
 * Time: 16.26
 */

namespace App\Libraries;


class Package
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

    private $free_shipping_ep = array(1, 3, 4, 6, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);

    public function freeShippingEp()
    {
        return $this->free_shipping_ep;
    }

}