<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 1:52 PM
 */

class Package_Setup extends CI_Controller {

    public function index() {

        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');

        $data['package_setup'] = $this->common_model->get_table_data('tbl_package_setup','*');
        $data['range_setup'] = $this->common_model->get_table_data('tbl_customorder_ranges','*');
        $this->load->view('admin/packages/package_setup', $data);
        //echo '<pre>'; print_r($data['package_setup']); echo '</pre>';
        $this->load->view('admin/common/footer');
    }

    public function update_package_setup() {
        is_admin_in();
        $package_id = $this->input->post('package_id');

            $data = array(
                'likes_range_from'=> $this->input->post('likes_range_from'),
                'likes_range_to'=> $this->input->post('likes_range_to'),
                'likes_discount'=> $this->input->post('likes_discount'),
                'likes_min_order'=> $this->input->post('likes_min_order'),
                'likes_max_order'=> $this->input->post('likes_max_order'),
                'likes_price'=> $this->input->post('likes_price'),

                'views_range_from'=> $this->input->post('views_range_from'),
                'views_range_to'=> $this->input->post('views_range_to'),
                'views_discount'=> $this->input->post('views_discount'),
                'views_min_order'=> $this->input->post('views_min_order'),
                'views_max_order'=> $this->input->post('views_max_order'),
                'views_price'=> $this->input->post('views_price'),

                'comments_range_from'=> $this->input->post('comments_range_from'),
                'comments_range_to'=> $this->input->post('comments_range_to'),
                'comments_discount'=> $this->input->post('comments_discount'),
                'comments_min_order'=> $this->input->post('comments_min_order'),
                'comments_max_order'=> $this->input->post('comments_max_order'),
                'comments_price'=> $this->input->post('comments_price'),

                'followers_range_from'=> $this->input->post('followers_range_from'),
                'followers_range_to'=> $this->input->post('followers_range_to'),
                'followers_discount'=> $this->input->post('followers_discount'),
                'followers_min_order'=> $this->input->post('followers_min_order'),
                'followers_max_order'=> $this->input->post('followers_max_order'),
                'followers_price'=> $this->input->post('followers_price'),
            );

            $total_rows = $this->common_model->get_table_data('tbl_package_setup','*');

            if(count($total_rows) == 0) {
                $this->common_model->insert_table('tbl_package_setup',$data);
            } else {
                $this->common_model->update_table('tbl_package_setup',$data, array('setup_id' => 1));
            }
            //echo '<pre>'; print_r($data); echo '</pre>'; exit;
            $this->session->set_flashdata('success_message', 'Package Updated Successfully');
            redirect('admin/package_setup');


    }



    public function add_customOrder_ranges() {
        is_admin_in();
        $data = array(
            'range_name' => $this->input->post('range_name'),
            'range_from' => $this->input->post('range_from'),
            'range_to' => $this->input->post('range_to'),
            'range_discount' => $this->input->post('range_discount'),
        );

        $this->common_model->insert_table('tbl_customorder_ranges',$data);
        $this->session->set_flashdata('success_message_range', 'Range Added Successfully');
        redirect('admin/package_setup');
    }





    public function delete_customOrder_range($range_id) {
        is_admin_in();

        $this->common_model->delete_table('tbl_customorder_ranges', array('range_id' => $range_id));
        $this->session->set_flashdata('success_message_range', 'Range Deleted Successfully');
        redirect('admin/package_setup');

    }












}
