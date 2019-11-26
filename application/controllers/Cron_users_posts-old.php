<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_users_posts extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $featured_orders = $this->common_model->get_featured_orders();

        require 'vendor/autoload.php';
        $instagram_api = new \InstagramScraper\Instagram();


        foreach ($featured_orders as $featured_order) {


            $count_posts = $this->common_model->get_table_data('tbl_posts','count(*) as total_posts', array('tbl_order_id' => $featured_order['order_id']));
            $total_posts = $count_posts[0]['total_posts'];

            $featured_posts = $this->common_model->get_featured_posts($featured_order['order_id']);

            $username = $featured_order['instagram_name'];
            $order_id = $featured_order['order_id'];
            $order_date = $featured_order['payment_date'];
            $order_status = $featured_order['order_status'];
            $medias = $instagram_api->getMedias($username, $total_posts);

            $count = 1;

            for ($i = 0; $i <= $total_posts - 1; $i++) {

                if (!empty($medias[$i])) {
                    $media = $medias[$i];

                    $post_id = $media->getId();
                    $postCode = $media->getShortCode();

                    $post_date = gmdate("Y-m-d H:i:s", $media->getCreatedTime());

                    echo $post_date . ' --and--' . $order_date . ' -----and----- ' . $postCode . '<br><br><bR>';

                    if ($post_date >= $order_date) {

                        if ($post_date < $order_date) {
                            unset($medias[$i]);
                            array_values($medias);
                        }

                        echo $post_date.  ' ++and++ ' . $postCode . '  +++ and+++ '  . $count . '<br><br><br><bR>';

                        $k = $i;

                        echo  $count. '..........';

                      //  exit;
                        $check_post = $this->common_model->get_table_data('tbl_posts', '*', array('post_code' => $postCode, 'tbl_order_id' => $featured_posts[$count]['tbl_order_id']));

                        echo '<pre>'; print_r($check_post); echo '</pre>';

                        if(count($check_post) < 1) {
                            if ($featured_posts[$count]['post_code'] == '') {

                            }
                        }
                        $count++;

                    }
                }
            }

        }

    }
















}