<?php


class Common_Model extends CI_Model
{
    //--- Get table data -----//
    public function get_table_data($table, $select, $where = NULL, $order = NULL, $row = 0, $group_by = NULL, $limit = null) {
        $this->db->select($select);
        if ($where) $this->db->where($where);
        if ($order) $this->db->order_by($order);
        if ($group_by) $this->db->group_by($group_by);
        if ($limit) $this->db->limit($limit);
        $query = $this->db->get($table);
        if ($row) return $query = $query->row_array();
        return $result = $query->result_array();
    }


    public function get_user_status($id) {
        $this->db->select('*');
        $this->db->from('user_status');
        $this->db->where('user_id', $id);
        $qry = $this->db->get()->result_array();
        return $qry;
    }


    //------- Count Row -----------------
    public function count_rows($table, $where = NULL) {
        $this->db->select('*');
        if ($where) $this->db->where($where);
        $query = $this->db->get($table);
        return $query->num_rows();
    }


    //--- Insert data into table ---//
    public function insert_table($table, $value) {
        $this->db->insert($table, $value);
        return $this->db->insert_id();
    }


    //--- Update table ---//
    public function update_table($table, $set, $where, $limit = null) {
        $this->db->where($where);
        $query = $this->db->update($table, $set);
        if ($limit) $this->db->limit($limit);
        if ($query) return 1;
        else
            return 0;
    }


    //-- Delete data from table ----//
    public function delete_table($table, $where) {
        $this->db->where($where);
        $this->db->delete($table);
    }


