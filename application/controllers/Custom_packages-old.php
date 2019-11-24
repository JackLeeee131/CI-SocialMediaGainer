<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_packages extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->library('paypal_lib');
    }


    public function index()
    {


        is_user_in();
        $this->load->view('common/header');
        $this->load->view('common/sidebar');

       /* $data['followers_dripfeed'] = $this->common_model->get_table_data('tbl_dripfeed', '*', array('dripfeed_for' => 'followers'));
        $data['likes_views_dripfeed'] = $this->common_model->get_table_data('tbl_dripfeed', '*', array('dripfeed_for' => 'likes_views'));
        */

        $data['dripfeed_detail'] = $this->common_model->get_table_data('tbl_dripfeed','*',array('dripfeed_for' => 'packages'));
        $data['custom_package_setup'] = $this->common_model->get_table_data('tbl_package_setup', '*');

        $default_like_min = $data['custom_package_setup'][0]['likes_min_order'];
        $default_view_min = $data['custom_package_setup'][0]['views_min_order'];
        $default_comment_min = $data['custom_package_setup'][0]['comments_min_order'];
        $default_follower_min = $data['custom_package_setup'][0]['followers_min_order'];

        $default_like_price = $data['custom_package_setup'][0]['likes_price'];
        $default_view_price = $data['custom_package_setup'][0]['views_price'];
        $default_comment_price = $data['custom_package_setup'][0]['comments_price'];
        $default_follower_price = $data['custom_package_setup'][0]['followers_price'];


        $like_range_data = $this->db->query("SELECT * FROM tbl_customorder_ranges WHERE '$default_like_min' BETWEEN range_from AND range_to AND range_name = 'Likes' LIMIT 1")->result_array();
        if (count($like_range_data) >= 1) {
            $original_price = $default_like_min * $default_like_price;
            $like_discount = $like_range_data[0]['range_discount'];
            $price_with_discount = ($original_price * $like_discount) / 100;
            $like_price = $original_price - $price_with_discount;
        } else {
            $like_discount = 0;
            $like_price = $default_like_min * $default_like_price;
        }


        $view_range_data = $this->db->query("SELECT * FROM tbl_customorder_ranges WHERE '$default_view_min' BETWEEN range_from AND range_to AND range_name = 'Views' LIMIT 1")->result_array();
        if (count($view_range_data) >= 1) {
            $original_price = $default_view_min * $default_view_price;
            $view_discount = $view_range_data[0]['range_discount'];
            $price_with_discount = ($original_price * $view_discount) / 100;
            $view_price = $original_price - $price_with_discount;

        } else {
            $view_discount = 0;
            $view_price = $default_view_min * $default_view_price;
        }


        $comment_range_data = $this->db->query("SELECT * FROM tbl_customorder_ranges WHERE '$default_comment_min' BETWEEN range_from AND range_to AND range_name = 'Comments' LIMIT 1")->result_array();
        if (count($comment_range_data) >= 1) {
            $original_price = $default_comment_min * $default_comment_price;
            $comment_discount = $comment_range_data[0]['range_discount'];
            $price_with_discount = ($original_price * $comment_discount) / 100;
            $comment_price = $original_price - $price_with_discount;

        } else {
            $comment_discount = 0;
            $comment_price = $default_comment_min * $default_comment_price;
        }


        $follower_range_data = $this->db->query("SELECT * FROM tbl_customorder_ranges WHERE '$default_follower_min' BETWEEN range_from AND range_to AND range_name = 'Followers' LIMIT 1")->result_array();
        if (count($follower_range_data) >= 1) {
            $original_price = $default_follower_min * $default_follower_price;
            $follower_discount = $follower_range_data[0]['range_discount'];
            $price_with_discount = ($original_price * $follower_discount) / 100;
            $follower_price = $original_price - $price_with_discount;


        } else {
            $follower_discount = 0;
            $follower_price = $default_follower_min * $default_follower_price;
        }


        $data['range_data'] = array(
            'likes_price' => round($like_price, 2),
            'likes_discount' => $like_discount,
            'views_price' => round($view_price, 2),
            'views_discount' => $view_discount,
            'comments_price' => round($comment_price, 2),
            'comments_discount' => $comment_discount,
            'followers_price' => round($follower_price, 2),
            'followers_discount' => $follower_discount,

        );


        $this->load->view('packages/custom_packages', $data);
        $this->load->view('common/footer');
        $this->common_model->delete_table('tbl_comments', array('user_id' => $this->session->userdata('user_id')));
        $this->common_model->delete_table('tbl_custom_orders', array('payment_status' => 'not confirmed'));


    }


    public function get_followers_data()
    {
        $followers_order = $this->input->post('followers_order');
        $package_setup_qry = $this->common_model->get_table_data('tbl_package_setup', 'followers_price');
        $follower_price = $package_setup_qry[0]['followers_price'];
        $follower_range_data = $this->db->query("SELECT * FROM tbl_customorder_ranges WHERE '$followers_order' BETWEEN range_from AND range_to AND range_name = 'followers' LIMIT 1")->result_array();
        if (count($follower_range_data) >= 1) {
            $original_price = $followers_order * $follower_price;
            $discount = $follower_range_data[0]['range_discount'];
            $price_with_discount = ($original_price * $discount) / 100;
            $price = $original_price - $price_with_discount;


        } else {
            $discount = 0;
            $price = $followers_order * $follower_price;
        }
        $data = array(
            'followers_discount' => $discount,
            'followers_price' => round($price, 2)
        );
        echo json_encode($data);
    }


    public function confirm_followers_order()
    {
        $custom_order_code = time() . uniqid();
        $dripfeed_id = $this->input->post('tbl_dripfeed_id');
        $followers_send = $this->input->post('followers');

        $package_setup_detail = $this->common_model->get_table_data('tbl_package_setup', '*');
        $followers_range_from = $package_setup_detail[0]['followers_range_from'];
        $followers_range_to = $package_setup_detail[0]['followers_range_to'];
        $followers_max_order = $package_setup_detail[0]['followers_max_order'];
        $followers_discount = $package_setup_detail[0]['followers_discount'];
        $followers_price = $package_setup_detail[0]['followers_price'];
        $total_price = $this->input->post('followers_price_value');

        if (!empty($dripfeed_id)) {
            $dripfeed_detail = $this->common_model->get_table_data('tbl_dripfeed', '*', array('dripfeed_id' => $dripfeed_id));
            $dripfeed_interval = $dripfeed_detail[0]['dripfeed_interval'];
            $dripfeed_count = preg_replace("/[^0-9,.]/", "", $dripfeed_interval);
            $dripfeed_price = $dripfeed_detail[0]['dripfeed_price'];
            $total_price = $total_price + $dripfeed_price;

            $count_date = 0;
            for ($i = 1; $i <= $dripfeed_count; $i++) {
                $dripfeed_date = date('Y-m-d H:i:s', strtotime(+$count_date++ . 'days'));
                $order_qty = $followers_send / $dripfeed_count;
                $insert_data = array(
                    'custom_order_code' => $custom_order_code,
                    'order_price' => $total_price,
                    'user_id' => $this->session->userdata('user_id'),
                    'txn_type' => 'custom package',
                    'instagram_url' => $this->input->post('instagram_url'),
                    'dripfeed' => 'yes',
                    'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                    'order_qty' => $order_qty,
                    'total_order_qty' => $followers_send,
                    'package_name' => 'Followers',
                    'order_name' => 'Followers',
                    'dripfeed_date' => $dripfeed_date,
                    'payment_status' => 'not confirmed',
                );
                $this->common_model->insert_table('tbl_custom_orders', $insert_data);
            }
        } else {
            $insert_data = array(
                'custom_order_code' => $custom_order_code,
                'order_price' => $total_price,
                'user_id' => $this->session->userdata('user_id'),
                'txn_type' => 'custom package',
                'instagram_url' => $this->input->post('instagram_url'),
                'dripfeed' => 'no',
                'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                'order_qty' => $followers_send,
                'total_order_qty' => $followers_send,
                'package_name' => 'Followers',
                'order_name' => 'Followers',
                'dripfeed_date' => date('Y-m-d H:i:s'),
                'payment_status' => 'not confirmed',
            );
            $this->common_model->insert_table('tbl_custom_orders', $insert_data);
        }

        $data['confirm_order_detail'] = $this->common_model->get_table_data('tbl_custom_orders', '*', array('custom_order_code' => $custom_order_code));

        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('packages/confirm_custom_package', $data);
        $this->load->view('common/footer');
    }


    public function get_likes_data()
    {
        $likes_order = $this->input->post('likes_order');
        $package_setup_qry = $this->common_model->get_table_data('tbl_package_setup', 'likes_price');
        $like_price = $package_setup_qry[0]['likes_price'];
        $like_range_data = $this->db->query("SELECT * FROM tbl_customorder_ranges WHERE '$likes_order' BETWEEN range_from AND range_to AND range_name = 'Likes' LIMIT 1")->result_array();
        if (count($like_range_data) >= 1) {
            $original_price = $likes_order * $like_price;
            $discount = $like_range_data[0]['range_discount'];
            $price_with_discount = ($original_price * $discount) / 100;
            $price = $original_price - $price_with_discount;

        } else {
            $discount = 0;
            $price = $likes_order * $like_price;
        }
        $data = array(
            'likes_discount' => $discount,
            'likes_price' => round($price, 2)
        );
        echo json_encode($data);
    }


    public function confirm_likes_order()
    {
        $custom_order_code = time() . uniqid();
        $dripfeed_id = $this->input->post('tbl_dripfeed_id');
        $likes_send = $this->input->post('likes');
        $total_price = $this->input->post('likes_price_value');

        if (!empty($dripfeed_id)) {
            $dripfeed_detail = $this->common_model->get_table_data('tbl_dripfeed', '*', array('dripfeed_id' => $dripfeed_id));
            $dripfeed_interval = $dripfeed_detail[0]['dripfeed_interval'];
            $dripfeed_price = $dripfeed_detail[0]['dripfeed_price'];
            $total_price = $total_price + $dripfeed_price;


            if (strpos($dripfeed_interval, 'hours') !== false) {
                $dripfeed_count = preg_replace("/[^0-9,.]/", "", $dripfeed_interval);
                $dripfeed_date = date('Y-m-d H:i:s', strtotime(+$dripfeed_count . ' hours'));
                $insert_data = array(
                    'custom_order_code' => $custom_order_code,
                    'order_price' => $total_price,
                    'user_id' => $this->session->userdata('user_id'),
                    'txn_type' => 'custom package',
                    'instagram_url' => $this->input->post('instagram_url'),
                    'dripfeed' => 'yes',
                    'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                    'order_qty' => $likes_send,
                    'total_order_qty' => $likes_send,
                    'package_name' => 'Likes',
                    'order_name' => 'Likes',
                    'dripfeed_date' => $dripfeed_date,
                    'payment_status' => 'not confirmed',
                );
                $this->common_model->insert_table('tbl_custom_orders', $insert_data);

            } else {

                $dripfeed_count = preg_replace("/[^0-9,.]/", "", $dripfeed_interval);
                $count_date = 0;
                for ($i = 1; $i <= $dripfeed_count; $i++) {
                    $dripfeed_date = date('Y-m-d H:i:s', strtotime(+$count_date++ . 'days'));
                    $order_qty = $likes_send / $dripfeed_count;
                    $insert_data = array(
                        'custom_order_code' => $custom_order_code,
                        'order_price' => $total_price,
                        'user_id' => $this->session->userdata('user_id'),
                        'txn_type' => 'custom package',
                        'instagram_url' => $this->input->post('instagram_url'),
                        'dripfeed' => 'yes',
                        'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                        'order_qty' => $order_qty,
                        'total_order_qty' => $likes_send,
                        'package_name' => 'Likes',
                        'order_name' => 'Likes',
                        'dripfeed_date' => $dripfeed_date,
                        'payment_status' => 'not confirmed',
                    );
                    $this->common_model->insert_table('tbl_custom_orders', $insert_data);
                }
            }


        } else {
            $insert_data = array(
                'custom_order_code' => $custom_order_code,
                'order_price' => $total_price,
                'user_id' => $this->session->userdata('user_id'),
                'txn_type' => 'custom package',
                'instagram_url' => $this->input->post('instagram_url'),
                'dripfeed' => 'no',
                'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                'order_qty' => $likes_send,
                'total_order_qty' => $likes_send,
                'package_name' => 'Likes',
                'order_name' => 'Likes',
                'dripfeed_date' => date('Y-m-d H:i:s'),
                'payment_status' => 'not confirmed',
            );
            $this->common_model->insert_table('tbl_custom_orders', $insert_data);
        }

        $data['confirm_order_detail'] = $this->common_model->get_table_data('tbl_custom_orders', '*', array('custom_order_code' => $custom_order_code));

        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('packages/confirm_custom_package', $data);
        $this->load->view('common/footer');
    }


    public function get_views_data()
    {
        $views_order = $this->input->post('views_order');
        $package_setup_qry = $this->common_model->get_table_data('tbl_package_setup', 'views_price');
        $view_price = $package_setup_qry[0]['views_price'];
        $view_range_data = $this->db->query("SELECT * FROM tbl_customorder_ranges WHERE '$views_order' BETWEEN range_from AND range_to AND range_name = 'Views' LIMIT 1")->result_array();
        if (count($view_range_data) >= 1) {
            $original_price = $views_order * $view_price;
            $discount = $view_range_data[0]['range_discount'];
            $price_with_discount = ($original_price * $discount) / 100;
            $price = $original_price - $price_with_discount;
        } else {
            $discount = 0;
            $price = $views_order * $view_price;
        }
        $data = array(
            'views_discount' => $discount,
            'views_price' => round($price, 2)
        );
        echo json_encode($data);
    }


    public function confirm_views_order()
    {
        $custom_order_code = time() . uniqid();
        $dripfeed_id = $this->input->post('tbl_dripfeed_id');
        $views_send = $this->input->post('views');


        $package_setup_detail = $this->common_model->get_table_data('tbl_package_setup', '*');
        $views_range_from = $package_setup_detail[0]['views_range_from'];
        $views_range_to = $package_setup_detail[0]['views_range_to'];
        $views_max_order = $package_setup_detail[0]['views_max_order'];
        $views_discount = $package_setup_detail[0]['views_discount'];
        $views_price = $package_setup_detail[0]['views_price'];
        $total_price = $this->input->post('views_price_value');

        /*        $count = 1;

        $price_count = 1;
        for ($i = $views_range_to; $i <= $views_max_order; $i += $views_range_to) {
        $discount = $views_discount * $count++;
        $price = $views_price * $price_count++;
        $calculate_discount = $price * $discount / 100;
        $total_price = $price - $calculate_discount;
        // echo  $i . '--' . $discount  . '--' . $price . '--'. $total_price. '<br><br>';
        if ($i >= $views_send) {
        break;
        }
        }*/

        if (!empty($dripfeed_id)) {
            $dripfeed_detail = $this->common_model->get_table_data('tbl_dripfeed', '*', array('dripfeed_id' => $dripfeed_id));
            $dripfeed_interval = $dripfeed_detail[0]['dripfeed_interval'];
            $dripfeed_price = $dripfeed_detail[0]['dripfeed_price'];
            $total_price = $total_price + $dripfeed_price;


            if (strpos($dripfeed_interval, 'hours') !== false) {
                $dripfeed_count = preg_replace("/[^0-9,.]/", "", $dripfeed_interval);
                $dripfeed_date = date('Y-m-d H:i:s', strtotime(+$dripfeed_count . ' hours'));
                $insert_data = array(
                    'custom_order_code' => $custom_order_code,
                    'order_price' => $total_price,
                    'user_id' => $this->session->userdata('user_id'),
                    'txn_type' => 'custom package',
                    'instagram_url' => $this->input->post('instagram_url'),
                    'dripfeed' => 'yes',
                    'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                    'order_qty' => $views_send,
                    'total_order_qty' => $views_send,
                    'package_name' => 'Views',
                    'order_name' => 'Views',
                    'dripfeed_date' => $dripfeed_date,
                    'payment_status' => 'not confirmed',
                );
                $this->common_model->insert_table('tbl_custom_orders', $insert_data);

            } else {

                $dripfeed_count = preg_replace("/[^0-9,.]/", "", $dripfeed_interval);
                $count_date = 0;
                for ($i = 1; $i <= $dripfeed_count; $i++) {
                    $dripfeed_date = date('Y-m-d H:i:s', strtotime(+$count_date++ . 'days'));
                    $order_qty = $views_send / $dripfeed_count;
                    $insert_data = array(
                        'custom_order_code' => $custom_order_code,
                        'order_price' => $total_price,
                        'user_id' => $this->session->userdata('user_id'),
                        'txn_type' => 'custom package',
                        'instagram_url' => $this->input->post('instagram_url'),
                        'dripfeed' => 'yes',
                        'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                        'order_qty' => $order_qty,
                        'total_order_qty' => $views_send,
                        'package_name' => 'Views',
                        'order_name' => 'Views',
                        'dripfeed_date' => $dripfeed_date,
                        'payment_status' => 'not confirmed',
                    );
                    $this->common_model->insert_table('tbl_custom_orders', $insert_data);
                }
            }


        } else {
            $insert_data = array(
                'custom_order_code' => $custom_order_code,
                'order_price' => $total_price,
                'user_id' => $this->session->userdata('user_id'),
                'txn_type' => 'custom package',
                'instagram_url' => $this->input->post('instagram_url'),
                'dripfeed' => 'no',
                'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                'order_qty' => $views_send,
                'total_order_qty' => $views_send,
                'package_name' => 'Views',
                'order_name' => 'Views',
                'dripfeed_date' => date('Y-m-d H:i:s'),
                'payment_status' => 'not confirmed',
            );
            $this->common_model->insert_table('tbl_custom_orders', $insert_data);
        }

        $data['confirm_order_detail'] = $this->common_model->get_table_data('tbl_custom_orders', '*', array('custom_order_code' => $custom_order_code));

        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $this->load->view('packages/confirm_custom_package', $data);
        $this->load->view('common/footer');
    }


    public function confirm_likesViews_order()
    {
        $likes_send = $this->input->post('likes');
        $views_send = $this->input->post('views');
        $custom_order_code = time() . uniqid();
        $dripfeed_id = $this->input->post('tbl_dripfeed_id');


        if (isset($likes_send)) {


            $package_setup_detail = $this->common_model->get_table_data('tbl_package_setup', '*');
            $likes_range_from = $package_setup_detail[0]['likes_range_from'];
            $likes_range_to = $package_setup_detail[0]['likes_range_to'];
            $likes_max_order = $package_setup_detail[0]['likes_max_order'];
            $likes_discount = $package_setup_detail[0]['likes_discount'];
            $likes_price = $package_setup_detail[0]['likes_price'];
            $total_price_likes = $this->input->post('likes_price_value');


            if (!empty($dripfeed_id)) {
                $dripfeed_detail = $this->common_model->get_table_data('tbl_dripfeed', '*', array('dripfeed_id' => $dripfeed_id));
                $dripfeed_interval = $dripfeed_detail[0]['dripfeed_interval'];
                $dripfeed_price = $dripfeed_detail[0]['dripfeed_price'];
                $total_price_likes = $total_price_likes + $dripfeed_price;


                if (strpos($dripfeed_interval, 'hours') !== false) {
                    $dripfeed_count = preg_replace("/[^0-9,.]/", "", $dripfeed_interval);
                    $dripfeed_date = date('Y-m-d H:i:s', strtotime(+$dripfeed_count . ' hours'));
                    $insert_data = array(
                        'custom_order_code' => $custom_order_code,
                        'order_price' => $total_price_likes,
                        'user_id' => $this->session->userdata('user_id'),
                        'txn_type' => 'custom package',
                        'instagram_url' => $this->input->post('instagram_url'),
                        'dripfeed' => 'yes',
                        'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                        'order_qty' => $likes_send,
                        'total_order_qty' => $likes_send,
                        'package_name' => 'Likes + Views',
                        'order_name' => 'Likes',
                        'dripfeed_date' => $dripfeed_date,
                        'payment_status' => 'not confirmed',
                    );
                    $this->common_model->insert_table('tbl_custom_orders', $insert_data);

                } else {

                    $dripfeed_count = preg_replace("/[^0-9,.]/", "", $dripfeed_interval);
                    $count_date = 0;
                    for ($i = 1; $i <= $dripfeed_count; $i++) {
                        $dripfeed_date = date('Y-m-d H:i:s', strtotime(+$count_date++ . 'days'));
                        $order_qty = $likes_send / $dripfeed_count;
                        $insert_data = array(
                            'custom_order_code' => $custom_order_code,
                            'order_price' => $total_price_likes,
                            'user_id' => $this->session->userdata('user_id'),
                            'txn_type' => 'custom package',
                            'instagram_url' => $this->input->post('instagram_url'),
                            'dripfeed' => 'yes',
                            'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                            'order_qty' => $order_qty,
                            'total_order_qty' => $likes_send,
                            'package_name' => 'Likes + Views',
                            'order_name' => 'Likes',
                            'dripfeed_date' => $dripfeed_date,
                            'payment_status' => 'not confirmed',
                        );
                        $this->common_model->insert_table('tbl_custom_orders', $insert_data);
                    }
                }


            } else {
                $insert_data = array(
                    'custom_order_code' => $custom_order_code,
                    'order_price' => $total_price_likes,
                    'user_id' => $this->session->userdata('user_id'),
                    'txn_type' => 'custom package',
                    'instagram_url' => $this->input->post('instagram_url'),
                    'dripfeed' => 'no',
                    'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                    'order_qty' => $likes_send,
                    'total_order_qty' => $likes_send,
                    'package_name' => 'Likes + Views',
                    'package_name' => 'Likes',
                    'dripfeed_date' => date('Y-m-d H:i:s'),
                    'payment_status' => 'not confirmed',
                );
                $this->common_model->insert_table('tbl_custom_orders', $insert_data);
            }


            $data['confirm_order_detail'] = $this->common_model->get_table_data('tbl_custom_orders', '*', array('custom_order_code' => $custom_order_code));

        }

        if (isset($views_send)) {

            $package_setup_detail = $this->common_model->get_table_data('tbl_package_setup', '*');
            $views_range_from = $package_setup_detail[0]['views_range_from'];
            $views_range_to = $package_setup_detail[0]['views_range_to'];
            $views_max_order = $package_setup_detail[0]['views_max_order'];
            $views_discount = $package_setup_detail[0]['views_discount'];
            $views_price = $package_setup_detail[0]['views_price'];
            $total_price = $this->input->post('views_price_value');


            if (!empty($dripfeed_id)) {
                $dripfeed_detail = $this->common_model->get_table_data('tbl_dripfeed', '*', array('dripfeed_id' => $dripfeed_id));
                $dripfeed_interval = $dripfeed_detail[0]['dripfeed_interval'];
                $dripfeed_price = $dripfeed_detail[0]['dripfeed_price'];
                $total_price = $total_price + $dripfeed_price;


                if (strpos($dripfeed_interval, 'hours') !== false) {
                    $dripfeed_count = preg_replace("/[^0-9,.]/", "", $dripfeed_interval);
                    $dripfeed_date = date('Y-m-d H:i:s', strtotime(+$dripfeed_count . ' hours'));
                    $insert_data = array(
                        'custom_order_code' => $custom_order_code,
                        'order_price' => $total_price + $total_price_likes,
                        'user_id' => $this->session->userdata('user_id'),
                        'txn_type' => 'custom package',
                        'instagram_url' => $this->input->post('instagram_url'),
                        'dripfeed' => 'yes',
                        'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                        'order_qty' => $views_send,
                        'total_order_qty' => $views_send,
                        'package_name' => 'Likes + Views',
                        'order_name' => 'Views',
                        'dripfeed_date' => $dripfeed_date,
                        'payment_status' => 'not confirmed',
                    );
                    $this->common_model->insert_table('tbl_custom_orders', $insert_data);

                } else {

                    $dripfeed_count = preg_replace("/[^0-9,.]/", "", $dripfeed_interval);
                    $count_date = 0;
                    for ($i = 1; $i <= $dripfeed_count; $i++) {
                        $dripfeed_date = date('Y-m-d H:i:s', strtotime(+$count_date++ . 'days'));
                        $order_qty = $views_send / $dripfeed_count;
                        $insert_data = array(
                            'custom_order_code' => $custom_order_code,
                            'order_price' => $total_price + $total_price_likes,
                            'user_id' => $this->session->userdata('user_id'),
                            'txn_type' => 'custom package',
                            'instagram_url' => $this->input->post('instagram_url'),
                            'dripfeed' => 'yes',
                            'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                            'order_qty' => $order_qty,
                            'total_order_qty' => $views_send,
                            'package_name' => 'Likes + Views',
                            'order_name' => 'Views',
                            'dripfeed_date' => $dripfeed_date,
                            'payment_status' => 'not confirmed',
                        );
                        $this->common_model->insert_table('tbl_custom_orders', $insert_data);
                    }
                }

            } else {
                $insert_data = array(
                    'custom_order_code' => $custom_order_code,
                    'order_price' => $total_price,
                    'user_id' => $this->session->userdata('user_id'),
                    'txn_type' => 'custom package',
                    'instagram_url' => $this->input->post('instagram_url'),
                    'dripfeed' => 'no',
                    'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                    'order_qty' => $views_send,
                    'total_order_qty' => $views_send,
                    'package_name' => 'Views',
                    'order_name' => 'Views',
                    'dripfeed_date' => date('Y-m-d H:i:s'),
                    'payment_status' => 'not confirmed',
                );
                $this->common_model->insert_table('tbl_custom_orders', $insert_data);
            }

            $this->common_model->update_table('tbl_custom_orders', array('order_price' => $total_price + $total_price_likes), array('custom_order_code' => $custom_order_code));
            $data['confirm_order_detail'] = $this->common_model->get_table_data('tbl_custom_orders', '*', array('custom_order_code' => $custom_order_code));

            $this->load->view('common/header');
            $this->load->view('common/sidebar');
            $this->load->view('packages/confirm_custom_package', $data);
            $this->load->view('common/footer');

        }

    }


    public function get_comments_data()
    {
        $comments_order = $this->input->post('comments_order');
        $package_setup_qry = $this->common_model->get_table_data('tbl_package_setup', 'comments_price');
        $comment_price = $package_setup_qry[0]['comments_price'];
        $comment_range_data = $this->db->query("SELECT * FROM tbl_customorder_ranges WHERE '$comments_order' BETWEEN range_from AND range_to AND range_name = 'Comments' LIMIT 1")->result_array();
        if (count($comment_range_data) >= 1) {
            $original_price = $comments_order * $comment_price;
            $discount = $comment_range_data[0]['range_discount'];
            $price_with_discount = ($original_price * $discount) / 100;
            $price = $original_price - $price_with_discount;
        } else {
            $discount = 0;
            $price = $comments_order * $comment_price;
        }
        $data = array(
            'comments_discount' => $discount,
            'comments_price' => round($price, 2)
        );
        echo json_encode($data);
    }


    public function confirm_comments_order()
    {


        $comment_list = $this->input->post('comment_list');
        $comments_type = $this->input->post('comments_type');
        $is_back = $this->input->post('is_back');

        if (isset($comment_list) || !empty($is_back)) {


            foreach ($comment_list as $commentsValue) {
                $comments_post[] = $commentsValue;
            }
            $comments_list = implode('<br/>', $comment_list);

            if ($comments_type == 'custom_comments') {

                $insert_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'comment_description' => $comments_list,
                    'comments_type' => 'custom_comments',
                );

                $this->common_model->insert_table('tbl_comments', $insert_data);

                $data['count_comments'] = $this->common_model->get_table_data('tbl_comments', 'Count(*) as comments_count', array('user_id' => $this->session->userdata('user_id'), 'comments_type' => 'custom_comments'));
                $data['comments_data'] = array(
                    'post_comments' => $this->input->post('post_comments'),
                    'instagram_url' => $this->input->post('instagram_url'),
                    'order_price' => $this->input->post('comments_price_value')
                );
                $this->common_model->delete_table('tbl_comments', array('user_id' => $this->session->userdata('user_id'), 'comments_type' => 'default_comments'));

            } else {

                $insert_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'comments_type' => 'default_comments',
                );

                $this->common_model->insert_table('tbl_comments', $insert_data);
                $this->common_model->delete_table('tbl_comments', array('user_id' => $this->session->userdata('user_id'), 'comments_type' => 'custom_comments'));
            }


            $custom_order_code = time() . uniqid();
            $comments_send = $this->input->post('post_comments');


            $package_setup_detail = $this->common_model->get_table_data('tbl_package_setup', '*');
            $comments_range_from = $package_setup_detail[0]['comments_range_from'];
            $comments_range_to = $package_setup_detail[0]['comments_range_to'];
            $comments_max_order = $package_setup_detail[0]['comments_max_order'];
            $comments_discount = $package_setup_detail[0]['comments_discount'];
            $comments_price = $package_setup_detail[0]['comments_price'];
            $total_price = $this->input->post('comments_price_value');


            $insert_data = array(
                'custom_order_code' => $custom_order_code,
                'order_price' => $total_price,
                'user_id' => $this->session->userdata('user_id'),
                'txn_type' => 'custom package',
                'instagram_url' => $this->input->post('instagram_url'),
                'dripfeed' => 'no',
                'tbl_dripfeed_id' => $this->input->post('tbl_dripfeed_id'),
                'order_qty' => $comments_send,
                'total_order_qty' => $comments_send,
                'package_name' => 'Comments',
                'order_name' => 'Comments',
                'dripfeed_date' => date('Y-m-d H:i:s'),
                'payment_status' => 'not confirmed',
            );


