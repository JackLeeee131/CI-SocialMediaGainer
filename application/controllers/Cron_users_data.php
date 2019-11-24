<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Cron_users_data extends CI_Controller
{
    function __construct() {
        parent::__construct();
    }


    public function index() {
        $date = date('Y-m-d');
        $this->common_model->update_table('tbl_orders', array('name_change_count' => null), array('change_date !=' => $date));

        $current_time = strtotime('now');
        $current_date = date('Y-m-d H:i:s');

        if ($current_time > strtotime('12:00pm') && $current_time < strtotime('01:00pm')) {
            $this->db->empty_table('tbl_acc_search');
            $this->db->query('UPDATE tbl_users SET total_acc_search = NULL WHERE total_acc_search != ""');
        }

        require_once('Followiz_api.php');
        $api = new Followiz_api();
        $services = $api->services();
        $balance = $api->balance();
        $currentDate = date('Y-m-d H:i:s');

        $service_ids = $this->common_model->get_table_data('tbl_api_setup', '*', 'api_id=1', $row = 1);

        $likes_service_id = $service_ids[0]['likes_service_id'];
        $views_service_id = $service_ids[0]['views_service_id'];
        $comments_service_id = $service_ids[0]['comments_service_id'];
        $followers_service_id = $service_ids[0]['followers_service_id'];
        $likes_min = $service_ids[0]['likes_min'];
        $likes_max = $service_ids[0]['likes_max'];
        $views_min = $service_ids[0]['views_min'];
        $views_max = $service_ids[0]['views_max'];
        $comments_min = $service_ids[0]['comments_min'];
        $comments_max = $service_ids[0]['comments_max'];
        $followers_min = $service_ids[0]['followers_min'];
        $followers_max = $service_ids[0]['followers_max'];

        $insta_users = $this->common_model->get_users_data();

// $status = $api->status(14365798); # return status, charge, remains, start count

//echo '<pre>'; print_r($status); echo '</pre>';  exit;

//$order = $api->order(array('service' => 449, 'link' => 'https://www.instagram.com/chrissullivan794', 'quantity' => 200)); # Mentions User Followers
// echo '<pre>'; print_r($order); echo '</pre>';  exit;

//$order = $api->order(array('service' => 492, 'link' => 'https://www.instagram.com/p/BfXbyPVFaQk/?taken-by=chrissullivan794', 'quantity' => 70));

//echo '<pre>'; print_r($order); echo '</pre>';  exit;

        //$order = $api->order(array('service' => 1, 'link' => 'https://www.instagram.com/p/Bgk_9osnbvb/?taken-by=mathewjames0900', 'quantity' => 100.6666666666667, 'runs' => 3, 'interval' => 1.666666666666667));
        // echo '<pre>'; print_r($order); echo '</pre>'; exit;

//$status = $api->status(20669662); # return status, charge, remains, start count

//echo '<pre>'; print_r($status); echo '</pre>'; exit;

//$order = $api->order(array('service' => 3, 'link' => 'https://www.instagram.com/p/BfsfnV6FRil/?taken-by=chrissullivan794', 'comments' => "good piccccc\ngreat photo\n:)\nlikeeee @name it\n;;;)")); # Default

//$status = $order->order; # return status, charge, remains, start count

//echo '<pre>'; print_r($order); echo '</pre>';  exit;

        foreach ($insta_users as $packages) {
//echo '<pre>'; print_r($packages); echo '</pre>';  exit;

            $post_code = $packages['post_code'];
            $instagram_name = $packages['instagram_name'];
            $link = 'https://www.instagram.com/p/' . trim($post_code) . '/?taken-by=' . $instagram_name;
            $followers_link = 'https://www.instagram.com/' . trim($instagram_name);
            $likes_qty = $packages['post_likes'];
            $views_qty = $packages['post_views'];
            $comments_qty = $packages['post_comments'];

            $comments_list = $packages['comments_list'];
            $followers_qty = $packages['post_followers'];

            if ($packages['post_likes'] != '') {
                if (!empty($packages['likes_type']) && $packages['likes_type'] == 'dripfeed') {
                    $dripfeed_runs = $packages['dripfeed_time'];
                    $dripfeed_interval = $packages['dripfeed_minutes'];
                    $dripfeed_likes_qty = $likes_qty / $dripfeed_runs;
                    $dripfeed_cal_startTime = $dripfeed_interval / $dripfeed_runs;
                    $dripfeed_start_date = date('Y-m-d H:i:s', strtotime($packages['payment_date'] . '+ ' . number_format($dripfeed_cal_startTime) . ' minute')) . '<br><bR>';
                    if ($current_date >= $dripfeed_start_date) {
                        $order = $api->order(array('service' => $likes_service_id, 'link' => $link, 'quantity' => $dripfeed_likes_qty, 'runs' => $dripfeed_runs, 'interval' => $dripfeed_cal_startTime));
                    }
                } else {
                    $order = $api->order(array('service' => $likes_service_id, 'link' => $link, 'quantity' => $likes_qty));
                }
                if (!empty($order->order)) {
                    $insert_data = array(
                        'user_id' => $packages['user_id'],
                        'tbl_pkg_id' => $packages['tbl_pkg_id'],
                        'tbl_subpkg_id' => $packages['tbl_subpkg_id'],
                        'tbl_order_id' => $packages['tbl_order_id'],
                        'tbl_post_id' => $packages['post_id'],
                        'response_order_id' => $order->order,
                        'given_likes' => $packages['post_likes'],
                        'given_date' => $currentDate,
                        'given_status' => 'Completed',
                    );

                    $this->common_model->insert_table('tbl_package_status', $insert_data);
                    if ($packages['post_views'] == '' && $packages['post_comments'] == '' && $packages['post_followers'] == '') {
                        $this->common_model->update_table('tbl_posts', array('post_status' => 'Done'), array('post_id' => $packages['post_id']));
                    }
                } else {
                    $error_log  = "999249 -> " . ' Order ID -> ' . $packages['tbl_order_id'] . ' -> Post ID ->' . $packages['post_id'] . ' -> Response -> ' . $order->error ;
                    log_message('Error', $error_log);
                }
            }

            if ($packages['post_views'] != '') {
                if (!empty($packages['post_views']) && $packages['likes_type'] == 'dripfeed') {
                    $dripfeed_runs = $packages['dripfeed_time'];
                    $dripfeed_interval = $packages['dripfeed_minutes'];
                    $dripfeed_views_qty = $views_qty / $dripfeed_runs;

                    $dripfeed_cal_startTime = $dripfeed_interval / $dripfeed_runs;
                    $dripfeed_start_date = date('Y-m-d H:i:s', strtotime($packages['payment_date'] . '+ ' . number_format($dripfeed_cal_startTime) . ' minute')) . '<br><bR>';
                    if ($current_date >= $dripfeed_start_date) {
                        $order = $api->order(array('service' => $views_service_id, 'link' => $link, 'quantity' => $dripfeed_views_qty, 'runs' => $dripfeed_runs, 'interval' => $dripfeed_cal_startTime));
                    }
                } else {
                    $order = $api->order(array('service' => $views_service_id, 'link' => $link, 'quantity' => $views_qty));
                }
                if (!empty($order->order)) {
                    $insert_data = array(
                        'user_id' => $packages['user_id'],
                        'tbl_pkg_id' => $packages['tbl_pkg_id'],
                        'tbl_subpkg_id' => $packages['tbl_subpkg_id'],
                        'tbl_order_id' => $packages['tbl_order_id'],
                        'tbl_post_id' => $packages['post_id'],
                        'response_order_id' => $order->order,
                        'given_views' => $packages['post_views'],
                        'given_date' => $currentDate,
                        'given_status' => 'Completed',
                    );

                    $this->common_model->insert_table('tbl_package_status', $insert_data);
                    if ($packages['post_followers'] == '') {
                        $this->common_model->update_table('tbl_posts', array('post_status' => 'Done'), array('post_id' => $packages['post_id']));
                    }
                } else {
                    $error_log  = "999249 -> " . ' Order ID -> ' . $packages['tbl_order_id'] . ' -> Post ID ->' . $packages['post_id'] . ' -> Response -> ' . $order->error ;
                    log_message('Error', $error_log);
                }
            }

            if ($packages['post_comments'] != '') {
                if (!empty($packages['post_comments'])) {
                    $order = $api->order(array('service' => $comments_service_id, 'link' => $link, 'comments' => str_replace('<br/>', "\n", $comments_list)));
                }
                if (!empty($order->order)) {
                    $insert_data = array(
                        'user_id' => $packages['user_id'],
                        'tbl_pkg_id' => $packages['tbl_pkg_id'],
                        'tbl_subpkg_id' => $packages['tbl_subpkg_id'],
                        'tbl_order_id' => $packages['tbl_order_id'],
                        'tbl_post_id' => $packages['post_id'],
                        'response_order_id' => $order->order,
                        'given_comments' => $packages['post_comments'],
                        'given_date' => $currentDate,
                        'given_status' => 'Completed',
                    );
                    $this->common_model->insert_table('tbl_package_status', $insert_data);
                    if ($packages['post_followers'] == '') {
                        $this->common_model->update_table('tbl_posts', array('post_status' => 'Done'), array('post_id' => $packages['post_id']));
                    }
                } else {
                    $error_log  = "999249 -> " . ' Order ID -> ' . $packages['tbl_order_id'] . ' -> Post ID ->' . $packages['post_id'] . ' -> Response -> ' . $order->error ;
                    log_message('Error', $error_log);
                }
            }

            if ($packages['post_followers'] != '') {
                $order = $api->order(array('service' => $followers_service_id, 'link' => $followers_link, 'quantity' => $followers_qty));
                if (!empty($order->order)) {
                    $insert_data = array(
                        'user_id' => $packages['user_id'],
                        'tbl_pkg_id' => $packages['tbl_pkg_id'],
                        'tbl_subpkg_id' => $packages['tbl_subpkg_id'],
                        'tbl_order_id' => $packages['tbl_order_id'],
                        'tbl_post_id' => $packages['post_id'],
                        'response_order_id' => $order->order,
                        'given_followers' => $packages['post_followers'],
                        'given_date' => $currentDate,
                        'given_status' => 'Completed',
                    );
                    $this->common_model->insert_table('tbl_package_status', $insert_data);
                    $this->common_model->update_table('tbl_posts', array('post_status' => 'Done'), array('post_id' => $packages['post_id']));
                } else {
                    $error_log  = "999249 -> " . ' Order ID -> ' . $packages['tbl_order_id'] . ' -> Post ID ->' . $packages['post_id'] . ' -> Response -> ' . $order->error ;
                    log_message('Error', $error_log);
                }
            }

            /*

            $sub_package_detail = $this->common_model->get_table_data('tbl_sub_packages','*',array('status'=> 'Active', 'sub_package_id' => $packages['tbl_subpkg_id']), $row=1);
            $total_likes = $sub_package_detail[0]['likes'];
            $total_views = $sub_package_detail[0]['views'];
            $total_comments = $sub_package_detail[0]['comments'];
            $total_followers = $sub_package_detail[0]['followers'];


            $sum_qry = $this->common_model->get_table_data('tbl_posts', 'SUM(post_likes) AS post_likes, SUM(post_views) AS post_views, SUM(post_comments) AS post_comments, SUM(post_followers) AS post_followers ', array('tbl_order_id' => $packages['tbl_order_id']), $row = 1);
            $post_likes = $sum_qry[0]['post_likes'];
            $post_views = $sum_qry[0]['post_views'];
            $post_comments = $sum_qry[0]['post_comments'];
            $post_followers = $sum_qry[0]['post_followers'];

            $remaining_likes = $total_likes - $post_likes;
            $remaining_views = $total_views - $post_views;
            $remaining_comments = $total_comments - $post_comments;
            $remaining_followers = $total_followers - $post_followers;

            if ($remaining_likes < $likes_min && $remaining_views < $views_min && $remaining_comments < $comments_min && $remaining_followers < $followers_min) {
            $this->common_model->update_table('tbl_orders', array('order_status' => 'Done'), array('order_id' => $packages['tbl_order_id']));
            }*/

            $count_posts_status = $this->common_model->get_table_data('tbl_posts', '*', array('tbl_order_id' => $packages['order_id'], 'post_status' => 'Featured'));

            if (count($count_posts_status) < 1) {
                $this->common_model->update_table('tbl_orders', array('order_status' => 'Done'), array('order_id' => $packages['tbl_order_id']));

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


<span style="text-align: left"><b>Hi, (' . ucfirst($packages['username']) . ') </b></span><br>

<p>
We would like to inform you that your Instagram package for (  ' . $instagram_name . ' ) is over.  If you liked our service, and would like to continue skyrocketing your account then please click below!
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
<td valign="top" width="500" class="flexibleContainerCell">


</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>




<tr>
<td align="center" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr style="padding-top:0;">
<td align="center" valign="top">
<table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
<tr>
<td style="padding-top:0;" align="center" valign="top" width="500" class="flexibleContainerCell">

<table border="0" cellpadding="0" cellspacing="0" width="50%" class="emailButton" style="background-color: #3498DB;">
<tr>
<td align="center" valign="middle" class="buttonContent" style="padding-top:15px;padding-bottom:15px;padding-right:15px;padding-left:15px;">
<a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%;" href="http://webhorde.com/socialmediagainer/login" target="_blank">Login</a>
</td>
</tr>


</table>

</td>
</tr>                          
<tr><td style="text-align: center; font-size: 13px;">All The Best, <br> <span style="margin-top: 10px"><b>SocialMediaGainer</b></span></td></tr>
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

                $email_qry = $this->smtp_email->send('no-reply@socialmediagainer.com', 'Social Media Gainer', $packages['email'], 'Instagram Package Status', $email_msg);
            }
        }

        // exit('exittttttt package');

        $custom_orders = $this->common_model->get_custom_orders();

        foreach ($custom_orders as $custom_order) {
            $link = trim($custom_order['instagram_url']);
            $order_qty = $custom_order['order_qty'];

            if ($custom_order['order_name'] == 'Followers' || $custom_order['order_name'] == 'Package Followers') {


                if (!empty($custom_order['dripfeed']) && $custom_order['dripfeed'] == 'yes') {


                    $dripfeed_runs = $custom_order['dripfeed_time'];
                    $dripfeed_interval = 1440;
                    $order_qty = $order_qty / $dripfeed_runs;

                    //echo $dripfeed_runs . ' -- ' . $order_qty;

                    $order = $api->order(array('service' => $followers_service_id, 'link' => $link, 'quantity' => number_format($order_qty), 'runs' => $dripfeed_runs, 'interval' => $dripfeed_interval));
                } else {
                    $order = $api->order(array('service' => $followers_service_id, 'link' => $link, 'quantity' => $order_qty));
                }
                if (!empty($order->order)) {
                    $insert_data = array(
                        'user_id' => $custom_order['user_id'],
                        'tbl_customorder_id' => $custom_order['order_id'],
                        'response_order_id' => $order->order,
                        'given_followers' => $custom_order['order_qty'],
                        'given_date' => $currentDate,
                        'given_status' => 'Completed',
                    );
                    $this->common_model->insert_table('tbl_custompackage_status', $insert_data);
                    $this->common_model->update_table('tbl_custom_orders', array('order_status' => 'Done'), array('order_id' => $custom_order['order_id']));
                } else {
                    $error_log  = "999249 -> " . ' Order ID -> ' . $packages['tbl_order_id'] . ' -> Post ID ->' . $packages['post_id'] . ' -> Response -> ' . $order->error ;
                    log_message('Error', $error_log);
                }
            }

            if ($custom_order['order_name'] == 'Likes') {
                if (!empty($custom_order['dripfeed']) && $custom_order['dripfeed'] == 'yes') {
                    $dripfeed_runs = $custom_order['dripfeed_time'];
                    $dripfeed_interval = $custom_order['dripfeed_minutes'];
                    $order_qty = $order_qty / $dripfeed_runs;
                    $dripfeed_cal_startTime = $dripfeed_interval / $dripfeed_runs;

                    $dripfeed_start_date = date('Y-m-d H:i:s', strtotime($custom_order['payment_date'] . '+ ' . number_format($dripfeed_cal_startTime) . ' minute')) . '<br><bR>';

                    //echo $dripfeed_runs .' and '. $dripfeed_cal_startTime; exit;

                    if ($current_date >= $dripfeed_start_date) {
                        //exit('exittt');
                        $order = $api->order(array('service' => $likes_service_id, 'link' => $link, 'quantity' => $order_qty, 'runs' => $dripfeed_runs, 'interval' => $dripfeed_cal_startTime));
                    }
                } else {
                    $order = $api->order(array('service' => $likes_service_id, 'link' => $link, 'quantity' => $order_qty));
                }
                if (!empty($order->order)) {
                    $insert_data = array(
                        'user_id' => $custom_order['user_id'],
                        'tbl_customorder_id' => $custom_order['order_id'],
                        'response_order_id' => $order->order,
                        'given_likes' => $custom_order['order_qty'],
                        'given_date' => $currentDate,
                        'given_status' => 'Completed',
                    );

                    $this->common_model->insert_table('tbl_custompackage_status', $insert_data);
                    $this->common_model->update_table('tbl_custom_orders', array('order_status' => 'Done'), array('order_id' => $custom_order['order_id']));
                } else {
                    $error_log  = "999249 -> " . ' Order ID -> ' . $packages['tbl_order_id'] . ' -> Post ID ->' . $packages['post_id'] . ' -> Response -> ' . $order->error ;
                    log_message('Error', $error_log);
                }
            }

            if ($custom_order['order_name'] == 'Views') {
                if (!empty($custom_order['dripfeed']) && $custom_order['dripfeed'] == 'yes') {
                    $dripfeed_runs = $custom_order['dripfeed_time'];
                    $dripfeed_interval = $custom_order['dripfeed_minutes'];
                    $order_qty = $order_qty / $dripfeed_runs;
                    $dripfeed_cal_startTime = $dripfeed_interval / $dripfeed_runs;
                    $dripfeed_start_date = date('Y-m-d H:i:s', strtotime($custom_order['payment_date'] . '+ ' . number_format($dripfeed_cal_startTime) . ' minute')) . '<br><bR>';
                    if ($current_date >= $dripfeed_start_date) {
                        $order = $api->order(array('service' => $views_service_id, 'link' => $link, 'quantity' => $order_qty, 'runs' => $dripfeed_runs, 'interval' => $dripfeed_cal_startTime));
                    }
                } else {
                    $order = $api->order(array('service' => $views_service_id, 'link' => $link, 'quantity' => $order_qty));
                }
                if (!empty($order->order)) {
                    $insert_data = array(
                        'user_id' => $custom_order['user_id'],
                        'tbl_customorder_id' => $custom_order['order_id'],
                        'response_order_id' => $order->order,
                        'given_views' => $custom_order['order_qty'],
                        'given_date' => $currentDate,
                        'given_status' => 'Completed',
                    );

                    $this->common_model->insert_table('tbl_custompackage_status', $insert_data);
                    $this->common_model->update_table('tbl_custom_orders', array('order_status' => 'Done'), array('order_id' => $custom_order['order_id']));
                } else {
                    $error_log  = "999249 -> " . ' Order ID -> ' . $packages['tbl_order_id'] . ' -> Post ID ->' . $packages['post_id'] . ' -> Response -> ' . $order->error ;
                    log_message('Error', $error_log);
                }
            }

            if ($custom_order['order_name'] == 'Comments') {
                $comment_qry = $this->common_model->get_table_data('tbl_comments', '*', array('custom_order_code' => $custom_order['custom_order_code'], 'comment_status' => 'active'));

// echo '<pre>'; print_r($comment_qry); echo '</pre>'; exit;

                if (!empty($comment_qry[0]['comments_type']) && $comment_qry[0]['comments_type'] == 'custom_comments') {
                    $comments_arr = $comment_qry[0]['comment_description'];
                    $comment_list = str_replace('<br/>', "\n", $comments_arr);
                    $comments_given = $custom_order['order_qty'];
                } else {
                    $comment_qry = $this->common_model->get_table_data('tbl_comments', '*', array('user_id' => null, 'comment_status' => 'active'), '', '', '', $custom_order['total_order_qty']);
                    $arr = array();
                    foreach ($comment_qry as $comments) {
                        $arr[] = $comments['comment_description'];
                    }
                    $comments_arr = implode($arr, '<br>');
                    $comment_list = str_replace('<br>', "\n", $comments_arr);
                    $comments_given = count($comment_qry);
                }

                //echo '<pre>'; print_r($comments_arr); echo '</pre><br><br>';

                // echo '<br><br>';
                // echo $comments_given;


                $order = $api->order(array('service' => $comments_service_id, 'link' => $link, 'comments' => $comment_list));


                //echo '<pre>'; print_r($order); echo '</pre>'; exit;



                if (!empty($order->order)) {
                    $insert_data = array(
                        'user_id' => $custom_order['user_id'],
                        'tbl_customorder_id' => $custom_order['order_id'],
                        'response_order_id' => $order->order,
                        'given_comments' => $comments_given,
                        'given_date' => $currentDate,
                        'given_status' => 'Completed',
                    );
                    $this->common_model->insert_table('tbl_custompackage_status', $insert_data);
                    $this->common_model->update_table('tbl_custom_orders', array('order_status' => 'Done'), array('order_id' => $custom_order['order_id']));
                    $this->common_model->delete_table('tbl_comments', array('custom_order_code' => $custom_order['custom_order_code']));

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


<span style="text-align: left"><b>Hi, (' . ucfirst($custom_order['username']) . ') </b></span><br>

<p>
We would like to inform you that your Instagram custom order for (  ' . $custom_order['instagram_url'] . ' ) is over.  If you liked our service, and would like to continue skyrocketing your account then please click below!
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
<td valign="top" width="500" class="flexibleContainerCell">


</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>




<tr>
<td align="center" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr style="padding-top:0;">
<td align="center" valign="top">
<table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
<tr>
<td style="padding-top:0;" align="center" valign="top" width="500" class="flexibleContainerCell">

<table border="0" cellpadding="0" cellspacing="0" width="50%" class="emailButton" style="background-color: #3498DB;">
<tr>
<td align="center" valign="middle" class="buttonContent" style="padding-top:15px;padding-bottom:15px;padding-right:15px;padding-left:15px;">
<a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%;" href="http://webhorde.com/socialmediagainer/login" target="_blank">Login</a>
</td>
</tr>


</table>

</td>
</tr>                          
<tr><td style="text-align: center; font-size: 13px;">All The Best, <br> <span style="margin-top: 10px"><b>SocialMediaGainer</b></span></td></tr>
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
                    $email_qry = $this->smtp_email->send('no-reply@socialmediagainer.com', 'Social Media Gainer', $custom_order['email'], 'Instagram Package Status', $email_msg);
                } else {
                    $error_log  = "999249 -> " . ' Order ID -> ' . $custom_order['order_id'] . ' -> Response -> ' . $order->error ;
                    log_message('Error', $error_log);
                }
            }
        }
    }
}