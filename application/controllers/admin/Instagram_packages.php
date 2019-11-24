<?php
/**
 * Created by PhpStorm.
 * User: Social Meida Gainer
 * Date: 1/30/2018
 * Time: 12:00 PM
 */

class Instagram_Packages extends CI_Controller {

    public function index() {

        is_admin_in();
        $this->load->view('admin/common/header');
        $this->load->view('admin/common/sidebar');

        $data['packages_list'] = $this->common_model->get_table_data('tbl_packages','*',array('package_status'=> 'Active'));

        $this->load->view('admin/packages/instagram_packages', $data);
        $this->load->view('admin/common/footer');
    }


}