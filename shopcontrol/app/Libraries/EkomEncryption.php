<?php

namespace App\Libraries;

class EkomEncryption
{
    private $encryption_data;
    private $split_size = 32;
    protected $suffix_array = array(
        '0' => 'Name of national fruit: Jackfruit',
        '1' => 'Name of national tree: Mango Tree',
        '2' => 'Name of national fish: Hilsha',
        '3' => 'Name of national flower: Shapla',
        '4' => 'Name of national bird: Dove',
        '5' => 'Name of national flower: Shapla',
        '6' => 'Name of national flower: Shapla',
    );

    /**
     * EkomEncryption constructor.
     * @param $encryption_data
     */

    public function __construct($encryption_data = NULL)
    {
        $this->setEncryptionData($encryption_data);
    }

    /**
     * @param mixed $encryption_data
     */
    public function setEncryptionData($encryption_data)
    {
        $this->encryption_data = $encryption_data;
    }

    /**
     * @return mixed
     */
    public function getEncryptionData()
    {
        return $this->encryption_data;
    }

    function encrypt()
    {
        return base64_encode(md5($this->suffix_array[rand(0, sizeof($this->suffix_array) - 1)]) . base64_encode($this->getEncryptionData()). md5($this->suffix_array[rand(0, sizeof($this->suffix_array) - 1)]));
    }

    function decrypt($data)
    {
        $decrypted_data = base64_decode($data);
        $decrypted_data = substr($decrypted_data, $this->split_size, -$this->split_size);//str_split($decrypted_data, );
        $decrypted_data = base64_decode($decrypted_data);
        return $decrypted_data;
    }
}