// echo '<pre>'; print_r($insert_data); echo '</pre>'; exit;

            $this->common_model->insert_table('tbl_custom_orders', $insert_data);
            $this->common_model->update_table('tbl_comments', array('custom_order_code' => $custom_order_code), array('user_id' => $this->session->userdata('user_id')));


            $data['confirm_order_detail'] = $this->common_model->get_table_data('tbl_custom_orders', '*', array('custom_order_code' => $custom_order_code));

            $this->load->view('common/header');
            $this->load->view('common/sidebar');
            $this->load->view('packages/confirm_custom_package', $data);
            $this->load->view('common/footer');


        } else {

            $post_comments = $this->input->post('comments');
            $instagram_url = $this->input->post('instagram_url');

            $data['count_comments'] = $this->common_model->get_table_data('tbl_comments', 'Count(*) as comments_count', array('user_id' => $this->session->userdata('user_id'), 'comments_type' => 'custom_comments'));

            $data['comments_data'] = array(
                'post_comments' => $post_comments,
                'instagram_url' => $instagram_url,
                'order_price' => $this->input->post('comments_price_value')

            );
            $this->load->view('common/header');
            $this->load->view('common/sidebar');
            $this->load->view('packages/add_custom_comments', $data);
            $this->load->view('common/footer');

        }


    }


    function confirmed_pay($custom_order_code)
    {
        $user_id = $this->session->userdata('user_id');
        $check_balance = $this->common_model->get_table_data('tbl_accounts', '*', array('user_id' => $user_id), $row = 1);
        $account_balance = $check_balance[0]['current_balance'];
        $order_id = $this->uri->segment(4);
        $data['confirm_order_detail'] = $this->common_model->get_table_data('tbl_custom_orders', '*', array('custom_order_code' => $custom_order_code));
        $confirmed_data = array(
            'order_id' => $data['confirm_order_detail'][0]['order_id'],
            'package_name' => $data['confirm_order_detail'][0]['package_name'],
            'order_price' => $data['confirm_order_detail'][0]['order_price'],
        );


        if ($account_balance >= $confirmed_data['order_price']) {

            $update_data = array(
                'payment_amount' => $confirmed_data['order_price'],
                'payment_status' => 'Completed',
                'payment_date' => date('Y-m-d H:i:s'),
            );

            $this->common_model->update_table('tbl_custom_orders', $update_data, array('custom_order_code' => $custom_order_code));
            $this->common_model->update_table('tbl_accounts', array('current_balance' => $account_balance - $confirmed_data['order_price']), array('user_id' => $user_id));


            $pkg_desc_mail = '<b>Package Includes:- </b> &nbsp;  ' . $data['confirm_order_detail'][0]['total_order_qty'] . ' ' . $data['confirm_order_detail'][0]['package_name'];


            $email_msg = '

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
<title>Respmail is a response HTML email designed to work on all major email platforms and smartphones</title>
<style type="text/css">
/* RESET STYLES */
html { background-color:#E1E1E1; margin:0; padding:0; }
body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif;}
table{border-collapse:collapse;}
table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
img, a img{border:0; outline:none; text-decoration:none;height:auto; line-height:100%;}
a {text-decoration:none !important;border-bottom: 1px solid;}
h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}

/* CLIENT-SPECIFIC STYLES */
.ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail/Outlook.com to display emails at full width. */
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} /* Force Hotmail/Outlook.com to display line heights normally. */
table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up. */
#outlook a{padding:0;} /* Force Outlook 2007 and up to provide a "view in browser" message. */
img{-ms-interpolation-mode: bicubic;display:block;outline:none; text-decoration:none;} /* Force IE to smoothly render resized images. */
body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; font-weight:normal!important;} /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */
.ExternalClass td[class="ecxflexibleContainerBox"] h3 {padding-top: 10px !important;} /* Force hotmail to push 2-grid sub headers down */


