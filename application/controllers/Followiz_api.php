<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Followiz_api extends CI_Model {

    public $api_url = ''; // API URL

    public $api_key = ''; // Your API key

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->api_key = $this->get_api_key();
        $this->api_url = $this->get_api_url();

    }

    public function get_api_key() {
        $qry = $this->common_model->get_table_data('tbl_api_setup', 'api_key','api_id=1', $row = 1);
        if(count($qry) >= 1) {
            $api_key = $qry[0]['api_key'];
            return $api_key;
        } else {
            return 0;
        }
    }

    public function get_api_url() {
        $qry = $this->common_model->get_table_data('tbl_api_setup', 'api_url','api_id=1', $row = 1);
        if(count($qry) >= 1) {
            $api_url = $qry[0]['api_url'];
            return $api_url;
        } else {
            return 0;
        }
    }

    public function order($data) { // add order

       // echo '<pre>'; print_r($data); echo '</pre>';

        $post = array_merge(array('key' => $this->api_key, 'action' => 'add'), $data);
        return json_decode($this->connect($post));
    }

    public function status($order_id) { // get order status
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'status',
            'order' => $order_id
        )));
    }

    public function services() { // get services
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'services',
        )));
    }

    public function balance() { // get balance
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'balance',
        )));
    }


    private function connect($post) {
        $_post = Array();
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name.'='.urlencode($value);
            }
        }

        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        return $result;
    }
}

// Examples



