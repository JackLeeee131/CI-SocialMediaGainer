<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        is_user_in();
        
        $this->common_model->delete_table('tbl_orders', array('payment_status' => 'not confirmed'));
        $this->common_model->delete_table('tbl_custom_orders', array('payment_status' => 'not confirmed'));
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $data['insta_users'] = $this->common_model->get_insta_users();
        $this->load->view('dashboard/dashboard', $data);
        $this->load->view('common/footer');
    }

    public function get_dashboard_data()
    {
        is_user_in();
        $data['insta_users'] = $this->common_model->get_insta_users();
        $this->load->view('dashboard/loader', $data);
    }

    public function view_posts($order_id)
    {
        is_user_in();
        require 'vendor/autoload.php';
        $this->common_model->delete_table('tbl_orders', array('payment_status' => 'not confirmed'));
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $data['insta_account'] = $this->common_model->get_insta_account($order_id);
        $this->load->view('dashboard/view_posts', $data);
        $this->load->view('common/footer');
    }

    public function get_comment_list()
    {
        is_user_in();
        $comment_ordered = $this->input->post('comment_ordered');
        $order_id = $this->input->post('order_id');
        $service_ids = $this->common_model->get_table_data('tbl_api_setup', '*', 'api_id=1');
        $comments_min = $service_ids[0]['comments_min'];
        if ($comment_ordered < $comments_min) {
            echo "0";
        } else {
            $this->db->select('*');
            $this->db->from('tbl_comments');
            $this->db->where('user_id', null);
            $this->db->limit($comment_ordered);
            $qry = $this->db->get()->result_array();
            $i = 1;
            foreach ($qry as $comments) {
                echo '<div class="form-row align-items-center">
                        <div class="col-lg-2 col-sm-2"> ' . $i++ . '  </div>
                        <div class="col-lg-6 col-sm-6">
                            <input name="comment_list[]" type="text" value="' . $comments['comment_description'] . '" class="form-control comments_box">
                        </div>
                    </div>';
            }
        }
    }


    public function update_package_status()
    {
        is_user_in();
        $order_id =  $this->uri->segment(3);
        $status =  $this->uri->segment(4);
        $date = date('Y-m-d H:i:s');
        if($status == 'active') {
            $status = 'pause';
        } else {
            $status = 'active';
        }
        $this->common_model->update_table('tbl_orders', array('package_status' => $status, 'status_change_date' => $date), array('order_id' => $order_id));
        redirect('dashboard');
    }
}