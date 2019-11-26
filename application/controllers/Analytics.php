<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller
{
    function __construct() {
        parent::__construct();
    }

    public function index() {
        is_user_in();
        $user_id = $this->session->userdata('user_id');
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $data['user_detail'] = $this->common_model->get_table_data('tbl_users', '*', array('user_id' => $user_id));
        $this->load->view('analytics/analytics', $data);
        $this->load->view('common/footer');
    }

    public function search_account() {
        date_default_timezone_set('Asia/Karachi');
        is_user_in();
        $user_id = $this->session->userdata('user_id');

        $search_type = $this->input->post('type');

        if (empty($search_type)) {
            $search_account = $this->input->post('instagram_name');
        } else {
            $search_account = $this->input->post('searched_account');
        }

        require 'vendor/autoload.php';
        $instagram_api = new \InstagramScraper\Instagram();
        $account = $instagram_api->getAccount($search_account);

        $is_private = 0;
        if (empty($search_type) && empty($account['error'])) {
            $is_private = $account->isPrivate();
        }

        if (empty($search_type) && !empty($account['error']) || $is_private == 1) {
            if (!empty($account['error'])) {
                $this->session->set_flashdata('error_message', 'Account with this username does not exist');
                redirect('analytics');
            }

            if (empty($account['error']) && $is_private == 1) {
                $this->session->set_flashdata('error_message', 'This Account is Private. <br> Please change your account status to use this resource.');
                redirect('analytics');
            }
        } else {
           $medias = $instagram_api->getMediasAnalytics($search_account, 100);

            $newMonthArray = array();
            $newYearArray = array();
            $counter = 12;
            $count_posts = 1;
            for ($i = 0; $i <= $counter; $i++) {
                if (!empty($medias['edge_owner_to_timeline_media']['edges'][$i]['node'])) {
                    $media = $medias['edge_owner_to_timeline_media']['edges'][$i]['node'];

                    $postCode = $media['shortcode'];
                    $post_date = date("Y-m-d H:i:s", $media['taken_at_timestamp']);

                    $post_likes = $media['edge_media_preview_like']['count'];
                    if (!empty($media['video_view_count'])) {
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
                            $given_date = date('F', strtotime($post_date));

                            if ($search_type == "likes") {
                                $month_data = array(
                                    'month' => $given_date,
                                    'total' => $post_likes,
                                    'Total Posts' => $count_posts,
                                    'Average Likes' => '',
                                );
                            } else if ($search_type == "comments") {
                                $month_data = array(
                                    'month' => $given_date,
                                    'total' => $post_comments,
                                    'Total Posts' => $count_posts,
                                    'Average Comments' => '',
                                );
                            } else {
                                $month_data = array(
                                    'month' => $given_date,
                                    'likes' => $post_likes,
                                    'views' => $post_views,
                                    'comments' => $post_comments,
                                    'Total Posts' => $count_posts,
                                    'Average Engagements' => '',

                                );
                            }
                        }
                    }

                    $newMonthArray[] = $month_data;
                }
            }


            $month_data = array();
            $month_analytics = array();

            if ($search_type == "likes") {
                foreach ($newMonthArray as $vals) {
                    if (!empty($vals['month']) && array_key_exists($vals['month'], $month_data)) {
                        $month_data[$vals['month']]['total'] += $vals['total'];
                        $month_data[$vals['month']]['month'] = $vals['month'];
                        $month_data[$vals['month']]['Total Posts'] += $vals['Total Posts'];
                        $month_data[$vals['month']]['Average Likes'] = number_format($month_data[$vals['month']]['total'] / $month_data[$vals['month']]['Total Posts']);
                    } else {
                        if (!empty($vals['month'])) {
                            $month_data[$vals['month']] = $vals;
                        }
                    }
                }
                foreach ($month_data as $key => $value) {
                    $month_analytics[] = $value;
                }

                echo json_encode(array_reverse($month_analytics));
                exit;
            } else if ($search_type == "comments") {
                foreach ($newMonthArray as $vals) {
                    if (!empty($vals['month']) && array_key_exists($vals['month'], $month_data)) {
                        $month_data[$vals['month']]['total'] += $vals['total'];
                        $month_data[$vals['month']]['month'] = $vals['month'];
                        $month_data[$vals['month']]['Total Posts'] += $vals['Total Posts'];
                        $month_data[$vals['month']]['Average Likes'] = number_format($month_data[$vals['month']]['total'] / $month_data[$vals['month']]['Total Posts']);
                    } else {
                        if (!empty($vals['month'])) {
                            $month_data[$vals['month']] = $vals;
                        }
                    }
                }
                foreach ($month_data as $key => $value) {
                    $month_analytics[] = $value;
                }
                echo json_encode(array_reverse($month_analytics));
                exit;
            } else {
                foreach ($newMonthArray as $vals) {
                    if (!empty($vals['month']) && array_key_exists($vals['month'], $month_data)) {
                        $month_data[$vals['month']]['likes'] += $vals['likes'];
                        $month_data[$vals['month']]['views'] += $vals['views'];
                        $month_data[$vals['month']]['comments'] += $vals['comments'];
                        $month_data[$vals['month']]['Total Posts'] += $vals['Total Posts'];

                        $month_data[$vals['month']]['Average Engagements'] = number_format(($month_data[$vals['month']]['likes'] + $month_data[$vals['month']]['comments']) / $month_data[$vals['month']]['Total Posts']);

                        $month_data[$vals['month']]['month'] = $vals['month'];
                    } else {
                        if (!empty($vals['month'])) {
                            $month_data[$vals['month']] = $vals;
                            $month_data[$vals['month']]['Average Engagements'] = number_format(($month_data[$vals['month']]['likes'] + $month_data[$vals['month']]['comments']) / $month_data[$vals['month']]['Total Posts']);
                        }
                    }
                }
            }
        }

        $search_account_post = $this->input->post('instagram_name');
        $acc_search_data = $this->common_model->get_table_data('tbl_acc_search', '*', array('user_id' => $user_id, 'account_searched' => $search_account_post));
        if (count($acc_search_data) < 1) {
            $count_searchs = $this->common_model->get_table_data('tbl_users', '*', array('user_id' => $user_id));

            if ($count_searchs[0]['total_acc_search'] <= 3) {
                $this->common_model->insert_table('tbl_acc_search', array('user_id' => $user_id, 'account_searched' => $search_account_post));
            }

            $total_searchs = $count_searchs[0]['total_acc_search'] + 1;
            $this->common_model->update_table('tbl_users', array('total_acc_search' => $total_searchs), 'user_id = ' . $user_id . '');
        }

        $total_count_likes = 0;
        $total_count_views = 0;
        $total_count_comments = 0;
        foreach ($month_data as $data) {
            $total_count_likes += $data['likes'];
            $total_count_views += $data['views'];
            $total_count_comments += $data['comments'];
        }

        $data['total_posts'] = $account->getMediaCount();
        $data['profile_pic'] = $account->getProfilePicUrl();
        $data['total_followers'] = $account->getFollowsCount();
        $data['total_followed_by'] = $account->getFollowedByCount();
        $data['instagram_username'] = $account->getUsername();
        $data['instagram_profile_detail'] = $account->getBiography();

        $data['instagram_data'] = array(
            'total_likes' => $total_count_likes,
            'avg_likes' => $total_count_likes / $data['total_posts'],
            'total_views' => $total_count_views,
            'avg_views' => $total_count_views / $data['total_posts'],
            'total_comments' => $total_count_comments,
            'avg_comments' => $total_count_comments / $data['total_posts'],
        );

        uksort($month_data, function ($a1, $a2) {
            $time1 = strtotime($a1);
            $time2 = strtotime($a2);

            return $time1 - $time2;
        });

        $default_data = array();
        $new_data = array();

        foreach ($month_data as $val) {
            $default_data[$val['month']] = $val;
            unset($val['likes']);
            unset($val['views']);
            unset($val['comments']);
            $new_data[$val['month']] = $val;
        }


        $data['month_analytics'] = $month_data;
        $data['searched_account'] = $this->input->post('instagram_name');

        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $data['user_detail'] = $this->common_model->get_table_data('tbl_users', '*', array('user_id' => $user_id));
        $this->load->view('analytics/view_search_account', $data);
        $this->load->view('common/footer');
    }
}