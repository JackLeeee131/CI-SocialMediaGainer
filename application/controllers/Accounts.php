<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->library('paypal_lib');
    }


    public function update_instagram_name()
    {
        is_user_in();


        $instagram_name = $this->input->post('instagram_name');
        $user_id = $this->session->userdata('user_id');
        $check_balance = $this->common_model->get_table_data('tbl_accounts', '*', array('user_id' => $user_id), $row = 1);
        $account_balance = $check_balance[0]['current_balance'];

        $ig_nameChange_setup_detail = $this->common_model->get_table_data('tbl_ig_name_change', '*');
        $change_time = $ig_nameChange_setup_detail[0]['change_time'];
        $change_price = $ig_nameChange_setup_detail[0]['change_price'];

        $currDate = date('Y-m-d');
        if ($account_balance >= $change_price) {
            $order_id = $this->input->post('order_id');

            $qry = $this->common_model->get_table_data('tbl_orders', '*', array('order_id' => $order_id), $row = 1);
            $name_change_count = $qry[0]['name_change_count'];




            $change_date = $qry[0]['change_date'];
            $check_instagram_name = $this->common_model->get_table_data('tbl_orders', '*', array('instagram_name' => $instagram_name, 'order_status' => 'Pending'));

            if ($change_date == $currDate && $name_change_count > $change_time || count($check_instagram_name) >= 1) {
                if (count($check_instagram_name) >= 1) {
                    $this->session->set_flashdata('error_message', 'Account with this username already exist');
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error_message', 'Maximum number of daily name switch’s has been reached.  Please come back tomorrow to try again.');
                    redirect('dashboard');
                }
            } else {

                require 'vendor/autoload.php';
                $instagram = new \InstagramScraper\Instagram();
                $account = $instagram->getAccount($instagram_name);
                if (empty($account['error'])) {
                    $is_private = $account->isPrivate();
                }


                if (!empty($account['error']) || $is_private == 1) {

                    if (!empty($account['error'])) {
                        $this->session->set_flashdata('error_message', 'Account with this username does not exist');
                        redirect('dashboard');
                    } else {
                        $this->session->set_flashdata('error_message', 'This Account is Private. <br> Please change your account status to view this resource.');
                        redirect('dashboard');
                    }

                } else {


                    $this->common_model->update_table('tbl_accounts', array('current_balance' => $account_balance - $change_price), array('user_id' => $this->session->userdata('user_id')));
                    $this->common_model->update_table('tbl_orders', array('instagram_name' => $instagram_name, 'name_change_count' => $name_change_count + 1, 'change_date' => $currDate), array('order_id' => $order_id));
                    $this->session->set_flashdata('success_message', 'Instagram account name updated Successfully! ');
                    redirect('dashboard');
                }
            }
        } else {
            redirect('add_funds');
        }

    }


    public function other_services()
    {
        is_user_in();
        $email_subscription = $this->input->post('email_subscription');
        $email = $this->input->post('email');


        if (!empty($email_subscription)) {
            if (!empty($email)) {
                $data = array(
                    'subscription_email' => $email,
                    'user_id' => $this->session->userdata('user_id'),
                    'subscription_date' => date('Y-m-d H:i:s')
                );






                $email_msg = '
                
                <html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
    <title>Respmail is a response HTML email designed to work on all major email platforms and smartphones</title>
    <style type="text/css">
       a img,img{outline:0;text-decoration:none}h1,h2,h3{font-style:normal}#bodyTable,#emailFooter,#emailHeader,body,html{background-color:#E1E1E1}html{margin:0;padding:0}#bodyCell,#bodyTable,body{height:100%!important;margin:0;padding:0;width:100%!important;font-family:Helvetica,Arial,"Lucida Grande",sans-serif}.flexibleImage,a img,img{height:auto}table{border-collapse:collapse}table[id=bodyTable]{width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:400}a img,img{border:0;line-height:100%}a{text-decoration:none!important;border-bottom:1px solid}h1,h2,h3,h4,h5,h6{color:#5F5F5F;font-weight:400;font-family:Helvetica;font-size:20px;line-height:125%;text-align:Left;letter-spacing:normal;margin:0 0 10px;padding:0}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,h1{line-height:100%}.ExternalClass,.ReadMsgBody{width:100%}table,td{mso-table-lspace:0;mso-table-rspace:0}#outlook a{padding:0}img{-ms-interpolation-mode:bicubic;display:block}a,blockquote,body,li,p,table,td{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;font-weight:400!important}h1,h2,h3,h4{font-weight:400;display:block}.ExternalClass td[class=ecxflexibleContainerBox] h3{padding-top:10px!important}h1{font-size:26px}h2{font-size:20px;line-height:120%}h3{font-size:17px;line-height:110%}.buttonContent,h4{font-size:18px;line-height:100%}h4{font-style:italic}.linkRemoveBorder{border-bottom:0!important}table[class=flexibleContainerCellDivider]{padding-bottom:0!important;padding-top:0!important}#emailBody{background-color:#FFF}.nestedContainer{background-color:#F8F8F8;border:1px solid #CCC}.emailButton{background-color:#205478;border-collapse:separate}.buttonContent{color:#FFF;font-family:Helvetica;font-weight:700;padding:15px;text-align:center}.emailCalendarDay,.emailCalendarMonth{font-family:Helvetica,Arial,sans-serif;font-weight:700;text-align:center}.buttonContent a{color:#FFF;display:block;text-decoration:none!important;border:0!important}.emailCalendar{background-color:#FFF;border:1px solid #CCC}.emailCalendarMonth{background-color:#205478;color:#FFF;font-size:16px;padding-top:10px;padding-bottom:10px}.emailCalendarDay{color:#205478;font-size:60px;line-height:100%;padding-top:20px;padding-bottom:20px}.imageContentText{margin-top:10px;line-height:0}.imageContentText a{line-height:0}#invisibleIntroduction{display:none!important}span[class=ios-color-hack] a{color:#275100!important;text-decoration:none!important}span[class=ios-color-hack2] a{color:#205478!important;text-decoration:none!important}span[class=ios-color-hack3] a{color:#8B8B8B!important;text-decoration:none!important}.a[href^=tel],a[href^=sms]{text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important}.mobile_link a[href^=tel],.mobile_link a[href^=sms]{text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important}@media only screen and (max-width:480px){body,table[class=emailButton],table[class=flexibleContainer],table[id=emailHeader],table[id=emailBody],table[id=emailFooter],td[class=flexibleContainerCell]{width:100%!important}body{min-width:100%!important}td[class=flexibleContainerBox],td[class=flexibleContainerBox] table{display:block;width:100%;text-align:left}img[class=flexibleImage],td[class=imageContent] img{height:auto!important;width:100%!important;max-width:100%!important}img[class=flexibleImageSmall]{height:auto!important;width:auto!important}table[class=flexibleContainerBoxNext]{padding-top:10px!important}td[class=buttonContent]{padding:0!important}td[class=buttonContent] a{padding:15px!important}}
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


                                                                        <span style="text-align: left"><b>Hi, ( Patrick ) </b></span><br>

                                                                        <p>
                                                                        '.ucfirst($email).'  Has been subscribed for other services .
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
</html>';

                $email_qry = $this->smtp_email->send('no-reply@socialmediagainer.com', 'Social Media Gainer', 'thesmgainer@gmail.com', 'Email subscription', $email_msg);








                $email_msg_user = '
                
                <html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
    <title>Respmail is a response HTML email designed to work on all major email platforms and smartphones</title>
    <style type="text/css">
       a img,img{outline:0;text-decoration:none}h1,h2,h3{font-style:normal}#bodyTable,#emailFooter,#emailHeader,body,html{background-color:#E1E1E1}html{margin:0;padding:0}#bodyCell,#bodyTable,body{height:100%!important;margin:0;padding:0;width:100%!important;font-family:Helvetica,Arial,"Lucida Grande",sans-serif}.flexibleImage,a img,img{height:auto}table{border-collapse:collapse}table[id=bodyTable]{width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:400}a img,img{border:0;line-height:100%}a{text-decoration:none!important;border-bottom:1px solid}h1,h2,h3,h4,h5,h6{color:#5F5F5F;font-weight:400;font-family:Helvetica;font-size:20px;line-height:125%;text-align:Left;letter-spacing:normal;margin:0 0 10px;padding:0}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,h1{line-height:100%}.ExternalClass,.ReadMsgBody{width:100%}table,td{mso-table-lspace:0;mso-table-rspace:0}#outlook a{padding:0}img{-ms-interpolation-mode:bicubic;display:block}a,blockquote,body,li,p,table,td{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;font-weight:400!important}h1,h2,h3,h4{font-weight:400;display:block}.ExternalClass td[class=ecxflexibleContainerBox] h3{padding-top:10px!important}h1{font-size:26px}h2{font-size:20px;line-height:120%}h3{font-size:17px;line-height:110%}.buttonContent,h4{font-size:18px;line-height:100%}h4{font-style:italic}.linkRemoveBorder{border-bottom:0!important}table[class=flexibleContainerCellDivider]{padding-bottom:0!important;padding-top:0!important}#emailBody{background-color:#FFF}.nestedContainer{background-color:#F8F8F8;border:1px solid #CCC}.emailButton{background-color:#205478;border-collapse:separate}.buttonContent{color:#FFF;font-family:Helvetica;font-weight:700;padding:15px;text-align:center}.emailCalendarDay,.emailCalendarMonth{font-family:Helvetica,Arial,sans-serif;font-weight:700;text-align:center}.buttonContent a{color:#FFF;display:block;text-decoration:none!important;border:0!important}.emailCalendar{background-color:#FFF;border:1px solid #CCC}.emailCalendarMonth{background-color:#205478;color:#FFF;font-size:16px;padding-top:10px;padding-bottom:10px}.emailCalendarDay{color:#205478;font-size:60px;line-height:100%;padding-top:20px;padding-bottom:20px}.imageContentText{margin-top:10px;line-height:0}.imageContentText a{line-height:0}#invisibleIntroduction{display:none!important}span[class=ios-color-hack] a{color:#275100!important;text-decoration:none!important}span[class=ios-color-hack2] a{color:#205478!important;text-decoration:none!important}span[class=ios-color-hack3] a{color:#8B8B8B!important;text-decoration:none!important}.a[href^=tel],a[href^=sms]{text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important}.mobile_link a[href^=tel],.mobile_link a[href^=sms]{text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important}@media only screen and (max-width:480px){body,table[class=emailButton],table[class=flexibleContainer],table[id=emailHeader],table[id=emailBody],table[id=emailFooter],td[class=flexibleContainerCell]{width:100%!important}body{min-width:100%!important}td[class=flexibleContainerBox],td[class=flexibleContainerBox] table{display:block;width:100%;text-align:left}img[class=flexibleImage],td[class=imageContent] img{height:auto!important;width:100%!important;max-width:100%!important}img[class=flexibleImageSmall]{height:auto!important;width:auto!important}table[class=flexibleContainerBoxNext]{padding-top:10px!important}td[class=buttonContent]{padding:0!important}td[class=buttonContent] a{padding:15px!important}}
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



                                                                         <span style="text-align: left"><b>Hi, ('.ucfirst($this->session->userdata('username')).') </b></span><br>

                                                                        <p>
                                                                        Thank you for subscribing for other services, We will get you back soon!
                                                                        </p>
                                                                        
                                                                        <p>
                                                                        If you have any questions, feel free to contact us at: <a href="mailto:TheSMGainer@gmail.com" style="color: #ffffff"> TheSMGainer@gmail.com </a> 
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
</html>';

                $email_qry_user = $this->smtp_email->send('no-reply@socialmediagainer.com', 'Social Media Gainer', $email, 'Email Subscription', $email_msg_user);









                $this->common_model->insert_table('tbl_email_subscriptions', $data);
                $this->session->set_flashdata('success_message', 'You are successfully subscribed for other Services!');
                redirect('accounts/other_services');
            } else {

                $this->session->set_flashdata('error_message', 'Email field is required!');
                redirect('accounts/other_services');
            }


        }
        $this->load->view('common/header');
        $this->load->view('common/sidebar');

        $this->load->view('accounts/other_services');
        $this->load->view('common/footer');

    }


    public function update_post()
    {

        $package_id = $this->input->post('pkg_id');
        $sub_package_id = $this->input->post('subpkg_id');
        $sub_package_detail = $this->common_model->get_table_data('tbl_sub_packages', '*', array('status' => 'Active', 'sub_package_id' => $sub_package_id), $row = 1);


        $total_likes = $sub_package_detail[0]['likes'];
        $total_views = $sub_package_detail[0]['views'];
        $total_comments = $sub_package_detail[0]['comments'];


        $order_id = $this->input->post('order_id');
        $post_no = $this->input->post('post_no');

        $likes = $this->input->post('likes');
        $views = $this->input->post('views');
        $count_comments = count($this->input->post('comment_list'));
        $comments_type = $this->input->post('comments_type');


        if ($comments_type == 'custom_comments') {
            $comments_value = $this->input->post('comment_list');
            foreach ($comments_value as $commentsValue) {
                $comments_post[] = $commentsValue;
            }
            $comments_list = implode('<br/>', $comments_post);
        } else {
            $comment_qry = $this->common_model->get_table_data('tbl_comments', '*', array('user_id' => null, 'comment_status' => 'active'), $order_by = 'rand()', '', '', $count_comments);
            $arr = array();
            foreach ($comment_qry as $comments) {
                $arr[] = $comments['comment_description'];
            }
            $comments_list = implode('<br/>', $arr);
        }


        $service_ids = $this->common_model->get_table_data('tbl_api_setup', '*', 'api_id=1', $row = 1);

        $likes_min = $service_ids[0]['likes_min'];
        $likes_max = $service_ids[0]['likes_max'];
        $views_min = $service_ids[0]['views_min'];
        $views_max = $service_ids[0]['views_max'];
        $comments_min = $service_ids[0]['comments_min'];
        $comments_max = $service_ids[0]['comments_max'];


        $sum_qry = $this->common_model->get_table_data('tbl_posts', 'SUM(post_likes) AS post_likes, SUM(post_views) AS post_views, SUM(post_comments) AS post_comments, SUM(post_followers) AS post_followers ', array('tbl_order_id' => $order_id), $row = 1);

        $post_likes = $sum_qry[0]['post_likes'];
        $post_views = $sum_qry[0]['post_views'];
        $post_comments = $sum_qry[0]['post_comments'];

        // remaining package data

        $remaining_likes = $total_likes - $post_likes;
        $remaining_views = $total_views - $post_views;
        $remaining_comments = $total_comments - $post_comments;


        $get_order_details = $this->common_model->get_table_data('tbl_orders', '*', array('order_id' => $order_id));

        $dripfeed_runs = $get_order_details[0]['dripfeed_time'];
        $dripfeed_interval = $get_order_details[0]['dripfeed_minutes'];


        $dripfeed_likes = $likes / $dripfeed_runs;
        $dripfeed_views = $views / $dripfeed_runs;

        if ($get_order_details[0]['likes_type'] == 'dripfeed') {

            if (!empty($likes) && $dripfeed_likes < $likes_min) {
                $this->session->set_flashdata('error_message', 'Minimum Likes amount should be ' . $likes_min . ' × ' . $dripfeed_runs . ' ( Dripfeed Time ) ');
                redirect('dashboard/view_posts/' . $order_id);
            }

            if (!empty($views) && $dripfeed_views < $views_min) {
                $this->session->set_flashdata('error_message', 'Minimum Views amount should be ' . $views_min . ' × ' . $dripfeed_runs . ' ( Dripfeed Time ) ');
                redirect('dashboard/view_posts/' . $order_id);
            }

        }


        if (!empty($likes) && $likes < $likes_min) {
            $this->session->set_flashdata('error_message', 'Minimum Likes amount should be ' . $likes_min);
            redirect('dashboard/view_posts/' . $order_id);
        }

        if (!empty($views) && $views < $views_min) {
            $this->session->set_flashdata('error_message', 'Minimum Views amount should be ' . $views_min);
            redirect('dashboard/view_posts/' . $order_id);
        }


        if ($count_comments == 0) {
            $count_comments = null;
        }


        $update_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'tbl_order_id' => $order_id,
            'tbl_pkg_id' => $package_id,
            'tbl_subpkg_id' => $sub_package_id,
            'post_likes' => $likes,
            'post_views' => $views,
            'post_comments' => $count_comments,
            'comments_list' => $comments_list,
            'comments_type' => $comments_type,
        );

        //echo '<pre>'; print_r($update_data); echo '</pre>'; exit;

        if ($likes <= $total_likes && $views <= $total_views && $count_comments <= $total_comments) {
            //
            $this->common_model->update_table('tbl_posts', $update_data, array('tbl_order_id' => $order_id, 'post_no' => $post_no));
            $this->session->set_flashdata('success_message', 'Updated Successfully');
            redirect('dashboard/view_posts/' . $order_id);

        } else {
            $this->session->set_flashdata('error_message', 'You can not specify a value more than you have ordered.  Please adjust accordingly');
            redirect('dashboard/view_posts/' . $order_id);
        }


    }


}