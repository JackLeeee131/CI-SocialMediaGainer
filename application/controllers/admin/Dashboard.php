<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


function __construct() {
    parent::__construct();
}


public function index() {

    is_admin_in();
    $this->load->view('admin/common/header');
    $this->load->view('admin/common/sidebar');

    $total_reg_users = $this->common_model->get_table_data('tbl_users', 'count(*) as total_users', array('user_type !=' => 'admin'));
    $total_accounts = $this->common_model->get_table_data('tbl_accounts', 'count(*) as total_accounts');
    $accounts_data = $this->common_model->get_table_data('tbl_accounts', 'SUM(current_balance) as total_users_balance, SUM(available_commission) as available_commission, SUM(total_checkout) as total_checkout');
    $money_spent = $this->common_model->total_money_spent();

    $data['dashboard_data'] = array(
        'total_reg_users' => $total_reg_users[0]['total_users'],
        'total_accounts' => $total_accounts[0]['total_accounts'],
        'total_users_balance' => $accounts_data[0]['total_users_balance'],
        'available_commission' => $accounts_data[0]['available_commission'],
        'total_checkout' => $accounts_data[0]['total_checkout'],
        'total_money_spent' => $money_spent[0]['total_amount'],
    );
    $this->load->view('admin/dashboard/dashboard', $data);
    $this->load->view('admin/common/footer');
}

}