<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller {


function __construct() {
    parent::__construct();

}



public function index() {

    $user_id = $this->session->userdata('user_id');
    $custom_orders = $this->common_model->custom_orders_analytics();

    //echo '<pre>'; print_r($custom_orders); echo '</pre>'; exit;
    $months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    $month_data = array();
    foreach($custom_orders as $custom) {






        $given_month = date('M', strtotime($custom['given_date']));
        $given_year= date('Y', strtotime($custom['given_date']));


        for($i = 0; $i <= 10; $i++) {
            if($months[$i] == $given_month && date('Y') == $given_year) {

                $given_date = date('Y-m', strtotime($custom['given_date']));

                $count_likes = $this->db->query("SELECT SUM(given_likes) as total_likes FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                $total_likes = $count_likes[0]['total_likes'];
                $count_likes_pkg = $this->db->query("SELECT SUM(given_likes) as total_likes FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                $total_likes_pkg  = $count_likes_pkg[0]['total_likes'];

                $count_views = $this->db->query("SELECT SUM(given_views) as total_views FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                $total_views = $count_views[0]['total_views'];
                $count_views_pkg  = $this->db->query("SELECT SUM(given_views) as total_views FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                $total_views_pkg  = $count_views_pkg[0]['total_views'];

                $count_comments = $this->db->query("SELECT SUM(given_comments) as total_comments FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                $total_comments = $count_comments[0]['total_comments'];
                $count_comments_pkg  = $this->db->query("SELECT SUM(given_comments) as total_comments FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                $total_comments_pkg  = $count_comments_pkg[0]['total_comments'];

                $count_followers = $this->db->query("SELECT SUM(given_followers) as total_followers FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                $total_followers = $count_followers[0]['total_followers'];
                $count_followers_pkg  = $this->db->query("SELECT SUM(given_followers) as total_followers FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                $total_followers_pkg  = $count_followers_pkg[0]['total_followers'];


                $month_data[$given_date] = array(
                        'month' => $given_date,
                        'likes' => $total_likes + $total_likes_pkg,
                        'views' => $total_views + $total_views_pkg,
                        'comments' => $total_comments + $total_comments_pkg,
                        'followers' => $total_followers + $total_followers_pkg
                    );
            }

        }

    }








    $year = array();
    $year_data = array();
    foreach($custom_orders as $custom) {

                $given_date = date('Y', strtotime($custom['given_date']));
                $current_year = date('Y');
                $max_year = $current_year + 10;
                for($i = $current_year; $i <= $max_year; $i++) {
                    $year[$i] = $i;
                    if ($year[$i] == $given_date) {



                        $count_likes = $this->db->query("SELECT SUM(given_likes) as total_likes FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                        $total_likes = $count_likes[0]['total_likes'];
                        $count_likes_pkg = $this->db->query("SELECT SUM(given_likes) as total_likes FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                        $total_likes_pkg = $count_likes_pkg[0]['total_likes'];

                        $count_views = $this->db->query("SELECT SUM(given_views) as total_views FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                        $total_views = $count_views[0]['total_views'];
                        $count_views_pkg = $this->db->query("SELECT SUM(given_views) as total_views FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                        $total_views_pkg = $count_views_pkg[0]['total_views'];

                        $count_comments = $this->db->query("SELECT SUM(given_comments) as total_comments FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                        $total_comments = $count_comments[0]['total_comments'];
                        $count_comments_pkg = $this->db->query("SELECT SUM(given_comments) as total_comments FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                        $total_comments_pkg = $count_comments_pkg[0]['total_comments'];

                        $count_followers = $this->db->query("SELECT SUM(given_followers) as total_followers FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                        $total_followers = $count_followers[0]['total_followers'];
                        $count_followers_pkg = $this->db->query("SELECT SUM(given_followers) as total_followers FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'")->result_array();
                        $total_followers_pkg = $count_followers_pkg[0]['total_followers'];


                        $year_data[$given_date] = array(
                            'year' => $given_date,
                            'likes' => $total_likes + $total_likes_pkg,
                            'views' => $total_views + $total_views_pkg,
                            'comments' => $total_comments + $total_comments_pkg,
                            'followers' => $total_followers + $total_followers_pkg
                        );

                    }


                }

    }



    is_user_in();
    $this->load->view('common/header');
    $this->load->view('common/sidebar');
    $data['user_detail'] = $this->db->query("SELECT * FROM tbl_orders WHERE user_id = '$user_id'")->result_array();
    $data['month_analytics'] = $month_data;
    $data['month_analytics_all_acc'] = $month_data;
    $data['year_analytics'] = $year_data;
    $this->load->view('analytics/analytics' , $data);
    $this->load->view('common/footer');
}











     public function get_month_data() {


         $type = $this->input->post('type');
         $order_id = $this->input->post('order_id');
         $user_id = $this->session->userdata('user_id');
         $custom_orders = $this->common_model->custom_orders_analytics();


         $months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
         $month_data = array();
         foreach($custom_orders as $custom) {

             $given_month = date('M', strtotime($custom['given_date']));
             $given_year= date('Y', strtotime($custom['given_date']));

             for($i = 0; $i <= 10; $i++) {
                 if($months[$i] == $given_month && date('Y') == $given_year) {

                     $given_date = date('Y-m', strtotime($custom['given_date']));

                     if(empty($order_id)) {

                         $count_likes = $this->db->query("SELECT SUM(given_likes) as total_likes, count(*) as total_posts FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_likes != ''")->result_array();
                         $total_likes = $count_likes[0]['total_likes'];
                         $total_likes_posts  = $count_likes[0]['total_posts'];
                         $count_likes_pkg = $this->db->query("SELECT SUM(given_likes) as total_likes, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'  AND given_likes != ''")->result_array();
                         $total_likes_pkg  = $count_likes_pkg[0]['total_likes'];
                         $total_likes_posts_pkg  = $count_likes_pkg[0]['total_posts'];
                         if($total_likes_posts + $total_likes_posts_pkg != 0) {
                             $likes_avg = ($total_likes + $total_likes_pkg) / ($total_likes_posts + $total_likes_posts_pkg);
                         } else {
                             $likes_avg = 0;
                         }

                         $count_views = $this->db->query("SELECT SUM(given_views) as total_views, count(*) as total_posts FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_views != ''")->result_array();
                         $total_views = $count_views[0]['total_views'];
                         $total_views_posts  = $count_views[0]['total_posts'];
                         $count_views_pkg  = $this->db->query("SELECT SUM(given_views) as total_views, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_views != ''")->result_array();
                         $total_views_pkg  = $count_views_pkg[0]['total_views'];
                         $total_views_posts_pkg  = $count_views_pkg[0]['total_posts'];
                         if($total_views_posts + $total_views_posts_pkg != 0) {
                             $views_avg = ($total_views + $total_views_pkg) / ($total_views_posts + $total_views_posts_pkg);
                         } else {
                             $views_avg = 0;
                         }

                         $count_comments = $this->db->query("SELECT SUM(given_comments) as total_comments, count(*) as total_posts FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_comments != ''")->result_array();
                         $total_comments = $count_comments[0]['total_comments'];
                         $total_comments_posts  = $count_comments[0]['total_posts'];
                         $count_comments_pkg  = $this->db->query("SELECT SUM(given_comments) as total_comments, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_comments != ''")->result_array();
                         $total_comments_pkg  = $count_comments_pkg[0]['total_comments'];
                         $total_comments_posts_pkg  = $count_comments_pkg[0]['total_posts'];
                         if($total_comments_posts + $total_comments_posts_pkg != 0) {
                             $comments_avg = ($total_comments + $total_comments_pkg) / ($total_comments_posts + $total_comments_posts_pkg);
                         } else {
                             $comments_avg = 0;
                         }

                         $count_followers = $this->db->query("SELECT SUM(given_followers) as total_followers, count(*) as total_posts FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_followers != ''")->result_array();
                         $total_followers = $count_followers[0]['total_followers'];
                         $total_followers_posts  = $count_followers[0]['total_posts'];
                         $count_followers_pkg  = $this->db->query("SELECT SUM(given_followers) as total_followers, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_followers != ''")->result_array();
                         $total_followers_pkg  = $count_followers_pkg[0]['total_followers'];
                         $total_followers_posts_pkg  = $count_followers_pkg[0]['total_posts'];
                         if($total_followers_posts + $total_followers_posts_pkg != 0) {
                             $followers_avg = ($total_followers + $total_followers_pkg) / ($total_followers_posts + $total_followers_posts_pkg);
                         } else {
                             $followers_avg = 0;
                         }

                     } else {

                         $count_likes_pkg = $this->db->query("SELECT SUM(given_likes) as total_likes, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND tbl_order_id = '$order_id' AND given_likes != ''")->result_array();
                         $total_likes_pkg  = $count_likes_pkg[0]['total_likes'];
                         $total_likes_posts_pkg  = $count_likes_pkg[0]['total_posts'];
                         if($total_likes_posts_pkg != 0) {
                             $likes_avg = $total_likes_pkg / $total_likes_posts_pkg;
                         } else {
                             $likes_avg = 0;
                         }

                         $count_views_pkg  = $this->db->query("SELECT SUM(given_views) as total_views, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND tbl_order_id = '$order_id' AND given_views != ''")->result_array();
                         $total_views_pkg  = $count_views_pkg[0]['total_views'];
                         $total_views_posts_pkg  = $count_views_pkg[0]['total_posts'];
                         if($total_views_posts_pkg != 0) {
                             $views_avg = $total_views_pkg / $total_views_posts_pkg;
                         } else {
                             $views_avg = 0;
                         }

                         $count_comments_pkg  = $this->db->query("SELECT SUM(given_comments) as total_comments, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND tbl_order_id = '$order_id' AND given_comments != ''")->result_array();
                         $total_comments_pkg  = $count_comments_pkg[0]['total_comments'];
                         $total_comments_posts_pkg  = $count_comments_pkg[0]['total_comments'];
                         if($total_comments_posts_pkg != 0) {
                             $comments_avg = $total_comments_pkg / $total_comments_posts_pkg;
                         } else {
                             $comments_avg = 0;
                         }

                         $count_followers_pkg  = $this->db->query("SELECT SUM(given_followers) as total_followers, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND tbl_order_id = '$order_id' AND given_followers != ''")->result_array();
                         $total_followers_pkg  = $count_followers_pkg[0]['total_followers'];
                         $total_followers_posts_pkg  = $count_followers_pkg[0]['total_followers'];
                         if($total_followers_posts_pkg != 0) {
                             $followers_avg = $total_followers_pkg / $total_followers_posts_pkg;
                         } else {
                             $followers_avg = 0;
                         }

                         $total_likes = 0;
                         $total_views = 0;
                         $total_comments = 0;
                         $total_followers = 0;
                     }




                     if($type == "likes") {
                         $month_data[$given_date] = array(
                             'month' => $given_date,
                             'total' => $total_likes + $total_likes_pkg,
                             'avg' => number_format($likes_avg,2),
                         );

                     }

                     else if($type == "views") {
                         $month_data[$given_date] = array(
                             'month' => $given_date,
                             'total' =>  $total_views + $total_views_pkg,
                             'avg' => number_format($views_avg,2),
                         );
                     }

                     else if($type == "comments") {
                         $month_data[$given_date] = array(
                             'month' => $given_date,
                             'total' =>  $total_comments + $total_comments_pkg,
                             'avg' => number_format($comments_avg,2),
                         );
                     }

                     else if($type == "followers") {
                         $month_data[$given_date] = array(
                             'month' => $given_date,
                             'total' =>  $total_followers + $total_followers_pkg,
                             'avg' => number_format($followers_avg,2),
                         );
                     } else {
                         $month_data[$given_date] = array(
                             'month' => $given_date,
                             'likes' => $total_likes + $total_likes_pkg,
                             'views' => $total_views + $total_views_pkg,
                             'comments' => $total_comments + $total_comments_pkg,
                             'followers' => $total_followers + $total_followers_pkg
                         );
                     }







                 }

             }

         }

       $month_analytics = array();
       foreach($month_data as $key => $value) {
           $month_analytics[] = $value;
         }

         echo json_encode($month_analytics);

       exit;

         if(count($month_analytics) == 0) {
             echo '[{"month":2018-02","total":713,"avg":"237.67"}]';
         } else {
             echo json_encode($month_analytics);

         }
     }









}