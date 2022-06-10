<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_liste extends CI_Model 
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_buchhaltung'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
    function day($date) {
        $sql = "SELECT * FROM tbl_buchhaltung WHERE date = ? ORDER BY id ASC";
        $query = $this->db->query($sql,$date);
        return $query->result_array();
    }
    
    function month($month) {
        $sql = "SELECT * FROM tbl_buchhaltung WHERE month = ? ORDER BY id ASC";
        $query = $this->db->query($sql,$month);
        return $query->result_array();
    }

    function add($data) {
        $this->db->insert('tbl_buchhaltung',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_buchhaltung',$data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tbl_buchhaltung');
    }

    function get_data($id)
    {
        $sql = 'SELECT * FROM tbl_buchhaltung WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    function date_check($date)
    {
        $sql = 'SELECT * FROM tbl_buchhaltung WHERE date=?';
        $query = $this->db->query($sql,array($date));
        return $query->first_row();
    }
    
}