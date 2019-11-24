<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */

class Track_oneTime_orders extends CI_Controller {

    public function index() {

        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $data['past_orders_detail'] = $this->common_model->get_oneTime_orders();

        $data['user_detail'] = $this->common_model->get_table_data('tbl_users','*', array('user_id' => $this->session->userdata('user_id')), $row = 1);
        $this->load->view('admin/accounts/track_oneTime_orders', $data);
        $this->load->view('admin/common/footer');
    }



}