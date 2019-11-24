<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


    function __construct(){
        parent::__construct();

    }

    public function index()
    {
        $this->load->view('login/login');
    }

    public function signup()
    {
        $data = $this->session->set_flashdata('signup','1');
        $this->load->view('login/login', $data);
    }


    public function userlogin(){
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));

        if(!empty($email) && !empty($password)){
            $where = "email='$email' and password='$password' and status='Active'";
            $result = $this->common_model->get_table_data('tbl_users','*',$where,'',$row=1);
            $popup_msg_status = $result['popup_msg_status'];
            $user_id = $result['user_id'];
            if($result){
                $data = array(
                    'user_id'=> $result['user_id'],
                    'username'=>$result['username'],
                    'email'=>$result['email'],
                    'user_type'=>$result['user_type'],
                    'status'=>$result['status'],
                    'ref_by'=>$result['ref_by'],
                    'created_date'=>$result['created_date']
                );
                $this->session->set_userdata($data);
                if($popup_msg_status == 1) {
                    $this->session->set_userdata(array('welcome_message' => true));
                    $this->common_model->update_table('tbl_users',array('popup_msg_status' => 0),array('user_id' => $user_id));
                }
                redirect('dashboard');
            }else{
                $this->session->set_flashdata('error_message', 'Invalid Username or Password');
                redirect('login');
            }
        }else{
            $this->session->set_flashdata('error_message', 'Invalid Username or Password');
            redirect('login');
        }
    }






    public function register() {
        $email = $this->input->post('reg_email');
        $username = $this->input->post('reg_username');
        $password = md5($this->input->post('reg_password'));
        $confirm_password = md5($this->input->post('reg_confirm_password'));
        $ref_id = $this->input->post('ref_id');

        if(!empty($email) && !empty($username) && !empty($password)){
            $where = "username='$username'";
            $result = $this->common_model->get_table_data('tbl_users','*',$where,'',$row=1);
            if(count($result) < 1) {
                $data = array(
                    'username'=> $this->input->post('reg_username'),
                    'email'=> $this->input->post('reg_email'),
                    'password'=> $password,
                    'confirm_password'=> $confirm_password,
                    'user_type'=> 'customer',
                    'status'=> 'Active',
                    'created_date'=> date('Y-m-d H:i:s')
                );


                 $result = $this->common_model->insert_table('tbl_users',$data);


                $account_data = array(
                    'user_id' => $result,
                    'referral' => '20',
                    'created_date' => date('Y-m-d H:i:s')
                );
                 $this->common_model->insert_table('tbl_accounts',$account_data);

                $replace_username = str_replace(' ', '.',$username);
                $referral_link_rem = str_replace('/register', '' , current_url()).'?ref='.time().'-'.$result;
                $referral_link = str_replace('index.php/', '' , $referral_link_rem);

                $this->common_model->update_table('tbl_users',array('referral_link' => $referral_link, 'ref_by' => $ref_id), array('user_id' => $result));

                if(!empty($ref_id)) {

                    $qry = $this->common_model->get_table_data('tbl_users','*',array('user_id' => $ref_id));
                    $ref_count = $qry[0]['total_ref'];
                     $this->common_model->update_table('tbl_users',array('total_ref' => $ref_count + 1), array('user_id' => $ref_id));
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


                                                                        <span style="text-align: left"><b>Hi, ('.ucfirst($username).') </b></span><br>

                                                                        <p>
                                                                        Thank you for registering your account on Social Media Gainer.  We want to personally welcome you to our journey in building the number one Instagram platform on the market.  We hope you enjoy what we have to offer, as I already know it will be amazing!
                                                                        </p>
                                                                        
                                                                        <p>
                                                                        If you have any questions, feel free to contact us at: <a href="mailto:TheSMGainer@gmail.com" style="color: #ffffff"> TheSMGainer@gmail.com </a> 
                                                                        </p>
                                                                        
                                                                        <p>
                                                                        Click the button below to login and start your journey in skyrocketing your Instagram page!
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
</html>';



$email_qry = $this->smtp_email->send('no-reply@socialmediagainer.com', 'Social Media Gainer', $email, 'Successful Registration', $email_msg);


               // echo $email_qry;

                //exit('exitttttt');
                $this->session->set_flashdata('success_message', 'Your account has been created successfully!');
                redirect('login');

            } else {
                $this->session->set_flashdata('error_message', 'Username Already Exist');
                redirect('login');
            }
        }else{
            $this->session->set_flashdata('error_message', 'Invalid Username or Password');
            redirect('login');
        }
    }








    public function forgot_password() {

        $email = $this->input->post('email');
        $check_email = $this->common_model->get_table_data('tbl_users','*',array('email' => $email));
        if(count($check_email) >= 1) {

            $username = $check_email[0]['username'];





            $password =  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8/strlen($x)) )),1,8);
            $this->common_model->update_table('tbl_users', array('password' => md5($password), 'confirm_password' => md5($password)), array('email' => $email));

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


                                                                        <span style="text-align: left"><b>Hi, ('.ucfirst($username).') </b></span><br>

                                                                        <p>
                                                                        Looks like you have forgotten the password to your account.  Use this as your new password:  <span style="color: #f5bc02; font-weight: bold"> '.$password.'</span>
                                                                        </p>
                                                                        
                                                                        <p>
                                                                        If you want to change the password please redirect to the manage account section after signing in using above password.
                                                                        </p>
                                                                        
                                                                        
                                                                        <p>
                                                                        If you have any questions, feel free to contact us at: <a href="mailto:TheSMGainer@gmail.com" style="color: #ffffff"> TheSMGainer@gmail.com </a> 
                                                                        </p>
                                                                        
                                                                        <p>
                                                                        Click the button below to login using your new generated password!
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

            $this->smtp_email->send('no-reply@socialmediagainer.com', 'Social Media Gainer', $email, 'Forgot Password', $email_msg);
            $this->session->set_flashdata('success_message','Please check your email, as it contains your new generated password.');
            redirect('login');



        } else {
            $this->session->set_flashdata('error_message', 'This Email is not exist');
            redirect('login');
        }


    }

    public function update_password() {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $confirm_password = md5($this->input->post('confirm_password'));

        $update_data = array(
            'password'=> $password,
            'confirm_password'=> $confirm_password,
        );

        if($password == $confirm_password) {
            $this->common_model->update_table('tbl_users',$update_data, array('email' => $email));

            $this->session->set_flashdata('success_message', 'Your Password is Updated Successfully');
            redirect('login');
        } else {
            $this->session->set_flashdata('error_message', 'Confirm Passsword is not same');
            redirect('login');
        }



    }




}