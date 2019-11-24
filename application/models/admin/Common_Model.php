<?php

class Common_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


//--- Get table data -----//
    public function get_table_data($table, $select, $where = NULL, $order = NULL, $row = 0)
    {
        $this->db->select($select);
        if ($where)
            $this->db->where($where);
        if ($order)
            $this->db->order_by($order);
        $query = $this->db->get($table);
        if ($row)
            return $query = $query->row_array();
        return $result = $query->result_array();
    }

    public function get_user_status($id)
    {
        $this->db->select('*');
        $this->db->from('user_status');
        $this->db->where('user_id', $id);
        $qry = $this->db->get()->result_array();
        return $qry;
    }


//------- Count Row -----------------

    public function count_rows($table, $where = NULL)
    {
        $this->db->select('*');
        if ($where)
            $this->db->where($where);
        $query = $this->db->get($table);
        return $query->num_rows();
    }

//--- Insert data into table ---//
    public function insert_table($table, $value)
    {

        $this->db->insert($table, $value);
        return $this->db->insert_id();
    }

//--- Update table ---//
    public function update_table($table, $set, $where)
    {
        $this->db->where($where);
        $query = $this->db->update($table, $set);
        if ($query)
            return 1;
        else
            return 0;
    }

//-- Delete data from table ----//
    public function delete_table($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function get_user_accounts() {

        $this->db->select('*,tbl_users.user_id as id');
        $this->db->from('tbl_users');
        $this->db->join('tbl_accounts','tbl_users.user_id = tbl_accounts.user_id', 'left');
        $array = array('tbl_users.status' => 'active', 'tbl_users.user_type !=' => 'admin');
        $this->db->where($array);
        $qry = $this->db->get()->result_array();
        //echo '<pre>'; print_r($qry); echo '</pre'; exit;
        return $qry;

    }

}