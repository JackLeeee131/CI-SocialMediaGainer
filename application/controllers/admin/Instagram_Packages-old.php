<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */

class Instagram_Packages extends CI_Controller {

    public function index() {

        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');

        $data['packages_list'] = $this->common_model->get_table_data('tbl_packages','*',array('package_status'=> 'Active'));

        $this->load->view('admin/packages/instagram_packages', $data);
        $this->load->view('admin/common/footer');
    }

    public function update_package() {
        $package_id = $this->input->post('package_id');
        $price = $this->input->post('price');
        $likes = $this->input->post('likes');
        $views = $this->input->post('views');
        $comments = $this->input->post('comments');
        $followers = $this->input->post('followers');
        $special_id = $this->input->post('special_order_id');

        if(!empty($package_id) && !empty($price)){

            if($package_id == 1 && empty($likes) || empty($views)) {
                $this->session->set_flashdata('error_message', 'All fields are required11');
                redirect('admin/instagram_packages');
            }
            if($package_id == 2 && empty($likes) && empty($views) && empty($comments)) {
                $this->session->set_flashdata('error_message', 'All fields are required22');
                redirect('admin/instagram_packages');
            }
            if($package_id == 3 && empty($followers) && empty($views) && empty($comments)) {
                $this->session->set_flashdata('error_message', 'All fields are required33');
                redirect('admin/instagram_packages');
            }
            if($package_id == 4 && empty($likes) && empty($followers) && empty($views) && empty($comments)) {
                $this->session->set_flashdata('error_message', 'All fields are required44');
                redirect('admin/instagram_packages');
            }
            if($package_id == 5 && empty($likes) && empty($followers) && empty($views) && empty($comments) && empty($special_id)) {
                $this->session->set_flashdata('error_message', 'All fields are required55');
                redirect('admin/instagram_packages');
            }

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
                //echo '<pre>'; print_r($data); echo '</pre>'; exit;
                $this->session->set_flashdata('success_message', 'Package Updated Successfully');
                redirect('admin/instagram_packages');

        }else{
            $this->session->set_flashdata('error_message', 'All fields are requireddddd');
            redirect('admin/instagram_packages');
        }
    }
}