<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user extends CI_Model 
{

    function get_all_user() {
        $sql = "SELECT * FROM tbl_user";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_user_data ($id)
    {
        $sql = "SELECT * FROm tbl_user WHERE id = ?";
        $query = $this->db->query($sql,$id);
        return $query->first_row();
    }

    function user_check($id)
    {
        $sql = 'SELECT id FROM tbl_user WHERE id=?';
        $query = $this->db->query($sql,$id);
        return $query->first_row();
    }
    
}