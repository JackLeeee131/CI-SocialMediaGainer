<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */

class User_Accounts extends CI_Controller {

    public function index() {

        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $data['accounts_list'] = $this->common_model->get_user_accounts();
        $this->load->view('admin/accounts/user_accounts', $data);
        $this->load->view('admin/common/footer');
    }


    public function add_funds() {
        is_admin_in();
        $user_id = $this->input->post('user_id');
        $funds = $this->input->post('funds');
        $total_rows = $this->common_model->get_table_data('tbl_accounts','*', array('user_id' => $user_id));

        if(count($total_rows) == 0) {
            $data = array(
                'user_id' => $user_id,
                'account_funds' => $funds,
                'created_date' => date('Y-m-d H:i:s')
            );
            $this->common_model->insert_table('tbl_accounts',$data);
        } else {
            $this->common_model->update_table('tbl_accounts',array('account_funds' => $funds, 'updated_date' => date('Y-m-d H:i:s')), array('user_id' => $user_id));
        }
    }


    public function update_funds() {
        is_admin_in();
        $user_id = $this->uri->segment(4);
        $total_rows = $this->common_model->get_table_data('tbl_accounts','*', array('user_id' => $user_id), $row=1);
        $funds = $total_rows[0]['account_funds'];
        $update_funds = $total_rows[0]['account_funds'] + $total_rows[0]['current_balance'];

        if (strpos($funds, '-') === 0) {
            $msg = 'Admin has Subtracted $'. $funds . ' from your Account';
        } else {
            $msg = 'Admin has Added $'. $funds . ' in your Account';
        }
       // echo '<pre>'; print_r($funds['package_setup']); echo '</pre>'; exit;

        $this->common_model->update_table('tbl_accounts',array('current_balance' => $update_funds, 'account_funds' => 0, 'seen_msg' => $msg), array('user_id' => $user_id));
        $this->session->set_flashdata('success_message', 'Funds Updated Successfully');
        redirect('admin/user_accounts');
    }

    public function update_status() {
        is_admin_in();
        $user_id = $this->uri->segment(4);
        $qry = $this->common_model->get_table_data('tbl_users','*', array('user_id' => $user_id), $row=1);
        $status = $qry[0]['status'];

        if ($status == 'Active') {
            $updated_status = 'Banned';
        } else {
            $updated_status = 'Active';
        }

        $this->common_model->update_table('tbl_users',array('status' => $updated_status), array('user_id' => $user_id));
        $this->session->set_flashdata('success_message', 'Status Updated Successfully');
        redirect('admin/user_accounts');
    }


    public function update_package() {
        is_admin_in();
        $package_id = $this->input->post('package_id');
        $price = $this->input->post('price');
        $likes = $this->input->post('likes');
        $views = $this->input->post('views');
        $comments = $this->input->post('comments');
        $followers = $this->input->post('followers');
        $special_id = $this->input->post('special_order_id');

        if(!empty($package_id) && !empty($price)){

            if($package_id == 1 && empty($likes) || empty($views)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/instagram_packages');
            } else if($package_id == 2 || empty($likes) || empty($views) || empty($comments)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/instagram_packages');
            } else if($package_id == 3 || empty($followers) || empty($views) || empty($comments)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/instagram_packages');
            } else if($package_id == 4 && empty($likes) || empty($followers) || empty($views) || empty($comments)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/instagram_packages');
            } else if($package_id == 5 && empty($likes) || empty($followers) || empty($views) || empty($comments) || empty($special_id)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/instagram_packages');
            } else {
                $data = array(
                    'package_likes' => $this->input->post('likes'),
                    'package_views' => $this->input->post('views'),
                    'package_comments' => $this->input->post('comments'),
                    'package_followers' => $this->input->post('followers'),
                    'package_price' => $this->input->post('price'),
                    'package_special_id' => $this->input->post('special_order_id'),
                    'package_updated_date' => date('Y-m-d H:i:s')
                );
                $this->common_model->update_table('tbl_packages', $data, array('package_id' => $package_id));
                $this->session->set_flashdata('success_message', 'Package Updated Successfully');
                redirect('admin/instagram_packages');
            }
        }else{
            $this->session->set_flashdata('error_message', 'All fields are required');
            redirect('admin/instagram_packages');
        }

    }


    public function update_referral() {
        is_admin_in();
        $user_id = $this->input->post('user_id');
        $referral = $this->input->post('referral');
            $this->common_model->update_table('tbl_accounts',array('referral' => $referral, 'updated_date' => date('Y-m-d H:i:s')), array('user_id' => $user_id));

            echo $referral; exit;
    }




}