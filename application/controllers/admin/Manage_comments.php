<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */

class Manage_Comments extends CI_Controller {

    public function index() {

        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');

        $data['comments_list'] = $this->common_model->get_table_data('tbl_comments','*',array('user_id' => null));

        $this->load->view('admin/comments/manage_comments', $data);
        $this->load->view('admin/common/footer');
    }

    public function add_comments() {
        is_admin_in();
                $data = array(
                    'comment_description' => $this->input->post('comment_description'),
                );
            $this->common_model->insert_table('tbl_comments',$data);
            $this->session->set_flashdata('success_message', 'Comment Added Successfully');
            redirect('admin/manage_comments');

    }


    public function delete_comments($comment_id) {
        is_admin_in();
        $this->common_model->delete_table('tbl_comments', array('comment_id' => $comment_id));
        $this->session->set_flashdata('success_message', 'Comment Deleted Successfully');
        redirect('admin/manage_comments');
    }









}