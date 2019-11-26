<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_Funds extends CI_Controller {


function __construct() {
    parent::__construct();
    $this->load->library('paypal_lib');
}


public function index() {
    is_user_in();
    $this->load->view('common/header');
    $this->load->view('common/sidebar');

    $data['payment_list'] = $this->common_model->get_table_data('tbl_payment_setup','*');

    $this->load->view('accounts/add_funds', $data);
    $this->load->view('common/footer');
}

public function add_funds() {
    is_user_in();

    $payment_id = $this->input->post('payment_id');
    $user_id = $this->session->userdata('user_id');
    $check_balance = $this->common_model->get_table_data('tbl_accounts', '*' ,array('user_id' => $user_id));
    $account_id =$check_balance[0]['account_id'];

    $data['payment_list'] = $this->common_model->get_table_data('tbl_payment_setup','*',array('payment_id'=> $payment_id));
    $minimum_amount = $data['payment_list'][0]['minimum_amount'];
    $payment_method = $data['payment_list'][0]['payment_method'];
    $post_amount = $this->input->post('amount');

    if($post_amount < $minimum_amount) {
        $this->session->set_flashdata('error_message', 'Unable to process, Minimum Amount is not matched. Please adjust accordingly');
        redirect('add_funds');
    } else {
        if($payment_method == 'Paypal') {

            //Set variables for paypal form
            $returnURL = base_url() . 'paypal/success_funds'; //payment success url
            $cancelURL = base_url() . 'paypal/cancel'; //payment cancel url
            $notifyURL = base_url() . 'paypal/ipn'; //ipn url

            $this->paypal_lib->add_field('cmd', '_xclick');
            $this->paypal_lib->add_field('item_number', $user_id);
            $this->paypal_lib->add_field('item_name', $this->session->userdata('username'));
            $this->paypal_lib->add_field('custom', $account_id);
            $this->paypal_lib->add_field('amount', $post_amount);

            $this->paypal_lib->add_field('return', $returnURL);
            $this->paypal_lib->add_field('cancel_return', $cancelURL);
            $this->paypal_lib->add_field('notify_url', $notifyURL);
            $this->paypal_lib->paypal_auto_form();

        } else {
            include APPPATH.'third_party/coingate-php-master/init.php';
            \CoinGate\CoinGate::config(array(
                'environment' => 'sandbox', // sandbox OR live
                'app_id'      => '1484',
                'api_key'     => 'k6aB0Vnz9luChsZxr32vEX',
                'api_secret'  => 'uXcTWv86zCOabrKneQDq5IkdVF4mGxlg'
            ));
            $post_params = array(
                'order_id'          => $account_id,
                'price'             =>  $post_amount,
                'currency'          => 'USD',
                'receive_currency'  => 'USD',
                'callback_url'      =>  base_url().'coinpayment/funds_callback/'.$account_id,
                'cancel_url'        =>  base_url().'coinpayment/cancel',
                'success_url'       =>  base_url().'coinpayment/funds_success',
                'title'             => 'Purchase Funds',
                'description'       => 'Purchase Funds'
            );
            //
            $order = \CoinGate\Merchant\Order::create($post_params);
            if ($order) {

                $update_data = array(
                    'payment_method'      =>  'coinpayment',
                    'payment_status'      =>  $order->status,
                    'btc_amount'        =>  $order->btc_amount,
                    'btc_address'       =>  $order->bitcoin_address,
                );

               // $this->db->update('tbl_orders',$update_data,array('order_id'=>$order_id));
                redirect($order->payment_url, 'refresh');
                exit();

            } else {
                $this->session->set_flashdata('error_message',"Payment Failed");
                redirect('dashboard');
                exit();
            }

        }

    }
}
}