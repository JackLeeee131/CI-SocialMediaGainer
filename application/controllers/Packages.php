<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Packages extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->library('paypal_lib');
    }


    public function index() {
        is_user_in();
        $this->common_model->delete_table('tbl_orders', array('payment_status' => 'not confirmed'));
        $this->common_model->delete_table('tbl_custom_orders', array('payment_status' => 'not confirmed'));
        is_user_in();
        $this->load->view('common/header');
        $this->load->view('common/sidebar');

        $data['packages_list'] = $this->common_model->get_table_data('tbl_packages', '*', array('package_status' => 'Active'));

        $this->load->view('packages/main_packages', $data);

        $this->load->view('common/footer');
    }


    public function sub_packages() {
        is_user_in();
        $package_id = $this->uri->segment(3);

        if ($package_id == 5) {
            $this->special_id($package_id);
        } else {
            $this->load->view('common/header');
            $this->load->view('common/sidebar');
            $data['sub_packages_list'] = $this->common_model->sub_packages_list($package_id);
            $this->load->view('packages/sub_packages', $data);
            $this->load->view('common/footer');
        }
    }


    public function special_id($package_id = null) {
        is_user_in();
        $package_id = '5';
        $special_id = $this->input->post('special_id');
        if (isset($special_id)) {
            if (!empty($special_id)) {
                $qry = $this->common_model->get_table_data('tbl_sub_packages', '*', array('special_id' => $special_id));
                if (count($qry) >= 1) {
                    $this->load->view('common/header');
                    $this->load->view('common/sidebar');
                    $data['sub_packages_list'] = $this->common_model->special_id_package($package_id, $special_id);
                    $this->load->view('packages/sub_packages', $data);
                    $this->load->view('common/footer');
                } else {
                    $this->session->set_flashdata('error_message', 'Incorrect Special Id');
                    redirect('packages/special_id');
                }
            } else {
                $this->session->set_flashdata('error_message', 'Special Id field required');
                redirect('packages/special_id');
            }
        } else {
            $this->load->view('common/header');
            $this->load->view('common/sidebar');
            $data['sub_packages_list'] = $this->common_model->sub_packages_list($package_id);
            $this->load->view('packages/special_id', $data);
            $this->load->view('common/footer');
        }
    }


    public function package_detail() {
        is_user_in();
        $sub_package_id = $this->uri->segment(3);
        $this->load->view('common/header');
        $this->load->view('common/sidebar');
        $data['dripfeed_detail'] = $this->common_model->get_table_data('tbl_dripfeed', '*', array('dripfeed_for' => 'packages'));
        $data['max_dripfeed'] = $this->common_model->get_table_data('tbl_dripfeed', 'MAX(dripfeed_run) AS dripfeed_run', array('dripfeed_for' => 'packages'));

        $data['api_setup'] = $this->common_model->get_table_data('tbl_api_setup', '*', 'api_id=1');

        // echo '<pre>'; print_r($data['api_setup']); echo '</pre>'; exit;

        $data['sub_package_detail'] = $this->common_model->get_table_data('tbl_sub_packages', '*', array('status' => 'Active', 'sub_package_id' => $sub_package_id), $row = 1);
        $this->load->view('packages/package_detail', $data);
//
        $this->load->view('common/footer');
    }


    public function confirm_package() {
        is_user_in();
        // echo '<pre>'; print_r($this->input->post()); echo '</pre>'; exit;

        $this->common_model->delete_table('tbl_orders', array('payment_status' => 'not confirmed'));
        $this->common_model->delete_table('tbl_custom_orders', array('payment_status' => 'not confirmed'));
        require 'vendor/autoload.php';
        $instagram_name = $this->input->post('instagram_name');
        $instagram = new \InstagramScraper\Instagram();
        $account = $instagram->getAccount($instagram_name);
        $sub_package_id = $this->input->post('sub_package_id');
        $post_special_id = $this->input->post('special_id');

        if (empty($account['error'])) {
            $is_private = $account->isPrivate();
        }

        $check_instagram_name = $this->common_model->get_table_data('tbl_orders', '*', array('instagram_name' => $instagram_name, 'order_status' => 'Pending'));

        if (!empty($account['error']) || count($check_instagram_name) >= 1 || $is_private == 1) {
            if (count($check_instagram_name) >= 1) {
                $this->session->set_flashdata('error_message', 'Account with this username already exist');
                redirect('packages/package_detail/' . $sub_package_id);
            }

            if (!empty($account['error'])) {
                $this->session->set_flashdata('error_message', 'Account with this username does not exist');
                redirect('packages/package_detail/' . $sub_package_id);
            }

            if (empty($account['error']) && $is_private == 1) {
                $this->session->set_flashdata('error_message', 'This Account is Private. <br> Please change your account status to use this resource.');
                redirect('packages/package_detail/' . $sub_package_id);
            }
        } else {
            $data['sub_package_detail'] = $this->common_model->get_table_data('tbl_sub_packages', '*', array('status' => 'Active', 'sub_package_id' => $sub_package_id));
            $special_id = $data['sub_package_detail'][0]['special_id'];

           //echo ' id ' .  $special_id . ' post id ' . $post_special_id; exit;

//            if ($special_id == $post_special_id) {
                $likes_type = $this->input->post('likes_type');
                $dripfeed_id = $this->input->post('dripfeed_id');

                $dripfeed_detail = $this->common_model->get_table_data('tbl_dripfeed', '*', array('dripfeed_id' => $dripfeed_id));
                $dripfeed_time = $dripfeed_detail[0]['dripfeed_run'];
                $dripfeed_interval = $this->input->post('dripfeed_minutes');
                $dripfeed_price = $dripfeed_detail[0]['dripfeed_price'];

                if ($likes_type == 'dripfeed') {
                    $total_price = $data['sub_package_detail'][0]['price'] + $dripfeed_price;
                } else {
                    $total_price = $data['sub_package_detail'][0]['price'];
                }

                $package_id = $data['sub_package_detail'][0]['tbl_package_id'];
                $data['main_package'] = $this->common_model->get_table_data('tbl_packages', '*', array('package_status' => 'Active', 'package_id' => $package_id), $row = 1);

                $data['package_data'] = array(
                    'package_id' => $data['main_package'][0]['package_id'],
                    'package_name' => $data['main_package'][0]['package_name'],
                    'package_description' => $data['main_package'][0]['package_description'],
                    'likes' => $data['sub_package_detail'][0]['likes'],
                    'views' => $data['sub_package_detail'][0]['views'],
                    'comments' => $data['sub_package_detail'][0]['comments'],
                    'followers' => $data['sub_package_detail'][0]['followers'],
                    'price' => $total_price,
                    'special_id' => $data['sub_package_detail'][0]['special_id'],
                    'followers_type' => $this->input->post('followers_type'),
                    'sub_package_id' => $this->input->post('sub_package_id'),
                    'instagram_name' => $this->input->post('instagram_name'),
                    'likes_type' => $this->input->post('likes_type'),
                    'dripfeed_time' => $dripfeed_time,
                    'dripfeed_minutes' => $this->input->post('dripfeed_minutes'),
                );
                $insert_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'txn_type' => 'package order',
                    'payment_amount' => $total_price,
                    'tbl_pkg_id' => $data['main_package'][0]['package_id'],
                    'tbl_subpkg_id' => $this->input->post('sub_package_id'),
                    'instagram_name' => $this->input->post('instagram_name'),
                    'followers_type' => $this->input->post('followers_type'),
                    'likes_type' => $this->input->post('likes_type'),
                    'dripfeed_time' => $dripfeed_time,
                    'dripfeed_minutes' => $this->input->post('dripfeed_minutes'),
                    'payment_status' => 'not confirmed',
                );
                $data['order_id'] = $this->common_model->insert_table('tbl_orders', $insert_data);

                $this->load->view('common/header');
                $this->load->view('common/sidebar');
                $this->load->view('packages/confirm_package', $data);
                $this->load->view('common/footer');
            /*} else {
                $this->session->set_flashdata('error_message', 'Incorrect Service ID');
                redirect('packages/package_detail/' . $sub_package_id);
            }*/
        }
    }


    function confirmed_pay($id) {
        is_user_in();
        $order_id = $this->uri->segment(4);
        $user_id = $this->session->userdata('user_id');
        $check_balance = $this->common_model->get_table_data('tbl_accounts', '*', array('user_id' => $user_id), $row = 1);
        $account_balance = $check_balance[0]['current_balance'];

        $data['sub_package_detail'] = $this->common_model->get_table_data('tbl_sub_packages', '*', array('status' => 'Active', 'sub_package_id' => $id), $row = 1);
        $package_id = $data['sub_package_detail'][0]['tbl_package_id'];
        $data['main_package'] = $this->common_model->get_table_data('tbl_packages', '*', array('package_status' => 'Active', 'package_id' => $package_id), $row = 1);
        $order_detail = $this->common_model->get_table_data('tbl_orders', '*', array('order_id' => $order_id));

        if ($account_balance >= $order_detail[0]['payment_amount']) {
            $update_data = array(
                'payment_amount' => $order_detail[0]['payment_amount'],
                'payment_status' => 'Completed',
                'payment_date' => date('Y-m-d H:i:s'),
                'status_change_date' => date('Y-m-d H:i:s'),
            );

            $sub_package_detail = $this->common_model->get_table_data('tbl_sub_packages', '*', array('sub_package_id' => $order_detail[0]['tbl_subpkg_id']));
            $total_posts = $sub_package_detail[0]['likes_per_post'];
            $comment_qry = $this->common_model->get_table_data('tbl_comments', '*', array('user_id' => null, 'comment_status' => 'active'), $order_by = 'rand()', '', '', $sub_package_detail[0]['comments']);
            $arr = array();
            foreach ($comment_qry as $comments) {
                $arr[] = $comments['comment_description'];
            }
            $comments_list = implode('<br/>', $arr);

            if (!empty($sub_package_detail[0]['likes'])) {
                $post_likes = $sub_package_detail[0]['likes'];
            } else {
                $post_likes = null;
            }

            if (!empty($sub_package_detail[0]['views'])) {
                $post_views = $sub_package_detail[0]['views'];
            } else {
                $post_views = null;
            }

            if (!empty($sub_package_detail[0]['comments'])) {
                $post_comments = $sub_package_detail[0]['comments'];
            } else {
                $post_comments = null;
                $comments_list = null;
            }

            if (!empty($sub_package_detail[0]['followers'])) {
                $post_followers = $sub_package_detail[0]['followers'];
                $followers_per_day = $sub_package_detail[0]['followers_per_day'];
                $dripfeed_time = $post_followers / $followers_per_day;
                $followers_link = 'https://www.instagram.com/' . trim($order_detail[0]['instagram_name']);

                $min_followers = $this->common_model->get_table_data('tbl_api_setup', '*', 'api_id=1');

                $cal_dripfeed = strpos($dripfeed_time, '.');

                if ($cal_dripfeed) {
                    $dripfeed_time = substr($dripfeed_time, 0, $cal_dripfeed);
                } else {
                    $dripfeed_time = $dripfeed_time;
                }

                //echo ' post followers - ' . $post_followers . ' per day -' . $followers_per_day . ' dripfeed_time --' . $dripfeed_time . '<br><br>';

                if ($followers_per_day >= $min_followers[0]['followers_min'] && $post_followers >= $min_followers[0]['followers_min']) {
                    $insert_data_follower = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'txn_id' => $order_detail[0]['order_id'],
                        'txn_type' => 'package follower',
                        'instagram_url' => $followers_link,
                        'dripfeed' => 'yes',
                        'dripfeed_time' => $dripfeed_time,
                        'dripfeed_minutes' => null,
                        'order_qty' => $post_followers,
                        'total_order_qty' => $post_followers,
                        'package_name' => 'Package Followers',
                        'order_name' => 'Package Followers',
                        'payment_status' => 'Completed',
                    );

                    //echo '<pre>'; print_r($insert_data_follower); echo '</pre>'; exit;

                    $this->common_model->insert_table('tbl_custom_orders', $insert_data_follower);
                    //exit('correct');
                } else {
                    //exit('error');
                    $this->session->set_flashdata('error_message', 'Unable to process, Please try again.');
                    redirect('packages');
                }
            } else {
                $post_followers = null;
            }

            for ($i = 1; $i <= $total_posts; $i++) {
                $insert_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'tbl_order_id' => $order_id,
                    'post_no' => $i,
                    'tbl_pkg_id' => $order_detail[0]['tbl_pkg_id'],
                    'tbl_subpkg_id' => $order_detail[0]['tbl_subpkg_id'],
                    'post_likes' => $post_likes,
                    'post_views' => $post_views,
                    'post_comments' => $post_comments,
                    'comments_list' => $comments_list,
                    'post_followers' => null,
                    'post_status' => 'Featured',
                );
                $this->common_model->insert_table('tbl_posts', $insert_data);
            }

            $this->common_model->update_table('tbl_orders', $update_data, array('order_id' => $order_id));
            $this->common_model->update_table('tbl_accounts', array('current_balance' => $account_balance - $order_detail[0]['payment_amount']), array('user_id' => $user_id));
            $this->common_model->delete_table('tbl_orders', array('payment_status' => 'not confirmed'));

            $pkg_desc_mail = '<b>Package Includes:- </b> &nbsp;  ' . ' ' . $post_likes . ' Likes, ';

            if (!empty($post_views)) {
                $pkg_desc_mail .= $post_views . ' Views';
            }
            if (!empty($post_comments)) {
                $pkg_desc_mail .= ', ' . $post_comments . ' Comments';
            }
            if (!empty($post_followers)) {
                $pkg_desc_mail .= ', ' . $post_followers . ' Followers';
            }

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
We are proud to announce that you have successfully purchased the below package for the Instagram account ( ' . ucfirst($order_detail[0]['instagram_name']) . ' ).  Thankyou for ordering your package, and we really hope you enjoy it!
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
            $email_qry = $this->smtp_email->send('no-reply@socialmediagainer.com', 'Social Media Gainer', $this->session->userdata('email'), 'Instagram Package Purchase', $email_msg);

            $this->session->set_flashdata('success_message', 'Package Purchased Successfully');
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('funds_error', 'Funds Error');
            redirect('add_funds');
        }
    }
}