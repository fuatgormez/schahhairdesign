<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_covid_test_form extends CI_Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_schnell_test_form'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
    function show() {
        $sql = "SELECT * FROM tbl_schnell_test_form ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_schnell_test_form',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_schnell_test_form',$data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_schnell_test_form');
    }

    function get_covid_test_form($code)
    {
        $sql = 'SELECT * FROM tbl_schnell_test_form WHERE code=?';
        $query = $this->db->query($sql,array($code));
        return $query->first_row('array');
    }

    function covid_test_form_check($id)
    {
        $sql = 'SELECT * FROM tbl_schnell_test_form WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }
    
}