    public function get_user_accounts() {
        $this->db->select('*,tbl_users.user_id as id');
        $this->db->from('tbl_users');
        $this->db->join('tbl_accounts', 'tbl_users.user_id = tbl_accounts.user_id', 'left');
        $array = array('tbl_users.user_type !=' => 'admin');
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function get_sub_packages() {
        $this->db->select('*');
        $this->db->from('tbl_packages');
        $this->db->join('tbl_sub_packages', 'tbl_packages.package_id = tbl_sub_packages.tbl_package_id');
        $array = array('tbl_sub_packages.status' => 'active');
        $this->db->where($array);
        $this->db->order_by('package_name ASC');
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre'; exit;
        return $qry;
    }


    public function get_sub_package($sub_package_id) {
        $this->db->select('*');
        $this->db->from('tbl_packages');
        $this->db->join('tbl_sub_packages', 'tbl_packages.package_id = tbl_sub_packages.tbl_package_id');
        $array = array('tbl_sub_packages.status' => 'active', 'tbl_sub_packages.sub_package_id' => $sub_package_id);
        $this->db->where($array);
        $this->db->order_by('price ASC');
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre'; exit;
        return $qry;
    }


    public function sub_packages_list($package_id) {
        $this->db->select('*');
        $this->db->from('tbl_packages');
        $this->db->join('tbl_sub_packages', 'tbl_packages.package_id = tbl_sub_packages.tbl_package_id');
        $array = array('tbl_sub_packages.status' => 'active', 'package_id' => $package_id);
        $this->db->where($array);
        $this->db->order_by('price ASC');
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre'; exit;
        return $qry;
    }


    public function special_id_package($package_id, $special_id) {
        $this->db->select('*');
        $this->db->from('tbl_packages');
        $this->db->join('tbl_sub_packages', 'tbl_packages.package_id = tbl_sub_packages.tbl_package_id');
        $array = array('tbl_sub_packages.status' => 'active', 'tbl_sub_packages.special_id' => $special_id, 'package_id' => $package_id);
        $this->db->where($array);
        $this->db->order_by('package_name ASC');
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre'; exit;
        return $qry;
    }


    public function get_insta_users() {
        $this->db->select('*,tbl_users.user_id as id');
        $this->db->from('tbl_users');
        $this->db->join('tbl_orders', 'tbl_users.user_id = tbl_orders.user_id', 'left');
        $array = array('tbl_users.user_type !=' => 'admin', 'tbl_orders.payment_status' => 'Completed', 'tbl_orders.user_id' => $this->session->userdata('user_id'), 
                        'tbl_orders.txn_type' => 'package order', 'tbl_orders.order_status' => 'Pending');
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function get_insta_account($order_id) {
        $this->db->select('*,tbl_users.user_id as id');
        $this->db->from('tbl_users');
        $this->db->join('tbl_orders', 'tbl_users.user_id = tbl_orders.user_id', 'left');
        $array = array('tbl_users.user_type !=' => 'admin', 'tbl_orders.payment_status' => 'Completed', 'tbl_orders.user_id' => $this->session->userdata('user_id'), 'tbl_orders.txn_type' => 'package order', 'tbl_orders.order_id' => $order_id);
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function get_users_data() {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->join('tbl_orders', 'tbl_users.user_id = tbl_orders.user_id', 'left');
        $this->db->join('tbl_posts', 'tbl_orders.order_id = tbl_posts.tbl_order_id', 'left');
        $array = array('tbl_users.user_type !=' => 'admin', 'tbl_orders.payment_status' => 'Completed', 'tbl_orders.txn_type' => 'package order', 'tbl_orders.order_status' => 'Pending', 'tbl_orders.package_status' => 'active', 'tbl_posts.post_code !=' => null, 'tbl_posts.post_status' => 'Featured');
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function get_featured_orders() {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->join('tbl_orders', 'tbl_users.user_id = tbl_orders.user_id', 'left');
        $array = array('tbl_users.user_type !=' => 'admin', 'tbl_orders.payment_status' => 'Completed', 'tbl_orders.txn_type' => 'package order', 'tbl_orders.order_status' => 'Pending', 'tbl_orders.package_status' => 'active');
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function get_featured_posts($order_id) {
        $this->db->select('*');
        $this->db->from('tbl_posts');
        $array = array('tbl_posts.tbl_order_id' => $order_id);
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function get_custom_orders() {
        $currDate = date('Y-m-d H:i:s');
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->join('tbl_custom_orders', 'tbl_users.user_id = tbl_custom_orders.user_id', 'left');
        $array = array('tbl_users.user_type !=' => 'admin', 'tbl_custom_orders.payment_status' => 'Completed', 'tbl_custom_orders.order_status' => 'Pending');
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function get_oneTime_orders() {
        $this->db->select('*');
        $this->db->from('tbl_custom_orders');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_custom_orders.user_id');
        $this->db->order_by('order_id DESC');
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function custom_orders_analytics() {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->join('tbl_custom_orders', 'tbl_users.user_id = tbl_custom_orders.user_id', 'left');
        $this->db->join('tbl_custompackage_status', 'tbl_custom_orders.order_id = tbl_custompackage_status.tbl_customorder_id', 'left');
        $this->db->join('tbl_orders', 'tbl_users.user_id = tbl_orders.user_id', 'left');
        $this->db->join('tbl_package_status', 'tbl_orders.order_id = tbl_package_status.tbl_order_id', 'left');
        $array = array('tbl_users.user_type !=' => 'admin', 'tbl_orders.user_id' => $this->session->userdata('user_id'));
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function pkg_orders_analytics() {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->join('tbl_orders', 'tbl_users.user_id = tbl_orders.user_id', 'left');
        $this->db->join('tbl_package_status', 'tbl_orders.order_id = tbl_package_status.tbl_order_id', 'left');
        $array = array('tbl_users.user_type !=' => 'admin', 'tbl_orders.payment_status' => 'Completed', 'tbl_orders.txn_type' => 'package order', 'tbl_orders.order_status' => 'Done', 'tbl_orders.user_id' => $this->session->userdata('user_id'));
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre>'; exit;
        return $qry;
    }


    public function get_money_spent($user_id) {
        $qry = $this->db->query("SELECT SUM(t.payment_amount) AS total_amount
    FROM (SELECT payment_amount FROM tbl_orders WHERE tbl_orders.user_id = '$user_id'
    UNION ALL
    SELECT payment_amount FROM tbl_custom_orders WHERE tbl_custom_orders.user_id = '$user_id') t")->result_array();
        return $qry;
    }


    public function total_money_spent() {
        $qry = $this->db->query("SELECT SUM(t.payment_amount) AS total_amount
    FROM (SELECT payment_amount FROM tbl_orders
    UNION ALL
    SELECT payment_amount FROM tbl_custom_orders) t")->result_array();
        return $qry;
    }
}