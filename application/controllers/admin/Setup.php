<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */

class Setup extends CI_Controller
{
    public function index()
    {
        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $data['ig_name_setup_detail'] = $this->common_model->get_table_data('tbl_ig_name_change', '*');
        $this->load->view('admin/setup/igName_changing_setup', $data);
        $this->load->view('admin/common/footer');
    }

    public function update_igName_changeSetup() {
        is_admin_in();
        $data = array(
            'change_time' => $this->input->post('change_time'),
            'change_price' => $this->input->post('change_price'),
        );
        $check_qry = $this->common_model->get_table_data('tbl_ig_name_change', '*');

        if (count($check_qry) == 0) {
            $this->common_model->insert_table('tbl_ig_name_change', $data);
            $this->session->set_flashdata('success_message', 'Added Successfully');
            redirect('admin/setup');
        } else {
            $this->common_model->update_table('tbl_ig_name_change', $data, 'change_id = 1');
            $this->session->set_flashdata('success_message', 'Updated Successfully');
            redirect('admin/setup');
        }
    }

    public function keywords_setup() {
        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $data['website_keywords_detail'] = $this->common_model->get_table_data('tbl_website_keywords', '*');
        $this->load->view('admin/setup/keywords_setup',  $data);
        $this->load->view('admin/common/footer');
    }

    public function update_keywords() {
        is_admin_in();

        $keyword_id =   $this->uri->segment(4);

        if(!empty($keyword_id)) {

            $this->load->view('admin/common/header');
            $this->load->view('admin/common/sidebar');
            $data['website_keywords_detail'] = $this->common_model->get_table_data('tbl_website_keywords', '*', array('keyword_id' => $keyword_id));
            $this->load->view('admin/setup/keywords_setup',  $data);
            $this->load->view('admin/common/footer');

        } else {

            $data = array(
                'page_title' => $this->input->post('page_title'),
                'keywords' => $this->input->post('keywords'),
                'keyword_description' => $this->input->post('keyword_description'),
            );

            $qry = $this->common_model->update_table('tbl_website_keywords', $data, array('keyword_id' => $this->input->post('keyword_id')));

            $this->session->set_flashdata('success_message', 'Data Updated Successfully');
            redirect('admin/setup/keywords_setup');
        }
    }
}