<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smtp_email{



     public function send($from,$name,$toEmail,$subject,$msg){

        $config = array (
            'mailtype' => 'html',
            'charset'  => 'utf-8',
            'priority' => '1'
        );
        $ci =& get_instance();
        $ci->load->library('email');
      	$ci->email->initialize($config);
		$ci->email->set_newline("\r\n");
		$ci->email->from($from,$name);
		$ci->email->to($toEmail);//to address here
		$ci->email->subject($subject);
        $ci->email->message($msg);
		if($ci->email->send())
			return true;
		else
		    return false;
	}
    public function send_attach_mail($from,$name,$toEmail,$subject,$msg,$filename)
    {
        $config = array (
             'mailtype' => 'html',
             'charset'  => 'utf-8',
             'priority' => '1'
              );

        $ci =& get_instance();
        $ci->load->library('email');
      	$ci->email->initialize($config);
		$ci->email->set_newline("\r\n");
		$ci->email->from($from,$name);
		$ci->email->to($toEmail);//to address here
		$ci->email->subject($subject);
        $ci->email->message($msg);
        $ci->email->attach($filename);
		if($ci->email->send())
			return true;
		else
		    show_error($ci->email->print_debugger());
    }
}