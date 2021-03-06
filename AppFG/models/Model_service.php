<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_service extends CI_Model 
{
    public function all_service()
    {
        $query = $this->db->query("SELECT * FROM tbl_service ORDER BY row ASC");
        return $query->result_array();
    }

    public function service_check($id) {
        $sql = 'SELECT * FROM tbl_service WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->num_rows();
    }

    public function service_detail($id) {
        $sql = 'SELECT * FROM tbl_service WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    public function get_service_photo($id)
    {
        $query = $this->db->query("SELECT * from tbl_service_photo WHERE service_id=?",array($id));
        return $query->result_array();
    }
    public function get_service_photo_number($id)
    {
        $query = $this->db->query("SELECT * from tbl_service_photo WHERE service_id=?",array($id));
        return $query->num_rows();
    }

}