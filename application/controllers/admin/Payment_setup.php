<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */

class Payment_Setup extends CI_Controller {

    public function index() {

        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');

        $data['payment_detail'] = $this->common_model->get_table_data('tbl_payment_setup','*','');

        $this->load->view('admin/payments/payment_setup', $data);
        $this->load->view('admin/common/footer');
    }

    public function add_payment() {
        is_admin_in();
        $payment_method = $this->input->post('payment_method');
                $data = array(
                    'payment_method' => $this->input->post('payment_method'),
                    'minimum_amount' => $this->input->post('amount'),
                    'payment_email' => $this->input->post('email'),
                    'message' => $this->input->post('message'),
                );
        $total_rows = $this->common_model->get_table_data('tbl_payment_setup','*', array('payment_method' => $payment_method));
        if(count($total_rows) >= 1) {
            $this->session->set_flashdata('error_message', 'Duplicate Payment Method not Allowed');
            redirect('admin/payment_setup');
        } else {
            $this->common_model->insert_table('tbl_payment_setup',$data);
            $this->session->set_flashdata('success_message', 'Payment Info Added Successfully');
            redirect('admin/payment_setup');
        }
    }


    public function update_payment() {
        is_admin_in();
        $edit_id = $this->input->post('payment_id');
        if(!empty($edit_id)) {
            $data = array(
                'minimum_amount' => $this->input->post('amount'),
                'payment_email' => $this->input->post('email'),
                'message' => $this->input->post('message'),
            );

            $this->common_model->update_table('tbl_payment_setup',$data, array('payment_id' => $edit_id));
            $this->session->set_flashdata('success_message', 'Payment Info Updated Successfully');
            redirect('admin/payment_setup');
        }
        $payment_id = $this->uri->segment(4);
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $data['edit_payment'] =  $this->common_model->get_table_data('tbl_payment_setup','*', array('payment_id' => $payment_id));
        $this->load->view('admin/payments/edit_payment_setup', $data);
        $this->load->view('admin/common/footer');

    }
}