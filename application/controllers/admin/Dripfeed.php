<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */

class Dripfeed extends CI_Controller {

    public function index() {
        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $data['dripfeed_detail'] = $this->common_model->get_table_data('tbl_dripfeed','*','');
        $this->load->view('admin/dripfeed/manage_dripfeed', $data);
        $this->load->view('admin/common/footer');
    }

    public function add_dripfeed() {
        is_admin_in();
        $dripfeed_run = $this->input->post('dripfeed_run');
        if(!empty($dripfeed_run)) {
            $dripfeed = $dripfeed_run;
        } else {
            $dripfeed = $this->input->post('dripfeed_run_follower');
        }
                $data = array(
                    'dripfeed_for' => $this->input->post('dripfeed_for'),
                    'dripfeed_run' => $dripfeed,
                    'dripfeed_price' => $this->input->post('dripfeed_price'),
                );
            $this->common_model->insert_table('tbl_dripfeed',$data);
            $this->session->set_flashdata('success_message', 'Dripfeed Added Successfully');
            redirect('admin/dripfeed');

    }

    public function update_dripfeed() {
        is_admin_in();
        $edit_id = $this->input->post('dripfeed_id');

        if(!empty($edit_id)) {

            $dripfeed_run = $this->input->post('dripfeed_run');
            if(!empty($dripfeed_run)) {
                $dripfeed = $dripfeed_run;
            } else {
                $dripfeed = $this->input->post('dripfeed_run_follower');
            }

            $data = array(
                'dripfeed_for' => $this->input->post('dripfeed_for'),
                'dripfeed_run' => $dripfeed,
                'dripfeed_price' => $this->input->post('dripfeed_price'),
            );

            $this->common_model->update_table('tbl_dripfeed',$data, array('dripfeed_id' => $edit_id));
            $this->session->set_flashdata('success_message', 'Dripfeed Info Updated Successfully');
            redirect('admin/dripfeed');
        }
        $dripfeed_id = $this->uri->segment(4);
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $data['edit_dripfeed'] =  $this->common_model->get_table_data('tbl_dripfeed','*', array('dripfeed_id' => $dripfeed_id));
        $this->load->view('admin/dripfeed/edit_dripfeed', $data);
        $this->load->view('admin/common/footer');

    }




    public function delete_dripfeed($dripfeed_id) {
        is_admin_in();
        $this->common_model->delete_table('tbl_dripfeed', array('dripfeed_id' => $dripfeed_id));
        $this->session->set_flashdata('success_message', 'Dripfeed Deleted Successfully');
        redirect('admin/dripfeed');

    }





}