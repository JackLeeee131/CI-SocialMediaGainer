<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */

class Api_Setup extends CI_Controller {

    public function index() {

        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');

        $data['api_detail'] = $this->common_model->get_table_data('tbl_api_setup','*','');

        $this->load->view('admin/api_setup/manage_api', $data);
        $this->load->view('admin/common/footer');
    }

    public function update_api_setup() {
        is_admin_in();
                $data = array(
                    'likes_service_id' => $this->input->post('likes_service_id'),
                    'views_service_id' => $this->input->post('views_service_id'),
                    'comments_service_id' => $this->input->post('comments_service_id'),
                    'followers_service_id' => $this->input->post('followers_service_id'),
                    'api_key' => $this->input->post('api_key'),
                    'api_url' => $this->input->post('api_url'),
                    'likes_min' => $this->input->post('likes_min'),
                    'likes_max' => $this->input->post('likes_max'),
                    'views_min' => $this->input->post('views_min'),
                    'views_max' => $this->input->post('views_max'),
                    'comments_min' => $this->input->post('comments_min'),
                    'comments_max' => $this->input->post('comments_max'),
                    'followers_min' => $this->input->post('followers_min'),
                    'followers_max' => $this->input->post('followers_max'),
                    'updated_date' => date('Y-m-d H:i:s')
                );

        $total_rows = $this->common_model->get_table_data('tbl_api_setup','*','');
        if(count($total_rows) == 0) {
            $this->common_model->insert_table('tbl_api_setup',$data);
            $this->session->set_flashdata('success_message', 'API detail Added Successfully');
            redirect('admin/api_setup');
        } else {
            $this->common_model->update_table('tbl_api_setup',$data, array('api_id' => 1));
            $this->session->set_flashdata('success_message', 'API detail Updated Successfully');
            redirect('admin/api_setup');
        }

    }

}