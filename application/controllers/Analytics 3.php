<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index() {
        is_user_in();
        $user_id = $this->session->userdata('user_id');
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $data['user_detail'] = $this->common_model->get_table_data('tbl_users','*', array('user_id' => $user_id));
        $this->load->view('analytics/analytics', $data);
        $this->load->view('common/footer');
    }

    public function search_account() {
        is_user_in();
        $user_id = $this->session->userdata('user_id');

        $search_type = $this->input->post('type');

        if(empty($search_type)) {
            $search_account = $this->input->post('instagram_name');
        } else{
            $search_account = $this->input->post('searched_account');
        }
        require 'vendor/autoload.php';
        $instagram_api = new \InstagramScraper\Instagram();
        $account = $instagram_api->getAccount($search_account);
        $is_private = 0;
        if(empty($search_type) && empty($account['error'])) {
            $is_private = $account->isPrivate();
        }
        if (empty($search_type) && !empty($account['error']) || $is_private == 1) {
            if(!empty($account['error'])) {
                $this->session->set_flashdata('error_message', 'Account with this username does not exist');
                redirect('analytics');
            }
            if(empty($account['error']) && $is_private == 1) {
                $this->session->set_flashdata('error_message', 'This Account is Private. <br> Please change your account status to use this resource.');
                redirect('analytics');
            }

        } else {
            $data['total_posts'] = $account->getMediaCount();
            $data['profile_pic'] = $account->getProfilePicUrl();
            $data['total_followesr'] = $account->getFollowsCount();
            $data['total_followed_by'] = $account->getFollowedByCount();
            $data['instagram_username'] = $account->getUsername();
            $data['instagram_profile_detail'] = $account->getBiography();

            $medias = $instagram_api->getMedias($search_account, 100);

            $newMonthArray = array();
            $newYearArray = array();
            if(count($medias) <= 99){
                $counter = count($medias);
            } else {
                $counter = 99;
            }
            for ($i = 0; $i <= $counter; $i++) {
                if (!empty($medias[$i])) {
                    $media = $medias[$i];
                    $postCode = $media['shortcode'];
                    $post_date = gmdate("Y-m-d H:i:s", $media['taken_at_timestamp']);

                    $post_likes = $media['edge_media_preview_like']['count'];
                    if(!empty($media['video_view_count'])) {
                        $post_views = $media['video_view_count'];
                    } else {
                        $post_views = 0;
                    }

                    $post_comments = $media['edge_media_to_comment']['count'];

                    $months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                    $month_data = array();
                    $given_month = date('M', strtotime($post_date));
                    $given_year = date('Y', strtotime($post_date));
                    for ($k = 0; $k <= 10; $k++) {
                        if ($months[$k] == $given_month && date('Y') == $given_year) {
                            $given_date = date('Y-m', strtotime($post_date));



                            if ($search_type == "likes") {
                                $month_data = array(
                                    'month' => $given_date,
                                    'total' => $post_likes,
                                    'avg' => number_format($post_likes / $counter, 2),
                                );

                            } else if ($search_type == "views") {
                                $month_data = array(
                                    'month' => $given_date,
                                    'total' => $post_views,
                                    'avg' => $post_views / $counter,

                                );
                            } else if ($search_type == "comments") {
                                $month_data = array(
                                    'month' => $given_date,
                                    'total' => $post_comments,
                                    'avg' => $post_comments / $counter,
                                );
                            } else {
                                $month_data = array(
                                    'month' => $given_date,
                                    'likes' => $post_likes,
                                    'views' => $post_views,
                                    'comments' => $post_comments,
                                );
                            }
                        }
                    }
                    $newMonthArray[] = $month_data;


                    $year = array();
                    $year_data = array();
                    $current_year = date('Y');
                    $max_year = $current_year + 10;
                    for ($c = 2010; $c <= $max_year; $c++) {
                        $year[$c] = $c;
                        if ($year[$c] == $given_year) {
                            $year_data = array(
                                'year' => $given_year,
                                'likes' => $post_likes,
                                'views' => $post_views,
                                'comments' => $post_comments,
                            );
                        }
                    }
                    $newYearArray[] = $year_data;
                }
            }


            $month_data = array();
            $month_analytics = array();

            if ($search_type == "likes") {
                foreach ($newMonthArray as $vals) {
                    if (!empty($vals['month']) && array_key_exists($vals['month'], $month_data)) {
                        $month_data[$vals['month']]['total'] += $vals['total'];
                        $month_data[$vals['month']]['avg'] += $vals['avg'];
                        $month_data[$vals['month']]['month'] = $vals['month'];
                    } else {
                        if (!empty($vals['month'])) {
                            $month_data[$vals['month']] = $vals;
                        }
                    }
                }
                foreach($month_data as $key => $value) {
                    $month_analytics[] = $value;
                }
                echo json_encode($month_analytics);
                exit;

            } else if ($search_type == "views") {
                foreach ($newMonthArray as $vals) {
                    if (!empty($vals['month']) && array_key_exists($vals['month'], $month_data)) {
                        $month_data[$vals['month']]['total'] += $vals['total'];
                        $month_data[$vals['month']]['avg'] += $vals['avg'];
                        $month_data[$vals['month']]['month'] = $vals['month'];
                    } else {
                        if (!empty($vals['month'])) {
                            $month_data[$vals['month']] = $vals;
                        }
                    }
                }
                foreach($month_data as $key => $value) {
                    $month_analytics[] = $value;
                }
                echo json_encode($month_analytics);
                exit;

            } else if ($search_type == "comments") {
                foreach ($newMonthArray as $vals) {
                    if (!empty($vals['month']) && array_key_exists($vals['month'], $month_data)) {
                        $month_data[$vals['month']]['total'] += $vals['total'];
                        $month_data[$vals['month']]['avg'] += $vals['avg'];
                        $month_data[$vals['month']]['month'] = $vals['month'];
                    } else {
                        if (!empty($vals['month'])) {
                            $month_data[$vals['month']] = $vals;
                        }
                    }
                }
                foreach($month_data as $key => $value) {
                    $month_analytics[] = $value;
                }
                echo json_encode($month_analytics);
                exit;

            } else {
                foreach ($newMonthArray as $vals) {
                    if (!empty($vals['month']) && array_key_exists($vals['month'], $month_data)) {
                        $month_data[$vals['month']]['likes'] += $vals['likes'];
                        $month_data[$vals['month']]['views'] += $vals['views'];
                        $month_data[$vals['month']]['comments'] += $vals['comments'];
                        $month_data[$vals['month']]['month'] = $vals['month'];
                    } else {
                        if (!empty($vals['month'])) {
                            $month_data[$vals['month']] = $vals;
                        }
                    }
                }
            }

            $year_data = array();
            foreach ($newYearArray as $vals) {
                if (array_key_exists($vals['year'], $year_data)) {
                    $year_data[$vals['year']]['likes'] += $vals['likes'];
                    $year_data[$vals['year']]['views'] += $vals['views'];
                    $year_data[$vals['year']]['comments'] += $vals['comments'];
                    $year_data[$vals['year']]['year'] = $vals['year'];
                } else {
                    $year_data[$vals['year']] = $vals;
                }
            }

        }

        $search_account_post = $this->input->post('instagram_name');
        $acc_search_data = $this->common_model->get_table_data('tbl_acc_search', '*', array('user_id' => $user_id, 'account_searched' => $search_account_post));
        if(count($acc_search_data) < 1) {

            $count_searchs = $this->common_model->get_table_data('tbl_users', '*', array('user_id' => $user_id));

            if($count_searchs[0]['total_acc_search'] <= 3) {
                $this->common_model->insert_table('tbl_acc_search', array('user_id' => $user_id, 'account_searched' => $search_account_post));
            }

            $total_searchs = $count_searchs[0]['total_acc_search'] + 1;
            $this->common_model->update_table('tbl_users', array('total_acc_search' => $total_searchs), 'user_id = ' . $user_id . '');

        }

        $data['month_analytics'] = $month_data;
        //$data['month_analytics_all_acc'] = $month_data;
        $data['year_analytics'] = $year_data;
        $data['searched_account'] = $this->input->post('instagram_name');


        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $data['user_detail'] = $this->common_model->get_table_data('tbl_users','*', array('user_id' => $user_id));
        $this->load->view('analytics/view_search_account', $data);
        $this->load->view('common/footer');

    }

    public function get_month_data() {

        $type = $this->input->post('type');
        $order_id = $this->input->post('order_id');
        $user_id = $this->session->userdata('user_id');
        $custom_orders = $this->common_model->custom_orders_analytics();

        $months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        $month_data = array();
        foreach ($custom_orders as $custom) {
            $given_month = date('M', strtotime($custom['given_date']));
            $given_year = date('Y', strtotime($custom['given_date']));

            for ($i = 0; $i <= 10; $i++) {
                if ($months[$i] == $given_month && date('Y') == $given_year) {
                    $given_date = date('Y-m', strtotime($custom['given_date']));
                    if (empty($order_id)) {
                        $count_likes = $this->db->query("SELECT SUM(given_likes) as total_likes, count(*) as total_posts FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_likes != ''")->result_array();
                        $total_likes = $count_likes[0]['total_likes'];
                        $total_likes_posts = $count_likes[0]['total_posts'];
                        $count_likes_pkg = $this->db->query("SELECT SUM(given_likes) as total_likes, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id'  AND given_likes != ''")->result_array();
                        $total_likes_pkg = $count_likes_pkg[0]['total_likes'];
                        $total_likes_posts_pkg = $count_likes_pkg[0]['total_posts'];
                        if ($total_likes_posts + $total_likes_posts_pkg != 0) {
                            $likes_avg = ($total_likes + $total_likes_pkg) / ($total_likes_posts + $total_likes_posts_pkg);
                        } else {
                            $likes_avg = 0;
                        }

                        $count_views = $this->db->query("SELECT SUM(given_views) as total_views, count(*) as total_posts FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_views != ''")->result_array();
                        $total_views = $count_views[0]['total_views'];
                        $total_views_posts = $count_views[0]['total_posts'];
                        $count_views_pkg = $this->db->query("SELECT SUM(given_views) as total_views, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_views != ''")->result_array();
                        $total_views_pkg = $count_views_pkg[0]['total_views'];
                        $total_views_posts_pkg = $count_views_pkg[0]['total_posts'];
                        if ($total_views_posts + $total_views_posts_pkg != 0) {
                            $views_avg = ($total_views + $total_views_pkg) / ($total_views_posts + $total_views_posts_pkg);
                        } else {
                            $views_avg = 0;
                        }

                        $count_comments = $this->db->query("SELECT SUM(given_comments) as total_comments, count(*) as total_posts FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_comments != ''")->result_array();
                        $total_comments = $count_comments[0]['total_comments'];
                        $total_comments_posts = $count_comments[0]['total_posts'];
                        $count_comments_pkg = $this->db->query("SELECT SUM(given_comments) as total_comments, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_comments != ''")->result_array();
                        $total_comments_pkg = $count_comments_pkg[0]['total_comments'];
                        $total_comments_posts_pkg = $count_comments_pkg[0]['total_posts'];
                        if ($total_comments_posts + $total_comments_posts_pkg != 0) {
                            $comments_avg = ($total_comments + $total_comments_pkg) / ($total_comments_posts + $total_comments_posts_pkg);
                        } else {
                            $comments_avg = 0;
                        }

                        $count_followers = $this->db->query("SELECT SUM(given_followers) as total_followers, count(*) as total_posts FROM tbl_custompackage_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_followers != ''")->result_array();
                        $total_followers = $count_followers[0]['total_followers'];
                        $total_followers_posts = $count_followers[0]['total_posts'];
                        $count_followers_pkg = $this->db->query("SELECT SUM(given_followers) as total_followers, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND given_followers != ''")->result_array();
                        $total_followers_pkg = $count_followers_pkg[0]['total_followers'];
                        $total_followers_posts_pkg = $count_followers_pkg[0]['total_posts'];
                        if ($total_followers_posts + $total_followers_posts_pkg != 0) {
                            $followers_avg = ($total_followers + $total_followers_pkg) / ($total_followers_posts + $total_followers_posts_pkg);
                        } else {
                            $followers_avg = 0;
                        }

                    } else {

                        $count_likes_pkg = $this->db->query("SELECT SUM(given_likes) as total_likes, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND tbl_order_id = '$order_id' AND given_likes != ''")->result_array();
                        $total_likes_pkg = $count_likes_pkg[0]['total_likes'];
                        $total_likes_posts_pkg = $count_likes_pkg[0]['total_posts'];
                        if ($total_likes_posts_pkg != 0) {
                            $likes_avg = $total_likes_pkg / $total_likes_posts_pkg;
                        } else {
                            $likes_avg = 0;
                        }

                        $count_views_pkg = $this->db->query("SELECT SUM(given_views) as total_views, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND tbl_order_id = '$order_id' AND given_views != ''")->result_array();
                        $total_views_pkg = $count_views_pkg[0]['total_views'];
                        $total_views_posts_pkg = $count_views_pkg[0]['total_posts'];
                        if ($total_views_posts_pkg != 0) {
                            $views_avg = $total_views_pkg / $total_views_posts_pkg;
                        } else {
                            $views_avg = 0;
                        }

                        $count_comments_pkg = $this->db->query("SELECT SUM(given_comments) as total_comments, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND tbl_order_id = '$order_id' AND given_comments != ''")->result_array();
                        $total_comments_pkg = $count_comments_pkg[0]['total_comments'];
                        $total_comments_posts_pkg = $count_comments_pkg[0]['total_comments'];
                        if ($total_comments_posts_pkg != 0) {
                            $comments_avg = $total_comments_pkg / $total_comments_posts_pkg;
                        } else {
                            $comments_avg = 0;
                        }

                        $count_followers_pkg = $this->db->query("SELECT SUM(given_followers) as total_followers, count(*) as total_posts FROM tbl_package_status WHERE given_date LIKE '%$given_date%' AND user_id = '$user_id' AND tbl_order_id = '$order_id' AND given_followers != ''")->result_array();
                        $total_followers_pkg = $count_followers_pkg[0]['total_followers'];
                        $total_followers_posts_pkg = $count_followers_pkg[0]['total_followers'];
                        if ($total_followers_posts_pkg != 0) {
                            $followers_avg = $total_followers_pkg / $total_followers_posts_pkg;
                        } else {
                            $followers_avg = 0;
                        }

                        $total_likes = 0;
                        $total_views = 0;
                        $total_comments = 0;
                        $total_followers = 0;
                    }


                    if ($type == "likes") {
                        $month_data[$given_date] = array(
                            'month' => $given_date,
                            'total' => $total_likes + $total_likes_pkg,
                            'avg' => number_format($likes_avg, 2),
                        );

                    } else if ($type == "views") {
                        $month_data[$given_date] = array(
                            'month' => $given_date,
                            'total' => $total_views + $total_views_pkg,
                            'avg' => number_format($views_avg, 2),
                        );
                    } else if ($type == "comments") {
                        $month_data[$given_date] = array(
                            'month' => $given_date,
                            'total' => $total_comments + $total_comments_pkg,
                            'avg' => number_format($comments_avg, 2),
                        );
                    } else if ($type == "followers") {
                        $month_data[$given_date] = array(
                            'month' => $given_date,
                            'total' => $total_followers + $total_followers_pkg,
                            'avg' => number_format($followers_avg, 2),
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
        foreach ($month_data as $key => $value) {
            $month_analytics[] = $value;
        }

        echo json_encode($month_analytics);

        exit;

        if (count($month_analytics) == 0) {
            echo '[{"month":2018-02","total":713,"avg":"237.67"}]';
        } else {
            echo json_encode($month_analytics);

        }
    }

}