<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('max_execution_time', 0);


class Cron_users_posts extends CI_Controller
{
    function __construct() {
        parent::__construct();
    }


    public function index() {
        /*


                function scrape_insta($username) {
                    $insta_source = file_get_contents('http://instagram.com/'.$username);
                    $shards = explode('window._sharedData = ', $insta_source);
                    $insta_json = explode(';</script>', $shards[1]);
                    $insta_array = json_decode($insta_json[0], TRUE);
                    return $insta_array;
                }
        //Supply a username
                $my_account = 'cosmocatalano';
        //Do the deed
                $results_array = scrape_insta($my_account);

                echo '<pre>'; print_r($results_array); echo '</pre>'; exit;

        //An example of where to go from there
                $latest_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'][0];
                echo 'Latest Photo:<br/>';
                echo '<a href="http://instagram.com/p/'.$latest_array['code'].'"><img src="'.$latest_array['display_src'].'"></a></br>';
                echo 'Likes: '.$latest_array['likes']['count'].' - Comments: '.$latest_array['comments']['count'].'<br/>';
        */

        //exit('exittttttt');

        $featured_orders = $this->common_model->get_featured_orders();
        //require 'vendor/autoload.php';
        //$instagram_api = new \InstagramScraper\Instagram();


        $count = 0;
        $medias_count = 12;
        $array = array();

        foreach ($featured_orders as $featured_order) {
            $count_posts = $this->common_model->get_table_data('tbl_posts', 'count(*) as total_posts', array('tbl_order_id' => $featured_order['order_id']));
            $total_posts = $count_posts[0]['total_posts'];

            $username = $featured_order['instagram_name'];
            $order_id = $featured_order['order_id'];
            $order_date = $featured_order['status_change_date'];
            $order_status = $featured_order['order_status'];



            $medias = array();
            $doc = new DOMDocument();
            $doc->loadHTML(implode("",file('https://www.instagram.com/'.$username.'/')));
            $jsNodes = $doc->getElementsByTagName("script");
            $jsNodeTmp = "";
            foreach($jsNodes as $node){
                if(strpos($node->nodeValue,"window._sharedData")!==false){
                    $jsNodeTmp = $node->nodeValue;
                    break;
                }
            }
            $medias = array();
            if($jsNodeTmp){
                $jsNodeTmp = trim(str_replace("window._sharedData","",$jsNodeTmp)," ;=");
                $json = json_decode($jsNodeTmp);
                $jsonMedia = $json->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media->edges;
                foreach($jsonMedia as $jsonMediaItem){
                    if(count($medias) < $medias_count)
                        $medias[] = (array)$jsonMediaItem;
                }
            }



            //$medias = $instagram_api->getMedias($username, 30);



            //echo '<pre>'; print_r($medias); echo '</pre>';




            for ($i = 0; $i <= $total_posts; $i++) {
                if (!empty($medias[$i])) {
                    $media = (array) $medias[$i]['node'];
                    $postCode = $media['shortcode'];
                    $post_date = gmdate("Y-m-d H:i:s", $media['taken_at_timestamp']);
                    if ($post_date >= $order_date) {
                        $arr = array();
                        $arr = $media;

                        $arr['order_data'] = $featured_order;
                        $array[] = $arr;
                        // $array[][$i] = $featured_order;
                        // $array[] = $featured_order;
                        // $array[] = $arr2;
                        // $array[$i]['data'] = $featured_order;
                        // $array[]['order_data'] = $featured_order;
                    }
                }
            }

            //

            $count++;
        }

        $data = array_reverse($array);


        foreach ($data as $key => $media_data) {
            //$featured_posts = $this->common_model->get_featured_posts($media_data[0]['order_id']);

            $postCode = $media_data['shortcode'];
            $order_id = $media_data['order_data']['order_id'];
            $check_post = $this->common_model->get_table_data('tbl_posts', '*', array('post_code' => $postCode, 'tbl_order_id' => $order_id));

            if (count($check_post) < 1) {
                // echo $postCode . '****';
                $this->db->limit(1);
                $this->db->where(array('tbl_order_id' => $order_id, 'post_code' => null, 'post_status' => 'Featured'));
                $this->db->update('tbl_posts', array('post_code' => $postCode));
            }
        }
    }
}