/* ========== Page Styles ========== */
h1{display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%;}
h2{display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%;}
h3{display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%;}
h4{display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%;}
p{ color: #ffffff}
.flexibleImage{height:auto;}
.linkRemoveBorder{border-bottom:0 !important;}
table[class=flexibleContainerCellDivider] {padding-bottom:0 !important;padding-top:0 !important;}

body, #bodyTable{background-color:#E1E1E1;}
#emailHeader{background-color:#E1E1E1;}
#emailBody{background-color:#FFFFFF;}
#emailFooter{background-color:#E1E1E1;}
.nestedContainer{background-color:#F8F8F8; border:1px solid #CCCCCC;}
.emailButton{background-color:#205478; border-collapse:separate;}
.buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}
.buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}
.emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}
.emailCalendarMonth{background-color:#205478; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}
.emailCalendarDay{color:#205478; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}
.imageContentText {margin-top: 10px;line-height:0;}
.imageContentText a {line-height:0;}
#invisibleIntroduction {display:none !important;} /* Removing the introduction text from the view */

/*FRAMEWORK HACKS & OVERRIDES */
span[class=ios-color-hack] a {color:#275100!important;text-decoration:none!important;} /* Remove all link colors in IOS (below are duplicates based on the color preference) */
span[class=ios-color-hack2] a {color:#205478!important;text-decoration:none!important;}
span[class=ios-color-hack3] a {color:#8B8B8B!important;text-decoration:none!important;}
/* A nice and clean way to target phone numbers you want clickable and avoid a mobile phone from linking other numbers that look like, but are not phone numbers.  Use these two blocks of code to "unstyle" any numbers that may be linked.  The second block gives you a class to apply with a span tag to the numbers you would like linked and styled.
Inspired by Campaign Monitor\'s article on using phone numbers in email: http://www.campaignmonitor.com/blog/post/3571/using-phone-numbers-in-html-email/.
*/
.a[href^="tel"], a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important;}
.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important;}


/* MOBILE STYLES */
@media only screen and (max-width: 480px){
/*////// CLIENT-SPECIFIC STYLES //////*/
body{width:100% !important; min-width:100% !important;} /* Force iOS Mail to render the email at full width. */


/*td[class="textContent"], td[class="flexibleContainerCell"] { width: 100%; padding-left: 10px !important; padding-right: 10px !important; }*/
table[id="emailHeader"],
table[id="emailBody"],
table[id="emailFooter"],
table[class="flexibleContainer"],
td[class="flexibleContainerCell"] {width:100% !important;}
td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table {display: block;width: 100%;text-align: left;}

td[class="imageContent"] img {height:auto !important; width:100% !important; max-width:100% !important; }
img[class="flexibleImage"]{height:auto !important; width:100% !important;max-width:100% !important;}
img[class="flexibleImageSmall"]{height:auto !important; width:auto !important;}



table[class="flexibleContainerBoxNext"]{padding-top: 10px !important;}


table[class="emailButton"]{width:100% !important;}
td[class="buttonContent"]{padding:0 !important;}
td[class="buttonContent"] a{padding:15px !important;}

}



@media only screen and (-webkit-device-pixel-ratio:.75){
/* Put CSS for low density (ldpi) Android layouts in here */
}

@media only screen and (-webkit-device-pixel-ratio:1){
/* Put CSS for medium density (mdpi) Android layouts in here */
}

@media only screen and (-webkit-device-pixel-ratio:1.5){
/* Put CSS for high density (hdpi) Android layouts in here */
}
/* end Android targeting */

/* CONDITIONS FOR IOS DEVICES ONLY
=====================================================*/
@media only screen and (min-device-width : 320px) and (max-device-width:568px) {

}
/* end IOS targeting */
</style>

<!--[if mso 12]>
<style type="text/css">
.flexibleContainer{display:block !important; width:100% !important;}
</style>
<![endif]-->
<!--[if mso 14]>
<style type="text/css">
.flexibleContainer{display:block !important; width:100% !important;}
</style>
<![endif]-->
</head>
<body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">







<div  border="0" cellpadding="0" cellspacing="0" width="500" id="emailHeader" align="center" style="background:#E1E1E1;  ">



<br><br>
<table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">


<tr>
<td align="center" valign="top">

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#3498db">
<tr>
<td align="center" valign="top">

<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
<tr>
<td align="center" valign="top" width="500" class="flexibleContainerCell">

<img src="http://webhorde.com/socialmediagainer/assets/img/gainer-sign-in-logo.png" alt="Social Media Gainer" class="front_logo" style="width: 60px; height: 55px; padding-top: 15px;" > 

<table border="0" cellpadding="30" cellspacing="0" width="100%">

<tr>
<td align="center" valign="top" class="textContent">
<div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#FFFFFF;line-height:135%;">


<span style="text-align: left"><b>Hi, (' . ucfirst($this->session->userdata('username')) . ') </b></span><br>

<p>
We are proud to announce that you have successfully purchased the custom package .  Thankyou for ordering your package, and we really hope you enjoy it!
</p>

<p>
' . $pkg_desc_mail . '
</p>



</div>
</td>
</tr>
</table>


</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>



<tr mc:hideable>
<td align="center" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" valign="top">
<table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
<tr>
<td valign="top" width="500" class="flexibleContainerCell" style="text-align: center; font-size: 13px;"> All The Best, <br> <span style="margin-top: 10px"><b>SocialMediaGainer</b></span></td>

</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>

</table>

<table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter">


<tr>
<td align="center" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
<tr>
<td align="center" valign="top" width="500" class="flexibleContainerCell">
<table border="0" cellpadding="30" cellspacing="0" width="100%">
<tr>
<td valign="top" bgcolor="#E1E1E1">

<div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
<div>Copyright &#169; 2018 <a href="http://www.webhorde.com/socialmediagainer/" target="_blank" style="text-decoration:none;color:#828282;"><span style="color:#828282;">SocialMediaGainer</span></a>. All&nbsp;rights&nbsp;reserved.</div>
<div>If you do not want to receive emails from us, you can <a href="#" target="_blank" style="text-decoration:none;color:#828282;"><span style="color:#828282;">unsubscribe</span></a>.</div>
</div>

</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>

</table>

</td>
</tr>
</div>

</body>
</html>
';


            $email_qry = $this->smtp_email->send('socialmediagainer@gmail.com', 'Social Media Gainer', $this->session->userdata('email'), 'Instagram Order Purchase', $email_msg);


            $this->session->set_flashdata('success_message', 'Package Purchased Successfully');
            redirect('dashboard');


        } else {
            $this->session->set_flashdata('funds_error', 'Funds Error');
            redirect('add_funds');

        }
    }

}