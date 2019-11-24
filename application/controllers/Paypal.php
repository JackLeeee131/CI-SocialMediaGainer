<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('paypal_lib');
    }


    function custom_order_success()
    {

    }






    function success()
    {

    }





    function success_funds()
    {
        is_user_in();
        $paypalInfo = $this->input->post();
        $account_id = $paypalInfo['custom'];

        $check_balance = $this->common_model->get_table_data('tbl_accounts', '*' ,array('account_id' => $account_id));
        $account_balance =$check_balance[0]['current_balance'] + $paypalInfo['mc_gross'];
        $check_referral = $this->common_model->get_table_data('tbl_accounts', '*' ,array('user_id' => $this->session->userdata('ref_by')));
        $available_commission = $check_referral[0]['available_commission'];
        $referral_percent = $check_referral[0]['referral'];

        $update_data_account = array(
            'txn_id' => $paypalInfo['txn_id'],
            'payment_status' => $paypalInfo['payment_status'],
            'payment_date' => $paypalInfo['payment_date'],
            'current_balance' => $account_balance
        );



        if($this->session->userdata('ref_by') >= 1) {
            $commission_earned = ($paypalInfo['mc_gross'] * $referral_percent)  / 100;
            $this->common_model->update_table('tbl_accounts', array('available_commission' => $available_commission + $commission_earned), array('user_id' => $this->session->userdata('ref_by')));
        }


        $this->common_model->update_table('tbl_accounts', $update_data_account, array('account_id' => $account_id));

        $insert_data_orders = array(
            'txn_id' => $paypalInfo['txn_id'],
            'txn_type' => 'add funds',
            'payment_amount' => $paypalInfo['mc_gross'],
            'user_id' => $this->session->userdata('user_id'),
            'payment_status' => $paypalInfo['payment_status'],
            'payment_date' => $paypalInfo['payment_date'],
        );


        $this->common_model->insert_table('tbl_orders',$insert_data_orders);
        $this->common_model->delete_table('tbl_orders', array('payment_status' => 'not confirmed'));
        redirect('packages');
    }



    function cancel()
    {
        is_user_in();
        $this->common_model->delete_table('tbl_orders', array('payment_status' => 'not confirmed'));
        redirect('dashboard');
    }

    function ipn()
    {
        is_user_in();
//paypal return transaction details array
        $paypalInfo = $this->input->post();

        $paypalURL = $this->paypal_lib->paypal_url;
        $result = $this->paypal_lib->curlPost($paypalURL, $paypalInfo);

//check whether the payment is verified
        if (preg_match("/VERIFIED/i", $result)) {

            $txt = json_encode($paypalInfo);
            $myfile = file_put_contents('paypal_log.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
            fwrite($myfile, $txt);
            fclose($myfile);
        }


    }
}