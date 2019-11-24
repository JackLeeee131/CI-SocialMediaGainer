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



           // echo '<pre>'; print_r($medias); echo '</pre>';

            for ($i = 0; $i <= $total_posts - 1; $i++) {


                if (!empty($medias[$i])) {
                    $media = $medias[$i];


                    $post_id = $media->getId();
                    $postCode = $media->getShortCode();

                    $post_date = gmdate("Y-m-d H:i:s", $media->getCreatedTime());
                    //$post_date = $media->getCreatedTime();

                    echo $post_date . ' --and--' . $order_date . ' -----and----- ' . $postCode . '<br><br><bR>';

                    if ($post_date >= $order_date) {

                        if ($post_date < $order_date) {
                            unset($medias[$i]);
                            array_values($medias);
                        }


                        //echo '<pre>'; print_r($featured_posts); echo '</pre>';
                        // echo $post_date  .' ++and++ ' . $order_

                        echo $post_date.  ' ++and++ ' . $postCode . '  +++ and+++ '  . $count . '<br><br><br><bR>';

                        $k = $i;

                        echo  $count. '..........';

                      //  exit;
                        $check_post = $this->common_model->get_table_data('tbl_posts', '*', array('post_code' => $postCode, 'tbl_order_id' => $featured_posts[$count]['tbl_order_id']));

                        echo '<pre>'; print_r($check_post); echo '</pre>';


                       // echo count($check_post). '///<br>';
                        if(count($check_post) < 1) {



                            if ($featured_posts[$count]['post_code'] == '') {




                                //echo '<pre>'; print_r($featured_posts[$count]); echo '</pre>'; exit;

                                //

                                // echo $postCode . '****';
                                //$this->db->limit(1);
                                // $this->db->where(array('tbl_order_id' => $order_id,  'post_code' => null, 'post_status' => 'Featured'));
                                //$this->db->update('tbl_posts', array('post_code' => $postCode));


                                //echo $post_date  .' and ' . $order_date.  ' and ' . $i . '<br>';
                                //echo $featured_posts[$i]['tbl_order_id']. ' ...--.. ';
                                //$this->common_model->update_table('tbl_posts', array('post_code' => $postCode), array('tbl_order_id' => $order_id,  'post_code' => null, 'post_status' => 'Featured'), $limit = 1);
                                //echo $postCode . ' ...--.. ' . $i;

                            }
                        }
                        $count++;

                    }
                }



                // echo '<pre>'; print_r($featured_posts); echo '</pre>';
               // echo $i. '<br>';



            }


        }



    }
















}