<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller {


function __construct() {
    parent::__construct();

}

public function index() {
    require 'vendor/autoload.php';

    $username =  'abdul';
    $instagram = new \InstagramScraper\Instagram();
    $medias = $instagram->getMedias($username, 31);


    $total_posts = 0;
    $total_likes = 0;
    $total_comments = 0;

    $arr = array();
    $i=0;
    foreach($medias as $key => $media) {
        $post_id = $media->getId();
        $post_code = $media->getShortCode();
        $post_pic_url = $media->getImageHighResolutionUrl();
        $likes = $media->getLikesCount();
        $comments = $media->getCommentsCount();
        $post_type = $media->getType();
        $created_at = date('Y-m', $media->getCreatedTime());

        $total_posts = count($key);
        $total_likes +=  $likes;
        $total_comments +=  $comments;

        $arr['post_data'][$i]["date"] =  $created_at;
        $arr['post_data'][$i]["likes"] =  $likes;
        $arr['post_data'][$i]["avg_likes"] =  0;
        $arr['post_data'][$i]["comments"] =  $comments;

        $i++;
    }




    $new_array=array();
    $count = 1;
    foreach($arr['post_data'] as $part){
        $code_as_key = $part['date'];
        if( isset($new_array[$code_as_key]) ){
            $new_array[$code_as_key]['likes'] += $part['likes'];
            $new_array[$code_as_key]['comments'] += $part['comments'];
        }
        else{
            $new_array[$code_as_key]=$part;
            $new_array[$code_as_key]['total_posts'] = count($part);
        }

        $count++;
    }

    is_user_in();
    $this->load->view('common/header');
    $this->load->view('common/sidebar');
    $data['user_detail'] = $this->common_model->get_table_data('tbl_users','*', array('user_id' => $this->session->userdata('user_id')), $row = 1);
    $this->load->view('analytics/analytics' , $data);
    $this->load->view('common/footer');
}

}