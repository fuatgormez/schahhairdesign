<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_liste extends CI_Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_customer'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
    function show() {
        $sql = "SELECT * FROM tbl_customer ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_customer',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_customer',$data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_customer');
    }

    function get_data($id)
    {
        $sql = 'SELECT * FROM tbl_customer WHERE id = ?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function customer_check($name, $email, $phone)
    {
        $sql = 'SELECT * FROM tbl_customer WHERE customer_name = ? AND customer_email = ? AND customer_phone = ?';
        $query = $this->db->query($sql,array($name, $email, $phone));
        return $query->first_row();
    }
    
}