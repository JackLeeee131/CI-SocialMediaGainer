<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('welcome/welcome');
    }

    public function terms()
    {
        $this->load->view('welcome/terms');
    }

    public function contact() {

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $message = $this->input->post('message');

        if (!empty($email) && !(empty($message))) {
            $data = array(
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'contact_date' => date('Y-m-d H:i:s')
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
                                                                                ' . ucfirst($name) . ' ( ' .ucfirst($email). ') has contacted us through the SocialMediaGainer contact us page, Below you can find his query in detail.
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
                                                            <td valign="top" width="500" class="flexibleContainerCell" style="font-size: 15px;">

                                                                    <p>' . $message . '</p>
                                                                    


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

            $email_qry = $this->smtp_email->send($email, $name, 'thesmgainer@gmail.com', 'SocialMediaGainer Contact us', $email_msg);

            // echo '<pre>'; print_r($email_qry); echo '</pre>'; exit;

            $email_msg_user = '
                
                <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                        <meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
                        <title>Email</title>
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



                                                                                    <span style="text-align: left"><b>Hi, (' . ucfirst($name) . ') </b></span><br>

                                                                                <p>
                                                                                Thank you for contacting us, We will get you back soon!
                                                                                </p>
                                                                                
                                                                                <p>
                                                                                If you have any questions, feel free to contact us at: <a href="mailto:TheSMGainer@gmail.com" style="color: #ffffff"> TheSMGainer@gmail.com </a> 
                                                                                </p>
                                                                                
                                                                                <p>
                                                                                Click the button below to check F.A.Q, For common queries !
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
                                                                            <a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%;" href="http://webhorde.com/socialmediagainer/settings/faq" target="_blank">F.A.Q</a>
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

            $email_qry_user = $this->smtp_email->send('no-reply@socialmediagainer.com', 'Social Media Gainer', $email, 'SocialMediaGainer Contact us', $email_msg_user);

            $this->common_model->insert_table('tbl_contacts', $data);
            //$this->session->set_flashdata('success_message', 'Thank you for contacting us, We will get you back soon ');
            redirect('welcome');
        } else {
            $this->session->set_flashdata('error_message', 'Email and Message fields cannot be empty');
            redirect('welcome');
        }

    }

}