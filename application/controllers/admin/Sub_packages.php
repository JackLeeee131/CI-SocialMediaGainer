<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */


class Sub_Packages extends CI_Controller
{
    public function index() {
        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $data['packages_list'] = $this->common_model->get_table_data('tbl_packages', '*', array('package_status' => 'Active'));

        $data['sub_packages_list'] = $this->common_model->get_sub_packages();

        $this->load->view('admin/packages/sub_packages', $data);
        $this->load->view('admin/common/footer');
    }

    public function add_sub_package() {
        is_admin_in();
        $package_id = $this->input->post('package_id');
        $price = $this->input->post('price');
        $likes = $this->input->post('likes');
        $views = $this->input->post('views');
        $comments = $this->input->post('comments');
        $followers = $this->input->post('followers');
        $special_id = $this->input->post('special_order_id');
        $likes_per_post = $this->input->post('likes_per_post');
        $views_per_post = $this->input->post('views_per_post');
        $comments_per_post = $this->input->post('comments_per_post');
        $followers_per_day = $this->input->post('followers_per_day');

        if (!empty($package_id) && !empty($price) && !(empty($likes_per_post))) {
            if ($package_id == 1 && empty($likes) && empty($views) && empty($likes_per_post) && empty($views_per_post)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/sub_packages');
            }
            if ($package_id == 2 && empty($likes) && empty($views) && empty($comments) && empty($likes_per_post) && empty($views_per_post) && empty($comments_per_post)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/sub_packages');
            }
            if ($package_id == 3 && empty($followers) && empty($views) && empty($comments)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/sub_packages');
            }
            if ($package_id == 4 && empty($likes) && empty($followers) && empty($views) && empty($comments)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/sub_packages');
            }
            if ($package_id == 5 && empty($likes) && empty($followers) && empty($views) && empty($comments) && empty($special_id)) {
                $this->session->set_flashdata('error_message', 'All fields are required');
                redirect('admin/sub_packages');
            }
            $data = array(
                'tbl_package_id' => $package_id,
                'likes' => $this->input->post('likes'),
                'likes_per_post' => $this->input->post('likes_per_post'),
                'views' => $this->input->post('views'),
                'views_per_post' => $this->input->post('views_per_post'),
                'comments' => $this->input->post('comments'),
                'comments_per_post' => $this->input->post('comments_per_post'),
                'followers' => $this->input->post('followers'),
                'followers_per_day' => $this->input->post('followers_per_day'),
                'price' => $this->input->post('price'),
                'special_id' => $this->input->post('special_order_id'),
                'updated_date' => date('Y-m-d H:i:s')
            );

            $this->common_model->insert_table('tbl_sub_packages', $data);
            //echo '<pre>'; print_r($data); echo '</pre>'; exit;
            $this->session->set_flashdata('success_message', 'Sub Package Added Successfully');
            redirect('admin/sub_packages');
        } else {
            $this->session->set_flashdata('error_message', 'All fields are required');
            redirect('admin/sub_packages');
        }
    }


    public function update_sub_package() {
        is_admin_in();
        $edit_id = $this->input->post('sub_package_id');
        if (!empty($edit_id)) {
            $data = array(
                'tbl_package_id' => $this->input->post('package_id'),
                'likes' => $this->input->post('likes'),
                'likes_per_post' => $this->input->post('likes_per_post'),
                'views' => $this->input->post('views'),
                'views_per_post' => $this->input->post('views_per_post'),
                'comments' => $this->input->post('comments'),
                'comments_per_post' => $this->input->post('comments_per_post'),
                'followers' => $this->input->post('followers'),
                'followers_per_day' => $this->input->post('followers_per_day'),
                'price' => $this->input->post('price'),
                'special_id' => $this->input->post('special_order_id'),
                'updated_date' => date('Y-m-d H:i:s')
            );

            $this->common_model->update_table('tbl_sub_packages', $data, array('sub_package_id' => $edit_id));
            $this->session->set_flashdata('success_message', 'Sub Package Updated Successfully');
            redirect('admin/sub_packages');
        }
        $sub_package_id = $this->uri->segment(4);
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');
        $data['packages_list'] = $this->common_model->get_table_data('tbl_packages', '*', array('package_status' => 'Active'));
        $data['sub_packages_list'] = $this->common_model->get_sub_package($sub_package_id);
        $this->load->view('admin/packages/edit_sub_packages', $data);
        $this->load->view('admin/common/footer');
    }


    public function delete_sub_package($sub_package_id) {
        is_admin_in();
        $this->common_model->delete_table('tbl_sub_packages', array('sub_package_id' => $sub_package_id));
        $this->session->set_flashdata('success_message', 'Sub Package Deleted Successfully');
        redirect('admin/sub_packages');
    }
}