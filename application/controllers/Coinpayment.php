<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coinpayment extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function order_callback($key)
    {
        if ($key != '') {
            if ($_POST) {
                $order_id = $this->input->post('order_id');
                $token = $key;
                $order = $this->common_model->get_table_data('tbl_orders', '*', array('order_id' => $order_id));
                if ($order) {

                    $status = $this->input->post('status');
                    if($status == 'paid') {
                        $status = 'Completed';
                    } else {
                        $status = $this->input->post('status');
                    }
                    $update_data = array(
                        'payment_status' => $status,
                        'payment_date' => date('Y-m-d H:i:s'),
                    );
                    $this->common_model->update_table('tbl_orders', $update_data, array('order_id' => $order_id));

                }
            }
        }
    }

    public function funds_callback($key)
    {
        if ($key != '') {
            if ($_POST) {
                $account_id = $this->input->post('order_id');
                $price = $this->input->post('price');
                $check_balance = $this->common_model->get_table_data('tbl_accounts', '*' ,array('account_id' => $account_id));

                $check_referral = $this->common_model->get_table_data('tbl_accounts', '*' ,array('user_id' => $this->session->userdata('ref_by')));
                $available_commission = $check_referral[0]['available_commission'];
                $referral_percent = $check_referral[0]['referral'];
                $status = $this->input->post('status');

                if ($check_balance) {
                    if ($status == 'paid') {

                        $this->db->insert('tbl_cron', array('test_string' => '222'));

                        $account_balance = $check_balance[0]['current_balance'] + $price;
                        $referral_percent = $check_balance[0]['referral'];
                        if ($status == 'paid') {
                            $status = 'Completed';
                        } else {
                            $status = $this->input->post('status');
                        }
                        $update_data_account = array(
                            'payment_status' => $status,
                            'payment_date' => date('Y-m-d H:i:s'),
                            'current_balance' => $account_balance
                        );

                        if ($this->session->userdata('ref_by') >= 1) {
                            $commission_earned = ($price * $referral_percent) / 100;
                            $this->common_model->update_table('tbl_accounts', array('available_commission' => $available_commission + $commission_earned), array('user_id' => $this->session->userdata('ref_by')));
                        }

                        $this->common_model->update_table('tbl_accounts', $update_data_account, array('account_id' => $account_id));
                    }
                }
            }
        }
    }

    public function custom_order_callback($key)
    {
        if ($key != '') {
            if ($_POST) {

                $custom_order_code = $this->input->post('order_id');
                $token = $key;
                $order = $this->common_model->get_table_data('tbl_custom_orders', '*', array('custom_order_code' => $custom_order_code));
                if ($order) {
                    $status = $this->input->post('status');
                    if($status == 'paid') {
                        $status = 'Completed';
                    } else {
                        $status = $this->input->post('status');
                    }
                    $update_data = array(
                        'payment_status' => $status,
                        'payment_date' => date('Y-m-d H:i:s'),
                    );
                    $this->common_model->update_table('tbl_custom_orders', $update_data, array('custom_order_code' => $custom_order_code));
                }
           }
        }
    }


    function order_success()
    {
        $this->session->set_flashdata('success_message', "Package Purchased Successfully");
        redirect('dashboard');
    }


    function funds_success()
    {
        $this->session->set_flashdata('success_message', "Funds Purchased Successfully");
        redirect('packages');
    }


    function cancel()
    {
        $this->common_model->delete_table('tbl_orders', array('payment_status' => 'not confirmed'));
        redirect('dashboard');
    }



    function ipn()
    {
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