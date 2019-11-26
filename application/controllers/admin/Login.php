<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('admin/common/header');
        $this->load->view('admin/login/login');
    }


    public function userlogin(){
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        if(!empty($username) && !empty($password)){
            $where = " username='$username' and password='$password'";
            $result = $this->common_model->get_table_data('tbl_users','*',$where,'',$row=1);
            //echo '<pre>'; print_r($result); echo '</pre>'; exit;
            if($result){
                    $data = array(
                        'user_id'=> $result['user_id'],
                        'session_id '=> $result['session_id'],
                        'username'=>$result['username'],
                        'email'=>$result['email'],
                        'user_type'=>$result['user_type'],
                        'status'=>$result['status'],
                        'created_date'=>$result['created_date']
                    );
                    $this->session->set_userdata($data);
                    redirect('admin/dashboard');
            }else{
                $this->session->set_flashdata('message_name', 'Invalid Username or Password');
                redirect('admin/login');
            }

        }else{
            $this->session->set_flashdata('message_name', 'Invalid Username or Password');
            redirect('admin/login');
        }

    }

}