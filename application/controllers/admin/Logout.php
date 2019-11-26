<?php
defined('BASEPATH') OR die("Direct access is not allowed");

class Logout extends CI_Controller {

   public function index() {
       is_admin_in();
       $this->session->unset_userdata('user_id');
       $this->session->unset_userdata('session_id');
       $this->session->unset_userdata('username');
       $this->session->unset_userdata('email');
       $this->session->unset_userdata('user_type');
       $this->session->unset_userdata('status');
       $this->session->unset_userdata('created_date');

       $data = array('user_id' => '', 'session_id' => '', 'username' => '', 'email' => '', 'user_type' => '', 'status' => '', 'created_date' => '');
       $this->session->unset_userdata($data);

       redirect(base_url().'/admin/', 'refresh');
   }
}